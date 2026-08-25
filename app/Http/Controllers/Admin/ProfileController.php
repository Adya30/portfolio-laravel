<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Services\TwoFactorAuth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    private TwoFactorAuth $twoFactorAuth;

    public function __construct(TwoFactorAuth $twoFactorAuth)
    {
        $this->twoFactorAuth = $twoFactorAuth;
    }

    public function edit(): View
    {
        return view('admin.profile.edit', [
            'profile' => Profile::firstOrCreate(['id' => 1]),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $profile = Profile::firstOrCreate(['id' => 1]);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role_title' => ['nullable', 'string', 'max:255'],
            'role_title_idn' => ['nullable', 'string', 'max:255'],
            'tagline' => ['nullable', 'string'],
            'tagline_idn' => ['nullable', 'string'],
            'about_1' => ['nullable', 'string'],
            'about_1_idn' => ['nullable', 'string'],
            'about_2' => ['nullable', 'string'],
            'about_2_idn' => ['nullable', 'string'],
            'email' => ['nullable', 'email', 'max:255'],
            'cv_url' => ['nullable', 'url'],
            'hero_image' => ['nullable', 'image:allow_svg', 'mimes:svg,png,jpg,jpeg,webp', 'max:2048'],
            'hero_image_url' => ['nullable', 'url'],
            'hero_quote' => ['nullable', 'string'],
            'hero_quote_idn' => ['nullable', 'string'],
            'github' => ['nullable', 'url'],
            'instagram' => ['nullable', 'url'],
            'youtube' => ['nullable', 'url'],
            'linkedin' => ['nullable', 'url'],
        ], $this->validationMessages(), [
            'name' => 'Nama lengkap',
            'role_title' => 'Role / posisi',
            'role_title_idn' => 'Role / posisi (Indonesia)',
            'tagline' => 'Tagline',
            'tagline_idn' => 'Tagline (Indonesia)',
            'about_1' => 'Paragraf 1 (tentang saya)',
            'about_1_idn' => 'Paragraf 1 (tentang saya, Indonesia)',
            'about_2' => 'Paragraf 2 (tentang saya)',
            'about_2_idn' => 'Paragraf 2 (tentang saya, Indonesia)',
            'email' => 'Email',
            'cv_url' => 'Link download CV',
            'hero_image' => 'Foto profil',
            'hero_image_url' => 'URL foto profil',
            'hero_quote' => 'Quote (English)',
            'hero_quote_idn' => 'Quote (Indonesia)',
            'github' => 'Link GitHub',
            'instagram' => 'Link Instagram',
            'youtube' => 'Link YouTube',
            'linkedin' => 'Link LinkedIn',
        ]);

        $profile->update([
            'name' => $data['name'],
            'role_title' => $data['role_title'] ?? null,
            'role_title_idn' => $data['role_title_idn'] ?? null,
            'tagline' => $data['tagline'] ?? null,
            'tagline_idn' => $data['tagline_idn'] ?? null,
            'about_1' => $data['about_1'] ?? null,
            'about_1_idn' => $data['about_1_idn'] ?? null,
            'about_2' => $data['about_2'] ?? null,
            'about_2_idn' => $data['about_2_idn'] ?? null,
            'email' => $data['email'] ?? null,
            'cv_url' => $data['cv_url'] ?? null,
            'hero_image' => $this->resolveFieldImage($request, 'hero_image', 'profile', $profile->hero_image),
            'hero_quote' => $data['hero_quote'] ?? null,
            'hero_quote_idn' => $data['hero_quote_idn'] ?? null,
            'github' => $data['github'] ?? null,
            'instagram' => $data['instagram'] ?? null,
            'youtube' => $data['youtube'] ?? null,
            'linkedin' => $data['linkedin'] ?? null,
        ]);

        if ($request->filled('new_password')) {
            $request->validate([
                'current_password' => ['required', 'current_password'],
                'new_password' => ['required', 'confirmed', Password::min(8)],
            ], $this->validationMessages(), [
                'current_password' => 'Password saat ini',
                'new_password' => 'Password baru',
                'new_password_confirmation' => 'Konfirmasi password baru',
            ]);

            $request->user()->update([
                'password' => Hash::make($request->input('new_password')),
            ]);
        }

        return redirect()->route('admin.profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }

    private function resolveFieldImage(Request $request, string $field, string $dir, ?string $current): ?string
    {
        if ($request->hasFile($field) && $request->file($field)->isValid()) {
            return $this->uploadImage($request->file($field), $dir);
        }

        if ($request->filled($field.'_url')) {
            return $request->input($field.'_url');
        }

        return $current;
    }

    /**
     * Show the 2FA setup form with QR code.
     */
    public function showTwoFactorSetup(): View
    {
        $user = request()->user();

        if ($user->hasTwoFactorEnabled()) {
            return view('admin.profile.two-factor-enabled', [
                'profile' => Profile::firstOrCreate(['id' => 1]),
            ]);
        }

        // Generate a new secret
        $secret = $this->twoFactorAuth->generateSecretKey();
        $qrUrl = $this->twoFactorAuth->getQRCodeUrl(
            config('app.name', 'Portfolio'),
            $user->email,
            $secret
        );

        // Store secret temporarily in session for verification
        session(['2fa_setup_secret' => $secret]);

        return view('admin.profile.two-factor-setup', [
            'profile' => Profile::firstOrCreate(['id' => 1]),
            'qrUrl' => $qrUrl,
            'secret' => $secret,
        ]);
    }

    /**
     * Verify and activate 2FA.
     */
    public function enableTwoFactor(Request $request): RedirectResponse
    {
        $request->validate([
            'one_time_password' => ['required', 'string', 'size:6'],
        ], [
            'one_time_password.required' => 'Kode verifikasi wajib diisi.',
            'one_time_password.size' => 'Kode verifikasi harus 6 digit.',
        ]);

        $secret = session('2fa_setup_secret');

        if (! $secret || ! $this->twoFactorAuth->verifyKey($secret, $request->input('one_time_password'))) {
            return back()->withErrors(['one_time_password' => 'Kode verifikasi salah. Pastikan kode di aplikasi Authenticator benar.'])->withInput();
        }

        $user = $request->user();
        $user->update([
            'two_factor_secret' => $secret,
            'two_factor_enabled' => true,
        ]);

        session()->forget('2fa_setup_secret');

        return redirect()->route('admin.profile.edit')
            ->with('success', 'Autentikasi dua faktor berhasil diaktifkan!');
    }

    /**
     * Disable 2FA.
     */
    public function disableTwoFactor(Request $request): RedirectResponse
    {
        $request->validate([
            'one_time_password' => ['required', 'string', 'size:6'],
        ], [
            'one_time_password.required' => 'Kode verifikasi wajib diisi untuk menonaktifkan 2FA.',
            'one_time_password.size' => 'Kode verifikasi harus 6 digit.',
        ]);

        $user = $request->user();

        if (! $this->twoFactorAuth->verifyKey($user->two_factor_secret, $request->input('one_time_password'))) {
            return back()->withErrors(['one_time_password' => 'Kode verifikasi salah. 2FA tidak dinonaktifkan.'])->withInput();
        }

        $user->update([
            'two_factor_secret' => null,
            'two_factor_enabled' => false,
        ]);

        return redirect()->route('admin.profile.edit')
            ->with('success', 'Autentikasi dua faktor berhasil dinonaktifkan.');
    }
}
