<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['action']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['action']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<form action="<?php echo e($action); ?>" method="GET" class="mb-6">
    <div class="glass-card p-4 rounded-xl flex flex-wrap items-center gap-4">
        <!-- Search Input -->
        <div class="flex-1 min-w-[200px]">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search..."
                    class="w-full bg-slate-900/50 text-white border-0 rounded-lg pl-10 pr-4 py-2 focus:ring-1 focus:ring-orange-500 placeholder-gray-500 text-sm">
            </div>
        </div>

        <!-- Filters Slot -->
        <?php echo e($slot); ?>


        <!-- Actions -->
        <div class="flex items-center gap-2 ml-auto">
            <button type="submit"
                class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm font-bold transition shadow-lg shadow-orange-500/20">
                Filter
            </button>

            <?php if(request()->hasAny(['search', 'stage_id', 'user_id', 'min_value', 'max_value', 'date_from', 'date_to', 'status', 'overdue', 'min_amount', 'max_amount'])): ?>
                <a href="<?php echo e($action); ?>"
                    class="text-gray-400 hover:text-white px-3 py-2 rounded-lg text-sm font-semibold transition">
                    Clear
                </a>
            <?php endif; ?>
        </div>
    </div>
</form><?php /**PATH C:\Users\dell\.gemini\antigravity\scratch\leadix-app\resources\views/components/filter-bar.blade.php ENDPATH**/ ?>