<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0a0a0f" media="(prefers-color-scheme: dark)">
    <meta name="theme-color" content="#f8fafc" media="(prefers-color-scheme: light)">

    @php
        $seo = $seo ?? [];

        $seoTitle = $seo['title'] ?? 'Course | Learning Materials';
        $seoDescription = $seo['description'] ?? 'Collection of learning materials covering web development, programming, and UI design.';
        $seoType = $seo['type'] ?? 'website';
        $seoUrl = $seo['url'] ?? url()->current();
        $seoImage = null;
        if (! empty($seo['image'])) {
            $seoImage = img_url($seo['image']);
            if (str_starts_with($seoImage, '//')) {
                $seoImage = 'https:'.$seoImage;
            }
        }
        $seoJsonLd = $seo['jsonld'] ?? [];
    @endphp

    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $seoDescription }}">
    <meta name="author" content="Adya Handika Putra AP">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="{{ $seoUrl }}">

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

    <meta property="og:site_name" content="Adya Handika Putra AP | Portfolio">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:type" content="{{ $seoType }}">
    <meta property="og:url" content="{{ $seoUrl }}">
    <meta property="og:locale" content="id_ID">
    <meta property="og:locale:alternate" content="en_US">
    @if ($seoImage)
        <meta property="og:image" content="{{ $seoImage }}">
        <meta property="og:image:alt" content="{{ $seoTitle }}">
    @endif

    <meta name="twitter:card" content="{{ $seoImage ? 'summary_large_image' : 'summary' }}">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    @if ($seoImage)
        <meta name="twitter:image" content="{{ $seoImage }}">
    @endif

    @if ($seoJsonLd)
        <script type="application/ld+json">{!! json_encode($seoJsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) !!}</script>
    @endif

    <script>
        (function () {
            try {
                var t = localStorage.getItem('theme');
                var dark = t ? t === 'dark' : window.matchMedia('(prefers-color-scheme: dark)').matches;
                document.documentElement.classList.toggle('dark', dark);

                var lang = localStorage.getItem('lang') || 'en';
                document.documentElement.setAttribute('lang', lang);
                document.documentElement.setAttribute('data-lang', lang);
            } catch (e) {}
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="app" data-active-nav="course"
      class="bg-slate-50 dark:bg-[#0a0a0f] text-slate-800 dark:text-white transition-colors duration-300">

    {{-- Floating action buttons (no container navbar bar background) --}}
    @hasSection('topbar')
        @yield('topbar')
    @else
        <div class="fixed top-4 left-4 right-4 z-100 flex items-center justify-between pointer-events-none" x-cloak>
            <div class="pointer-events-auto">
                <a href="{{ route('landing') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl border backdrop-blur-xl shadow-lg bg-white/80 dark:bg-[#0b1329]/80 border-slate-200/60 dark:border-white/10 text-xs font-bold text-slate-700 dark:text-slate-200 hover:text-accent dark:hover:text-[#60a5fa] hover:border-accent/30 dark:hover:border-[#60a5fa]/30 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                    <i class="ri-arrow-left-line text-base text-accent dark:text-[#60a5fa]"></i>
                    <span x-text="t('home')">Home</span>
                </a>
            </div>
            <div class="pointer-events-auto flex items-center gap-2 p-1 rounded-2xl border backdrop-blur-xl shadow-lg bg-white/80 dark:bg-[#0b1329]/80 border-slate-200/60 dark:border-white/10">
                @include('course._toggles')
            </div>
        </div>
    @endif

    <main class="relative z-20">
        @yield('content')
    </main>
</body>
</html>
