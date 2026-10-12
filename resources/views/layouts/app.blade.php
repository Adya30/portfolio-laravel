<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#e2e8f0">

    @php
        $seo = $seo ?? [];

        $seoTitle = $seo['title'] ?? 'Adya Handika Putra AP | Web Developer & UI Designer Portfolio';
        $seoDescription = $seo['description']
            ?? 'Portfolio resmi Adya Handika Putra AP — Full Stack Web Developer & UI Designer. Menampilkan karya proyek web modern, sertifikasi, tech stack, dan course materi pemrograman.';
        $seoKeywords = $seo['keywords']
            ?? 'adya, adya handika, portfolio, portfolio adya, adya komputer, Adya Handika Putra AP, Adya AP, Web Developer, Full Stack Developer, UI UX Designer, Portfolio Laravel, Tailwind CSS, JavaScript, Programmer Jember, Pemrograman Web';
        $seoType = $seo['type'] ?? 'website';
        $seoUrl = $seo['url'] ?? url()->current();

        $seoImage = null;
        if (! empty($seo['image'])) {
            $seoImage = img_url($seo['image']);
        } elseif (! empty(profile()?->hero_image)) {
            $seoImage = img_url(profile()->hero_image);
        }
        if ($seoImage) {
            if (str_starts_with($seoImage, '//')) {
                $seoImage = 'https:'.$seoImage;
            } elseif (! str_starts_with($seoImage, 'http://') && ! str_starts_with($seoImage, 'https://')) {
                $seoImage = url($seoImage);
            }
        }

        $seoJsonLd = $seo['jsonld'] ?? [];
    @endphp

    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $seoDescription }}">
    <meta name="keywords" content="{{ $seoKeywords }}">
    <meta name="author" content="Adya Handika Putra AP">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    @if (config('services.google.site_verification'))
        <meta name="google-site-verification" content="{{ config('services.google.site_verification') }}">
    @endif
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
        (function () {
            try {
                var t = localStorage.getItem('theme');
                var dark = t === 'dark';
                document.documentElement.classList.toggle('dark', dark);

                var themeColor = document.querySelector('meta[name="theme-color"]');
                if (themeColor) themeColor.setAttribute('content', dark ? '#050508' : '#e2e8f0');

                var lang = localStorage.getItem('lang') || 'en';
                document.documentElement.setAttribute('lang', lang);
                document.documentElement.setAttribute('data-lang', lang);
            } catch (e) {}
        })();
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://res.cloudinary.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap">

    <script>window.landingUrl = "{{ route('landing') }}";</script>

    <x-custom-cursor-styles />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="app" data-active-nav="{{ $activeNav ?? 'beranda' }}"
      class="bg-canvas dark:bg-canvas-dark text-slate-800 dark:text-white transition-colors duration-300">

    <x-navbar />

    <main>
        @yield('content')
    </main>

    <x-footer />
</body>
</html>
