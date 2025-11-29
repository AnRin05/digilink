<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DriverApprovedNotification extends Notification implements ShouldQueue
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
            ->subject('Driver Account Approved - ' . config('app.name'))
            ->greeting('Congratulations ' . $notifiable->fullname . '!')
            ->line('Your driver account has been successfully approved by our administration team.')
            ->line('You can now log in to your account and start accepting rides.')
            ->action('Login to Driver Dashboard', url('/login'))
            ->line('If you have any questions, please contact our support team.')
            ->line('Thank you for choosing our service!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Your driver account has been approved.',
            'driver_id' => $notifiable->id,
        ];
    }
}