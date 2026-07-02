<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;
use App\Models\School;
use App\Models\AbuseType;
use Carbon\Carbon;

class SchoolAdminDashboardController extends AdminController
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'school') {
            abort(403, 'Unauthorized');
        }

        $schoolName = $user->school_name;
        $school = School::where('school_name', $schoolName)->first();

        if (!$school) {
            abort(404, 'School not found');
        }

        // Get filters from request
        $abuseTypeFilter = $request->input('abuse_type');
        $ageRange = $request->input('age_range');
        $gradeFilter = $request->input('grade');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        // Load abuse types for the filter dropdown (always show all for selection)
        $allAbuseTypes = AbuseType::orderBy('type_name')->get();
        
        // Get available grades for this school - get all distinct grades
        $grades = Report::where('school_name', $schoolName)
            ->whereNotNull('grade')
            ->where('grade', '!=', '')
            ->distinct()
            ->pluck('grade')
            ->filter(function($grade) {
                return !empty(trim($grade));
            })
            ->unique()
            ->sortBy(function($grade) {
                // Sort: Creche first, then Grade R, then numeric grades
                $gradeLower = strtolower(trim($grade));
                
                // Creche comes first (handle misspellings: creche, crèche, cretch, crèch, etc.)
                if (preg_match('/^cr[èe]?ch?e?$/i', $gradeLower) || $gradeLower === 'cretch') {
                    return -2;
                }
                
                // Grade R comes next
                if ($gradeLower === 'r' || $gradeLower === 'grade r' || $gradeLower === 'pre-primary' || $gradeLower === 'pre-grade') {
                    return -1;
                }
                
                // Handle numeric grades
                if (is_numeric($grade)) {
                    return (int)$grade;
                }
                
                // Handle "Grade X" format
                if (preg_match('/^grade\s*(\d+)$/i', $gradeLower, $matches)) {
                    return (int)$matches[1];
                }
                
                return 999; // Non-numeric grades at the end
            })
            ->values()
            ->toArray();

        // Base reports query with eager loading (filtered by school)
        $reportsQuery = Report::with(['school', 'abuseType'])
            ->where('school_name', $schoolName);

        // Apply filters
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
        // Only apply grade filter if a specific grade is selected (not "Any Grade")
        // When empty or null, show all grades (no filter applied)
        if (!empty($gradeFilter) && trim($gradeFilter) !== '') {
            $reportsQuery->where('grade', $gradeFilter);
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

        // Count reports per canonical status (legacy DB values map into six buckets + false-report)
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

        // --- Fix: Build abuse type labels & counts based on the currently displayed reports ---
        // This ensures charts/tables only show abuse types present in the filtered reports.
        // However, we still pass $allAbuseTypes to the view for the filter dropdown.
        $abuseTypeIdsInReports = $reports->pluck('abuse_type_id')->filter()->unique()->values()->toArray();

        if (!empty($abuseTypeIdsInReports)) {
            $abuseTypesForDisplay = AbuseType::whereIn('id', $abuseTypeIdsInReports)
                ->orderBy('type_name')
                ->get();
        } else {
            // No reports -> empty collection (avoid showing all types on charts)
            $abuseTypesForDisplay = collect();
        }

        $abuseTypeLabels = $abuseTypesForDisplay->pluck('type_name')->toArray();
        $abuseTypeCounts = [];
        foreach ($abuseTypesForDisplay as $atype) {
            $abuseTypeCounts[] = $reports->where('abuse_type_id', $atype->id)->count();
        }

        // Anonymous vs identified counts
        $anonymousCounts = [
            'anonymous' => $reports->where('is_anonymous', 1)->count(),
            'identified' => $reports->where('is_anonymous', 0)->count(),
        ];

        // Top abuse types by report count (for this school) - limit to those with at least 1 report
        $topAbuseTypes = $reports->filter(fn($report) => optional($report->abuseType)->type_name !== null)
            ->groupBy(fn($report) => $report->abuseType->type_name)
            ->map(fn($group) => $group->count())
            ->filter(fn($count) => $count > 0)
            ->sortDesc()
            ->take(8)
            ->toArray();

        // Percentages for abuse types (for extras modal table)
        $totalAbuseReports = array_sum($abuseTypeCounts);
        $abuseTypePercentages = $totalAbuseReports > 0
            ? array_map(fn($c) => round(($c / $totalAbuseReports) * 100, 2), $abuseTypeCounts)
            : array_fill(0, count($abuseTypeCounts), 0);

        // Total count of all abuse types in the system (always 6)
        $totalAbuseTypesCount = $allAbuseTypes->count();

        // Active filters for UI chips
        $activeFilters = [];
        if ($abuseTypeFilter) {
            $abuseTypeName = $allAbuseTypes->firstWhere('id', $abuseTypeFilter)?->type_name ?? '';
            if ($abuseTypeName) $activeFilters[] = $abuseTypeName;
        }
        if ($ageRange) {
            $activeFilters[] = "Age: $ageRange";
        }
        if (!empty($gradeFilter) && trim($gradeFilter) !== '') {
            $activeFilters[] = "Grade: $gradeFilter";
        }
        if ($fromDate) {
            $activeFilters[] = "From: $fromDate";
        }
        if ($toDate) {
            $activeFilters[] = "To: $toDate";
        }

        // Prepare status reports group for modal (keys match headline cards)
        $statusReportPayload = $reports->groupBy(fn ($report) => Report::normalizeStatusForDashboard($report->status))->map(fn ($collection) =>
            $collection->map(fn ($report) => [
                'case_number' => $report->case_number,
                'status' => $report->status,
                'abuse_type' => optional($report->abuseType)->type_name,
                'created_at' => optional($report->created_at)->format('Y M d'),
            ])->values()
        )->toArray();

        // Prepare all reports payload for modal
        $allReportsPayload = $reports->map(fn($report) => [
            'case_number' => $report->case_number,
            'status' => $report->status,
            'abuse_type' => optional($report->abuseType)->type_name,
            'created_at' => optional($report->created_at)->format('Y M d'),
        ])->values()->toArray();

        // Prepare anonymous reports payload for modal
        $anonymousReportsPayload = $reports->where('is_anonymous', 1)->map(fn($report) => [
            'case_number' => $report->case_number,
            'status' => $report->status,
            'abuse_type' => optional($report->abuseType)->type_name,
            'created_at' => optional($report->created_at)->format('Y M d'),
        ])->values()->toArray();

        // Prepare identified reports payload for modal
        $identifiedReportsPayload = $reports->where('is_anonymous', 0)->map(fn($report) => [
            'case_number' => $report->case_number,
            'status' => $report->status,
            'abuse_type' => optional($report->abuseType)->type_name,
            'created_at' => optional($report->created_at)->format('Y M d'),
        ])->values()->toArray();

        // False reports summary for dashboard card (identify repeat reporters)
        $falseReportsForSchool = $reports->filter(fn ($r) => Report::normalizeStatusForDashboard($r->status) === 'false-report');
        $falseReportTotal = $falseReportsForSchool->count();
        $repeatByEmail = $falseReportsForSchool->filter(fn($r) => !empty(trim($r->reporter_email ?? '')))
            ->groupBy(fn($r) => strtolower(trim($r->reporter_email)))
            ->filter(fn($g) => $g->count() > 1)->count();
        $repeatByName = $falseReportsForSchool->filter(fn($r) => !empty(trim($r->full_name ?? '')))
            ->groupBy(fn($r) => strtolower(trim($r->full_name)))
            ->filter(fn($g) => $g->count() > 1)->count();
        $repeatByPhone = $falseReportsForSchool->filter(fn($r) => !empty(preg_replace('/\s+/', '', trim($r->phone_number ?? ''))))
            ->groupBy(fn($r) => preg_replace('/\s+/', '', trim($r->phone_number)))
            ->filter(fn($g) => $g->count() > 1)->count();
        $falseReportSummary = [
            'total' => $falseReportTotal,
            'repeat_emails' => $repeatByEmail,
            'repeat_names' => $repeatByName,
            'repeat_phones' => $repeatByPhone,
        ];

        return view('school-admin-dashboard.index', [
            'school' => $school,
            'abuseTypeFilter' => $abuseTypeFilter,
            'ageRange' => $ageRange,
            'gradeFilter' => $gradeFilter,
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            // Keep dropdown options complete
            'abuseTypes' => $allAbuseTypes,
            'grades' => $grades,
            'summaryCounts' => ['total' => $totalReports, 'statuses' => $statusCounts],
            'months' => $months,
            'monthlyCounts' => $monthlyCounts,
            // Provide labels & counts based on filtered reports
            'abuseTypeLabels' => $abuseTypeLabels,
            'abuseTypeCounts' => $abuseTypeCounts,
            'abuseTypePercentages' => $abuseTypePercentages,

            'anonymousCounts' => $anonymousCounts,
            'statusCounts' => $statusCounts,
            'topAbuseTypes' => $topAbuseTypes,
            'totalAbuseTypesCount' => $totalAbuseTypesCount,
            'activeFilters' => $activeFilters,
            'statusReportPayload' => $statusReportPayload,
            'allReportsPayload' => $allReportsPayload,
            'anonymousReportsPayload' => $anonymousReportsPayload,
            'identifiedReportsPayload' => $identifiedReportsPayload,
            'falseReportSummary' => $falseReportSummary,
        ]);
    }

    public function falseReports(Request $request)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'school') {
            abort(403, 'Unauthorized');
        }

        $schoolName = $user->school_name;
        $school = School::where('school_name', $schoolName)->first();

        if (!$school) {
            abort(404, 'School not found');
        }

        // Get all false reports for this school
        $falseReports = Report::with(['abuseType', 'subtype'])
            ->where('school_name', $schoolName)
            ->whereCanonicalDashboardStatus('false-report')
            ->orderBy('created_at', 'desc')
            ->get();

        // Analyze patterns: Group by email
        $emailPatterns = [];
        foreach ($falseReports as $report) {
            if (!empty($report->reporter_email)) {
                $email = strtolower(trim($report->reporter_email));
                if (!isset($emailPatterns[$email])) {
                    $emailPatterns[$email] = [];
                }
                $emailPatterns[$email][] = $report;
            }
        }

        // Filter emails with multiple false reports
        $suspiciousEmails = array_filter($emailPatterns, function($reports) {
            return count($reports) > 1;
        });

        // Analyze patterns: Group by name
        $namePatterns = [];
        foreach ($falseReports as $report) {
            if (!empty($report->full_name)) {
                $name = strtolower(trim($report->full_name));
                if (!isset($namePatterns[$name])) {
                    $namePatterns[$name] = [];
                }
                $namePatterns[$name][] = $report;
            }
        }

        // Filter names with multiple false reports
        $suspiciousNames = array_filter($namePatterns, function($reports) {
            return count($reports) > 1;
        });

        // Analyze patterns: Group by phone number
        $phonePatterns = [];
        foreach ($falseReports as $report) {
            if (!empty($report->phone_number)) {
                $phone = preg_replace('/\s+/', '', trim($report->phone_number));
                if ($phone !== '') {
                    if (!isset($phonePatterns[$phone])) {
                        $phonePatterns[$phone] = [];
                    }
                    $phonePatterns[$phone][] = $report;
                }
            }
        }

        // Filter phones with multiple false reports
        $suspiciousPhones = array_filter($phonePatterns, function($reports) {
            return count($reports) > 1;
        });

        // Sort by count (descending)
        uasort($suspiciousEmails, function($a, $b) {
            return count($b) - count($a);
        });

        uasort($suspiciousNames, function($a, $b) {
            return count($b) - count($a);
        });

        uasort($suspiciousPhones, function($a, $b) {
            return count($b) - count($a);
        });

        // Get action filter
        $actionFilter = $request->input('action', 'all'); // all, email, name, phone

        return view('school-admin-dashboard.false-reports', [
            'school' => $school,
            'falseReports' => $falseReports,
            'suspiciousEmails' => $suspiciousEmails,
            'suspiciousNames' => $suspiciousNames,
            'suspiciousPhones' => $suspiciousPhones,
            'totalFalseReports' => $falseReports->count(),
            'totalSuspiciousEmails' => count($suspiciousEmails),
            'totalSuspiciousNames' => count($suspiciousNames),
            'totalSuspiciousPhones' => count($suspiciousPhones),
            'actionFilter' => $actionFilter,
        ]);
    }

    public function flagReport(Request $request, $reportId)
    {
        return $this->safeAdmin(function () use ($request, $reportId) {
            return $this->performFlagReport($request, $reportId);
        }, $request);
    }

    private function performFlagReport(Request $request, $reportId)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'school') {
            abort(403, 'Unauthorized');
        }

        $report = Report::findOrFail($reportId);

        // Security check: ensure report belongs to admin's school
        if ($report->school_name !== $user->school_name) {
            abort(403, 'Unauthorized');
        }

        // Update status to false-report
        $report->status = 'false-report';
        $report->latest_status_reason = $request->input('reason', 'Flagged as false report by admin');
        $report->save();

        return redirect()->back()->with('success', 'Report has been flagged as false.');
    }
}