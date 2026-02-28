@extends('layouts.app')

@section('header', 'Deal Details')

@section('content')
    <style>
        .glass-card {
            background: rgba(20, 20, 20, 0.6);
            backdrop-filter: blur(10px);
        }
    </style>

    <div>
        {{-- Header --}}
        <div class="mb-6">
            <a href="{{ route('deals.kanban') }}"
                class="text-gray-400 hover:text-white flex items-center gap-2 mb-4 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Pipeline
            </a>
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-2xl font-black text-white mb-2">{{ $deal->title }}</h2>
                    <div class="flex items-center gap-3">
                        <span
                            class="px-3 py-1 rounded-full text-xs font-bold bg-{{ $deal->stage->color ?? 'gray' }}-500/20 text-{{ $deal->stage->color ?? 'gray' }}-400">
                            {{ $deal->stage->name ?? 'No Stage' }}
                        </span>
                        <span class="text-gray-500 text-sm">Created {{ $deal->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('deals.edit', $deal) }}"
                        class="px-4 py-2 bg-white/5 hover:bg-white/10 text-white rounded-xl font-bold text-sm transition border border-white/10">
                        Edit Deal
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Left Column - Deal Info & Contact --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Deal Information --}}
                <div class="glass-card rounded-2xl p-6 border border-white/10">
                    <h3 class="text-lg font-black text-orange-500 mb-4 uppercase tracking-wider">Deal Information</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Value</p>
                            <p class="text-2xl font-black text-white">${{ number_format($deal->value, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Expected Close</p>
                            <p class="text-lg font-bold text-white">
                                {{ $deal->expected_close_date ? $deal->expected_close_date->format('M d, Y') : 'Not set' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Owner</p>
                            <p class="text-sm text-gray-400">{{ $deal->user->name ?? 'Unassigned' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Probability</p>
                            <p class="text-sm text-gray-400">{{ $deal->stage->probability ?? 0 }}%</p>
                        </div>
                    </div>
                </div>

                {{-- Contact Information --}}
                @if($deal->lead)
                    <div class="glass-card rounded-2xl p-6 border border-white/10">
                        <h3 class="text-lg font-black text-orange-500 mb-4 uppercase tracking-wider">Contact Information</h3>
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-full bg-orange-500/20 flex items-center justify-center">
                                    <span
                                        class="text-orange-500 font-bold text-lg">{{ strtoupper(substr($deal->lead->contact_name ?? $deal->lead->title, 0, 1)) }}</span>
                                </div>
                                <div>
                                    <p class="text-white font-bold">{{ $deal->lead->contact_name ?? $deal->lead->title }}</p>
                                    <p class="text-gray-500 text-sm">{{ $deal->lead->company ?? 'No company' }}</p>
                                </div>
                            </div>
                            @if($deal->lead->email)
                                <div class="flex items-center gap-2 text-gray-400 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    {{ $deal->lead->email }}
                                </div>
                            @endif
                            @if($deal->lead->phone)
                                <div class="flex items-center gap-2 text-gray-400 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    {{ $deal->lead->phone }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            {{-- Right Column - Actions & Details --}}
            <div class="space-y-6">
                {{-- Quick Actions --}}
                <div class="glass-card rounded-2xl p-6 border border-white/10">
                    <h3 class="text-sm font-black text-gray-400 mb-4 uppercase tracking-wider">Quick Actions</h3>
                    <div class="space-y-2">
                        @if($deal->stage->name != 'Won' && $deal->stage->name != 'Lost')
                            <form action="{{ route('deals.markWon', $deal) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full px-4 py-2.5 bg-green-500/10 hover:bg-green-500/20 text-green-500 rounded-xl font-bold text-sm transition border border-green-500/20">
                                    Mark as Won
                                </button>
                            </form>
                            <form action="{{ route('deals.markLost', $deal) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full px-4 py-2.5 bg-red-500/10 hover:bg-red-500/20 text-red-500 rounded-xl font-bold text-sm transition border border-red-500/20">
                                    Mark as Lost
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                {{-- Related Items --}}
                <div class="glass-card rounded-2xl p-6 border border-white/10">
                    <h3 class="text-sm font-black text-gray-400 mb-4 uppercase tracking-wider">Related Items</h3>
                    <div class="space-y-3">
                        @php
                            $invoices = $deal->invoices ?? collect();
                        @endphp
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider mb-2">Invoices</p>
                            @if($invoices->count() > 0)
                                <div class="space-y-2">
                                    @foreach($invoices as $invoice)
                                        <a href="{{ route('invoices.show', $invoice) }}"
                                            class="block p-2 bg-white/5 hover:bg-white/10 rounded-lg transition">
                                            <p class="text-white text-sm font-bold">#{{ $invoice->invoice_number }}</p>
                                            <p class="text-gray-500 text-xs">${{ number_format($invoice->total, 2) }}</p>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-600 text-xs">No invoices</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection