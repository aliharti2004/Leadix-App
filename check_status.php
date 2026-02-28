<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Current Notification Status:\n";
echo "============================\n\n";

$user = App\Models\User::find(2);
echo "Logged in user: {$user->name}\n";
echo "Total notifications: " . $user->notifications()->count() . "\n";
echo "Unread notifications: " . $user->unreadNotifications->count() . "\n\n";

echo "Recent notifications:\n";
$recent = $user->notifications()->latest()->take(5)->get();
foreach ($recent as $notif) {
    $readStatus = $notif->read_at ? '✓ Read' : '⚠ UNREAD';
    echo "- [{$readStatus}] {$notif->data['message']} (Created: {$notif->created_at->diffForHumans()})\n";
}

echo "\n\nAll overdue notifications in database:\n";
$all = \Illuminate\Notifications\DatabaseNotification::where('type', 'App\Notifications\InvoiceOverdueNotification')->get();
echo "Found: " . $all->count() . " overdue invoice notifications\n";
