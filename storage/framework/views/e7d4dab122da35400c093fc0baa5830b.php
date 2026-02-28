

<?php $__env->startSection('header', 'Edit Invoice'); ?>

<?php $__env->startSection('content'); ?>
    <style>
        .form-card {
            background: rgba(20, 20, 20, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 115, 0, 0.1);
            transition: all 0.3s ease;
        }

        .form-card:hover {
            border-color: rgba(255, 115, 0, 0.3);
        }

        .form-input {
            background: rgba(30, 30, 30, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: rgba(255, 115, 0, 0.5);
            box-shadow: 0 0 0 3px rgba(255, 115, 0, 0.1);
            background: rgba(40, 40, 40, 0.9);
        }

        .btn-primary {
            background: linear-gradient(135deg, #ff7300 0%, #ff9500 100%);
            box-shadow: 0 4px 20px rgba(255, 115, 0, 0.3);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            box-shadow: 0 8px 30px rgba(255, 115, 0, 0.5);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: rgba(100, 100, 100, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: rgba(120, 120, 120, 0.4);
            border-color: rgba(255, 255, 255, 0.2);
        }
    </style>

    <div class="max-w-4xl mx-auto">
        
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-black text-white">Edit Invoice #<?php echo e($invoice->invoice_number); ?></h2>
                <p class="text-gray-400 text-sm mt-1">Update invoice details</p>
            </div>
            <a href="<?php echo e(route('invoices.index')); ?>" class="btn-secondary text-white px-4 py-2 rounded-lg font-medium">
                ← Back to Invoices
            </a>
        </div>

        
        <form action="<?php echo e(route('invoices.update', $invoice)); ?>" method="POST" class="form-card rounded-2xl p-6">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            
            <div class="mb-6">
                <h3 class="text-lg font-bold text-white mb-4 text-orange-500">Invoice Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    <div>
                        <label class="block text-gray-400 text-sm font-medium mb-2">Invoice Number *</label>
                        <input type="text" name="invoice_number"
                            value="<?php echo e(old('invoice_number', $invoice->invoice_number)); ?>"
                            class="form-input w-full px-4 py-2 rounded-lg" required readonly>
                        <?php $__errorArgs = ['invoice_number'];
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
                        <label class="block text-gray-400 text-sm font-medium mb-2">Deal (Optional)</label>
                        <input type="text"
                            value="<?php echo e($invoice->deal ? $invoice->deal->title . ' - ' . ($invoice->deal->lead->name ?? 'No Lead') : 'No Deal'); ?>"
                            class="form-input w-full px-4 py-2 rounded-lg" readonly>
                    </div>

                    
                    <div>
                        <label class="block text-gray-400 text-sm font-medium mb-2">Issue Date *</label>
                        <input type="date" name="issue_date"
                            value="<?php echo e(old('issue_date', $invoice->issue_date?->format('Y-m-d'))); ?>"
                            class="form-input w-full px-4 py-2 rounded-lg">
                        <?php $__errorArgs = ['issue_date'];
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
                        <label class="block text-gray-400 text-sm font-medium mb-2">Due Date *</label>
                        <input type="date" name="due_date"
                            value="<?php echo e(old('due_date', $invoice->due_date?->format('Y-m-d'))); ?>"
                            class="form-input w-full px-4 py-2 rounded-lg">
                        <?php $__errorArgs = ['due_date'];
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
                        <label class="block text-gray-400 text-sm font-medium mb-2">Status *</label>
                        <select name="status" class="form-input w-full px-4 py-2 rounded-lg" required>
                            <option value="draft" <?php echo e(old('status', $invoice->status) == 'draft' ? 'selected' : ''); ?>>Draft
                            </option>
                            <option value="sent" <?php echo e(old('status', $invoice->status) == 'sent' ? 'selected' : ''); ?>>Sent
                            </option>
                            <option value="paid" <?php echo e(old('status', $invoice->status) == 'paid' ? 'selected' : ''); ?>>Paid
                            </option>
                            <option value="overdue" <?php echo e(old('status', $invoice->status) == 'overdue' ? 'selected' : ''); ?>>
                                Overdue</option>
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

                    
                    <div>
                        <label class="block text-gray-400 text-sm font-medium mb-2">Total Amount *</label>
                        <input type="number" name="total" value="<?php echo e(old('total', $invoice->total)); ?>"
                            class="form-input w-full px-4 py-2 rounded-lg" min="0" step="0.01" required>
                        <?php $__errorArgs = ['total'];
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
            </div>

            
            <div class="flex justify-end gap-3">
                <a href="<?php echo e(route('invoices.index')); ?>" class="btn-secondary text-white px-6 py-3 rounded-lg font-medium">
                    Cancel
                </a>
                <button type="submit" class="btn-primary text-white px-6 py-3 rounded-lg font-bold">
                    Update Invoice
                </button>
            </div>
        </form>

        
        <?php if($invoice->items && $invoice->items->count() > 0): ?>
            <div class="form-card rounded-2xl p-6 mt-6">
                <h3 class="text-lg font-bold text-white mb-4 text-orange-500">Invoice Items</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="border-b border-white/10">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-bold text-gray-400 uppercase">Description</th>
                                <th class="px-4 py-2 text-right text-xs font-bold text-gray-400 uppercase">Quantity</th>
                                <th class="px-4 py-2 text-right text-xs font-bold text-gray-400 uppercase">Unit Price</th>
                                <th class="px-4 py-2 text-right text-xs font-bold text-gray-400 uppercase">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            <?php $__currentLoopData = $invoice->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="px-4 py-3 text-sm text-white"><?php echo e($item->description); ?></td>
                                    <td class="px-4 py-3 text-sm text-gray-300 text-right"><?php echo e($item->quantity); ?></td>
                                    <td class="px-4 py-3 text-sm text-gray-300 text-right">
                                        $<?php echo e(number_format($item->unit_price, 2)); ?></td>
                                    <td class="px-4 py-3 text-sm text-white font-semibold text-right">
                                        $<?php echo e(number_format($item->total, 2)); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot class="border-t border-white/10">
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-sm text-gray-400 text-right font-semibold">Subtotal:</td>
                                <td class="px-4 py-3 text-sm text-white font-semibold text-right">
                                    $<?php echo e(number_format($invoice->subtotal, 2)); ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-sm text-gray-400 text-right font-semibold">Tax:</td>
                                <td class="px-4 py-3 text-sm text-white font-semibold text-right">
                                    $<?php echo e(number_format($invoice->tax, 2)); ?></td>
                            </tr>
                            <tr class="border-t border-white/10">
                                <td colspan="3" class="px-4 py-3 text-sm text-orange-500 text-right font-bold">Total:</td>
                                <td class="px-4 py-3 text-lg text-orange-500 font-black text-right">
                                    $<?php echo e(number_format($invoice->total, 2)); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\dell\.gemini\antigravity\scratch\leadix-app\resources\views/invoices/edit.blade.php ENDPATH**/ ?>