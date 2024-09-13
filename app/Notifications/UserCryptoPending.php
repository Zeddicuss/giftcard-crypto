<?php

namespace App\Notifications;

use App\Models\AddCrypto;
use Illuminate\Bus\Queueable;
use App\Models\Cryptocurrency;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserCryptoPending extends Notification
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
                            ->line('Admin have cryptocurrency available! ')
                            ->line('Cryptocurrency Name:' .$this->crypto->name)
                            ->line('Price: ₦' .number_format($this->crypto->crypto_price,2))
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
