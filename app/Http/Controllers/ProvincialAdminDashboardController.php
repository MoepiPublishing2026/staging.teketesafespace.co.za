<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;
use App\Models\Province;
use App\Models\District;
use App\Models\School;
use App\Models\AbuseType;
use Carbon\Carbon;

class ProvincialAdminDashboardController extends Controller
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

        $activeTab = $request->input('tab', 'overview');

        // Get filters from request
        $districtFilter = $request->input('district');
        $schoolFilter = $request->input('school');
        $abuseTypeFilter = $request->input('abuse_type');
        $ageRange = $request->input('age_range');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        // Load filter options for selects (only for this province)
        $districts = District::where('province_id', $province_id)
            ->orderBy('district_name')
            ->get(['district_id as id', 'district_name as name']);
        $schools = $districtFilter 
            ? School::where('district_id', $districtFilter)->where('province_id', $province_id)->orderBy('school_name')->get(['school_id', 'school_name']) 
            : School::where('province_id', $province_id)->orderBy('school_name')->get(['school_id', 'school_name']);
        $abuseTypes = AbuseType::orderBy('type_name')->get();

        // Base reports query with eager loading (filtered by province)
        $reportsQuery = Report::with(['province', 'district', 'school.district', 'abuseType'])
            ->where('province_id', $province_id);

        // Apply all filters regardless of tab
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
                    $reportsQuery->whereBetween('age', [(int)$minAge, (int)$maxAge]);
                }
            }
        }
        if ($fromDate) {
            $reportsQuery->whereDate('created_at', '>=', $fromDate);
        }
        if ($toDate) {
            $reportsQuery->whereDate('created_at', '<=', $toDate);
        }

        // Get reports
        $reports = $reportsQuery->get();

        // Count total reports
        $totalReports = $reports->count();

        // Define statuses in fixed order
        $statusOrder = [
            'awaiting-resolution',
            'forwarded',
            'under-review',
            'closed',
            'unresolved',
            'false-report',
        ];

        // Count reports per canonical status (pending, legacy labels, etc. map into six buckets)
        $statusCounts = array_fill_keys($statusOrder, 0);
        foreach ($reports as $report) {
            $bucket = Report::normalizeStatusForDashboard($report->status);
            if (isset($statusCounts[$bucket])) {
                $statusCounts[$bucket]++;
            }
        }

        // Monthly counts for each month (Jan-Dec)
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $monthlyGroups = $reports->groupBy(function ($report) {
            return Carbon::parse($report->created_at)->format('M');
        });
        $monthlyCounts = array_map(fn($month) => $monthlyGroups->has($month) ? $monthlyGroups[$month]->count() : 0, $months);

        // Abuse types data and percentages
        $abuseTypeLabels = $abuseTypes->pluck('type_name')->toArray();
        $abuseTypeCounts = [];
        foreach ($abuseTypeLabels as $label) {
            $abuseTypeCounts[] = $reports->filter(fn($report) => $report->abuseType && $report->abuseType->type_name === $label)->count();
        }
        $totalAbuseReports = array_sum($abuseTypeCounts);
        $abuseTypePercentages = $totalAbuseReports > 0
            ? array_map(fn($count) => round(($count / $totalAbuseReports) * 100, 2), $abuseTypeCounts)
            : array_fill(0, count($abuseTypeCounts), 0);

        // Anonymous vs identified counts
        $anonymousCounts = [
            'anonymous' => $reports->where('is_anonymous', 1)->count(),
            'identified' => $reports->where('is_anonymous', 0)->count(),
        ];

        // Schools with linked record: card + modal = full list; chart/table = top 8 by volume
        $reportsWithLinkedSchool = $reports->filter(fn ($report) => optional($report->school)->school_name);
        $schoolGroups = $reportsWithLinkedSchool
            ->groupBy(fn ($report) => $report->school->school_name)
            ->map(fn ($group) => $group->count())
            ->sortDesc();
        $activeSchoolsWithReports = $schoolGroups->count();
        $activeSchoolsByReports = $schoolGroups->toArray();
        $topSchools = $schoolGroups->take(8)->toArray();
        $reportsWithoutLinkedSchool = $totalReports - $reportsWithLinkedSchool->count();

        // Recent reports
        $recentReports = $reports->sortByDesc('created_at')->take(10);

        // Active filters for UI chips
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
        if ($ageRange) {
            $activeFilters[] = "Age: $ageRange";
        }
        if ($fromDate) {
            $activeFilters[] = "From: $fromDate";
        }
        if ($toDate) {
            $activeFilters[] = "To: $toDate";
        }

        // Prepare status reports group for modal (keys match headline status cards)
        $statusReportPayload = $reports->groupBy(fn ($report) => Report::normalizeStatusForDashboard($report->status))->map(fn($collection) =>
            $collection->map(fn($report) => [
                'case_number' => $report->case_number,
                'status' => $report->status,
                'abuse_type' => optional($report->abuseType)->type_name,
                'created_at' => optional($report->created_at)->format('Y-m-d'),
            ])->values()
        )->toArray();

        // Prepare all reports payload for modal
        $allReportsPayload = $reports->map(fn($report) => [
            'case_number' => $report->case_number,
            'status' => $report->status,
            'abuse_type' => optional($report->abuseType)->type_name,
            'created_at' => optional($report->created_at)->format('Y-m-d'),
        ])->values()->toArray();

        // Prepare anonymous reports payload for modal
        $anonymousReportsPayload = $reports->where('is_anonymous', 1)->map(fn($report) => [
            'case_number' => $report->case_number,
            'status' => $report->status,
            'abuse_type' => optional($report->abuseType)->type_name,
            'created_at' => optional($report->created_at)->format('Y-m-d'),
        ])->values()->toArray();

        // Prepare identified reports payload for modal
        $identifiedReportsPayload = $reports->where('is_anonymous', 0)->map(fn($report) => [
            'case_number' => $report->case_number,
            'status' => $report->status,
            'abuse_type' => optional($report->abuseType)->type_name,
            'created_at' => optional($report->created_at)->format('Y-m-d'),
        ])->values()->toArray();

        /* -----------------------------------------
         * HEATMAP: District × Abuse Type (within province)
         * ----------------------------------------- */
        $heatmapDistricts = $districts->pluck('name', 'id')->toArray();
        $heatmapAbuseTypes = $abuseTypes->pluck('type_name')->toArray();
        $heatmapMatrix = [];

        foreach ($heatmapDistricts as $districtId => $districtName) {
            $row = [];
            foreach ($abuseTypes as $atype) {
                $count = $reports
                    ->filter(function ($r) use ($districtId, $atype) {
                        $rid = $r->district_id ?? optional($r->school)->district_id;
                        return $rid == $districtId && $r->abuseType && $r->abuseType->type_name === $atype->type_name;
                    })
                    ->count();
                $row[] = $count;
            }
            $heatmapMatrix[$districtName] = $row;
        }

        // Sort districts by total reports (descending)
        uasort($heatmapMatrix, function ($a, $b) {
            return array_sum($b) <=> array_sum($a);
        });

        $heatmapRowTotals = [];
        $heatmapColumnTotals = array_fill(0, count($heatmapAbuseTypes), 0);
        foreach ($heatmapMatrix as $district => $row) {
            $heatmapRowTotals[$district] = array_sum($row);
            foreach ($row as $i => $count) {
                $heatmapColumnTotals[$i] += $count;
            }
        }
        $heatmapGrandTotal = array_sum($heatmapColumnTotals);
        $heatmapMax = collect($heatmapMatrix)->flatten()->max() ?: 1;

        $heatmapDistrictNameToId = $districts->pluck('id', 'name')->toArray();
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

        /* -----------------------------------------
         * GEO MAP: Province report counts for choropleth
         * Only user's province has count; others are 0 (dimmed)
         * ----------------------------------------- */
        $allProvinces = Province::orderBy('province_name')->get(['province_id', 'province_name']);
        $mapProvinceCounts = [];
        foreach ($allProvinces as $p) {
            $mapProvinceCounts[$p->province_name] = ($p->province_id == $province_id) ? $totalReports : 0;
        }
        $mapUserProvinceName = $province->province_name ?? null;

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

        return view('provincial-admin-dashboard.index', [
            'adminType' => 'provincial',
            'province' => $province,
            'activeTab' => $activeTab,
            'districtFilter' => $districtFilter,
            'schoolFilter' => $schoolFilter,
            'abuseTypeFilter' => $abuseTypeFilter,
            'ageRange' => $ageRange,
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'districts' => $districts,
            'schools' => $schools,
            'abuseTypes' => $abuseTypes,
            'summaryCounts' => ['total' => $totalReports, 'statuses' => $statusCounts],
            'months' => $months,
            'monthlyCounts' => $monthlyCounts,
            'abuseTypeLabels' => $abuseTypeLabels,
            'abuseTypeCounts' => $abuseTypeCounts,
            'abuseTypePercentages' => $abuseTypePercentages,
            'anonymousCounts' => $anonymousCounts,
            'statusCounts' => $statusCounts,
            'topSchools' => $topSchools,
            'activeSchoolsWithReports' => $activeSchoolsWithReports,
            'activeSchoolsByReports' => $activeSchoolsByReports,
            'reportsWithoutLinkedSchool' => $reportsWithoutLinkedSchool,
            'recentReports' => $recentReports,
            'activeFilters' => $activeFilters,
            'statusReportPayload' => $statusReportPayload,
            'allReportsPayload' => $allReportsPayload,
            'anonymousReportsPayload' => $anonymousReportsPayload,
            'identifiedReportsPayload' => $identifiedReportsPayload,

            // Heatmap: District × Abuse Type
            'heatmapAbuseTypes' => $heatmapAbuseTypes,
            'heatmapMatrix' => $heatmapMatrix,
            'heatmapMax' => $heatmapMax,
            'heatmapRowTotals' => $heatmapRowTotals,
            'heatmapColumnTotals' => $heatmapColumnTotals,
            'heatmapGrandTotal' => $heatmapGrandTotal,
            'heatmapDistrictNameToId' => $heatmapDistrictNameToId,
            'heatmapAbuseTypeNameToId' => $heatmapAbuseTypeNameToId,
            'heatmapPercentages' => $heatmapPercentages,
            'heatmapHotspots' => $heatmapHotspots,

            // Geographic map choropleth
            'mapProvinceCounts' => $mapProvinceCounts,
            'mapUserProvinceName' => $mapUserProvinceName,
            'mapDistrictCounts' => $mapDistrictCounts,
            'mapProvinceSlug' => $mapProvinceSlug,
        ]);
    }
}

