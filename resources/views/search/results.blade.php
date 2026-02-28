<x-app-layout>
    @section('header', 'Search Results')

    <div class="space-y-8">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-black text-white">Search Results</h1>
                <p class="text-gray-400 mt-1">Found results for <span class="text-orange-500 font-bold">"{{ $query }}"</span></p>
            </div>
            <a href="{{ url()->previous() }}" class="text-gray-400 hover:text-white transition flex items-center gap-2 text-sm font-bold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back
            </a>
        </div>

        @if($deals->isEmpty() && $leads->isEmpty() && $invoices->isEmpty())
             <div class="glass-card rounded-2xl p-12 text-center">
                <svg class="w-16 h-16 text-gray-700 mb-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <p class="text-gray-500 text-lg font-bold mb-2">No results found</p>
                <p class="text-gray-600 text-sm">Try using different keywords or check for typos.</p>
            </div>
        @endif

        <!-- Deals -->
        @if($deals->isNotEmpty())
            <section>
                <h2 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                    <span class="bg-orange-500 w-2 h-6 rounded-full"></span>
                    Deals
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($deals as $deal)
                        <div class="glass-card rounded-2xl p-5 hover:bg-white/5 transition group cursor-pointer" 
                             onclick="window.location='{{ route('deals.kanban') }}?search={{ $deal->name }}'">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="text-white font-bold group-hover:text-orange-500 transition">{{ $deal->name }}</h3>
                                    <p class="text-gray-500 text-sm">{{ $deal->lead->company ?? 'Unknown Company' }}</p>
                                </div>
                                <span class="px-2 py-1 rounded-lg text-xs font-bold bg-white/5 text-gray-300">
                                    {{ $deal->stage->name ?? 'Unknown' }}
                                </span>
                            </div>
                            <p class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-amber-500 font-black text-xl">
                                ${{ number_format($deal->value, 0) }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Invoices -->
        @if($invoices->isNotEmpty())
            <section>
                <h2 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                    <span class="bg-blue-500 w-2 h-6 rounded-full"></span>
                    Invoices
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($invoices as $invoice)
                        <div class="glass-card rounded-2xl p-5 hover:bg-white/5 transition group cursor-pointer"
                             onclick="window.location='{{ route('invoices.show', $invoice) }}'">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="text-white font-bold group-hover:text-orange-500 transition">{{ $invoice->invoice_number }}</h3>
                                    <p class="text-gray-500 text-sm">{{ $invoice->deal->lead->company ?? 'Unknown Client' }}</p>
                                </div>
                                <span class="px-2 py-1 rounded-lg text-xs font-bold 
                                    {{ $invoice->status === 'paid' ? 'bg-green-500/20 text-green-400' : ($invoice->status === 'overdue' ? 'bg-red-500/20 text-red-400' : 'bg-amber-500/20 text-amber-400') }}">
                                    {{ ucfirst($invoice->status) }}
                                </span>
                            </div>
                            <p class="font-bold text-white text-lg">
                                ${{ number_format($invoice->total, 2) }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Leads -->
        @if($leads->isNotEmpty())
            <section>
                <h2 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                    <span class="bg-purple-500 w-2 h-6 rounded-full"></span>
                    Contacts & Leads
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($leads as $lead)
                        <div class="glass-card rounded-2xl p-5 hover:bg-white/5 transition group">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-white font-bold group-hover:text-orange-500 transition">{{ $lead->company }}</h3>
                                <span class="text-xs font-bold text-gray-500 uppercase">{{ $lead->status }}</span>
                            </div>
                            <div class="space-y-1">
                                <p class="text-gray-400 text-sm flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    {{ $lead->contact_name }}
                                </p>
                                <p class="text-gray-400 text-sm flex items-center gap-2">
                                     <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $lead->email }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</x-app-layout>
