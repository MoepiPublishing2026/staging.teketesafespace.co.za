<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AbuseType;
use App\Models\Subtype;
use App\Models\Incident;
use App\Models\Notification;
use App\Mail\CaseNumberNotification;
use App\Notifications\CaseNumberSms;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification as Notifier;

class Counter extends Component
{
    public $abuseTypeID;
    public $abuseSubID;

    #[Validate('required|string|min:10')]
    public $description;

    #[Validate('required|email')]
    public $reporterEmail;

    #[Validate('nullable|string|min:10')]
    public $phoneNumber;

    #[Computed]
    public function abuseTypes()
    {
        return AbuseType::all();
    }

    #[Computed]
    public function subtypes()
    {
        if (!$this->abuseTypeID) {
            return collect();
        }

        // Corrected to use the 'parent_type_id' column from your Subtype model
        return Subtype::where('parent_type_id', $this->abuseTypeID)->get();
    }

    public function render()
    {
        // Renders the correct view file.
        return view('livewire.report-form');
    }

    public function submitReport()
    {
        $this->validate([
            'abuseTypeID' => 'required',
            'abuseSubID' => 'required',
            'description' => 'required|string|min:10',
            'reporterEmail' => 'required|email',
            'phoneNumber' => 'nullable|string|min:10',
        ]);

        // Create a new incident and get its ID as the case number
        $incident = Incident::create([
            'abuse_type_id' => $this->abuseTypeID,
            'subtype_id' => $this->abuseSubID,
            'description' => $this->description,
        ]);

        $caseNumber = $incident->id;

        // Save a new record in the notifications table
        try {
            Notification::create([
                'report_id' => (int) $caseNumber,
                'notification_type' => 'CaseUpdate',
                'message' => 'Your incident has been reported. Case Number: ' . $caseNumber,
                'phone_number' => $this->phoneNumber,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to create notification record: ' . $e->getMessage());
        }

        // Send a notification email to the reporter with the case number
        Mail::to($this->reporterEmail)->send(new CaseNumberNotification($caseNumber));

        // Send SMS notification if a phone number is provided, using the Vonage channel
        if ($this->phoneNumber) {
            Notifier::route('vonage', $this->phoneNumber)->notify(new CaseNumberSms($caseNumber));
        }

        $this->reset(['abuseTypeID', 'abuseSubID', 'description', 'reporterEmail', 'phoneNumber']);
        session()->flash('success_message', "Your report has been submitted successfully. Your case number is #{$caseNumber}. A confirmation email has been sent to {$this->reporterEmail}.");
    }
}
