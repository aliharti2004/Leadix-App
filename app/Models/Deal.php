<?php

namespace App\Models;

use App\Traits\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deal extends Model
{
    use HasFactory, SoftDeletes, BelongsToOrganization, \App\Traits\RecordsActivity;

    protected $guarded = ['id'];

    protected $casts = [
        'expected_close_date' => 'date',
        'won_at' => 'datetime',
        'lost_at' => 'datetime',
    ];

    protected $appends = ['name'];

    /**
     * Get the deal name (alias for title)
     */
    public function getNameAttribute()
    {
        return $this->title;
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function stage()
    {
        return $this->belongsTo(DealStage::class, 'deal_stage_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Check if deal already has an invoice
     * 
     * @return bool
     */
    public function hasInvoice(): bool
    {
        return $this->invoices()->exists();
    }

    /**
     * Check if deal is in Won stage
     * 
     * @return bool
     */
    public function isWon(): bool
    {
        return $this->stage && $this->stage->name === 'Won';
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeFilterByStage($query, $stageId)
    {
        if ($stageId) {
            $query->where('deal_stage_id', $stageId);
        }
    }

    public function scopeFilterByOwner($query, $userId)
    {
        if ($userId) {
            $query->where('user_id', $userId);
        }
    }

    public function scopeFilterByValue($query, $min, $max)
    {
        if ($min) {
            $query->where('value', '>=', $min);
        }
        if ($max) {
            $query->where('value', '<=', $max);
        }
    }

    public function scopeFilterByDate($query, $startDate, $endDate)
    {
        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }
    }

    public function scopeSearch($query, $term)
    {
        $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
                ->orWhereHas('lead', function ($q) use ($term) {
                    $q->where('company', 'like', "%{$term}%")
                        ->orWhere('contact_name', 'like', "%{$term}%");
                });
        });
    }
}
