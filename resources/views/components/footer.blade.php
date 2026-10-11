@php
    $profile = profile();

    $footerName = $profile->name ?? 'Adya Handika Putra AP';
    $footerTagline =
        $profile->tagline ??
        'Design UI for website, Building modular, Web applications with a focus on architecture and precise digital experiences.';
    $footerTaglineIdn = $profile->tagline_idn ?? null;

    $quickLinks = [
        ['href' => '#beranda', 'label' => 'Home', 'tKey' => 'navHome'],
        ['href' => '#tentang', 'label' => 'About', 'tKey' => 'navAbout'],
        ['href' => '#skills', 'label' => 'Skills', 'tKey' => 'navSkills'],
        ['href' => '#proyek', 'label' => 'Projects', 'tKey' => 'navProjects'],
        ['href' => route('course.index'), 'label' => 'Course', 'tKey' => 'navCourse', 'external' => true],
        ['href' => '#certificates', 'label' => 'Certificates', 'tKey' => 'navCertificates'],
        ['href' => '#kontak', 'label' => 'Contact', 'tKey' => 'navContact'],
    ];

    $socials = [
        ['url' => $profile->github ?? 'https://github.com/Adya30/', 'icon' => 'ri-github-fill', 'label' => 'GitHub'],
        [
            'url' => $profile->instagram ?? 'https://www.instagram.com/adya_han/',
            'icon' => 'ri-instagram-fill',
            'label' => 'Instagram',
        ],
        [
            'url' => $profile->youtube ?? 'https://www.youtube.com/@AdyaHandika',
            'icon' => 'ri-youtube-fill',
            'label' => 'YouTube',
        ],
        [
            'url' => $profile->linkedin ?? 'https://www.linkedin.com/in/adya-handika/',
            'icon' => 'ri-linkedin-box-fill',
            'label' => 'LinkedIn',
        ],
    ];

    $footerLinkClasses =
        'text-sm text-slate-600 dark:text-slate-400 hover:text-accent dark:hover:text-accent-light transition-colors duration-200';
    $footerHeadingClasses =
        'font-poppins font-bold text-sm uppercase tracking-wider mb-6 text-slate-900 dark:text-white';
@endphp

<footer class="relative z-10 pt-2 sm:pt-3 pb-8 sm:pb-12" id="footer">
    <div class="w-[calc(100%-2.5rem)] max-w-6xl mx-auto">
        <div
            class="rounded-3xl border border-slate-200/90 dark:border-white/10 bg-white dark:bg-[#0f172a]/95 p-6 sm:p-10 lg:p-12 shadow-none">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 sm:gap-10 lg:gap-16">

                <div class="space-y-4">
                    <span
                        class="font-poppins font-bold text-xl sm:text-2xl text-slate-900 dark:text-white block tracking-tight">
                        {{ $footerName }}
                    </span>
                    <p class="text-sm leading-relaxed max-w-sm text-slate-600 dark:text-slate-400"
                        x-text='L(@json($footerTagline), @json($footerTaglineIdn))'>
                        {{ $footerTagline }}
                    </p>
                </div>

                <div>
                    <h3 class="{{ $footerHeadingClasses }}" x-text="t('quickLinks')">Quick Links</h3>
                    <ul class="space-y-3">
                        @foreach ($quickLinks as $link)
                            <li>
                                 @if (!empty($link['external']))
                                     <a href="{{ $link['href'] }}"
                                         class="{{ $footerLinkClasses }} inline-flex items-center gap-1.5 hover:text-orange-500 dark:hover:text-orange-400">
                                         <i class="ri-arrow-right-s-line text-xs" aria-hidden="true"></i>
                                         <span x-text="t('{{ $link['tKey'] }}')">{{ $link['label'] }}</span>
                                     </a>
                                 @else
                                     <a href="{{ $link['href'] }}"
                                         @click.prevent="scrollToSection($event, '{{ $link['href'] }}')"
                                         class="{{ $footerLinkClasses }} inline-flex items-center gap-1.5 hover:text-orange-500 dark:hover:text-orange-400">
                                         <i class="ri-arrow-right-s-line text-xs" aria-hidden="true"></i>
                                         <span x-text="t('{{ $link['tKey'] }}')">{{ $link['label'] }}</span>
                                     </a>
                                 @endif
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <h3 class="{{ $footerHeadingClasses }}" x-text="t('connect')">Connect</h3>
                    <div class="space-y-3.5">
                        @foreach ($socials as $social)
                            <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer"
                                class="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-400 hover:text-orange-500 dark:hover:text-orange-400 transition-colors duration-200 group">
                                <span
                                    class="w-8 h-8 rounded-lg border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/5 flex items-center justify-center text-slate-700 dark:text-slate-300 group-hover:text-orange-500 dark:group-hover:text-orange-400 group-hover:border-orange-500/40 transition-all shrink-0">
                                    <i class="{{ $social['icon'] }} text-base" aria-hidden="true"></i>
                                </span>
                                <span>{{ $social['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="w-[calc(100%-2.5rem)] max-w-6xl mx-auto mt-3 sm:mt-4">
        <div
            class="rounded-2xl sm:rounded-3xl border border-slate-200/90 dark:border-white/10 bg-white dark:bg-[#0f172a]/95 px-6 py-4 sm:px-8 sm:py-4.5 shadow-none flex flex-col sm:flex-row items-center justify-between gap-3 text-center sm:text-left">
            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 font-medium">
                © {{ date('Y') }} {{ $footerName }}. All rights reserved.
            </p>
        </div>
    </div>
</footer>
