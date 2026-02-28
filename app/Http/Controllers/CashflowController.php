<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CashflowController extends Controller
{
    public function index(Request $request)
    {
        // Admin and Finance only
        if (!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('finance')) {
            abort(403, 'Cashflow is only accessible to administrators and finance users.');
        }

        $organization = auth()->user()->organization;

        // 1. Current Stats
        $totalIncome = $organization->invoices()->where('status', 'paid')->sum('total');
        $totalExpenses = $organization->expenses()->sum('amount');
        $currentBalance = $totalIncome - $totalExpenses;

        // Balance vs Last Month calculation
        $lastMonthIncome = $organization->invoices()
            ->where('status', 'paid')
            ->whereMonth('issue_date', now()->subMonth()->month)
            ->sum('total');
        $incomeGrowth = $lastMonthIncome > 0 ? (($totalIncome - $lastMonthIncome) / $lastMonthIncome) * 100 : 0;


        // 2. Chart Data
        $range = $request->input('range', '6_months'); // Default to 6 months
        $months = [];
        $incomeData = [];
        $expenseData = [];

        $periods = 6;
        if ($range === '12_months') {
            $periods = 12;
        } elseif ($range === 'this_year') {
            $periods = now()->month; // Months so far this year
        }

        // Loop backwards from current month
        for ($i = $periods - 1; $i >= 0; $i--) {
            $date = now()->subMonths($i);

            // Adjust loop if we went back into previous year for "this_year" scenario (though safe with now()->month)
            if ($range === 'this_year' && $date->year < now()->year) {
                continue;
            }

            $monthName = $date->format('M');
            $year = $date->year;
            $month = $date->month;

            $months[] = $monthName;

            $incomeData[] = $organization->invoices()
                ->where('status', 'paid')
                ->whereYear('issue_date', $year)
                ->whereMonth('issue_date', $month)
                ->sum('total');

            $expenseData[] = $organization->expenses()
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->sum('amount');
        }

        // 3. Forecast (Pending Invoices)
        $pendingInvoices = $organization->invoices()->whereIn('status', ['sent', 'overdue'])->get();

        $forecast = [
            '30' => $pendingInvoices->where('due_date', '<=', now()->addDays(30))->sum('total'),
            '60' => $pendingInvoices->where('due_date', '>', now()->addDays(30))->where('due_date', '<=', now()->addDays(60))->sum('total'),
            '90' => $pendingInvoices->where('due_date', '>', now()->addDays(60))->sum('total'),
        ];

        // 4. Receivables
        $pendingAmount = $organization->invoices()->where('status', 'sent')->sum('total');
        $pendingCount = $organization->invoices()->where('status', 'sent')->count();

        $overdueAmount = $organization->invoices()->where('status', 'overdue')->sum('total');
        $overdueCount = $organization->invoices()->where('status', 'overdue')->count();

        return view('cashflow.index', [
            'stats' => [
                'income' => $totalIncome,
                'expenses' => $totalExpenses,
                'balance' => $currentBalance,
                'growth' => $incomeGrowth,
            ],
            'chart' => [
                'labels' => $months,
                'income' => $incomeData,
                'expenses' => $expenseData,
            ],
            'forecast' => $forecast,
            'receivables' => [
                'pending_amount' => $pendingAmount,
                'pending_count' => $pendingCount,
                'overdue_amount' => $overdueAmount,
                'overdue_count' => $overdueCount,
                'total_outstanding' => $pendingAmount + $overdueAmount,
            ]
        ]);
    }
}
