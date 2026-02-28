<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class InvoiceCreatedNotification extends Notification
{
    use Queueable;

    protected $invoice;

    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New Invoice Created 📄',
            'message' => "Invoice #{$this->invoice->id} created for $" . number_format($this->invoice->amount, 2),
            'invoice_id' => $this->invoice->id,
            'type' => 'invoice_created',
            'icon' => 'document'
        ];
    }
}
