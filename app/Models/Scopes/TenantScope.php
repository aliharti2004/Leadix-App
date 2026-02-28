<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class TenantScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (Auth::check()) {
            if (session()->has('organization_id')) {
                // For admin switching logic if implemented
                $builder->where($model->getTable() . '.organization_id', session('organization_id'));
            } else {
                $builder->where($model->getTable() . '.organization_id', Auth::user()->organization_id);
            }
        }
    }
}
