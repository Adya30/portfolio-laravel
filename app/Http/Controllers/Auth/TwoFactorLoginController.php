<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\TwoFactorAuth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class TwoFactorLoginController extends Controller
{
    private TwoFactorAuth $twoFactorAuth;

    public function __construct(TwoFactorAuth $twoFactorAuth)
    {
        $this->twoFactorAuth = $twoFactorAuth;
    }

    /**
     * Show the 2FA verification form.
     */
    public function showForm(Request $request): View|RedirectResponse
    {
        $userId = $request->query('u');
        $signature = $request->query('s');

        if (! $userId || ! $signature || ! $this->verifySignedUrl($userId, $signature)) {
            return redirect()->route('login');
        }

        return view('auth.two-factor', [
            'userId' => $userId,
            'signature' => $signature,
        ]);
    }

    /**
     * Verify the 2FA code and complete login.
     */
    public function verify(Request $request): RedirectResponse
    {
        $userId = $request->input('user_id');
        $signature = $request->input('signature');

        if (! $userId || ! $signature || ! $this->verifySignedUrl($userId, $signature)) {
            return redirect()->route('login');
        }

        // Rate limiting: max 5 attempts per 2FA verification
        $throttleKey = '2fa|'.$userId.'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $label = $seconds >= 60 ? ceil($seconds / 60).' menit' : $seconds.' detik';

            return back()->withErrors([
                'one_time_password' => 'Terlalu banyak percobaan. Silakan coba lagi dalam '.$label.'.',
            ]);
        }

        $request->validate([
            'one_time_password' => ['required', 'string', 'size:6'],
        ], [
            'one_time_password.required' => 'Kode verifikasi wajib diisi.',
            'one_time_password.size' => 'Kode verifikasi harus 6 digit.',
        ]);

        $user = User::find($userId);

        if (! $user || ! $user->hasTwoFactorEnabled()) {
            return redirect()->route('login')->withErrors([
                'email' => 'Terjadi kesalahan. Silakan login ulang.',
            ]);
        }

        if (! $this->twoFactorAuth->verifyKey($user->two_factor_secret, $request->input('one_time_password'))) {
            RateLimiter::hit($throttleKey, 300);

            return back()->withErrors([
                'one_time_password' => 'Kode verifikasi salah. Silakan coba lagi.',
            ])->withInput();
        }

        RateLimiter::clear($throttleKey);

        // 2FA verified — complete login (without "remember me" for security)
        Auth::login($user, false);

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    /**
     * Generate a signed URL for 2FA verification.
     */
    public static function generateSignedUrl(int $userId): string
    {
        $signature = hash_hmac('sha256', (string) $userId, config('app.key'));

        return route('2fa.form', [
            'u' => $userId,
            's' => $signature,
        ]);
    }

    /**
     * Verify the signature for a given user ID.
     */
    private function verifySignedUrl(string $userId, string $signature): bool
    {
        $expected = hash_hmac('sha256', (string) $userId, config('app.key'));

        return hash_equals($expected, (string) $signature);
    }
}
