<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Checking users in database...\n\n";

$users = App\Models\User::all();
echo "Total users: " . $users->count() . "\n\n";

foreach ($users as $user) {
    echo "- {$user->email} ({$user->name}) - Role: {$user->role}\n";
}

echo "\n\nChecking admin user specifically:\n";
$admin = App\Models\User::where('email', 'admin@demo.com')->first();

if ($admin) {
    echo "✓ Admin user found!\n";
    echo "  Name: {$admin->name}\n";
    echo "  Email: {$admin->email}\n";
    echo "  Role: {$admin->role}\n";

    // Test password
    if (Hash::check('password', $admin->password)) {
        echo "  ✓ Password 'password' matches!\n";
    } else {
        echo "  ✗ Password does NOT match!\n";
    }
} else {
    echo "✗ Admin user NOT found!\n";
}
