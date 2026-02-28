<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentReceivedNotification extends Notification
{

    protected $payment;

    /**
     * Create a new notification instance.
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
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
            ->subject('💰 Payment Received')
            ->greeting('Payment Confirmed!')
            ->line('A payment has been received:')
            ->line('**Amount:** $' . number_format($this->payment->amount, 2))
            ->line('**Method:** ' . ucfirst($this->payment->method ?? 'N/A'))
            ->line('**Date:** ' . $this->payment->payment_date->format('M d, Y'))
            ->action('View Details', url('/invoices/' . $this->payment->invoice_id))
            ->line('Thank you for processing this payment!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'payment_received',
            'payment_id' => $this->payment->id,
            'invoice_id' => $this->payment->invoice_id,
            'amount' => $this->payment->amount,
            'method' => $this->payment->method ?? 'N/A',
            'message' => "Payment of $" . number_format($this->payment->amount, 0) . " received",
            'icon' => 'success',
            'url' => '/invoices/' . $this->payment->invoice_id
        ];
    }
}
