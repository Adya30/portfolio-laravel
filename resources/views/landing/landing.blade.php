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
                '<strong class="font-bold text-slate-900 dark:text-white">' . e($profileName) . '</strong>',
                $about1Html,
            );
        }

        $about1IdnHtml = $about1Idn ? e($about1Idn) : null;
        if ($about1IdnHtml && $profileName !== '' && str_contains($about1IdnHtml, e($profileName))) {
            $about1IdnHtml = str_replace(
                e($profileName),
                '<strong class="font-bold text-slate-900 dark:text-white">' . e($profileName) . '</strong>',
                $about1IdnHtml,
            );
        }
    @endphp

    <script>
        window.portfolioData = @json($portfolioData);
        window.githubData = @json($githubData);
        window.githubUsername = @json($githubUsername);
        window.heroQuote = {
            en: @json($profile?->hero_quote),
            idn: @json($profile?->hero_quote_idn),
            defaultEn: 'Code is like humor. When you have to explain it, it\u2019s bad. Build with passion, learn with coding.',
            defaultIdn: 'Kode itu seperti humor. Ketika harus dijelaskan, artinya buruk. Bangun dengan semangat, belajar sambil ngoding.'
        };
    </script>

    <style>
        @keyframes marquee-left {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        @keyframes marquee-right {
            0% {
                transform: translateX(-50%);
            }

            100% {
                transform: translateX(0);
            }
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
        class="relative z-10 flex flex-col justify-start pt-20 sm:pt-22 lg:pt-24 pb-2 sm:pb-3 scroll-mt-24 sm:scroll-mt-28 overflow-x-clip">
        <div class="w-[calc(100%-2.5rem)] max-w-6xl mx-auto">

            <div class="relative bg-white dark:bg-[#0f172a] rounded-[28px] sm:rounded-[36px] lg:rounded-3xl border border-slate-200/80 dark:border-white/10 shadow-[0_15px_35px_-12px_rgba(0,0,0,0.06)] dark:shadow-[0_15px_35px_-12px_rgba(0,0,0,0.6)] px-6 pt-3.5 pb-8 sm:px-10 sm:pt-4 sm:pb-10 lg:px-12 lg:pt-4 lg:pb-0 xl:px-14 xl:pt-5 xl:pb-0 overflow-hidden w-full"
                data-aos="fade-up">

                <div class="flex lg:hidden flex-col items-center relative mb-6 w-full">
                    <div class="relative flex justify-center items-end">
                        <img src="{{ $heroImage }}" alt="{{ $profileName }} - Full Stack Web Developer & UI Designer Portfolio" title="{{ $profileName }}" width="750" height="auto"
                            fetchpriority="high" decoding="async"
                            class="w-auto h-52 sm:h-64 max-w-[260px] sm:max-w-[300px] object-contain object-bottom drop-shadow-md">
                    </div>

                    <div
                        class="inline-flex items-center gap-3 px-5 sm:px-6 py-2.5 sm:py-3 rounded-2xl sm:rounded-3xl border border-slate-300 dark:border-white/20 bg-white dark:bg-[#1e293b] shadow-md -mt-5 sm:-mt-6 z-20 relative max-w-full">
                        <img src="{{ asset('images/icons/quote.png') }}" alt=""
                            class="w-4.5 sm:w-5.5 h-auto shrink-0 dark:invert object-contain select-none"
                            aria-hidden="true">
                        <p class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white leading-snug text-center">
                            <span x-text="L(heroQuote.en || heroQuote.defaultEn, heroQuote.idn || heroQuote.defaultIdn)">
                                Every bug is a lesson, every commit is progress.
                            </span>
                        </p>
                    </div>
                </div>

                <div
                    class="flex flex-col lg:flex-row items-center lg:items-end justify-between gap-6 lg:gap-8 xl:gap-10 relative">

                    <div
                        class="w-full lg:flex-1 lg:max-w-xl xl:max-w-2xl flex flex-col items-center text-center lg:items-start lg:text-left z-10 lg:pb-6 xl:pb-8">
                        <div
                            class="hidden lg:inline-flex items-center gap-3 sm:gap-3.5 px-5 sm:px-6 py-2.5 sm:py-3 rounded-2xl sm:rounded-3xl border border-slate-300 dark:border-white/20 bg-white dark:bg-white/5 mb-4 sm:mb-5 lg:mb-6 max-w-full shadow-sm">
                            <img src="{{ asset('images/icons/quote.png') }}" alt=""
                                class="w-5 sm:w-5.5 h-auto shrink-0 dark:invert object-contain select-none"
                                aria-hidden="true">
                            <p class="text-sm sm:text-base font-bold text-slate-900 dark:text-white leading-snug">
                                <span
                                    x-text="L(heroQuote.en || heroQuote.defaultEn, heroQuote.idn || heroQuote.defaultIdn)">
                                    Every bug is a lesson, every commit is progress.
                                </span>
                            </p>
                        </div>

                        <h1
                            class="font-poppins font-extrabold text-3xl py-2 sm:text-4xl md:text-5xl lg:text-[40px] xl:leading-tight tracking-tight mb-2 sm:mb-2.5">
                            <span class="hero-name-gradient inline-block bg-clip-text text-transparent">
                                {{ $profileName }}
                            </span>
                        </h1>

                        <h2 class="text-lg sm:text-xl lg:text-2xl font-bold text-slate-800 dark:text-slate-100 tracking-tight mb-2.5 sm:mb-3"
                            x-text='L(@json($roleTitle), @json($roleTitleIdn))'>
                            {{ $roleTitle }}
                        </h2>

                        <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 font-normal leading-relaxed max-w-lg mb-6 sm:mb-7"
                            x-text='L(@json($tagline), @json($taglineIdn))'>
                            {{ $tagline }}
                        </p>

                        <div class="flex flex-wrap items-center justify-center lg:justify-start gap-3 sm:gap-3.5">
                            <a href="{{ $cvUrl }}" target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center justify-center gap-2 px-5 sm:px-6 py-2.5 sm:py-3 rounded-xl sm:rounded-2xl bg-orange-500 hover:bg-orange-600 active:scale-95 text-white font-bold text-xs sm:text-sm dark:transition-all select-none cursor-pointer">
                                <span x-text="t('downloadCv')">Download CV</span>
                                <img src="{{ asset('images/icons/download.png') }}" alt=""
                                    class="w-4 h-4 sm:w-4.5 sm:h-4.5 shrink-0 object-contain select-none"
                                    aria-hidden="true">
                            </a>

                            <a href="#proyek" @click.prevent="scrollToSection($event, '#proyek')"
                                class="inline-flex items-center justify-center gap-2 px-5 sm:px-6 py-2.5 sm:py-3 rounded-xl sm:rounded-2xl bg-blue-500 hover:bg-blue-600 active:scale-95 text-white font-bold text-xs sm:text-sm dark:transition-all select-none cursor-pointer">
                                <span x-text="t('viewProjects')">View Projects</span>
                                <img src="{{ asset('images/icons/project.png') }}" alt=""
                                    class="w-4 h-4 sm:w-4.5 sm:h-4.5 shrink-0 object-contain select-none"
                                    aria-hidden="true">
                            </a>
                        </div>
                    </div>

                    <div
                        class="hidden lg:flex items-end justify-end gap-3 sm:gap-4 lg:gap-6 self-end z-10 w-full lg:w-auto">

                        <div class="relative flex justify-center items-end self-end">
                            <img src="{{ $heroImage }}" alt="{{ $profileName }} - Full Stack Web Developer & UI Designer Portfolio" title="{{ $profileName }}" width="750" height="auto"
                                fetchpriority="high" decoding="async"
                                class="w-auto h-auto max-h-[360px] lg:max-h-[430px] xl:max-h-[460px] object-contain object-bottom drop-shadow-md origin-bottom block -mb-px">
                        </div>

                        <div class="flex flex-col gap-5 xl:gap-6 shrink-0 self-center mb-8 xl:mb-10 z-20 ml-2 xl:ml-4">
                            @foreach ($socials as $social)
                                <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer"
                                    aria-label="{{ $social['label'] }}"
                                    class="w-10 h-10 xl:w-11 xl:h-11 rounded-xl bg-white dark:bg-white/5 border border-slate-300 dark:border-white/20 flex items-center justify-center text-slate-800 dark:text-white hover:text-orange-500 dark:hover:text-orange-400 hover:border-orange-500/50 hover:scale-105 active:scale-95 transition-all text-lg xl:text-xl cursor-pointer">
                                    <i class="{{ $social['icon'] }}" aria-hidden="true"></i>
                                </a>
                            @endforeach
                        </div>

                    </div>

                </div>

                <div
                    class="flex lg:hidden items-center justify-center gap-4 sm:gap-5 pt-6 mt-6 sm:mt-8 border-t border-slate-100 dark:border-white/5 w-full z-20 relative">
                    @foreach ($socials as $social)
                        <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer"
                            aria-label="{{ $social['label'] }}"
                            class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-white dark:bg-white/5 border border-slate-300 dark:border-white/20 flex items-center justify-center text-slate-800 dark:text-white hover:text-orange-500 dark:hover:text-orange-400 hover:border-orange-500/50 active:scale-95 transition-all text-lg sm:text-xl cursor-pointer">
                            <i class="{{ $social['icon'] }}" aria-hidden="true"></i>
                        </a>
                    @endforeach
                </div>

            </div>

        </div>
    </section>

    <section class="relative z-10 scroll-mt-24 sm:scroll-mt-28 overflow-hidden pt-0 pb-2 sm:pb-3" data-aos="fade-up">
        <div class="py-1">
            @php
                $toolsArray = $tools->values()->toArray();
                $half = ceil(count($toolsArray) / 2);
                $row1 = array_slice($toolsArray, 0, $half);
                $row2 = array_slice($toolsArray, $half);
            @endphp

            <div class="relative mb-3.5 py-1 overflow-hidden">
                <div class="animate-marquee-right flex gap-4 sm:gap-5 whitespace-nowrap">
                    @foreach (array_merge($row1, $row1) as $tool)
                        <div
                            class="bg-white dark:bg-[#1e293b] border border-slate-200/90 dark:border-white/10 px-5 py-3 sm:px-6 sm:py-3.5 rounded-2xl flex items-center gap-3.5 sm:gap-4 shrink-0 min-w-[190px] sm:min-w-[220px] shadow-none hover:border-slate-300 dark:hover:border-white/20 transition-all select-none">
                            <div
                                class="surface-muted w-12 h-12 sm:w-14 sm:h-14 rounded-xl flex items-center justify-center shrink-0">
                                <img src="{{ img_url($tool['gambar'] ?? '') }}" alt="Keahlian {{ $tool['nama'] }} - Tech Stack" title="{{ $tool['nama'] }}"
                                    class="w-7 h-7 sm:w-8 sm:h-8 object-contain" loading="lazy" decoding="async">
                            </div>
                            <div class="min-w-0">
                                <h4
                                    class="font-bold text-sm sm:text-base lg:text-[17px] text-slate-900 dark:text-white truncate">
                                    {{ $tool['nama'] }}</h4>
                                <p class="text-xs sm:text-[13px] text-slate-500 dark:text-slate-400 truncate">
                                    {{ $tool['ket'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="relative py-1 overflow-hidden">
                <div class="animate-marquee-left flex gap-4 sm:gap-5 whitespace-nowrap">
                    @foreach (array_merge($row2, $row2) as $tool)
                        <div
                            class="bg-white dark:bg-[#1e293b] border border-slate-200/90 dark:border-white/10 px-5 py-3 sm:px-6 sm:py-3.5 rounded-2xl flex items-center gap-3.5 sm:gap-4 shrink-0 min-w-[190px] sm:min-w-[220px] shadow-none hover:border-slate-300 dark:hover:border-white/20 transition-all select-none">
                            <div
                                class="surface-muted w-12 h-12 sm:w-14 sm:h-14 rounded-xl flex items-center justify-center shrink-0">
                                <img src="{{ img_url($tool['gambar'] ?? '') }}" alt="Keahlian {{ $tool['nama'] }} - Tech Stack" title="{{ $tool['nama'] }}"
                                    class="w-7 h-7 sm:w-8 sm:h-8 object-contain" loading="lazy" decoding="async">
                            </div>
                            <div class="min-w-0">
                                <h4
                                    class="font-bold text-sm sm:text-base lg:text-[17px] text-slate-900 dark:text-white truncate">
                                    {{ $tool['nama'] }}</h4>
                                <p class="text-xs sm:text-[13px] text-slate-500 dark:text-slate-400 truncate">
                                    {{ $tool['ket'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="pt-2 sm:pt-3 pb-2 sm:pb-3 scroll-mt-24 sm:scroll-mt-28 relative z-10" id="tentang"
        data-aos="fade-up">
        <div class="w-[calc(100%-2.5rem)] max-w-6xl mx-auto">
            <div
                class="rounded-3xl border border-slate-200/90 dark:border-white/10 bg-white dark:bg-[#0f172a]/95 p-6 sm:p-10 lg:p-14 shadow-none">
                <div class="flex flex-col lg:flex-row items-center justify-between gap-8 lg:gap-12">

                    <div class="shrink-0 flex items-center justify-center w-full lg:w-auto order-1 lg:order-2">
                        <img src="{{ asset('images/icons/hand-wave.png') }}" alt="Waving Hand"
                            class="w-48 sm:w-60 md:w-68 lg:w-72 xl:w-80 h-auto object-contain select-none transition-transform duration-300 hover:rotate-6"
                            loading="lazy">
                    </div>

                    <div
                        class="w-full lg:flex-1 lg:max-w-2xl flex flex-col items-center lg:items-start order-2 lg:order-1">
                        <div class="inline-flex flex-col items-center lg:items-start mb-6 sm:mb-8">
                            <h2
                                class="text-3xl sm:text-4xl lg:text-[40px] font-extrabold tracking-tight font-poppins text-slate-900 dark:text-white text-center lg:text-left">
                                <span x-show="$store.lang.current === 'id'">Tentang <span
                                        class="text-orange-500">Saya</span></span>
                                <span x-show="$store.lang.current !== 'id'">About <span
                                        class="text-orange-500">Me</span></span>
                            </h2>
                            <div class="h-1.5 w-full bg-orange-500 rounded-full mt-4 sm:mt-5"></div>
                        </div>

                        <div
                            class="space-y-4 sm:space-y-5 text-sm sm:text-base text-slate-700 dark:text-slate-300 leading-relaxed font-normal text-center lg:text-left">
                            <p x-html='L(@json($about1Html), @json($about1IdnHtml))'></p>
                            <p x-text='L(@json($about2), @json($about2Idn))'></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>


    <section class="pt-2 sm:pt-3 pb-2 sm:pb-3 relative z-10 scroll-mt-24 sm:scroll-mt-28" id="github-activity">
        <div class="w-[calc(100%-2.5rem)] max-w-6xl mx-auto" data-aos="fade-up" x-data="githubCalendar()">

            <div
                class="rounded-2xl sm:rounded-3xl border border-slate-200/90 dark:border-white/10 bg-white dark:bg-[#0f172a] p-4 sm:p-6 lg:p-7 relative shadow-none">

                <div class="mb-4 sm:mb-5 select-none pb-3 border-b border-slate-200/80 dark:border-white/10">
                    <h3 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white leading-tight">
                        <span x-text="totalContributions">639</span>
                        <span x-text="' ' + t('contributionsInLastYear')"> contributions in the last year</span>
                    </h3>
                </div>

                <div x-ref="calendarScroll" class="overflow-x-auto scrollbar-none pb-2 pt-1 scroll-smooth w-full">
                    <div class="w-full min-w-[700px]">
                        <div
                            class="flex text-[11px] font-semibold text-slate-500 dark:text-slate-400 mb-1.5 select-none relative h-4">
                            <span class="w-6 sm:w-7 shrink-0 mr-2"></span>
                            <div class="relative flex-1">
                                <template x-for="m in monthLabels" :key="m.month + m.weekIndex">
                                    <span class="absolute" :style="`left: ${(m.weekIndex / (weeks.length || 53)) * 100}%`"
                                        x-text="m.month"></span>
                                </template>
                            </div>
                        </div>

                        <div class="flex gap-2 items-stretch w-full">
                            <div
                                class="grid grid-rows-7 gap-[2px] sm:gap-[3px] text-[10px] font-semibold text-slate-400 dark:text-slate-500 select-none w-6 sm:w-7 shrink-0 text-right pr-1">
                                <span class="flex items-center justify-end opacity-0">Sun</span>
                                <span class="flex items-center justify-end">Mon</span>
                                <span class="flex items-center justify-end opacity-0">Tue</span>
                                <span class="flex items-center justify-end">Wed</span>
                                <span class="flex items-center justify-end opacity-0">Thu</span>
                                <span class="flex items-center justify-end">Fri</span>
                                <span class="flex items-center justify-end opacity-0">Sat</span>
                            </div>

                            <div class="flex-1 flex justify-between gap-[2px] sm:gap-[3px]">
                                <template x-for="(week, wIdx) in weeks" :key="wIdx">
                                    <div class="flex-1 grid grid-rows-7 gap-[2px] sm:gap-[3px]">
                                        <template x-for="(day, dIdx) in week" :key="dIdx">
                                            <div class="w-full aspect-square rounded-[2px] sm:rounded-[2.5px] transition-transform duration-150 hover:scale-125 cursor-pointer"
                                                :class="getCellColor(day)" @mouseenter="showCellTooltip($event, day)"
                                                @mouseleave="hideCellTooltip()">
                                            </div>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div
                            class="flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500 dark:text-slate-400 mt-5 pt-3.5 border-t border-slate-200/70 dark:border-white/5 select-none pl-8 sm:pl-9">
                            <a :href="'https://github.com/' + username" target="_blank" rel="noopener noreferrer"
                                class="hover:text-orange-500 dark:hover:text-orange-400 transition-colors inline-flex items-center gap-1 font-medium focus:outline-none">
                                <span x-text="t('learnHowCount')">Learn how we count contributions</span>
                                <i class="ri-arrow-right-up-line text-xs" aria-hidden="true"></i>
                            </a>

                            <div class="flex items-center gap-1.5">
                                <span x-text="t('less')">Less</span>
                                <div class="flex items-center gap-1">
                                    <div class="w-[11px] h-[11px] rounded-[2px] bg-slate-200/90 dark:bg-[#162032]"></div>
                                    <div class="w-[11px] h-[11px] rounded-[2px] bg-[#0e4429]"></div>
                                    <div class="w-[11px] h-[11px] rounded-[2px] bg-[#006d32]"></div>
                                    <div class="w-[11px] h-[11px] rounded-[2px] bg-[#26a641]"></div>
                                    <div class="w-[11px] h-[11px] rounded-[2px] bg-[#39d353]"></div>
                                </div>
                                <span x-text="t('more')">More</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div x-show="tooltip.show" x-cloak
                    class="fixed z-[999] pointer-events-none px-2.5 py-1.5 rounded-lg bg-slate-900/95 dark:bg-black/95 text-white text-xs font-medium shadow-xl border border-white/10 backdrop-blur -translate-x-1/2 -translate-y-full mb-2 transition-all duration-75 whitespace-nowrap"
                    :style="`top: ${tooltip.y - 8}px; left: ${tooltip.x}px;`">
                    <span x-text="tooltip.text"></span>
                </div>

            </div>

        </div>
    </section>

    <section class="pt-2 sm:pt-3 pb-2 sm:pb-3 scroll-mt-24 sm:scroll-mt-28 relative z-10" id="proyek"
        data-aos="fade-up">
        <div class="w-[calc(100%-2.5rem)] max-w-6xl mx-auto">
            <div class="rounded-3xl border border-slate-200/90 dark:border-white/10 bg-white dark:bg-[#0f172a]/95 p-6 sm:p-10 lg:p-12 shadow-none"
                x-data="projectGallery({{ json_encode($categories->map(fn($c) => ['id' => $c->id, 'nama' => $c->nama])->values()) }})">

                <div class="flex flex-col items-center justify-center text-center mb-6 sm:mb-8">
                    <div class="inline-flex flex-col items-center">
                        <h2
                            class="text-3xl sm:text-4xl lg:text-[40px] font-extrabold tracking-tight font-poppins text-slate-900 dark:text-white">
                            <span x-show="$store.lang.current === 'id'"><span class="text-orange-500">Proyek</span>
                                Saya</span>
                            <span x-show="$store.lang.current !== 'id'"><span class="text-orange-500">My</span>
                                Projects</span>
                        </h2>
                        <div class="h-1.5 w-full bg-orange-500 rounded-full mt-4 sm:mt-5"></div>
                    </div>
                </div>

                <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-2.5 mb-8 sm:mb-10 select-none">
                    <button type="button" @click="setCategory('all')"
                        class="px-4 sm:px-5 py-2 sm:py-2.5 rounded-full text-xs sm:text-sm font-bold border transition-all duration-200 cursor-pointer active:scale-95"
                        :class="category === 'all'
                            ?
                            'bg-orange-500 text-white border-orange-500 shadow-sm' :
                            'bg-slate-100 dark:bg-white/5 border-slate-200/90 dark:border-white/10 text-slate-600 dark:text-slate-300 hover:border-orange-500/50 hover:text-orange-500 dark:hover:text-orange-400 hover:bg-slate-200/70 dark:hover:bg-white/10'">
                        <span x-text="t('all')">All</span>
                    </button>
                    <template x-for="c in categories" :key="c.id">
                        <button type="button" @click="setCategory(c.id)"
                            class="px-4 sm:px-5 py-2 sm:py-2.5 rounded-full text-xs sm:text-sm font-bold border transition-all duration-200 cursor-pointer active:scale-95"
                            :class="category === c.id ?
                                'bg-orange-500 text-white border-orange-500 shadow-sm' :
                                'bg-slate-100 dark:bg-white/5 border-slate-200/90 dark:border-white/10 text-slate-600 dark:text-slate-300 hover:border-orange-500/50 hover:text-orange-500 dark:hover:text-orange-400 hover:bg-slate-200/70 dark:hover:bg-white/10'"
                            x-text="c.nama"></button>
                    </template>
                </div>

                <div x-ref="track"
                    class="grid grid-flow-col grid-rows-2 gap-5 sm:gap-6 lg:gap-7 overflow-x-auto scrollbar-none snap-x snap-mandatory pt-1 pb-3 auto-cols-[100%] sm:auto-cols-[calc(50%-0.75rem)] lg:auto-cols-[calc(33.333%-1.17rem)] scroll-smooth">
                    <template x-for="p in visibleProjects" :key="p.id">
                        <a :href="p.url"
                            class="border border-slate-200/90 dark:border-white/10 bg-white dark:bg-[#1e293b] rounded-2xl overflow-hidden flex flex-col group snap-start w-full min-w-0 transition-all hover:border-slate-300 dark:hover:border-white/25 shadow-none">
                            <div class="relative overflow-hidden aspect-[16/10] bg-slate-100 dark:bg-white/5">
                                <img x-show="p.img" :src="p.img" :alt="'Proyek ' + p.nama + ' - Adya Portfolio'" :title="p.nama"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                    loading="lazy" decoding="async">
                                <template x-if="!p.img">
                                    <div class="w-full h-full flex items-center justify-center text-5xl font-bold text-slate-300 dark:text-white/20"
                                        x-text="(p.nama || 'P').charAt(0).toUpperCase()"></div>
                                </template>
                            </div>
                            <div class="p-5 sm:p-6 flex flex-col flex-1">
                                <h3 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white mb-2 leading-snug group-hover:text-orange-500 transition-colors line-clamp-1"
                                    x-text="p.nama"></h3>
                                <p class="text-xs sm:text-[13px] text-slate-600 dark:text-slate-400 mb-4 line-clamp-2 sm:line-clamp-3 leading-relaxed"
                                    x-text="L(p.desk, p.deskIdn)"></p>
                                <div class="flex flex-wrap items-center justify-center gap-2 mt-auto pt-2">
                                    <template x-for="tool in p.tools" :key="tool">
                                        <span
                                            class="rounded-full border border-slate-200 dark:border-white/15 px-3.5 py-1 text-xs text-slate-600 dark:text-slate-300 font-medium bg-white dark:bg-white/5"
                                            x-text="tool"></span>
                                    </template>
                                </div>
                            </div>
                        </a>
                    </template>
                </div>

                <div class="flex justify-center items-center gap-2.5 mt-8 sm:mt-10">
                    <template x-for="i in pages" :key="i">
                        <button @click="go(i)"
                            class="w-3.5 h-3.5 rounded-full transition-all duration-300 cursor-pointer border-0"
                            :class="current === i ? 'bg-orange-500 scale-105' :
                                'bg-slate-300 dark:bg-white/25 hover:bg-slate-400 dark:hover:bg-white/35'"
                            :aria-label="'Go to page ' + i"></button>
                    </template>
                </div>

            </div>
        </div>
    </section>

    <section class="pt-2 sm:pt-3 pb-2 sm:pb-3 relative z-10 scroll-mt-24 sm:scroll-mt-28" id="experiences">
        <div class="w-[calc(100%-2.5rem)] max-w-6xl mx-auto">
            <div class="rounded-3xl border border-slate-200/90 dark:border-white/10 bg-white dark:bg-[#0f172a]/95 p-6 sm:p-10 lg:p-12 shadow-none"
                data-aos="fade-up">

                <div class="flex flex-col items-center justify-center text-center mb-10 sm:mb-14">
                    <div class="inline-flex flex-col items-center">
                        <h2
                            class="text-3xl sm:text-4xl lg:text-[40px] font-extrabold tracking-tight font-poppins text-slate-900 dark:text-white">
                            <span x-show="$store.lang.current === 'id'"><span class="text-orange-500">Pengalaman</span>
                                Saya</span>
                            <span x-show="$store.lang.current !== 'id'"><span class="text-orange-500">My</span>
                                Experiences</span>
                        </h2>
                        <div class="h-1.5 w-full bg-orange-500 rounded-full mt-4 sm:mt-5"></div>
                    </div>
                </div>

                <div class="relative">
                    @foreach ($experiences as $i => $e)
                        @php
                            $isLeft = $loop->odd; // Item 1, 3, 5 on left; 2, 4 on right
                            $hasThumbnail = !empty($e->gambar);
                        @endphp

                        <div class="relative {{ !$loop->last ? 'mb-8 sm:mb-12 lg:mb-14' : '' }}" data-aos="fade-up">

                            <div class="hidden lg:flex items-center justify-between relative">

                                @if ($isLeft)
                                    <div class="w-[60%] z-10">
                                        <a href="{{ route('experience.show', $e) }}"
                                            class="group block border border-slate-200/90 dark:border-white/10 bg-white dark:bg-[#1e293b] hover:bg-slate-100/90 dark:hover:bg-[#162032] rounded-2xl p-4 sm:p-5 transition-all hover:border-slate-300 dark:hover:border-white/25 shadow-none">
                                            <div class="flex flex-row items-center gap-5 sm:gap-6">
                                                <div
                                                    class="w-32 h-32 sm:w-36 sm:h-36 xl:w-40 xl:h-40 aspect-square rounded-2xl overflow-hidden bg-slate-100/80 dark:bg-white/5 shrink-0 flex items-center justify-center p-2.5 sm:p-3">
                                                    @if ($hasThumbnail)
                                                        <img src="{{ img_url($e->gambar) }}"
                                                            alt="{{ $e->company ?? $e->role }}"
                                                            class="w-full h-full object-contain transition-transform duration-500 group-hover:scale-105"
                                                            loading="lazy">
                                                    @else
                                                        <div
                                                            class="w-full h-full flex items-center justify-center font-bold text-3xl text-orange-500 bg-orange-500/10">
                                                            {{ substr($e->company ?: ($e->role ?: 'E'), 0, 1) }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-1 min-w-0 flex flex-col items-start">
                                                    <h3
                                                        class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white leading-snug group-hover:text-slate-600 dark:group-hover:text-slate-300 transition-colors">
                                                        {{ $e->company ?: $e->role }}
                                                    </h3>
                                                    @if ($e->company && $e->role)
                                                        <p class="text-xs font-semibold text-orange-500 mt-0.5">
                                                            <span
                                                                x-text='L(@json($e->role), @json($e->role_idn))'>{{ $e->role }}</span>
                                                        </p>
                                                    @endif
                                                    <p class="text-xs sm:text-[13px] text-slate-600 dark:text-slate-400 mt-2 line-clamp-2 leading-relaxed"
                                                        x-text='L(@json($e->desk), @json($e->desk_idn))'>
                                                        {{ $e->desk }}
                                                    </p>
                                                    @if (!empty($e->skills))
                                                        <div class="flex flex-wrap items-center gap-2 mt-3 pt-1">
                                                            @foreach (array_slice($e->skills, 0, 4) as $skill)
                                                                <span
                                                                    class="rounded-full border border-slate-300 dark:border-white/20 px-3.5 py-0.5 text-xs text-slate-600 dark:text-slate-300 font-normal bg-white dark:bg-white/5">
                                                                    {{ $skill }}
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="w-[40%] pl-8 xl:pl-12 flex flex-col items-start z-10 relative">
                                        <div
                                            class="inline-flex items-center gap-2 text-sm lg:text-base font-semibold text-slate-700 dark:text-slate-300 select-none mb-3">
                                            <img src="{{ asset('images/icons/calendar.png') }}" alt=""
                                                class="w-4 h-4 object-contain shrink-0 dark:invert" aria-hidden="true">
                                            <span>{{ $e->duration }}</span>
                                        </div>
                                    </div>

                                    @if (!$loop->last)
                                        <div class="hidden lg:block absolute left-[60%] right-20 top-[calc(50%+16px)] -bottom-14 border-t-2 border-r-2 border-orange-500 pointer-events-none"
                                            aria-hidden="true"></div>
                                    @endif
                                @else
                                    <div class="w-[40%] pr-8 xl:pr-12 flex flex-col items-end text-right z-10 relative">
                                        <div
                                            class="inline-flex items-center gap-2 text-sm lg:text-base font-semibold text-slate-700 dark:text-slate-300 select-none mb-3">
                                            <img src="{{ asset('images/icons/calendar.png') }}" alt=""
                                                class="w-4 h-4 object-contain shrink-0 dark:invert" aria-hidden="true">
                                            <span>{{ $e->duration }}</span>
                                        </div>
                                    </div>

                                    <div class="w-[60%] z-10">
                                        <a href="{{ route('experience.show', $e) }}"
                                            class="group block border border-slate-200/90 dark:border-white/10 bg-white dark:bg-[#1e293b] hover:bg-slate-100/90 dark:hover:bg-[#162032] rounded-2xl p-4 sm:p-5 transition-all hover:border-slate-300 dark:hover:border-white/25 shadow-none">
                                            <div class="flex flex-row items-center gap-5 sm:gap-6">
                                                <div
                                                    class="w-32 h-32 sm:w-36 sm:h-36 xl:w-40 xl:h-40 aspect-square rounded-2xl overflow-hidden bg-slate-100/80 dark:bg-white/5 shrink-0 flex items-center justify-center p-2.5 sm:p-3">
                                                    @if ($hasThumbnail)
                                                        <img src="{{ img_url($e->gambar) }}"
                                                            alt="{{ $e->company ?? $e->role }}"
                                                            class="w-full h-full object-contain transition-transform duration-500 group-hover:scale-105"
                                                            loading="lazy">
                                                    @else
                                                        <div
                                                            class="w-full h-full flex items-center justify-center font-bold text-3xl text-orange-500 bg-orange-500/10">
                                                            {{ substr($e->company ?: ($e->role ?: 'E'), 0, 1) }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-1 min-w-0 flex flex-col items-start">
                                                    <h3
                                                        class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white leading-snug group-hover:text-slate-600 dark:group-hover:text-slate-300 transition-colors">
                                                        {{ $e->company ?: $e->role }}
                                                    </h3>
                                                    @if ($e->company && $e->role)
                                                        <p class="text-xs font-semibold text-orange-500 mt-0.5">
                                                            <span
                                                                x-text='L(@json($e->role), @json($e->role_idn))'>{{ $e->role }}</span>
                                                        </p>
                                                    @endif
                                                    <p class="text-xs sm:text-[13px] text-slate-600 dark:text-slate-400 mt-2 line-clamp-2 leading-relaxed"
                                                        x-text='L(@json($e->desk), @json($e->desk_idn))'>
                                                        {{ $e->desk }}
                                                    </p>
                                                    @if (!empty($e->skills))
                                                        <div class="flex flex-wrap items-center gap-2 mt-3 pt-1">
                                                            @foreach (array_slice($e->skills, 0, 4) as $skill)
                                                                <span
                                                                    class="rounded-full border border-slate-300 dark:border-white/20 px-3.5 py-0.5 text-xs text-slate-600 dark:text-slate-300 font-normal bg-white dark:bg-white/5">
                                                                    {{ $skill }}
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    @if (!$loop->last)
                                        <div class="hidden lg:block absolute right-[60%] left-20 top-[calc(50%+16px)] -bottom-14 border-t-2 border-l-2 border-orange-500 pointer-events-none"
                                            aria-hidden="true"></div>
                                    @endif
                                @endif

                            </div>

                            <div class="flex lg:hidden flex-col">
                                <div
                                    class="flex items-center gap-2 mb-2.5 text-xs font-semibold text-slate-900 dark:text-white">
                                    <img src="{{ asset('images/icons/calendar.png') }}" alt=""
                                        class="w-3.5 h-3.5 object-contain shrink-0 dark:invert" aria-hidden="true">
                                    <span>{{ $e->duration }}</span>
                                </div>
                                <a href="{{ route('experience.show', $e) }}"
                                    class="group block border border-slate-200/90 dark:border-white/10 bg-white dark:bg-[#1e293b] hover:bg-slate-100/90 dark:hover:bg-[#162032] rounded-2xl p-4 sm:p-5 transition-all hover:border-slate-300 dark:hover:border-white/25 shadow-none">
                                    <div class="flex flex-col">
                                        <div class="flex items-center gap-3.5 sm:gap-4 mb-3">
                                            <div
                                                class="w-12 h-12 sm:w-14 sm:h-14 aspect-square rounded-xl overflow-hidden bg-slate-100/80 dark:bg-white/5 shrink-0 flex items-center justify-center p-2 sm:p-2.5">
                                                @if ($hasThumbnail)
                                                    <img src="{{ img_url($e->gambar) }}"
                                                        alt="{{ $e->company ?? $e->role }}"
                                                        class="w-full h-full object-contain transition-transform duration-500 group-hover:scale-105"
                                                        loading="lazy">
                                                @else
                                                    <div
                                                        class="w-full h-full flex items-center justify-center font-bold text-xl sm:text-2xl text-orange-500 bg-orange-500/10 rounded-lg">
                                                        {{ substr($e->company ?: ($e->role ?: 'E'), 0, 1) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <h3
                                                    class="text-base sm:text-lg font-bold text-slate-900 dark:text-white leading-snug group-hover:text-slate-600 dark:group-hover:text-slate-300 transition-colors">
                                                    {{ $e->company ?: $e->role }}
                                                </h3>
                                                @if ($e->company && $e->role)
                                                    <p class="text-xs font-semibold text-orange-500 mt-0.5">
                                                        <span
                                                            x-text='L(@json($e->role), @json($e->role_idn))'>{{ $e->role }}</span>
                                                    </p>
                                                @endif
                                            </div>
                                        </div>

                                        <p class="text-xs sm:text-[13px] text-slate-600 dark:text-slate-400 mb-3 line-clamp-3 leading-relaxed"
                                            x-text='L(@json($e->desk), @json($e->desk_idn))'>
                                            {{ $e->desk }}
                                        </p>

                                        @if (!empty($e->skills))
                                            <div class="flex flex-wrap items-center gap-2 pt-0.5">
                                                @foreach (array_slice($e->skills, 0, 4) as $skill)
                                                    <span
                                                        class="rounded-full border border-slate-300 dark:border-white/20 px-3.5 py-0.5 text-xs text-slate-600 dark:text-slate-300 font-normal bg-white dark:bg-white/5">
                                                        {{ $skill }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </a>
                            </div>

                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </section>

    <section class="pt-2 sm:pt-3 pb-2 sm:pb-3 relative z-10 scroll-mt-24 sm:scroll-mt-28" id="certificates">
        <div class="w-[calc(100%-2.5rem)] max-w-6xl mx-auto">
            <div class="rounded-3xl border border-slate-200/90 dark:border-white/10 bg-white dark:bg-[#0f172a]/95 p-6 sm:p-10 lg:p-12 shadow-none"
                data-aos="fade-up">

                <div class="flex flex-col items-center justify-center text-center mb-8 sm:mb-10">
                    <div class="inline-flex flex-col items-center">
                        <h2
                            class="text-3xl sm:text-4xl lg:text-[40px] font-extrabold tracking-tight font-poppins text-slate-900 dark:text-white">
                            <span x-show="$store.lang.current === 'id'"><span class="text-orange-500">Sertifikat</span> &
                                Penghargaan</span>
                            <span x-show="$store.lang.current !== 'id'"><span class="text-orange-500">Certificates</span>
                                & Awards</span>
                        </h2>
                        <div class="h-1.5 w-full bg-orange-500 rounded-full mt-4 sm:mt-5"></div>
                    </div>
                </div>

                <div x-data="carousel({{ $certificates->count() }})">
                    <div x-ref="track"
                        class="grid grid-flow-col grid-rows-2 gap-5 sm:gap-6 lg:gap-7 overflow-x-auto scrollbar-none snap-x snap-mandatory pt-1 pb-3 auto-cols-[100%] sm:auto-cols-[calc(50%-0.75rem)] lg:auto-cols-[calc(33.333%-1.17rem)] scroll-smooth">
                        <template x-for="c in certificates" :key="c.id">
                            <a :href="c.url"
                                class="border border-slate-200/90 dark:border-white/10 bg-white dark:bg-[#1e293b] rounded-2xl overflow-hidden flex flex-col group snap-start w-full min-w-0 transition-all hover:border-slate-300 dark:hover:border-white/25 shadow-none">
                                <div
                                    class="relative h-44 sm:h-52 w-full shrink-0 border-b border-slate-200/80 dark:border-white/10 overflow-hidden bg-slate-50 dark:bg-white/[0.03]">
                                    <img :src="c.img" :alt="'Sertifikat ' + c.nama + ' - ' + (c.penerbit || 'Adya Portfolio')" :title="c.nama"
                                        class="w-full h-full object-contain p-4 transition-transform duration-500 group-hover:scale-105"
                                        loading="lazy" decoding="async">
                                    <div
                                        class="absolute bottom-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <span
                                            class="inline-flex items-center gap-1 text-xs font-semibold px-3 py-1.5 rounded-full bg-white dark:bg-slate-900 text-slate-800 dark:text-white border border-slate-200 dark:border-white/10 shadow-sm">
                                            <i class="ri-eye-line mr-1" aria-hidden="true"></i>
                                            <span x-text="t('view')">View</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex flex-1 flex-col p-4 sm:p-5">
                                    <h3 class="font-bold text-slate-900 dark:text-white text-sm group-hover:text-orange-500 transition-colors leading-snug line-clamp-2"
                                        x-text="L(c.nama, c.namaIdn)"></h3>
                                    <div
                                        class="mt-auto pt-3 flex items-center justify-between gap-2 text-[11px] text-slate-500 dark:text-slate-400 font-semibold uppercase tracking-wide">
                                        <span class="truncate" x-text="c.penerbit"></span>
                                        <span class="flex items-center gap-1.5 shrink-0 normal-case">
                                            <img src="{{ asset('images/icons/calendar.png') }}" alt=""
                                                class="w-3.5 h-3.5 object-contain shrink-0 dark:invert"
                                                aria-hidden="true">
                                            <span x-text="c.tanggal"></span>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </template>
                    </div>

                    <div class="flex justify-center items-center gap-2.5 mt-8 sm:mt-10">
                        <template x-for="i in pages" :key="i">
                            <button @click="go(i)"
                                class="w-3.5 h-3.5 rounded-full transition-all duration-300 cursor-pointer border-0"
                                :class="current === i ? 'bg-orange-500 scale-105' :
                                    'bg-slate-300 dark:bg-white/25 hover:bg-slate-400 dark:hover:bg-white/35'"
                                :aria-label="'Go to page ' + i"></button>
                        </template>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="pt-2 sm:pt-3 pb-2 sm:pb-3 relative z-10 scroll-mt-24 sm:scroll-mt-28" id="kontak">
        <div class="w-[calc(100%-2.5rem)] max-w-6xl mx-auto">
            <div class="rounded-3xl border border-slate-200/90 dark:border-white/10 bg-white dark:bg-[#0f172a]/95 p-6 sm:p-10 lg:p-14 shadow-none text-center"
                data-aos="fade-up">

                <div class="flex flex-col items-center justify-center text-center mb-6 sm:mb-8">
                    <div class="inline-flex flex-col items-center">
                        <h2
                            class="text-3xl sm:text-4xl lg:text-[40px] font-extrabold tracking-tight font-poppins text-slate-900 dark:text-white">
                            <span x-show="$store.lang.current === 'id'"><span class="text-orange-500">Mari</span>
                                Berbicara</span>
                            <span x-show="$store.lang.current !== 'id'">Let's <span
                                    class="text-orange-500">Talk</span></span>
                        </h2>
                        <div class="h-1.5 w-full bg-orange-500 rounded-full mt-4 sm:mt-5"></div>
                    </div>
                </div>

                <p class="text-sm sm:text-base md:text-lg text-slate-700 dark:text-slate-300 mb-8 leading-relaxed max-w-xl mx-auto"
                    x-text="t('contactBody')">
                    I am always open to discussing new projects, collaboration opportunities, or just to say hi. Send your
                    email and I will respond as soon as possible!
                </p>

                <a href="mailto:{{ $email }}"
                    class="inline-flex items-center justify-center gap-2 px-6 sm:px-8 py-3 sm:py-3.5 rounded-full bg-orange-500 hover:bg-orange-600 active:scale-95 text-white font-bold text-sm sm:text-base border-2 border-orange-600/70 dark:border-orange-400/80 transition-all select-none cursor-pointer">
                    <i class="ri-mail-send-line text-lg" aria-hidden="true"></i>
                    <span>{{ $email }}</span>
                </a>

            </div>
        </div>
    </section>
@endsection
