<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
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
}
