@extends('layouts.app')

@section('header', 'Reports & Analytics')

@section('content')
    <style>
        .glass-card {
            background: rgba(20, 20, 20, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 115, 0, 0.1);
        }

        .stat-card {
            background: rgba(20, 20, 20, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 115, 0, 0.1);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            border-color: rgba(255, 115, 0, 0.3);
            transform: translateY(-2px);
        }
    </style>

    <div>
        <header class="mb-8">
            <h2 class="text-2xl font-black text-white mb-2">Reports & Analytics</h2>
            <p class="text-gray-400 font-medium">Insights into your sales performance and financial health.</p>
        </header>

        <!-- Key Metrics Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Total Revenue -->
            <div class="stat-card rounded-2xl p-6 relative overflow-hidden group">
                <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition">
                    <svg class="w-24 h-24 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="relative z-10">
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Total Revenue</p>
                    <h3 class="text-3xl font-black text-white">${{ number_format($totalRevenue, 2) }}</h3>
                    <p class="text-green-500 text-xs mt-2 font-bold flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                        Paid Invoices
                    </p>
                </div>
            </div>

            <!-- Pipeline Value -->
            <div class="stat-card rounded-2xl p-6 relative overflow-hidden group">
                <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition">
                    <svg class="w-24 h-24 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                    </svg>
                </div>
                <div class="relative z-10">
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Pipeline Value</p>
                    <h3 class="text-3xl font-black text-white">${{ number_format($pipelineValue, 2) }}</h3>
                    <p class="text-orange-500 text-xs mt-2 font-bold flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        Open Deals
                    </p>
                </div>
            </div>

            <!-- Win Rate -->
            <div class="stat-card rounded-2xl p-6 relative overflow-hidden group">
                <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition">
                    <svg class="w-24 h-24 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="relative z-10">
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Win Rate</p>
                    <h3 class="text-3xl font-black text-white">{{ $winRate }}%</h3>
                    <p class="text-blue-500 text-xs mt-2 font-bold flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Closed Deals
                    </p>
                </div>
            </div>

            <!-- Active Deals -->
            <div class="stat-card rounded-2xl p-6 relative overflow-hidden group">
                <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition">
                    <svg class="w-24 h-24 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                        <path fill-rule="evenodd"
                            d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="relative z-10">
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Active Deals</p>
                    <h3 class="text-3xl font-black text-white">{{ $activeDeals }}</h3>
                    <p class="text-purple-500 text-xs mt-2 font-bold flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        In Progress
                    </p>
                </div>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Deals by Stage Chart -->
            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-lg font-bold text-white mb-6 uppercase tracking-wide text-orange-500">Deals by Stage</h3>
                <div class="relative" style="height: 300px;">
                    <canvas id="dealsByStageChart"></canvas>
                </div>
            </div>

            <!-- Revenue Trend Chart -->
            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-lg font-bold text-white mb-6 uppercase tracking-wide text-orange-500">Revenue Trend (6
                    Months)</h3>
                <div class="relative" style="height: 300px;">
                    <canvas id="revenueTrendChart"></canvas>
                </div>
            </div>

            <!-- Invoice Status Breakdown -->
            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-lg font-bold text-white mb-6 uppercase tracking-wide text-orange-500">Invoice Status</h3>
                <div class="relative" style="height: 300px;">
                    <canvas id="invoiceStatusChart"></canvas>
                </div>
            </div>

            <!-- Monthly Performance -->
            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-lg font-bold text-white mb-6 uppercase tracking-wide text-orange-500">Won Deals by Month
                </h3>
                <div class="relative" style="height: 300px;">
                    <canvas id="monthlyPerformanceChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart.js Script --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Data from Controller
            const dealsData = @json($dealsByStage);
            const revenueData = @json($revenueTrend);
            const invoiceData = @json($invoicesByStatus);
            const monthlyData = @json($monthlyPerformance);

            // Chart defaults
            Chart.defaults.color = '#9ca3af';
            Chart.defaults.font.family = 'Inter, system-ui, sans-serif';

            // 1. Deals by Stage Chart - Bar
            const dealsCtx = document.getElementById('dealsByStageChart').getContext('2d');
            new Chart(dealsCtx, {
                type: 'bar',
                data: {
                    labels: dealsData.map(d => d.stage),
                    datasets: [{
                        label: 'Number of Deals',
                        data: dealsData.map(d => d.count),
                        backgroundColor: 'rgba(255, 115, 0, 0.8)',
                        borderColor: '#ff7300',
                        borderWidth: 2,
                        borderRadius: 8,
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(20, 20, 20, 0.95)',
                            titleColor: '#fff',
                            bodyColor: '#cbd5e1',
                            borderColor: 'rgba(255, 115, 0, 0.5)',
                            borderWidth: 1,
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                label: function (context) {
                                    const value = context.raw;
                                    const dealValue = dealsData[context.dataIndex].value;
                                    return `${value} deals ($${new Intl.NumberFormat('en-US').format(dealValue)})`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(255, 255, 255, 0.05)' },
                            ticks: {
                                color: '#9ca3af',
                                stepSize: 1,
                                callback: (value) => Math.round(value)
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#9ca3af' }
                        }
                    }
                }
            });

            // 2. Revenue Trend Chart - Line
            const revenueCtx = document.getElementById('revenueTrendChart').getContext('2d');
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: revenueData.map(d => d.month),
                    datasets: [{
                        label: 'Revenue',
                        data: revenueData.map(d => d.total),
                        borderColor: '#22c55e',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        borderWidth: 3,
                        pointBackgroundColor: '#22c55e',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(20, 20, 20, 0.95)',
                            titleColor: '#fff',
                            bodyColor: '#cbd5e1',
                            borderColor: 'rgba(34, 197, 94, 0.5)',
                            borderWidth: 1,
                            padding: 12,
                            cornerRadius: 8,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(255, 255, 255, 0.05)' },
                            ticks: {
                                color: '#9ca3af',
                                callback: function (value) {
                                    return '$' + new Intl.NumberFormat('en-US', { notation: "compact" }).format(value);
                                }
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#9ca3af' }
                        }
                    }
                }
            });

            // 3. Invoice Status Chart - Doughnut
            const invoiceCtx = document.getElementById('invoiceStatusChart').getContext('2d');
            new Chart(invoiceCtx, {
                type: 'doughnut',
                data: {
                    labels: invoiceData.map(d => d.status.charAt(0).toUpperCase() + d.status.slice(1)),
                    datasets: [{
                        data: invoiceData.map(d => d.count),
                        backgroundColor: [
                            'rgba(107, 114, 128, 0.8)',  // draft - gray
                            'rgba(251, 146, 60, 0.8)',   // sent - orange
                            'rgba(34, 197, 94, 0.8)',    // paid - green
                            'rgba(239, 68, 68, 0.8)',    // overdue - red
                        ],
                        borderColor: [
                            '#6b7280',
                            '#fb923c',
                            '#22c55e',
                            '#ef4444',
                        ],
                        borderWidth: 2,
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                color: '#9ca3af',
                                padding: 15,
                                font: { size: 12, weight: 'bold' }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(20, 20, 20, 0.95)',
                            titleColor: '#fff',
                            bodyColor: '#cbd5e1',
                            borderColor: 'rgba(255, 115, 0, 0.5)',
                            borderWidth: 1,
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                label: function (context) {
                                    const total = invoiceData[context.dataIndex].total;
                                    return `${context.label}: ${context.raw} invoices ($${new Intl.NumberFormat('en-US').format(total)})`;
                                }
                            }
                        }
                    }
                }
            });

            // 4. Monthly Performance Chart - Bar
            const monthlyCtx = document.getElementById('monthlyPerformanceChart').getContext('2d');
            new Chart(monthlyCtx, {
                type: 'bar',
                data: {
                    labels: monthlyData.map(d => d.month),
                    datasets: [{
                        label: 'Won Deals',
                        data: monthlyData.map(d => d.count),
                        backgroundColor: 'rgba(59, 130, 246, 0.8)',
                        borderColor: '#3b82f6',
                        borderWidth: 2,
                        borderRadius: 8,
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(20, 20, 20, 0.95)',
                            titleColor: '#fff',
                            bodyColor: '#cbd5e1',
                            borderColor: 'rgba(59, 130, 246, 0.5)',
                            borderWidth: 1,
                            padding: 12,
                            cornerRadius: 8,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(255, 255, 255, 0.05)' },
                            ticks: {
                                color: '#9ca3af',
                                stepSize: 1,
                                callback: (value) => Math.round(value)
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#9ca3af' }
                        }
                    }
                }
            });
        });
    </script>
@endsection