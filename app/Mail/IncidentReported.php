<?php

namespace App\Mail;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class IncidentReported extends Mailable
{
    use Queueable, SerializesModels;

    public $report;
    public $timestamp;

    /**
     * Create a new message instance.
     */
    public function __construct(Report $report)
    {
        $this->report = $report;
         $this->timestamp = Carbon::now('Africa/Johannesburg')->format('d M Y, H:i');
    }
    

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('New Report Submitted: ' . $this->report->case_number)
                    ->markdown('emails.incident-reported');
    }
}
