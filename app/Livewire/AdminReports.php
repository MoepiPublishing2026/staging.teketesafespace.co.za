<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Report;
use App\Models\AbuseType;
use App\Models\Subtype;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\ReportStatusChangedNotification;
use App\Mail\ReporterBlockedNotification;
use App\Notifications\CaseStatusChanged;

class AdminReports extends Component
{
    use WithPagination;

    public $filter = 'all';
    public $selectedReport = null;
    public $modalImage = null;

    // Reason modal
    public $showReasonModal = false;
    public $statusChangeReason = '';
    public $reportToUpdate = null;
    public $newStatus = '';

    // Properties for the Flagging display
    public $adminName = '';
    public $timestamp = '';
    public $falseReportsCount = 0;

    // Search & filter properties
    public $search         = '';
    public $filterName     = '';
    public $filterGrade    = '';
    public $filterDateFrom = '';
    public $filterDateTo   = '';
    public $filterType     = '';
    public $filterSubtype  = '';
    public $filterStatus   = '';
    public $filterAnonymous = '';

    // Reset pagination whenever a filter changes
    public function updatingSearch():         void { $this->resetPage(); }
    public function updatingFilterName():     void { $this->resetPage(); }
    public function updatingFilterGrade():    void { $this->resetPage(); }
    public function updatingFilterDateFrom(): void { $this->resetPage(); }
    public function updatingFilterDateTo():   void { $this->resetPage(); }
    public function updatingFilterType():     void { $this->resetPage(); }
    public function updatingFilterSubtype():  void { $this->resetPage(); }
    public function updatingFilterStatus():   void { $this->resetPage(); }

    public function mount($filter = 'all')
    {
        $this->filter = $filter;
    }
    public function updatingFilterAnonymous(): void {
        $this->resetPage();
        
        
    }
    // Clear all filters
    public function clearFilters(): void
    {
        $this->search         = '';
        $this->filterName     = '';
        $this->filterGrade    = '';
        $this->filterDateFrom = '';
        $this->filterDateTo   = '';
        $this->filterType     = '';
        $this->filterSubtype  = '';
        $this->filterStatus   = '';
        $this->filterAnonymous = '';
        $this->resetPage();
    }

    // Step 1: Prompt admin to give a reason before changing status
    public function promptForStatusUpdate($reportId, $newStatus)
    {
        $user   = Auth::user();
        $report = Report::findOrFail($reportId);

        if ($user->role === 'school' && $report->school_name !== $user->school_name) {
            session()->flash('error_message', 'You do not have permission to update this report.');
            return;
        }

        $this->reportToUpdate  = $report;
        $this->newStatus       = $newStatus;
        $this->adminName       = $user->name;
        $this->timestamp       = now()->format('F d, Y H:i');
        $this->showReasonModal = true;
    }

    // Step 2: Cancel modal
    public function cancelUpdate()
    {
        $this->showReasonModal    = false;
        $this->statusChangeReason = '';
    }

