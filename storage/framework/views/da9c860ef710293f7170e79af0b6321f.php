

<?php $__env->startSection('header', 'Create Invoice'); ?>

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

        .item-row {
            background: rgba(30, 30, 30, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 0.75rem;
        }
    </style>

    <div class="max-w-4xl mx-auto">
        
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-black text-white">Create New Invoice</h2>
                <p class="text-gray-400 text-sm mt-1">Add a new invoice to your organization</p>
            </div>
            <a href="<?php echo e(route('invoices.kanban')); ?>" class="btn-secondary text-white px-4 py-2 rounded-lg font-medium">
                ← Back to Invoices
            </a>
        </div>

        
        <form action="<?php echo e(route('invoices.store')); ?>" method="POST" id="invoiceForm" class="form-card rounded-2xl p-6">
            <?php echo csrf_field(); ?>

            
            <div class="mb-6">
                <h3 class="text-lg font-bold text-white mb-4 text-orange-500">Invoice Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    <div>
                        <label class="block text-gray-400 text-sm font-medium mb-2">Invoice Number *</label>
                        <input type="text" name="invoice_number" value="<?php echo e(old('invoice_number', $nextInvoiceNumber)); ?>"
                            class="form-input w-full px-4 py-2 rounded-lg" required>
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
                        <select name="deal_id" class="form-input w-full px-4 py-2 rounded-lg">
                            <option value="">No Deal</option>
                            <?php $__currentLoopData = $deals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($deal->id); ?>" <?php echo e(old('deal_id') == $deal->id ? 'selected' : ''); ?>>
                                    <?php echo e($deal->title); ?> - <?php echo e($deal->lead->name ?? 'No Lead'); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['deal_id'];
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
                        <label class="block text-gray-400 text-sm font-medium mb-2">Issue Date *</label>
                        <input type="date" name="issue_date" value="<?php echo e(old('issue_date', date('Y-m-d'))); ?>"
                            class="form-input w-full px-4 py-2 rounded-lg" required>
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
                            value="<?php echo e(old('due_date', date('Y-m-d', strtotime('+30 days')))); ?>"
                            class="form-input w-full px-4 py-2 rounded-lg" required>
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
                            <option value="draft" <?php echo e(old('status') == 'draft' ? 'selected' : ''); ?>>Draft</option>
                            <option value="sent" <?php echo e(old('status', 'draft') == 'sent' ? 'selected' : ''); ?>>Sent</option>
                            <option value="paid" <?php echo e(old('status') == 'paid' ? 'selected' : ''); ?>>Paid</option>
                            <option value="overdue" <?php echo e(old('status') == 'overdue' ? 'selected' : ''); ?>>Overdue</option>
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
                </div>
            </div>

            
            <div class="mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-white text-orange-500">Invoice Items</h3>
                    <button type="button" onclick="addItem()"
                        class="text-orange-500 hover:text-orange-400 font-medium text-sm">
                        + Add Item
                    </button>
                </div>

                <div id="itemsContainer">
                    
                    <div class="item-row" data-item-index="0">
                        <div class="grid grid-cols-12 gap-3">
                            <div class="col-span-12 md:col-span-5">
                                <label class="block text-gray-400 text-xs font-medium mb-1">Description *</label>
                                <input type="text" name="items[0][description]"
                                    class="form-input w-full px-3 py-2 rounded-lg text-sm"
                                    placeholder="Professional Services" required>
                            </div>
                            <div class="col-span-4 md:col-span-2">
                                <label class="block text-gray-400 text-xs font-medium mb-1">Quantity *</label>
                                <input type="number" name="items[0][quantity]"
                                    class="form-input w-full px-3 py-2 rounded-lg text-sm item-quantity" value="1" min="1"
                                    step="0.01" required onchange="calculateItemTotal(this)">
                            </div>
                            <div class="col-span-4 md:col-span-2">
                                <label class="block text-gray-400 text-xs font-medium mb-1">Unit Price *</label>
                                <input type="number" name="items[0][unit_price]"
                                    class="form-input w-full px-3 py-2 rounded-lg text-sm item-price" value="0" min="0"
                                    step="0.01" required onchange="calculateItemTotal(this)">
                            </div>
                            <div class="col-span-3 md:col-span-2">
                                <label class="block text-gray-400 text-xs font-medium mb-1">Total</label>
                                <input type="text"
                                    class="form-input w-full px-3 py-2 rounded-lg text-sm item-total bg-gray-800"
                                    value="$0.00" readonly>
                            </div>
                            <div class="col-span-1 flex items-end">
                                <button type="button" onclick="removeItem(this)"
                                    class="text-red-500 hover:text-red-400 p-2">
                                    ✕
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="mb-6">
                <div class="max-w-md ml-auto space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400">Subtotal:</span>
                        <span class="text-white font-bold" id="subtotalDisplay">$0.00</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <label class="text-gray-400">Tax:</label>
                        <div class="flex items-center gap-2">
                            <span class="text-white">$</span>
                            <input type="number" name="tax" id="taxInput" value="<?php echo e(old('tax', 0)); ?>"
                                class="form-input px-3 py-1 rounded-lg w-32 text-right" min="0" step="0.01"
                                onchange="calculateTotals()">
                        </div>
                    </div>
                    <div class="flex justify-between items-center pt-3 border-t border-gray-700">
                        <span class="text-gray-300 font-bold">Total:</span>
                        <span class="text-orange-500 font-black text-2xl" id="totalDisplay">$0.00</span>
                    </div>
                    <input type="hidden" name="total" id="totalInput" value="0">
                </div>
            </div>

            
            <div class="flex justify-end gap-3">
                <a href="<?php echo e(route('invoices.kanban')); ?>" class="btn-secondary text-white px-6 py-3 rounded-lg font-medium">
                    Cancel
                </a>
                <button type="submit" class="btn-primary text-white px-6 py-3 rounded-lg font-bold">
                    Create Invoice
                </button>
            </div>
        </form>
    </div>

    <script>
        let itemIndex = 1;

        function addItem() {
            const container = document.getElementById('itemsContainer');
            const newItem = `
                <div class="item-row" data-item-index="${itemIndex}">
                    <div class="grid grid-cols-12 gap-3">
                        <div class="col-span-12 md:col-span-5">
                            <label class="block text-gray-400 text-xs font-medium mb-1">Description *</label>
                            <input type="text" 
                                   name="items[${itemIndex}][description]" 
                                   class="form-input w-full px-3 py-2 rounded-lg text-sm" 
                                   placeholder="Item description"
                                   required>
                        </div>
                        <div class="col-span-4 md:col-span-2">
                            <label class="block text-gray-400 text-xs font-medium mb-1">Quantity *</label>
                            <input type="number" 
                                   name="items[${itemIndex}][quantity]" 
                                   class="form-input w-full px-3 py-2 rounded-lg text-sm item-quantity" 
                                   value="1" 
                                   min="1"
                                   step="0.01"
                                   required
                                   onchange="calculateItemTotal(this)">
                        </div>
                        <div class="col-span-4 md:col-span-2">
                            <label class="block text-gray-400 text-xs font-medium mb-1">Unit Price *</label>
                            <input type="number" 
                                   name="items[${itemIndex}][unit_price]" 
                                   class="form-input w-full px-3 py-2 rounded-lg text-sm item-price" 
                                   value="0" 
                                   min="0"
                                   step="0.01"
                                   required
                                   onchange="calculateItemTotal(this)">
                        </div>
                        <div class="col-span-3 md:col-span-2">
                            <label class="block text-gray-400 text-xs font-medium mb-1">Total</label>
                            <input type="text" 
                                   class="form-input w-full px-3 py-2 rounded-lg text-sm item-total bg-gray-800" 
                                   value="$0.00" 
                                   readonly>
                        </div>
                        <div class="col-span-1 flex items-end">
                            <button type="button" 
                                    onclick="removeItem(this)" 
                                    class="text-red-500 hover:text-red-400 p-2">
                                ✕
                            </button>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', newItem);
            itemIndex++;
        }

        function removeItem(button) {
            const itemRow = button.closest('.item-row');
            if (document.querySelectorAll('.item-row').length > 1) {
                itemRow.remove();
                calculateTotals();
            } else {
                alert('You must have at least one item');
            }
        }

        function calculateItemTotal(input) {
            const row = input.closest('.item-row');
            const quantity = parseFloat(row.querySelector('.item-quantity').value) || 0;
            const price = parseFloat(row.querySelector('.item-price').value) || 0;
            const total = quantity * price;

            row.querySelector('.item-total').value = '$' + total.toFixed(2);
            calculateTotals();
        }

        function calculateTotals() {
            let subtotal = 0;

            // Sum all item totals
            document.querySelectorAll('.item-row').forEach(row => {
                const quantity = parseFloat(row.querySelector('.item-quantity').value) || 0;
                const price = parseFloat(row.querySelector('.item-price').value) || 0;
                subtotal += quantity * price;
            });

            const tax = parseFloat(document.getElementById('taxInput').value) || 0;
            const total = subtotal + tax;

            document.getElementById('subtotalDisplay').textContent = '$' + subtotal.toFixed(2);
            document.getElementById('totalDisplay').textContent = '$' + total.toFixed(2);
            document.getElementById('totalInput').value = total.toFixed(2);
        }

        // Initialize totals on page load
        document.addEventListener('DOMContentLoaded', function () {
            calculateTotals();
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\dell\.gemini\antigravity\scratch\leadix-app\resources\views/invoices/create.blade.php ENDPATH**/ ?>