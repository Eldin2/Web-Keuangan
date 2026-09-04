<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Paksa semua URL (Form, CSS, JS) menggunakan HTTPS jika di environment production/Render
        if (config('app.env') === 'production' || request()->header('x-forwarded-proto') === 'https') {
            URL::forceScheme('https');
        }
    }
}
