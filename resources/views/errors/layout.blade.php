<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('code', 'Error') - @yield('title', 'Terjadi Kesalahan')</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    <script>
        (function () {
            try {
                var dark = localStorage.getItem('theme') === 'dark';
                document.documentElement.classList.toggle('dark', dark);
            } catch (e) {}
        })();
    </script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Poppins', 'Inter', sans-serif;
        }
    </style>
</head>
<body class="min-h-full flex flex-col justify-center items-center p-6 bg-slate-100 dark:bg-[#050508] text-slate-800 dark:text-slate-100 transition-colors duration-300">
    <div class="w-full max-w-lg mx-auto text-center">
        <!-- Main Error Card -->
        <div class="relative bg-white dark:bg-[#0f172a] rounded-3xl p-8 sm:p-10 border border-slate-200/80 dark:border-white/10 shadow-xl shadow-slate-200/40 dark:shadow-none backdrop-blur-xl">
            <!-- Code Badge (Tanpa Animasi Kedip) -->
            <div class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold tracking-wider uppercase mb-6 @yield('badge-class', 'bg-red-50 text-red-600 dark:bg-red-500/10 dark:text-red-400 border border-red-200/60 dark:border-red-500/20')">
                <span>ERROR @yield('code')</span>
            </div>

            <!-- Icon Graphic -->
            <div class="mx-auto w-20 h-20 rounded-2xl flex items-center justify-center mb-6 @yield('icon-bg-class', 'bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400')">
                @yield('icon')
            </div>

            <!-- Title -->
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white mb-3">
                @yield('title')
            </h1>

            <!-- Description -->
            <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 mb-8 leading-relaxed">
                @yield('message')
            </p>

            <!-- Action Buttons (Hanya Tombol Kembali) -->
            <div class="flex items-center justify-center">
                <button onclick="if(window.history.length > 1) { window.history.back(); } else { window.location.href = '{{ route('landing') }}'; }" 
                        type="button"
                        class="px-6 py-2.5 rounded-xl font-medium text-sm border border-slate-200 dark:border-white/10 text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-white/5 transition-all flex items-center justify-center gap-2 cursor-pointer shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Kembali</span>
                </button>
            </div>
        </div>
    </div>
</body>
</html>
