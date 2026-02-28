<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilterService
{
    /**
     * Apply standard filters to Deal query
     *
     * @param Builder $query
     * @param Request $request
     * @return Builder
     */
    public function applyDealFilters(Builder $query, Request $request): Builder
    {
        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by Stage (using deal_stage_id param)
        if ($request->filled('deal_stage_id')) {
            $query->filterByStage($request->deal_stage_id);
        }

        // Legacy stage_id support
        if ($request->filled('stage_id')) {
            $query->filterByStage($request->stage_id);
        }

        // Filter by Owner
        if ($request->filled('user_id')) {
            $query->filterByOwner($request->user_id);
        }

        // Filter by Priority (based on value ranges)
        if ($request->filled('priority')) {
            switch ($request->priority) {
                case 'high':
                    $query->where('value', '>=', 50000);
                    break;
                case 'medium':
                    $query->whereBetween('value', [20000, 49999.99]);
                    break;
                case 'low':
                    $query->where('value', '<', 20000);
                    break;
            }
        }

        // Filter by Value
        if ($request->filled('min_value') || $request->filled('max_value')) {
            $query->filterByValue($request->min_value, $request->max_value);
        }

        // Quick Date Filters
        if ($request->filled('quick_date')) {
            $now = now();
            switch ($request->quick_date) {
                case 'today':
                    $query->whereDate('expected_close_date', $now->toDateString());
                    break;
                case 'week':
                    $query->whereBetween('expected_close_date', [
                        $now->startOfWeek()->toDateString(),
                        $now->copy()->endOfWeek()->toDateString()
                    ]);
                    break;
                case 'month':
                    $query->whereBetween('expected_close_date', [
                        $now->startOfMonth()->toDateString(),
                        $now->copy()->endOfMonth()->toDateString()
                    ]);
                    break;
                case 'overdue':
                    $query->where('expected_close_date', '<', $now->toDateString())
                        ->whereNotIn('deal_stage_id', function ($q) {
                            $q->select('id')
                                ->from('deal_stages')
                                ->whereIn('name', ['Won', 'Lost']);
                        });
                    break;
            }
        }

        // Filter by Date (custom range)
        if ($request->filled('date_from') || $request->filled('date_to')) {
            $query->filterByDate($request->date_from, $request->date_to);
        }

        return $query;
    }

    /**
     * Apply standard filters to Invoice query
     *
     * @param Builder $query
     * @param Request $request
     * @return Builder
     */
    public function applyInvoiceFilters(Builder $query, Request $request): Builder
    {
        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->filterByStatus($request->status);
        }

        // Filter by Company/Lead
        if ($request->filled('company')) {
            $query->whereHas('deal.lead', function ($q) use ($request) {
                $q->where('id', $request->company);
            });
        }

        // Filter by Priority (amount-based)
        if ($request->filled('priority')) {
            switch ($request->priority) {
                case 'high':
                    $query->where('total', '>=', 10000);
                    break;
                case 'medium':
                    $query->whereBetween('total', [5000, 9999.99]);
                    break;
                case 'low':
                    $query->where('total', '<', 5000);
                    break;
            }
        }

        // Quick Date Filters (for due date)
        if ($request->filled('quick_date')) {
            $now = now();
            switch ($request->quick_date) {
                case 'due_today':
                    $query->whereDate('due_date', $now->toDateString());
                    break;
                case 'due_week':
                    $query->whereBetween('due_date', [
                        $now->startOfWeek()->toDateString(),
                        $now->copy()->endOfWeek()->toDateString()
                    ]);
                    break;
                case 'overdue':
                    $query->where('due_date', '<', $now->toDateString())
                        ->where('status', '!=', 'paid');
                    break;
            }
        }

        // Filter by Overdue (legacy support)
        if ($request->filled('overdue') && $request->boolean('overdue')) {
            $query->filterByOverdue();
        }

        // Filter by Amount
        if ($request->filled('min_amount') || $request->filled('max_amount')) {
            $query->filterByAmount($request->min_amount, $request->max_amount);
        }

        // Filter by Date (issue date for invoices)
        if ($request->filled('date_from') || $request->filled('date_to')) {
            $query->filterByDate($request->date_from, $request->date_to);
        }

        // Sort by Newest/Oldest
        if ($request->filled('sort_by')) {
            if ($request->sort_by === 'oldest') {
                $query->oldest();
            } else {
                $query->latest(); // Default: newest first
            }
        } else {
            $query->latest(); // Default sorting
        }

        return $query;
    }
}
