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
            ?? 'Portfolio of Adya Handika Putra AP — a Full Stack Developer and UI Designer. Explore projects, certificates, tools, and experiences in web development.';
        $seoKeywords = $seo['keywords']
            ?? 'Adya Handika Putra AP, Web Developer, UI Designer, Full Stack Developer, Portfolio, Laravel, JavaScript, Web Design';
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
    <meta name="keywords" content="{{ $seoKeywords }}">
    <meta name="author" content="Adya Handika Putra AP">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    @if (config('services.google.site_verification'))
        <meta name="google-site-verification" content="{{ config('services.google.site_verification') }}">
    @endif
    <link rel="canonical" href="{{ $seoUrl }}">

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon.ico') }}">

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
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
    @endif

    <meta name="twitter:card" content="{{ $seoImage ? 'summary_large_image' : 'summary' }}">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    @if ($seoImage)
        <meta name="twitter:image" content="{{ $seoImage }}">
    @endif

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
                var dark = t ? t === 'dark' : window.matchMedia('(prefers-color-scheme: dark)').matches;
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
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap">

    <script>window.landingUrl = "{{ route('landing') }}";</script>

    <style>
        @media (hover: hover) and (pointer: fine) {
            html, body, div, section, article, header, nav, footer, main, p, span, h1, h2, h3, h4, h5, h6, ul, li, img {
                cursor: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAM9SURBVFhHxZdLaBNBGMd3k9RkNwpGNiGLJkXwoCdBFFHUoAhaPfgsCIq1Up8XJQe9KVrxcVFR8FURETz0oCIqCNpWfNCiUkFoNU2b1narlbY22Hbb7iYzft/s9kVrm8Zk/cOf2Z2dxy/fzM5+4Xiej+XYbIXc/xLPcwNQJMFbWIXVEp18y8ndrg67jSNwu9WotVZKvMLb87B4BoVrjMQ2VmuhlNpXskrbZtPbYXcP3CNEPntikZTacn8v7cilpFFOlIRFhIBo2C2LhAHwM0gTzUFKYnKyJOzuhXrcnOtYiyzLAGgLUi0WMCAgErfCbhWe9YPXs1ZZ1CgAtG5G4sYREfeDBs5jLbOkMQBDkWiQyZXDIkYCITay1lnQuABaowkRk/VLh0TcEzpnt2cFYnwA02YkEiYEbsyVrFcGNSHAUCQA4vJBthzd4FWsZ4Y0MQB6BMTFA6IOfTAaIdY7A5ocAG1C0KhMLxQJCeiHEKvZCP+o1ADQg5GI+hNn9gi4HCpszDXGMOkrdQD0IES9Xzch+jjOscIYKj1NDQANEMlhCADg4uAlbLQ01FxTNkUA9PBy6MUFAp6Y6UE8uyc19tYFSKJpnEkm8yBExE9O7BIwoUGIpWzgVFVR6o2p9QGi/wUgCfW0K5fSOBjLX6Y7we2m4Zo0yeR0gYAfr26Hw7HMGD01fRuzBPDLsKQK/LqWQOL6WY92tdhDb56fpZdek+ijEqnv6V2p//UDn1b52KdWP/fT6DtZbS+XtKI8J+QTfI/L5Vhujj+pRm/CJigjcyip9FHy2TewdxNbXwX8AlwGrgZXgb+CI+A6cCe4VRT4ft9M228eEhpIdpuhLiUNA+DkUZj8jURJlZTct8GJX0GcfC5rOUKhUMgBhRMsgCWwF4zt5uXkcIugXAhOSQYArKVWD5O/9VLyXtLC+QImqd85btp8o1n2BEkpAPwI0iRO/kFKHtvBNlMHeAFrkWUptS8B4BOs+UdJP1UoYti7wIvZUwukfLnvUUmNl5zbL+Kphp9byyZHKfEnnu47x6djsoFne0a+cCnL7eJbj2534XrjSbaWVVopeF8xwcB3fTOrsFrw97zBZrPtNG8tFsf9AZKe/ut982c1AAAAAElFTkSuQmCC') 3 2, auto !important;
            }
            a, button, [role="button"], input[type="submit"], input[type="button"], select, label[for], summary, .cursor-pointer {
                cursor: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAANYSURBVFhHxZdfSFNRHMfvndN5r0X+ubMNmxL6UE9BFFFUqwjKgigoCArZQAxfInzwLV2Y5JNIgZQRRPRQDxVlD0HNFQlWhBHkUKfT1iwrzZFz03t37+n3O/duKVrOtbu+8OHsnnvO+X3v73funzEsy/qzDQYn87/EsswcNDJwDI8lT/kewIUtHusuPof91FhlmsgyMIrLWXgeAj+XPBVEbTNjIhjyCOH7TatJg6NQUYPHKXdpY3RVsM9jiZDxEtLZXBB1t5XEg2cuA96utTNkoozIfmvsUXN+FDJBGp1Cg3Zed6kGvpaSWKCUyMNW+Xpd3gz04+Y8QEfoLNXAeCkR/TbVBGSioy4vAudmgYN0lI5aYACRtExcPcvj7SkClXSkTlpkIJGJIatyuZbHTKCJw3S0DlrSgDiSKIfUWsvjnpCYrCxdTCxtQEPLREwzgRtzF52VRv3VQCITYKLtDC3HNLCbzkyT/m4AmWeitYaXYA5mw05np0HLG0A0E8RnJS3VXAzmoYm9dIV/VHIGkHgmBi2xJgeH5YjAxtynLpO6kjeAJMphkTQTUYYx7lSXSk0rM4CACVkzcdHBgQEmBGylq6WgQJ97hQaQeCZ8kIkqDp+YqZl4fKtoJDxgU2KjSwRZjriJfovScJpTYDk0sY0unKy67gj+GZ9Nkf5gQIZ+MlVGSAjA9ofGJPBdA37LI1blQhWHL69po9G4XV09OX1cVAK4MmxJEK4uYIu1NxeIV5oKyLWWQuluu0AedBRFO28Wzb64Vyz2PDRHep9YyGC3JfLNLYjVlaYwfGmGc3ONO7T1l9XCTTgK7cA6ovQUE/m9ec55hNY3CDwF3EAv8AroBwaAQWASGOM5drZ4jeEnyzAEPnYD0JeUfhvA4D4I/lIgco8gVx8y4VsQg6+nI+fJbrcboTEBHCAAZgDHVWRnM5uh3QQkJdUA1FIcguDdZiK/FsS6ExyBc58ZJmeDOkw/Bb0eMPAF6o3B3why/Um6mSaAjXSEzgp6n4GBd1Dzt4LkcvCY9ilgCz2bAQW9t/Mj8gezcqmGx6cavm4zFhwVDHXmT9+oX4UfG/hsT8sbLmnlmdixc8dNWG98ku2nnZkU3K/4gYH3+lHakWnB3/Nhg8FwSjvMsBjmF5bXJyDzj8hqAAAAAElFTkSuQmCC') 5 4, pointer !important;
            }
            input[type="text"], input[type="email"], input[type="password"], input[type="number"], input[type="search"], textarea, [contenteditable="true"] {
                cursor: text !important;
            }
            [disabled], .cursor-not-allowed {
                cursor: not-allowed !important;
            }
        }
    </style>

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
