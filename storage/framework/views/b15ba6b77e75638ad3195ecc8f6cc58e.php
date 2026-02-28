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
    <?php $__env->startSection('header', 'Search Results'); ?>

    <div class="space-y-8">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-black text-white">Search Results</h1>
                <p class="text-gray-400 mt-1">Found results for <span class="text-orange-500 font-bold">"<?php echo e($query); ?>"</span></p>
            </div>
            <a href="<?php echo e(url()->previous()); ?>" class="text-gray-400 hover:text-white transition flex items-center gap-2 text-sm font-bold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back
            </a>
        </div>

        <?php if($deals->isEmpty() && $leads->isEmpty() && $invoices->isEmpty()): ?>
             <div class="glass-card rounded-2xl p-12 text-center">
                <svg class="w-16 h-16 text-gray-700 mb-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <p class="text-gray-500 text-lg font-bold mb-2">No results found</p>
                <p class="text-gray-600 text-sm">Try using different keywords or check for typos.</p>
            </div>
        <?php endif; ?>

        <!-- Deals -->
        <?php if($deals->isNotEmpty()): ?>
            <section>
                <h2 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                    <span class="bg-orange-500 w-2 h-6 rounded-full"></span>
                    Deals
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <?php $__currentLoopData = $deals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="glass-card rounded-2xl p-5 hover:bg-white/5 transition group cursor-pointer" 
                             onclick="window.location='<?php echo e(route('deals.kanban')); ?>?search=<?php echo e($deal->name); ?>'">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="text-white font-bold group-hover:text-orange-500 transition"><?php echo e($deal->name); ?></h3>
                                    <p class="text-gray-500 text-sm"><?php echo e($deal->lead->company ?? 'Unknown Company'); ?></p>
                                </div>
                                <span class="px-2 py-1 rounded-lg text-xs font-bold bg-white/5 text-gray-300">
                                    <?php echo e($deal->stage->name ?? 'Unknown'); ?>

                                </span>
                            </div>
                            <p class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-amber-500 font-black text-xl">
                                $<?php echo e(number_format($deal->value, 0)); ?>

                            </p>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </section>
        <?php endif; ?>

        <!-- Invoices -->
        <?php if($invoices->isNotEmpty()): ?>
            <section>
                <h2 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                    <span class="bg-blue-500 w-2 h-6 rounded-full"></span>
                    Invoices
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="glass-card rounded-2xl p-5 hover:bg-white/5 transition group cursor-pointer"
                             onclick="window.location='<?php echo e(route('invoices.show', $invoice)); ?>'">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="text-white font-bold group-hover:text-orange-500 transition"><?php echo e($invoice->invoice_number); ?></h3>
                                    <p class="text-gray-500 text-sm"><?php echo e($invoice->deal->lead->company ?? 'Unknown Client'); ?></p>
                                </div>
                                <span class="px-2 py-1 rounded-lg text-xs font-bold 
                                    <?php echo e($invoice->status === 'paid' ? 'bg-green-500/20 text-green-400' : ($invoice->status === 'overdue' ? 'bg-red-500/20 text-red-400' : 'bg-amber-500/20 text-amber-400')); ?>">
                                    <?php echo e(ucfirst($invoice->status)); ?>

                                </span>
                            </div>
                            <p class="font-bold text-white text-lg">
                                $<?php echo e(number_format($invoice->total, 2)); ?>

                            </p>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </section>
        <?php endif; ?>

        <!-- Leads -->
        <?php if($leads->isNotEmpty()): ?>
            <section>
                <h2 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                    <span class="bg-purple-500 w-2 h-6 rounded-full"></span>
                    Contacts & Leads
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <?php $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="glass-card rounded-2xl p-5 hover:bg-white/5 transition group">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-white font-bold group-hover:text-orange-500 transition"><?php echo e($lead->company); ?></h3>
                                <span class="text-xs font-bold text-gray-500 uppercase"><?php echo e($lead->status); ?></span>
                            </div>
                            <div class="space-y-1">
                                <p class="text-gray-400 text-sm flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <?php echo e($lead->contact_name); ?>

                                </p>
                                <p class="text-gray-400 text-sm flex items-center gap-2">
                                     <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <?php echo e($lead->email); ?>

                                </p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </section>
        <?php endif; ?>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\Users\dell\.gemini\antigravity\scratch\leadix-app\resources\views/search/results.blade.php ENDPATH**/ ?>