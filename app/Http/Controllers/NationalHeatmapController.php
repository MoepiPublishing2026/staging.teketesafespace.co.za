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
use Illuminate\Support\Facades\Schema;

class NationalHeatmapController extends Controller
{
    /**
     * Thresholds scaled to the full count range (0..max) so all counts are represented.
     *
     * @return array{0:int,1:int} [lowMax, mediumMax]
     */
    protected function rangeScaledBandThresholds(array $counts): array
    {
        $vals = array_map(fn ($c) => (int) $c, $counts);
        $max = max(0, ...$vals);
        if ($max <= 0) {
            return [0, 0];
        }
        // Split the full range into 3 bands.
        $lowMax = (int) floor($max / 3);
        $mediumMax = (int) floor((2 * $max) / 3);
        // Ensure medium is always >= low and both are at least 1 when there is data.
        $lowMax = max(1, $lowMax);
        $mediumMax = max($lowMax, $mediumMax);

        return [$lowMax, $mediumMax];
    }

    /**
     * Balanced thresholds (approx tertiles) so low/medium/high all appear when possible.
     * Excludes zeros so "no reports" doesn't dominate the distribution.
     *
     * Guarantees:
     * - If there are >= 3 distinct positive counts, low/medium/high will all have at least 1 item.
     * - Otherwise falls back to range-scaled thresholds.
     *
     * @return array{0:int,1:int} [lowMax, mediumMax]
     */
    protected function balancedBandThresholds(array $counts): array
    {
        $positive = array_values(array_filter(
            array_map(fn ($c) => (int) $c, $counts),
            fn ($c) => $c > 0
        ));

        if (count($positive) < 3) {
            return $this->rangeScaledBandThresholds($counts);
        }

        sort($positive);
        $unique = array_values(array_unique($positive));
        if (count($unique) < 3) {
            return $this->rangeScaledBandThresholds($counts);
        }

        $n = count($positive);
        $iLow = max(0, (int) floor($n / 3) - 1);
        $iMed = max($iLow + 1, (int) floor((2 * $n) / 3) - 1);
        $iMed = min($n - 1, $iMed);

        $lowMax = $positive[$iLow];
        $mediumMax = $positive[$iMed];

        // If cutoffs collapse (skewed distribution), bump mediumMax to next distinct value.
        if ($mediumMax <= $lowMax) {
            foreach ($positive as $v) {
                if ($v > $lowMax) {
                    $mediumMax = $v;
                    break;
                }
            }
        }

        // If still collapsed, fall back.
        if ($mediumMax <= $lowMax) {
            return $this->rangeScaledBandThresholds($counts);
        }

        return [(int) $lowMax, (int) $mediumMax];
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
        if ($ageRange && Schema::hasColumn('reports', 'age')) {
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
        $unknownAbuseTypeId = 0;
        $unknownAbuseTypeLabel = 'Unknown';
        $abuseTypeIds = array_values(array_merge($abuseTypes->pluck('id')->all(), [$unknownAbuseTypeId]));

        // Reports are sometimes missing province/district ids and only have `school_id`.
        // For heatmaps/maps we treat province/district as:
        //   effective_province_id = COALESCE(reports.province_id, schools.province_id)
        //   effective_district_id = COALESCE(reports.district_id, schools.district_id)
        // so the UI reflects the correct data even when denormalized fields are null.
        $baseQuery = DB::table('reports')
            ->leftJoin('schools as s', 'reports.school_id', '=', 's.school_id')
            // Allow province to be inferred from district when reports.province_id is null.
            ->leftJoin('districts as d', DB::raw('COALESCE(reports.district_id, s.district_id)'), '=', 'd.district_id');

        $applySqlFilters = function (\Illuminate\Database\Query\Builder $q) use ($request): void {
            $provinceFilter = $request->input('province');
            $districtFilter = $request->input('district');
            $schoolFilter = $request->input('school');
            $abuseTypeFilter = $request->input('abuse_type');

            if ($provinceFilter) {
                $q->whereRaw('COALESCE(reports.province_id, s.province_id, d.province_id) = ?', [$provinceFilter]);
            }
            if ($provinceFilter && $districtFilter) {
                $q->whereRaw('COALESCE(reports.district_id, s.district_id) = ?', [$districtFilter]);
            }
            if ($provinceFilter && $districtFilter && $schoolFilter) {
                $q->where('reports.school_id', $schoolFilter);
            }
            if ($abuseTypeFilter) {
                $q->where('reports.abuse_type_id', $abuseTypeFilter);
            }

            $ageRange = $request->input('age_range');
            if ($ageRange && Schema::hasColumn('reports', 'age')) {
                if ($ageRange === '30+') {
                    $q->where('reports.age', '>=', 30);
                } elseif (strpos((string) $ageRange, '-') !== false) {
                    [$minAge, $maxAge] = explode('-', $ageRange, 2);
                    if (is_numeric($minAge) && is_numeric($maxAge)) {
                        $q->whereBetween('reports.age', [(int) $minAge, (int) $maxAge]);
                    }
                }
            }

            if ($request->filled('from_date')) {
                $q->whereDate('reports.created_at', '>=', $request->input('from_date'));
            }
            if ($request->filled('to_date')) {
                $q->whereDate('reports.created_at', '<=', $request->input('to_date'));
            }
        };

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
        $provinceHeatmapAbuseTypes = array_values(array_merge(
            $abuseTypes->pluck('type_name')->toArray(),
            [$unknownAbuseTypeLabel]
        ));

        $provinceTypeCounts = (clone $baseQuery)
            ->selectRaw('COALESCE(reports.province_id, s.province_id, d.province_id) as province_id, COALESCE(reports.abuse_type_id, 0) as abuse_type_id, COUNT(*) as count')
            ->whereNotNull(DB::raw('COALESCE(reports.province_id, s.province_id, d.province_id)'))
            ->tap($applySqlFilters)
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

        $provinceHeatmapProvinceNameToId = $provinces->pluck('id', 'name')->toArray();
        $provinceHeatmapAbuseTypeNameToId = $abuseTypes->pluck('id', 'type_name')->toArray();
        $provinceHeatmapAbuseTypeNameToId[$unknownAbuseTypeLabel] = null;

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

        /* District counts for national geographic map (map_data.json is district-level) */
        $allDistricts = District::orderBy('district_name')
            ->get(['district_id as id', 'district_name as name', 'province_id']);

        $districtTotals = (clone $baseQuery)
            ->selectRaw('COALESCE(reports.district_id, s.district_id) as district_id, COUNT(*) as count')
            ->whereNotNull(DB::raw('COALESCE(reports.district_id, s.district_id)'))
            ->tap($applySqlFilters)
            ->groupBy('district_id')
            ->get()
            ->keyBy('district_id');

        $mapDistrictCounts = [];
        foreach ($allDistricts as $district) {
            $mapDistrictCounts[$district->name] = (int) ($districtTotals[$district->id]->count ?? 0);
        }

        $mapDistrictMax = collect($mapDistrictCounts)->max() ?: 1;
        $mapDistrictNameToId = $allDistricts->pluck('id', 'name')->toArray();
        [$mapDistrictBandLowMax, $mapDistrictBandMediumMax] = $this->balancedBandThresholds(array_values($mapDistrictCounts));

        $filteredReportsTotal = (clone $baseQuery)
            ->tap($applySqlFilters)
            ->count();

        $mappedReportsTotal = (int) collect($districtTotals)->sum('count');
        $unmappedReportsTotal = max(0, (int) ($filteredReportsTotal - $mappedReportsTotal));

        $provinceNameById = $provinces->pluck('name', 'id')->toArray();
        $mapProvinceTotalsFromDistricts = [];
        foreach ($allDistricts as $district) {
            $pid = (int) ($district->province_id ?? 0);
            if ($pid <= 0) {
                continue;
            }
            $pname = $provinceNameById[$pid] ?? null;
            if (!$pname) {
                continue;
            }
            $mapProvinceTotalsFromDistricts[$pname] = ($mapProvinceTotalsFromDistricts[$pname] ?? 0) + (int) ($districtTotals[$district->id]->count ?? 0);
        }
        arsort($mapProvinceTotalsFromDistricts);

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
            'provinceHeatmapRowTotals' => $provinceHeatmapRowTotals,
            'provinceHeatmapColumnTotals' => $provinceHeatmapColumnTotals,
            'provinceHeatmapGrandTotal' => $provinceHeatmapGrandTotal,
            'filteredReportsTotal' => $filteredReportsTotal,
            'provinceHeatmapProvinceNameToId' => $provinceHeatmapProvinceNameToId,
            'provinceHeatmapAbuseTypeNameToId' => $provinceHeatmapAbuseTypeNameToId,
            'provinceHeatmapPercentages' => $provinceHeatmapPercentages,
            'provinceHeatmapHotspots' => $provinceHeatmapHotspots,

            'mapDistrictCounts' => $mapDistrictCounts,
            'mapDistrictMax' => $mapDistrictMax,
            'mapDistrictBandLowMax' => $mapDistrictBandLowMax,
            'mapDistrictBandMediumMax' => $mapDistrictBandMediumMax,
            'mapDistrictNameToId' => $mapDistrictNameToId,
            'mappedReportsTotal' => $mappedReportsTotal,
            'unmappedReportsTotal' => $unmappedReportsTotal,
            'mapProvinceTotalsFromDistricts' => $mapProvinceTotalsFromDistricts,
        ]);
    }
}
