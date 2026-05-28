<?php

namespace App\Http\Controllers;

use App\Models\AbuseType;
use App\Models\District;
use App\Models\Province;
use App\Models\Report;
use App\Models\School;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NationalHeatmapController extends Controller
{
    /**
     * Tertile cutoffs so low / medium / high colors all appear when counts vary.
     *
     * @return array{0: int, 1: int} [lowMax, mediumMax] — count <= lowMax → low band, etc.
     */
    protected function heatBandThresholds(array $counts): array
    {
        $positive = array_values(array_filter(
            array_map(fn ($c) => (int) $c, $counts),
            fn ($c) => $c > 0
        ));
        sort($positive);
        $n = count($positive);

        if ($n === 0) {
            return [0, 0];
        }
        if ($n === 1) {
            return [0, $positive[0]];
        }

        $iLow = max(0, (int) floor($n / 3) - 1);
        $iMed = max($iLow, (int) floor((2 * $n) / 3) - 1);

        return [$positive[$iLow], $positive[$iMed]];
    }

    protected function heatBandIndex(int $count, int $lowMax, int $mediumMax): int
    {
        if ($count <= 0) {
            return 0;
        }
        if ($count <= $lowMax) {
            return 0;
        }
        if ($count <= $mediumMax) {
            return 1;
        }

        return 2;
    }

    /**
     * Apply the same GET filters used on the national dashboard / reports list.
     */
    protected function applyHeatmapFilters(Builder $query, Request $request): void
    {
        if ($request->filled('province')) {
            $query->where('province_id', $request->input('province'));
        }
        if ($request->filled('province') && $request->filled('district')) {
            $query->where('district_id', $request->input('district'));
        }
        if ($request->filled('province') && $request->filled('district') && $request->filled('school')) {
            $query->where('school_id', $request->input('school'));
        }
        if ($request->filled('abuse_type')) {
            $query->where('abuse_type_id', $request->input('abuse_type'));
        }

        $ageRange = $request->input('age_range');
        if ($ageRange) {
            if ($ageRange === '30+') {
                $query->where('age', '>=', 30);
            } elseif (strpos((string) $ageRange, '-') !== false) {
                [$minAge, $maxAge] = explode('-', $ageRange, 2);
                if (is_numeric($minAge) && is_numeric($maxAge)) {
                    $query->whereBetween('age', [(int) $minAge, (int) $maxAge]);
                }
            }
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->input('from_date'));
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->input('to_date'));
        }
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user || ! in_array((string) $user->role, ['national', 'admin'], true)) {
            abort(403, 'Unauthorized');
        }

        $provinceFilter = $request->input('province');
        $districtFilter = $request->input('district');
        $schoolFilter = $request->input('school');
        $abuseTypeFilter = $request->input('abuse_type');
        $ageRange = $request->input('age_range');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        $provinces = Province::orderBy('province_name')
            ->get(['province_id as id', 'province_name as name']);

        $districts = $provinceFilter
            ? District::where('province_id', $provinceFilter)
                ->orderBy('district_name')
                ->get(['district_id as id', 'district_name as name'])
            : collect();

        $schools = ($districtFilter && $provinceFilter)
            ? School::where('district_id', $districtFilter)
                ->orderBy('school_name')
                ->get(['school_id', 'school_name'])
            : collect();

        $abuseTypes = AbuseType::orderBy('type_name')->get();
        $abuseTypeIds = $abuseTypes->pluck('id')->all();

        $baseQuery = Report::query();
        $this->applyHeatmapFilters($baseQuery, $request);

        $activeFilters = [];
        if ($provinceFilter) {
            $n = $provinces->firstWhere('id', $provinceFilter)?->name;
            if ($n) {
                $activeFilters[] = $n;
            }
        }
        if ($provinceFilter && $districtFilter) {
            $n = $districts->firstWhere('id', $districtFilter)?->name;
            if ($n) {
                $activeFilters[] = $n;
            }
        }
        if ($provinceFilter && $districtFilter && $schoolFilter) {
            $n = $schools->firstWhere('school_id', $schoolFilter)?->school_name;
            if ($n) {
                $activeFilters[] = $n;
            }
        }
        if ($abuseTypeFilter) {
            $n = $abuseTypes->firstWhere('id', $abuseTypeFilter)?->type_name;
            if ($n) {
                $activeFilters[] = $n;
            }
        }
        if ($ageRange) {
            $activeFilters[] = 'Age: ' . $ageRange;
        }
        if ($fromDate) {
            $activeFilters[] = 'From: ' . $fromDate;
        }
        if ($toDate) {
            $activeFilters[] = 'To: ' . $toDate;
        }

        /* Province × abuse type (same cell semantics as provincial district × type) */
        $provinceHeatmapAbuseTypes = $abuseTypes->pluck('type_name')->toArray();

        $provinceTypeCounts = (clone $baseQuery)
            ->select('province_id', 'abuse_type_id', DB::raw('COUNT(*) as count'))
            ->whereNotNull('province_id')
            ->whereNotNull('abuse_type_id')
            ->groupBy('province_id', 'abuse_type_id')
            ->get();

        $provinceTypeLookup = [];
        foreach ($provinceTypeCounts as $row) {
            $provinceTypeLookup[(int) $row->province_id][(int) $row->abuse_type_id] = (int) $row->count;
        }

        $provinceHeatmapMatrix = [];
        foreach ($provinces as $province) {
            $row = [];
            foreach ($abuseTypeIds as $abuseTypeId) {
                $row[] = $provinceTypeLookup[(int) $province->id][(int) $abuseTypeId] ?? 0;
            }
            $provinceHeatmapMatrix[$province->name] = $row;
        }

        uasort($provinceHeatmapMatrix, fn ($a, $b) => array_sum($b) <=> array_sum($a));

        $provinceHeatmapRowTotals = [];
        $provinceHeatmapColumnTotals = array_fill(0, count($provinceHeatmapAbuseTypes), 0);
        foreach ($provinceHeatmapMatrix as $pName => $row) {
            $provinceHeatmapRowTotals[$pName] = array_sum($row);
            foreach ($row as $i => $count) {
                $provinceHeatmapColumnTotals[$i] += $count;
            }
        }

        $provinceHeatmapGrandTotal = array_sum($provinceHeatmapColumnTotals);
        $provinceHeatmapMax = collect($provinceHeatmapMatrix)->flatten()->max() ?: 1;

        $matrixCounts = collect($provinceHeatmapMatrix)->flatten()->map(fn ($c) => (int) $c)->all();
        [$provinceHeatmapBandLowMax, $provinceHeatmapBandMediumMax] = $this->heatBandThresholds($matrixCounts);

        $provinceHeatmapProvinceNameToId = $provinces->pluck('id', 'name')->toArray();
        $provinceHeatmapAbuseTypeNameToId = $abuseTypes->pluck('id', 'type_name')->toArray();

        $provinceHeatmapPercentages = [];
        foreach ($provinceHeatmapMatrix as $pName => $row) {
            $rowTotal = $provinceHeatmapRowTotals[$pName] ?? 0;
            $provinceHeatmapPercentages[$pName] = array_map(
                fn ($c) => $rowTotal > 0 ? round($c / $rowTotal * 100, 1) : 0,
                $row
            );
        }

        $provinceHeatmapHotspots = [];
        foreach ($provinceHeatmapMatrix as $pName => $row) {
            $withIndex = array_map(fn ($c, $i) => ['count' => $c, 'idx' => $i], $row, array_keys($row));
            usort($withIndex, fn ($a, $b) => $b['count'] <=> $a['count']);
            $provinceHeatmapHotspots[$pName] = array_column(array_slice($withIndex, 0, 3), 'idx');
        }

        /* District counts for national geographic map (per-province geojson files) */
        $allDistricts = District::orderBy('district_name')
            ->get(['district_id as id', 'district_name as name']);

        $districtTotals = (clone $baseQuery)
            ->select('district_id', DB::raw('COUNT(*) as count'))
            ->whereNotNull('district_id')
            ->groupBy('district_id')
            ->get()
            ->keyBy('district_id');

        $mapDistrictCounts = [];
        foreach ($allDistricts as $district) {
            $mapDistrictCounts[$district->name] = (int) ($districtTotals[$district->id]->count ?? 0);
        }

        $mapDistrictMax = collect($mapDistrictCounts)->max() ?: 1;
        $mapDistrictNameToId = $allDistricts->pluck('id', 'name')->toArray();
        [$mapDistrictBandLowMax, $mapDistrictBandMediumMax] = $this->heatBandThresholds(array_values($mapDistrictCounts));

        return view('national-admin-dashboard.heatmap', [
            'provinces' => $provinces,
            'districts' => $districts,
            'schools' => $schools,
            'abuseTypes' => $abuseTypes,
            'provinceFilter' => $provinceFilter,
            'districtFilter' => $districtFilter,
            'schoolFilter' => $schoolFilter,
            'abuseTypeFilter' => $abuseTypeFilter,
            'ageRange' => $ageRange,
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'activeFilters' => $activeFilters,

            'provinceHeatmapAbuseTypes' => $provinceHeatmapAbuseTypes,
            'provinceHeatmapMatrix' => $provinceHeatmapMatrix,
            'provinceHeatmapMax' => $provinceHeatmapMax,
            'provinceHeatmapBandLowMax' => $provinceHeatmapBandLowMax,
            'provinceHeatmapBandMediumMax' => $provinceHeatmapBandMediumMax,
            'provinceHeatmapRowTotals' => $provinceHeatmapRowTotals,
            'provinceHeatmapColumnTotals' => $provinceHeatmapColumnTotals,
            'provinceHeatmapGrandTotal' => $provinceHeatmapGrandTotal,
            'provinceHeatmapProvinceNameToId' => $provinceHeatmapProvinceNameToId,
            'provinceHeatmapAbuseTypeNameToId' => $provinceHeatmapAbuseTypeNameToId,
            'provinceHeatmapPercentages' => $provinceHeatmapPercentages,
            'provinceHeatmapHotspots' => $provinceHeatmapHotspots,

            'mapDistrictCounts' => $mapDistrictCounts,
            'mapDistrictMax' => $mapDistrictMax,
            'mapDistrictBandLowMax' => $mapDistrictBandLowMax,
            'mapDistrictBandMediumMax' => $mapDistrictBandMediumMax,
            'mapDistrictNameToId' => $mapDistrictNameToId,
        ]);
    }
}
