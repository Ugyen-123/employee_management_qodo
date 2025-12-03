<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminResetPassword extends Notification
{

    public function __construct(private string $token, private string $email)
    {
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = route('admin.password.reset', ['token' => $this->token, 'email' => $this->email]);

        return (new MailMessage)
            ->subject('Admin Password Reset')
            ->greeting('Hello Admin,')
            ->line('You requested a password reset for your administrator account.')
            ->action('Reset Password', $url)
            ->line('This reset link will expire in 60 minutes.')
            ->line('If you did not request a password reset, no further action is required.');
    }
}
