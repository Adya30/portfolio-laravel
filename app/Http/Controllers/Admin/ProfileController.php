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
            'tagline' => ['nullable', 'string'],
            'about_1' => ['nullable', 'string'],
            'about_2' => ['nullable', 'string'],
            'email' => ['nullable', 'email', 'max:255'],
            'cv_url' => ['nullable', 'url'],
            'hero_image' => ['nullable', 'image:allow_svg', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:4096'],
            'hero_image_url' => ['nullable', 'url'],
            'github' => ['nullable', 'url'],
            'instagram' => ['nullable', 'url'],
            'youtube' => ['nullable', 'url'],
            'linkedin' => ['nullable', 'url'],
        ], $this->validationMessages(), [
            'name' => 'Nama lengkap',
            'role_title' => 'Role / posisi',
            'tagline' => 'Tagline',
            'about_1' => 'Paragraf 1 (tentang saya)',
            'about_2' => 'Paragraf 2 (tentang saya)',
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
            'tagline' => $data['tagline'] ?? null,
            'about_1' => $data['about_1'] ?? null,
            'about_2' => $data['about_2'] ?? null,
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
