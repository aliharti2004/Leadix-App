<?php

if (php_sapi_name() !== 'cli') {
    die("Run this script from command line: php seed_data.php");
}

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Force Load Models
$models = [
    __DIR__ . '/app/Models/Organization.php',
    __DIR__ . '/app/Models/User.php',
    __DIR__ . '/app/Models/DealStage.php',
    __DIR__ . '/app/Models/Lead.php',
    __DIR__ . '/app/Models/Deal.php',
];

foreach ($models as $path) {
    if (file_exists($path))
        require_once $path;
}

use App\Models\Organization;
use App\Models\User;
use App\Models\DealStage;
use App\Models\Lead;
use App\Models\Deal;

echo "--- Leadix Data Seeder ---\n";

try {
    $org = Organization::where('domain', 'demo.leadix.com')->first();
    if (!$org)
        die("Error: Organization not found. Run fix_users.php first.\n");

    $startOrgId = session('organization_id');
    session(['organization_id' => $org->id]); // Force context

    // 1. Create Stages
    $stages = [
        ['name' => 'Prospecting', 'probability' => 10],
        ['name' => 'Qualified', 'probability' => 30],
        ['name' => 'Proposal', 'probability' => 50],
        ['name' => 'Negotiation', 'probability' => 80],
        ['name' => 'Won', 'probability' => 100],
        ['name' => 'Lost', 'probability' => 0],
    ];

    foreach ($stages as $index => $s) {
        DealStage::firstOrCreate(
            ['name' => $s['name'], 'organization_id' => $org->id],
            ['probability' => $s['probability'], 'position' => $index + 1]
        );
    }
    echo "[OK] Deal Stages created.\n";

    // 2. Get Sales User
    $sales = User::where('email', 'sales@demo.com')->first();
    if (!$sales)
        die("Error: Sales user not found.\n");

    // 3. Create Leads
    $leads = [
        ['title' => 'Big Enterprise Lead', 'val' => 50000],
        ['title' => 'Startup Bundle', 'val' => 5000],
        ['title' => 'Consulting Gig', 'val' => 12000],
    ];

    foreach ($leads as $l) {
        Lead::firstOrCreate(
            ['title' => $l['title'], 'organization_id' => $org->id],
            [
                'user_id' => $sales->id,
                'contact_name' => 'John Doe',
                'estimated_value' => $l['val'],
                'status' => 'new'
            ]
        );
    }
    echo "[OK] Leads created for Sales Agent.\n";

    // 4. Create Active Deals
    $negStage = DealStage::where('name', 'Negotiation')->where('organization_id', $org->id)->first();
    $propStage = DealStage::where('name', 'Proposal')->where('organization_id', $org->id)->first();

    if ($negStage) {
        Deal::firstOrCreate(
            ['title' => 'SaaS Contract Q3', 'organization_id' => $org->id],
            [
                'user_id' => $sales->id,
                'deal_stage_id' => $negStage->id,
                'value' => 25000,
                'expected_close_date' => now()->addDays(15)
            ]
        );
    }

    if ($propStage) {
        Deal::firstOrCreate(
            ['title' => 'Website Redesign', 'organization_id' => $org->id],
            [
                'user_id' => $sales->id,
                'deal_stage_id' => $propStage->id,
                'value' => 8500,
                'expected_close_date' => now()->addDays(7)
            ]
        );
    }
    echo "[OK] Deals created for Sales Agent.\n";

    echo "\n[SUCCESS] Data populated! Refresh your dashboard.\n";

} catch (\Exception $e) {
    echo "\n[ERROR] " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
