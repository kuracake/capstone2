<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <--- 1. TAMBAHKAN BARIS INI

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
        // 2. TAMBAHKAN LOGIKA INI:
        // Jika alamat website mengandung 'ngrok', paksa gunakan HTTPS
        if (str_contains(request()->url(), 'ngrok-free.dev') || str_contains(request()->url(), 'ngrok.io')) {
            URL::forceScheme('https');
        }
    }
}