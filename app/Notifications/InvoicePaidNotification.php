<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoicePaidNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $invoice;

    /**
     * Create a new notification instance.
     */
    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Invoice Paid 💰',
            'message' => "Invoice #{$this->invoice->invoice_number} ({$this->invoice->deal->lead->company}) has been paid.",
            'amount' => $this->invoice->total,
            'invoice_id' => $this->invoice->id,
            'type' => 'invoice_paid',
            'icon' => 'cash' // For UI
        ];
    }
}
