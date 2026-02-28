@extends('layouts.app')

@section('header', 'Invoices')

@section('content')
    <style>
        .glass-card {
            background: rgba(20, 20, 20, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 115, 0, 0.1);
        }

        .btn-gradient {
            background: linear-gradient(135deg, #ff7300 0%, #ff9500 100%);
            box-shadow: 0 4px 20px rgba(255, 115, 0, 0.3);
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            box-shadow: 0 8px 30px rgba(255, 115, 0, 0.5);
            transform: translateY(-2px);
        }

        table {
            border-collapse: separate;
            border-spacing: 0;
        }

        tbody tr {
            transition: all 0.2s ease;
        }

        tbody tr:hover {
            background: rgba(255, 115, 0, 0.05);
            transform: translateX(4px);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.375rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .status-draft {
            background: rgba(156, 163, 175, 0.1);
            color: #9CA3AF;
        }

        .status-sent {
            background: rgba(59, 130, 246, 0.1);
            color: #3B82F6;
        }

        .status-paid {
            background: rgba(34, 197, 94, 0.1);
            color: #22C55E;
        }

        .status-overdue {
            background: rgba(239, 68, 68, 0.1);
            color: #EF4444;
        }
    </style>

    <div>
        <!-- Page Header -->
        <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-white mb-1">Invoices</h1>
                <p class="text-gray-400 font-medium">Manage and track your invoices</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('invoices.create') }}"
                    class="btn-gradient text-white px-6 py-2.5 rounded-xl text-sm font-bold flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Invoice
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="glass-card rounded-2xl p-4 mb-6">
            <form method="GET" action="{{ route('invoices.index') }}" class="flex flex-wrap gap-3">
                <input type="text" name="search" placeholder="Search invoices..." value="{{ request('search') }}"
                    class="flex-1 min-w-[200px] bg-white/5 border border-white/10 rounded-xl px-4 py-2 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500">

                <select name="status"
                    class="bg-white/5 border border-white/10 rounded-xl px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-orange-500/50">
                    <option value="">All Statuses</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                </select>

                <button type="submit"
                    class="bg-white/5 hover:bg-white/10 border border-white/10 hover:border-orange-500/50 px-6 py-2 rounded-xl text-white font-semibold transition">
                    Filter
                </button>

                @if (request()->hasAny(['search', 'status']))
                    <a href="{{ route('invoices.index') }}"
                        class="bg-white/5 hover:bg-white/10 border border-white/10 px-6 py-2 rounded-xl text-gray-400 hover:text-white font-semibold transition">
                        Clear
                    </a>
                @endif
            </form>
        </div>

        <!-- Invoices Table -->
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/10">
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Invoice #
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Client
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Due Date
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Amount
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($invoices as $invoice)
                            <tr class="hover:bg-white/5 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-orange-500">{{ $invoice->invoice_number }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-white">
                                        {{ $invoice->deal->lead->company ?? 'N/A' }}
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        {{ $invoice->deal->lead->name ?? 'No contact' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-300">
                                        {{ $invoice->issue_date?->format('M d, Y') ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-300">
                                        {{ $invoice->due_date?->format('M d, Y') ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-white">
                                        ${{ number_format($invoice->total, 2) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="status-badge status-{{ $invoice->status }}">
                                        {{ ucfirst($invoice->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('invoices.show', $invoice) }}"
                                            class="text-blue-400 hover:text-blue-300 transition" title="View">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('invoices.edit', $invoice) }}"
                                            class="text-orange-400 hover:text-orange-300 transition" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <button onclick="if(confirm('Delete this invoice?')) { /* delete logic */ }"
                                            class="text-red-400 hover:text-red-300 transition" title="Delete">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-semibold text-gray-400">No invoices found</h3>
                                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new invoice.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('invoices.create') }}"
                                            class="btn-gradient text-white px-6 py-2.5 rounded-xl text-sm font-bold inline-flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                            New Invoice
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($invoices->hasPages())
                <div class="px-6 py-4 border-t border-white/10">
                    {{ $invoices->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection