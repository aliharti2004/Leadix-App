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
    <div class="p-6 max-w-7xl mx-auto">
        <header class="mb-8">
            <h1 class="text-3xl font-black text-white">Settings</h1>
            <p class="text-gray-400 font-medium">Manage your account and organization preferences.</p>
        </header>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Navigation -->
            <aside class="w-full lg:w-64 flex-shrink-0">
                <nav class="space-y-1">
                    <a href="<?php echo e(route('settings.profile')); ?>"
                        class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 <?php echo e(request()->routeIs('settings.profile') ? 'bg-orange-500/10 text-orange-500 ring-1 ring-orange-500/50' : 'text-gray-400 hover:bg-white/5 hover:text-white'); ?>">
                        <svg class="mr-3 flex-shrink-0 h-5 w-5 <?php echo e(request()->routeIs('settings.profile') ? 'text-orange-500' : 'text-gray-500 group-hover:text-white'); ?>"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        My Profile
                    </a>

                    <a href="<?php echo e(route('settings.organization')); ?>"
                        class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 <?php echo e(request()->routeIs('settings.organization') ? 'bg-orange-500/10 text-orange-500 ring-1 ring-orange-500/50' : 'text-gray-400 hover:bg-white/5 hover:text-white'); ?>">
                        <svg class="mr-3 flex-shrink-0 h-5 w-5 <?php echo e(request()->routeIs('settings.organization') ? 'text-orange-500' : 'text-gray-500 group-hover:text-white'); ?>"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Organization
                    </a>


            </aside>

            <!-- Main Content Area -->
            <main class="flex-1">
                <?php if(session('success')): ?>
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                        class="mb-6 p-4 rounded-xl bg-green-500/10 border border-green-500/20 text-green-500 flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-medium"><?php echo e(session('success')); ?></span>
                    </div>
                <?php endif; ?>

                <?php echo e($slot); ?>

            </main>
        </div>
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
<?php endif; ?><?php /**PATH C:\Users\dell\.gemini\antigravity\scratch\leadix-app\resources\views/components/settings-layout.blade.php ENDPATH**/ ?>