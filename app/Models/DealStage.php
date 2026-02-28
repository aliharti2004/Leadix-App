<?php

namespace App\Models;

use App\Traits\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealStage extends Model
{
    use HasFactory, BelongsToOrganization;

    protected $guarded = ['id'];

    protected $fillable = [
        'organization_id',
        'name',
        'position',
        'probability',
    ];

    /**
     * Get all deals in this stage
     */
    public function deals()
    {
        return $this->hasMany(Deal::class);
    }

    /**
     * Scope to order stages by position
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('position');
    }
}
