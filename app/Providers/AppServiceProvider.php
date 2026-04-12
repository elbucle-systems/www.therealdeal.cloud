<?php

namespace App\Providers;

use Carbon\Carbon;
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
        // Developer time-travel: set TEST_NOW=2026-07-10T12:00:00 in .env to fake today's date.
        // Remove or leave blank to use real time.
        if (app()->isLocal() && ($testNow = env('TEST_NOW'))) {
            Carbon::setTestNow(Carbon::parse($testNow));
        }
    }
}
