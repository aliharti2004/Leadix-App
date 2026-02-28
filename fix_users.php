<?php

// Only run this in CLI
if (php_sapi_name() !== 'cli') {
    die("Run this script from command line: php fix_users.php");
}

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

// Bootstrap Laravel Kernel
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Organization;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

echo "--- Leadix User Fixer ---\n";

try {
    // 1. Ensure Organization exists
    $org = Organization::firstOrCreate(
        ['domain' => 'demo.leadix.com'],
        ['name' => 'Demo Corp', 'subdomain' => 'demo']
    );
    echo "[OK] Organization 'Demo Corp' (ID: {$org->id}) ready.\n";

    // 2. Fix Users
    $users = [
        ['email' => 'admin@demo.com', 'role' => 'admin', 'name' => 'Admin Owner'],
        ['email' => 'sales@demo.com', 'role' => 'sales', 'name' => 'Sales Agent'],
        ['email' => 'finance@demo.com', 'role' => 'finance', 'name' => 'Finance Manager'],
    ];

    foreach ($users as $u) {
        $user = User::withTrashed()->where('email', $u['email'])->first();

        if ($user) {
            // Restore if deleted
            if ($user->trashed()) {
                $user->restore();
                echo "[Restored] ";
            }

            // Update details
            $user->name = $u['name'];
            $user->role = $u['role'];
            $user->organization_id = $org->id;
            $user->password = Hash::make('password');
            $user->save();

            echo "[Updated] User {$u['email']} reset to password 'password' (Role: {$u['role']})\n";
        } else {
            // Create new
            User::create([
                'name' => $u['name'],
                'email' => $u['email'],
                'password' => Hash::make('password'),
                'organization_id' => $org->id,
                'role' => $u['role'],
            ]);
            echo "[Created] User {$u['email']} created with password 'password' (Role: {$u['role']})\n";
        }
    }

    echo "\n[SUCCESS] All users ready. You can now login.\n";

} catch (\Exception $e) {
    echo "\n[ERROR] " . $e->getMessage() . "\n";
    echo "Stack Trace:\n" . $e->getTraceAsString();
}
