<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles; // Assuming package installation
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    // Uncomment after installing spatie/laravel-permission
    // use HasRoles; 

    protected $fillable = [
        'name',
        'email',
        'password',
        'organization_id',
        'role', // Fallback role
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    // Simple RBAC Helper if Spatie not installed
    public function hasRole($role)
    {
        // if (method_exists($this, 'roles')) { ... }
        return $this->role === $role;
    }

    public function isManager()
    {
        return in_array($this->role, ['admin', 'manager']);
    }
}
