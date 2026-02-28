<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div x-data="invoiceKanbanApp()" class="flex flex-col min-h-[600px]">
        <style>
            /* Reuse premium styling from deals kanban */
            .invoice-card {
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                border: 1px solid rgba(255, 115, 0, 0.1);
                background: rgba(20, 20, 20, 0.6);
                backdrop-filter: blur(10px);
            }

            .invoice-card:hover {
                transform: translateY(-6px) scale(1.01);
                border-color: rgba(255, 115, 0, 0.5);
                box-shadow: 0 16px 50px rgba(255, 115, 0, 0.2), 0 0 35px rgba(255, 115, 0, 0.1);
                background: rgba(30, 30, 30, 0.8);
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

            /* Premium Select Styling */
            select {
                appearance: none;
                background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='rgb(251, 146, 60)' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
                background-repeat: no-repeat;
                background-position: right 0.75rem center;
                background-size: 1.25rem;
                padding-right: 2.5rem;
                cursor: pointer;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            select:hover {
                border-color: rgba(255, 115, 0, 0.4);
                background-color: rgba(0, 0, 0, 0.5);
                box-shadow: 0 0 0 3px rgba(255, 115, 0, 0.1);
            }

            select option {
                background-color: #1a1a1a;
                color: #ffffff;
            }

            input[type="date"] {
                color-scheme: dark;
            }
        </style>

        <!-- Enhanced Filter Bar -->
        <div class="mb-6 flex-shrink-0"
            x-data="{ showFilters: true, hasActiveFilters: <?php echo e(request()->hasAny(['status', 'min_amount', 'max_amount', 'date_from', 'date_to', 'quick_date', 'company', 'sort_by', 'priority']) ? 'true' : 'false'); ?> }">
            <!-- Top Row: Title and Actions -->
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <h2 class="text-lg font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filters
                    </h2>
                    <button @click="showFilters = !showFilters" class="text-gray-400 hover:text-orange-500 transition">
                        <svg class="w-5 h-5" :class="{ 'rotate-180': !showFilters }" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <span x-show="hasActiveFilters"
                        class="bg-orange-500/20 text-orange-400 px-3 py-1 rounded-full text-xs font-bold border border-orange-500/30">
                        Active
                    </span>
                </div>
                
                <!-- Create Invoice Button -->
                <a href="<?php echo e(route('invoices.create')); ?>" 
                   class="btn-gradient text-white px-6 py-2.5 rounded-xl font-bold text-sm flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Create Invoice
                </a>
            </div>

            <!-- Filter Panels -->
            <form action="<?php echo e(route('invoices.kanban')); ?>" method="GET" x-show="showFilters" x-transition>
                <div class="glass-card rounded-2xl p-5 space-y-4">
                    <!-- Row 1: Primary Filters -->
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <!-- Status Filter -->
                        <div>
                            <label class="flex items-center gap-2 text-xs font-bold text-gray-400 uppercase mb-2">
                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Status
                            </label>
                            <select name="status" onchange="this.form.submit()"
                                class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition text-sm">
                                <option value="">All Status</option>
                                <option value="draft" <?php echo e(request('status') == 'draft' ? 'selected' : ''); ?>>Draft</option>
                                <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>
                                    Sent/Pending</option>
                                <option value="paid" <?php echo e(request('status') == 'paid' ? 'selected' : ''); ?>>Paid</option>
                                <option value="overdue" <?php echo e(request('status') == 'overdue' ? 'selected' : ''); ?>>Overdue
                                </option>
                            </select>
                        </div>

                        <!-- Company Filter -->
                        <div>
                            <label class="flex items-center gap-2 text-xs font-bold text-gray-400 uppercase mb-2">
                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Company
                            </label>
                            <select name="company" onchange="this.form.submit()"
                                class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition text-sm">
                                <option value="">All Companies</option>
                                <?php $__currentLoopData = \App\Models\Lead::select('id', 'company')->distinct()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($lead->id); ?>" <?php echo e(request('company') == $lead->id ? 'selected' : ''); ?>>
                                        <?php echo e($lead->company); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- Priority (Amount-based) -->
                        <div>
                            <label class="flex items-center gap-2 text-xs font-bold text-gray-400 uppercase mb-2">
                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                </svg>
                                Priority
                            </label>
                            <select name="priority" onchange="this.form.submit()"
                                class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition text-sm">
                                <option value="">All Priority</option>
                                <option value="high" <?php echo e(request('priority') == 'high' ? 'selected' : ''); ?>>High ($10k+)
                                </option>
                                <option value="medium" <?php echo e(request('priority') == 'medium' ? 'selected' : ''); ?>>Medium
                                    ($5k-$10k)</option>
                                <option value="low" <?php echo e(request('priority') == 'low' ? 'selected' : ''); ?>>Low (<
                                        $5k)</option>
                            </select>
                        </div>

                        <!-- Quick Date Filter -->
                        <div>
                            <label class="flex items-center gap-2 text-xs font-bold text-gray-400 uppercase mb-2">
                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Quick Filter
                            </label>
                            <select name="quick_date" onchange="this.form.submit()"
                                class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition text-sm">
                                <option value="">All Time</option>
                                <option value="due_today" <?php echo e(request('quick_date') == 'due_today' ? 'selected' : ''); ?>>Due
                                    Today</option>
                                <option value="due_week" <?php echo e(request('quick_date') == 'due_week' ? 'selected' : ''); ?>>Due
                                    This Week</option>
                                <option value="overdue" <?php echo e(request('quick_date') == 'overdue' ? 'selected' : ''); ?>>Overdue
                                </option>
                            </select>
                        </div>

                        <!-- Sort By Filter -->
                        <div>
                            <label class="flex items-center gap-2 text-xs font-bold text-gray-400 uppercase mb-2">
                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                </svg>
                                Sort By
                            </label>
                            <select name="sort_by" onchange="this.form.submit()"
                                class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition text-sm">
                                <option value="newest" <?php echo e(request('sort_by', 'newest') == 'newest' ? 'selected' : ''); ?>>
                                    Newest First</option>
                                <option value="oldest" <?php echo e(request('sort_by') == 'oldest' ? 'selected' : ''); ?>>Oldest First
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Row 2: Advanced Filters -->
                    <div class="pt-4 border-t border-white/5">
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                            <div>
                                <label class="flex items-center gap-2 text-xs font-bold text-gray-400 uppercase mb-2">
                                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Min Amount
                                </label>
                                <input type="number" name="min_amount" value="<?php echo e(request('min_amount')); ?>"
                                    placeholder="$0"
                                    class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition text-sm placeholder-gray-500">
                            </div>

                            <div>
                                <label class="flex items-center gap-2 text-xs font-bold text-gray-400 uppercase mb-2">
                                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Max Amount
                                </label>
                                <input type="number" name="max_amount" value="<?php echo e(request('max_amount')); ?>"
                                    placeholder="No limit"
                                    class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition text-sm placeholder-gray-500">
                            </div>

                            <div>
                                <label class="flex items-center gap-2 text-xs font-bold text-gray-400 uppercase mb-2">
                                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Due From
                                </label>
                                <input type="date" name="date_from" value="<?php echo e(request('date_from')); ?>"
                                    class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition text-sm">
                            </div>

                            <div>
                                <label class="flex items-center gap-2 text-xs font-bold text-gray-400 uppercase mb-2">
                                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Due To
                                </label>
                                <input type="date" name="date_to" value="<?php echo e(request('date_to')); ?>"
                                    class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition text-sm">
                            </div>

                            <div class="flex gap-2">
                                <button type="submit"
                                    class="flex-1 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2.5 rounded-xl font-bold text-sm transition shadow-lg shadow-orange-500/20">
                                    Apply
                                </button>
                                <a href="<?php echo e(route('invoices.kanban')); ?>"
                                    class="flex-1 bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white px-4 py-2.5 rounded-xl font-bold text-sm transition border border-white/10 text-center">
                                    Clear
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Kanban Board -->
        <div class="flex-1 overflow-hidden -mx-6">
            <div class="overflow-x-auto overflow-y-hidden px-6 pb-4">
                <div class="flex gap-5 pb-4">
                    <?php $__currentLoopData = ['draft' => 'Draft', 'pending' => 'Sent/Pending', 'paid' => 'Paid', 'overdue' => 'Overdue']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statusKey => $statusName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex-shrink-0 flex flex-col min-h-[500px]" style="width: 340px;">
                            <!-- Column Header -->
                            <div class="mb-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span
                                        class="text-white font-bold text-sm uppercase tracking-wide"><?php echo e($statusName); ?></span>
                                    <span class="glass-card px-2 py-1 rounded-lg text-gray-400 text-xs font-bold">
                                        <?php echo e($invoicesByStatus->get($statusKey)?->count() ?? 0); ?>

                                    </span>
                                </div>
                                <p class="text-xs text-gray-600 font-semibold">
                                    $<?php echo e(number_format($invoicesByStatus->get($statusKey)?->sum('total') ?? 0, 0)); ?>

                                </p>
                            </div>

                            <!-- Invoice Cards -->
                            <div class="flex-1 overflow-y-auto space-y-3 pr-2" x-ref="status_<?php echo e($statusKey); ?>"
                                data-status="<?php echo e($statusKey); ?>"
                                style="scrollbar-width: thin; scrollbar-color: rgba(255,115,0,0.3) transparent;">

                                <?php $__empty_1 = true; $__currentLoopData = $invoicesByStatus->get($statusKey, collect()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="invoice-card rounded-2xl p-4 cursor-pointer relative"
                                        data-invoice-id="<?php echo e($invoice->id); ?>" @click="openDrawer(<?php echo e($invoice->id); ?>)">

                                        <!-- Header: Invoice Number & Status -->
                                        <div class="flex items-start justify-between gap-2 mb-3">
                                            <div class="flex-1">
                                                <p class="text-gray-500 text-xs font-semibold mb-1">INVOICE</p>
                                                <h4 class="text-white text-base font-bold"><?php echo e($invoice->invoice_number); ?></h4>
                                            </div>
                                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold uppercase border
                                                        <?php if($statusKey === 'paid'): ?> bg-green-500/20 text-green-400 border-green-500/30
                                                        <?php elseif($statusKey === 'overdue'): ?> bg-red-500/20 text-red-400 border-red-500/30
                                                        <?php elseif($statusKey === 'pending'): ?> bg-amber-500/20 text-amber-400 border-amber-500/30
                                                        <?php else: ?> bg-gray-500/20 text-gray-400 border-gray-500/30 <?php endif; ?>">
                                                <?php echo e($statusKey); ?>

                                            </span>
                                        </div>

                                        <!-- Company Name -->
                                        <div class="mb-3">
                                            <div class="flex items-center gap-2 text-white">
                                                <svg class="w-4 h-4 flex-shrink-0 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m" />
                                                </svg>
                                                <p class="text-sm font-bold truncate">
                                                    <?php if($invoice->deal && $invoice->deal->lead): ?>
                                                        <?php echo e($invoice->deal->lead->company); ?>

                                                    <?php else: ?>
                                                        <span class="text-gray-500">No Company</span>
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Amount - Large and Prominent -->
                                        <div class="mb-4">
                                            <p class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-amber-500 font-black text-3xl">
                                                $<?php echo e(number_format($invoice->total ?? 0, 0)); ?>

                                            </p>
                                        </div>

                                        <!-- Dates Section -->
                                        <div class="space-y-2 mb-3">
                                            <!-- Issue Date -->
                                            <div class="flex items-center justify-between text-xs">
                                                <span class="text-gray-500 font-semibold">Issued:</span>
                                                <span
                                                    class="text-gray-400 font-medium"><?php echo e($invoice->issue_date ? $invoice->issue_date->format('M d, Y') : 'N/A'); ?></span>
                                            </div>

                                            <!-- Due Date with Urgency -->
                                            <div class="flex items-center justify-between text-xs">
                                                <span class="text-gray-500 font-semibold">Due:</span>
                                                <?php if($invoice->due_date): ?>
                                                    <?php
                                                        $daysUntilDue = (int) now()->diffInDays($invoice->due_date, false);
                                                        $isOverdue = $daysUntilDue < 0 && $invoice->status !== 'paid';
                                                        $isDueSoon = $daysUntilDue >= 0 && $daysUntilDue <= 3 && $invoice->status !== 'paid';
                                                    ?>
                                                    <span
                                                        class="font-bold <?php echo e($isOverdue ? 'text-red-400' : ($isDueSoon ? 'text-amber-400' : 'text-gray-400')); ?>">
                                                        <?php echo e($invoice->due_date->format('M d, Y')); ?>

                                                        <?php if($isOverdue): ?>
                                                            (<?php echo e(abs($daysUntilDue)); ?>d overdue)
                                                        <?php elseif($isDueSoon && $invoice->status !== 'paid'): ?>
                                                            (<?php echo e($daysUntilDue); ?>d left)
                                                        <?php endif; ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-gray-400 font-medium">N/A</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <!-- Footer: Quick Actions -->
                                        <div class="pt-3 border-t border-white/5">
                                            <div class="flex items-center justify-between text-xs">
                                                <div class="flex items-center gap-1.5 text-gray-500">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    <span
                                                        class="font-semibold"><?php echo e($invoice->created_at->diffForHumans()); ?></span>
                                                </div>
                                                <div class="text-orange-500 font-bold flex items-center gap-1">
                                                    View
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M9 5l7 7-7 7" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="glass-card rounded-2xl p-8 text-center">
                                        <svg class="w-12 h-12 text-gray-700 mb-3 mx-auto" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="text-gray-600 text-xs font-medium">No invoices</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

        <!-- Toast Messages -->
        <div class="fixed bottom-6 right-6 toast-container space-y-3 z-10000" x-show="toasts.length > 0"
            style="display: none;">
            <template x-for="toast in toasts" :key="toast.id">
                <div class="glass-card rounded-2xl p-4 shadow-2xl flex items-center gap-3 min-w-[320px]"
                    :class="{'border-green-500': toast.type === 'success', 'border-red-500': toast.type === 'error'}">
                    <p class="text-white text-sm font-bold flex-1" x-text="toast.message"></p>
                    <button @click="dismissToast(toast.id)" class="text-gray-600 hover:text-orange-500 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </template>
        </div>
    </div>

    <script>
        function invoiceKanbanApp() {
            return {
                toasts: [],

                init() {
                    // Initialize Sortable for drag-and-drop
                    <?php $__currentLoopData = ['draft', 'pending', 'paid', 'overdue']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                     const status<?php echo e(ucfirst($status)); ?> = this.$refs.status_<?php echo e($status); ?>; if (status<?php echo e(ucfirst($status)); ?>) { new Sortable(status<?php echo e(ucfirst($status)); ?>, { group: 'invoices', animation: 200, ghostClass: 'opacity-30', onEnd: (evt) => this.handleDrop(evt) }); }
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                },

                handleDrop(evt) {
                    const invoiceId = evt.item.dataset.invoiceId;
                    const newStatus = evt.to.dataset.status;

                    fetch(`/invoices/${invoiceId}/update-status`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ status: newStatus })
                    })
                        .then(r => r.json())
                        .then(data => {
                            if (data.success) {
                                this.showToast(data.message, 'success');
                            } else {
                                this.showToast(data.message, 'error');
                                location.reload();
                            }
                        });
                },

                openDrawer(invoiceId) {
                    window.location.href = `/invoices/${invoiceId}`;
                },

                showToast(message, type = 'info') {
                    const id = Date.now();
                    this.toasts.push({ id, message, type });
                    setTimeout(() => this.dismissToast(id), 3500);
                },

                dismissToast(id) {
                    this.toasts = this.toasts.filter(t => t.id !== id);
                }
            }
        }
    </script>

    <!-- SortableJS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Users\dell\.gemini\antigravity\scratch\leadix-app\resources\views/invoices/kanban.blade.php ENDPATH**/ ?>