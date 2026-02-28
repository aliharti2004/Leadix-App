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
    <div class="max-w-4xl mx-auto" x-data="invoiceEditApp(<?php echo e($invoice->id); ?>)">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-3xl font-black text-white">Invoice <?php echo e($invoice->invoice_number); ?></h1>
            <div class="flex items-center gap-3">
                <button @click="editMode = !editMode" 
                        class="px-4 py-2 rounded-lg font-semibold transition"
                        :class="editMode ? 'bg-red-500/20 text-red-400 border border-red-500/30' : 'bg-orange-500/20 text-orange-400 border border-orange-500/30'">
                    <span x-text="editMode ? 'Cancel' : 'Edit Invoice'"></span>
                </button>
                <a href="<?php echo e(route('invoices.kanban')); ?>" class="text-gray-400 hover:text-orange-500 transition">
                    ← Back to Kanban
                </a>
            </div>
        </div>

        <form @submit.prevent="saveInvoice" class="glass-card rounded-2xl p-8">
            <!-- Invoice Header -->
            <div class="flex justify-between items-start mb-8">
                <div>
                    <div class="flex items-center gap-4 mb-4">
                        <h2 class="text-2xl font-bold text-white"><?php echo e($invoice->invoice_number); ?></h2>
                        <div class="inline-block px-3 py-1 rounded-lg text-sm font-bold uppercase
                            <?php if($invoice->status === 'paid'): ?> bg-green-500/20 text-green-400 border border-green-500/30
                            <?php elseif($invoice->status === 'overdue'): ?> bg-red-500/20 text-red-400 border border-red-500/30
                            <?php elseif($invoice->status === 'pending'): ?> bg-amber-500/20 text-amber-400 border border-amber-500/30
                            <?php else: ?> bg-gray-500/20 text-gray-400 border border-gray-500/30 <?php endif; ?>">
                            <?php echo e($invoice->status); ?>

                        </div>
                    </div>

                    <!-- Company Name - Prominent -->
                    <div x-show="!editMode" class="mb-4">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m" />
                            </svg>
                            <span class="text-2xl font-bold text-white">
                                <?php if($invoice->deal && $invoice->deal->lead): ?>
                                    <?php echo e($invoice->deal->lead->company); ?>

                                <?php else: ?>
                                    <span class="text-gray-500">No Company Assigned</span>
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>
                </div>
                
                <a href="<?php echo e(route('invoices.pdf', $invoice)); ?>" 
                   class="btn-gradient px-6 py-3 rounded-full text-white font-bold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Download PDF
                </a>
            </div>

            <!-- Invoice Details -->
            <div class="grid grid-cols-2 gap-8 mb-8">
                <!-- Bill To -->
                <div>
                    <h3 class="text-sm font-bold text-gray-400 uppercase mb-3">Bill To</h3>
                    
                    <!-- Edit Mode -->
                    <div x-show="editMode" class="space-y-3">
                        <div>
                            <label class="text-xs text-gray-400 font-semibold">Deal/Company</label>
                            <select x-model="form.deal_id"
                                    class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-orange-500">
                                <option value="">No Deal</option>
                                <?php $__currentLoopData = \App\Models\Deal::with('lead')->where('organization_id', auth()->user()->organization_id)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($deal->id); ?>" <?php echo e($invoice->deal_id == $deal->id ? 'selected' : ''); ?>>
                                        <?php echo e($deal->name); ?> - <?php echo e($deal->lead->company ?? 'No Company'); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <!-- View Mode -->
                    <div x-show="!editMode">
                        <?php if($invoice->deal && $invoice->deal->lead): ?>
                            <p class="text-white font-bold text-lg"><?php echo e($invoice->deal->lead->company); ?></p>
                            <p class="text-gray-400"><?php echo e($invoice->deal->lead->contact_name); ?></p>
                            <p class="text-gray-400"><?php echo e($invoice->deal->lead->email); ?></p>
                        <?php else: ?>
                            <p class="text-gray-500">No customer information</p>
                            <p class="text-xs text-amber-400 mt-2">Click "Edit Invoice" to assign a company</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Invoice Details -->
                <div>
                    <h3 class="text-sm font-bold text-gray-400 uppercase mb-3">Invoice Details</h3>
                    
                    <!-- Edit Mode -->
                    <div x-show="editMode" class="space-y-3">
                        <div>
                            <label class="text-xs text-gray-400 font-semibold">Status</label>
                            <select x-model="form.status"
                                    class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-orange-500">
                                <option value="draft">Draft</option>
                                <option value="pending">Pending</option>
                                <option value="paid">Paid</option>
                                <option value="overdue">Overdue</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-xs text-gray-400 font-semibold">Issue Date</label>
                            <input type="date" x-model="form.issue_date"
                                   class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-orange-500">
                        </div>
                        <div>
                            <label class="text-xs text-gray-400 font-semibold">Due Date</label>
                            <input type="date" x-model="form.due_date"
                                   class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-orange-500">
                        </div>
                        <div>
                            <label class="text-xs text-gray-400 font-semibold">Total Amount</label>
                            <input type="number" step="0.01" x-model="form.total"
                                   class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-orange-500">
                        </div>
                    </div>

                    <!-- View Mode -->
                    <div x-show="!editMode" class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Issue Date:</span>
                            <span class="text-white font-semibold"><?php echo e($invoice->issue_date ? $invoice->issue_date->format('M d, Y') : 'N/A'); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Due Date:</span>
                            <span class="text-white font-semibold"><?php echo e($invoice->due_date ? $invoice->due_date->format('M d, Y') : 'N/A'); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Amount -->
            <div class="border-t border-white/10 pt-6">
                <div class="flex justify-between items-center">
                    <span class="text-gray-400 font-semibold">Total Amount</span>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-amber-500 font-black text-4xl">
                        $<?php echo e(number_format($invoice->total, 2)); ?>

                    </span>
                </div>
            </div>

            <!-- Save Button -->
            <div x-show="editMode" class="mt-6 flex justify-end">
                <button type="submit"
                        class="btn-gradient px-8 py-3 rounded-full text-white font-bold">
                    Save Changes
                </button>
            </div>
        </form>

        <!-- Toast Messages -->
        <div class="fixed bottom-6 right-6 space-y-3 z-50" x-show="toasts.length > 0" style="display: none;">
            <template x-for="toast in toasts" :key="toast.id">
                <div class="glass-card rounded-2xl p-4 shadow-2xl flex items-center gap-3 min-w-[320px] border"
                     :class="{'border-green-500': toast.type === 'success', 'border-red-500': toast.type === 'error'}">
                    <p class="text-white text-sm font-bold flex-1" x-text="toast.message"></p>
                    <button @click="dismissToast(toast.id)" class="text-gray-400 hover:text-orange-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </template>
        </div>
    </div>

    <script>
        function invoiceEditApp(invoiceId) {
            return {
                editMode: false,
                toasts: [],
                form: {
                    deal_id: '<?php echo e($invoice->deal_id ?? ''); ?>',
                    status: '<?php echo e($invoice->status); ?>',
                    issue_date: '<?php echo e($invoice->issue_date ? $invoice->issue_date->format('Y-m-d') : ''); ?>',
                    due_date: '<?php echo e($invoice->due_date ? $invoice->due_date->format('Y-m-d') : ''); ?>',
                    total: '<?php echo e($invoice->total); ?>'
                },

                saveInvoice() {
                    fetch(`/invoices/${invoiceId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(this.form)
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            this.showToast('Invoice updated successfully!', 'success');
                            this.editMode = false;
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            this.showToast(data.message || 'Error updating invoice', 'error');
                        }
                    })
                    .catch(() => {
                        this.showToast('Error updating invoice', 'error');
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
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Users\dell\.gemini\antigravity\scratch\leadix-app\resources\views/invoices/show.blade.php ENDPATH**/ ?>