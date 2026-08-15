<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        // Paksa koneksi HTTPS (dipatuhi browser hanya saat halaman diakses via HTTPS).
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        // Nonaktifkan filter XSS lama bawaan browser (rekomendasi OWASP — filter
        // lama justru bisa menimbulkan kerentanan baru).
        $response->headers->set('X-XSS-Protection', '0');

        return $response;
    }
}
