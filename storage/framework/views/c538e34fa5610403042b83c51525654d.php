<?php if($paginator->hasPages()): ?>
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
        
        <div class="flex-1 flex justify-start">
            <p class="text-sm text-gray-400">
                Showing
                <span class="font-bold text-white"><?php echo e($paginator->firstItem()); ?></span>
                to
                <span class="font-bold text-white"><?php echo e($paginator->lastItem()); ?></span>
                of
                <span class="font-bold text-orange-500"><?php echo e($paginator->total()); ?></span>
                results
            </p>
        </div>

        <div class="flex-1 flex justify-center">
            <div class="flex items-center gap-2">
                
                <?php if($paginator->onFirstPage()): ?>
                    <span
                        class="px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-gray-600 cursor-not-allowed font-bold text-sm">
                        <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </span>
                <?php else: ?>
                    <a href="<?php echo e($paginator->previousPageUrl()); ?>"
                        class="px-4 py-2 rounded-xl bg-white/5 border border-white/10 hover:border-orange-500/50 hover:bg-orange-500/10 text-gray-400 hover:text-orange-500 transition-all font-bold text-sm">
                        <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                <?php endif; ?>

                
                <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                    <?php if(is_string($element)): ?>
                        <span class="px-4 py-2 text-gray-600 font-bold"><?php echo e($element); ?></span>
                    <?php endif; ?>

                    
                    <?php if(is_array($element)): ?>
                        <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($page == $paginator->currentPage()): ?>
                                <span
                                    class="px-4 py-2 rounded-xl bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold text-sm shadow-lg shadow-orange-500/30">
                                    <?php echo e($page); ?>

                                </span>
                            <?php else: ?>
                                <a href="<?php echo e($url); ?>"
                                    class="px-4 py-2 rounded-xl bg-white/5 border border-white/10 hover:border-orange-500/50 hover:bg-orange-500/10 text-gray-400 hover:text-orange-500 transition-all font-bold text-sm">
                                    <?php echo e($page); ?>

                                </a>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                
                <?php if($paginator->hasMorePages()): ?>
                    <a href="<?php echo e($paginator->nextPageUrl()); ?>"
                        class="px-4 py-2 rounded-xl bg-white/5 border border-white/10 hover:border-orange-500/50 hover:bg-orange-500/10 text-gray-400 hover:text-orange-500 transition-all font-bold text-sm">
                        <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                <?php else: ?>
                    <span
                        class="px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-gray-600 cursor-not-allowed font-bold text-sm">
                        <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </span>
                <?php endif; ?>
            </div>
        </div>

        <div class="flex-1"></div>
    </nav>
<?php endif; ?><?php /**PATH C:\Users\dell\.gemini\antigravity\scratch\leadix-app\resources\views/components/pagination.blade.php ENDPATH**/ ?>