<?php

namespace App\Mail;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReportSubmittedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $report;

    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: ucfirst($this->report->status),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.report-submitted-notification',
            with: [
                'report' => $this->report,
                'status' => ucfirst($this->report->status),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}