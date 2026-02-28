<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deal;
use App\Models\Lead;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return $this->adminDashboard();
        } elseif ($user->hasRole('sales')) {
            return $this->salesDashboard($user);
        } elseif ($user->hasRole('finance')) {
            return $this->financeDashboard();
        }

        return view('dashboard.viewer');
    }


    private function adminDashboard()
    {
        // Admin: Executive Pulse
        // Total Pipeline Value (Sum of all deals)
        $totalPipeline = Deal::sum('value');

        // MRR (Proxy: Sum of value of Won deals)
        $monthlyRecurringRevenue = Deal::whereHas('stage', function ($q) {
            $q->where('name', 'Won');
        })->sum('value');

        // Active Customers (Proxy: Count of Won deals/orgs)
        $activeCustomers = Deal::whereHas('stage', function ($q) {
            $q->where('name', 'Won');
        })->count();

        // Overdue Receivables (Sum of unpaid invoices)
        $overdueReceivables = Invoice::where('status', 'overdue')->sum('total');

        // Overdue Invoices
        $overdueInvoices = Invoice::where('status', 'overdue')->count();

        // Won Deals
        $wonDeals = $activeCustomers;

        // Latest Activities
        $activities = \App\Models\Activity::with('user', 'subject')->latest()->take(10)->get();

        // Pipeline Chart Data (deals by stage - only active deals)
        $pipelineChartData = \App\Models\DealStage::orderBy('position')->get()->map(function ($stage) {
            $activeDeals = $stage->deals()->whereNull('won_at')->whereNull('lost_at')->get();
            return [
                'stage' => $stage->name,
                'value' => $activeDeals->sum('value'),
                'count' => $activeDeals->count(),
            ];
        })->filter(fn($item) => $item['count'] > 0); // Only show stages with deals

        // Revenue Trend (last 6 months from won deals)
        $revenueChartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $revenueChartData[] = [
                'month' => $month->format('M'),
                'revenue' => Deal::whereHas('stage', function ($q) {
                    $q->where('name', 'Won');
                })
                    ->whereYear('won_at', $month->year)
                    ->whereMonth('won_at', $month->month)
                    ->sum('value'),
            ];
        }

        return view('dashboard.admin', compact(
            'totalPipeline',
            'monthlyRecurringRevenue',
            'activeCustomers',
            'overdueReceivables',
            'wonDeals',
            'overdueInvoices',
            'activities',
            'pipelineChartData',
            'revenueChartData'
        ));
    }

    private function salesDashboard($user)
    {
        // Sales: Pipeline Tracker
        // My Active Leads
        $myActiveLeads = Lead::where('user_id', $user->id)
            ->where('status', '!=', 'converted')
            ->where('status', '!=', 'lost')
            ->count();

        // Deals in Negotiation
        $dealsInNegotiation = Deal::where('user_id', $user->id)
            ->whereHas('stage', function ($q) {
                $q->where('name', 'Negotiation');
            })->count();

        // Weighted Forecast
        $weightedForecast = Deal::join('deal_stages', 'deals.deal_stage_id', '=', 'deal_stages.id')
            ->where('deals.user_id', $user->id)
            ->sum(DB::raw('deals.value * deal_stages.probability / 100'));

        // Win Rate %
        $wonCount = Deal::where('user_id', $user->id)->whereHas('stage', function ($q) {
            $q->where('name', 'Won');
        })->count();
        $lostCount = Deal::where('user_id', $user->id)->whereHas('stage', function ($q) {
            $q->where('name', 'Lost');
        })->count();
        $totalClosed = $wonCount + $lostCount;
        $winRate = $totalClosed > 0 ? round(($wonCount / $totalClosed) * 100) . '%' : '0%';

        // Existing lists
        $myDeals = Deal::where('user_id', $user->id)->get();
        $myLeads = Lead::where('user_id', $user->id)->where('status', '!=', 'converted')->get();
        $forecast = $weightedForecast; // Alias for backward compatibility if needed

        // Latest Activities (Global or User specific? Let's show Global for better visibility for now, or team based)
        // For sales dashboard, seeing team activity is often good.
        $activities = \App\Models\Activity::with('user', 'subject')->latest()->take(10)->get();

        // Sales Funnel Data
        $salesFunnelData = [
            'leads' => Lead::where('user_id', $user->id)->where('status', '!=', 'converted')->count(),
            'qualified' => Lead::where('user_id', $user->id)->where('status', 'qualified')->count(),
            'proposals' => Deal::where('user_id', $user->id)->whereHas('stage', function ($q) {
                $q->where('name', 'LIKE', '%Proposal%');
            })->count(),
            'negotiations' => Deal::where('user_id', $user->id)->whereHas('stage', function ($q) {
                $q->where('name', 'LIKE', '%Negotiation%');
            })->count(),
            'won' => Deal::where('user_id', $user->id)->whereHas('stage', function ($q) {
                $q->where('name', 'Won');
            })->count(),
        ];

        // Format Recent Activity for Timeline
        $recentActivity = $activities->map(function ($activity) {
            return [
                'title' => $activity->subject_type ? class_basename($activity->subject_type) . ' Activity' : 'Activity',
                'description' => $activity->description ?? 'No description',
                'time' => $activity->created_at->diffForHumans(),
                'user' => $activity->user->name ?? 'Unknown',
            ];
        })->toArray();

        return view('dashboard.sales', compact(
            'myActiveLeads',
            'dealsInNegotiation',
            'weightedForecast',
            'winRate',
            'myDeals',
            'myLeads',
            'forecast',
            'salesFunnelData',
            'recentActivity'
        ));
    }

    private function financeDashboard()
    {
        // Finance: Cashflow Monitor
        // Total Cash Collected (This month - via Paid Invoices)
        $totalCashCollected = Invoice::where('status', 'paid')
            ->whereMonth('updated_at', now()->month)
            ->whereYear('updated_at', now()->year)
            ->sum('total');

        // Pending Invoices (Sent or Overdue)
        $pendingInvoicesQuery = Invoice::whereIn('status', ['sent', 'overdue']);
        $pendingInvoicesCount = $pendingInvoicesQuery->count();
        $pendingInvoicesValue = $pendingInvoicesQuery->sum('total');

        // Average Days to Pay (Paid invoices)
        // Using updated_at - issue_date as proxy for payment duration
        // Database-agnostic approach: calculate in PHP instead of SQL
        $paidInvoices = Invoice::where('status', 'paid')
            ->whereNotNull('issue_date')
            ->whereNotNull('updated_at')
            ->select('issue_date', 'updated_at')
            ->get();

        if ($paidInvoices->count() > 0) {
            $totalDays = $paidInvoices->sum(function ($invoice) {
                $issueDate = \Carbon\Carbon::parse($invoice->issue_date);
                $paidDate = \Carbon\Carbon::parse($invoice->updated_at);
                return $issueDate->diffInDays($paidDate);
            });
            $averageDaysToPay = round($totalDays / $paidInvoices->count());
        } else {
            $averageDaysToPay = 0;
        }

        // Total Tax Liability
        $totalTaxLiability = Invoice::where('status', 'paid')->sum('tax');

        // Existing vars
        $outstanding = Invoice::whereIn('status', ['sent', 'overdue'])->sum('total');
        $collected = Invoice::where('status', 'paid')->sum('total');

        return view('dashboard.finance', compact(
            'totalCashCollected',
            'pendingInvoicesCount',
            'pendingInvoicesValue',
            'averageDaysToPay',
            'totalTaxLiability',
            'outstanding',
            'collected'
        ));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        if (!$query) {
            return redirect()->back();
        }

        $leads = Lead::search($query)->limit(5)->get();
        $deals = Deal::with('stage', 'lead')->search($query)->limit(5)->get();
        $invoices = Invoice::with('deal.lead')->search($query)->limit(5)->get();

        return view('search.results', compact('leads', 'deals', 'invoices', 'query'));
    }
}

