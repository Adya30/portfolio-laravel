@extends('admin.layouts.app')

@section('title', 'Profil')
@section('page_title', 'Profil')

@section('content')
    <x-admin.page-title/>

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
                        <x-admin.field name="role_title" label="Role / Posisi (English)" :value="$profile->role_title"
                                       placeholder="Contoh: Web Developer | UI Design"
                                       help="Pisahkan dengan tanda | untuk menampilkan beberapa label." />
                    </div>

                    <div>
                        <x-admin.field name="role_title_idn" label="Role / Posisi (Indonesia)" :value="$profile->role_title_idn"
                                       placeholder="Contoh: Web Developer | Desain UI"
                                       help="Kosongkan untuk memakai versi Inggris." />
                    </div>

                    <div class="sm:col-span-2">
                        <x-admin.field name="email" label="Email" type="email" :value="$profile->email" />
                    </div>

                    <div class="sm:col-span-2">
                        <x-admin.field name="tagline" label="Tagline (English)" type="textarea" rows="2" :value="$profile->tagline"
                                       help="Kalimat singkat di hero section." />
                    </div>

                    <div class="sm:col-span-2">
                        <x-admin.field name="tagline_idn" label="Tagline (Indonesia)" type="textarea" rows="2" :value="$profile->tagline_idn"
                                       help="Kosongkan untuk memakai versi Inggris." />
                    </div>

                    <div class="sm:col-span-2">
                        <x-admin.field name="about_1" label="Paragraf 1 (Tentang Saya, English)" type="textarea" rows="3" :value="$profile->about_1" />
                    </div>

                    <div class="sm:col-span-2">
                        <x-admin.field name="about_1_idn" label="Paragraf 1 (Tentang Saya, Indonesia)" type="textarea" rows="3" :value="$profile->about_1_idn"
                                       help="Kosongkan untuk memakai versi Inggris." />
                    </div>

                    <div class="sm:col-span-2">
                        <x-admin.field name="about_2" label="Paragraf 2 (Tentang Saya, English)" type="textarea" rows="3" :value="$profile->about_2" />
                    </div>

                    <div class="sm:col-span-2">
                        <x-admin.field name="about_2_idn" label="Paragraf 2 (Tentang Saya, Indonesia)" type="textarea" rows="3" :value="$profile->about_2_idn"
                                       help="Kosongkan untuk memakai versi Inggris." />
                    </div>

                    <div class="sm:col-span-2">
                        <x-admin.field name="cv_url" label="Link Download CV" type="url" :value="$profile->cv_url"
                                       placeholder="https://drive.google.com/..." />
                    </div>

                    <div class="sm:col-span-2">
                        <x-admin.image-input name="hero_image" label="Foto Profil (Hero)" :current="$profile->hero_image" ratio="1" />
                    </div>

                    <div class="sm:col-span-2">
                        <x-admin.field name="hero_quote" label="Quote (English)" type="textarea" rows="2" :value="$profile->hero_quote"
                                       placeholder="Contoh: Code is like humor. When you have to explain it, it's bad. Build with passion, learn with coding."
                                       help="Teks quote di hero section. Kosongkan untuk menggunakan default." />
                    </div>

                    <div class="sm:col-span-2">
                        <x-admin.field name="hero_quote_idn" label="Quote (Indonesia)" type="textarea" rows="2" :value="$profile->hero_quote_idn"
                                       placeholder="Contoh: Kode itu seperti humor. Ketika harus dijelaskan, artinya buruk. Bangun dengan semangat, belajar sambil ngoding."
                                       help="Kosongkan untuk memakai versi Inggris." />
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

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <h3 class="font-poppins font-bold text-slate-800 mb-5 flex items-center gap-2">
                        <i class="ri-shield-check-line text-accent"></i>Keamanan 2 Langkah (2FA)
                    </h3>
                    @if (auth()->user()->hasTwoFactorEnabled())
                        <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 mb-4 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                                <i class="ri-checkbox-circle-fill text-emerald-600 text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-emerald-800">2FA Aktif</p>
                                <p class="text-xs text-emerald-600">Akun Anda dilindungi autentikasi dua faktor.</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.profile.2fa.setup') }}"
                           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs font-bold hover:bg-red-100 transition-colors">
                            <i class="ri-shield-cross-line"></i> Nonaktifkan 2FA
                        </a>
                    @else
                        <p class="text-xs text-slate-500 mb-4">Tambahkan lapisan keamanan ekstra dengan autentikasi dua faktor menggunakan aplikasi seperti Google Authenticator.</p>
                        <a href="{{ route('admin.profile.2fa.setup') }}"
                           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 text-white text-xs font-bold hover:bg-emerald-700 transition-colors">
                            <i class="ri-shield-check-line"></i> Aktifkan 2FA
                        </a>
                    @endif
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
