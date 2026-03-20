<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Report;
use App\Models\Province;
use Illuminate\Support\Facades\Auth;

class ProvincialReport extends Component
{
    public $province;
    public $province_id;
    public $searchCase = '';
    
    public $fromDate = '';
    public $toDate = '';
    public $filter = 'all';

    public $reports = [];
   

    public function mount($filter = 'all')
    {
        
        $user = Auth::user();

        if (!$user || $user->role !== 'provincial') {
            abort(403, 'Unauthorized');
        }

        $this->province_id = $user->province_id;
        $provinceModel = Province::find($this->province_id);
        $this->province = $provinceModel->province_name ?? 'Unknown';
        
        $this->filter = $filter;
        $this->loadReports();
    }

    public function updatedFromDate()
    {
        $this->loadReports();
    }

    public function updatedToDate()
    {
        $this->loadReports();
    }

    public function loadReports()
    {
        $query = Report::with(['abuseType', 'school'])
            ->whereHas('school', function($q) {
                $q->where('province_id', $this->province_id);
            });
        
            // Filter by report status if selected
        if ($this->filter !== 'all') {
            $query->where('status', $this->filter);
        }

        // Filter by date 
        if ($this->fromDate) {
            $query->whereDate('created_at', '>=', $this->fromDate);
        }

        if ($this->toDate) {
            $query->whereDate('created_at', '<=', $this->toDate);
        }

        $this->reports = $query->orderBy('created_at', 'desc')->get();
    }

    public function resetSearch()
    {
        $this->searchCase = '';
        $this->fromDate = '';
        $this->toDate = '';
        $this->loadReports();
    }

    public function searchReport()
    {
        $query = Report::with(['abuseType', 'school'])
            ->whereHas('school', function($q) {
                $q->where('province_id', $this->province_id);
            });

        if (!empty($this->searchCase)) {
            $query->where('case_number', 'like', '%' . $this->searchCase . '%');
        }

        // Apply date filters if any
        if ($this->fromDate) {
            $query->whereDate('created_at', '>=', $this->fromDate);
        }

        if ($this->toDate) {
            $query->whereDate('created_at', '<=', $this->toDate);
        }

        $this->reports = $query->orderBy('created_at', 'desc')->get();
    }

    public function render()
    {
        return view('livewire.provincial-report', [
            'reports' => $this->reports,
            'filter' => $this->filter,
        ]);
    }
}
