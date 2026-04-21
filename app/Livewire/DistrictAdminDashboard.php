<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;
use App\Models\District;
use App\Models\School;
use App\Models\AbuseType;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class DistrictAdminDashboard extends Component
{
    public $districtId;
    public $districtName = 'Unknown District';
    public $provinceName;

    public $schools = [];
    public $abuseTypes = [];

    public $selectedSchool = '';
    public $selectedAbuseType = '';
    public $selectedAgeRange = '';
    public $selectedGrade = '';
    public $fromDate = '';
    public $toDate = '';

    public $reports;
    public $totalReports = 0;
    public $statusCounts = [];

    public $months = [];
    public $monthlyCounts = [];
    public $ageGroups = [];
    public $abuseTypesData = [];
    public $anonymousCounts = [];
    public $statusDistribution = [];
    public $topSchools = [];
    public $summaryStats = [];
    public $recentReports;
    public $activeTab = 'dashboard';
    public $ageRanges = [];
    public $gradeOptions = [];
    public $gradeDistribution = [];
    public $ageStatistics = [];
    public $attentionStatuses = [];
    public $dataRefreshedAt = '';
    public $periodComparison = [];
    public $dataQuality = [];

    public $showModal = false;
    public $statusReports;
    public $modalStatus = null;
    public $selectedReport = null;
    public $selectedReportDetails = [];

    public $schoolCardColors = [
        '#A52A2A', '#3fa796', '#d7e47a', '#c7e03a', '#e38645',
        '#2196f3', '#5ea241', '#f5cf4d', '#b8d42f', '#e57373',
    ];

    public function mount(): void
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'district') {
            abort(403, 'Unauthorized');
        }

        $this->districtId = $user->district_id ?? null;

        if (!$this->districtId) {
            abort(403, 'District not assigned to administrator');
        }

        $district = District::with('province')->find($this->districtId);

        if ($district) {
            $this->districtName = $district->district_name;
            $this->provinceName = optional($district->province)->province_name;
        }

        $this->schools = School::where('district_id', $this->districtId)
            ->orderBy('school_name')
            ->pluck('school_name', 'school_id')
            ->toArray();

        $this->abuseTypes = AbuseType::orderBy('type_name')
            ->pluck('type_name', 'id')
            ->toArray();

        $this->ageRanges = [
            'Under 10', '10-15', '15-20', '20-25', '25-30', '30+'
        ];

        $existingGrades = Report::where('district_id', $this->districtId)
            ->whereNotNull('grade')
            ->pluck('grade')
            ->map(fn ($value) => trim((string) $value))
            ->filter()
            ->values()
            ->unique();

        $this->gradeOptions = collect($this->standardGradeList())
            ->merge($existingGrades)
            ->unique()
            ->values()
            ->toArray();

        $this->reports = collect();
        $this->statusReports = collect();
        $this->recentReports = collect();

        $this->loadDashboardData();
    }

    public function updatedSelectedSchool(): void
    {
        $this->loadDashboardData();
    }

    public function updatedSelectedAbuseType(): void
    {
        $this->loadDashboardData();
    }

    public function updatedSelectedAgeRange(): void
    {
        $this->loadDashboardData();
    }

    public function updatedSelectedGrade(): void
    {
        $this->loadDashboardData();
    }

    public function updatedFromDate(): void
    {
        $this->loadDashboardData();
    }

    public function updatedToDate(): void
    {
        $this->loadDashboardData();
    }

    public function resetFilters(): void
    {
        $this->reset([
            'selectedSchool',
            'selectedAbuseType',
            'selectedAgeRange',
            'selectedGrade',
            'fromDate',
            'toDate',
        ]);

        $this->loadDashboardData();
    }

    public function setActiveTab(string $tab): void
    {
        if (in_array($tab, ['dashboard', 'reports'], true)) {
            $this->activeTab = $tab;
            if ($tab === 'dashboard') {
                $this->loadDashboardData();
            }
        }
    }

    protected function baseQuery(array $overrides = [])
    {
        $filters = array_merge([
            'selectedSchool' => $this->selectedSchool,
            'selectedAbuseType' => $this->selectedAbuseType,
            'selectedAgeRange' => $this->selectedAgeRange,
            'selectedGrade' => $this->selectedGrade,
            'fromDate' => $this->fromDate,
            'toDate' => $this->toDate,
        ], $overrides);

        $query = Report::with(['abuseType', 'province', 'district', 'school'])
            ->where('district_id', $this->districtId);

        if ($filters['selectedSchool']) {
            $query->where('school_id', $filters['selectedSchool']);
        }

        if ($filters['selectedAbuseType']) {
            $query->where('abuse_type_id', $filters['selectedAbuseType']);
        }

        if ($filters['selectedAgeRange']) {
            $ageRange = $filters['selectedAgeRange'];
            if ($ageRange === 'Under 10') {
                $query->where('age', '<', 10);
            } elseif ($ageRange === '30+') {
                $query->where('age', '>=', 30);
            } elseif (strpos($ageRange, '-') !== false) {
                [$min, $max] = explode('-', $ageRange);
                $query->whereBetween('age', [(int) $min, (int) $max - 1]);
            }
        }

        if ($filters['selectedGrade'] !== '') {
            $selected = $filters['selectedGrade'];
            $numericMatch = null;
            if (preg_match('/\d+/', $selected, $matches)) {
                $numericMatch = $matches[0];
            }

            $query->where(function ($gradeQuery) use ($selected, $numericMatch) {
                $gradeQuery->where('grade', $selected);

                if ($numericMatch !== null) {
                    $gradeQuery->orWhere('grade', $numericMatch);
                }

                if (strtolower($selected) === 'grade r') {
                    $gradeQuery->orWhere('grade', 'R')->orWhere('grade', '0');
                }

                if (strtolower($selected) === 'pre-primary') {
                    $gradeQuery->orWhere('grade', 'Pre-Primary')->orWhere('grade', 'Pre-Grade');
                }
            });
        }

        if (!empty($filters['fromDate'])) {
            $query->whereDate('created_at', '>=', $filters['fromDate']);
        }

        if (!empty($filters['toDate'])) {
            $query->whereDate('created_at', '<=', $filters['toDate']);
        }

        return $query;
    }

    public function loadDashboardData(): void
    {
        $this->reports = $this->baseQuery()->get();
        $this->totalReports = $this->reports->count();

        $statuses = ['awaiting-resolution', 'forwarded', 'under-review', 'unresolved', 'closed', 'false-report'];

        foreach ($statuses as $status) {
            $this->statusCounts[$status] = $this->reports->where('status', $status)->count();
        }

        $this->loadMonthlyReportData();
        $this->loadAbuseTypeData();
        $this->loadAgeGroupsData();
        $this->loadAnonymousData();
        $this->loadTopSchoolsData();
        $this->loadSummaryStats();
        $this->loadRecentReports();
        $this->loadGradeDistributionData();
        $this->loadAgeStatistics();
        $this->loadAttentionStatuses();
        $this->loadPeriodComparison();
        $this->loadDataQualityIndicators();

        $this->statusDistribution = $this->statusCounts;
        $this->dataRefreshedAt = now()->format('Y-m-d H:i');

        $this->dispatch('updateCharts', [
            'months' => $this->months,
            'monthlyCounts' => $this->monthlyCounts,
            'ageGroups' => $this->ageGroups,
            'abuseTypes' => $this->abuseTypesData,
            'anonymousCounts' => $this->anonymousCounts,
            'statusDistribution' => $this->statusDistribution,
            'topSchools' => $this->topSchools,
            'gradeDistribution' => $this->gradeDistribution,
        ]);
    }

    private function loadMonthlyReportData(): void
    {
        $monthOrder = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $monthlyGroups = $this->reports->groupBy(fn ($report) => Carbon::parse($report->created_at)->format('M'));

        $this->months = $monthOrder;
        $this->monthlyCounts = array_map(
            fn ($month) => $monthlyGroups->has($month) ? $monthlyGroups[$month]->count() : 0,
            $monthOrder
        );
    }

    private function loadAbuseTypeData(): void
    {
        $types = AbuseType::pluck('type_name')->toArray();
        $counts = [];

        foreach ($types as $type) {
            $counts[] = $this->reports
                ->filter(fn ($report) => $report->abuseType && strcasecmp($report->abuseType->type_name, $type) === 0)
                ->count();
        }

        $this->abuseTypesData = array_combine($types, $counts);
    }

    private function loadAgeGroupsData(): void
    {
        $ranges = [
            'Under 10' => 0,
            '10-15' => 0,
            '15-20' => 0,
            '20-25' => 0,
            '25-30' => 0,
            '30+' => 0,
        ];

        foreach ($this->reports as $report) {
            if (!$report->age) {
                continue;
            }

            $age = (int) $report->age;

            foreach ($ranges as $range => &$count) {
                if ($range === 'Under 10') {
                    if ($age < 10) {
                        $count++;
                        break;
                    }
                    continue;
                }

                if ($range === '30+' && $age >= 30) {
                    $count++;
                    break;
                }

                if (strpos($range, '-') !== false) {
                    [$min, $max] = explode('-', $range);

                    if ($age >= (int) $min && $age < (int) $max) {
                        $count++;
                        break;
                    }
                }
            }
            unset($count);
        }

        $this->ageGroups = $ranges;
    }

    private function loadAnonymousData(): void
    {
        $this->anonymousCounts = [
            'anonymous' => $this->reports->where('is_anonymous', 1)->count(),
            'non_anonymous' => $this->reports->where('is_anonymous', 0)->count(),
        ];
    }

    private function loadTopSchoolsData(): void
    {
        $this->topSchools = $this->reports
            ->filter(fn ($report) => $report->school)
            ->groupBy(fn ($report) => $report->school->school_name)
            ->map(fn ($group) => $group->count())
            ->sortDesc()
            ->take(5)
            ->toArray();
    }

    private function loadSummaryStats(): void
    {
        $uniqueSchools = $this->reports->pluck('school_id')->filter()->unique()->count();
        $totalReports = $this->totalReports;
        $anonymous = $this->anonymousCounts['anonymous'] ?? 0;
        $topSchoolName = array_key_first($this->topSchools);
        $latestReportAt = optional($this->reports->sortByDesc('created_at')->first())->created_at;

        $this->summaryStats = [
            'uniqueSchools' => $uniqueSchools,
            'anonymousPercentage' => $totalReports > 0 ? round(($anonymous / $totalReports) * 100, 1) : 0,
            'latestReportDate' => $latestReportAt ? Carbon::parse($latestReportAt)->format('Y-m-d') : null,
            'topSchoolName' => $topSchoolName,
            'reportsPerSchool' => $uniqueSchools > 0 ? round($totalReports / $uniqueSchools, 1) : $totalReports,
        ];
    }

    private function loadRecentReports(): void
    {
        $this->recentReports = $this->baseQuery()
            ->latest()
            ->take(8)
            ->get();
    }

    private function loadGradeDistributionData(): void
    {
        $this->gradeDistribution = $this->reports
            ->filter(fn ($report) => $report->grade)
            ->groupBy(fn ($report) => trim((string) $report->grade))
            ->map(fn ($group) => $group->count())
            ->sortDesc()
            ->take(15)
            ->toArray();
    }

    private function loadAgeStatistics(): void
    {
        $ages = $this->reports
            ->pluck('age')
            ->filter(fn ($age) => $age !== null && $age !== '' && is_numeric($age))
            ->map(fn ($age) => (int) $age)
            ->values();

        if ($ages->isEmpty()) {
            $this->ageStatistics = [
                'averageAge' => null,
                'medianAge' => null,
                'minorsPercentage' => null,
                'underTenCount' => 0,
                'sampleSize' => 0,
            ];
            return;
        }

        $average = round($ages->avg(), 1);
        $sorted = $ages->sort()->values();
        $count = $sorted->count();
        $median = $count % 2 === 1
            ? $sorted->get(intdiv($count, 2))
            : round(($sorted->get($count / 2 - 1) + $sorted->get($count / 2)) / 2, 1);

        $minors = $ages->filter(fn ($age) => $age < 18)->count();
        $minorsPercentage = $count > 0 ? round(($minors / $count) * 100, 1) : null;
        $underTen = $ages->filter(fn ($age) => $age < 10)->count();

        $this->ageStatistics = [
            'averageAge' => $average,
            'medianAge' => $median,
            'minorsPercentage' => $minorsPercentage,
            'underTenCount' => $underTen,
            'sampleSize' => $count,
        ];
    }

    private function loadAttentionStatuses(): void
    {
        $priorityStatuses = ['awaiting-resolution', 'under-review', 'forwarded', 'unresolved'];
        $attention = [];

        foreach ($priorityStatuses as $status) {
            $count = $this->statusCounts[$status] ?? 0;
            if ($count === 0) {
                continue;
            }

            $oldest = $this->reports
                ->where('status', $status)
                ->sortBy('created_at')
                ->first();

            $latest = $this->reports
                ->where('status', $status)
                ->sortByDesc('updated_at')
                ->first();

            $oldestDays = $oldest && $oldest->created_at
                ? Carbon::parse($oldest->created_at)->diffInDays(now())
                : null;

            $lastUpdate = $latest && $latest->updated_at
                ? Carbon::parse($latest->updated_at)->diffForHumans()
                : null;

            $attention[] = [
                'status' => $status,
                'count' => $count,
                'oldestDays' => $oldestDays,
                'lastUpdate' => $lastUpdate,
            ];
        }

        $this->attentionStatuses = collect($attention)
            ->sortByDesc('count')
            ->values()
            ->toArray();
    }

    private function loadPeriodComparison(): void
    {
        $currentStart = $this->fromDate ? Carbon::parse($this->fromDate) : Carbon::now()->startOfMonth();
        $currentEnd = $this->toDate ? Carbon::parse($this->toDate) : Carbon::now()->endOfMonth();

        if ($currentEnd->lessThan($currentStart)) {
            [$currentStart, $currentEnd] = [$currentEnd, $currentStart];
        }

        $rangeDays = max($currentStart->diffInDays($currentEnd) + 1, 1);

        $previousEnd = (clone $currentStart)->subDay();
        $previousStart = (clone $previousEnd)->subDays($rangeDays - 1);

        $currentCount = $this->baseQuery([
            'fromDate' => $currentStart->format('Y-m-d'),
            'toDate' => $currentEnd->format('Y-m-d'),
        ])->count();

        $previousCount = $this->baseQuery([
            'fromDate' => $previousStart->format('Y-m-d'),
            'toDate' => $previousEnd->format('Y-m-d'),
        ])->count();

        $difference = $currentCount - $previousCount;
        $percent = $previousCount > 0 ? round(($difference / $previousCount) * 100, 1) : null;

        $this->periodComparison = [
            'currentRange' => [$currentStart->format('Y-m-d'), $currentEnd->format('Y-m-d')],
            'previousRange' => [$previousStart->format('Y-m-d'), $previousEnd->format('Y-m-d')],
            'currentCount' => $currentCount,
            'previousCount' => $previousCount,
            'difference' => $difference,
            'percentChange' => $percent,
        ];
    }

    private function loadDataQualityIndicators(): void
    {
        $missingAge = $this->reports->whereNull('age')->count() + $this->reports->where('age', '')->count();
        $missingGrade = $this->reports->whereNull('grade')->count() + $this->reports->where('grade', '')->count();
        $missingDetails = $this->reports->whereNull('details')->count() + $this->reports->where('details', '')->count();

        $this->dataQuality = [
            'missingAge' => $missingAge,
            'missingGrade' => $missingGrade,
            'missingDetails' => $missingDetails,
            'total' => $this->totalReports,
        ];
    }

    private function standardGradeList(): array
    {
        return [
            'Pre-Primary',
            'Grade R',
            'Grade 1',
            'Grade 2',
            'Grade 3',
            'Grade 4',
            'Grade 5',
            'Grade 6',
            'Grade 7',
            'Grade 8',
            'Grade 9',
            'Grade 10',
            'Grade 11',
            'Grade 12',
        ];
    }

    public function showStatusReports($status = null): void
    {
        $query = $this->baseQuery();

        if ($status) {
            $query->where('status', $status);
        }

        $this->statusReports = $query->latest()->get();
        $this->modalStatus = $status;
        $this->showModal = true;
        $this->selectedReport = null;
        $this->selectedReportDetails = [];
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->statusReports = collect();
        $this->modalStatus = null;
        $this->selectedReport = null;
        $this->selectedReportDetails = [];
    }

    public function showReportDetails($reportId): void
    {
        $report = $this->statusReports->firstWhere('id', $reportId);

        if (!$report) {
            $this->selectedReport = null;
            $this->selectedReportDetails = [];
            return;
        }

        $this->selectedReport = $report;

        $statusLabel = $report->status
            ? ucwords(str_replace('-', ' ', $report->status))
            : 'N/A';

        $this->selectedReportDetails = [
            'case_number' => $report->case_number ?? 'N/A',
            'abuse_type' => optional($report->abuseType)->type_name ?? 'N/A',
            'status' => $statusLabel,
            'created_at' => $report->created_at ? Carbon::parse($report->created_at)->format('Y-m-d') : 'N/A',
            'province' => optional($report->province)->province_name ?? 'N/A',
            'district' => optional($report->district)->district_name ?? 'N/A',
            'school' => optional($report->school)->school_name ?? 'N/A',
            'age' => $report->age ?? 'N/A',
            'anonymous' => $report->is_anonymous ? 'Yes' : 'No',
            'details' => $report->details ?? 'No additional details.'
        ];
    }

    public function closeReportDetails(): void
    {
        $this->selectedReport = null;
        $this->selectedReportDetails = [];
    }

    public function getFiltersAppliedProperty(): bool
    {
        return (bool) (
            $this->selectedSchool ||
            $this->selectedAbuseType ||
            $this->selectedAgeRange ||
            $this->selectedGrade ||
            $this->fromDate ||
            $this->toDate
        );
    }



