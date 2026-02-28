<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'organization_id',
        'name',
        'email',
        'phone',
        'job_title',
        'linkedin_url',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
