<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;

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
        // Force HTTPS when in production
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
        
        // Set session secure cookies if using HTTPS
        if (request()->isSecure()) {
            Session::getDefaultDriver();
            config(['session.secure' => true]);
        }
        
        // Set default string length for database migrations
        Schema::defaultStringLength(191);
    }
}
