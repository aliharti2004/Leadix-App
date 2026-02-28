
<header class="glass-header h-16 sticky top-0 z-40 flex items-center justify-between px-6">
    
    <div class="flex items-center gap-4 md:hidden">
        
        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-400 hover:text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    
    <div class="w-full max-w-md hidden md:block">
        <form action="<?php echo e(route('search')); ?>" method="GET">
            <div class="relative group">
                <span
                    class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 group-focus-within:text-orange-500 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input type="text" name="q" placeholder="Search..."
                    class="w-full bg-white/5 text-white border border-white/10 rounded-full pl-10 pr-4 py-2 focus:ring-2 focus:ring-orange-500 focus:bg-white/10 transition-all text-sm placeholder-gray-500">
            </div>
        </form>
    </div>

    
    <div class="flex items-center gap-3">
        
        <div class="relative" x-data="{ notificationOpen: false }">
            <button @click="notificationOpen = !notificationOpen"
                class="relative p-2 text-gray-400 hover:text-white transition focus:outline-none">
                <span class="sr-only">Notifications</span>
                
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>

                
                <?php if(auth()->user()->unreadNotifications->count() > 0): ?>
                    <span
                        class="absolute -top-1 -right-1 min-w-[18px] h-[18px] px-1 bg-red-500 rounded-full border-2 border-[#1a1a1a] text-[10px] font-bold text-white flex items-center justify-center">
                        <?php echo e(auth()->user()->unreadNotifications->count() > 9 ? '9+' : auth()->user()->unreadNotifications->count()); ?>

                    </span>
                <?php endif; ?>
            </button>

            
            <div x-show="notificationOpen" @click.away="notificationOpen = false"
                x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                style="display: none;"
                class="absolute right-0 mt-2 w-80 bg-[#1a1a1a] border border-white/10 rounded-xl shadow-2xl overflow-hidden z-50">

                
                <div class="px-4 py-3 border-b border-white/10 flex justify-between items-center bg-white/5">
                    <h3 class="text-sm font-bold text-white">Notifications</h3>
                    <?php if(auth()->user()->unreadNotifications->count() > 0): ?>
                        <button onclick="markAllRead()" class="text-xs text-orange-500 hover:text-orange-400 font-bold">
                            Mark all read
                        </button>
                    <?php endif; ?>
                </div>

                
                <div class="max-h-96 overflow-y-auto">
                    <?php $__empty_1 = true; $__currentLoopData = auth()->user()->unreadNotifications->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $type = $notification->data['type'] ?? 'info';
                            $borderColors = [
                                'deal_won' => 'border-l-green-500',
                                'payment_received' => 'border-l-emerald-500',
                                'invoice_overdue' => 'border-l-red-500',
                                'invoice_created' => 'border-l-blue-500',
                                'contact_created' => 'border-l-indigo-500',
                            ];
                            $borderClass = $borderColors[$type] ?? 'border-l-gray-500';
                        ?>
                        
                        <div class="px-4 py-3 border-b border-white/5 border-l-2 <?php echo e($borderClass); ?> hover:bg-white/5 transition cursor-pointer group"
                            onclick="markRead('<?php echo e($notification->id); ?>', '<?php echo e(isset($notification->data['url']) ? $notification->data['url'] : '#'); ?>')">
                            <div class="flex items-start gap-3">
                                
                                <div class="flex-shrink-0 mt-1">
                                    <?php echo $__env->make('layouts.partials.notification-icon', ['icon' => $notification->data['icon'] ?? '', 'type' => $type], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                </div>

                                
                                <div>
                                    <?php
                                        $textColors = [
                                            'deal_won' => 'text-green-400',
                                            'payment_received' => 'text-emerald-400',
                                            'invoice_overdue' => 'text-red-400',
                                            'invoice_created' => 'text-blue-400',
                                            'contact_created' => 'text-indigo-400',
                                        ];
                                        $messageColor = $textColors[$type] ?? 'text-gray-400';
                                    ?>
                                    <p class="text-sm font-bold text-white group-hover:text-orange-500 transition">
                                        <?php echo e($notification->data['type'] ?? 'Notification'); ?></p>
                                    <p class="text-xs <?php echo e($messageColor); ?> mt-1 font-medium">
                                        <?php echo e($notification->data['message'] ?? 'You have a new notification.'); ?></p>
                                    <p class="text-[10px] text-gray-500 mt-2 font-mono">
                                        <?php echo e($notification->created_at->diffForHumans()); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="px-4 py-8 text-center">
                            <p class="text-gray-500 text-sm">No new notifications</p>
                        </div>
                    <?php endif; ?>
                </div>

                
                <div class="px-4 py-3 border-t border-white/10 bg-white/5">
                    <a href="<?php echo e(route('notifications.index')); ?>" 
                        class="block text-center text-sm font-bold text-orange-500 hover:text-orange-400 transition">
                        View All Notifications
                    </a>
                </div>
            </div>
        </div>

        
        <span class="text-gray-600 text-sm font-medium hidden sm:block"><?php echo e(now()->format('l, M d, Y')); ?></span>

        
        <span
            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-white/5 border border-white/10 text-orange-400 uppercase tracking-wide">
            <?php echo e(Auth::user()->role); ?>

        </span>

        
        <div class="relative ml-3">
            <?php if (isset($component)) { $__componentOriginaldf8083d4a852c446488d8d384bbc7cbe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown','data' => ['align' => 'right','width' => '48']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['align' => 'right','width' => '48']); ?>
                 <?php $__env->slot('trigger', null, []); ?> 
                    <button
                        class="flex items-center gap-2 text-sm font-medium text-gray-400 hover:text-white transition focus:outline-none">
                        <div
                            class="h-8 w-8 rounded-full bg-orange-500 flex items-center justify-center text-white font-bold shadow-lg shadow-orange-500/20">
                            <?php echo e(substr(Auth::user()->name, 0, 1)); ?>

                        </div>
                        <span class="hidden md:block"><?php echo e(Auth::user()->name); ?></span>
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                 <?php $__env->endSlot(); ?>

                 <?php $__env->slot('content', null, []); ?> 
                    <div class="px-4 py-2 border-b border-white/10">
                        <p class="text-xs text-gray-500 uppercase font-bold">Organization</p>
                        <p class="text-sm font-medium text-white">
                            <?php echo e(Auth::user()->organization->name ?? 'No Org'); ?>

                        </p>
                    </div>

                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <?php if (isset($component)) { $__componentOriginal68cb1971a2b92c9735f83359058f7108 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal68cb1971a2b92c9735f83359058f7108 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown-link','data' => ['href' => route('logout'),'onclick' => 'event.preventDefault(); this.closest(\'form\').submit();']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('logout')),'onclick' => 'event.preventDefault(); this.closest(\'form\').submit();']); ?>
                            <?php echo e(__('Log Out')); ?>

                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $attributes = $__attributesOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__attributesOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $component = $__componentOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__componentOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
                    </form>
                 <?php $__env->endSlot(); ?>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe)): ?>
<?php $attributes = $__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe; ?>
<?php unset($__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldf8083d4a852c446488d8d384bbc7cbe)): ?>
<?php $component = $__componentOriginaldf8083d4a852c446488d8d384bbc7cbe; ?>
<?php unset($__componentOriginaldf8083d4a852c446488d8d384bbc7cbe); ?>
<?php endif; ?>
        </div>
    </div>
</header>


<script>
    function markRead(id, url) {
        fetch(`/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        }).then(() => {
            if (url && url !== '#') window.location.href = url;
            else window.location.reload();
        });
    }

    function markAllRead() {
        fetch('/notifications/read-all', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        }).then(() => {
            window.location.reload();
        });
    }
</script><?php /**PATH C:\Users\dell\.gemini\antigravity\scratch\leadix-app\resources\views/layouts/partials/top-navigation.blade.php ENDPATH**/ ?>