<?php

namespace App\Notifications;

use App\Models\GiftCard;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GiftcardRejected extends Notification
{
    use Queueable;
    public $giftcard;

    /**
     * Create a new notification instance.
     */
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
                    ->subject('Gift Card Rejection!.')
                    ->line('Your Gift Card have been Rejected and you will not receive any payment!.')
                    ->line('Reasons for Rejection can be one of the following:')
                    ->line('Spam details detected.')
                    ->line('incorrect account details')
                    ->line('incorrect Gift Card details')
                    ->line('Unclear Image')
                    ->line('Kindly login, review and correct')
                    ->action('View Giftcard', url('/'))
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
