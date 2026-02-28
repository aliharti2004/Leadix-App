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
    <div x-data="kanbanApp()" class="flex flex-col min-h-[600px]">
        <style>
            /* Card Hover Effects */
            .deal-card {
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                border: 1px solid rgba(255, 115, 0, 0.1);
                background: rgba(20, 20, 20, 0.6);
                backdrop-filter: blur(10px);
            }

            .deal-card:hover {
                transform: translateY(-8px) scale(1.02);
                border-color: rgba(255, 115, 0, 0.5);
                box-shadow: 0 20px 60px rgba(255, 115, 0, 0.2), 0 0 40px rgba(255, 115, 0, 0.1);
                background: rgba(30, 30, 30, 0.8);
            }

            /* Icon Glow */
            .icon-glow {
                background: rgba(255, 115, 0, 0.1);
                box-shadow: 0 0 20px rgba(255, 115, 0, 0.3);
                transition: all 0.3s ease;
            }

            .deal-card:hover .icon-glow {
                box-shadow: 0 0 30px rgba(255, 115, 0, 0.6);
                background: rgba(255, 115, 0, 0.2);
            }

            /* Button Gradient */
            .btn-gradient {
                background: linear-gradient(135deg, #ff7300 0%, #ff9500 100%);
                box-shadow: 0 4px 20px rgba(255, 115, 0, 0.3);
                transition: all 0.3s ease;
            }

            .btn-gradient:hover {
                box-shadow: 0 8px 30px rgba(255, 115, 0, 0.5);
                transform: translateY(-2px) scale(1.05);
            }

            /* Cursor Spotlight Effect on Cards */
            .deal-card {
                position: relative;
                overflow: hidden;
            }

            .deal-card::before {
                content: '';
                position: absolute;
                width: 300px;
                height: 300px;
                background: radial-gradient(circle, rgba(255, 115, 0, 0.15) 0%, transparent 70%);
                border-radius: 50%;
                pointer-events: none;
                opacity: 0;
                transition: opacity 0.3s ease;
                z-index: 1;
            }

            .deal-card:hover::before {
                opacity: 1;
            }

            /* Drawer & Modal with higher z-index */
            .drawer {
                transform: translateX(100%);
                transition: transform 0.3s ease;
                z-index: 9999;
            }

            .drawer.open {
                transform: translateX(0);
            }

            .modal-overlay {
                z-index: 9998;
            }

            .toast-container {
                z-index: 10000;
            }

            /* Glassmorphism */
            .glass-card {
                background: rgba(20, 20, 20, 0.6);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 115, 0, 0.1);
            }

            /* Premium Select Styling - Million Dollar SaaS */
            select {
                appearance: none;
                -webkit-appearance: none;
                -moz-appearance: none;
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

            select:focus {
                outline: none;
                border-color: rgba(255, 115, 0, 0.6);
                background-color: rgba(0, 0, 0, 0.6);
                box-shadow: 0 0 0 4px rgba(255, 115, 0, 0.15);
            }

            /* Dark dropdown options styling */
            select option {
                background-color: #1a1a1a;
                color: #ffffff;
                padding: 12px 16px;
                border-bottom: 1px solid rgba(255, 115, 0, 0.1);
                transition: all 0.2s ease;
            }

            select option:hover {
                background-color: rgba(255, 115, 0, 0.2);
                color: #ff9500;
            }

            select option:checked {
                background: linear-gradient(135deg, rgba(255, 115, 0, 0.3) 0%, rgba(255, 149, 0, 0.3) 100%);
                color: #ff9500;
                font-weight: 600;
            }

            /* Date input styling */
            input[type="date"] {
                color-scheme: dark;
                cursor: pointer;
            }

            input[type="date"]::-webkit-calendar-picker-indicator {
                filter: invert(0.6) sepia(1) saturate(5) hue-rotate(345deg);
                cursor: pointer;
                transition: all 0.3s ease;
            }

            input[type="date"]:hover::-webkit-calendar-picker-indicator {
                filter: invert(0.5) sepia(1) saturate(8) hue-rotate(345deg);
                transform: scale(1.1);
            }

            /* Number input styling */
            input[type="number"]::-webkit-inner-spin-button,
            input[type="number"]::-webkit-outer-spin-button {
                opacity: 0.6;
                transition: opacity 0.3s ease;
            }

            input[type="number"]:hover::-webkit-inner-spin-button,
            input[type="number"]:hover::-webkit-outer-spin-button {
                opacity: 1;
            }

            /* Scrollbar for select dropdowns */
            select::-webkit-scrollbar {
                width: 8px;
            }

            select::-webkit-scrollbar-track {
                background: rgba(0, 0, 0, 0.3);
                border-radius: 4px;
            }

            select::-webkit-scrollbar-thumb {
                background: rgba(255, 115, 0, 0.5);
                border-radius: 4px;
            }

            select::-webkit-scrollbar-thumb:hover {
                background: rgba(255, 115, 0, 0.7);
            }
        </style>

        <!-- Enhanced Filter Bar -->
        <div class="mb-6 flex-shrink-0"
            x-data="{ showFilters: true, hasActiveFilters: <?php echo e(request()->hasAny(['user_id', 'min_value', 'max_value', 'date_from', 'date_to', 'priority', 'deal_stage_id']) ? 'true' : 'false'); ?> }">
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
                    <!-- Active Filters Badge -->
                    <span x-show="hasActiveFilters"
                        class="bg-orange-500/20 text-orange-400 px-3 py-1 rounded-full text-xs font-bold border border-orange-500/30">
                        Active
                    </span>
                </div>

                <button @click="openCreateModal()"
                    class="btn-gradient text-white px-6 py-3 rounded-full text-sm font-bold flex items-center gap-2 whitespace-nowrap shadow-lg shadow-orange-500/20 hover:shadow-orange-500/30 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    New Deal
                </button>
            </div>

            <!-- Filter Panels -->
            <form action="<?php echo e(route('deals.kanban')); ?>" method="GET" x-show="showFilters"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="glass-card rounded-2xl p-5 space-y-4">
                    <!-- Row 1: Primary Filters -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Owner Filter -->
                        <div>
                            <label class="flex items-center gap-2 text-xs font-bold text-gray-400 uppercase mb-2">
                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Owner
                            </label>
                            <select name="user_id" onchange="this.form.submit()"
                                class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition text-sm">
                                <option value="">All Owners</option>
                                <?php $__currentLoopData = $owners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $owner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($owner->id); ?>" <?php echo e(request('user_id') == $owner->id ? 'selected' : ''); ?>>
                                        <?php echo e($owner->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- Stage Filter -->
                        <div>
                            <label class="flex items-center gap-2 text-xs font-bold text-gray-400 uppercase mb-2">
                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Stage
                            </label>
                            <select name="deal_stage_id" onchange="this.form.submit()"
                                class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition text-sm">
                                <option value="">All Stages</option>
                                <?php $__currentLoopData = $stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($stage->id); ?>" <?php echo e(request('deal_stage_id') == $stage->id ? 'selected' : ''); ?>>
                                        <?php echo e($stage->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- Priority Filter -->
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
                                <option value="high" <?php echo e(request('priority') == 'high' ? 'selected' : ''); ?>>High ($50k+)
                                </option>
                                <option value="medium" <?php echo e(request('priority') == 'medium' ? 'selected' : ''); ?>>Medium
                                    ($20k-$50k)</option>
                                <option value="low" <?php echo e(request('priority') == 'low' ? 'selected' : ''); ?>>Low (<
                                        $20k)</option>
                            </select>
                        </div>

                        <!-- Quick Date Filters -->
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
                                <option value="today" <?php echo e(request('quick_date') == 'today' ? 'selected' : ''); ?>>Today
                                </option>
                                <option value="week" <?php echo e(request('quick_date') == 'week' ? 'selected' : ''); ?>>This Week
                                </option>
                                <option value="month" <?php echo e(request('quick_date') == 'month' ? 'selected' : ''); ?>>This Month
                                </option>
                                <option value="overdue" <?php echo e(request('quick_date') == 'overdue' ? 'selected' : ''); ?>>Overdue
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Row 2: Advanced Filters (Collapsible) -->
                    <div class="pt-4 border-t border-white/5">
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                            <!-- Min Value -->
                            <div>
                                <label class="flex items-center gap-2 text-xs font-bold text-gray-400 uppercase mb-2">
                                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Min Value
                                </label>
                                <input type="number" name="min_value" value="<?php echo e(request('min_value')); ?>"
                                    placeholder="$0"
                                    class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition text-sm placeholder-gray-500">
                            </div>

                            <!-- Max Value -->
                            <div>
                                <label class="flex items-center gap-2 text-xs font-bold text-gray-400 uppercase mb-2">
                                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Max Value
                                </label>
                                <input type="number" name="max_value" value="<?php echo e(request('max_value')); ?>"
                                    placeholder="No limit"
                                    class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition text-sm placeholder-gray-500">
                            </div>

                            <!-- Date From -->
                            <div>
                                <label class="flex items-center gap-2 text-xs font-bold text-gray-400 uppercase mb-2">
                                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    From Date
                                </label>
                                <input type="date" name="date_from" value="<?php echo e(request('date_from')); ?>"
                                    class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition text-sm">
                            </div>

                            <!-- Date To -->
                            <div>
                                <label class="flex items-center gap-2 text-xs font-bold text-gray-400 uppercase mb-2">
                                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    To Date
                                </label>
                                <input type="date" name="date_to" value="<?php echo e(request('date_to')); ?>"
                                    class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition text-sm">
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-2">
                                <button type="submit"
                                    class="flex-1 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2.5 rounded-xl font-bold text-sm transition shadow-lg shadow-orange-500/20">
                                    Apply
                                </button>
                                <a href="<?php echo e(route('deals.kanban')); ?>"
                                    class="flex-1 bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white px-4 py-2.5 rounded-xl font-bold text-sm transition border border-white/10 text-center">
                                    Clear
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Kanban Board - Scrollable Container -->
        <div class="flex-1 overflow-hidden -mx-6">
            <div class="overflow-x-auto overflow-y-hidden px-6 pb-4">
                <div class="flex gap-5 pb-4">
                    <?php $__currentLoopData = $stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex-shrink-0 flex flex-col min-h-[500px]" style="width: 320px;">
                            <!-- Stage Header -->
                            <div class="mb-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span
                                        class="text-white font-bold text-sm uppercase tracking-wide"><?php echo e($stage->name); ?></span>
                                    <span class="glass-card px-2 py-1 rounded-lg text-gray-400 text-xs font-bold">
                                        <?php echo e($dealsByStage->get($stage->id)?->count() ?? 0); ?>

                                    </span>
                                </div>
                                <p class="text-xs text-gray-600 font-semibold">
                                    $<?php echo e(number_format($dealsByStage->get($stage->id)?->sum('value') ?? 0, 0)); ?>

                                </p>
                            </div>

                            <!-- Deal Cards - Scrollable -->
                            <div class="flex-1 overflow-y-auto space-y-3 pr-2" x-ref="stage_<?php echo e($stage->id); ?>"
                                data-stage-id="<?php echo e($stage->id); ?>"
                                style="scrollbar-width: thin; scrollbar-color: rgba(255,115,0,0.3) transparent;">

                                <?php $__empty_1 = true; $__currentLoopData = $dealsByStage->get($stage->id, collect()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="deal-card rounded-2xl p-4 cursor-pointer relative"
                                        data-deal-id="<?php echo e($deal->id); ?>" @click="openDrawer(<?php echo e($deal->id); ?>)">

                                        <!-- Main Content -->
                                        <div class="relative">
                                            <!-- Header: Deal Name & Priority -->
                                            <div class="flex items-start justify-between gap-2 mb-2">
                                                <h4 class="text-white text-base font-bold leading-tight flex-1">
                                                    <?php echo e($deal->name); ?>

                                                </h4>
                                                <?php
                                                    // Priority based on deal value
                                                    $priority = $deal->value >= 50000 ? 'high' : ($deal->value >= 20000 ? 'medium' : 'low');
                                                    $priorityColors = [
                                                        'high' => 'bg-red-500/20 text-red-400 border-red-500/30',
                                                        'medium' => 'bg-yellow-500/20 text-yellow-400 border-yellow-500/30',
                                                        'low' => 'bg-blue-500/20 text-blue-400 border-blue-500/30'
                                                    ];
                                                ?>
                                                <span
                                                    class="px-2 py-0.5 rounded-md text-[10px] font-bold uppercase border <?php echo e($priorityColors[$priority]); ?>">
                                                    <?php echo e($priority); ?>

                                                </span>
                                            </div>

                                            <!-- Company Name & Contact -->
                                            <div class="mb-3 space-y-1">
                                                <div class="flex items-center gap-1.5 text-gray-400">
                                                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                    </svg>
                                                    <p class="text-xs font-semibold"><?php echo e($deal->lead->company ?? 'No Company'); ?>

                                                    </p>
                                                </div>
                                                <?php if($deal->lead && ($deal->lead->first_name || $deal->lead->last_name)): ?>
                                                    <div class="flex items-center gap-1.5 text-gray-500">
                                                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                        <p class="text-xs"><?php echo e($deal->lead->first_name); ?>

                                                            <?php echo e($deal->lead->last_name); ?>

                                                        </p>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <!-- Dollar Amount & Win Probability -->
                                            <div class="flex items-center gap-2 mb-3">
                                                <p
                                                    class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-amber-500 font-black text-2xl">
                                                    $<?php echo e(number_format($deal->value, 0)); ?>

                                                </p>
                                                <span
                                                    class="bg-orange-500/20 text-orange-400 px-2.5 py-1 rounded-lg text-xs font-bold">
                                                    <?php echo e($stage->probability); ?>% win
                                                </span>
                                            </div>

                                            <!-- Tags/Status Section -->
                                            <div class="flex flex-wrap gap-1.5 mb-3">
                                                <?php if($deal->expected_close_date && $deal->expected_close_date->isPast()): ?>
                                                    <span
                                                        class="inline-flex items-center gap-1 bg-red-500/20 text-red-400 px-2 py-1 rounded-md text-[10px] font-bold border border-red-500/30">
                                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        OVERDUE
                                                    </span>
                                                <?php elseif($deal->expected_close_date && $deal->expected_close_date->isToday()): ?>
                                                    <span
                                                        class="inline-flex items-center gap-1 bg-orange-500/20 text-orange-400 px-2 py-1 rounded-md text-[10px] font-bold border border-orange-500/30">
                                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        CLOSES TODAY
                                                    </span>
                                                <?php elseif($deal->expected_close_date && $deal->expected_close_date->diffInDays(now()) <= 7): ?>
                                                    <span
                                                        class="inline-flex items-center gap-1 bg-amber-500/20 text-amber-400 px-2 py-1 rounded-md text-[10px] font-bold border border-amber-500/30">
                                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        DUE SOON
                                                    </span>
                                                <?php endif; ?>

                                                <?php
                                                    // Stage-specific tags
                                                    $stageTag = '';
                                                    switch (strtolower($stage->name)) {
                                                        case 'prospecting':
                                                            $stageTag = '<span class="bg-purple-500/20 text-purple-300 px-2 py-1 rounded-md text-[10px] font-bold border border-purple-500/30">NEW LEAD</span>';
                                                            break;
                                                        case 'qualified':
                                                            $stageTag = '<span class="bg-green-500/20 text-green-300 px-2 py-1 rounded-md text-[10px] font-bold border border-green-500/30">QUALIFIED</span>';
                                                            break;
                                                        case 'proposal':
                                                            $stageTag = '<span class="bg-blue-500/20 text-blue-300 px-2 py-1 rounded-md text-[10px] font-bold border border-blue-500/30">IN REVIEW</span>';
                                                            break;
                                                        case 'negotiation':
                                                            $stageTag = '<span class="bg-indigo-500/20 text-indigo-300 px-2 py-1 rounded-md text-[10px] font-bold border border-indigo-500/30">NEGOTIATING</span>';
                                                            break;
                                                    }
                                                ?>
                                                <?php echo $stageTag; ?>

                                            </div>

                                            <!-- Last Activity / Notes Preview -->
                                            <div class="mb-3 bg-white/5 rounded-lg p-2">
                                                <div class="flex items-center gap-1.5 text-gray-500">
                                                    <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <p class="text-[10px] font-semibold">Updated
                                                        <?php echo e($deal->updated_at->diffForHumans()); ?>

                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Footer: Owner & Close Date -->
                                            <div class="flex items-center justify-between pt-3 border-t border-white/5">
                                                <div class="flex items-center gap-2">
                                                    <div
                                                        class="w-7 h-7 rounded-xl icon-glow flex items-center justify-center text-white text-xs font-bold shadow-lg">
                                                        <?php echo e(strtoupper(substr($deal->owner->name ?? 'U', 0, 1))); ?>

                                                    </div>
                                                    <div class="text-left">
                                                        <p class="text-gray-400 text-[10px] font-semibold leading-tight">
                                                            <?php echo e($deal->owner->name ?? 'Unassigned'); ?>

                                                        </p>
                                                        <p class="text-gray-600 text-[9px]">Owner</p>
                                                    </div>
                                                </div>

                                                <?php if($deal->expected_close_date): ?>
                                                    <div class="text-right">
                                                        <div class="flex items-center gap-1 text-gray-400 text-xs font-bold">
                                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd"
                                                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                            <?php echo e($deal->expected_close_date->format('M d')); ?>

                                                        </div>
                                                        <p class="text-gray-600 text-[9px] mt-0.5">Expected Close</p>
                                                    </div>
                                                <?php endif; ?>
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
                                        <p class="text-gray-600 text-xs font-medium">No deals in this stage</p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Add Deal -->
                            <button @click="openCreateModal()"
                                class="mt-4 w-full py-2.5 text-gray-600 hover:text-orange-500 text-sm font-semibold flex items-center justify-center gap-1.5 hover:bg-white/5 rounded-xl transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Add Deal
                            </button>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

        <!-- Drawer -->
        <div x-show="drawerOpen" @click.self="closeDrawer()"
            class="fixed inset-0 bg-black/80 backdrop-blur-md modal-overlay" x-cloak style="display: none;">
            <div class="drawer fixed right-0 top-0 h-full w-[500px] glass-card overflow-y-auto"
                :class="{ 'open': drawerOpen }">

                <template x-if="currentDeal">
                    <div class="p-6">
                        <!-- Header -->
                        <div class="flex items-start justify-between mb-6">
                            <div>
                                <span
                                    class="bg-orange-500/20 text-orange-400 px-3 py-1 rounded-xl text-xs font-bold mb-2 inline-block">
                                    <span x-text="currentDeal.stage.name"></span>
                                </span>
                                <h2 class="text-xl font-black text-white mb-2">Edit Deal</h2>
                            </div>
                            <button @click="closeDrawer()" class="text-gray-600 hover:text-orange-500 transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Quick Actions -->
                        <div class="flex gap-3 mb-6">
                            <button @click="markWon()"
                                class="flex-1 btn-gradient text-white px-4 py-3 rounded-xl font-bold">
                                Mark Won
                            </button>
                            <button @click="markLost()"
                                class="flex-1 glass-card hover:border-orange-500/50 text-white px-4 py-3 rounded-xl font-bold transition">
                                Mark Lost
                            </button>
                        </div>

                        <!-- Edit Form -->
                        <form @submit.prevent="updateDeal()" class="space-y-4 mb-6">
                            <!-- Deal Name -->
                            <div>
                                <label class="block text-gray-400 text-xs font-bold uppercase mb-2">Deal Name</label>
                                <input type="text" x-model="editForm.name" required
                                    class="w-full glass-card text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500">
                            </div>

                            <!-- Company -->
                            <div>
                                <label class="block text-gray-400 text-xs font-bold uppercase mb-2">Company</label>
                                <select x-model="editForm.lead_id" required
                                    class="w-full glass-card text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500">
                                    <option value="">Select Company...</option>
                                    <?php $__currentLoopData = \App\Models\Lead::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option :value="<?php echo e($lead->id); ?>" :selected="currentDeal.lead.id == <?php echo e($lead->id); ?>">
                                            <?php echo e($lead->company); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <!-- Value & Stage -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-400 text-xs font-bold uppercase mb-2">Value
                                        ($)</label>
                                    <input type="number" x-model="editForm.value" required step="0.01"
                                        class="w-full glass-card text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500">
                                </div>
                                <div>
                                    <label class="block text-gray-400 text-xs font-bold uppercase mb-2">Stage</label>
                                    <select x-model="editForm.deal_stage_id"
                                        class="w-full glass-card text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500">
                                        <?php $__currentLoopData = $stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($s->id); ?>"><?php echo e($s->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Expected Close Date -->
                            <div>
                                <label class="block text-gray-400 text-xs font-bold uppercase mb-2">Expected Close
                                    Date</label>
                                <input type="date" x-model="editForm.expected_close_date"
                                    class="w-full glass-card text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500">
                            </div>

                            <!-- Notes -->
                            <div>
                                <label class="block text-gray-400 text-xs font-bold uppercase mb-2">Notes</label>
                                <textarea x-model="editForm.notes" rows="4"
                                    class="w-full glass-card text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500 resize-none"
                                    placeholder="Add notes about this deal..."></textarea>
                            </div>

                            <!-- Owner (Read-only) -->
                            <div>
                                <label class="block text-gray-400 text-xs font-bold uppercase mb-2">Owner</label>
                                <div class="glass-card rounded-xl px-4 py-3">
                                    <p class="text-white font-bold" x-text="currentDeal.owner.name"></p>
                                </div>
                            </div>

                            <!-- Save Button -->
                            <button type="submit" class="w-full btn-gradient text-white px-4 py-3 rounded-xl font-bold">
                                Save Changes
                            </button>
                        </form>

                        <!-- Delete Button -->
                        <button @click="deleteDeal()"
                            class="w-full bg-red-900/20 hover:bg-red-900/40 text-red-500 px-4 py-3 rounded-xl font-bold border border-red-900/50 transition">
                            Delete Deal
                        </button>
                    </div>
                </template>
            </div>
        </div>

        <!-- Modal -->
        <div x-show="modalOpen" @click.self="closeModal()"
            class="fixed inset-0 bg-black/80 backdrop-blur-md modal-overlay flex items-center justify-center" x-cloak
            style="display: none;">
            <div class="glass-card rounded-2xl p-8 w-full max-w-lg m-4">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-black text-white">New Deal</h2>
                    <button @click="closeModal()" class="text-gray-600 hover:text-orange-500 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form @submit.prevent="createDeal()" class="space-y-4">
                    <div>
                        <label class="block text-gray-400 text-sm font-bold mb-2">Deal Name *</label>
                        <input x-model="formData.name" type="text" required
                            class="w-full glass-card text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>

                    <div>
                        <label class="block text-gray-400 text-sm font-bold mb-2">Company</label>
                        <select x-model="formData.lead_id"
                            class="w-full glass-card text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500">
                            <option value="">Select...</option>
                            <?php $__currentLoopData = \App\Models\Lead::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($lead->id); ?>"><?php echo e($lead->company); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php if(\App\Models\Lead::count() === 0): ?>
                            <p class="text-amber-400 text-xs mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd" />
                                </svg>
                                No leads available.
                                <a href="<?php echo e(route('leads.create')); ?>"
                                    class="text-orange-500 hover:text-orange-400 underline">Create a lead first</a>
                            </p>
                        <?php endif; ?>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-400 text-sm font-bold mb-2">Value *</label>
                            <input x-model="formData.value" type="number" required
                                class="w-full glass-card text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500">
                        </div>
                        <div>
                            <label class="block text-gray-400 text-sm font-bold mb-2">Stage *</label>
                            <select x-model="formData.deal_stage_id" required
                                class="w-full glass-card text-white rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-500">
                                <option value="">Select...</option>
                                <?php $__currentLoopData = $stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($s->id); ?>"><?php echo e($s->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="button" @click="closeModal()"
                            class="flex-1 glass-card text-white px-6 py-3 rounded-xl font-bold hover:border-orange-500/50 transition">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 btn-gradient text-white px-6 py-3 rounded-xl font-bold">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Toast -->
        <div class="fixed bottom-6 right-6 toast-container space-y-3" x-show="toasts.length > 0" style="display: none;">
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
        function kanbanApp() {
            return {
                drawerOpen: false,
                modalOpen: false,
                currentDeal: null,
                editForm: {},
                toasts: [],
                formData: {},

                init() {
                    <?php $__currentLoopData = $stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        const stage<?php echo e($stage->id); ?> = this.$refs.stage_<?php echo e($stage->id); ?>;
                        if (stage<?php echo e($stage->id); ?>) {
                            new Sortable(stage<?php echo e($stage->id); ?>, {
                                group: 'deals',
                                animation: 200,
                                ghostClass: 'opacity-30',
                                onEnd: (evt) => this.handleDrop(evt)
                            });
                        }
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                },

                handleDrop(evt) {
                    const dealId = evt.item.dataset.dealId;
                    const newStageId = evt.to.dataset.stageId;

                    fetch(`/deals/${dealId}/update-stage`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ stage_id: newStageId })
                    })
                        .then(r => r.json())
                        .then(data => {
                            if (data.success) {
                                this.showToast(data.message, 'success');

                                // INSTANT notification refresh
                                if (window.refreshNotifications) {
                                    setTimeout(() => window.refreshNotifications(), 500);
                                }
                            } else {
                                this.showToast(data.message, 'error');
                                location.reload();
                            }
                        });
                },

                openDrawer(dealId) {
                    fetch(`/deals/${dealId}`, { headers: { 'Accept': 'application/json' } })
                        .then(r => r.json())
                        .then(data => {
                            this.currentDeal = data.deal;
                            // Populate edit form
                            this.editForm = {
                                name: data.deal.name,
                                lead_id: data.deal.lead.id,
                                value: data.deal.value,
                                deal_stage_id: data.deal.stage.id,
                                expected_close_date: data.deal.expected_close_date || '',
                                notes: data.deal.notes || ''
                            };
                            this.drawerOpen = true;
                        });
                },

                updateDeal() {
                    fetch(`/deals/${this.currentDeal.id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify(this.editForm)
                    })
                        .then(r => r.json())
                        .then(data => {
                            if (data.success) {
                                this.showToast(data.message || 'Deal updated successfully', 'success');
                                this.closeDrawer();
                                setTimeout(() => location.reload(), 1000);
                            } else {
                                this.showToast(data.message || 'Failed to update deal', 'error');
                            }
                        })
                        .catch(err => {
                            this.showToast('Error updating deal', 'error');
                        });
                },

                closeDrawer() {
                    this.drawerOpen = false;
                    setTimeout(() => this.currentDeal = null, 300);
                },

                openCreateModal() {
                    this.formData = {
                        name: '',
                        lead_id: '',
                        value: '',
                        user_id: '<?php echo e(auth()->id()); ?>',
                        deal_stage_id: '<?php echo e(isset($stages) && count($stages) > 0 ? $stages->first()->id : ""); ?>',
                        expected_close_date: ''
                    };
                    this.modalOpen = true;
                },

                closeModal() {
                    this.modalOpen = false;
                },

                createDeal() {
                    fetch('/deals', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify(this.formData)
                    })
                        .then(r => r.json())
                        .then(data => {
                            if (data.success) {
                                this.showToast(data.message, 'success');
                                this.closeModal();
                                setTimeout(() => location.reload(), 1000);
                            } else {
                                this.showToast('Failed to create deal', 'error');
                            }
                        });
                },

                markWon() {
                    if (!confirm('Mark as Won?')) return;
                    fetch(`/deals/${this.currentDeal.id}/mark-won`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                        .then(r => r.json())
                        .then(data => {
                            if (data.success) {
                                this.showToast(data.message, 'success');
                                this.closeDrawer();
                                setTimeout(() => location.reload(), 1000);
                            }
                        });
                },

                markLost() {
                    if (!confirm('Mark as Lost?')) return;
                    fetch(`/deals/${this.currentDeal.id}/mark-lost`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                        .then(r => r.json())
                        .then(data => {
                            if (data.success) {
                                this.showToast(data.message, 'success');
                                this.closeDrawer();
                                setTimeout(() => location.reload(), 1000);
                            }
                        });
                },

                deleteDeal() {
                    if (!confirm('Are you sure you want to delete this deal?')) return;
                    fetch(`/deals/${this.currentDeal.id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                        .then(r => r.json())
                        .then(data => {
                            if (data.success) {
                                this.showToast(data.message, 'success');
                                this.closeDrawer();
                                setTimeout(() => location.reload(), 1000);
                            }
                        });
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
<?php endif; ?><?php /**PATH C:\Users\dell\.gemini\antigravity\scratch\leadix-app\resources\views/deals/kanban.blade.php ENDPATH**/ ?>