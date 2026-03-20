<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Report;
use App\Models\Province;
use App\Models\District;
use App\Models\School;
use App\Models\AbuseType;

class NationalAdminDashboard extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Tabs & Filters
    public $activeTab = 'overview';

    public $provinceFilter = null;
    public $districtFilter = null;
    public $abuseTypeFilter = null;
    public $townCityFilter = null;
    public $schoolFilter = null;

    // Collections used for filters
    public $provinces = [];
    public $districts = []; // only districts of selected province
    public $townCities = [];
    public $schools = [];
    public $abuseTypes = [];

    // Dashboard data
    public $summaryCounts = [];
    public $showModal = false;
    public $modalStatus = null;
    public $statusReports = [];
    public $selectedReport = null;
    public $anyFilterActive = false;


    public function mount()
    {
        $this->loadDropdownData();
        $this->updateDashboardData();
    }


    public function updatedProvinceFilter($provinceId)
    {
        $this->districtFilter = null; // reset district when province changes
        $this->loadDistricts($provinceId);
        $this->resetPage();
        $this->updateDashboardData();
    }

    public function updatedDistrictFilter()
    {
        $this->resetPage();
        $this->updateDashboardData();
    }

    public function updatedAbuseTypeFilter()
    {
        $this->resetPage();
        $this->updateDashboardData();
    }

    public function updatedTownCityFilter()
    {
        $this->resetPage();
        $this->updateDashboardData();
    }

    public function updatedSchoolFilter()
    {
        $this->resetPage();
        $this->updateDashboardData();
    }

    protected function loadDropdownData()
    {
        // Load provinces for filter
        $this->provinces = Province::orderBy('province_name')
            ->get(['province_id', 'province_name'])
            ->map(fn($p) => ['id' => $p->province_id, 'name' => $p->province_name])
            ->toArray();

        // Districts empty initially, load on province selection
        $this->districts = [];

        $this->townCities = School::select('towncity')
            ->distinct()
            ->orderBy('towncity')
            ->pluck('towncity')
            ->filter()
            ->values()
            ->toArray();

        $this->schools = School::orderBy('school_name')->get();

        $this->abuseTypes = AbuseType::orderBy('type_name')->get();
    }

    protected function loadDistricts($provinceId = null)
    {
        if ($provinceId) {
            $this->districts = District::where('province_id', $provinceId)
                ->orderBy('district_name')
                ->get(['district_id', 'district_name'])
                ->map(fn($d) => ['id' => $d->district_id, 'name' => $d->district_name])
                ->toArray();
        } else {
            $this->districts = [];
        }
    }

    protected function determineFiltersActive(): bool
    {
        return match ($this->activeTab) {
            'overview' => (bool)($this->provinceFilter || $this->districtFilter),
            'analysis' => (bool)($this->abuseTypeFilter || $this->townCityFilter || $this->schoolFilter),
            default => false,
        };
    }

    protected function applyFilters(&$query)
    {
        if ($this->activeTab === 'overview') {
            if ($this->provinceFilter) {
                $query->where('province_id', $this->provinceFilter);
            }
            if ($this->districtFilter) {
                $query->where('district_id', $this->districtFilter);
            }
        }

        if ($this->activeTab === 'analysis') {
            if ($this->abuseTypeFilter) {
                $query->where('abuse_type_id', $this->abuseTypeFilter);
            }
            if ($this->townCityFilter) {
                $query->where('location', $this->townCityFilter);
            }
            if ($this->schoolFilter) {
                $query->where('school_id', $this->schoolFilter);
            }
        }
    }

    public function fetchSummaryCounts(): void
    {
        $statuses = ['awaiting-resolution', 'under-review', 'forwarded', 'closed', 'unresolved', 'false-report', 'anonymous', 'identified'];
        $counts = [];

        foreach ($statuses as $status) {
            $query = Report::where('status', $status);
            $this->applyFilters($query);
            $counts[$status] = $query->count();
        }

        $totalQuery = Report::query();
        $this->applyFilters($totalQuery);
        $counts['total'] = $totalQuery->count();

        $this->summaryCounts = $counts;
    }

    protected function getOverviewAbuseTypeData()
    {
        $query = Report::selectRaw('abuse_type_id, count(*) as total')
            ->with('abuseType:id,type_name');

        $this->applyFilters($query);

        $results = $query->groupBy('abuse_type_id')->get();

        return $results->mapWithKeys(fn($item) => [$item->abuseType->type_name => $item->total])->toArray();
    }

    protected function getAnalysisPieChartData()
    {
        $query = Report::selectRaw('abuse_type_id, count(*) as total')
            ->with('abuseType:id,type_name');

        $this->applyFilters($query);

        $results = $query->groupBy('abuse_type_id')->get();

        return $results->mapWithKeys(fn($item) => [$item->abuseType->type_name => $item->total])->toArray();
    }

    protected function getAnalysisPyramidChartData()
    {
        $query = Report::selectRaw('status, count(*) as total');

        $this->applyFilters($query);

        $results = $query->groupBy('status')->get();

        return $results->pluck('total', 'status')->toArray();
    }

    protected function getSchoolChartData()
    {
        if (empty($this->statusReports)) {
            return [];
        }

        return collect($this->statusReports)
            ->groupBy(fn($r) => optional($r->school)->school_name ?? 'Unknown')
            ->map(fn($g) => $g->count())
            ->sortDesc()
            ->take(10)
            ->toArray();
    }

    public function updateDashboardData()
    {
        $this->anyFilterActive = $this->determineFiltersActive();

        $this->fetchSummaryCounts();

        $query = Report::with('school')->orderByDesc('created_at');
        $this->applyFilters($query);
        $this->statusReports = $query->take(100)->get();

        if ($this->activeTab === 'overview') {
            $abuseTypeChartData = $this->getOverviewAbuseTypeData();
            $schoolChartData = $this->getSchoolChartData();
        } elseif ($this->activeTab === 'analysis') {
            $abuseTypeChartData = $this->getAnalysisPieChartData();
            $schoolChartData = $this->getAnalysisPyramidChartData();
        } else {
            $abuseTypeChartData = [];
            $schoolChartData = [];
        }

        $this->dispatch('refreshCharts', $abuseTypeChartData, $schoolChartData);
    }

    public function showStatusReports($status = null): void
    {
        $this->modalStatus = $status;

        $query = Report::query();

        if ($status) {
            $query->where('status', $status);
        }

        $this->applyFilters($query);

        $this->statusReports = $query->with(['abuseType', 'province', 'district', 'school'])
            ->orderByDesc('created_at')->get();

        $this->showModal = true;
        $this->selectedReport = null;

        if ($this->activeTab === 'overview') {
            $abuseTypeChartData = $this->getOverviewAbuseTypeData();
            $schoolChartData = $this->getSchoolChartData();
        } elseif ($this->activeTab === 'analysis') {
            $abuseTypeChartData = $this->getAnalysisPieChartData();
            $schoolChartData = $this->getAnalysisPyramidChartData();
        } else {
            $abuseTypeChartData = [];
            $schoolChartData = [];
        }

        $this->dispatch('refreshCharts', $abuseTypeChartData, $schoolChartData);
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->statusReports = [];
        $this->selectedReport = null;
    }

    public function showReportDetails($reportId): void
    {
        $this->selectedReport = Report::with(['abuseType', 'province', 'district', 'school'])->find($reportId);
    }

    public function closeReportDetails(): void
    {
        $this->selectedReport = null;
    }

    public function switchTab($tab): void
    {
        $allowedTabs = ['overview', 'analysis'];
        $this->activeTab = in_array($tab, $allowedTabs) ? $tab : 'overview';
        $this->resetPage();
        $this->updateDashboardData();
    }

    public function render()
    {
        if ($this->anyFilterActive) {
            $query = Report::with(['abuseType', 'province', 'district', 'school'])->orderByDesc('created_at');
            $this->applyFilters($query);
            $filteredReports = $query->paginate(12);
        } else {
            $filteredReports = collect();
        }

        if ($this->activeTab === 'overview') {
            $abuseTypeChartData = $this->getOverviewAbuseTypeData();
            $schoolChartData = $this->getSchoolChartData();
        } elseif ($this->activeTab === 'analysis') {
            $abuseTypeChartData = $this->getAnalysisPieChartData();
            $schoolChartData = $this->getAnalysisPyramidChartData();
        } else {
            $abuseTypeChartData = [];
            $schoolChartData = [];
        }

        return view('livewire.national-admin-dashboard', [
            'filteredReports' => $filteredReports,
            'summaryCounts' => $this->summaryCounts,
            'provinces' => $this->provinces,
            'districts' => $this->districts,
            'townCities' => $this->townCities,
            'schools' => $this->schools,
            'abuseTypes' => $this->abuseTypes,
            'showModal' => $this->showModal,
            'modalStatus' => $this->modalStatus,
            'statusReports' => $this->statusReports,
            'selectedReport' => $this->selectedReport,
            'anyFilterActive' => $this->anyFilterActive,
            'activeTab' => $this->activeTab,
            'abuseTypeChartData' => $abuseTypeChartData,
            'schoolChartData' => $schoolChartData,
        ]);
    }
}
