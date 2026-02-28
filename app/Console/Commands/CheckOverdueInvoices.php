<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Models\User;
use App\Notifications\InvoiceOverdueNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckOverdueInvoices extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'check:overdue-invoices';

    /**
     * The console command description.
     */
    protected $description = 'Check for overdue invoices and send notifications';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Checking for overdue invoices...');

        // Get all unpaid invoices that are past their due date
        $overdueInvoices = Invoice::where('status', '!=', 'paid')
            ->where('due_date', '<', now())
            ->whereNull('deleted_at')
            ->get();

        $this->info("Found {$overdueInvoices->count()} overdue invoices");
        Log::info('Overdue invoice check', ['count' => $overdueInvoices->count()]);

        foreach ($overdueInvoices as $invoice) {
            $this->notifyOverdueInvoice($invoice);
        }

        $this->info('Overdue invoice notifications sent!');

        return Command::SUCCESS;
    }

    /**
     * Notify relevant users about the overdue invoice.
     */
    protected function notifyOverdueInvoice(Invoice $invoice): void
    {
        $organizationId = $invoice->organization_id;

        // Get all finance and admin users in the organization
        $usersToNotify = User::where('organization_id', $organizationId)
            ->whereIn('role', ['admin', 'finance'])
            ->get();

        $this->info("Notifying {$usersToNotify->count()} users about overdue invoice #{$invoice->invoice_number}");

        Log::info('Sending overdue invoice notifications', [
            'invoice_id' => $invoice->id,
            'invoice_number' => $invoice->invoice_number,
            'users_count' => $usersToNotify->count(),
        ]);

        // Send notification to each user
        foreach ($usersToNotify as $user) {
            $user->notify(new InvoiceOverdueNotification($invoice));
        }
    }
}
