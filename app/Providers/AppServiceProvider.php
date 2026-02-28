<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register Deal Observer for lifecycle automation
        \App\Models\Deal::observe(\App\Observers\DealObserver::class);

        // Register Payment Observer for payment notifications
        \App\Models\Payment::observe(\App\Observers\PaymentObserver::class);

        // Use custom pagination view
        \Illuminate\Pagination\Paginator::defaultView('components.pagination');
    }
}
