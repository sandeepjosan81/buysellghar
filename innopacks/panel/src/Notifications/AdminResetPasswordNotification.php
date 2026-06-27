<?php

namespace InnoShop\Panel\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminResetPasswordNotification extends Notification
{
    public function __construct(public string $token)
    {
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
        // echo "<pre>";
        // print_r($url);
        // exit;
        return (new MailMessage)
            ->subject('Reset Password')
            ->line('You requested a password reset.')
            ->action('Reset Password', $url)
            ->line('If you did not request this, ignore this email.');
    }
}