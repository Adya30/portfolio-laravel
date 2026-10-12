<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#f8fafc">

    @php
        $seo = $seo ?? [];

        $seoTitle = $seo['title'] ?? 'Course Programming | Adya Handika Putra AP';
        $seoDescription =
            $seo['description'] ??
            'Kumpulan materi belajar programming dan web development oleh Adya Handika Putra AP. Tutorial Laravel, PHP, JavaScript, dan UI Design.';
        $seoType = $seo['type'] ?? 'website';
        $seoUrl = $seo['url'] ?? url()->current();

        $seoImage = null;
        if (!empty($seo['image'])) {
            $seoImage = img_url($seo['image']);
        } elseif (!empty(profile()?->hero_image)) {
            $seoImage = img_url(profile()->hero_image);
        }
        if ($seoImage) {
            if (str_starts_with($seoImage, '//')) {
                $seoImage = 'https:' . $seoImage;
            } elseif (! str_starts_with($seoImage, 'http://') && ! str_starts_with($seoImage, 'https://')) {
                $seoImage = url($seoImage);
            }
        }

        $seoJsonLd = $seo['jsonld'] ?? [];
    @endphp

    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $seoDescription }}">
    <meta name="keywords" content="{{ $seo['keywords'] ?? 'adya, adya handika, portfolio, portfolio adya, adya komputer, Adya Handika Putra AP, Web Developer, Programming, Course, Tutorial, Laravel, JavaScript, UI Design' }}">
    <meta name="author" content="Adya Handika Putra AP">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="{{ $seoUrl }}">

    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="apple-touch-icon" href="{{ asset('favicon.ico') }}">

    <meta property="og:site_name" content="Adya Handika Putra AP | Portfolio">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:type" content="{{ $seoType }}">
    <meta property="og:url" content="{{ $seoUrl }}">
    <meta property="og:locale" content="id_ID">
    <meta property="og:locale:alternate" content="en_US">
    @if ($seoImage)
        <meta property="og:image" content="{{ $seoImage }}">
        <meta property="og:image:secure_url" content="{{ $seoImage }}">
        <meta property="og:image:alt" content="{{ $seoTitle }}">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:image" content="{{ $seoImage }}">
        <meta name="twitter:image:alt" content="{{ $seoTitle }}">
    @else
        <meta name="twitter:card" content="summary">
    @endif
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">

    <link rel="alternate" hreflang="en" href="{{ $seoUrl }}">
    <link rel="alternate" hreflang="id" href="{{ $seoUrl }}">
    <link rel="alternate" hreflang="x-default" href="{{ $seoUrl }}">

    @if ($seoJsonLd)
        <script type="application/ld+json">{!! json_encode($seoJsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) !!}</script>
    @endif

    <script>
        (function() {
            try {
                var t = localStorage.getItem('theme');
                var dark = t === 'dark';
                document.documentElement.classList.toggle('dark', dark);

                var themeColor = document.querySelector('meta[name="theme-color"]');
                if (themeColor) themeColor.setAttribute('content', dark ? '#0a0a0f' : '#f8fafc');

                var lang = localStorage.getItem('lang') || 'en';
                document.documentElement.setAttribute('lang', lang);
                document.documentElement.setAttribute('data-lang', lang);
            } catch (e) {}
        })();
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://res.cloudinary.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap">

    <x-custom-cursor-styles />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body x-data="app" data-active-nav="course"
    class="bg-slate-50 dark:bg-[#0a0a0f] text-slate-800 dark:text-white transition-colors duration-300">

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
            <div
                class="pointer-events-auto flex items-center gap-2 p-1 rounded-2xl border backdrop-blur-xl shadow-lg bg-white/80 dark:bg-[#0b1329]/80 border-slate-200/60 dark:border-white/10">
                @include('course._toggles')
            </div>
        </div>
    @endif

    <main class="relative z-20">
        @yield('content')
    </main>
</body>

</html>
