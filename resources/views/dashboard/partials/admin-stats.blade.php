{{-- Total Pipeline --}}
<div class="stat-card rounded-2xl p-5">
    <div class="flex items-center justify-between mb-3">
        <div class="icon-glow w-12 h-12 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                </path>
            </svg>
        </div>
    </div>
    <div>
        <p class="text-gray-500 text-xs uppercase font-bold tracking-wider mb-1">TOTAL PIPELINE</p>
        <h3 class="text-3xl font-black text-white mb-1">{{ $totalPipeline ?? '$880,214' }}</h3>
        <p class="text-xs text-gray-600 font-medium">Across all stages</p>
    </div>
</div>

{{-- Won Deals --}}
<div class="stat-card rounded-2xl p-5">
    <div class="flex items-center justify-between mb-3">
        <div class="icon-glow w-12 h-12 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                </path>
            </svg>
        </div>
    </div>
    <div>
        <p class="text-gray-500 text-xs uppercase font-bold tracking-wider mb-1">WON DEALS</p>
        <h3 class="text-3xl font-black text-white mb-1">{{ $wonDeals ?? '$120,733' }}</h3>
        <p class="text-xs text-green-500 font-bold">↑ {{ $wonDealsCount ?? '2' }} deals closed</p>
    </div>
</div>

{{-- Active Customers --}}
<div class="stat-card rounded-2xl p-5">
    <div class="flex items-center justify-between mb-3">
        <div class="icon-glow w-12 h-12 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                </path>
            </svg>
        </div>
    </div>
    <div>
        <p class="text-gray-500 text-xs uppercase font-bold tracking-wider mb-1">ACTIVE CUSTOMERS</p>
        <h3 class="text-3xl font-black text-white mb-1">{{ $activeCustomers ?? '2' }}</h3>
        <p class="text-xs text-gray-600 font-medium">Enterprise clients</p>
    </div>
</div>

{{-- Overdue Invoices --}}
<div class="stat-card rounded-2xl p-5">
    <div class="flex items-center justify-between mb-3">
        <div class="icon-glow w-12 h-12 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
    </div>
    <div>
        <p class="text-gray-500 text-xs uppercase font-bold tracking-wider mb-1">OVERDUE</p>
        <h3 class="text-3xl font-black text-red-500 mb-1">{{ $overdueReceivables ?? '$18,500' }}</h3>
        <p class="text-xs text-red-400 font-bold">{{ $overdueCount ?? '1' }} invoices</p>
    </div>
</div>