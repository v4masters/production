<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ShiprocketService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
   public function register()
    {
        $this->app->singleton(ShiprocketService::class, function ($app) {
            return new ShiprocketService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