    // Step 3: Finalize status change with reason
    public function finalizeStatusUpdate()
    {
        $this->validate([
            'statusChangeReason' => 'required|string|max:500|min:10',
        ], [
            'statusChangeReason.required' => 'You must provide a reason for this status change.',
            'statusChangeReason.min'      => 'Please provide a more detailed justification (at least 10 characters).',
        ]);

        if ($this->reportToUpdate) {
            $user   = Auth::user();
            $report = $this->reportToUpdate;

            if ($user->role === 'school' && $report->school_name !== $user->school_name) {
                session()->flash('error_message', 'Unauthorized action.');
                $this->showReasonModal = false;
                return;
            }

            $report->status               = $this->newStatus;
            $report->latest_status_reason = $this->statusChangeReason;
            $report->save();
            
             $report->refresh();

            // 2nd Strike Logic
           // 3. SUSPENSION LOGIC (Strict 2-Strike Rule)
       // 2. Strict 2nd Strike Logic
       // 2-Strike Logic across Email, Phone, or Name
  if ($this->newStatus === 'false-report') {
    $falseCount = Report::where('status', 'false-report')
        ->where(function($query) use ($report) {
            if (!empty($report->reporter_email)) {
                $query->where('reporter_email', $report->reporter_email);
            } elseif (!empty($report->phone_number)) {
                $query->where('phone_number', $report->phone_number);
            } elseif (!empty($report->full_name)) {
                $query->where('full_name', $report->full_name);
            } else {
                $query->whereRaw('1 = 0');
            }
        })->count();

    if ($falseCount >= 2) {
        // Apply suspension to the specific identity found
        Report::where(function($query) use ($report) {
            if (!empty($report->reporter_email)) $query->where('reporter_email', $report->reporter_email);
            elseif (!empty($report->phone_number)) $query->where('phone_number', $report->phone_number);
            elseif (!empty($report->full_name)) $query->where('full_name', $report->full_name);
        })->update(['suspended_until' => now()->addDays(90)]);
        
        $report->refresh(); 
    }
}


            // Notify reporter by email
            if ($report->reporter_email && $report->reporter_email !== $user->email) {
                try {
                    Mail::to($report->reporter_email)->send(
                        new ReportStatusChangedNotification($report, $this->statusChangeReason)
                    );
                } catch (\Exception $e) {
                    \Log::error('Failed to send status update email: ' . $e->getMessage());
                }
            }

            // In-app notification
            if ($report->user && $report->user->id !== $user->id) {
                try {
                    $report->user->notify(new CaseStatusChanged($report));
                } catch (\Exception $e) {
                    \Log::error('Failed to send in-app status notification: ' . $e->getMessage());
                }
            }

            $this->showReasonModal = false;
        $this->statusChangeReason = '';

        // Determine the success message
        $msg = 'Status updated successfully. Reporter notified.';

        if ($this->newStatus === 'false-report') {
            if ($report->suspended_until) {
                // If the year is 2037 or later, it's a permanent block
                $isPermanent = $report->suspended_until->year >= 2037;
                
                $msg = $isPermanent 
                    ? 'Reporter is permanently blocked (linked identifiers found).' 
                    : 'Reporter has been suspended for 90 days.';
            } else {
                $msg = 'Report marked as false.';
            }
        }

        session()->flash('success_message', $msg);

        // Refresh selected report if its detail view is open
        if ($this->selectedReport && $this->selectedReport->id === $report->id) {
            $this->selectedReport = Report::with(['abuseType', 'subtype', 'user'])->find($report->id);
        }
    } // End of finalizeStatusUpdate
    }


    // Show report detail modal
    public function showReport($reportId)
    {
        $user   = Auth::user();
        $report = Report::with(['abuseType', 'subtype', 'user'])->find($reportId);

        if ($user->role === 'school' && $report && $report->school_name !== $user->school_name) {
            session()->flash('error_message', 'You do not have permission to view this report.');
            return;
        }

        $this->selectedReport = $report;

        if ($report) {
    $this->falseReportsCount = Report::where('status', 'false-report')
        ->where(function($query) use ($report) {
            // 1. Priority: If they have an email, only count by that email
            if (!empty($report->reporter_email)) {
                $query->where('reporter_email', trim(strtolower($report->reporter_email)));
            } 
            // 2. Fallback: If no email, check phone number
            elseif (!empty($report->phone_number)) {
                $query->where('phone_number', trim($report->phone_number));
            }
            // 3. Last Resort: Check name only if email and phone are missing
            elseif (!empty($report->full_name)) {
                $query->where('full_name', trim($report->full_name));
            } 
            // 4. Safety: Force 0 count if no identifiers exist
            else {
                $query->whereRaw('1 = 0');
            }
        })
        ->count();
} else {
    $this->falseReportsCount = 0;
}
    }

    // Permanent block
    public function permanentBlock($email)
    {
        if (! $email) {
            session()->flash('error_message', 'No email address found.');
            return;
        }

        if (! in_array(Auth::user()->role, ['admin', 'school'])) {
            session()->flash('error_message', 'Unauthorized action.');
            return;
        }

       $report = \App\Models\Report::where('reporter_email', $email)->first();

    if (!$report) {
        session()->flash('error_message', 'Could not find a report record for this email.');
        return;
    }
    
    $permanentDate = \Carbon\Carbon::create(2037, 12, 31, 23, 59, 59);

    \App\Models\Report::where(function($query) use ($report) {
        if ($report->reporter_email) $query->where('reporter_email', $report->reporter_email);
        if ($report->phone_number) $query->orWhere('phone_number', $report->phone_number);
        if ($report->full_name) $query->orWhere('full_name', $report->full_name);
        })
    ->update([
        'suspended_until' => $permanentDate,
        'blocked_by_id'   => auth()->id(),
        'blocked_by_name' => auth()->user()->name,
        'blocked_at'      => now(),
    ]);

    // --- EMAIL NOTIFICATION START ---
    // ... after the database update code ...

    $report->refresh(); 

    if ($report->reporter_email) {
        try {
            // Using the new specialized Mail class
            Mail::to($report->reporter_email)->send(
                new ReporterBlockedNotification($report, true)
            );
        } catch (\Exception $e) {
            \Log::error('Failed to send block email: ' . $e->getMessage());
        }
    }

    session()->flash('success_message', "Reporter has been permanently blocked and notified via email.");
    
    $this->selectedReport = null; 

}

