<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmail extends Notification
{
    use Queueable;

    protected $verificationToken;

    /**
     * Create a new notification instance.
     */
    public function __construct($verificationToken)
    {
        $this->verificationToken = $verificationToken;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Email Verification Code')
                    ->line('Thank you for registering! Please use the code to verify your email:')
                    ->line('Your verification code is: ' . $notifiable->verification_token)
                    ->action('Verify Email', url('/verification'))
                    // ->action('Verify Email', url('/verify?code' .$notifiable->verification_token))
                    ->line('Thank you for using Xchange!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
