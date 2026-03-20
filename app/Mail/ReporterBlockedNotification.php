<?php

namespace App\Mail;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReporterBlockedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $report;
    public $isPermanent;

    /**
     * @param  Report  $report
     * @param  bool  $isPermanent
     */
    public function __construct(Report $report, $isPermanent = true)
    {
        $this->report = $report;
        $this->isPermanent = $isPermanent;
    }

    public function build()
{
    $subject = $this->isPermanent 
        ? 'Account Access Restricted - Permanent' 
        : 'Account Access Suspended';

    // Change this line to match your actual file location
    return $this->subject($subject)
                ->markdown('emails.blocked'); 
}
}