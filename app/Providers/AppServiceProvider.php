<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
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
        // Batas keras per IP untuk endpoint login — berjalan sebelum controller
        // masuk, jadi serangan DDoS / brute-force skala besar di halaman login
        // langsung diputus (HTTP 429) jauh sebelum membanjiri proses login.
        // Batas lunak per akun + IP (5 percobaan, backoff eksponensial) tetap
        // ditangani di LoginController.
        RateLimiter::for('login', fn (Request $request) => Limit::perMinute(20)->by('login-ip:'.$request->ip()));
    }
}
