<?php

namespace App\Notifications;

use App\Models\Invoice;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoiceOverdueNotification extends Notification
{

    protected $invoice;

    /**
     * Create a new notification instance.
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
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
        $daysOverdue = now()->diffInDays($this->invoice->due_date);

        return (new MailMessage)
            ->subject('⚠️ Invoice Overdue: ' . $this->invoice->invoice_number)
            ->greeting('Payment Reminder')
            ->line('An invoice is now overdue:')
            ->line('**Invoice:** ' . $this->invoice->invoice_number)
            ->line('**Amount:** $' . number_format($this->invoice->total, 2))
            ->line('**Due Date:** ' . $this->invoice->due_date->format('M d, Y'))
            ->line('**Days Overdue:** ' . $daysOverdue . ' days')
            ->action('View Invoice', url('/invoices/' . $this->invoice->id))
            ->line('Please follow up with the client to ensure timely payment.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        $daysOverdue = (int) now()->diffInDays($this->invoice->due_date);

        return [
            'type' => 'invoice_overdue',
            'invoice_id' => $this->invoice->id,
            'invoice_number' => $this->invoice->invoice_number,
            'amount' => $this->invoice->total,
            'days_overdue' => $daysOverdue,
            'message' => "Invoice {$this->invoice->invoice_number} is {$daysOverdue} days overdue ($" . number_format($this->invoice->total, 0) . ")",
            'icon' => 'warning',
            'url' => '/invoices/' . $this->invoice->id
        ];
    }
}
