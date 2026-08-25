<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <title>Verifikasi 2FA - Adya Portfolio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-body bg-[#0a0a0f] text-white min-h-screen flex items-center justify-center p-4 relative overflow-hidden">

    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="absolute inset-0 bg-[linear-gradient(rgba(59,130,246,0.04)_1px,transparent_1px),linear-gradient(90deg,rgba(59,130,246,0.04)_1px,transparent_1px)] bg-size-[48px_48px]"></div>
        <div class="absolute rounded-full blur-[120px] opacity-25"
             style="width: 400px; height: 400px; left: -10%; top: 10%; background: radial-gradient(circle, #3b82f6 0%, #8b5cf6 70%);"></div>
        <div class="absolute rounded-full blur-[120px] opacity-25"
             style="width: 450px; height: 450px; left: 60%; top: 45%; background: radial-gradient(circle, #8b5cf6 0%, #06b6d4 70%);"></div>
    </div>

    <div class="relative z-10 w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-1">
                <span class="font-poppins font-bold text-2xl text-amber-500">Adya</span>
                <span class="font-poppins font-bold text-2xl text-white">'s Portfolio</span>
            </div>
        </div>

        <div class="bg-[#1a1a2e] rounded-2xl border border-white/10 shadow-2xl p-8">
            <div class="text-center mb-6">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-blue-500/10 flex items-center justify-center">
                    <i class="ri-shield-keyhole-line text-blue-400 text-3xl"></i>
                </div>
                <h2 class="font-poppins font-bold text-white text-lg mb-1">Verifikasi 2FA</h2>
                <p class="text-sm text-slate-400">Masukkan kode dari aplikasi authenticator Anda.</p>
            </div>

            <form method="POST" action="{{ route('2fa.verify') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="user_id" value="{{ $userId }}">
                <input type="hidden" name="signature" value="{{ $signature }}">

                @if ($errors->any())
                    <div class="flex items-start gap-2 bg-red-500/10 border border-red-500/30 text-red-400 text-sm font-medium px-4 py-3 rounded-xl">
                        <i class="ri-error-warning-line text-lg mt-0.5 shrink-0"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <div class="space-y-1.5">
                    <label for="one_time_password" class="block text-sm font-semibold text-slate-300">Kode Verifikasi</label>
                    <input type="text" name="one_time_password" id="one_time_password" maxlength="6" pattern="[0-9]{6}" inputmode="numeric" autocomplete="one-time-code"
                           placeholder="000000" autofocus
                           class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-center text-2xl font-mono font-bold tracking-[0.5em] text-white placeholder:text-slate-500 outline-none focus:border-accent focus:ring-4 focus:ring-accent/20 transition-all">
                </div>

                <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-accent text-white text-sm font-semibold hover:bg-blue-600 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-accent/30 transition-all">
                    <i class="ri-shield-check-line"></i> Verifikasi
                </button>
            </form>
        </div>

        <p class="text-center mt-6">
            <a href="{{ route('login') }}"
               class="inline-flex items-center gap-1.5 text-sm text-slate-400 hover:text-white transition-colors">
                <i class="ri-arrow-left-line"></i> Kembali ke Login
            </a>
        </p>
    </div>
</body>
</html>
