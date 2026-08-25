@extends('admin.layouts.app')

@section('title', '2FA Aktif')
@section('page_title', 'Autentikasi Dua Faktor')

@section('content')
    <x-admin.page-title/>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">

            <div class="text-center mb-8">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-emerald-100 flex items-center justify-center">
                    <i class="ri-shield-check-fill text-emerald-600 text-3xl"></i>
                </div>
                <h2 class="font-poppins font-bold text-slate-800 text-xl mb-2">2FA Aktif</h2>
                <p class="text-sm text-slate-500">Autentikasi dua faktor sudah aktif pada akun Anda.</p>
            </div>

            {{-- Status --}}
            <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 mb-6 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                    <i class="ri-checkbox-circle-fill text-emerald-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-emerald-800">2FA Telah Aktif</p>
                    <p class="text-xs text-emerald-600">Akun Anda dilindungi oleh autentikasi dua faktor.</p>
                </div>
            </div>

            {{-- Disable Section --}}
            <div class="border border-red-200 rounded-xl p-5 bg-red-50/50">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center shrink-0">
                        <i class="ri-shield-cross-line text-red-500 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-800 text-sm">Nonaktifkan 2FA</h3>
                        <p class="text-xs text-slate-500">Masukkan kode dari aplikasi authenticator untuk menonaktifkan.</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.profile.2fa.disable') }}">
                    @csrf
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3">
                        <input type="text" name="one_time_password" maxlength="6" pattern="[0-9]{6}" inputmode="numeric" autocomplete="one-time-code"
                               placeholder="000000"
                               class="w-full max-w-[200px] rounded-xl border border-slate-200 bg-white px-4 py-3 text-center text-2xl font-mono font-bold tracking-[0.5em] text-slate-800 placeholder:text-slate-300 outline-none focus:border-red-400 focus:ring-2 focus:ring-red-400/15 transition-all"
                               required>
                        <button type="submit"
                                onclick="return confirm('Apakah Anda yakin ingin menonaktifkan 2FA? Akun Anda akan kehilangan perlindungan tambahan.')"
                                class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-red-600 text-white text-sm font-bold hover:bg-red-700 transition-colors">
                            <i class="ri-shield-cross-line"></i> Nonaktifkan
                        </button>
                    </div>
                    @error('one_time_password')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </form>
            </div>

            <div class="border-t border-slate-100 pt-5 mt-6">
                <a href="{{ route('admin.profile.edit') }}" class="text-sm text-slate-500 hover:text-accent transition-colors">
                    <i class="ri-arrow-left-line mr-1"></i>Kembali ke Profil
                </a>
            </div>
        </div>
    </div>
@endsection
