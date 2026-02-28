
<?php
    $notifType = $type ?? null;
    $iconFallback = $icon ?? 'info';
?>

<?php if(in_array($notifType, ['deal_won', 'payment_received']) || $iconFallback === 'success'): ?>
    
    <div class="w-8 h-8 rounded-lg bg-green-500/20 flex items-center justify-center">
        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                clip-rule="evenodd" />
        </svg>
    </div>
<?php elseif($notifType === 'invoice_overdue' || $iconFallback === 'warning' || $iconFallback === 'error'): ?>
    
    <div class="w-8 h-8 rounded-lg bg-red-500/20 flex items-center justify-center">
        <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                clip-rule="evenodd" />
        </svg>
    </div>
<?php elseif($notifType === 'invoice_created'): ?>
    
    <div class="w-8 h-8 rounded-lg bg-blue-500/20 flex items-center justify-center">
        <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                clip-rule="evenodd" />
        </svg>
    </div>
<?php elseif($notifType === 'contact_created'): ?>
    
    <div class="w-8 h-8 rounded-lg bg-indigo-500/20 flex items-center justify-center">
        <svg class="w-4 h-4 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
        </svg>
    </div>
<?php else: ?>
    
    <div class="w-8 h-8 rounded-lg bg-blue-500/20 flex items-center justify-center">
        <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                clip-rule="evenodd" />
        </svg>
    </div>
<?php endif; ?><?php /**PATH C:\Users\dell\.gemini\antigravity\scratch\leadix-app\resources\views/layouts/partials/notification-icon.blade.php ENDPATH**/ ?>