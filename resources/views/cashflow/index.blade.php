<x-app-layout>

    <style>
        .stat-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 115, 0, 0.1);
            background: rgba(20, 20, 20, 0.6);
            backdrop-filter: blur(10px);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            border-color: rgba(255, 115, 0, 0.5);
            box-shadow: 0 12px 40px rgba(255, 115, 0, 0.2);
            background: rgba(30, 30, 30, 0.8);
        }

        .icon-glow {
            background: rgba(255, 115, 0, 0.1);
            box-shadow: 0 0 20px rgba(255, 115, 0, 0.3);
            transition: all 0.3s ease;
        }

        .stat-card:hover .icon-glow {
            box-shadow: 0 0 30px rgba(255, 115, 0, 0.6);
            background: rgba(255, 115, 0, 0.2);
        }

        .btn-gradient {
            background: linear-gradient(135deg, #ff7300 0%, #ff9500 100%);
            box-shadow: 0 4px 20px rgba(255, 115, 0, 0.3);
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            box-shadow: 0 8px 30px rgba(255, 115, 0, 0.5);
            transform: translateY(-2px) scale(1.05);
        }

        .glass-card {
            background: rgba(20, 20, 20, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 115, 0, 0.1);
        }
    </style>

    <!-- Page Header & Filter -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-end gap-4">
        <select onchange="window.location.href = '?range=' + this.value"
            class="glass-card text-white text-sm rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 bg-black/20 cursor-pointer">
            <option value="6_months" {{ request('range') == '6_months' ? 'selected' : '' }}>Last 6 Months</option>
            <option value="12_months" {{ request('range') == '12_months' ? 'selected' : '' }}>Last 12 Months</option>
            <option value="this_year" {{ request('range') == 'this_year' ? 'selected' : '' }}>This Year</option>
        </select>
    </div>

    <!-- Top Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Current Balance -->
        <div class="stat-card rounded-2xl p-6">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-xl icon-glow flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                    </svg>
                </div>
            </div>
            <p class="text-gray-500 text-xs font-bold uppercase mb-1">Current Balance</p>
            <p class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-amber-500 text-3xl font-black">
                ${{ number_format($stats['balance'], 0) }}
            </p>
            <p
                class="{{ $stats['growth'] >= 0 ? 'text-green-400 bg-green-500/10' : 'text-red-400 bg-red-500/10' }} text-xs mt-2 font-medium inline-block px-2 py-1 rounded-lg">
                {{ $stats['growth'] >= 0 ? '+' : '' }}{{ number_format($stats['growth'], 1) }}% vs last month
            </p>
        </div>

        <!-- Total Income -->
        <div class="stat-card rounded-2xl p-6">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-green-500/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 11l5-5m0 0l5 5m-5-5v12" />
                    </svg>
                </div>
            </div>
            <p class="text-gray-500 text-xs font-bold uppercase mb-1">Total Income</p>
            <p class="text-white text-3xl font-black">${{ number_format($stats['income'], 0) }}</p>
            <p class="text-gray-500 text-xs mt-2 font-medium">From paid invoices</p>
        </div>

        <!-- Total Expenses -->
        <div class="stat-card rounded-2xl p-6">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-red-500/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                    </svg>
                </div>
            </div>
            <p class="text-gray-500 text-xs font-bold uppercase mb-1">Total Expenses</p>
            <p class="text-white text-3xl font-black">${{ number_format($stats['expenses'], 0) }}</p>
            <p class="text-gray-500 text-xs mt-2 font-medium">Operational costs</p>
        </div>
    </div>

    <!-- Cashflow Timeline Chart -->
    <div class="glass-card rounded-2xl p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-white font-black text-lg">
                Cashflow Timeline
                <span class="text-gray-500 text-sm font-medium ml-2">
                    ({{ request('range') == '12_months' ? 'Last 12 Months' : (request('range') == 'this_year' ? 'This Year' : 'Last 6 Months') }})
                </span>
            </h3>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                    <span class="text-gray-400 text-xs font-medium">Income</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                    <span class="text-gray-400 text-xs font-medium">Expenses</span>
                </div>
            </div>
        </div>
        <div style="position: relative; height: 350px;">
            <canvas id="cashflowChart"></canvas>
        </div>
    </div>

    <!-- Forecast & Receivables -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Revenue Forecast -->
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-white font-black text-lg mb-6">Revenue Forecast</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-white/5 rounded-xl border border-white/5">
                    <div>
                        <p class="text-gray-500 text-xs font-bold uppercase mb-1">Next 30 Days</p>
                        <p class="text-white text-xl font-black">${{ number_format($forecast['30'], 0) }}</p>
                    </div>
                </div>

                <div class="flex items-center justify-between p-4 bg-white/5 rounded-xl border border-white/5">
                    <div>
                        <p class="text-gray-500 text-xs font-bold uppercase mb-1">Next 60 Days</p>
                        <p class="text-white text-xl font-black">${{ number_format($forecast['60'], 0) }}</p>
                    </div>
                </div>

                <div class="flex items-center justify-between p-4 bg-white/5 rounded-xl border border-white/5">
                    <div>
                        <p class="text-gray-500 text-xs font-bold uppercase mb-1">Next 90 Days</p>
                        <p class="text-white text-xl font-black">${{ number_format($forecast['90'], 0) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Outstanding Receivables -->
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-white font-black text-lg mb-6">Outstanding Receivables</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-white/5 rounded-xl border border-white/5">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-white text-sm font-bold">Pending</p>
                            <p class="text-gray-500 text-xs">{{ $receivables['pending_count'] }} invoices</p>
                        </div>
                    </div>
                    <p class="text-white font-black text-lg">${{ number_format($receivables['pending_amount'], 0) }}</p>
                </div>

                <div class="flex items-center justify-between p-4 bg-white/5 rounded-xl border border-white/5">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-red-500/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-white text-sm font-bold">Overdue</p>
                            <p class="text-gray-500 text-xs text-red-400">{{ $receivables['overdue_count'] }} invoices
                            </p>
                        </div>
                    </div>
                    <p class="text-red-400 font-black text-lg">${{ number_format($receivables['overdue_amount'], 0) }}
                    </p>
                </div>

                <div class="pt-4 border-t border-white/5 mt-2">
                    <div class="flex items-center justify-between">
                        <p class="text-gray-500 text-xs font-bold uppercase">Total Outstanding</p>
                        <p
                            class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-amber-500 text-2xl font-black">
                            ${{ number_format($receivables['total_outstanding'], 0) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Config -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('cashflowChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chart['labels']),
                    datasets: [
                        {
                            label: 'Income',
                            data: @json($chart['income']),
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#10b981',
                            pointBorderColor: '#0a0a0a',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        },
                        {
                            label: 'Expenses',
                            data: @json($chart['expenses']),
                            borderColor: '#ef4444',
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#ef4444',
                            pointBorderColor: '#0a0a0a',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(20, 20, 20, 0.9)',
                            titleColor: '#fff',
                            bodyColor: '#cbd5e1',
                            padding: 12,
                            borderColor: 'rgba(255,255,255,0.1)',
                            borderWidth: 1,
                            cornerRadius: 8,
                            displayColors: true,
                            boxPadding: 4
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: '#64748b',
                                font: { family: 'Inter', size: 11 },
                                callback: function (value) { return '$' + value.toLocaleString(); }
                            },
                            grid: { color: 'rgba(255, 255, 255, 0.05)' },
                            border: { display: false }
                        },
                        x: {
                            ticks: {
                                color: '#64748b',
                                font: { family: 'Inter', size: 11 }
                            },
                            grid: { display: false },
                            border: { display: false }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>