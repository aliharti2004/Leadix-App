<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Deal;
use App\Models\DealStage;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        // Block finance users - Leads are sales only
        if (auth()->user()->hasRole('finance')) {
            abort(403, 'Leads are only accessible to sales and admin users.');
        }

        $query = Lead::query()->where('organization_id', auth()->user()->organization_id);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('contact_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Source filter
        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        $leads = $query->latest()->paginate(20);
        return view('leads.index', compact('leads'));
    }

    public function create()
    {
        // Block finance users
        if (auth()->user()->hasRole('finance')) {
            abort(403, 'Only sales and admin users can create leads.');
        }

        return view('leads.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'company' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'source' => 'nullable|in:website,referral,cold_call,linkedin,event,other',
            'status' => 'nullable|in:new,contacted,qualified,nurturing,disqualified,converted',
            'estimated_value' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        // Add organization and user
        $validated['organization_id'] = auth()->user()->organization_id;
        $validated['user_id'] = auth()->id();
        $validated['status'] = $validated['status'] ?? 'new';

        $lead = Lead::create($validated);

        // Notify Organization
        $usersToNotify = \App\Models\User::where('organization_id', auth()->user()->organization_id)->get();
        \Illuminate\Support\Facades\Notification::send($usersToNotify, new \App\Notifications\LeadCreatedNotification($lead));

        return redirect()->route('leads.index')->with('success', 'Lead created successfully.');
    }

    public function show(Lead $lead)
    {
        return view('leads.show', compact('lead'));
    }

    public function edit(Lead $lead)
    {
        return view('leads.edit', compact('lead'));
    }

    public function update(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'company' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'source' => 'nullable|in:website,referral,cold_call,linkedin,event,other',
            'status' => 'nullable|in:new,contacted,qualified,nurturing,disqualified,converted',
            'estimated_value' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $lead->update($validated);

        return redirect()->route('leads.index')->with('success', 'Lead updated successfully.');
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();
        return redirect()->route('leads.index')->with('success', 'Lead deleted successfully.');
    }

    public function convert(Lead $lead)
    {
        // Convert Lead to Deal workflow
        $firstStage = DealStage::where('organization_id', auth()->user()->organization_id)
            ->orderBy('position')
            ->first();

        $deal = Deal::create([
            'organization_id' => auth()->user()->organization_id,
            'lead_id' => $lead->id,
            'title' => $lead->title,
            'deal_stage_id' => $firstStage ? $firstStage->id : 1, // Fallback
            'user_id' => $lead->user_id,
            'value' => $lead->estimated_value ?? 0,
            'expected_close_date' => now()->addDays(30),
        ]);

        $lead->status = 'converted';
        $lead->save();

        return redirect()->route('deals.kanban')->with('success', 'Lead converted to Deal successfully!');
    }
}
