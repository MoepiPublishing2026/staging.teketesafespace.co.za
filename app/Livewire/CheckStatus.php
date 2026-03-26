<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Report;
use App\Models\User;
use App\Mail\TrackStatusChange;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class CheckStatus extends Component
{
    public $caseNumber = '';
    public $reportData = [];
    public $message = '';

    protected $rules = [
        'caseNumber' => 'required|string',
    ];

    protected $queryString = ['caseNumber'];

    public function mount()
    {
        if (!empty($this->caseNumber)) {
            $this->caseNumber = strtoupper(trim($this->caseNumber));
            $this->checkStatus();
        }
    }

    public function updatedCaseNumber()
    {
        $this->caseNumber = strtoupper(trim($this->caseNumber));
    }

    public function checkStatus()
    {
        $this->validate();

        $report = Report::with(['abuseType', 'subtype'])
            ->where('case_number', trim($this->caseNumber))
            ->first();

        if (!$report) {
            $this->addError('caseNumber', 'No report found with the provided case number.');
            $this->message = '';
            $this->reportData = [];
            return;
        }

        $rawDescription = (string) ($report->description ?? '');
        $otherSubtypeText = null;
        $cleanDescription = $rawDescription;
        if ($rawDescription !== '' && preg_match('/^\[Other:\s*(.*?)\]\s*/i', $rawDescription, $matches)) {
            $otherSubtypeText = trim($matches[1] ?? '');
            $cleanDescription = preg_replace('/^\[Other:\s*.*?\]\s*/i', '', $rawDescription);
        }
        $cleanDescription = trim((string) $cleanDescription);

        $this->reportData = [
            'id'                   => $report->id,
            'case_number'          => $report->case_number,
            'status'               => $report->status,
            'created_at'           => $report->created_at->format('Y-m-d H:i:s'),
            'full_name'            => $report->full_name,
            'reporter_email'       => $report->reporter_email,
            'phone_number'         => $report->phone_number,
            'location'             => $report->location,
            'grade'                => $report->grade,
            'school_name'          => $report->school_name,
            'age'                  => $report->age,
            'description'          => $cleanDescription,
            'other_subtype_text'   => $otherSubtypeText,
            'image_path'           => $report->image_path,
            'is_anonymous'         => $report->is_anonymous,
            'latest_status_reason' => $report->latest_status_reason,
            'abuse_type'           => $report->abuseType ? $report->abuseType->type_name : null,
            'subtype'              => $report->subtype ? $report->subtype->sub_type_name : null,
        ];

        $this->message = '';
    }

    protected function findSchoolAdmin(Report $report)
    {
        return User::where('role', 'school')
            ->where('school_name', $report->school_name)
            ->first();
    }

    protected function sendNotifications(Report $report, string $reason, string $status)
    {
        $admin = $this->findSchoolAdmin($report);

        if ($admin && $admin->email) {
            try {
                Mail::to($admin->email)->send(
                    new TrackStatusChange($report, $reason, $status)
                );
            } catch (\Exception $e) {
                Log::error("Failed to send status update email to admin ({$admin->email}) for report #{$report->case_number}: " . $e->getMessage());
            }
        }
    }

    public function markUnresolved()
    {
        if (!empty($this->reportData) && $this->reportData['status'] === 'forwarded') {
            $report = Report::find($this->reportData['id']);

            $newStatus = 'unresolved';
            $reason = 'Reporter chose not to keep the case forwarded, changing the status to Unresolved.';

            $report->status = $newStatus;
            $report->latest_status_reason = $reason;
            $report->save();

            $this->sendNotifications($report, $reason, $newStatus);

            $this->dispatch('status-updated', message: 'Your case status has been updated to Unresolved. A notification has been sent.', status: $newStatus);
        }

        $this->reset(['caseNumber', 'reportData']);
    }

    public function markForwarded()
    {
        if (!empty($this->reportData) && $this->reportData['status'] === 'forwarded') {
            $report = Report::find($this->reportData['id']);

            $newStatus = 'forwarded';
            $reason = 'Reporter chose to keep the case Forwarded.';

            $report->latest_status_reason = $reason;
            $report->save();

            $this->sendNotifications($report, $reason, $newStatus);

            $this->dispatch('status-updated', message: 'Your case remains Forwarded. A notification has been sent.', status: $newStatus);
        }

        $this->reset(['caseNumber', 'reportData']);
    }

    public function appealReport()
    {
        if (!empty($this->reportData) && $this->reportData['status'] === 'false-report') {
            return redirect()->route('edit-report', ['caseNumber' => $this->reportData['case_number']]);
        }
    }

    public function render()
    {
        return view('livewire.check-status');
    }
}
