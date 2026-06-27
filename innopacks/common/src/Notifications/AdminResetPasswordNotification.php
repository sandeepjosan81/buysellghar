<?php

namespace InnoShop\Panel\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminResetPasswordNotification extends Notification
{
    public string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = route('panel.password.reset', [
            'token' => $this->token,
            'email' => $notifiable->email,
        ]);

        return (new MailMessage)
            ->subject('Reset Password')
            ->line('You requested a password reset.')
            ->action('Reset Password', $url)
            ->line('This password reset link will expire in 60 minutes.')
            ->line('If you did not request this, ignore this email.');
    }
}