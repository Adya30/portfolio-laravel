<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <title>Login - Adya Portfolio</title>

    <script>
        (function() {
            try {
                var t = localStorage.getItem('theme');
                var dark = t === 'dark';
                document.documentElement.classList.toggle('dark', dark);
            } catch (e) {}
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body x-data="{
    dark: localStorage.getItem('theme') === 'dark',
    toggleTheme() {
        this.dark = !this.dark;
        localStorage.setItem('theme', this.dark ? 'dark' : 'light');
        document.documentElement.classList.toggle('dark', this.dark);
    }
}"
    class="min-h-screen bg-canvas dark:bg-canvas-dark text-slate-800 dark:text-white flex items-center justify-center p-3.5 sm:p-6 font-sans relative overflow-x-hidden antialiased transition-colors duration-300">

    <!-- THEME-AWARE PAGE BACKDROP (GRID + SOFT GLOW) -->
    <x-page-background />

    <!-- MAIN CARD CONTAINER -->
    <div
        class="relative z-10 w-full max-w-[768px] bg-white dark:bg-[#0f172a] rounded-[28px] sm:rounded-[32px] shadow-[0_20px_50px_rgba(249,115,22,0.12),0_10px_25px_rgba(0,0,0,0.05)] dark:shadow-[0_25px_60px_-15px_rgba(0,0,0,0.8)] overflow-hidden flex flex-col md:flex-row transition-all duration-300 border border-slate-200/80 dark:border-white/10">

        <!-- THEME TOGGLE BUTTON (FUSED INSIDE TOP-RIGHT OF CARD) -->
        <button @click="toggleTheme" type="button"
            class="absolute top-3.5 right-3.5 sm:top-4 sm:right-4 z-30 w-9 h-9 sm:w-10 sm:h-10 rounded-xl sm:rounded-2xl bg-white/20 hover:bg-white/30 border border-white/30 backdrop-blur-md flex items-center justify-center text-white shadow-sm transition-all active:scale-95 cursor-pointer"
            :aria-label="dark ? 'Ganti ke tema terang' : 'Ganti ke tema gelap'"
            :title="dark ? 'Ganti ke tema terang' : 'Ganti ke tema gelap'">
            <i class="text-base sm:text-lg leading-none"
                :class="dark ? 'ri-sun-line text-amber-300' : 'ri-moon-line text-white'" aria-hidden="true"></i>
        </button>

        <!-- ORANGE PANEL (TOP ON MOBILE, RIGHT ON DESKTOP) -->
        <div
            class="order-1 md:order-2 w-full md:w-1/2 bg-gradient-to-br from-orange-500 to-amber-500 dark:from-orange-500 dark:to-amber-500 text-white p-7 pt-10 sm:p-10 md:p-11 flex flex-col items-center justify-center text-center relative overflow-hidden rounded-t-[28px] sm:rounded-t-[32px] rounded-b-[36px] sm:rounded-b-[44px] md:rounded-t-none md:rounded-b-none md:rounded-l-[50px] lg:md:rounded-l-[65px] md:rounded-r-[32px] transition-all duration-300">

            <!-- FOTO HERO IMAGE PROFIL (RAPAT DENGAN LINGKARAN & BACKGROUND PUTIH) -->
            <div class="flex flex-col items-center justify-center mb-5 sm:mb-6 md:mb-7">
                <div
                    class="relative w-28 h-28 sm:w-32 sm:h-32 md:w-36 md:h-36 rounded-full bg-white border-2 sm:border-3 border-white/90 shadow-2xl overflow-hidden flex items-center justify-center shrink-0">
                    @php
                        $heroImg = profile()?->hero_image ? img_url(profile()->hero_image) : null;
                    @endphp
                    @if ($heroImg)
                        <img src="{{ $heroImg }}" alt="{{ profile()?->name ?? 'Hero Image' }}"
                            class="w-full h-full object-cover object-top select-none">
                    @else
                        <i class="ri-user-smile-line text-5xl md:text-6xl text-orange-500"></i>
                    @endif
                </div>

                @if (!empty(profile()?->name))
                    <h2 class="text-base sm:text-lg font-bold text-white mt-3 text-center tracking-tight">
                        {{ profile()->name }}
                    </h2>
                @endif
                @if (!empty(profile()?->role_title))
                    <p class="text-xs text-white/90 dark:text-amber-100 font-medium text-center mt-0.5">
                        {{ profile()->role_title }}
                    </p>
                @endif
            </div>

            <!-- TOMBOL KEMBALI KE HALAMAN PROFILE -->
            <a href="{{ route('landing') }}"
                class="bg-white text-orange-600 hover:text-orange-700 hover:bg-slate-50 dark:bg-white dark:text-orange-600 dark:hover:bg-slate-100 text-xs font-bold uppercase tracking-wider px-7 sm:px-9 py-2.5 sm:py-3 rounded-xl sm:rounded-2xl hover:shadow-lg hover:shadow-orange-950/20 active:scale-95 transition-all duration-200 inline-block shadow-md cursor-pointer">
                KEMBALI KE PROFILE
            </a>

        </div>

        <!-- SIGN IN FORM (BOTTOM ON MOBILE, LEFT ON DESKTOP) -->
        <div class="order-2 md:order-1 w-full md:w-1/2 p-6 sm:p-9 md:p-12 flex flex-col justify-center">

            <h1
                class="text-2xl sm:text-3xl font-extrabold text-slate-800 dark:text-white text-center tracking-tight mb-5 md:mb-6">
                Welcome!
            </h1>

            @if (isset($errors) && $errors->any())
                <div
                    class="mb-4 p-3 rounded-xl bg-red-500/10 border border-red-500/20 text-red-600 dark:text-red-400 text-xs font-medium text-center">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.attempt') }}" class="w-full space-y-3 sm:space-y-3.5">
                @csrf

                <div>
                    <input type="email" name="email" id="email" required autofocus value="{{ old('email') }}"
                        placeholder="Email" autocomplete="email"
                        class="w-full bg-[#f1f3f6] dark:bg-white/5 text-slate-800 dark:text-white placeholder:text-slate-400 dark:placeholder:text-slate-500 text-sm px-4 py-3 rounded-xl border border-transparent dark:border-white/10 outline-none focus:ring-2 focus:ring-orange-500/30 dark:focus:ring-orange-500/40 focus:bg-white dark:focus:bg-white/10 transition">
                </div>

                <div>
                    <input type="password" name="password" id="password" required placeholder="Password"
                        autocomplete="current-password"
                        class="w-full bg-[#f1f3f6] dark:bg-white/5 text-slate-800 dark:text-white placeholder:text-slate-400 dark:placeholder:text-slate-500 text-sm px-4 py-3 rounded-xl border border-transparent dark:border-white/10 outline-none focus:ring-2 focus:ring-orange-500/30 dark:focus:ring-orange-500/40 focus:bg-white dark:focus:bg-white/10 transition">
                </div>

                <div class="text-center pt-2">
                    <button type="submit"
                        class="w-full sm:w-auto bg-orange-500 hover:bg-orange-600 dark:bg-orange-500 dark:hover:bg-orange-600 text-white text-xs font-bold uppercase tracking-wider px-12 py-3.5 rounded-xl hover:shadow-lg hover:shadow-orange-500/25 dark:shadow-orange-950/40 active:scale-95 transition-all duration-200 inline-block shadow-md cursor-pointer">
                        Login
                    </button>
                </div>
            </form>
        </div>

    </div>

</body>

</html>
