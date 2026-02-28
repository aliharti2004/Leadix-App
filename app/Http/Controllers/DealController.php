<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\DealStage;
use App\Models\Invoice;
use App\Services\DealService;
use Illuminate\Http\Request;

class DealController extends Controller
{
    protected $dealService;
    protected $filterService;

    public function __construct(DealService $dealService, \App\Services\FilterService $filterService)
    {
        $this->dealService = $dealService;
        $this->filterService = $filterService;
    }

    /**
     * Display kanban board view of deals
     */
    public function kanban(Request $request)
    {
        // Block finance users - Deals/Pipeline are sales only
        if (auth()->user()->hasRole('finance')) {
            abort(403, 'Sales pipeline is only accessible to sales and admin users.');
        }

        $user = auth()->user();

        // Get stages ordered by position
        $stages = DealStage::ordered()->get();

        // Get deals based on user role
        $dealsQuery = Deal::with(['stage', 'lead', 'owner']);

        // Sales users only see their own deals
        if ($user->hasRole('sales')) {
            $dealsQuery->where('user_id', $user->id);
        }

        // Apply filters
        $this->filterService->applyDealFilters($dealsQuery, $request);

        $deals = $dealsQuery->get();
        $owners = \App\Models\User::all(['id', 'name']); // Or filter by role if needed

        // Group deals by stage
        $dealsByStage = $deals->groupBy('deal_stage_id');

        return view('deals.kanban', compact('stages', 'dealsByStage', 'deals', 'user', 'owners'));
    }

    public function index()
    {
        $deals = Deal::with('stage')->latest()->paginate(10);
        return view('deals.index', compact('deals'));
    }

