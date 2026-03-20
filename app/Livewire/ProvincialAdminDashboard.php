<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;
use App\Models\School;
use App\Models\District;
use App\Models\Province;
use App\Models\AbuseType;
use Carbon\Carbon;

class ProvincialAdminDashboard extends Component
{
    public $province_id;
    public $province;
    public $schools = [];
    public $districts = [];

    public $selectedSchool = '';
    public $selectedDistrict = '';
    public $fromDate = '';
    public $toDate = '';

    public $reports = [];
    public $months = [];
    public $monthlyCounts = [];
    public $abuseTypes = [];
    public $ageGroups = [];
    public $totalReports = 0;
    public $statusCounts = [];
    public $anonymousCounts = [];

    public function mount()
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'provincial') {
            abort(403, 'Unauthorized');
        }

        // set province 
        $this->province_id = $user->province_id;
        $provinceModel = Province::find($this->province_id);
        $this->province = $provinceModel->province_name ?? 'Unknown ';

        // Load dependent dropdowns
        $this->loadDistricts();
        $this->loadSchools();

        // Load dashboard data initially
        $this->loadDashboardData();
        $this->reports;
    }

    private function loadDistricts()
    {
        $this->districts = District::where('province_id', $this->province_id)
            ->orderBy('district_name')
            ->pluck('district_name', 'district_id')
            ->toArray();
    }

    private function loadSchools()
    {
        $query = School::where('province_id', $this->province_id);

        if ($this->selectedDistrict) {
            $query->where('district_id', $this->selectedDistrict);
        }

        $this->schools = $query->orderBy('school_name')
            ->pluck('school_name', 'school_id')
            ->toArray();
    }

    
    public function updatedSelectedDistrict()
    {
        $this->selectedSchool = '';
        $this->loadSchools();
        $this->loadDashboardData();
    }

    public function updatedSelectedSchool($value)
    {
        
        $this->loadDashboardData();
    }

    public function updatedFromDate()
    {
        $this->loadDashboardData();
    }

    public function updatedToDate()
    {
        $this->loadDashboardData();
    }

    
    public function resetFilters()
    {
        $this->reset(['selectedDistrict', 'selectedSchool', 'fromDate', 'toDate',]);
        $this->loadDistricts();
        $this->loadSchools();
        $this->loadDashboardData();
    }


    public function loadDashboardData()
    {
        $query = Report::with(['abuseType', 'subtype'])
            ->where('province_id', $this->province_id);

        if ($this->selectedDistrict) {
            $query->where('district_id', $this->selectedDistrict);
        }

        if ($this->selectedSchool) {
            $query->where('school_id', $this->selectedSchool);
        }

        if ($this->fromDate) {
            $query->whereDate('created_at', '>=', $this->fromDate);
        }

        if ($this->toDate) {
            $query->whereDate('created_at', '<=', $this->toDate);
        }

        $this->reports = $query->get();
        $this->totalReports = $this->reports->count();

        $statuses = ['awaiting-resolution', 'forwarded', 'under-review', 'unresolved', 'closed', 'false-report'];
        foreach ($statuses as $status) {
            $this->statusCounts[$status] = $this->reports->where('status', $status)->count();
        }

        $this->loadMonthlyReportData();
        $this->loadAbuseTypeData();
       $this->loadAgeGroupsData();
        $this->loadAnonymousData();
       $this->loadAbuseSubtypesData();

       
    }

    private function loadMonthlyReportData()
    {
        
        $monthlyGroups = $this->reports->groupBy(fn($r) => Carbon::parse($r->created_at)->format('M'));

        $monthNames = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        $this->months = $monthNames;

        $this->monthlyCounts = array_map(fn($m) =>
            isset($monthlyGroups[$m]) ? $monthlyGroups[$m]->count() : 0, $monthNames
        );
    }

    private function loadAbuseTypeData()
    {
        $types = AbuseType::pluck('type_name')->toArray();
        $counts = [];

        foreach ($types as $type) {
            $counts[] = $this->reports->filter(fn($r) =>
                $r->abuseType && strtolower($r->abuseType->type_name) === strtolower($type)
            )->count();
        }

        $this->abuseTypes = array_combine($types, $counts);
    }

    private function loadAgeGroupsData()
    {
        $ranges = [
            '10-15'=>0,'15-20'=>0,'20-25'=>0,'25-30'=>0,'30-35'=>0,
            '35-40'=>0,'40-45'=>0,'45-50'=>0,'50-55'=>0,'55-60'=>0,'60+'=>0
        ];

        foreach ($this->reports as $r) {
            if (!$r->age) continue;
            $age = (int)$r->age;

            foreach ($ranges as $range => &$count) {
                if ($range === '60+' && $age >= 60) {
                    $count++;
                    break;
                }
                if (strpos($range, '-') !== false) {
                    [$min, $max] = explode('-', $range);
                    if ($age >= (int)$min && $age < (int)$max) {
                        $count++;
                        break;
                    }
                }
            }
        }

        $this->ageGroups = $ranges;
    }

    private function loadAnonymousData()
    {
        $this->anonymousCounts = [
            'anonymous' => $this->reports->where('is_anonymous', 1)->count(),
            'non_anonymous' => $this->reports->where('is_anonymous', 0)->count(),
        ];
    }

    private function loadAbuseSubtypesData()
    {
        $this->abuseTypes = [];

        foreach ($this->reports as $r) {
            $type = $r->abuseType->type_name ?? 'Unknown';
            $sub = $r->subtype->sub_type_name ?? 'No Subtype';
            $this->abuseTypes[$type][$sub] = ($this->abuseTypes[$type][$sub] ?? 0) + 1;
        }
    }

    public function render()
    {
        return view('livewire.provincial-admin-dashboard', [
            'province' => $this->province,
            'districts' => $this->districts,
            'schools' => $this->schools,
            'reports' => $this->reports,
            'months' => $this->months,
            'monthlyCounts' => $this->monthlyCounts,
            'ageGroups' => $this->ageGroups,
            'abuseTypes' => $this->abuseTypes,
            'statusCounts' => $this->statusCounts,
            'totalReports' => $this->totalReports,
            'anonymousCounts' => $this->anonymousCounts,
        ]);
    }
}
