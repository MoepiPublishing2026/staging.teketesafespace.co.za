<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Report;

class ReportStatusChangedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $report;
    public $reason;

    /**
     * Create a new message instance.
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
                ->view('emails.report-status-changed'); // This must match the file path
}
}