<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <title>Login — Admin Adya Portfolio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-body bg-[#0a0a0f] text-white min-h-screen flex items-center justify-center p-4 relative overflow-hidden">

    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="absolute inset-0 bg-[linear-gradient(rgba(59,130,246,0.04)_1px,transparent_1px),linear-gradient(90deg,rgba(59,130,246,0.04)_1px,transparent_1px)] bg-[size:48px_48px]"></div>
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
            <form method="POST" action="{{ route('login.attempt') }}" class="space-y-5">
                @csrf

                @if ($errors->any())
                    <div class="flex items-start gap-2 bg-red-500/10 border border-red-500/30 text-red-400 text-sm font-medium px-4 py-3 rounded-xl">
                        <i class="ri-error-warning-line text-lg mt-0.5 flex-shrink-0"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <div class="space-y-1.5">
                    <label for="email" class="block text-sm font-semibold text-slate-300">Email</label>
                    <div class="relative">
                        <i class="ri-mail-line absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                               placeholder="admin@adyahan.my.id"
                               class="w-full rounded-xl border border-white/10 bg-white/5 pl-10 pr-3.5 py-2.5 text-sm text-white placeholder:text-slate-500 outline-none focus:border-accent focus:ring-4 focus:ring-accent/20 transition-all">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label for="password" class="block text-sm font-semibold text-slate-300">Password</label>
                    <div class="relative">
                        <i class="ri-lock-line absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                        <input type="password" name="password" id="password" required placeholder="••••••••"
                               class="w-full rounded-xl border border-white/10 bg-white/5 pl-10 pr-3.5 py-2.5 text-sm text-white placeholder:text-slate-500 outline-none focus:border-accent focus:ring-4 focus:ring-accent/20 transition-all">
                    </div>
                </div>

                <label class="flex items-center gap-2 text-sm text-slate-400 cursor-pointer select-none">
                    <input type="checkbox" name="remember"
                           class="w-4 h-4 rounded border-slate-600 bg-white/5 text-accent focus:ring-accent/30">
                    Ingat saya
                </label>

                <button type="submit"
                        class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-accent text-white text-sm font-semibold hover:bg-blue-600 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-accent/30 transition-all">
                    <i class="ri-login-box-line"></i>Masuk
                </button>
            </form>
        </div>

        <p class="text-center mt-6">
            <a href="{{ route('landing') }}"
               class="inline-flex items-center gap-1.5 text-sm text-slate-400 hover:text-white transition-colors">
                <i class="ri-arrow-left-line"></i>Kembali ke Website
            </a>
        </p>
    </div>
</body>
</html>
