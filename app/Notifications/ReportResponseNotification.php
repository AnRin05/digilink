<?php

namespace App\Notifications;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReportResponseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $report;
    public $adminResponse;

    public function __construct(Report $report, $adminResponse)
    {
        $this->report = $report;
        $this->adminResponse = $adminResponse;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $reportType = $this->report->report_type === 'urgent_help' ? 'Urgent Help' : 'Complaint';
        
        return (new MailMessage)
            ->subject('Response to Your ' . $reportType . ' Report - ' . config('app.name'))
            ->greeting('Hello ' . ($notifiable->fullname ?? 'User') . ',')
            ->line('We have reviewed your report and here is our response:')
            ->line('')
            ->line($this->adminResponse)
            ->line('')
            ->line('Report Details:')
            ->line('Type: ' . $reportType)
            ->line('Booking ID: ' . $this->report->booking_id)
            ->line('Status: ' . ucfirst($this->report->status))
            ->line('')
            ->action('View Report Details', url('/admin/reports/' . $this->report->id))
            ->line('Thank you for using our service!');
    }
}