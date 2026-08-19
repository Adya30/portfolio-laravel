<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Sumber kebenaran konfigurasi: file .env
|--------------------------------------------------------------------------
|
| Beberapa shell / IDE mengekspor isi .env proyek ini ke environment
| (misalnya DB_CONNECTION=sqlite dari versi lama). Karena loader dotenv
| Laravel bersifat immutable, ekspor tersebut diam-diam menimpa nilai
| dari file .env. Di sini variabel yang kuncinya juga didefinisikan di
| .env dibersihkan, sehingga file .env selalu menang.
|
*/

// Saat menjalankan PHPUnit, phpunit.xml sudah menetapkan override-nya
// sendiri (APP_ENV=testing, DB sqlite :memory:, cache array, dll.) ke
// environment. Jangan bersihkan environment dalam kasus ini agar
// override tersebut tetap berlaku.
$isTestRun = in_array(getenv('APP_ENV'), ['testing'], true)
    || in_array($_SERVER['APP_ENV'] ?? null, ['testing'], true);

$envFilePath = dirname(__DIR__).'/.env';

if (is_file($envFilePath)) {
    $envNames = [];

    foreach (file($envFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
        $line = trim($line);

        if ($line === '' || str_starts_with($line, '#') || ! str_contains($line, '=')) {
            continue;
        }

        [$name] = explode('=', $line, 2);
        $name = trim($name);

        if (preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/', $name)) {
            $envNames[] = $name;
        }
    }

    if ($isTestRun) {
        // During PHPUnit, phpunit.xml forces its own values via putenv() and
        // $_ENV. But the shell/IDE exports of the .env contents are still
        // visible in $_SERVER — which Laravel's env() reads first — and Git
        // Bash even mangles *PATH vars there (e.g. SESSION_PATH becomes
        // "C:/Program Files/Git/"). Drop the stale $_SERVER entries so the
        // forced phpunit.xml values win.
        foreach ($envNames as $name) {
            unset($_SERVER[$name]);
        }
    } else {
        // Shell/IDE exports would otherwise shadow the .env file (dotenv is
        // immutable), so remove them and let the .env file win.
        foreach ($envNames as $name) {
            putenv($name);
            unset($_ENV[$name], $_SERVER[$name]);
        }
    }
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Pengguna yang belum login diarahkan ke halaman login,
        // dan pengguna yang sudah login dijauhkan dari form login.
        $middleware->redirectGuestsTo(fn () => route('login'));
        $middleware->redirectUsersTo(fn () => auth()->user()?->isMateriOnly() ? route('admin.courses.index') : route('admin.dashboard'));

        // Keamanan dasar: header keamanan + batas permintaan per IP
        // per menit (120) untuk semua halaman web sebagai mitigasi
        // dasar serangan brute-force / DDoS di level aplikasi.
        $middleware->web(append: [
            \App\Http\Middleware\SecurityHeaders::class,
            'throttle:120,1',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
