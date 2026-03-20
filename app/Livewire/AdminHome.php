<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Report;
use App\Models\School;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AdminHome extends Component
{
    // Livewire properties for data and state
    public $reports;
    public $months;
    public $monthlyCounts;
    public $abuseTypeLabels;
    public $abuseTypeCounts;
    public $abuseTypePercentages;
    public $schools;
    public $years;
    public $role;
    public $currentYear;
    public $statusDataWithPercentage = [];
     // Anonymity Counts (NEW)
    public $anonymousCount = 0;
    public $nonAnonymousCount = 0; // <--- ADD THIS

    // Dynamic filter properties
    public $availableAgeGroups = [];
    public $availableGrades = [];
    public $ageGroupCounts = [];
    public $gradeCounts = [];
    public $ageTrendData = [];

    // Filter state properties
    public $debugQuery = null;
    public $selectedGrade = null;
    public $selectedAge = null;
    public $selectedAbuseType = null;
    public $fromDate = null;
    public $toDate = null;
    public $selectedYear = null;

    // Dashboard status counts
    public $escalatedCount = 0;
    public $falseCount = 0;
    public $inProcessCount = 0;
    public $pendingCount = 0;
    public $unresolvedCount = 0;
    public $resolvedCount = 0;
    public $totalCount = 0;

     public function resetAllFilters()
    {
        $this->selectedGrade = null;
        $this->selectedAge = null;
        $this->selectedAbuseType = null;
        $this->fromDate = null;
        $this->toDate = null;
        
        // Refresh all data
        $this->fetchAgeTrendData();
        $this->fetchAbuseTypeData();
        $this->fetchStatusCounts();
        $this->fetchAnonymityCounts();
        $this->fetchReports();
    }

     public function updated($property)
    {
        // List of filter properties that should trigger data refresh
        $filterProperties = [
            'selectedGrade',
            'selectedAge', 
            'selectedAbuseType',
            'fromDate',
            'toDate'
        ];

        if (in_array($property, $filterProperties)) {
            $this->applyFilters();
        }
    }
     protected function applyFilters()
    {
        $this->fetchAgeTrendData();
        $this->fetchAbuseTypeData();
        $this->fetchStatusCounts();
        $this->fetchAnonymityCounts();
        $this->fetchReports();
    }
    protected function fetchAbuseTypeData()
    {
        $this->calculateFilterCounts();

        $schoolName = Auth::check() ? Auth::user()->school_name : null;

        $query = Report::selectRaw('abuse_types.type_name as abuse_name, COUNT(reports.id) as count')
            ->join('abuse_types', 'reports.abuse_type_id', '=', 'abuse_types.id')
            ->when($schoolName, fn($q) => $q->where('reports.school_name', $schoolName))
            ->whereYear('reports.created_at', $this->selectedYear);

        // Age filter
        if ($this->selectedAge !== null) {
            if ($this->selectedAge === '<=10') {
                $query->where('age', '<=', 10);
            } elseif ($this->selectedAge === '20+') {
                $query->where('age', '>=', 20);
            } elseif (strpos($this->selectedAge, '-') !== false) {
                list($minAge, $maxAge) = explode('-', $this->selectedAge);
                $query->whereBetween('age', [(int)$minAge, (int)$maxAge]);
            }
        }

        // Grade filter
        if ($this->selectedGrade !== null) {
            $gradeToFilter = 'Grade ' . $this->selectedGrade;
            $query->where('grade', $gradeToFilter);
        }

        // Abuse type filter
        if ($this->selectedAbuseType !== null) {
            $query->where('abuse_types.type_name', $this->selectedAbuseType);
        }

        // Date range filter
        if ($this->fromDate) {
            $query->whereDate('reports.created_at', '>=', $this->fromDate);
        }
        if ($this->toDate) {
            $query->whereDate('reports.created_at', '<=', $this->toDate);
        }

        $filteredData = $query
            ->groupBy('abuse_name')
            ->orderBy('abuse_name', 'asc')
            ->pluck('count', 'abuse_name')
            ->toArray();

        $this->abuseTypeLabels = array_keys($filteredData);
        $this->abuseTypeCounts = array_values($filteredData);

        $dataPayload = [
            'labels' => $this->abuseTypeLabels,
            'counts' => $this->abuseTypeCounts,
            'ageLabels' => $this->availableAgeGroups,
            'ageCounts' => array_values($this->ageGroupCounts),
            'ageTrendData' => $this->ageTrendData,
            'anonymousCount' => $this->anonymousCount,
            'nonAnonymousCount' => $this->nonAnonymousCount,
        ];

        $this->dispatch('chartDataUpdated', $dataPayload);
    }

     protected function fetchReports()
    {
        $schoolName = Auth::check() ? Auth::user()->school_name : null;

        $query = Report::with(['abuseType', 'subtype'])
            ->when($schoolName, fn($q) => $q->where('school_name', $schoolName))
            ->whereYear('created_at', $this->selectedYear);

        // Apply all active filters
        if ($this->selectedAge !== null) {
            if ($this->selectedAge === '<=10') {
                $query->where('age', '<=', 10);
            } elseif ($this->selectedAge === '20+') {
                $query->where('age', '>=', 20);
            } elseif (strpos($this->selectedAge, '-') !== false) {
                list($minAge, $maxAge) = explode('-', $this->selectedAge);
                $query->whereBetween('age', [(int)$minAge, (int)$maxAge]);
            }
        }

        if ($this->selectedGrade !== null) {
            $gradeToFilter = 'Grade ' . $this->selectedGrade;
            $query->where('grade', $gradeToFilter);
        }

        if ($this->selectedAbuseType !== null) {
            $query->whereHas('abuseType', function($q) {
                $q->where('type_name', $this->selectedAbuseType);
            });
        }

        if ($this->fromDate) {
            $query->whereDate('created_at', '>=', $this->fromDate);
        }
        if ($this->toDate) {
            $query->whereDate('created_at', '<=', $this->toDate);
        }

        $this->reports = $query->get();

        // Total Reports by Status with filters applied
        $statusQuery = Report::select('status', DB::raw('count(*) as total'))
            ->when($schoolName, fn($q) => $q->where('school_name', $schoolName))
            ->whereYear('created_at', $this->selectedYear);

        
        if ($this->selectedAge !== null) {
            
        }
        if ($this->selectedGrade !== null) {
           
        }
        if ($this->selectedAbuseType !== null) {
            
        }
        if ($this->fromDate) {
            $statusQuery->whereDate('created_at', '>=', $this->fromDate);
        }
        if ($this->toDate) {
            $statusQuery->whereDate('created_at', '<=', $this->toDate);
        }

        $statusData = $statusQuery
            ->groupBy('status')
            ->orderByRaw("FIELD(status, 'pending', 'in-process', 'unresolved', 'resolved', 'false-report', 'escalated')")
            ->get();

        $totalStatusReports = $statusData->sum('total');
        $this->statusDataWithPercentage = $statusData->map(function ($item) use ($totalStatusReports) {
            $item->percentage = $totalStatusReports > 0 ? round(($item->total / $totalStatusReports) * 100, 2) : 0;
            return $item;
        });
    }

    /**
     * Helper function to standardize the grade string to a key (e.g., 'Grade 10' -> '10')
     */
    private function standardizeGradeKey(?string $gradeValue): string
    {
        $gradeValue = trim((string)($gradeValue ?? ''));
        $gradeValue = strtolower($gradeValue);

        if (preg_match('/grade\s*(\d+)/', $gradeValue, $matches)) {
            return $matches[1];
        }

        return $gradeValue;
    }

    /**
     * Mount is called once when the component is initialized.
     */
    public function mount()
    {
        $this->role = session('admin_role');
        $this->schools = School::orderBy('school_name', 'asc')->get();
        $this->currentYear = now()->year;
        $this->years = range(now()->year, now()->year + 5);

        // Default year (adjust if needed)
        $this->selectedYear = 2025;

        // Initial data loads
        $this->fetchAvailableFilters();
        $this->fetchReports();
        $this->fetchMonthlyCounts();
        $this->fetchAgeTrendData();
        $this->fetchAbuseTypeData();
        $this->fetchStatusCounts(); 
        $this->fetchAnonymityCounts(); 
    }

    /**
     * Fetches distinct grades and age groups
     */
    protected function fetchAvailableFilters()
    {
        $schoolName = Auth::check() ? Auth::user()->school_name : null;

        // Distinct Grades
        $grades = Report::when($schoolName, fn($q) => $q->where('school_name', $schoolName))
            ->whereYear('created_at', $this->selectedYear)
            ->distinct('grade')
            ->whereNotNull('grade')
            ->where('grade', '!=', '')
            ->pluck('grade')
            ->map(fn($grade) => $this->standardizeGradeKey($grade))
            ->unique()
            ->sort(SORT_NUMERIC)
            ->values()
            ->toArray();

        $this->availableGrades = $grades;
        Log::info('Available Grades List (Buttons): ' . var_export($this->availableGrades, true));


        // Distinct Ages grouped into categories
        $ages = Report::when($schoolName, fn($q) => $q->where('school_name', $schoolName))
            ->whereYear('created_at', $this->selectedYear)
            ->distinct('age')
            ->whereNotNull('age')
            ->pluck('age')
            ->toArray();

        $ageGroups = [];
        foreach ($ages as $age) {
            if ($age <= 10) $group = '<=10';
            elseif ($age <= 13) $group = '11-13';
            elseif ($age <= 16) $group = '14-16';
            elseif ($age <= 19) $group = '17-19';
            else $group = '20+';

            if (!in_array($group, $ageGroups)) {
                $ageGroups[] = $group;
            }
        }
  $order = ['<=10', '11-13', '14-16', '17-19', '20+']; 
        $sortedGroups = [];
        foreach ($order as $group) {
            if (in_array($group, $ageGroups)) {
                $sortedGroups[] = $group;
            }
        }

        $this->availableAgeGroups = $sortedGroups;
    }

    /**
     * Calculate counts for each age group and grade
     */
    protected function calculateFilterCounts()
    {
        $schoolName = Auth::check() ? Auth::user()->school_name : null;
            Log::info("Filtering counts by School: '{$schoolName}' and Year: {$this->selectedYear}");

        $baseQuery = Report::query()
            ->when($schoolName, fn($q) => $q->where('school_name', $schoolName))
            ->whereYear('created_at', $this->selectedYear);

        $reports = $baseQuery->get();

        // Age Group Counts
        $ageGroupCountsRaw = $reports->groupBy(function ($report) {
            $age = $report->age;
            if ($age <= 10) return '<=10';
            elseif ($age <= 13) return '11-13';
            elseif ($age <= 16) return '14-16';
            elseif ($age <= 19) return '17-19';
            elseif ($age >= 20) return '20+';
            return 'Other';
        })->map->count()->toArray();

        $defaultAgeCounts = array_fill_keys($this->availableAgeGroups, 0);
        $this->ageGroupCounts = array_merge($defaultAgeCounts, $ageGroupCountsRaw);

        // Grade Counts
        $dbGradeCountsRaw = (clone $baseQuery)
            ->select(DB::raw('TRIM(grade) as grade_key'), DB::raw('COUNT(*) as count'))
            ->whereNotNull('grade')
            ->where('grade', '!=', '')
            ->groupBy(DB::raw('TRIM(grade)'))
            ->pluck('count', 'grade_key')
            ->toArray();

        Log::info('RAW DB Grade Counts (Before Standardization): ' . var_export($dbGradeCountsRaw, true));

    // 2. Map the database keys ('Grade X') to the standardized keys ('X')
    $gradeGroupsRaw = [];
    foreach ($dbGradeCountsRaw as $fullGradeString => $count) {
        $standardKey = $this->standardizeGradeKey($fullGradeString);
        
        $standardKey = (string)$standardKey; 
        
        $gradeGroupsRaw[$standardKey] = ($gradeGroupsRaw[$standardKey] ?? 0) + $count; 
    }

    $defaultGradeCounts = array_fill_keys($this->availableGrades, 0); 
 
    $this->gradeCounts = $gradeGroupsRaw + $defaultGradeCounts;

    Log::info('Grade Counts (Filter Buttons): ' . var_export($this->gradeCounts, true));
}
    /**
     * Updates chart filters dynamically
     */
     #[On('updateAbuseChartFilters')]
    public function updateAbuseChartFilters($type, $value)
    {
        if ($type === 'age') {
            $this->selectedGrade = null;
            $this->selectedAge = ($this->selectedAge === $value) ? null : $value;
        } elseif ($type === 'grade') {
            $this->selectedAge = null;
            $gradeValue = $this->standardizeGradeKey($value);
            $this->selectedGrade = ($this->selectedGrade === $gradeValue) ? null : $gradeValue;
        }
        $this->fetchAgeTrendData();
        $this->fetchAbuseTypeData();
        $this->fetchStatusCounts(); 
        $this->fetchAnonymityCounts(); 
    }

    public function resetAgeFilter()
    {
        $this->selectedAge = null;
        $this->fetchAgeTrendData(); 
        $this->selectedGrade = null;
        $this->fetchAbuseTypeData();
        $this->fetchStatusCounts();
        $this->fetchAnonymityCounts(); 
    }

    public function resetGradeFilter()
    {
        $this->selectedGrade = null;
        $this->selectedAge = null;
        $this->fetchAbuseTypeData();
        $this->fetchStatusCounts();
        $this->fetchAnonymityCounts(); 
    }

      protected function fetchAgeTrendData()
  {
    $schoolName = Auth::check() ? Auth::user()->school_name : null;
    $currentYear = $this->selectedYear ?? now()->year;
    $query = Report::query()
     ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(id) as count'))
      ->when($schoolName, fn($q) => $q->where('school_name', $schoolName))
      ->whereYear('created_at', $currentYear);
      if ($this->selectedAge !== null) {
        if ($this->selectedAge === '<=10') {
            $query->where('age', '<=', 10);
        } elseif ($this->selectedAge === '20+') {
            $query->where('age', '>=', 20);
        } elseif (strpos($this->selectedAge, '-') !== false) {
            list($minAge, $maxAge) = explode('-', $this->selectedAge);
            $query->whereBetween('age', [(int)$minAge, (int)$maxAge]);
        }
    }
    
    $monthlyData = $query
    ->groupBy('month')
    ->orderBy('month', 'asc')
    ->pluck('count', 'month')
    ->toArray();
    $fullTrendData = [];
    for ($i = 1; $i <= 12; $i++)
        {
        $monthName = Carbon::create(null, $i, 1)->format('M');
        $fullTrendData[$monthName . ' ' . $currentYear] = $monthlyData[$i] ?? 0;
        }
        $this->ageTrendData = $fullTrendData;
        Log::info('Age Trend Data: ' . var_export($this->ageTrendData, true));
  }


    /**
     * Fetch monthly counts placeholder
     */
    protected function fetchMonthlyCounts()
    {
        $this->months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $this->monthlyCounts = array_fill(0, 12, 0);
    }

    /**
     * ✅ Fetch counts of reports by status
     */
    protected function fetchStatusCounts()
    {
        $schoolName = Auth::check() ? Auth::user()->school_name : null;

        $baseQuery = Report::query()
            ->when($schoolName, fn($q) => $q->where('school_name', $schoolName))
            ->whereYear('created_at', $this->selectedYear);

        $this->escalatedCount = Report::where('status', 'escalated')->where('school_name', $schoolName)->count();
        $this->falseCount = Report::where('status', 'false')->where('school_name', $schoolName)->count();
        $this->inProcessCount = Report::where('status', 'in-process')->where('school_name', $schoolName)->count();
        $this->pendingCount = Report::where('status', 'pending')->where('school_name', $schoolName)->count();
        $this->unresolvedCount = Report::where('status', 'unresolved')->where('school_name', $schoolName)->count();
        $this->resolvedCount = Report::where('status', 'resolved')->where('school_name', $schoolName)->count();
        $this->totalCount = Report::where('school_name', $schoolName)->count();
    }
    
 protected function fetchAnonymityCounts()
{
    $schoolName = Auth::check() ? Auth::user()->school_name : null;

    $baseQuery = Report::query()
        ->when($schoolName, fn($q) => $q->where('school_name', $schoolName))
        ->whereYear('created_at', $this->selectedYear);

    // Filter by Age/Grade if selected (matching fetchAbuseTypeData logic)
    if ($this->selectedAge !== null) {
        if ($this->selectedAge === '<=10') {
            $baseQuery->where('age', '<=', 10);
        } elseif ($this->selectedAge === '20+') {
            $baseQuery->where('age', '>=', 20);
        } elseif (strpos($this->selectedAge, '-') !== false) {
            list($minAge, $maxAge) = explode('-', $this->selectedAge);
            $baseQuery->whereBetween('age', [(int)$minAge, (int)$maxAge]);
        }
    }

    if ($this->selectedGrade !== null) {
        $gradeToFilter = 'Grade ' . $this->selectedGrade;
        $baseQuery->where('grade', $gradeToFilter);
    }

    $this->anonymousCount = (clone $baseQuery)->where('is_anonymous', true)->count();
    $this->nonAnonymousCount = (clone $baseQuery)->where('is_anonymous', false)->count();
}


    /**
     * Render the Livewire component
     */
    public function render()
    {
        return view('livewire.admin-home', [
            'months' => $this->months,
            'monthlyCounts' => $this->monthlyCounts,
            'reports' => $this->reports,
            'abuseTypeLabels' => $this->abuseTypeLabels,
            'abuseTypeCounts' => $this->abuseTypeCounts,
            'abuseTypePercentages' => $this->abuseTypePercentages,
            'schools' => $this->schools,
            'availableAgeGroups' => $this->availableAgeGroups,
            'availableGrades' => $this->availableGrades,
            'ageGroupCounts' => $this->ageGroupCounts,
            'gradeCounts' => $this->gradeCounts,
            'selectedAge' => $this->selectedAge,
            'selectedGrade' => $this->selectedGrade,

            // ✅ Pass counts by status
            'escalatedCount' => $this->escalatedCount,
            'falseCount' => $this->falseCount,
            'inProcessCount' => $this->inProcessCount,
            'pendingCount' => $this->pendingCount,
            'unresolvedCount' => $this->unresolvedCount,
            'resolvedCount' => $this->resolvedCount,
            'totalCount' => $this->totalCount,
             // Pass Anonymity Counts (NEW)
           'anonymousCount' => $this->anonymousCount, // <--- ADD THIS LINE
           'nonAnonymousCount' => $this->nonAnonymousCount, // <--- ADD THIS LINE
            
            
           
    'statusData' => $this->statusDataWithPercentage,

        ]);
    }
}
