<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Organization;
use App\Models\User;
use App\Models\DealStage;
use App\Models\Lead;
use App\Models\Deal;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Payment;
use App\Models\Expense;
use App\Models\Contact;
use App\Models\Activity;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        echo "🌱 Seeding demo data for impressive dashboards...\n";

        // Get the Demo Corp organization
        $org = Organization::where('domain', 'demo.leadix.com')->first();

        if (!$org) {
            echo "❌ Demo organization not found. Run fix_users.php first.\n";
            return;
        }

        echo "✅ Found organization: {$org->name}\n";

        // Get users
        $admin = User::where('email', 'admin@demo.com')->first();
        $sales = User::where('email', 'sales@demo.com')->first();
        $finance = User::where('email', 'finance@demo.com')->first();

        // 1. Create Deal Stages (if they don't exist)
        echo "\n📊 Creating deal stages...\n";
        $stages = [
            ['name' => 'Lead', 'position' => 1, 'probability' => 10],
            ['name' => 'Qualified', 'position' => 2, 'probability' => 25],
            ['name' => 'Proposal', 'position' => 3, 'probability' => 50],
            ['name' => 'Negotiation', 'position' => 4, 'probability' => 75],
            ['name' => 'Won', 'position' => 5, 'probability' => 100],
            ['name' => 'Lost', 'position' => 6, 'probability' => 0],
        ];

        $stageModels = [];
        foreach ($stages as $stageData) {
            $stage = DealStage::firstOrCreate(
                ['name' => $stageData['name'], 'organization_id' => $org->id],
                ['position' => $stageData['position'], 'probability' => $stageData['probability']]
            );
            $stageModels[$stageData['name']] = $stage;
            echo "  ✓ {$stageData['name']} stage\n";
        }

        // 2. Create Contacts
        echo "\n👥 Creating contacts...\n";
        $contacts = [
            ['name' => 'Sarah Johnson', 'email' => 'sarah@techcorp.com', 'phone' => '+1-555-0101', 'job_title' => 'VP of Operations - TechCorp Solutions'],
            ['name' => 'Michael Chen', 'email' => 'mchen@innovate.io', 'phone' => '+1-555-0102', 'job_title' => 'CTO - Innovate Industries'],
            ['name' => 'Emma Williams', 'email' => 'emma@globaltech.com', 'phone' => '+1-555-0103', 'job_title' => 'Director of IT - GlobalTech Inc'],
            ['name' => 'David Martinez', 'email' => 'dmartinez@cloudify.com', 'phone' => '+1-555-0104', 'job_title' => 'CEO - Cloudify Systems'],
            ['name' => 'Lisa Anderson', 'email' => 'landerson@datastream.net', 'phone' => '+1-555-0105', 'job_title' => 'CFO - DataStream Corp'],
        ];

        $contactModels = [];
        foreach ($contacts as $contactData) {
            $contact = Contact::create(array_merge($contactData, ['organization_id' => $org->id]));
            $contactModels[] = $contact;
            echo "  ✓ {$contactData['name']} ({$contactData['job_title']})\n";
        }

        // 3. Create Leads
        echo "\n🎯 Creating leads...\n";
        $leadData = [
            ['title' => 'TechCorp Enterprise License', 'contact_name' => 'Sarah Johnson', 'email' => 'sarah@techcorp.com', 'phone' => '+1-555-0101', 'status' => 'qualified', 'estimated_value' => 45000],
            ['title' => 'Innovate Annual Subscription', 'contact_name' => 'Michael Chen', 'email' => 'mchen@innovate.io', 'phone' => '+1-555-0102', 'status' => 'new', 'estimated_value' => 28000],
            ['title' => 'GlobalTech Integration Project', 'contact_name' => 'Emma Williams', 'email' => 'emma@globaltech.com', 'phone' => '+1-555-0103', 'status' => 'contacted', 'estimated_value' => 62000],
        ];

        $leads = [];
        foreach ($leadData as $data) {
            $lead = Lead::create(array_merge($data, [
                'organization_id' => $org->id,
                'user_id' => $sales->id,
                'notes' => 'Generated demo data'
            ]));
            $leads[] = $lead;
            echo "  ✓ {$data['title']} - {$data['status']}\n";
        }

        // 4. Create Deals (including converted from leads and standalone)
        echo "\n💼 Creating deals...\n";
        $dealData = [
            // Active deals in various stages
            ['title' => 'TechCorp Enterprise License', 'value' => 45000, 'stage' => 'Proposal', 'expected_close_date' => now()->addDays(15), 'lead_id' => $leads[0]->id],
            ['title' => 'Cloudify Cloud Migration', 'value' => 89000, 'stage' => 'Negotiation', 'expected_close_date' => now()->addDays(20)],
            ['title' => 'DataStream Analytics Platform', 'value' => 125000, 'stage' => 'Proposal', 'expected_close_date' => now()->addDays(30)],
            ['title' => 'MegaCorp CRM Implementation', 'value' => 210000, 'stage' => 'Qualified', 'expected_close_date' => now()->addDays(45)],
            ['title' => 'StartupXYZ Growth Package', 'value' => 18500, 'stage' => 'Lead', 'expected_close_date' => now()->addDays(60)],

            // Won deals (last 6 months for revenue chart)
            ['title' => 'Acme Corp Annual License', 'value' => 55000, 'stage' => 'Won', 'won_at' => now()->subMonths(1)->startOfMonth()],
            ['title' => 'Beta Industries Integration', 'value' => 72000, 'stage' => 'Won', 'won_at' => now()->subMonths(2)->startOfMonth()],
            ['title' => 'Gamma Solutions Package', 'value' => 38000, 'stage' => 'Won', 'won_at' => now()->subMonths(3)->startOfMonth()],
            ['title' => 'Delta Tech Consulting', 'value' => 95000, 'stage' => 'Won', 'won_at' => now()->subMonths(4)->startOfMonth()],
            ['title' => 'Epsilon Systems Deal', 'value' => 42000, 'stage' => 'Won', 'won_at' => now()->subMonths(5)->startOfMonth()],
        ];

        foreach ($dealData as $data) {
            $stageName = $data['stage'];
            unset($data['stage']);

            $deal = Deal::create(array_merge($data, [
                'organization_id' => $org->id,
                'user_id' => $sales->id,
                'deal_stage_id' => $stageModels[$stageName]->id,
            ]));
            echo "  ✓ {$data['title']} - {$stageName} ($" . number_format($data['value']) . ")\n";
        }

        // 5. Create Invoices
        echo "\n📄 Creating invoices...\n";
        $invoiceData = [
            // Paid invoices (for revenue)
            ['invoice_number' => 'INV-2025-001', 'issue_date' => now()->subMonths(1), 'due_date' => now()->subMonths(1)->addDays(30), 'status' => 'paid', 'total' => 55000, 'tax' => 5500, 'subtotal' => 49500],
            ['invoice_number' => 'INV-2025-002', 'issue_date' => now()->subMonths(2), 'due_date' => now()->subMonths(2)->addDays(30), 'status' => 'paid', 'total' => 72000, 'tax' => 7200, 'subtotal' => 64800],
            ['invoice_number' => 'INV-2025-003', 'issue_date' => now()->subMonths(3), 'due_date' => now()->subMonths(3)->addDays(30), 'status' => 'paid', 'total' => 38000, 'tax' => 3800, 'subtotal' => 34200],

            // Sent/Pending invoices
            ['invoice_number' => 'INV-2026-001', 'issue_date' => now()->subDays(10), 'due_date' => now()->addDays(20), 'status' => 'sent', 'total' => 15000, 'tax' => 1500, 'subtotal' => 13500],
            ['invoice_number' => 'INV-2026-002', 'issue_date' => now()->subDays(5), 'due_date' => now()->addDays(25), 'status' => 'sent', 'total' => 22500, 'tax' => 2250, 'subtotal' => 20250],

            // Overdue invoice
            ['invoice_number' => 'INV-2025-099', 'issue_date' => now()->subDays(45), 'due_date' => now()->subDays(15), 'status' => 'overdue', 'total' => 18500, 'tax' => 1850, 'subtotal' => 16650],

            // Draft
            ['invoice_number' => 'INV-2026-003', 'issue_date' => now(), 'due_date' => now()->addDays(30), 'status' => 'draft', 'total' => 32000, 'tax' => 3200, 'subtotal' => 28800],
        ];

        foreach ($invoiceData as $data) {
            $invoice = Invoice::create(array_merge($data, [
                'organization_id' => $org->id,
            ]));

            // Add invoice items
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'description' => 'Professional Services',
                'quantity' => 1,
                'unit_price' => $data['subtotal'],
                'total' => $data['subtotal'],
            ]);

            echo "  ✓ Invoice {$data['invoice_number']} - {$data['status']} ($" . number_format($data['total']) . ")\n";
        }

        // 6. Create Expenses
        echo "\n💸 Creating expenses...\n";
        $expenseData = [
            ['amount' => 5200, 'category' => 'Software', 'date' => now()->subMonths(1), 'description' => 'AWS Cloud Services - Monthly subscription'],
            ['amount' => 3800, 'category' => 'Marketing', 'date' => now()->subMonths(1), 'description' => 'Google Ads Campaign'],
            ['amount' => 4500, 'category' => 'Software', 'date' => now()->subMonths(2), 'description' => 'Adobe Creative Cloud - Team license'],
            ['amount' => 2100, 'category' => 'Office', 'date' => now()->subMonths(2), 'description' => 'WeWork Office Space'],
            ['amount' => 6700, 'category' => 'Payroll', 'date' => now()->subMonths(3), 'description' => 'Gusto Payroll Service'],
            ['amount' => 1900, 'category' => 'Software', 'date' => now()->subMonths(3), 'description' => 'Slack Business subscription'],
        ];

        foreach ($expenseData as $data) {
            $expense = Expense::create(array_merge($data, [
                'organization_id' => $org->id,
                'user_id' => $finance->id,
            ]));
            echo "  ✓ {$data['category']} - {$data['description']} ($" . number_format($data['amount']) . ")\n";
        }

        // 7. Create Activities (skipping for now - not critical for dashboards)
        echo "\n📝 Skipping activities (not needed for dashboard demo)...\n";
        // $activityData = [
        //     ['type' => 'call', 'description' => 'Follow-up call with TechCorp', 'completed' => true],
        //     ['type' => 'email', 'description' => 'Sent proposal to Cloudify', 'completed' => true],
        //     ['type' => 'meeting', 'description' => 'Demo scheduled with DataStream', 'due_at' => now()->addDays(3), 'completed' => false],
        //     ['type' => 'task', 'description' => 'Prepare contract for MegaCorp', 'due_at' => now()->addDays(7), 'completed' => false],
        // ];

        // foreach ($activityData as $data) {
        //     $activity = Activity::create(array_merge($data, [
        //         'organization_id' => $org->id,
        //         'user_id' => $sales->id,
        //     ]));
        //     echo "  ✓ {$data['type']} - {$data['description']}\n";
        // }

        echo "\n✨ Demo data seeding complete!\n";
        echo "\n📊 Summary:\n";
        echo "  - " . DealStage::where('organization_id', $org->id)->count() . " deal stages\n";
        echo "  - " . Contact::where('organization_id', $org->id)->count() . " contacts\n";
        echo "  - " . Lead::where('organization_id', $org->id)->count() . " leads\n";
        echo "  - " . Deal::where('organization_id', $org->id)->count() . " deals\n";
        echo "  - " . Invoice::where('organization_id', $org->id)->count() . " invoices\n";
        echo "  - " . Expense::where('organization_id', $org->id)->count() . " expenses\n";
        echo "\n🎉 Your dashboards should now look impressive with real data!\n";
    }
}
