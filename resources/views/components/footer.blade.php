@php
    $profile = \App\Models\Profile::first();

    $footerName = $profile->name ?? 'Adya Handika Putra AP';
    $footerTagline = $profile->tagline ?? 'Design UI for website, Building modular, Web applications with a focus on architecture and precise digital experiences.';
    $footerTaglineIdn = $profile->tagline_idn ?? null;

    $quickLinks = [
        ['href' => '#beranda', 'label' => 'Home', 'tKey' => 'navHome'],
        ['href' => '#tentang', 'label' => 'About', 'tKey' => 'navAbout'],
        ['href' => '#skills', 'label' => 'Skills', 'tKey' => 'navSkills'],
        ['href' => '#proyek', 'label' => 'Projects', 'tKey' => 'navProjects'],
        ['href' => '#certificates', 'label' => 'Certificates', 'tKey' => 'navCertificates'],
        ['href' => '#kontak', 'label' => 'Contact', 'tKey' => 'navContact'],
    ];

    $socials = [
        ['url' => $profile->github ?? 'https://github.com/Adya30/', 'icon' => 'ri-github-fill', 'label' => 'GitHub'],
        ['url' => $profile->instagram ?? 'https://www.instagram.com/adya_han/', 'icon' => 'ri-instagram-fill', 'label' => 'Instagram'],
        ['url' => $profile->youtube ?? 'https://www.youtube.com/@AdyaHandika', 'icon' => 'ri-youtube-fill', 'label' => 'YouTube'],
        ['url' => $profile->linkedin ?? 'https://www.linkedin.com/in/adya-handika/', 'icon' => 'ri-linkedin-box-fill', 'label' => 'LinkedIn'],
    ];
@endphp

<footer class="relative z-10 bg-black text-slate-400 pt-16 pb-12 px-6 mt-2 md:pt-20 md:pb-16">
    <div class="max-w-6xl mx-auto">
        <div class="grid md:grid-cols-3 gap-12 md:gap-16 lg:gap-24">

            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <span class="font-poppins font-bold text-lg text-white">{{ $footerName }}</span>
                </div>
                <div class="space-y-4">
                    <p class="text-sm leading-relaxed max-w-xs text-slate-400"
                       x-text='L(@json($footerTagline), @json($footerTaglineIdn))'>
                        {{ $footerTagline }}
                    </p>
                </div>
            </div>

            <div>
                <h3 class="font-poppins font-bold text-sm text-white mb-6 uppercase tracking-wider" x-text="t('quickLinks')">Quick Links</h3>
                <ul class="space-y-3.5">
                    @foreach ($quickLinks as $link)
                        <li>
                            <a href="{{ $link['href'] }}" @click.prevent="scrollToSection($event, '{{ $link['href'] }}')"
                               class="text-sm hover:text-white transition-colors duration-200">
                                <span x-text="t('{{ $link['tKey'] }}')">{{ $link['label'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h3 class="font-poppins font-bold text-sm text-white mb-6 uppercase tracking-wider" x-text="t('connect')">Connect</h3>
                <div class="space-y-4">
                    @foreach ($socials as $social)
                        <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer"
                           class="flex items-center gap-3 text-sm hover:text-white transition-colors duration-200">
                            <i class="{{ $social['icon'] }} text-lg"></i>
                            <span>{{ $social['label'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mt-20 pt-10 border-t border-white/10">
            <p class="text-sm text-slate-500 font-medium">© {{ date('Y') }} {{ $footerName }}</p>
        </div>
    </div>
</footer>
