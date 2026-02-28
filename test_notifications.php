<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing Notification System...\n\n";

// Get a user
$user = App\Models\User::find(2);
echo "User: {$user->name} (ID: {$user->id})\n";
echo "User email: {$user->email}\n\n";

// Check current notifications
$before = $user->notifications()->count();
echo "Notifications before: $before\n\n";

// Create a test notification
echo "Creating test notification...\n";
try {
    $deal = App\Models\Deal::first();
    echo "Deal: {$deal->title}\n";

    $notification = new App\Notifications\DealWonNotification($deal);
    $user->notify($notification);

    echo "✓ Notification created successfully!\n\n";
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n\n";
}

// Check after
$after = $user->notifications()->count();
echo "Notifications after: $after\n";
echo "New notifications: " . ($after - $before) . "\n\n";

// Show latest notification
$latest = $user->notifications()->latest()->first();
if ($latest) {
    echo "Latest notification:\n";
    echo "- Type: {$latest->type}\n";
    echo "- Created: {$latest->created_at}\n";
    echo "- Data: " . json_encode($latest->data, JSON_PRETTY_PRINT) . "\n";
}
