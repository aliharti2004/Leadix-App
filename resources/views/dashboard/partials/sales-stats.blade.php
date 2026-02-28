{{-- My Active Leads --}}
<div class="glass-card rounded-2xl p-6 border border-white/10 hover:border-orange-500/30 transition-all group">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">My Active Leads</h3>
        <div class="p-2 bg-orange-500/10 rounded-lg group-hover:bg-orange-500/20 transition">
            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                </path>
            </svg>
        </div>
    </div>
    <div class="flex items-baseline">
        <h2 class="text-3xl font-black text-white">{{ $myActiveLeads ?? '0' }}</h2>
        <span class="ml-2 text-xs font-bold text-green-500">+5 this week</span>
    </div>
</div>

{{-- Deals in Negotiation --}}
<div class="glass-card rounded-2xl p-6 border border-white/10 hover:border-orange-500/30 transition-all group">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Deals in Negotiation</h3>
        <div class="p-2 bg-blue-500/10 rounded-lg group-hover:bg-blue-500/20 transition">
            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                </path>
            </svg>
        </div>
    </div>
    <div class="flex items-baseline">
        <h2 class="text-3xl font-black text-white">{{ $dealsInNegotiation ?? '0' }}</h2>
        <span class="ml-2 text-xs font-semibold text-gray-500">Avg. size: $5k</span>
    </div>
</div>

{{-- Weighted Forecast --}}
<div class="glass-card rounded-2xl p-6 border border-white/10 hover:border-orange-500/30 transition-all group">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Weighted Pipeline</h3>
        <div class="p-2 bg-purple-500/10 rounded-lg group-hover:bg-purple-500/20 transition">
            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
            </svg>
        </div>
    </div>
    <div class="flex items-baseline">
        <h2 class="text-3xl font-black text-white">${{ number_format($weightedForecast ?? 0, 0) }}</h2>
        <span class="ml-2 text-xs font-bold text-green-500">On Track</span>
    </div>
</div>

{{-- Win Rate % --}}
<div class="glass-card rounded-2xl p-6 border border-white/10 hover:border-orange-500/30 transition-all group">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Win Rate</h3>
        <div class="p-2 bg-yellow-500/10 rounded-lg group-hover:bg-yellow-500/20 transition">
            <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                </path>
            </svg>
        </div>
    </div>
    <div class="flex items-baseline">
        <h2 class="text-3xl font-black text-white">{{ $winRate ?? '0%' }}</h2>
        <span class="ml-2 text-xs font-bold text-green-500">+2% vs Avg</span>
    </div>
</div>

<style>
    .glass-card {
        background: rgba(20, 20, 20, 0.6);
        backdrop-filter: blur(10px);
    }
</style>