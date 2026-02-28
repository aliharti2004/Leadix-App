<?php

namespace App\Observers;

use App\Models\Payment;
use App\Models\User;
use App\Notifications\PaymentReceivedNotification;
use Illuminate\Support\Facades\Log;

class PaymentObserver
{
    /**
     * Handle the Payment "created" event.
     */
    public function created(Payment $payment): void
    {
        Log::info('PaymentObserver created triggered', [
            'payment_id' => $payment->id,
            'amount' => $payment->amount,
            'invoice_id' => $payment->invoice_id,
        ]);

        // Notify finance and admin users about the payment
        $this->notifyPaymentReceived($payment);
    }

    /**
     * Notify relevant users about the payment received.
     */
    protected function notifyPaymentReceived(Payment $payment): void
    {
        // Get the payment's organization through the invoice
        $invoice = $payment->invoice;
        if (!$invoice) {
            Log::warning('Payment has no invoice', ['payment_id' => $payment->id]);
            return;
        }

        $organizationId = $invoice->organization_id;

        Log::info('notifyPaymentReceived called', [
            'payment_id' => $payment->id,
            'organization_id' => $organizationId,
        ]);

        // Get all finance and admin users in the organization
        $usersToNotify = User::where('organization_id', $organizationId)
            ->whereIn('role', ['admin', 'finance'])
            ->get();

        Log::info('Found users to notify', ['count' => $usersToNotify->count()]);

        // Send notification to each user
        foreach ($usersToNotify as $user) {
            Log::info('Notifying user', [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_role' => $user->role,
            ]);

            $user->notify(new PaymentReceivedNotification($payment));
        }

        Log::info('Payment notification dispatch complete');
    }
}