    public function closeReport()
    {
        $this->selectedReport = null;
    }

    public function showImage($path)
    {
        $this->modalImage = $path;
    }

    public function closeImage()
    {
        $this->modalImage = null;
    }

    public function render()
    {
        $user = Auth::user();

        // Reports query — rebuilt fresh every render so all filters always apply
        $query = Report::with(['abuseType', 'subtype', 'user']);

        // Restrict school admins to their own school
        if ($user && $user->role === 'school') {
            $query->where('school_name', $user->school_name);
        }

        // Sidebar status tab filter
        if ($this->filter !== 'all') {
            $query->where('status', $this->filter);
        }
        
        
        if ($this->filterAnonymous !== '') {
            $query->where('is_anonymous', (int) $this->filterAnonymous);
        }

        // Global search bar
        if (trim($this->search) !== '') {
            $s = trim($this->search);
            $query->where(function ($q) use ($s) {
                $q->where('case_number',      'like', "%{$s}%")
                  ->orWhere('reporter_email', 'like', "%{$s}%")
                  ->orWhere('full_name',      'like', "%{$s}%")
                  ->orWhere('description',    'like', "%{$s}%");
            });
        }

        // Name / surname filter
        if (trim($this->filterName) !== '') {
            $n = trim($this->filterName);
            $query->where(function ($q) use ($n) {
                $q->where('full_name',        'like', "%{$n}%")
                  ->orWhere('reporter_email', 'like', "%{$n}%");
            });
        }

        // Grade filter
        if ($this->filterGrade !== '') {
            $query->where('grade', $this->filterGrade);
        }

        // Date range filter
        if ($this->filterDateFrom !== '') {
            $query->whereDate('created_at', '>=', $this->filterDateFrom);
        }
        if ($this->filterDateTo !== '') {
            $query->whereDate('created_at', '<=', $this->filterDateTo);
        }

        // Report type filter
        if ($this->filterType !== '') {
            $query->where('abuse_type_id', $this->filterType);
        }

        // Subtype filter
        if ($this->filterSubtype !== '') {
            $query->where('subtype_id', $this->filterSubtype);
        }

        // Status dropdown filter (only when sidebar tab is not already filtering)
        if ($this->filterStatus !== '' && $this->filter === 'all') {
            $query->where('status', $this->filterStatus);
        }

        $reports = $query->latest()->paginate(15);

        // Dropdown options
        $typeOptions = AbuseType::orderBy('type_name')->get();
        
        $subtypeQuery = Subtype::orderByRaw("CASE WHEN sub_type_name = 'Other' THEN 1 ELSE 0 END")
            ->orderBy('sub_type_name');
        
        if ($this->filterType !== '') {
            $subtypeQuery->where('abuse_type_id', $this->filterType);
        }
        
        $subtypeOptions = $subtypeQuery->get()->unique('sub_type_name')->values();

        $gradeQuery = Report::whereNotNull('grade')->where('grade', '!=', '');
        if ($user && $user->role === 'school') {
            $gradeQuery->where('school_name', $user->school_name);
        }
        $gradeOptions = $gradeQuery->distinct()->pluck('grade')->sort(function ($a, $b) {
            $order = [
                'Creche'  => 0,
                'Grade R'   => 1,
                'Grade 1'  => 2,
                'Grade 2'  => 3,
                'Grade 3'  => 4,
                'Grade 4'  => 5,
                'Grade 5'  => 6,
                'Grade 6'  => 7,
                'Grade 7'  => 8,
                'Grade 8'  => 9,
                'Grade 9'  => 10,
                'Grade 10' => 11,
                'Grade 11' => 12,
                'Grade 12' => 13,
            ];
            $aVal = $order[$a] ?? 99;
            $bVal = $order[$b] ?? 99;
            return $aVal <=> $bVal;
        })->values()->toArray();

        return view('livewire.admin-reports', [
            'reports'        => $reports,
            'filter'         => $this->filter,
            'typeOptions'    => $typeOptions,
            'subtypeOptions' => $subtypeOptions,
            'gradeOptions'   => $gradeOptions,
        ])->layout('components.layouts.school-admin', ['title' => 'Reports | Tekete SafeSpace']);
    }
}