@extends('layouts.app')

@section('header', 'Sales Dashboard')

@section('content')
    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
        @include('dashboard.partials.sales-stats')
    </div>

    {{-- Charts and Activity --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Sales Funnel --}}
        <div class="glass-card rounded-2xl p-6 border border-white/10">
            <h3 class="text-lg font-black text-white mb-4 uppercase tracking-wider text-orange-500">Sales Funnel</h3>
            <canvas id="salesFunnelChart"></canvas>
        </div>

        {{-- Recent Activity --}}
        <div class="glass-card rounded-2xl p-6 border border-white/10">
            <h3 class="text-lg font-black text-white mb-4 uppercase tracking-wider text-orange-500">Recent Activity</h3>
            <div class="space-y-3">
                @forelse($recentActivity ?? [] as $activity)
                    <div class="flex items-start gap-3 p-3 rounded-lg bg-white/5 hover:bg-white/10 transition">
                        <div
                            class="w-8 h-8 rounded-full bg-orange-500/20 text-orange-500 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-white truncate">{{ $activity['title'] }}</p>
                            <p class="text-xs text-gray-400">{{ $activity['description'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $activity['time'] }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-8">No recent activity</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Chart.js Script --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const salesCtx = document.getElementById('salesFunnelChart').getContext('2d');
        new Chart(salesCtx, {
            type: 'bar',
            data: {
                labels: ['Leads', 'Qualified', 'Proposals', 'Negotiations', 'Closed Won'],
                datasets: [{
                    label: 'Count',
                    data: [{{ $salesFunnelData['leads'] ?? 0 }}, {{ $salesFunnelData['qualified'] ?? 0 }}, {{ $salesFunnelData['proposals'] ?? 0 }}, {{ $salesFunnelData['negotiations'] ?? 0 }}, {{ $salesFunnelData['won'] ?? 0 }}],
                    backgroundColor: 'rgba(255, 115, 0, 0.8)',
                    borderColor: '#ff7300',
                    borderWidth: 2,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { color: '#9ca3af' },
                        grid: { color: 'rgba(255, 255, 255, 0.05)' }
                    },
                    x: {
                        ticks: { color: '#9ca3af' },
                        grid: { display: false }
                    }
                }
            }
        });
    </script>
@endsection