<?php

namespace App\Services;

use App\Models\Deal;
use App\Models\DealStage;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DealService
{
    /**
     * Update the stage of a deal with proper validation and business logic
     * 
     * @param Deal $deal
     * @param int $newStageId
     * @param User $user
     * @return array ['success' => bool, 'message' => string, 'invoice' => Invoice|null]
     */
    public function updateDealStage(Deal $deal, int $newStageId, User $user): array
    {
        // Check permissions
        if (!$this->canUserUpdateDeal($deal, $user)) {
            return [
                'success' => false,
                'message' => 'You do not have permission to update this deal.',
                'invoice' => null,
            ];
        }

        // Validate stage exists and belongs to same organization
        $newStage = DealStage::where('id', $newStageId)
            ->where('organization_id', $user->organization_id)
            ->first();

        if (!$newStage) {
            return [
                'success' => false,
                'message' => 'Invalid stage selected.',
                'invoice' => null,
            ];
        }

        $previousStage = $deal->stage;
        $invoice = null;

        DB::beginTransaction();
        try {
            // Update deal stage
            $deal->deal_stage_id = $newStageId;
            $deal->save(); // This will trigger DealObserver
            $deal->refresh(); // Reload relationships

            //  Observer handles Won/Lost logic automatically
            // Check if invoice was created by observer
            $invoice = null;
            if ($newStage->name === 'Won' && $deal->invoices()->exists()) {
                $invoice = $deal->invoices()->latest()->first();
            }

            DB::commit();

            $message = "Deal moved to {$newStage->name}";
            if ($invoice) {
                $message .= '. Draft invoice created automatically.';
            }

            return [
                'success' => true,
                'message' => $message,
                'invoice' => $invoice,
            ];

        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => 'Failed to update deal: ' . $e->getMessage(),
                'invoice' => null,
            ];
        }
    }

    /**
     * Check if user has permission to update the deal
     * 
     * @param Deal $deal
     * @param User $user
     * @return bool
     */
    public function canUserUpdateDeal(Deal $deal, User $user): bool
    {
        // Admin can update all deals in their organization
        if ($user->hasRole('admin')) {
            return $deal->organization_id === $user->organization_id;
        }

        // Sales can only update their own deals
        if ($user->hasRole('sales')) {
            return $deal->user_id === $user->id &&
                $deal->organization_id === $user->organization_id;
        }

        // Viewer and Finance cannot update deals
        return false;
    }

    /**
     * Create an invoice for a won deal
     * 
     * @param Deal $deal
     * @return Invoice
     */
    public function createInvoiceForWonDeal(Deal $deal): Invoice
    {
        $invoice = Invoice::create([
            'organization_id' => $deal->organization_id,
            'deal_id' => $deal->id,
            'invoice_number' => 'INV-' . strtoupper(uniqid()),
            'issue_date' => now(),
            'due_date' => now()->addDays(14),
            'subtotal' => $deal->value,
            'tax' => 0, // Simplified for MVP
            'total' => $deal->value,
            'status' => 'draft',
        ]);

        // Create invoice line item
        InvoiceItem::create([
            'invoice_id' => $invoice->id,
            'description' => $deal->title . ' - Deal Closed',
            'quantity' => 1,
            'unit_price' => $deal->value,
            'total' => $deal->value,
        ]);

        return $invoice;
    }
}
