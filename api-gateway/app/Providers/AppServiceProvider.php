<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\BusinessDateCalculator\BusinessDateCalculator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('BusinessDateCalculatorInterface', function ($app) {
            return new BusinessDateCalculator();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
