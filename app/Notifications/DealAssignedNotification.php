<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DealAssignedNotification extends Notification
{
    use Queueable;

    protected $deal;
    protected $assignee;

    public function __construct($deal, $assignee)
    {
        $this->deal = $deal;
        $this->assignee = $assignee;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Deal Assigned to You 🎯',
            'message' => "You've been assigned: {$this->deal->name}",
            'deal_id' => $this->deal->id,
            'type' => 'deal_assigned',
            'icon' => 'user-check'
        ];
    }
}
