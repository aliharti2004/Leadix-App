<?php

namespace App\Models;

use App\Traits\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use HasFactory, SoftDeletes, BelongsToOrganization, \App\Traits\RecordsActivity;

    protected $guarded = ['id'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function deal()
    {
        return $this->hasOne(Deal::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeSearch($query, $term)
    {
        $query->where('company', 'like', "%{$term}%")
            ->orWhere('contact_name', 'like', "%{$term}%")
            ->orWhere('email', 'like', "%{$term}%");
    }
}