    /**
     * Update deal stage via AJAX (for Kanban drag-and-drop)
     */
    public function updateStage(Request $request, Deal $deal)
    {
        $validated = $request->validate([
            'stage_id' => 'required|exists:deal_stages,id',
        ]);

        $result = $this->dealService->updateDealStage(
            $deal,
            $validated['stage_id'],
            auth()->user()
        );

        if ($result['success']) {
            // Observer handles notifications automatically
            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'deal' => $deal->fresh(['stage', 'lead', 'owner']),
                'invoice' => $result['invoice'],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'],
        ], 403);
    }

    public function update(Request $request, Deal $deal)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'lead_id' => 'nullable|exists:leads,id',
            'deal_stage_id' => 'required|exists:deal_stages,id',
            'value' => 'nullable|numeric',
            'expected_close_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        // If AJAX request, update the deal and return JSON
        if ($request->ajax() || $request->wantsJson()) {
            $previousStage = $deal->stage->name ?? '';

            // Update deal fields
            $deal->update($validated);
            $deal->refresh();

            $newStage = $deal->stage->name;

            // Handle stage change logic
            if ($newStage === 'Won' && $previousStage !== 'Won') {
                $deal->won_at = now();
                $deal->save();

                $usersToNotify = \App\Models\User::where('organization_id', $deal->organization_id)->get();
                \Illuminate\Support\Facades\Notification::send($usersToNotify, new \App\Notifications\DealWonNotification($deal, auth()->user()));

                if (!$deal->hasInvoice()) {
                    $invoice = $this->dealService->createInvoiceForWonDeal($deal);
                }
            } elseif ($newStage !== $previousStage) {
                $usersToNotify = \App\Models\User::where('organization_id', $deal->organization_id)->get();
                \Illuminate\Support\Facades\Notification::send($usersToNotify, new \App\Notifications\DealStageChangedNotification($deal, $previousStage, $newStage));
            }

            return response()->json([
                'success' => true,
                'message' => 'Deal updated successfully',
                'deal' => $deal->fresh(['stage', 'lead', 'owner']),
            ]);
        }

        // Traditional form submission - keep existing behavior
        $previousStage = $deal->stage->name ?? '';
        $deal->update($validated);
        $deal->refresh();

        $newStage = $deal->stage->name;

        // Workflow: Deal Won -> Trigger Invoice Creation
        if ($newStage === 'Won' && $previousStage !== 'Won') {
            $deal->won_at = now();
            $deal->save();

            // Trigger Won Notification
            $usersToNotify = \App\Models\User::where('organization_id', $deal->organization_id)->get();
            \Illuminate\Support\Facades\Notification::send($usersToNotify, new \App\Notifications\DealWonNotification($deal, auth()->user()));

            // For MVP, auto-create a draft invoice
            if (!$deal->hasInvoice()) {
                $invoice = $this->dealService->createInvoiceForWonDeal($deal);
                return redirect()->route('invoices.edit', $invoice)->with('success', 'Deal Won! Draft invoice created.');
            }
        } elseif ($newStage !== $previousStage) {
            // Trigger Stage Change Notification
            $usersToNotify = \App\Models\User::where('organization_id', $deal->organization_id)->get();
            \Illuminate\Support\Facades\Notification::send($usersToNotify, new \App\Notifications\DealStageChangedNotification($deal, $previousStage, $newStage));
        }

        return back()->with('success', 'Deal updated.');
    }

    /**
     * Show deal details (supports JSON for drawer)
     */
    public function show(Deal $deal)
    {
        // Load relationships
        $deal->load(['lead', 'owner', 'stage', 'invoices']);

        // If AJAX request, return JSON for drawer
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'deal' => [
                    'id' => $deal->id,
                    'name' => $deal->name,
                    'value' => $deal->value,
                    'expected_close_date' => $deal->expected_close_date?->format('Y-m-d'),
                    'probability' => $deal->stage->probability ?? 0,
                    'notes' => $deal->notes,
                    'stage' => [
                        'id' => $deal->stage->id,
                        'name' => $deal->stage->name,
                    ],
                    'lead' => [
                        'id' => $deal->lead->id,
                        'company' => $deal->lead->company,
                        'contact_name' => $deal->lead->contact_name,
                    ],
                    'owner' => [
                        'id' => $deal->owner->id,
                        'name' => $deal->owner->name,
                    ],
                    'has_invoice' => $deal->hasInvoice(),
                    'created_at' => $deal->created_at->diffForHumans(),
                ],
            ]);
        }

        return view('deals.show', compact('deal'));
    }

    /**
     * Store a new deal
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'lead_id' => 'required|exists:leads,id',
            'value' => 'required|numeric|min:0',
            'deal_stage_id' => 'required|exists:deal_stages,id',
            'user_id' => 'required|exists:users,id',
            'expected_close_date' => 'nullable|date',
        ]);

        $deal = Deal::create($validated);
        $deal->load(['lead', 'owner', 'stage']);

        // Notify organization
        $usersToNotify = \App\Models\User::where('organization_id', auth()->user()->organization_id)->get();
        \Illuminate\Support\Facades\Notification::send($usersToNotify, new \App\Notifications\DealCreatedNotification($deal));

        return response()->json([
            'success' => true,
            'message' => 'Deal created successfully!',
            'deal' => $deal,
        ], 201);
    }

    /**
     * Delete a deal
     */
    public function destroy(Deal $deal)
    {
        // Check permission
        $user = auth()->user();
        if (!$user->hasRole('admin') && $deal->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to delete this deal.',
            ], 403);
        }

        $deal->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deal deleted successfully.',
        ]);
    }

    /**
     * Mark deal as Won
     */
    public function markWon(Deal $deal)
    {
        // Find the "Won" stage
        $wonStage = DealStage::where('name', 'Won')->first();

        if (!$wonStage) {
            return response()->json([
                'success' => false,
                'message' => 'Won stage not found.',
            ], 404);
        }

        // Update deal stage
        $result = $this->dealService->updateDealStage($deal, $wonStage->id, auth()->user());

        if ($result['success']) {
            // Trigger Notification
            $usersToNotify = \App\Models\User::where('organization_id', $deal->organization_id)->get();
            \Illuminate\Support\Facades\Notification::send($usersToNotify, new \App\Notifications\DealWonNotification($deal, auth()->user()));

            return response()->json([
                'success' => true,
                'message' => 'Deal marked as Won! ' . ($result['invoice'] ? 'Draft invoice created.' : ''),
                'deal' => $deal->fresh(['stage', 'lead', 'owner']),
                'invoice' => $result['invoice'] ?? null,
            ]);
        }

        return response()->json($result, 403);
    }

    /**
     * Mark deal as Lost
     */
    public function markLost(Deal $deal)
    {
        // Find the "Lost" stage
        $lostStage = DealStage::where('name', 'Lost')->first();

        if (!$lostStage) {
            return response()->json([
                'success' => false,
                'message' => 'Lost stage not found.',
            ], 404);
        }

        // Update deal stage
        $result = $this->dealService->updateDealStage($deal, $lostStage->id, auth()->user());

        if ($result['success']) {
            // Notify organization about lost deal
            $usersToNotify = \App\Models\User::where('organization_id', auth()->user()->organization_id)->get();
            \Illuminate\Support\Facades\Notification::send($usersToNotify, new \App\Notifications\DealLostNotification($deal));

            return response()->json([
                'success' => true,
                'message' => 'Deal marked as Lost.',
                'deal' => $deal->fresh(['stage', 'lead', 'owner']),
            ]);
        }

        return response()->json($result, 403);
    }
}

