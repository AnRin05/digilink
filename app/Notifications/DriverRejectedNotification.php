<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DriverRejectedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Driver Account Application Status - ' . config('app.name'))
            ->greeting('Hello ' . $notifiable->fullname . ',')
            ->line('Thank you for your interest in becoming a driver with our service.')
            ->line('After careful review, we regret to inform you that your driver account application has not been approved at this time.')
            ->line('This decision may be due to one of the following reasons:')
            ->line('- Incomplete or unclear documentation')
            ->line('- Issues with vehicle registration')
            ->line('- Driver license verification concerns')
            ->line('- Vehicle requirements not met')
            ->line('If you believe this is an error or would like to submit additional information, please contact our support team.')
            ->line('Thank you for your understanding.');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Your driver account application was not approved.',
            'driver_id' => $notifiable->id,
        ];
    }
}