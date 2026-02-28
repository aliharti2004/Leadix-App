<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    protected $filterService;

    public function __construct(\App\Services\FilterService $filterService)
    {
        $this->filterService = $filterService;
    }

    public function kanban(Request $request)
    {
        // Redirect to table view (kanban view removed due to compatibility issues)
        return redirect()->route('invoices.index');
    }

    public function index(Request $request)
    {
        // Only finance users can access invoices
        if (!auth()->user()->hasRole('finance')) {
            abort(403, 'Invoices are only accessible to finance users.');
        }

        $query = Invoice::with(['deal.lead'])->latest();

        // Apply filters
        $this->filterService->applyInvoiceFilters($query, $request);

        $invoices = $query->paginate(10)->withQueryString();

        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        // Finance users only
        if (!auth()->user()->hasRole('finance')) {
            abort(403, 'Only finance users can create invoices.');
        }

        // Get all deals from the user's organization for selection
        $deals = \App\Models\Deal::where('organization_id', auth()->user()->organization_id)
            ->with('lead')
            ->orderBy('title')
            ->get();

        // Generate next invoice number
        $lastInvoice = Invoice::where('organization_id', auth()->user()->organization_id)
            ->latest('id')
            ->first();

        $nextInvoiceNumber = $lastInvoice
            ? 'INV-' . (int) substr($lastInvoice->invoice_number, 4) + 1
            : 'INV-' . date('Y') . '-001';

        return view('invoices.create', compact('deals', 'nextInvoiceNumber'));
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('deal.lead', 'items', 'payments');

        if (request()->wantsJson()) {
            return response()->json([
                'invoice' => $invoice
            ]);
        }

        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        // Finance users only
        if (!auth()->user()->hasRole('finance')) {
            abort(403, 'Only finance users can edit invoices.');
        }

        return view('invoices.edit', compact('invoice'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'deal_id' => 'nullable|exists:deals,id',
            'invoice_number' => 'required|unique:invoices,invoice_number',
            'total' => 'required|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'status' => 'required|in:draft,sent,paid,overdue',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        // Calculate subtotal from total - tax
        $tax = $validated['tax'] ?? 0;
        $subtotal = $validated['total'] - $tax;

        // Create invoice
        $invoice = Invoice::create([
            'organization_id' => auth()->user()->organization_id,
            'deal_id' => $validated['deal_id'],
            'invoice_number' => $validated['invoice_number'],
            'issue_date' => $validated['issue_date'],
            'due_date' => $validated['due_date'],
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $validated['total'],
            'status' => $validated['status'],
        ]);

        // Create invoice items
        foreach ($validated['items'] as $item) {
            $invoice->items()->create([
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total' => $item['quantity'] * $item['unit_price'],
            ]);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Invoice created successfully',
                'invoice' => $invoice->load('items')
            ]);
        }

        return redirect()->route('invoices.kanban')
            ->with('success', 'Invoice created successfully');
    }

    public function update(Request $request, Invoice $invoice)
    {
        // Finance users only
        if (!auth()->user()->hasRole('finance')) {
            abort(403, 'Only finance users can update invoices.');
        }

        $validated = $request->validate([
            'deal_id' => 'nullable|exists:deals,id',
            'status' => 'required|in:draft,pending,paid,overdue',
            'issue_date' => 'nullable|date',
            'due_date' => 'nullable|date',
            'total' => 'required|numeric|min:0',
        ]);

        $invoice->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Invoice updated successfully',
                'invoice' => $invoice->load('deal.lead')
            ]);
        }

        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Invoice updated successfully');
    }

    public function destroy(Invoice $invoice)
    {
        // Finance users only
        if (!auth()->user()->hasRole('finance')) {
            abort(403, 'Only finance users can delete invoices.');
        }

        $invoice->delete();

        return response()->json([
            'success' => true,
            'message' => 'Invoice deleted successfully'
        ]);
    }

    /**
     * Download invoice as PDF.
     *
     * @param Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function downloadPdf(Invoice $invoice)
    {
        return app(\App\Services\InvoicePdfService::class)->downloadPdf($invoice);
    }

    /**
     * Update invoice status (for kanban drag-and-drop)
     */
    public function updateStatus(Request $request, Invoice $invoice)
    {
        // Finance users only
        if (!auth()->user()->hasRole('finance')) {
            abort(403, 'Only finance users can update invoice status.');
        }

        $validated = $request->validate([
            'status' => 'required|in:draft,sent,paid,overdue',
        ]);

        $invoice->update(['status' => $validated['status']]);

        return response()->json([
            'success' => true,
            'message' => 'Invoice status updated to ' . ucfirst($validated['status']),
            'invoice' => $invoice->fresh(['deal.lead'])
        ]);
    }

    // Additional methods for add item, send, etc. would go here
}
