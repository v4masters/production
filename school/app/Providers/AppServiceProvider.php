<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

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
        //   $domain = request()->getHost();

        // // Dynamically set the database connection based on the domain
        // if ($domain == 'evyapari.com') {
        //     Config::set('database.default', 'evyapari_mysql');
        // }
    }
    
   


}
