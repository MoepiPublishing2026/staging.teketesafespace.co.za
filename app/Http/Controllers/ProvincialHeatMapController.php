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

class ProvincialHeatMapController extends Controller
{
    protected function applyHeatmapFilters(Builder $query, Request $request, int $provinceId): void
    {
        $query->where('province_id', $provinceId);

        if ($request->filled('district')) {
            $query->where('district_id', $request->input('district'));
        }
        if ($request->filled('district') && $request->filled('school')) {
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
                [$minAge, $maxAge] = explode('-', (string) $ageRange, 2);
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

        if (!$user || $user->role !== 'provincial') {
            abort(403, 'Unauthorized');
        }

        $provinceId = (int) $user->province_id;
        $province = Province::find($provinceId);

        if (!$province) {
            abort(404, 'Province not found');
        }

        $districtFilter = $request->input('district');
        $schoolFilter = $request->input('school');
        $abuseTypeFilter = $request->input('abuse_type');
        $ageRange = $request->input('age_range');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        $districts = District::where('province_id', $provinceId)
            ->orderBy('district_name')
            ->get(['district_id as id', 'district_name as name']);

        $schools = $districtFilter
            ? School::where('district_id', $districtFilter)
                ->where('province_id', $provinceId)
                ->orderBy('school_name')
                ->get(['school_id', 'school_name'])
            : collect();

        $abuseTypes = AbuseType::orderBy('type_name')->get();
        $abuseTypeIds = $abuseTypes->pluck('id')->all();

        $baseQuery = Report::query();
        $this->applyHeatmapFilters($baseQuery, $request, $provinceId);

        $activeFilters = [];
        if ($districtFilter) {
            $n = $districts->firstWhere('id', $districtFilter)?->name;
            if ($n) {
                $activeFilters[] = $n;
            }
        }
        if ($districtFilter && $schoolFilter) {
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

        $heatmapAbuseTypes = $abuseTypes->pluck('type_name')->toArray();

        $districtTypeCounts = (clone $baseQuery)
            ->select('district_id', 'abuse_type_id', DB::raw('COUNT(*) as count'))
            ->whereNotNull('district_id')
            ->whereNotNull('abuse_type_id')
            ->groupBy('district_id', 'abuse_type_id')
            ->get();

        $districtTypeLookup = [];
        foreach ($districtTypeCounts as $row) {
            $districtTypeLookup[(int) $row->district_id][(int) $row->abuse_type_id] = (int) $row->count;
        }

        $heatmapMatrix = [];
        foreach ($districts as $district) {
            $row = [];
            foreach ($abuseTypeIds as $abuseTypeId) {
                $row[] = $districtTypeLookup[(int) $district->id][(int) $abuseTypeId] ?? 0;
            }
            $heatmapMatrix[$district->name] = $row;
        }

        uasort($heatmapMatrix, fn ($a, $b) => array_sum($b) <=> array_sum($a));

        $heatmapRowTotals = [];
        $heatmapColumnTotals = array_fill(0, count($heatmapAbuseTypes), 0);
        foreach ($heatmapMatrix as $districtName => $row) {
            $heatmapRowTotals[$districtName] = array_sum($row);
            foreach ($row as $i => $count) {
                $heatmapColumnTotals[$i] += $count;
            }
        }

        $heatmapGrandTotal = array_sum($heatmapColumnTotals);
        $heatmapMax = collect($heatmapMatrix)->flatten()->max() ?: 1;
        $districtsWithReports = collect($heatmapRowTotals)->filter(fn ($c) => $c > 0)->count();

        $heatmapDistrictNameToId = $districts->pluck('id', 'name')->toArray();
        $heatmapAbuseTypeNameToId = $abuseTypes->pluck('id', 'type_name')->toArray();

        $heatmapPercentages = [];
        foreach ($heatmapMatrix as $districtName => $row) {
            $rowTotal = $heatmapRowTotals[$districtName] ?? 0;
            $heatmapPercentages[$districtName] = array_map(
                fn ($c) => $rowTotal > 0 ? round($c / $rowTotal * 100, 1) : 0,
                $row
            );
        }

        $heatmapHotspots = [];
        foreach ($heatmapMatrix as $districtName => $row) {
            $withIndex = array_map(fn ($c, $i) => ['count' => $c, 'idx' => $i], $row, array_keys($row));
            usort($withIndex, fn ($a, $b) => $b['count'] <=> $a['count']);
            $heatmapHotspots[$districtName] = array_column(array_slice($withIndex, 0, 3), 'idx');
        }

        $mapProvinceSlug = preg_replace('/[^a-z]/', '', strtolower((string) ($province->province_name ?? '')));

        return view('provincial-admin-dashboard.heatmap', [
            'province' => $province,
            'districts' => $districts,
            'schools' => $schools,
            'abuseTypes' => $abuseTypes,
            'districtFilter' => $districtFilter,
            'schoolFilter' => $schoolFilter,
            'abuseTypeFilter' => $abuseTypeFilter,
            'ageRange' => $ageRange,
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'activeFilters' => $activeFilters,

            'heatmapAbuseTypes' => $heatmapAbuseTypes,
            'heatmapMatrix' => $heatmapMatrix,
            'heatmapMax' => $heatmapMax,
            'heatmapRowTotals' => $heatmapRowTotals,
            'heatmapColumnTotals' => $heatmapColumnTotals,
            'heatmapGrandTotal' => $heatmapGrandTotal,
            'districtsWithReports' => $districtsWithReports,
            'heatmapDistrictNameToId' => $heatmapDistrictNameToId,
            'heatmapAbuseTypeNameToId' => $heatmapAbuseTypeNameToId,
            'heatmapPercentages' => $heatmapPercentages,
            'heatmapHotspots' => $heatmapHotspots,

            'mapProvinceSlug' => $mapProvinceSlug,
        ]);
    }
}
