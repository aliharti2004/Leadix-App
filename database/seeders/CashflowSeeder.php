<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Expense;
use App\Models\Organization;
use App\Models\User;
use Carbon\Carbon;

class CashflowSeeder extends Seeder
{
    public function run()
    {
        $org = Organization::first();
        $user = User::first();

        if (!$org || !$user) {
            echo "No organization or user found.\n";
            return;
        }

        // Add expenses for the last 6 months
        for ($i = 0; $i < 6; $i++) {
            Expense::create([
                'organization_id' => $org->id,
                'user_id' => $user->id,
                'amount' => rand(5000, 15000),
                'description' => 'Monthly Infrastructure',
                'category' => 'Infrastructure',
                'date' => Carbon::now()->subMonths($i)->startOfMonth()->addDays(rand(1, 28)),
            ]);

            Expense::create([
                'organization_id' => $org->id,
                'user_id' => $user->id,
                'amount' => rand(2000, 5000),
                'description' => 'Marketing Spend',
                'category' => 'Marketing',
                'date' => Carbon::now()->subMonths($i)->startOfMonth()->addDays(rand(1, 15)),
            ]);
        }

        echo "Expenses seeded successfully.\n";
    }
}
