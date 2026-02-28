<?php if (isset($component)) { $__componentOriginalbb4e234f23ee3d31f932674016047db1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbb4e234f23ee3d31f932674016047db1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.settings-layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('settings-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="space-y-8">
        <!-- Organization Details (Read-Only) -->
        <section class="glass-card p-8 rounded-2xl">
            <header class="mb-6">
                <h2 class="text-xl font-bold text-white">Organization Details</h2>
                <p class="text-gray-400 text-sm mt-1">View your organization's information.</p>
            </header>

            <div class="space-y-6 max-w-xl">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-400 mb-2">Organization Name</label>
                    <input type="text" name="name" id="name" value="<?php echo e($organization->name); ?>" disabled readonly
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-gray-400 cursor-not-allowed">
                    <p class="text-gray-500 text-xs mt-2">Contact system administrator to modify organization settings.
                    </p>
                </div>
            </div>
        </section>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbb4e234f23ee3d31f932674016047db1)): ?>
<?php $attributes = $__attributesOriginalbb4e234f23ee3d31f932674016047db1; ?>
<?php unset($__attributesOriginalbb4e234f23ee3d31f932674016047db1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbb4e234f23ee3d31f932674016047db1)): ?>
<?php $component = $__componentOriginalbb4e234f23ee3d31f932674016047db1; ?>
<?php unset($__componentOriginalbb4e234f23ee3d31f932674016047db1); ?>
<?php endif; ?><?php /**PATH C:\Users\dell\.gemini\antigravity\scratch\leadix-app\resources\views/settings/organization.blade.php ENDPATH**/ ?>