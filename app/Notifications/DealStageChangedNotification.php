<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DealStageChangedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $deal;
    protected $oldStage;
    protected $newStage;

    /**
     * Create a new notification instance.
     */
    public function __construct($deal, $oldStage, $newStage)
    {
        $this->deal = $deal;
        $this->oldStage = $oldStage;
        $this->newStage = $newStage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Deal Moved ➡️',
            'message' => "{$this->deal->name} moved from {$this->oldStage} to {$this->newStage}.",
            'deal_id' => $this->deal->id,
            'type' => 'deal_stage_changed',
            'icon' => 'arrow-right' // For UI
        ];
    }
}
