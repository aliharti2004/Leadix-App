

<?php $__env->startSection('header', 'Finance Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
        <?php echo $__env->make('dashboard.partials.finance-stats', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <div class="glass-card rounded-2xl p-6 border border-white/10">
            <h3 class="text-lg font-black text-white mb-4 uppercase tracking-wider text-orange-500">Revenue vs Expenses</h3>
            <canvas id="revenueExpensesChart"></canvas>
        </div>

        
        <div class="glass-card rounded-2xl p-6 border border-white/10">
            <h3 class="text-lg font-black text-white mb-4 uppercase tracking-wider text-orange-500">Cash Flow</h3>
            <canvas id="cashFlowChart"></canvas>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Revenue vs Expenses Chart
        const revenueExpensesCtx = document.getElementById('revenueExpensesChart').getContext('2d');
        new Chart(revenueExpensesCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($monthLabels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']); ?>,
                datasets: [{
                    label: 'Revenue',
                    data: <?php echo json_encode($revenueData ?? [45000, 52000, 48000, 61000, 79000, 94000]); ?>,
                    backgroundColor: 'rgba(34, 197, 94, 0.8)',
                    borderColor: '#22c55e',
                    borderWidth: 2,
                    borderRadius: 8
                }, {
                    label: 'Expenses',
                    data: <?php echo json_encode($expensesData ?? [25000, 28000, 26000, 32000, 38000, 41000]); ?>,
                    backgroundColor: 'rgba(239, 68, 68, 0.8)',
                    borderColor: '#ef4444',
                    borderWidth: 2,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        labels: { color: '#9ca3af' }
                    }
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

        // Cash Flow Chart
        const cashFlowCtx = document.getElementById('cashFlowChart').getContext('2d');
        new Chart(cashFlowCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($monthLabels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']); ?>,
                datasets: [{
                    label: 'Net Cash Flow',
                    data: <?php echo json_encode($cashFlowData ?? [20000, 24000, 22000, 29000, 41000, 53000]); ?>,
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
                    legend: {
                        display: true,
                        labels: { color: '#9ca3af' }
                    }
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\dell\.gemini\antigravity\scratch\leadix-app\resources\views/dashboard/finance.blade.php ENDPATH**/ ?>