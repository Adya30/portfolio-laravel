@extends('admin.layouts.app')

@section('title', 'Profil')
@section('page_title', 'Profil')

@section('content')
    <x-admin.page-title title="Profil" subtitle="Atur informasi yang tampil di landing page" />

    <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid lg:grid-cols-3 gap-6 items-start">

            <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h3 class="font-poppins font-bold text-slate-800 mb-5 flex items-center gap-2">
                    <i class="ri-user-settings-line text-accent"></i>Informasi Profil
                </h3>

                <div class="grid sm:grid-cols-2 gap-5">
                    <div class="sm:col-span-2">
                        <x-admin.field name="name" label="Nama Lengkap" :value="$profile->name" required />
                    </div>

                    <div>
                        <x-admin.field name="role_title" label="Role / Posisi" :value="$profile->role_title"
                                       placeholder="Contoh: Web Developer | UI Design"
                                       help="Pisahkan dengan tanda | untuk menampilkan beberapa label." />
                    </div>

                    <div>
                        <x-admin.field name="email" label="Email" type="email" :value="$profile->email" />
                    </div>

                    <div class="sm:col-span-2">
                        <x-admin.field name="tagline" label="Tagline" type="textarea" rows="2" :value="$profile->tagline"
                                       help="Kalimat singkat di hero section." />
                    </div>

                    <div class="sm:col-span-2">
                        <x-admin.field name="about_1" label="Paragraf 1 (Tentang Saya)" type="textarea" rows="3" :value="$profile->about_1" />
                    </div>

                    <div class="sm:col-span-2">
                        <x-admin.field name="about_2" label="Paragraf 2 (Tentang Saya)" type="textarea" rows="3" :value="$profile->about_2" />
                    </div>

                    <div class="sm:col-span-2">
                        <x-admin.field name="cv_url" label="Link Download CV" type="url" :value="$profile->cv_url"
                                       placeholder="https://drive.google.com/..." />
                    </div>

                    <div class="sm:col-span-2">
                        <x-admin.image-input name="hero_image" label="Foto Profil (Hero)" :current="$profile->hero_image" />
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <h3 class="font-poppins font-bold text-slate-800 mb-5 flex items-center gap-2">
                        <i class="ri-share-line text-accent"></i>Media Sosial
                    </h3>
                    <div class="space-y-4">
                        <x-admin.field name="github" label="GitHub" type="url" :value="$profile->github" placeholder="https://github.com/..." />
                        <x-admin.field name="instagram" label="Instagram" type="url" :value="$profile->instagram" placeholder="https://instagram.com/..." />
                        <x-admin.field name="youtube" label="YouTube" type="url" :value="$profile->youtube" placeholder="https://youtube.com/..." />
                        <x-admin.field name="linkedin" label="LinkedIn" type="url" :value="$profile->linkedin" placeholder="https://linkedin.com/in/..." />
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <h3 class="font-poppins font-bold text-slate-800 mb-5 flex items-center gap-2">
                        <i class="ri-lock-line text-accent"></i>Ubah Password
                    </h3>
                    <p class="text-xs text-slate-400 mb-4">Kosongkan jika tidak ingin mengubah password.</p>
                    <div class="space-y-4">
                        <x-admin.field name="current_password" label="Password Saat Ini" type="password" />
                        <x-admin.field name="new_password" label="Password Baru" type="password" help="Minimal 8 karakter." />
                        <x-admin.field name="new_password_confirmation" label="Konfirmasi Password Baru" type="password" />
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center gap-3">
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-accent text-white text-sm font-semibold hover:bg-blue-600 transition-colors">
                <i class="ri-save-line"></i>Simpan Profil
            </button>
        </div>
    </form>
@endsection
