<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Deal;
use App\Models\Invoice;
use App\Models\DealStage;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $organizationId = auth()->user()->organization_id;

        // 1. Total Revenue (Paid Invoices)
        $totalRevenue = Invoice::where('organization_id', $organizationId)
            ->where('status', 'paid')
            ->sum('total');

        // 2. Open Pipeline Value
        $pipelineValue = Deal::where('organization_id', $organizationId)
            ->whereDoesntHave('stage', function ($q) {
                $q->whereIn('name', ['Won', 'Lost']);
            })
            ->sum('value');

        // 3. Win Rate
        $wonDeals = Deal::where('organization_id', $organizationId)
            ->whereHas('stage', function ($q) {
                $q->where('name', 'Won');
            })->count();

        $lostDeals = Deal::where('organization_id', $organizationId)
            ->whereHas('stage', function ($q) {
                $q->where('name', 'Lost');
            })->count();

        $closedDeals = $wonDeals + $lostDeals;
        $winRate = $closedDeals > 0 ? round(($wonDeals / $closedDeals) * 100, 1) : 0;

        // 4. Active Deals Count
        $activeDeals = Deal::where('organization_id', $organizationId)
            ->whereDoesntHave('stage', function ($q) {
                $q->whereIn('name', ['Won', 'Lost']);
            })
            ->count();

        // 5. Deals by Stage (for Chart)
        $dealsByStage = Deal::where('organization_id', $organizationId)
            ->with('stage')
            ->get()
            ->groupBy('deal_stage_id')
            ->map(function ($group) {
                $first = $group->first();
                return [
                    'stage' => $first->stage->name ?? 'Unknown',
                    'count' => $group->count(),
                    'value' => $group->sum('value')
                ];
            })
            ->values();

        // 6. Revenue Trend (Last 6 Months)
        $revenueTrend = collect();
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $revenueTrend->push([
                'month' => $month->format('M Y'),
                'total' => Invoice::where('organization_id', $organizationId)
                    ->where('status', 'paid')
                    ->whereYear('issue_date', $month->year)
                    ->whereMonth('issue_date', $month->month)
                    ->sum('total')
            ]);
        }

        // 7. Invoices by Status (for Doughnut Chart)
        $invoicesByStatus = collect(['draft', 'sent', 'paid', 'overdue'])->map(function ($status) use ($organizationId) {
            $invoices = Invoice::where('organization_id', $organizationId)
                ->where('status', $status)
                ->get();

            return [
                'status' => $status,
                'count' => $invoices->count(),
                'total' => $invoices->sum('total')
            ];
        })->filter(fn($item) => $item['count'] > 0)->values();

        // 8. Monthly Performance (Won Deals per Month)
        $monthlyPerformance = collect();
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthlyPerformance->push([
                'month' => $month->format('M Y'),
                'count' => Deal::where('organization_id', $organizationId)
                    ->whereHas('stage', function ($q) {
                        $q->where('name', 'Won');
                    })
                    ->whereYear('won_at', $month->year)
                    ->whereMonth('won_at', $month->month)
                    ->count()
            ]);
        }

        return view('reports.index', compact(
            'totalRevenue',
            'pipelineValue',
            'winRate',
            'activeDeals',
            'dealsByStage',
            'revenueTrend',
            'invoicesByStatus',
            'monthlyPerformance'
        ));
    }
}
