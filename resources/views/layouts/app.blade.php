<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0a0a0f" media="(prefers-color-scheme: dark)">
    <meta name="theme-color" content="#f8fafc" media="(prefers-color-scheme: light)">

    @php
        $seo = $seo ?? [];

        $seoTitle = $seo['title'] ?? 'Adya Handika Putra AP | Web Developer & UI Designer Portfolio';
        $seoDescription = $seo['description']
            ?? 'Portfolio of Adya Handika Putra AP — a Full Stack Developer and UI Designer. Explore projects, certificates, tools, and experiences in web development.';
        $seoKeywords = $seo['keywords']
            ?? 'Adya Handika Putra AP, Web Developer, UI Designer, Full Stack Developer, Portfolio, Laravel, JavaScript, Web Design';
        $seoType = $seo['type'] ?? 'website';
        $seoUrl = $seo['url'] ?? url()->current();
        $seoImage = null;
        if (! empty($seo['image'])) {
            $isAbsolute = str_starts_with($seo['image'], 'http://')
                || str_starts_with($seo['image'], 'https://');
            $seoImage = $isAbsolute
                ? $seo['image']
                : (str_starts_with($seo['image'], '//') ? 'https:'.$seo['image'] : url($seo['image']));
        }
        $seoJsonLd = $seo['jsonld'] ?? [];
    @endphp

    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $seoDescription }}">
    <meta name="keywords" content="{{ $seoKeywords }}">
    <meta name="author" content="Adya Handika Putra AP">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ $seoUrl }}">

    {{-- Favicon (file lokal, kompatibel browser lama) --}}
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

    {{-- Open Graph --}}
    <meta property="og:site_name" content="Adya Handika Putra AP | Portfolio">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:type" content="{{ $seoType }}">
    <meta property="og:url" content="{{ $seoUrl }}">
    <meta property="og:locale" content="en_US">
    @if ($seoImage)
        <meta property="og:image" content="{{ $seoImage }}">
        <meta property="og:image:alt" content="{{ $seoTitle }}">
    @endif

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="{{ $seoImage ? 'summary_large_image' : 'summary' }}">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    @if ($seoImage)
        <meta name="twitter:image" content="{{ $seoImage }}">
    @endif

    {{-- Structured data (JSON-LD) --}}
    @if ($seoJsonLd)
        <script type="application/ld+json">{!! json_encode($seoJsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    @endif

    <script>
        (function () {
            try {
                var t = localStorage.getItem('theme');
                var dark = t ? t === 'dark' : window.matchMedia('(prefers-color-scheme: dark)').matches;
                document.documentElement.classList.toggle('dark', dark);
            } catch (e) {}
        })();
    </script>

    {{-- Base URL of the landing page, used by the navbar to jump to a section
         from detail pages (e.g. /project/1 -> /#proyek). --}}
    <script>window.landingUrl = "{{ route('landing') }}";</script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="app" data-active-nav="{{ $activeNav ?? 'beranda' }}"
      class="bg-slate-50 dark:bg-[#0a0a0f] text-slate-800 dark:text-white transition-colors duration-300">

    <x-navbar />

    <main>
        @yield('content')
    </main>

    <x-footer />
</body>
</html>
