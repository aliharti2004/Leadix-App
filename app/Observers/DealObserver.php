<?php

namespace App\Observers;

use App\Models\Deal;
use App\Services\DealService;

class DealObserver
{
    protected $dealService;

    public function __construct(DealService $dealService)
    {
        $this->dealService = $dealService;
    }

    /**
     * Handle the Deal "updated" event.
     * This observer handles automatic invoice creation when deal is won
     * 
     * @param  \App\Models\Deal  $deal
     * @return void
     */
    public function updated(Deal $deal)
    {
        // DEBUG: Log that observer was triggered
        \Log::info('DealObserver updated triggered', [
            'deal_id' => $deal->id,
            'deal_title' => $deal->title,
            'isDirty_stage' => $deal->isDirty('deal_stage_id'),
            'stage_id' => $deal->deal_stage_id
        ]);

        // Check if stage was changed
        if (!$deal->isDirty('deal_stage_id')) {
            \Log::info('Stage was not changed, skipping');
            return;
        }

        // Load the new stage
        $deal->load('stage');

        \Log::info('Stage loaded', [
            'stage_name' => $deal->stage->name ?? 'NULL',
            'hasInvoice' => $deal->hasInvoice(),
            'won_at' => $deal->won_at
        ]);

        // Check if moved to Won stage and doesn't already has invoice
        if ($deal->stage->name === 'Won' && !$deal->hasInvoice() && !$deal->won_at) {
            \Log::info('Deal won! Creating invoice and sending notification');

            // Set won timestamp
            $deal->won_at = now();
            $deal->saveQuietly(); // Save without triggering observers again

            // Create invoice
            $this->dealService->createInvoiceForWonDeal($deal);

            // Send notification to deal owner and admins
            $this->notifyDealWon($deal);
        }

        // Check if moved to Lost stage
        if ($deal->stage->name === 'Lost' && !$deal->lost_at) {
            $deal->lost_at = now();
            $deal->saveQuietly();
        }
    }

    /**
     * Notify relevant users when a deal is won.
     */
    protected function notifyDealWon(Deal $deal)
    {
        \Log::info('notifyDealWon called', [
            'deal_id' => $deal->id,
            'owner_id' => $deal->user_id,
            'organization_id' => $deal->organization_id
        ]);

        $notification = new \App\Notifications\DealWonNotification($deal);

        // Notify deal owner
        if ($deal->owner) {
            \Log::info('Notifying deal owner', ['owner_id' => $deal->owner->id, 'owner_name' => $deal->owner->name]);
            $deal->owner->notify($notification);
        } else {
            \Log::warning('Deal has no owner!');
        }

        // Notify all admins in the organization
        $admins = \App\Models\User::where('organization_id', $deal->organization_id)
            ->where('role', 'admin')
            ->where('id', '!=', $deal->user_id) // Don't duplicate if owner is admin
            ->get();

        \Log::info('Found admins', ['count' => $admins->count()]);

        foreach ($admins as $admin) {
            \Log::info('Notifying admin', ['admin_id' => $admin->id, 'admin_name' => $admin->name]);
            $admin->notify($notification);
        }

        \Log::info('Notification dispatch complete');
    }
}
