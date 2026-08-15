<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LoginController extends Controller
{

    protected const MAX_ATTEMPTS = 5;

    // Waktu tunggu dasar per percobaan gagal (detik).
    protected const BASE_DECAY_SECONDS = 60;

    // Batas atas waktu tunggu (30 menit).
    protected const MAX_DECAY_SECONDS = 1800;

    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], $this->validationMessages(), [
            'email' => 'Email',
            'password' => 'Password',
        ]);

        $throttleKey = $this->throttleKey($request);

        if (RateLimiter::tooManyAttempts($throttleKey, self::MAX_ATTEMPTS)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $label = $seconds >= 60 ? ceil($seconds / 60).' menit' : $seconds.' detik';

            return back()->withErrors([
                'email' => 'Terlalu banyak percobaan login. Silakan coba lagi dalam '.$label.'.',
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        // Backoff eksponensial: makin sering gagal, makin lama waktu tunggu
        // (1, 2, 4, 8, 16 menit, dst. — dibatasi maksimal 30 menit).
        $attempts = RateLimiter::attempts($throttleKey);
        $decay = min(
            self::BASE_DECAY_SECONDS * (2 ** $attempts),
            self::MAX_DECAY_SECONDS
        );
        RateLimiter::hit($throttleKey, $decay);

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function throttleKey(Request $request): string
    {
        return 'login|'.Str::lower((string) $request->input('email')).'|'.$request->ip();
    }
}
