<?php

namespace App\Notifications;

use App\Models\Cryptocurrency;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCryptoPending extends Notification
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
                    ->subject ('New Cryptocurrency Available')
                    ->line('There is a pending cryptocurrency awaiting approval')
                    ->line('Cryptocurrency Name:' .' '.$this->crypto->name)
                    ->line('Price: ₦' . number_format($this->crypto->crypto_price * $this->crypto->exchange_rate, 2))
                    ->action('View Cryptocurrency', url('/'));
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
