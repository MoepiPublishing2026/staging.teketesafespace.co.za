<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Province;
use App\Models\District;
use App\Models\School;
use App\Models\AbuseType;
use Carbon\Carbon;

class NationalAdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->input('tab', 'overview');

        /* -----------------------------------------
         * FILTER INPUTS
         * ----------------------------------------- */
        $provinceFilter = $request->input('province');
        $districtFilter = $request->input('district');
        $schoolFilter   = $request->input('school');
        $abuseTypeFilter = $request->input('abuse_type');
        $ageRange      = $request->input('age_range');
        $fromDate      = $request->input('from_date');
        $toDate        = $request->input('to_date');

        /* -----------------------------------------
         * FILTER OPTIONS FOR SELECT BOXES
         * ----------------------------------------- */
        $provinces = Province::orderBy('province_name')
            ->get(['province_id as id', 'province_name as name']);

        $districts = $provinceFilter
            ? District::where('province_id', $provinceFilter)
                ->orderBy('district_name')
                ->get(['district_id as id', 'district_name as name'])
            : collect();

        $schools = $districtFilter
            ? School::where('district_id', $districtFilter)
                ->orderBy('school_name')
                ->get(['school_id', 'school_name'])
            : collect();

        $abuseTypes = AbuseType::orderBy('type_name')->get();

        /* -----------------------------------------
         * REPORTS QUERY WITH FILTERS
         * ----------------------------------------- */
        $reportsQuery = Report::with(['province', 'district', 'school', 'abuseType']);

        if ($provinceFilter) $reportsQuery->where('province_id', $provinceFilter);
        if ($districtFilter) $reportsQuery->where('district_id', $districtFilter);
        if ($schoolFilter)   $reportsQuery->where('school_id', $schoolFilter);
        if ($abuseTypeFilter) $reportsQuery->where('abuse_type_id', $abuseTypeFilter);

        if ($ageRange) {
            if ($ageRange === '30+') {
                $reportsQuery->where('age', '>=', 30);
            } elseif (strpos($ageRange, '-') !== false) {
                [$minAge, $maxAge] = explode('-', $ageRange);
                $reportsQuery->whereBetween('age', [(int)$minAge, (int)$maxAge]);
            }
        }

        if ($fromDate) $reportsQuery->whereDate('created_at', '>=', $fromDate);
        if ($toDate)   $reportsQuery->whereDate('created_at', '<=', $toDate);

        $reports = $reportsQuery->get();
        $totalReports = $reports->count();

        /* -----------------------------------------
         * STATUS COUNTS
         * ----------------------------------------- */
        $statusOrder = [
            'awaiting-resolution', 'forwarded', 'under-review',
            'closed', 'unresolved', 'false-report'
        ];

        $statusCounts = array_fill_keys($statusOrder, 0);
        foreach ($reports as $report) {
            $bucket = Report::normalizeStatusForDashboard($report->status);
            if (isset($statusCounts[$bucket])) {
                $statusCounts[$bucket]++;
            }
        }

        /* -----------------------------------------
         * MONTHLY COUNTS (JAN–DEC)
         * ----------------------------------------- */
        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

        $monthlyGroups = $reports->groupBy(fn($r) =>
            Carbon::parse($r->created_at)->format('M')
        );

        $monthlyCounts = array_map(
            fn($m) => $monthlyGroups->has($m) ? $monthlyGroups[$m]->count() : 0,
            $months
        );

        /* -----------------------------------------
         * ABUSE TYPE COUNTS + PERCENTAGES
         * ----------------------------------------- */
        $abuseTypeLabels = $abuseTypes->pluck('type_name')->toArray();
        $abuseTypeCounts = [];

        foreach ($abuseTypeLabels as $label) {
            $abuseTypeCounts[] = $reports
                ->filter(fn($r) => $r->abuseType && $r->abuseType->type_name === $label)
                ->count();
        }

        $totalAbuseReports = array_sum($abuseTypeCounts);

        $abuseTypePercentages = $totalAbuseReports > 0
            ? array_map(fn($c) => round(($c / $totalAbuseReports) * 100, 2), $abuseTypeCounts)
            : array_fill(0, count($abuseTypeCounts), 0);

        /* -----------------------------------------
         * ANONYMOUS COUNTS
         * ----------------------------------------- */
        $anonymousCounts = [
            'anonymous' => $reports->where('is_anonymous', 1)->count(),
            'identified' => $reports->where('is_anonymous', 0)->count(),
        ];

        /* -----------------------------------------
         * SCHOOLS (linked school record only)
         * Active Schools card + modal: full list. Top Reporting Schools chart: top 8 only.
         * ----------------------------------------- */
        $reportsWithLinkedSchool = $reports->filter(fn ($r) => optional($r->school)->school_name);
        $schoolGroups = $reportsWithLinkedSchool
            ->groupBy(fn ($r) => $r->school->school_name)
            ->map->count()
            ->sortDesc();
        $activeSchoolsWithReports = $schoolGroups->count();
        $activeSchoolsByReports = $schoolGroups->toArray();
        $topSchools = $schoolGroups->take(8)->toArray();
        $reportsWithoutLinkedSchool = $totalReports - $reportsWithLinkedSchool->count();

        /* -----------------------------------------
         * RECENT REPORTS (LAST 10)
         * ----------------------------------------- */
        $recentReports = $reports->sortByDesc('created_at')->take(10);

        /* -----------------------------------------
         * ACTIVE FILTER LABELS FOR UI
         * ----------------------------------------- */
        $activeFilters = [];

        if ($provinceFilter) {
            $name = $provinces->firstWhere('id', $provinceFilter)?->name;
            if ($name) $activeFilters[] = $name;
        }

        if ($districtFilter) {
            $name = $districts->firstWhere('id', $districtFilter)?->name;
            if ($name) $activeFilters[] = $name;
        }

        if ($schoolFilter) {
            $name = $schools->firstWhere('school_id', $schoolFilter)?->school_name;
            if ($name) $activeFilters[] = $name;
        }

        if ($abuseTypeFilter) {
            $name = $abuseTypes->firstWhere('id', $abuseTypeFilter)?->type_name;
            if ($name) $activeFilters[] = $name;
        }

        if ($ageRange)  $activeFilters[] = "Age: $ageRange";
        if ($fromDate)  $activeFilters[] = "From: $fromDate";
        if ($toDate)    $activeFilters[] = "To: $toDate";

        /* -----------------------------------------
         * STATUS REPORT PAYLOAD (FOR MODALS)
         * ----------------------------------------- */
        $statusReportPayload = $reports
            ->groupBy(fn ($r) => Report::normalizeStatusForDashboard($r->status))
            ->map(fn($list) =>
                $list->map(fn($r) => [
                    'case_number' => $r->case_number,
                    'status' => $r->status,
                    'abuse_type' => optional($r->abuseType)->type_name,
                    'created_at' => optional($r->created_at)->format('Y-m-d'),
                ])->values()
            )->toArray();

        /* -----------------------------------------
         * ALL REPORTS TABLE PAYLOAD
         * ----------------------------------------- */
        $allReportsPayload = $reports->map(fn($r) => [
            'case_number' => $r->case_number,
            'status' => $r->status,
            'abuse_type' => optional($r->abuseType)->type_name,
            'created_at' => optional($r->created_at)->format('Y-m-d'),
        ])->values()->toArray();

        /* -----------------------------------------
         * AGE GROUPS (SINGLE DATASET ONLY)
         * ----------------------------------------- */
        $ageGroups = ['0-10', '11-15', '16-20', '21-25', '26-30', '30+'];

        $ageCounts = [];
        foreach ($ageGroups as $group) {
            if ($group === '30+') {
                $count = $reports->where('age', '>=', 30)->count();
            } else {
                [$min, $max] = explode('-', $group);
                $count = $reports->whereBetween('age', [(int)$min, (int)$max])->count();
            }
            $ageCounts[] = $count;
        }

        /* -----------------------------------------
         * HEATMAP: Province × Abuse Type
         * ----------------------------------------- */
        $heatmapProvinces = $provinces->pluck('name', 'id')->toArray();
        $heatmapAbuseTypes = $abuseTypes->pluck('type_name')->toArray();
        $heatmapMatrix = [];

        foreach ($heatmapProvinces as $provinceId => $provinceName) {
            $row = [];
            foreach ($abuseTypes as $atype) {
                $count = $reports
                    ->filter(fn($r) => $r->province_id == $provinceId && $r->abuseType && $r->abuseType->type_name === $atype->type_name)
                    ->count();
                $row[] = $count;
            }
            $heatmapMatrix[$provinceName] = $row;
        }

        // Sort provinces by total reports (descending) for easier analysis
        uasort($heatmapMatrix, function ($a, $b) {
            return array_sum($b) <=> array_sum($a);
        });

        // Row totals (per province) and column totals (per abuse type)
        $heatmapRowTotals = [];
        $heatmapColumnTotals = array_fill(0, count($heatmapAbuseTypes), 0);
        foreach ($heatmapMatrix as $province => $row) {
            $heatmapRowTotals[$province] = array_sum($row);
            foreach ($row as $i => $count) {
                $heatmapColumnTotals[$i] += $count;
            }
        }
        $heatmapGrandTotal = array_sum($heatmapColumnTotals);

        $heatmapMax = collect($heatmapMatrix)->flatten()->max() ?: 1;

        // Province/abuse type name → ID for click-to-filter
        $heatmapProvinceNameToId = $provinces->pluck('id', 'name')->toArray();
        $heatmapAbuseTypeNameToId = $abuseTypes->pluck('id', 'type_name')->toArray();

        // Row percentages (each cell = % of province total)
        $heatmapPercentages = [];
        foreach ($heatmapMatrix as $province => $row) {
            $rowTotal = $heatmapRowTotals[$province] ?? 0;
            $heatmapPercentages[$province] = array_map(
                fn($c) => $rowTotal > 0 ? round($c / $rowTotal * 100, 1) : 0,
                $row
            );
        }

        // Hotspot indices: top 3 cells per row by count
        $heatmapHotspots = [];
        foreach ($heatmapMatrix as $province => $row) {
            $withIndex = array_map(fn($c, $i) => ['count' => $c, 'idx' => $i], $row, array_keys($row));
            usort($withIndex, fn($a, $b) => $b['count'] <=> $a['count']);
            $heatmapHotspots[$province] = array_column(array_slice($withIndex, 0, 3), 'idx');
        }

        /* -----------------------------------------
         * GEO MAP: Province report counts for choropleth
         * ----------------------------------------- */
        $mapProvinceCounts = [];
        foreach ($provinces as $p) {
            $count = $reports->filter(fn($r) => $r->province_id == $p->id)->count();
            $mapProvinceCounts[$p->name] = $count;
        }

        /* -----------------------------------------
         * RETURN TO VIEW
         * ----------------------------------------- */
        return view('national-admin-dashboard.index', [
            'adminType' => 'national',
            'activeTab' => $activeTab,
            'provinceFilter' => $provinceFilter,
            'districtFilter' => $districtFilter,
            'schoolFilter' => $schoolFilter,
            'abuseTypeFilter' => $abuseTypeFilter,
            'ageRange' => $ageRange,
            'fromDate' => $fromDate,
            'toDate' => $toDate,

            'provinces' => $provinces,
            'districts' => $districts,
            'schools' => $schools,
            'abuseTypes' => $abuseTypes,

            'summaryCounts' => [
                'total' => $totalReports,
                'statuses' => $statusCounts
            ],

            'months' => $months,
            'monthlyCounts' => $monthlyCounts,

            'abuseTypeLabels' => $abuseTypeLabels,
            'abuseTypeCounts' => $abuseTypeCounts,
            'abuseTypePercentages' => $abuseTypePercentages,

            'anonymousCounts' => $anonymousCounts,
            'statusCounts' => $statusCounts,

            'topSchools' => $topSchools,
            'activeSchoolsByReports' => $activeSchoolsByReports,
            'activeSchoolsWithReports' => $activeSchoolsWithReports,
            'reportsWithoutLinkedSchool' => $reportsWithoutLinkedSchool,
            'recentReports' => $recentReports,
            'activeFilters' => $activeFilters,

            'statusReportPayload' => $statusReportPayload,
            'allReportsPayload' => $allReportsPayload,

            // NEW AGE CHART DATA (single dataset)
            'ageGroups' => $ageGroups,
            'ageCounts' => $ageCounts,

            // Heatmap: Province × Abuse Type
            'heatmapProvinces' => array_keys($heatmapMatrix),
            'heatmapAbuseTypes' => $heatmapAbuseTypes,
            'heatmapMatrix' => $heatmapMatrix,
            'heatmapMax' => $heatmapMax,
            'heatmapRowTotals' => $heatmapRowTotals,
            'heatmapColumnTotals' => $heatmapColumnTotals,
            'heatmapGrandTotal' => $heatmapGrandTotal,
            'heatmapProvinceNameToId' => $heatmapProvinceNameToId,
            'heatmapAbuseTypeNameToId' => $heatmapAbuseTypeNameToId,
            'heatmapPercentages' => $heatmapPercentages,
            'heatmapHotspots' => $heatmapHotspots,

            // Geographic map choropleth
            'mapProvinceCounts' => $mapProvinceCounts,
        ]);
    }
}
