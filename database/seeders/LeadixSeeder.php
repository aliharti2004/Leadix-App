<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Organization;
use App\Models\User;
use App\Models\DealStage;
use App\Models\Lead;
use App\Models\Deal;
use App\Models\Invoice;

class LeadixSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Organization
        $org = Organization::create([
            'name' => 'Demo Corp',
            'domain' => 'demo.leadix.com',
        ]);

        // 2. Create Users
        $admin = User::create([
            'name' => 'Admin Owner',
            'email' => 'admin@demo.com',
            'password' => bcrypt('password'),
            'organization_id' => $org->id,
            'role' => 'admin',
        ]);

        $sales1 = User::create([
            'name' => 'Sarah Johnson',
            'email' => 'sarah@demo.com',
            'password' => bcrypt('password'),
            'organization_id' => $org->id,
            'role' => 'sales',
        ]);

        $sales2 = User::create([
            'name' => 'Michael Chen',
            'email' => 'michael@demo.com',
            'password' => bcrypt('password'),
            'organization_id' => $org->id,
            'role' => 'sales',
        ]);

        $finance = User::create([
            'name' => 'Finance Manager',
            'email' => 'finance@demo.com',
            'password' => bcrypt('password'),
            'organization_id' => $org->id,
            'role' => 'finance',
        ]);

        // 3. Create Deal Stages
        $stages = [
            ['name' => 'Prospecting', 'probability' => 10],
            ['name' => 'Qualified', 'probability' => 30],
            ['name' => 'Proposal', 'probability' => 50],
            ['name' => 'Negotiation', 'probability' => 80],
            ['name' => 'Won', 'probability' => 100],
            ['name' => 'Lost', 'probability' => 0],
        ];

        $createdStages = [];
        foreach ($stages as $index => $s) {
            $createdStages[$s['name']] = DealStage::create([
                'organization_id' => $org->id,
                'name' => $s['name'],
                'probability' => $s['probability'],
                'position' => $index + 1,
            ]);
        }

        // 4. Create Realistic Leads & Deals
        $companies = [
            ['name' => 'TechVision Inc', 'contact' => 'Emily Rodriguez', 'email' => 'emily@techvision.com'],
            ['name' => 'Global Solutions Ltd', 'contact' => 'David Park', 'email' => 'david@globalsolutions.com'],
            ['name' => 'Innovate Corp', 'contact' => 'Rachel Kim', 'email' => 'rachel@innovate.co'],
            ['name' => 'CloudScale Systems', 'contact' => 'James Wilson', 'email' => 'james@cloudscale.io'],
            ['name' => 'DataFlow Analytics', 'contact' => 'Maria Garcia', 'email' => 'maria@dataflow.ai'],
            ['name' => 'Automation Hub', 'contact' => 'Robert Taylor', 'email' => 'robert@automationhub.com'],
            ['name' => 'Enterprise Dynamics', 'contact' => 'Lisa Anderson', 'email' => 'lisa@entdynamics.com'],
            ['name' => 'Digital Forge Co', 'contact' => 'Thomas Brown', 'email' => 'thomas@digitalforge.net'],
            ['name' => 'Smart Systems Inc', 'contact' => 'Jennifer Lee', 'email' => 'jennifer@smartsystems.io'],
            ['name' => 'Nexus Technologies', 'contact' => 'Chris Martinez', 'email' => 'chris@nexustech.com'],
            ['name' => 'Prime Solutions', 'contact' => 'Amanda White', 'email' => 'amanda@primesol.co'],
            ['name' => 'Velocity Software', 'contact' => 'Daniel Harris', 'email' => 'daniel@velocitysoft.com'],
            ['name' => 'Quantum Labs', 'contact' => 'Sarah Thompson', 'email' => 'sarah@quantumlabs.io'],
            ['name' => 'Synergy Partners', 'contact' => 'Kevin Clark', 'email' => 'kevin@synergypartners.com'],
            ['name' => 'Apex Innovations', 'contact' => 'Michelle Davis', 'email' => 'michelle@apexinnovate.co'],
            ['name' => 'Future Tech Group', 'contact' => 'Brian Miller', 'email' => 'brian@futuretech.com'],
            ['name' => 'Integrated Systems', 'contact' => 'Jessica Moore', 'email' => 'jessica@intsystems.net'],
            ['name' => 'Peak Performance', 'contact' => 'Andrew Johnson', 'email' => 'andrew@peakperf.io'],
        ];

        $dealTemplates = [
            ['title' => 'Enterprise CRM Implementation', 'min' => 45000, 'max' => 85000],
            ['title' => 'Cloud Migration Project', 'min' => 30000, 'max' => 65000],
            ['title' => 'Annual SaaS Subscription', 'min' => 8500, 'max' => 25000],
            ['title' => 'Custom Integration Services', 'min' => 15000, 'max' => 40000],
            ['title' => 'Consulting Retainer Q1', 'min' => 12000, 'max' => 28000],
            ['title' => 'Platform Upgrade', 'min' => 20000, 'max' => 50000],
            ['title' => 'Training & Support Package', 'min' => 5000, 'max' => 15000],
            ['title' => 'Security Audit & Implementation', 'min' => 25000, 'max' => 60000],
            ['title' => 'Data Analytics Solution', 'min' => 35000, 'max' => 75000],
            ['title' => 'Mobile App Development', 'min' => 40000, 'max' => 90000],
        ];

        $stageDistribution = [
            'Prospecting' => 5,
            'Qualified' => 4,
            'Proposal' => 3,
            'Negotiation' => 3,
            'Won' => 2,
            'Lost' => 1,
        ];

        $dealCount = 0;
        $leads = [];

        foreach ($stageDistribution as $stageName => $count) {
            for ($i = 0; $i < $count; $i++) {
                if ($dealCount >= count($companies))
                    break;

                $company = $companies[$dealCount];
                $dealTemplate = $dealTemplates[array_rand($dealTemplates)];
                $owner = rand(0, 1) ? $sales1 : $sales2;

                // Create Lead
                $lead = Lead::create([
                    'organization_id' => $org->id,
                    'user_id' => $owner->id,
                    'title' => $company['name'],
                    'contact_name' => $company['contact'],
                    'email' => $company['email'],
                    'phone' => '+1 ' . rand(200, 999) . '-' . rand(100, 999) . '-' . rand(1000, 9999),
                    'status' => 'converted',
                ]);

                $leads[] = $lead;

                // Create Deal
                $value = rand($dealTemplate['min'], $dealTemplate['max']);
                $daysOffset = match ($stageName) {
                    'Prospecting' => rand(30, 60),
                    'Qualified' => rand(20, 40),
                    'Proposal' => rand(10, 25),
                    'Negotiation' => rand(5, 15),
                    'Won' => rand(-30, -5),
                    'Lost' => rand(-45, -10),
                };

                $deal = Deal::create([
                    'organization_id' => $org->id,
                    'user_id' => $owner->id,
                    'lead_id' => $lead->id,
                    'deal_stage_id' => $createdStages[$stageName]->id,
                    'title' => $dealTemplate['title'],
                    'value' => $value,
                    'expected_close_date' => now()->addDays($daysOffset),
                ]);

                // Create Invoices for Won deals
                if ($stageName === 'Won') {
                    $invoiceNumber = 'INV-' . str_pad(($dealCount + 1) * 1000 + rand(1, 99), 6, '0', STR_PAD_LEFT);
                    $issueDate = now()->subDays(rand(5, 30));

                    Invoice::create([
                        'organization_id' => $org->id,
                        'deal_id' => $deal->id,
                        'invoice_number' => $invoiceNumber,
                        'total' => $value,
                        'status' => 'paid',
                        'issue_date' => $issueDate,
                        'due_date' => $issueDate->copy()->addDays(30),
                    ]);
                }

                $dealCount++;
            }
        }

        // Create additional standalone invoices (pending & overdue)
        $pendingInvoices = [
            ['company_idx' => 0, 'amount' => 12500, 'status' => 'pending', 'days_ago' => 5],
            ['company_idx' => 1, 'amount' => 8500, 'status' => 'pending', 'days_ago' => 10],
            ['company_idx' => 2, 'amount' => 15000, 'status' => 'overdue', 'days_ago' => 45],
            ['company_idx' => 3, 'amount' => 22000, 'status' => 'pending', 'days_ago' => 3],
            ['company_idx' => 4, 'amount' => 18500, 'status' => 'overdue', 'days_ago' => 60],
            ['company_idx' => 5, 'amount' => 9800, 'status' => 'pending', 'days_ago' => 7],
        ];

        foreach ($pendingInvoices as $inv) {
            if (!isset($leads[$inv['company_idx']]))
                continue;

            $invoiceNumber = 'INV-' . str_pad((count($pendingInvoices) + $inv['company_idx']) * 1000 + rand(1, 99), 6, '0', STR_PAD_LEFT);
            $issueDate = now()->subDays($inv['days_ago']);
            $dueDate = $issueDate->copy()->addDays(30);

            // Create a deal for this invoice if lead doesn't have one
            $existingDeal = Deal::where('lead_id', $leads[$inv['company_idx']]->id)->first();

            if (!$existingDeal) {
                $existingDeal = Deal::create([
                    'organization_id' => $org->id,
                    'user_id' => $sales1->id,
                    'lead_id' => $leads[$inv['company_idx']]->id,
                    'deal_stage_id' => $createdStages['Won']->id,
                    'name' => 'Service Contract',
                    'value' => $inv['amount'],
                    'expected_close_date' => $issueDate,
                ]);
            }

            Invoice::create([
                'organization_id' => $org->id,
                'deal_id' => $existingDeal->id,
                'invoice_number' => $invoiceNumber,
                'total' => $inv['amount'],
                'status' => $inv['status'],
                'issue_date' => $issueDate,
                'due_date' => $dueDate,
            ]);
        }
    }
}
