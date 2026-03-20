<?php

namespace App\Mail;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Support\Carbon;

class ReportUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $report;
    public $timestamp;

    public function __construct(Report $report)
    {
        $this->report = $report;
        // Set South African time
        $this->timestamp = Carbon::now('Africa/Johannesburg')->format('d M Y, H:i');
    }

    public function build()
    {
        return $this->subject('Report Updated Notification')
                    ->markdown('emails.report_updated');
    }
    public function content(): Content
{
   return new Content(
            // Change this to match the filename you want to use
            markdown: 'emails.report_updated', 
            with: [
                'report' => $this->report,
                'timestamp' => $this->timestamp,
            ],
    );
}
}