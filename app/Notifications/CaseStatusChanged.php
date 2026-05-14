<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Report;

Mail::to($user)->queue(new StatusUpdatedMail($report));

class CaseStatusChanged extends Notification
{
    use Queueable;

    public $report;

    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Report Status Has Changed')
            ->greeting('Hello,')
            ->line('The status of your report (Case #: ' . $this->report->case_number . ') has been updated to: ' . ucfirst($this->report->status) . '.')
            ->line('Thank you for helping keep SafeSpace safe.')
            ->salutation('SafeSpace Team');
    }
}
