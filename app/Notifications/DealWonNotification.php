<?php

namespace App\Notifications;

use App\Models\Deal;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DealWonNotification extends Notification
{

    protected $deal;

    /**
     * Create a new notification instance.
     */
    public function __construct(Deal $deal)
    {
        $this->deal = $deal;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('🎉 Deal Won: ' . $this->deal->name)
            ->greeting('Congratulations!')
            ->line('A deal has been marked as won:')
            ->line('**Deal:** ' . $this->deal->name)
            ->line('**Value:** $' . number_format($this->deal->value, 2))
            ->line('**Company:** ' . ($this->deal->lead->company ?? 'N/A'))
            ->action('View Deal', url('/deals/kanban'))
            ->line('Great work closing this deal!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'deal_won',
            'deal_id' => $this->deal->id,
            'deal_name' => $this->deal->name,
            'deal_value' => $this->deal->value,
            'company' => $this->deal->lead->company ?? 'N/A',
            'message' => "Deal '{$this->deal->name}' worth $" . number_format($this->deal->value, 0) . " has been won!",
            'icon' => 'success',
            'url' => '/deals/kanban'
        ];
    }
}
