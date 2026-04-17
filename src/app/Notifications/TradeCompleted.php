<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TradeCompleted extends Notification
{
    use Queueable;
    public $item;

    public function __construct($item)
    {
        $this->item = $item;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('【COACHTECH】取引が完了しました')
            ->line($this->item->name . ' の取引が購入者によって完了されました。')
            ->line('取引画面より購入者の評価を行ってください。')
            ->action('取引画面を確認する', url('/chat/' . $this->item->id));
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
