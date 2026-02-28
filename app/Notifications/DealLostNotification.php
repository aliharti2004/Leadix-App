<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DealLostNotification extends Notification
{
    use Queueable;

    protected $deal;

    public function __construct($deal)
    {
        $this->deal = $deal;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Deal Lost 😔',
            'message' => "Deal lost: {$this->deal->name}",
            'deal_id' => $this->deal->id,
            'type' => 'deal_lost',
            'icon' => 'x-circle'
        ];
    }
}