public function exportPDF()
{
    $reports = $this->baseQuery()->get();

    $pdf = Pdf::loadView('pdf.district-dashboard', [
        'reports' => $reports,
        'districtName' => $this->districtName,
        'provinceName' => $this->provinceName,
    ]);

    return response()->streamDownload(
        fn() => print($pdf->output()),
        "District_Dashboard_{$this->districtName}.pdf"
    );
}
    public function render()
    {
        return view('livewire.district-admin-dashboard', [
            'districtName' => $this->districtName,
            'provinceName' => $this->provinceName,
            'schools' => $this->schools,
            'abuseTypes' => $this->abuseTypes,
            'reports' => $this->reports,
            'months' => $this->months,
            'monthlyCounts' => $this->monthlyCounts,
            'ageGroups' => $this->ageGroups,
            'abuseTypesData' => $this->abuseTypesData,
            'statusCounts' => $this->statusCounts,
            'totalReports' => $this->totalReports,
            'anonymousCounts' => $this->anonymousCounts,
            'showModal' => $this->showModal,
            'statusReports' => $this->statusReports,
            'modalStatus' => $this->modalStatus,
            'selectedReport' => $this->selectedReport,
            'selectedReportDetails' => $this->selectedReportDetails,
            'statusDistribution' => $this->statusDistribution,
            'topSchools' => $this->topSchools,
            'summaryStats' => $this->summaryStats,
            'recentReports' => $this->recentReports,
            'activeTab' => $this->activeTab,
            'gradeDistribution' => $this->gradeDistribution,
            'ageStatistics' => $this->ageStatistics,
            'attentionStatuses' => $this->attentionStatuses,
            'dataRefreshedAt' => $this->dataRefreshedAt,
            'periodComparison' => $this->periodComparison,
            'dataQuality' => $this->dataQuality,
        ])->layout('components.layouts.app', ['title' => 'District Dashboard | Tekete SafeSpace']);
    }
}