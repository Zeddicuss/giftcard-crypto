<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\Cryptocurrency;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CryptoApproved extends Notification
{
    use Queueable;
    public $crypto;

    /**
     * Create a new notification instance.
     */
    public function __construct(Cryptocurrency $crypto)
    {
        $this->crypto = $crypto;
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
                    ->subject('Crypto Approval!.')
                    ->line('Your Crypto have been approved and you will receive your payment soon!.')
                    ->action('View Cryptocurrency', url('/'))
                    ->line('Thank you for using JTCards!');
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
