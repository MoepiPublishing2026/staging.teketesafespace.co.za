<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;
use App\Models\Province;
use App\Models\District;
use App\Models\School;
use App\Models\AbuseType;

class ProvincialHeatmapController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'provincial') {
            abort(403, 'Unauthorized');
        }

        $province_id = $user->province_id;
        $province = Province::find($province_id);

        if (!$province) {
            abort(404, 'Province not found');
        }

        // Filters
        $districtFilter  = $request->input('district');
        $schoolFilter    = $request->input('school');
        $abuseTypeFilter = $request->input('abuse_type');
        $ageRange        = $request->input('age_range');
        $fromDate        = $request->input('from_date');
        $toDate          = $request->input('to_date');

        // Filter option lists
        $districts = District::where('province_id', $province_id)
            ->orderBy('district_name')
            ->get(['district_id as id', 'district_name as name']);

        $schools = $districtFilter
            ? School::where('district_id', $districtFilter)->where('province_id', $province_id)->orderBy('school_name')->get(['school_id', 'school_name'])
            : School::where('province_id', $province_id)->orderBy('school_name')->get(['school_id', 'school_name']);

        $abuseTypes = AbuseType::orderBy('type_name')->get();

        // Base reports query
        $reportsQuery = Report::with(['district', 'school.district', 'abuseType'])
            ->where('province_id', $province_id);

        if ($districtFilter) {
            $reportsQuery->where('district_id', $districtFilter);
        }
        if ($schoolFilter) {
            $reportsQuery->where('school_id', $schoolFilter);
        }
        if ($abuseTypeFilter) {
            $reportsQuery->where('abuse_type_id', $abuseTypeFilter);
        }
        if ($ageRange) {
            if ($ageRange === '30+') {
                $reportsQuery->where('age', '>=', 30);
            } elseif (strpos($ageRange, '-') !== false) {
                [$minAge, $maxAge] = explode('-', $ageRange);
                if (is_numeric($minAge) && is_numeric($maxAge)) {
                    $reportsQuery->whereBetween('age', [(int) $minAge, (int) $maxAge]);
                }
            }
        }
        if ($fromDate) {
            $reportsQuery->whereDate('created_at', '>=', $fromDate);
        }
        if ($toDate) {
            $reportsQuery->whereDate('created_at', '<=', $toDate);
        }

        $reports     = $reportsQuery->get();
        $totalReports = $reports->count();

        // Active filter chips
        $activeFilters = [];
        if ($districtFilter) {
            $districtName = $districts->firstWhere('id', $districtFilter)?->name ?? '';
            if ($districtName) $activeFilters[] = $districtName;
        }
        if ($schoolFilter) {
            $schoolName = $schools->firstWhere('school_id', $schoolFilter)?->school_name ?? '';
            if ($schoolName) $activeFilters[] = $schoolName;
        }
        if ($abuseTypeFilter) {
            $abuseTypeName = $abuseTypes->firstWhere('id', $abuseTypeFilter)?->type_name ?? '';
            if ($abuseTypeName) $activeFilters[] = $abuseTypeName;
        }
        if ($ageRange)  $activeFilters[] = "Age: $ageRange";
        if ($fromDate)  $activeFilters[] = "From: $fromDate";
        if ($toDate)    $activeFilters[] = "To: $toDate";

        /* -------------------------------------------------------
         * HEATMAP: District × Abuse Type
         * ------------------------------------------------------- */
        $heatmapDistrictMap = $districts->pluck('name', 'id')->toArray();
        $heatmapAbuseTypes  = $abuseTypes->pluck('type_name')->toArray();
        $heatmapMatrix      = [];

        foreach ($heatmapDistrictMap as $districtId => $districtName) {
            $row = [];
            foreach ($abuseTypes as $atype) {
                $row[] = $reports->filter(function ($r) use ($districtId, $atype) {
                    $rid = $r->district_id ?? optional($r->school)->district_id;
                    return $rid == $districtId
                        && $r->abuseType
                        && $r->abuseType->type_name === $atype->type_name;
                })->count();
            }
            $heatmapMatrix[$districtName] = $row;
        }

        // Sort districts by total (descending)
        uasort($heatmapMatrix, fn($a, $b) => array_sum($b) <=> array_sum($a));

        $heatmapRowTotals    = [];
        $heatmapColumnTotals = array_fill(0, count($heatmapAbuseTypes), 0);
        foreach ($heatmapMatrix as $district => $row) {
            $heatmapRowTotals[$district] = array_sum($row);
            foreach ($row as $i => $count) {
                $heatmapColumnTotals[$i] += $count;
            }
        }
        $heatmapGrandTotal = array_sum($heatmapColumnTotals);
        $heatmapMax        = collect($heatmapMatrix)->flatten()->max() ?: 1;

        $heatmapDistrictNameToId  = $districts->pluck('id', 'name')->toArray();
        $heatmapAbuseTypeNameToId = $abuseTypes->pluck('id', 'type_name')->toArray();

        $heatmapPercentages = [];
        foreach ($heatmapMatrix as $district => $row) {
            $rowTotal = $heatmapRowTotals[$district] ?? 0;
            $heatmapPercentages[$district] = array_map(
                fn($c) => $rowTotal > 0 ? round($c / $rowTotal * 100, 1) : 0,
                $row
            );
        }

        $heatmapHotspots = [];
        foreach ($heatmapMatrix as $district => $row) {
            $withIndex = array_map(fn($c, $i) => ['count' => $c, 'idx' => $i], $row, array_keys($row));
            usort($withIndex, fn($a, $b) => $b['count'] <=> $a['count']);
            $heatmapHotspots[$district] = array_column(array_slice($withIndex, 0, 3), 'idx');
        }

        /* -------------------------------------------------------
         * GEO MAP: District choropleth for this province
         * ------------------------------------------------------- */
        $mapDistrictCounts = $reports
            ->map(function ($r) {
                $districtName = optional($r->district)->district_name
                    ?? optional(optional($r->school)->district)->district_name;
                return $districtName ? ['district' => $districtName] : null;
            })
            ->filter()
            ->groupBy('district')
            ->map->count()
            ->toArray();

        $mapProvinceSlug = preg_replace('/[^a-z]/', '', strtolower((string) ($province->province_name ?? '')));

        return view('provincial-admin-dashboard.heatmap', [
            'province'                => $province,
            'districts'               => $districts,
            'schools'                 => $schools,
            'abuseTypes'              => $abuseTypes,
            'districtFilter'          => $districtFilter,
            'schoolFilter'            => $schoolFilter,
            'abuseTypeFilter'         => $abuseTypeFilter,
            'ageRange'                => $ageRange,
            'fromDate'                => $fromDate,
            'toDate'                  => $toDate,
            'activeFilters'           => $activeFilters,

            // Heatmap
            'heatmapAbuseTypes'       => $heatmapAbuseTypes,
            'heatmapMatrix'           => $heatmapMatrix,
            'heatmapMax'              => $heatmapMax,
            'heatmapRowTotals'        => $heatmapRowTotals,
            'heatmapColumnTotals'     => $heatmapColumnTotals,
            'heatmapGrandTotal'       => $heatmapGrandTotal,
            'heatmapDistrictNameToId' => $heatmapDistrictNameToId,
            'heatmapAbuseTypeNameToId'=> $heatmapAbuseTypeNameToId,
            'heatmapPercentages'      => $heatmapPercentages,
            'heatmapHotspots'         => $heatmapHotspots,

            // Geographic map
            'mapDistrictCounts'       => $mapDistrictCounts,
            'mapProvinceSlug'         => $mapProvinceSlug,
        ]);
    }
}