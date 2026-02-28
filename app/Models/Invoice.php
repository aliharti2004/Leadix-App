<?php

namespace App\Models;

use App\Traits\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, BelongsToOrganization, \App\Traits\RecordsActivity;

    protected $guarded = ['id'];

    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
    ];

    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeFilterByStatus($query, $status)
    {
        if ($status) {
            $query->where('status', $status);
        }
    }

    public function scopeFilterByOverdue($query)
    {
        $query->where('status', 'overdue') // Or pending & due_date < now() depending on definition
            ->orWhere(function ($q) {
                $q->where('status', 'pending')
                    ->where('due_date', '<', now());
            });
    }

    public function scopeFilterByAmount($query, $min, $max)
    {
        if ($min) {
            $query->where('total', '>=', $min);
        }
        if ($max) {
            $query->where('total', '<=', $max);
        }
    }

    public function scopeFilterByDate($query, $startDate, $endDate)
    {
        if ($startDate) {
            $query->whereDate('issue_date', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('issue_date', '<=', $endDate);
        }
    }

    public function scopeSearch($query, $term)
    {
        $query->where(function ($q) use ($term) {
            $q->where('invoice_number', 'like', "%{$term}%")
                ->orWhereHas('deal.lead', function ($q) use ($term) {
                    $q->where('company', 'like', "%{$term}%")
                        ->orWhere('contact_name', 'like', "%{$term}%");
                });
        });
    }
}
