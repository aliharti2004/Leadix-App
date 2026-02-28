<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DealCreatedNotification extends Notification
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
            'title' => 'New Deal Created 💼',
            'message' => "New deal: {$this->deal->name} - $" . number_format($this->deal->value, 0),
            'deal_id' => $this->deal->id,
            'type' => 'deal_created',
            'icon' => 'briefcase'
        ];
    }
}
