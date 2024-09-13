<?php

namespace App\Notifications;

use App\Models\GiftCard;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GiftcardAvailableNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $giftcard;
    public function __construct(GiftCard $giftcard)
    {
        $this->giftcard = $giftcard;
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
                    ->subject('New Gift Card Available')
                    ->line('There is a new pending Gift Card.')
                    ->line('Gift Card Name:' .$this->giftcard->name)
                    ->line('Amount: ₦' .number_format($this->giftcard->amount_in_naira, 2))
                    ->line('Please review and Approve Gift Card.')
                    ->action('View Gift Card', url('/giftcard/giftcard/' .$this->giftcard->id));
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
