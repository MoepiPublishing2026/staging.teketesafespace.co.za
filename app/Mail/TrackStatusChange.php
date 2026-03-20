<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Report; // Ensure the Report model is imported

class TrackStatusChange extends Mailable
{
    use Queueable, SerializesModels;

    public $report;
    public $reason;

    /**
     * Create a new message instance.
     *
     * @param Report $report The Report model instance.
     * @param string $reason The reason for the status change/confirmation.
     */
    public function __construct(Report $report, $reason)
    {
        $this->report = $report;
        $this->reason = $reason;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Case Status Update - ' . $this->report->case_number)
                    // You might still use the same view file
                    ->view('emails.escalation-choice-notification');
    }
}