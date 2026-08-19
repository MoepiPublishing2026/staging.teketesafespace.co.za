<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Report;
use App\Models\Province;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProvincialReport extends Component
{
    public $province;
    public $province_id;
    public $searchCase = '';
    public $fromDate   = '';
    public $toDate     = '';
    public $filter     = 'all';
    public $reports    = [];

    public function mount($filter = 'all')
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'provincial') {
            abort(403, 'Unauthorized');
        }

        $this->province_id = $user->province_id;
        $provinceModel     = Province::find($this->province_id);
        $this->province    = $provinceModel->province_name ?? 'Unknown';
        $this->filter      = $filter;

        $this->loadReports();
    }

    public function updatedFromDate() { $this->loadReports(); }
    public function updatedToDate()   { $this->loadReports(); }

    public function loadReports()
    {
        $query = Report::with(['abuseType', 'school'])
            ->whereHas('school', fn($q) => $q->where('province_id', $this->province_id));

        if ($this->filter !== 'all') {
            $query->whereCanonicalDashboardStatus($this->filter);
        }

        if (!empty($this->searchCase)) {
            $query->where('case_number', 'like', '%' . $this->searchCase . '%');
        }

        if ($this->fromDate) {
            $query->where('created_at', '>=', Carbon::parse($this->fromDate)->startOfDay());
        }

        if ($this->toDate) {
            $query->where('created_at', '<=', Carbon::parse($this->toDate)->endOfDay());
        }

        $this->reports = $query->orderByDesc('created_at')->get();
    }

    public function searchReport()
    {
        $this->loadReports();
    }

    public function resetSearch()
    {
        $this->searchCase = '';
        $this->fromDate   = '';
        $this->toDate     = '';
        $this->loadReports();
    }

    public function render()
    {
        return view('livewire.provincial-report', [
            'reports' => $this->reports,
            'filter'  => $this->filter,
        ])->layout('components.layouts.app', ['title' => 'Reports | Tekete SafeSpace']);
    }
}