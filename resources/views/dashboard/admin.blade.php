@extends('layouts.app')

@section('header', 'Dashboard')

@section('content')
    <style>
        /* Card Hover Effects */
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

        /* Icon Glow */
        .icon-glow {
            background: rgba(255, 115, 0, 0.1);
            box-shadow: 0 0 20px rgba(255, 115, 0, 0.3);
            transition: all 0.3s ease;
        }

        .stat-card:hover .icon-glow {
            box-shadow: 0 0 30px rgba(255, 115, 0, 0.6);
            background: rgba(255, 115, 0, 0.2);
        }

        /* Glassmorphism */
        .glass-card {
            background: rgba(20, 20, 20, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 115, 0, 0.1);
        }
    </style>

    {{-- Dashboard Content --}}
    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
        {{-- Total Pipeline --}}
        <div class="stat-card rounded-2xl p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="icon-glow w-12 h-12 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-gray-500 text-xs uppercase font-bold tracking-wider mb-1">TOTAL PIPELINE</p>
                <h3 class="text-3xl font-black text-white">${{ number_format($totalPipeline ?? 0) }}</h3>
                <p class="text-xs text-gray-600 font-medium mt-1">Across all stages</p>
            </div>
        </div>

        {{-- Won Deals --}}
        <div class="stat-card rounded-2xl p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="icon-glow w-12 h-12 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-gray-500 text-xs uppercase font-bold tracking-wider mb-1">WON DEALS</p>
                <h3 class="text-3xl font-black text-white">${{ number_format($monthlyRecurringRevenue ?? 0) }}</h3>
                <p class="text-xs text-green-500 font-bold mt-1">↑ {{ $wonDeals ?? 0 }} deals closed</p>
            </div>
        </div>

        {{-- Active Customers --}}
        <div class="stat-card rounded-2xl p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="icon-glow w-12 h-12 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-gray-500 text-xs uppercase font-bold tracking-wider mb-1">ACTIVE CUSTOMERS</p>
                <h3 class="text-3xl font-black text-white">{{ $activeCustomers ?? 0 }}</h3>
                <p class="text-xs text-gray-600 font-medium mt-1">Enterprise clients</p>
            </div>
        </div>

        {{-- Overdue --}}
        <div class="stat-card rounded-2xl p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="icon-glow w-12 h-12 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-gray-500 text-xs uppercase font-bold tracking-wider mb-1">OVERDUE</p>
                <h3 class="text-3xl font-black text-red-500">${{ number_format($overdueReceivables ?? 0) }}</h3>
                <p class="text-xs text-red-400 font-bold mt-1">{{ $overdueInvoices ?? 0 }} invoices</p>
            </div>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Pipeline Overview --}}
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-lg font-black text-white mb-4 uppercase tracking-wider text-orange-500">Pipeline Overview</h3>
            <canvas id="pipelineChart"></canvas>
        </div>

        {{-- Revenue Trend --}}
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-lg font-black text-white mb-4 uppercase tracking-wider text-orange-500">Revenue Trend</h3>
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    {{-- Chart.js Script --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Pipeline Chart - DYNAMIC DATA
        const pipelineData = @json($pipelineChartData);
        const pipelineCtx = document.getElementById('pipelineChart').getContext('2d');
        new Chart(pipelineCtx, {
            type: 'bar',
            data: {
                labels: pipelineData.map(d => d.stage),
                datasets: [{
                    label: 'Deal Value ($)',
                    data: pipelineData.map(d => d.value),
                    backgroundColor: 'rgba(255, 115, 0, 0.8)',
                    borderColor: '#ff7300',
                    borderWidth: 2,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                onClick: (e, items) => {
                    if (items.length > 0) {
                        const stage = pipelineData[items[0].index].stage;
                        window.location.href = `/deals/kanban?stage=${encodeURIComponent(stage)}`;
                    }
                },
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
                            label: (context) => {
                                const data = pipelineData[context.dataIndex];
                                return [
                                    `Value: $${data.value.toLocaleString()}`,
                                    `Deals: ${data.count}`
                                ];
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#9ca3af',
                            callback: (value) => '$' + value.toLocaleString()
                        },
                        grid: { color: 'rgba(255, 255, 255, 0.05)' }
                    },
                    x: {
                        ticks: { color: '#9ca3af' },
                        grid: { display: false }
                    }
                }
            }
        });

        // Revenue Chart - DYNAMIC DATA
        const revenueData = @json($revenueChartData);
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: revenueData.map(d => d.month),
                datasets: [{
                    label: 'Revenue',
                    data: revenueData.map(d => d.revenue),
                    borderColor: '#ff7300',
                    backgroundColor: 'rgba(255, 115, 0, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#ff7300',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
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
                            label: (context) => {
                                return `Revenue: $${context.parsed.y.toLocaleString()}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#9ca3af',
                            callback: (value) => '$' + value.toLocaleString()
                        },
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