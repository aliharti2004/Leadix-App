
<div class="glass-card rounded-2xl p-6 border border-white/10">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wide">Cash Collected (MTD)</h3>
        <div class="p-3 bg-green-500/20 rounded-xl">
            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                </path>
            </svg>
        </div>
    </div>
    <div class="flex items-baseline">
        <h2 class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-orange-600">
            $<?php echo e(number_format($totalCashCollected ?? 66500, 0)); ?>

        </h2>
        <span class="ml-2 text-sm font-medium text-green-500">+12%</span>
    </div>
</div>


<div class="glass-card rounded-2xl p-6 border border-white/10">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wide">Pending Invoices</h3>
        <div class="p-3 bg-amber-500/20 rounded-xl">
            <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                </path>
            </svg>
        </div>
    </div>
    <div class="flex items-baseline">
        <h2 class="text-3xl font-black text-white"><?php echo e($pendingInvoicesCount ?? 14); ?></h2>
        <span class="ml-2 text-sm font-medium text-gray-400">Value:
            $<?php echo e(number_format($pendingInvoicesValue ?? 42750, 0)); ?></span>
    </div>
</div>


<div class="glass-card rounded-2xl p-6 border border-white/10">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wide">Avg. Days to Pay</h3>
        <div class="p-3 bg-blue-500/20 rounded-xl">
            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
    </div>
    <div class="flex items-baseline">
        <h2 class="text-3xl font-black text-white"><?php echo e($averageDaysToPay ?? 42); ?></h2>
        <span class="ml-2 text-sm font-medium text-red-500">+2 days</span>
    </div>
</div>


<div class="glass-card rounded-2xl p-6 border border-white/10">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wide">Est. Tax Liability</h3>
        <div class="p-3 bg-purple-500/20 rounded-xl">
            <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3">
                </path>
            </svg>
        </div>
    </div>
    <div class="flex items-baseline">
        <h2 class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-orange-600">
            $<?php echo e(number_format($totalTaxLiability ?? 66000, 0)); ?>

        </h2>
        <span class="ml-2 text-sm font-medium text-gray-500">Updated today</span>
    </div>
</div>

<style>
    .glass-card {
        background: rgba(20, 20, 20, 0.6);
        backdrop-filter: blur(10px);
    }
</style><?php /**PATH C:\Users\dell\.gemini\antigravity\scratch\leadix-app\resources\views/dashboard/partials/finance-stats.blade.php ENDPATH**/ ?>