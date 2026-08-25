@extends('admin.layouts.app')

@section('title', 'Aktifkan 2FA')
@section('page_title', 'Aktifkan Autentikasi Dua Faktor')

@section('content')
    <x-admin.page-title/>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">

            <div class="text-center mb-8">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-emerald-100 flex items-center justify-center">
                    <i class="ri-shield-check-line text-emerald-600 text-3xl"></i>
                </div>
                <h2 class="font-poppins font-bold text-slate-800 text-xl mb-2">Aktifkan 2FA</h2>
                <p class="text-sm text-slate-500">Autentikasi dua faktor menambahkan lapisan keamanan ekstra pada akun Anda.</p>
            </div>

            {{-- Step 1 --}}
            <div class="mb-6">
                <div class="flex items-center gap-3 mb-3">
                    <span class="w-7 h-7 rounded-full bg-accent text-white text-xs font-bold flex items-center justify-center shrink-0">1</span>
                    <h3 class="font-semibold text-slate-800 text-sm">Install Aplikasi Authenticator</h3>
                </div>
                <p class="text-xs text-slate-500 ml-10">Install aplikasi seperti Google Authenticator, Authy, atau 1Password di HP Anda.</p>
            </div>

            {{-- Step 2 --}}
            <div class="mb-6">
                <div class="flex items-center gap-3 mb-3">
                    <span class="w-7 h-7 rounded-full bg-accent text-white text-xs font-bold flex items-center justify-center shrink-0">2</span>
                    <h3 class="font-semibold text-slate-800 text-sm">Scan QR Code</h3>
                </div>
                <div class="ml-10">
                    <div class="bg-white border-2 border-dashed border-slate-200 rounded-xl p-3 sm:p-4 inline-block max-w-full">
                        <div id="qrcode" class="w-36 h-36 sm:w-44 sm:h-44 md:w-48 md:h-48 [&>svg]:w-full [&>svg]:h-full"></div>
                    </div>
                    <p class="text-xs text-slate-500 mt-2">Scan QR code di atas menggunakan aplikasi authenticator Anda.</p>

                    {{-- Manual entry --}}
                    <details class="mt-3">
                        <summary class="text-xs text-accent font-semibold cursor-pointer hover:underline">Tidak bisa scan? Masukkan kode manual</summary>
                        <div class="mt-2 bg-slate-50 rounded-lg p-3 border border-slate-200">
                            <code class="text-xs text-slate-700 font-mono break-all tracking-widest block text-center py-2">{{ $secret }}</code>
                        </div>
                    </details>
                </div>
            </div>

            {{-- Aktifkan --}}
            <div class="mb-8">
                <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 mb-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                        <i class="ri-checkbox-circle-fill text-emerald-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-emerald-800">Setelah scan QR code, klik tombol di bawah untuk mengaktifkan 2FA.</p>
                        <p class="text-xs text-emerald-600">Pastikan kode sudah muncul di aplikasi authenticator Anda.</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.profile.2fa.enable') }}" id="enable2faForm">
                    @csrf
                    <button type="submit"
                            onclick="return confirm('Aktifkan 2FA? Setelah ini, login akan memerlukan kode dari aplikasi authenticator.')"
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-emerald-600 text-white text-sm font-bold hover:bg-emerald-700 transition-colors">
                        <i class="ri-shield-check-line"></i> Aktifkan 2FA
                    </button>
                </form>
            </div>

            <div class="border-t border-slate-100 pt-5 flex items-center justify-between">
                <a href="{{ route('admin.profile.edit') }}" class="text-sm text-slate-500 hover:text-accent transition-colors">
                    <i class="ri-arrow-left-line mr-1"></i>Kembali ke Profil
                </a>
            </div>
        </div>
    </div>

    {{-- QR Code Generator (lightweight) --}}
    <script src="https://cdn.jsdelivr.net/npm/qrcode-generator@1.4.4/qrcode.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var url = @json($qrUrl);
            var qr = qrcode(0, 'M');
            qr.addData(url);
            qr.make();
            document.getElementById('qrcode').innerHTML = qr.createSvgTag(5, 0);
        });
    </script>
@endsection
