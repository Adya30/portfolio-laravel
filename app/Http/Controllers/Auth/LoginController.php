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
    /**
     * Maksimal percobaan login yang diperbolehkan sebelum dikunci sementara.
     */
    protected const MAX_ATTEMPTS = 5;

    /**
     * Durasi kunci (dalam menit) setelah percobaan login melebihi batas.
     */
    protected const DECAY_MINUTES = 1;

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

        // Kunci sementara percobaan login dari email + IP yang sama
        // setelah terlalu banyak kegagalan (anti brute-force / spam).
        $throttleKey = $this->throttleKey($request);

        if (RateLimiter::tooManyAttempts($throttleKey, self::MAX_ATTEMPTS)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()->withErrors([
                'email' => 'Terlalu banyak percobaan login. Silakan coba lagi dalam '.ceil($seconds / 60).' menit.',
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        RateLimiter::hit($throttleKey, self::DECAY_MINUTES * 60);

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

    /**
     * Kunci rate limiter yang unik per kombinasi email + IP.
     */
    private function throttleKey(Request $request): string
    {
        return 'login|'.Str::lower((string) $request->input('email')).'|'.$request->ip();
    }
}
