<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
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
    // لتنسيق pagination
    Paginator::useBootstrapFive();
    // أو لو تستخدم Bootstrap 4
    // Paginator::useBootstrapFour();
}

}
