@extends('layouts.app')

@section('content')
    @php
        $toolNames = $tools->keyBy('id')->map->nama;

        $portfolioData = [
            'categories' => $categories->map(fn($c) => ['id' => $c->id, 'nama' => $c->nama])->values(),
            'tools' => $tools
                ->map(fn($t) => ['id' => $t->id, 'img' => img_url($t->gambar), 'nama' => $t->nama, 'ket' => $t->ket])
                ->values(),
            'projects' => $projects
                ->map(
                    fn($p) => [
                        'id' => $p->id,
                        'url' => route('project.show', $p),
                        'img' => img_url($p->gambar),
                        'nama' => $p->nama,
                        'desk' => $p->desk,
                        'deskIdn' => $p->desk_idn,
                        'tools' => collect($p->tools ?? [])
                            ->map(fn($t) => $toolNames[$t] ?? $t)
                            ->values(),
                        'link' => $p->link,
                        'fullDesk' => $p->full_desk,
                        'fullDeskIdn' => $p->full_desk_idn,
                        'fitur' => $p->fitur ?? [],
                        'fiturIdn' => $p->fitur_idn ?? [],
                        'categoryId' => $p->category_id,
                    ],
                )
                ->values(),
            'experiences' => $experiences
                ->map(
                    fn($e) => [
                        'id' => $e->id,
                        'url' => route('experience.show', $e),
                        'role' => $e->role,
                        'roleIdn' => $e->role_idn,
                        'company' => $e->company,
                        'duration' => $e->duration,
                        'location' => $e->location,
                        'desc' => $e->desk,
                        'descIdn' => $e->desk_idn,
                        'practicumDesc' => $e->practicum_desc,
                        'practicumDescIdn' => $e->practicum_desc_idn,
                        'img' => $e->gambar ? img_url($e->gambar) : null,
                        'responsibilities' => $e->responsibilities ?? [],
                        'responsibilitiesIdn' => $e->responsibilities_idn ?? [],
                        'skills' => $e->skills ?? [],
                    ],
                )
                ->values(),
            'certificates' => $certificates
                ->map(
                    fn($c) => [
                        'id' => $c->id,
                        'url' => route('certificate.show', $c),
                        'img' => img_url($c->gambar),
                        'nama' => $c->nama,
                        'namaIdn' => $c->nama_idn,
                        'penerbit' => $c->penerbit,
                        'tanggal' => $c->tanggal,
                        'desk' => $c->desk,
                        'deskIdn' => $c->desk_idn,
                    ],
                )
                ->values(),
        ];

        $profileName = $profile->name ?? 'Adya Handika Putra AP';
        $roleTitle = $profile->role_title ?? 'Web Developer | UI Design';
        $roleTitleIdn = $profile->role_title_idn ?? null;
        $tagline =
            $profile->tagline ??
            'Design UI for website, Building modular, Web applications with a focus on architecture and precise digital experiences.';
        $taglineIdn = $profile->tagline_idn ?? null;
        $about1 =
            $profile->about_1 ??
            "Hello! I'm Adya Handika Putra AP, a Full Stack Developer with a deep passion for technology, open source, and exploring new programming concepts to build digital solutions that are both functional and precisely crafted.";
        $about1Idn = $profile->about_1_idn ?? null;
        $about2 =
            $profile->about_2 ??
            "Currently pursuing a degree in Information Systems at the University of Jember, I'm constantly driven to learn, create, and contribute to the developer community through clean code, thoughtful architecture, and collaborative projects.";
        $about2Idn = $profile->about_2_idn ?? null;
        $email = $profile->email ?? 'handikaadya@gmail.com';
        $cvUrl =
            $profile->cv_url ?? 'https://drive.google.com/file/d/1yxphIQqnXRANWjzAER0K194RBqvTg3We/view?usp=sharing';
        $heroImage = $profile?->hero_image
            ? img_url($profile->hero_image)
            : 'data:image/svg+xml;utf8,' .
                rawurlencode(
                    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 320"><rect width="100%" height="100%" fill="#1e293b"/><text x="50%" y="54%" font-family="Arial, sans-serif" font-size="88" fill="#60a5fa" text-anchor="middle" font-weight="bold">AP</text></svg>',
                );
        $socials = [
            [
                'url' => $profile->github ?? 'https://github.com/Adya30/',
                'icon' => 'ri-github-fill',
                'label' => 'GitHub',
            ],
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
                'icon' => 'ri-linkedin-fill',
                'label' => 'LinkedIn',
            ],
        ];
        $chips = array_values(array_filter(array_map('trim', explode('|', $roleTitle)), fn($c) => $c !== ''));

        $nameParts = explode(' ', trim($profileName));
        $lastWord = array_pop($nameParts) ?: 'AP';
        $firstName = implode(' ', $nameParts) ?: 'Adya Handika Putra';

        $about1Html = e($about1);
        if ($profileName !== '' && str_contains($about1Html, e($profileName))) {
            $about1Html = str_replace(
                e($profileName),
                '<strong class="text-accent dark:text-accent-light">' . e($profileName) . '</strong>',
                $about1Html,
            );
        }

        $about1IdnHtml = $about1Idn ? e($about1Idn) : null;
        if ($about1IdnHtml && $profileName !== '' && str_contains($about1IdnHtml, e($profileName))) {
            $about1IdnHtml = str_replace(
                e($profileName),
                '<strong class="text-accent dark:text-accent-light">' . e($profileName) . '</strong>',
                $about1IdnHtml,
            );
        }
    @endphp

    <script>
        window.portfolioData = @json($portfolioData);
        window.heroQuote = {
            en: @json($profile?->hero_quote),
            idn: @json($profile?->hero_quote_idn),
            defaultEn: 'Code is like humor. When you have to explain it, it\u2019s bad. Build with passion, learn with coding.',
            defaultIdn: 'Kode itu seperti humor. Ketika harus dijelaskan, artinya buruk. Bangun dengan semangat, belajar sambil ngoding.'
        };
    </script>

    <style>
        @keyframes marquee-left {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        @keyframes marquee-right {
            0% { transform: translateX(-50%); }
            100% { transform: translateX(0); }
        }
        .animate-marquee-left {
            animation: marquee-left 30s linear infinite;
        }
        .animate-marquee-right {
            animation: marquee-right 30s linear infinite;
        }
        @media (prefers-reduced-motion: reduce) {
            .animate-marquee-left,
            .animate-marquee-right {
                animation: none;
            }
        }
    </style>

    <x-page-background />

    <section id="beranda"
        class="relative z-10 flex flex-col justify-start pt-32 pb-16 sm:pt-36 sm:pb-20 lg:pt-30 lg:pb-10 scroll-mt-24 sm:scroll-mt-28 overflow-x-clip">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="grid lg:grid-cols-3 items-center gap-10 lg:gap-8 w-full">

                <div class="text-center lg:text-left order-2 lg:order-1" data-aos="fade-up">
                    <h1 class="text-3xl sm:text-4xl lg:text-6xl font-bold font-poppins leading-tight mb-3 tracking-tight">
                        {{ $firstName }} <span class="text-accent dark:text-accent-light">{{ $lastWord }}</span>
                    </h1>
                    <p class="text-base sm:text-lg font-medium text-slate-600 dark:text-slate-300 mb-3"
                        x-text='L(@json($roleTitle), @json($roleTitleIdn))'>{{ $roleTitle }}</p>
                    <p class="text-sm sm:text-base text-slate-500 dark:text-slate-400 max-w-md mx-auto lg:mx-0 leading-relaxed"
                        x-text='L(@json($tagline), @json($taglineIdn))'>
                        {{ $tagline }}
                    </p>
                </div>

                <div class="flex justify-center order-1 lg:order-2" data-aos="fade-up" data-aos-delay="100">
                    <div class="relative w-full max-w-4xl mx-auto flex flex-col items-center pb-4 sm:pb-6">
                        <div class="absolute inset-x-0 top-0 aspect-square pointer-events-none"
                            style="background: radial-gradient(50% 50% at 50% 45%, rgb(59 130 246 / 0.13), transparent 70%);">
                        </div>

                        <div class="relative w-full flex justify-center z-10">
                            <img src="{{ $heroImage }}" alt="{{ $profileName }}" width="864" height="1080"
                                fetchpriority="high"
                                class="w-[50vw] max-w-[15rem] sm:w-[44vw] sm:max-w-[18rem] md:w-[40vw] md:max-w-[22rem] lg:w-full lg:max-w-none h-auto object-contain">
                        </div>

                        <div class="relative w-full max-w-lg -mt-4 sm:-mt-5 z-20" data-aos="fade-up" data-aos-delay="300">
                            <div class="surface flex items-start gap-2.5 sm:gap-3 px-3.5 py-3 sm:px-5 sm:py-4">
                                <span class="surface-muted w-7 h-7 sm:w-9 sm:h-9 flex items-center justify-center text-accent dark:text-accent-light shrink-0 mt-0.5">
                                    <i class="ri-double-quotes-l text-sm sm:text-base" aria-hidden="true"></i>
                                </span>
                                <p class="text-[12px] sm:text-xs md:text-sm font-medium leading-relaxed italic text-slate-700 dark:text-slate-200"
                                    x-text="L(heroQuote.en || heroQuote.defaultEn, heroQuote.idn || heroQuote.defaultIdn)">
                                    Code is like humor. When you have to explain it, it's bad. Build with passion, learn with coding.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col items-center lg:items-end gap-4 sm:gap-5 order-3 lg:order-3 w-full"
                    data-aos="fade-up" data-aos-delay="200">
                    <div class="grid grid-cols-2 lg:grid-cols-1 lg:flex lg:flex-col gap-2 sm:gap-3 w-full max-w-xs sm:max-w-sm lg:w-full">
                        <div class="surface w-full p-3 sm:px-5 sm:py-4">
                            <div class="flex items-center gap-2 sm:gap-3">
                                <div class="surface-muted w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center shrink-0">
                                    <i class="ri-code-box-line text-accent dark:text-accent-light text-sm sm:text-base" aria-hidden="true"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[9px] sm:text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 truncate" x-text="t('projects')">Projects</p>
                                    <p class="text-lg sm:text-2xl font-bold text-accent dark:text-accent-light">
                                        <span x-data="counter({{ $projects->count() }})" x-text="value + suffix"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="surface w-full p-3 sm:px-5 sm:py-4">
                            <div class="flex items-center gap-2 sm:gap-3">
                                <div class="surface-muted w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center shrink-0">
                                    <i class="ri-award-line text-accent dark:text-accent-light text-sm sm:text-base" aria-hidden="true"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[9px] sm:text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 truncate" x-text="t('certificates')">Certificates</p>
                                    <p class="text-lg sm:text-2xl font-bold text-accent dark:text-accent-light">
                                        <span x-data="counter({{ $certificates->count() }})" x-text="value + suffix"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row lg:flex-col gap-2 w-full max-w-xs sm:max-w-sm lg:w-full">
                        <x-btn :href="$cvUrl" target="_blank" icon="ri-download-2-line" size="md" class="w-full">
                            <span x-text="t('downloadCv')">Download CV</span>
                        </x-btn>
                        <x-btn href="#proyek" variant="secondary" icon="ri-eye-line" size="md" class="w-full"
                            x-on:click.prevent="scrollToSection($event, '#proyek')">
                            <span x-text="t('viewProjects')">Lihat Proyek</span>
                        </x-btn>
                    </div>

                    <div class="flex items-center gap-2 justify-center lg:justify-end w-full">
                        @foreach ($socials as $social)
                            <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer"
                                aria-label="{{ $social['label'] }}" class="icon-btn w-9 h-9">
                                <i class="{{ $social['icon'] }} text-lg" aria-hidden="true"></i>
                            </a>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="relative z-10 scroll-mt-24 sm:scroll-mt-28 overflow-hidden py-10" id="skills" data-aos="fade-up">
        <div class="py-4 sm:py-6">
            @php
                $toolsArray = $tools->values()->toArray();
                $half = ceil(count($toolsArray) / 2);
                $row1 = array_slice($toolsArray, 0, $half);
                $row2 = array_slice($toolsArray, $half);
            @endphp

            <div class="relative mb-3 sm:mb-4 py-2 overflow-hidden">
                <div class="animate-marquee-right flex gap-3 sm:gap-4 whitespace-nowrap">
                    @foreach (array_merge($row1, $row1) as $tool)
                        <div class="surface surface-interactive p-3 sm:p-4 flex items-center gap-3 sm:gap-4 shrink-0">
                            <div class="surface-muted w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center shrink-0">
                                <img src="{{ img_url($tool['gambar'] ?? '') }}" alt="{{ $tool['nama'] }}"
                                    class="w-6 h-6 sm:w-7 sm:h-7 object-contain" loading="lazy">
                            </div>
                            <div class="min-w-0">
                                <h4 class="font-semibold text-xs sm:text-sm text-slate-900 dark:text-white truncate">{{ $tool['nama'] }}</h4>
                                <p class="text-[10px] sm:text-xs text-slate-500 dark:text-slate-400 truncate">{{ $tool['ket'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="relative py-2 overflow-hidden">
                <div class="animate-marquee-left flex gap-3 sm:gap-4 whitespace-nowrap">
                    @foreach (array_merge($row2, $row2) as $tool)
                        <div class="surface surface-interactive p-3 sm:p-4 flex items-center gap-3 sm:gap-4 shrink-0">
                            <div class="surface-muted w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center shrink-0">
                                <img src="{{ img_url($tool['gambar'] ?? '') }}" alt="{{ $tool['nama'] }}"
                                    class="w-6 h-6 sm:w-7 sm:h-7 object-contain" loading="lazy">
                            </div>
                            <div class="min-w-0">
                                <h4 class="font-semibold text-xs sm:text-sm text-slate-900 dark:text-white truncate">{{ $tool['nama'] }}</h4>
                                <p class="text-[10px] sm:text-xs text-slate-500 dark:text-slate-400 truncate">{{ $tool['ket'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 scroll-mt-20" id="tentang" data-aos="fade-up">
        <div class="max-w-3xl mx-auto px-4">
            <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white mb-8 text-center" x-text="t('aboutMe')">About Me</h2>
            <div class="surface p-6 sm:p-8">
                <p class="prose-measure mx-auto text-slate-600 dark:text-slate-300 leading-relaxed mb-6" x-html='L(@json($about1Html), @json($about1IdnHtml))'></p>
                <p class="prose-measure mx-auto text-slate-600 dark:text-slate-300 leading-relaxed" x-text='L(@json($about2), @json($about2Idn))'></p>
            </div>
        </div>
    </section>

    <section class="py-14 sm:py-20 relative z-10 scroll-mt-24 sm:scroll-mt-28 overflow-x-clip" id="proyek">
        <div class="text-center mb-10 sm:mb-12" data-aos="fade-up">
            <h2 class="font-poppins text-2xl sm:text-4xl font-bold tracking-tight leading-[1.2] text-slate-900 dark:text-white">
                <span x-text="t('recentProjects')">Recent Projects</span>
            </h2>
            <p class="mt-2 sm:mt-3 mx-auto text-xs sm:text-[0.95rem] text-slate-600 dark:text-slate-400 max-w-lg px-4"
                x-text="t('projectsSubtitle')">Click on any project to see full details</p>
        </div>

        <div class="relative max-w-6xl mx-auto px-4" data-aos="fade-up" data-aos-delay="100">
            <div x-data="projectGallery({{ json_encode($categories->map(fn($c) => ['id' => $c->id, 'nama' => $c->nama])->values()) }})">

                <div class="flex flex-wrap justify-center gap-1.5 sm:gap-2 mb-6 sm:mb-8">
                    <button type="button" @click="setCategory('all')"
                        class="btn btn-sm rounded-full"
                        :aria-pressed="category === 'all'"
                        :class="category === 'all' ? 'btn-primary' : 'btn-secondary'">
                        <span x-text="t('all')">All</span>
                    </button>
                    <template x-for="c in categories" :key="c.id">
                        <button type="button" @click="setCategory(c.id)"
                            class="btn btn-sm rounded-full"
                            :aria-pressed="category === c.id"
                            :class="category === c.id ? 'btn-primary' : 'btn-secondary'"
                            x-text="c.nama"></button>
                    </template>
                </div>

                <div x-ref="track"
                    class="grid grid-flow-col grid-rows-2 gap-4 sm:gap-6 overflow-x-auto scrollbar-none snap-x snap-mandatory pt-2 pb-5 auto-cols-[100%] sm:auto-cols-[calc(50%-0.75rem)] lg:auto-cols-[calc(33.333%-1rem)] scroll-smooth">
                    <template x-for="p in visibleProjects" :key="p.id">
                        <a :href="p.url"
                            class="surface surface-interactive focus-ring block overflow-hidden group snap-start w-full min-w-0">
                            <div class="relative overflow-hidden border-b border-line dark:border-white/10">
                                <img x-show="p.img" :src="p.img" :alt="p.nama"
                                    class="w-full aspect-video object-cover transition-transform duration-500 group-hover:scale-105"
                                    loading="lazy">
                                <template x-if="!p.img">
                                    <div class="w-full aspect-video flex items-center justify-center bg-slate-100 dark:bg-white/5">
                                        <span class="text-5xl font-bold text-accent/50 dark:text-accent-light/50"
                                            x-text="(p.nama || 'P').charAt(0).toUpperCase()"></span>
                                    </div>
                                </template>
                                <div class="absolute bottom-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold px-3 py-1.5 rounded-full bg-white text-slate-800 border border-line dark:bg-slate-900 dark:text-white dark:border-white/10 shadow-sm"><i class="ri-eye-line mr-1" aria-hidden="true"></i><span x-text="t('view')">View</span></span>
                                </div>
                            </div>
                            <div class="p-4 sm:p-5">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-[10px] font-semibold text-accent dark:text-accent-light tracking-wider" x-text="'#' + String(p.id).padStart(2, '0')"></span>
                                    <span class="w-1 h-1 rounded-full bg-slate-400 dark:bg-slate-500"></span>
                                    <span class="text-[10px] uppercase tracking-wider text-slate-500 dark:text-slate-400" x-text="t('project')">Project</span>
                                </div>
                                <h3 class="text-sm sm:text-base font-bold text-slate-900 dark:text-white mb-2 group-hover:text-accent dark:group-hover:text-accent-light transition-colors line-clamp-1" x-text="p.nama"></h3>
                                <p class="text-[11px] sm:text-xs text-slate-600 dark:text-slate-400 mb-3 line-clamp-2 leading-relaxed" x-text="L(p.desk, p.deskIdn)"></p>
                                <div class="flex flex-wrap gap-1.5">
                                    <template x-for="tool in p.tools" :key="tool">
                                        <span class="chip" x-text="tool"></span>
                                    </template>
                                </div>
                            </div>
                        </a>
                    </template>
                </div>
                <div class="flex justify-center items-center gap-2 mt-6">
                    <template x-for="i in pages" :key="i">
                        <button @click="go(i)" class="h-1.5 rounded-full transition-all duration-300 cursor-pointer border-0"
                            :class="current === i ? 'bg-accent w-6' : 'bg-slate-300 dark:bg-white/15 w-2 hover:bg-slate-400 dark:hover:bg-white/25'"
                            :aria-label="'Go to page ' + i"></button>
                    </template>
                </div>
            </div>
        </div>
    </section>

    <section class="py-10 sm:py-20 relative z-10 scroll-mt-24 sm:scroll-mt-28 overflow-x-clip" id="experiences">
        <div class="text-center mb-10 sm:mb-14" data-aos="fade-up">
            <h2 class="font-poppins text-2xl sm:text-4xl font-bold tracking-tight leading-[1.2] text-slate-900 dark:text-white">
                <span class="inline-block pb-2" x-text="t('myExperience')">My Experience</span>
            </h2>
            <p class="mt-2 sm:mt-3 mx-auto text-xs sm:text-[0.95rem] text-slate-600 dark:text-slate-400 max-w-lg px-4"
                x-text="t('experiencesSubtitle')">Click on any experience to see the full details</p>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative">

                <!-- Garis vertikal -->
                <div class="absolute left-4 sm:left-6 top-1 bottom-1 w-[1px] bg-linear-to-b from-accent via-slate-300 dark:via-white/15 to-transparent" aria-hidden="true"></div>

                <template x-for="(e, i) in experiences" :key="e.id">
                    <div class="relative pl-10 sm:pl-16 mb-6 sm:mb-8 last:mb-0" data-aos="fade-up" :data-aos-delay="i * 50">
                        <span class="absolute left-4 sm:left-6 top-10 sm:top-12 -translate-x-1/2 w-3 h-3 rounded-full border-[3px] border-canvas dark:border-canvas-dark transition-all duration-300"
                            :class="i === 0 ? 'bg-accent' : 'bg-slate-400 dark:bg-slate-500'"></span>

                        <a :href="e.url" class="focus-ring block group w-full">
                            <div class="surface surface-interactive p-5 sm:p-6">

                                <div class="flex items-start gap-3 sm:gap-4">
                                    <span class="surface-muted w-11 h-11 sm:w-12 sm:h-12 shrink-0 overflow-hidden flex items-center justify-center font-poppins font-bold text-base text-accent dark:text-accent-light">
                                        <img x-show="e.img" :src="e.img" :alt="e.company" class="w-full h-full object-cover" loading="lazy">
                                        <template x-if="!e.img">
                                            <span x-text="(e.company || '?').charAt(0).toUpperCase()"></span>
                                        </template>
                                    </span>
                                    <div class="min-w-0 flex-1">
                                        <h3 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white group-hover:text-accent dark:group-hover:text-accent-light transition-colors leading-snug" x-text="L(e.role, e.roleIdn)"></h3>
                                        <p class="mt-1 text-xs sm:text-[13px] font-semibold text-accent dark:text-accent-light truncate" x-text="e.company"></p>
                                    </div>
                                </div>

                                <div class="mt-3 flex flex-wrap items-center gap-x-4 gap-y-1.5 text-xs text-slate-500 dark:text-slate-400">
                                    <span class="inline-flex items-center gap-1.5 font-medium">
                                        <i class="ri-calendar-line text-accent dark:text-accent-light" aria-hidden="true"></i><span x-text="e.duration"></span>
                                    </span>
                                    <template x-if="e.location">
                                        <span class="inline-flex items-center gap-1.5 font-medium">
                                            <i class="ri-map-pin-line" aria-hidden="true"></i><span x-text="e.location"></span>
                                        </span>
                                    </template>
                                </div>

                                <template x-if="e.desc">
                                    <p class="mt-3 text-sm text-slate-700 dark:text-slate-300 leading-relaxed line-clamp-2" x-text="L(e.desc, e.descIdn)"></p>
                                </template>

                                <div class="mt-4 flex items-center justify-between gap-3">
                                    <template x-if="e.skills && e.skills.length > 0">
                                        <div class="flex flex-wrap items-center gap-1.5 min-w-0">
                                            <template x-for="(s, si) in e.skills.slice(0, 3)" :key="si">
                                                <span class="chip" x-text="s"></span>
                                            </template>
                                            <template x-if="e.skills.length > 3">
                                                <span class="chip" x-text="'+' + (e.skills.length - 3)"></span>
                                            </template>
                                        </div>
                                    </template>
                                    <span class="shrink-0 inline-flex items-center gap-1 text-xs font-semibold text-slate-600 dark:text-slate-400 group-hover:text-accent dark:group-hover:text-accent-light transition-colors">
                                        <span x-text="t('viewDetails')">View Details</span>
                                        <i class="ri-arrow-right-up-line" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                </template>
            </div>
        </div>
    </section>

    <section class="py-14 sm:py-20 relative z-10 scroll-mt-24 sm:scroll-mt-28 overflow-x-clip" id="certificates">
        <div class="text-center mb-10 sm:mb-12" data-aos="fade-up">
            <h2 class="font-poppins text-2xl sm:text-4xl font-bold tracking-tight leading-[1.2] text-slate-900 dark:text-white">
                <span class="inline-block pb-2" x-text="t('certificatesAwards')">Certificates & Awards</span>
            </h2>
            <p class="mt-2 sm:mt-3 mx-auto text-xs sm:text-[0.95rem] text-slate-600 dark:text-slate-400 max-w-lg px-4"
                x-text="t('certificatesSubtitle')">Click on any certificate to see full details</p>
        </div>

        <div class="relative max-w-6xl mx-auto px-4" data-aos="fade-up" data-aos-delay="100">
            <div x-data="carousel({{ $certificates->count() }})">
                <div x-ref="track"
                    class="grid grid-flow-col grid-rows-2 gap-4 sm:gap-6 overflow-x-auto scrollbar-none snap-x snap-mandatory pt-2 pb-5 auto-cols-[100%] sm:auto-cols-[calc(50%-0.75rem)] lg:auto-cols-[calc(33.333%-1rem)] scroll-smooth">
                    <template x-for="c in certificates" :key="c.id">
                        <a :href="c.url"
                            class="surface surface-interactive focus-ring overflow-hidden flex flex-col group snap-start w-full min-w-0">
                            <div class="relative h-44 sm:h-56 w-full shrink-0 border-b border-line dark:border-white/10 overflow-hidden bg-surface-muted dark:bg-white/[0.03]">
                                <img :src="c.img" :alt="c.nama"
                                    class="w-full h-full object-contain p-4 transition-transform duration-500 group-hover:scale-105"
                                    loading="lazy">
                                <div class="absolute bottom-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold px-3 py-1.5 rounded-full bg-white text-slate-800 border border-line dark:bg-slate-900 dark:text-white dark:border-white/10 shadow-sm"><i class="ri-eye-line mr-1" aria-hidden="true"></i><span x-text="t('view')">View</span></span>
                                </div>
                            </div>
                            <div class="flex flex-1 flex-col p-4 sm:p-5">
                                <h3 class="font-bold text-slate-900 dark:text-white text-sm group-hover:text-accent dark:group-hover:text-accent-light transition-colors leading-snug line-clamp-2"
                                    x-text="L(c.nama, c.namaIdn)"></h3>
                                <div class="mt-auto pt-3 flex items-center justify-between gap-2 text-[10px] text-slate-500 dark:text-slate-400 font-semibold uppercase tracking-wide">
                                    <span class="truncate" x-text="c.penerbit"></span>
                                    <span class="flex items-center gap-1 shrink-0 normal-case"><i class="ri-calendar-line" aria-hidden="true"></i><span x-text="c.tanggal"></span></span>
                                </div>
                            </div>
                        </a>
                    </template>
                </div>
                <div class="flex justify-center items-center gap-2 mt-6">
                    <template x-for="i in pages" :key="i">
                        <button @click="go(i)" class="h-1.5 rounded-full transition-all duration-300 cursor-pointer border-0"
                            :class="current === i ? 'bg-accent w-6' : 'bg-slate-300 dark:bg-white/15 w-2 hover:bg-slate-400 dark:hover:bg-white/25'"
                            :aria-label="'Go to page ' + i"></button>
                    </template>
                </div>
            </div>
        </div>
    </section>

    <section class="py-14 sm:py-20 relative z-10 scroll-mt-24 sm:scroll-mt-28 overflow-x-clip" id="kontak">
        <div class="text-center mb-10 sm:mb-12" data-aos="fade-up">
            <h2 class="font-poppins text-2xl sm:text-4xl font-bold tracking-tight leading-[1.2] text-slate-900 dark:text-white">
                <span class="inline-block pb-2" x-text="t('letsTalk')">Let's Talk</span>
            </h2>
            <p class="mt-2 sm:mt-3 mx-auto text-xs sm:text-[0.95rem] text-slate-600 dark:text-slate-400 max-w-lg px-4"
                x-text="t('contactSubtitle')">Have a project in mind or just want to say hi? Feel free to reach out directly!</p>
        </div>

        <div class="max-w-5xl mx-auto text-center px-4 sm:px-6 lg:px-8" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
            <div class="surface relative overflow-hidden p-6 sm:p-10 md:p-12">
                <div class="absolute inset-0 pointer-events-none"
                    style="background: radial-gradient(70% 60% at 50% 0%, rgb(59 130 246 / 0.08), transparent 72%);"></div>
                <div class="relative z-10">
                    <p class="text-sm sm:text-base md:text-lg text-slate-700 dark:text-slate-300 mb-8 leading-relaxed max-w-xl mx-auto"
                        x-text="t('contactBody')">
                        I am always open to discussing new projects, collaboration opportunities, or just to say hi. Send your email and I will respond as soon as possible!
                    </p>
                    <x-btn :href="'mailto:' . $email" size="lg" icon="ri-mail-send-line" class="rounded-full">
                        {{ $email }}
                    </x-btn>
                </div>
            </div>
        </div>
    </section>
@endsection
