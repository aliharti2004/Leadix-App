

<?php $__env->startSection('header', 'Create Lead'); ?>

<?php $__env->startSection('content'); ?>
    <style>
        .glass-card {
            background: rgba(20, 20, 20, 0.6);
            backdrop-filter: blur(10px);
        }
    </style>

    <div class="max-w-4xl mx-auto">
        
        <div class="mb-6">
            <a href="<?php echo e(route('leads.index')); ?>"
                class="text-gray-400 hover:text-white flex items-center gap-2 mb-4 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Leads
            </a>
            <h2 class="text-2xl font-black text-white">Create New Lead</h2>
            <p class="text-gray-400 mt-1">Add a new potential customer to your pipeline</p>
        </div>

        
        <form action="<?php echo e(route('leads.store')); ?>" method="POST" class="glass-card rounded-2xl p-8 border border-white/10">
            <?php echo csrf_field(); ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wide">Lead Title *</label>
                    <input type="text" name="title" value="<?php echo e(old('title')); ?>" required
                        class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                        placeholder="e.g., Enterprise CRM Solution for Acme Corp">
                    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wide">Contact Name</label>
                    <input type="text" name="contact_name" value="<?php echo e(old('contact_name')); ?>"
                        class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                        placeholder="John Doe">
                    <?php $__errorArgs = ['contact_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wide">Email</label>
                    <input type="email" name="email" value="<?php echo e(old('email')); ?>"
                        class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                        placeholder="john@example.com">
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wide">Phone</label>
                    <input type="text" name="phone" value="<?php echo e(old('phone')); ?>"
                        class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                        placeholder="+1 (555) 123-4567">
                    <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wide">Company</label>
                    <input type="text" name="company" value="<?php echo e(old('company')); ?>"
                        class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                        placeholder="Acme Corporation">
                    <?php $__errorArgs = ['company'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wide">Job Title</label>
                    <input type="text" name="job_title" value="<?php echo e(old('job_title')); ?>"
                        class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                        placeholder="CEO">
                    <?php $__errorArgs = ['job_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wide">Source</label>
                    <select name="source"
                        class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
                        <option value="website" <?php echo e(old('source') == 'website' ? 'selected' : ''); ?>>Website</option>
                        <option value="referral" <?php echo e(old('source') == 'referral' ? 'selected' : ''); ?>>Referral</option>
                        <option value="cold_call" <?php echo e(old('source') == 'cold_call' ? 'selected' : ''); ?>>Cold Call</option>
                        <option value="linkedin" <?php echo e(old('source') == 'linkedin' ? 'selected' : ''); ?>>LinkedIn</option>
                        <option value="event" <?php echo e(old('source') == 'event' ? 'selected' : ''); ?>>Event</option>
                        <option value="other" <?php echo e(old('source') == 'other' ? 'selected' : ''); ?>>Other</option>
                    </select>
                    <?php $__errorArgs = ['source'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wide">Status</label>
                    <select name="status"
                        class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
                        <option value="new" <?php echo e(old('status', 'new') == 'new' ? 'selected' : ''); ?>>New</option>
                        <option value="contacted" <?php echo e(old('status') == 'contacted' ? 'selected' : ''); ?>>Contacted</option>
                        <option value="qualified" <?php echo e(old('status') == 'qualified' ? 'selected' : ''); ?>>Qualified</option>
                        <option value="nurturing" <?php echo e(old('status') == 'nurturing' ? 'selected' : ''); ?>>Nurturing</option>
                        <option value="disqualified" <?php echo e(old('status') == 'disqualified' ? 'selected' : ''); ?>>Disqualified
                        </option>
                    </select>
                    <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wide">Estimated
                        Value</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-bold">$</span>
                        <input type="number" name="estimated_value" value="<?php echo e(old('estimated_value', 0)); ?>" step="0.01"
                            min="0"
                            class="w-full bg-black/30 text-white border border-white/10 rounded-xl pl-8 pr-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                            placeholder="10000">
                    </div>
                    <?php $__errorArgs = ['estimated_value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wide">Notes</label>
                    <textarea name="notes" rows="4"
                        class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition resize-none"
                        placeholder="Add any additional notes or context about this lead..."><?php echo e(old('notes')); ?></textarea>
                    <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            
            <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-white/10">
                <a href="<?php echo e(route('leads.index')); ?>"
                    class="px-6 py-3 bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white rounded-xl font-bold text-sm transition border border-white/10">
                    Cancel
                </a>
                <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-orange-500/30 transition-all">
                    Create Lead
                </button>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\dell\.gemini\antigravity\scratch\leadix-app\resources\views/leads/create.blade.php ENDPATH**/ ?>