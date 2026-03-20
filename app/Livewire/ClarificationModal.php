<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReportUpdatedMail;

class ClarificationModal extends Component
{
    public $caseNumber;
    public $report;
    public $clarificationText;
    public $showSuccess = false;

    public function mount($caseNumber)
    {
        $this->caseNumber = $caseNumber;
        // Find report or fail with 404
        $this->report = Report::where('case_number', $caseNumber)->firstOrFail();
    }

public function submitClarification()
{
    // 1. Validate the input
    $this->validate([
        'clarificationText' => 'required|string|min:20|max:2000',
    ]);

    // 2. Update the database
    $this->report->update([
        'reporter_clarification' => $this->clarificationText,
        'status' => 'under-review', 
    ]);

    // 3. Identify all relevant Admins
    // Get School-level admins
    $schoolAdmins = User::where('role', 'school')
        ->where('school_name', $this->report->school_name)
        ->pluck('email')
        ->toArray();

    // Get Super Admins (The main system users)
    $superAdmins = User::where('role', 'admin')->pluck('email')->toArray();

    // Combine into one unique list
    $allAdmins = array_unique(array_merge($schoolAdmins, $superAdmins));

    // 4. Send the emails
    foreach ($allAdmins as $email) {
        try {
            // Using the full namespace to be safe, or just ReportUpdatedMail if imported above
            // Use the NEW Clarification mailer
Mail::to($email)->send(new \App\Mail\ReportClarificationMail($this->report));
        } catch (\Exception $e) {
            \Log::error("Failed to send clarification email to $email: " . $e->getMessage());
        }
    }

    // 5. Reset UI state
    $this->reset('clarificationText'); 
    $this->showSuccess = true;

    session()->flash('success_message', 'Your statement has been submitted.');
}
    public function render()
    {
        return view('livewire.clarification-modal')->layout('layouts.app');
    }
}