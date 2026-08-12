@extends('layouts.app')

@section('content')

@php
    $portfolioData = [
        'tools' => $tools->map(fn ($t) => ['id' => $t->id, 'img' => img_url($t->gambar), 'nama' => $t->nama, 'ket' => $t->ket])->values(),
        'projects' => $projects->map(fn ($p) => [
            'id' => $p->id,
            'url' => route('project.show', $p->id),
            'img' => img_url($p->gambar),
            'nama' => $p->nama,
            'desk' => $p->desk,
            'tools' => $p->tools ?? [],
            'link' => $p->link,
            'fullDesk' => $p->full_desk,
            'fitur' => $p->fitur ?? [],
        ])->values(),
        'experiences' => $experiences->map(fn ($e) => [
            'id' => $e->id,
            'url' => route('experience.show', $e->id),
            'role' => $e->role,
            'company' => $e->company,
            'duration' => $e->duration,
            'location' => $e->location,
            'desc' => $e->desk,
            'practicumDesc' => $e->practicum_desc,
            'responsibilities' => $e->responsibilities ?? [],
            'skills' => $e->skills ?? [],
        ])->values(),
        'certificates' => $certificates->map(fn ($c) => [
            'id' => $c->id,
            'url' => route('certificate.show', $c->id),
            'img' => img_url($c->gambar),
            'nama' => $c->nama,
            'penerbit' => $c->penerbit,
            'tanggal' => $c->tanggal,
            'desk' => $c->desk,
            'icon' => $c->icon,
        ])->values(),
    ];

    $profileName = $profile->name ?? 'Adya Handika Putra AP';
    $roleTitle = $profile->role_title ?? 'Web Developer | UI Design';
    $tagline = $profile->tagline ?? 'Design UI for website, Building modular, Web applications with a focus on architecture and precise digital experiences.';
    $about1 = $profile->about_1 ?? "Hello! I'm Adya Handika Putra AP, a Full Stack Developer with a deep passion for technology, open source, and exploring new programming concepts to build digital solutions that are both functional and precisely crafted.";
    $about2 = $profile->about_2 ?? "Currently pursuing a degree in Information Systems at the University of Jember, I'm constantly driven to learn, create, and contribute to the developer community through clean code, thoughtful architecture, and collaborative projects.";
    $email = $profile->email ?? 'handikaadya@gmail.com';
    $cvUrl = $profile->cv_url ?? 'https://drive.google.com/file/d/1yxphIQqnXRANWjzAER0K194RBqvTg3We/view?usp=sharing';
    $heroImage = $profile?->hero_image
        ? img_url($profile->hero_image)
        : 'data:image/svg+xml;utf8,'.rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 320"><rect width="100%" height="100%" fill="#1e293b"/><text x="50%" y="54%" font-family="Arial, sans-serif" font-size="88" fill="#60a5fa" text-anchor="middle" font-weight="bold">AP</text></svg>');
    $socials = [
        ['url' => $profile->github ?? 'https://github.com/Adya30/', 'icon' => 'ri-github-fill', 'label' => 'GitHub'],
        ['url' => $profile->instagram ?? 'https://www.instagram.com/adya_han/', 'icon' => 'ri-instagram-fill', 'label' => 'Instagram'],
        ['url' => $profile->youtube ?? 'https://www.youtube.com/@AdyaHandika', 'icon' => 'ri-youtube-fill', 'label' => 'YouTube'],
        ['url' => $profile->linkedin ?? 'https://www.linkedin.com/in/adya-handika/', 'icon' => 'ri-linkedin-fill', 'label' => 'LinkedIn'],
    ];
    $chips = array_values(array_filter(array_map('trim', explode('|', $roleTitle)), fn ($c) => $c !== ''));

    $nameParts = explode(' ', trim($profileName));
    $lastWord = array_pop($nameParts) ?: 'AP';
    $firstName = implode(' ', $nameParts) ?: 'Adya Handika Putra';

    $about1Html = e($about1);
    if ($profileName !== '' && str_contains($about1Html, e($profileName))) {
        $about1Html = str_replace(e($profileName), '<strong class="text-accent">'.e($profileName).'</strong>', $about1Html);
    }
@endphp

<script>window.portfolioData = @json($portfolioData);</script>

<div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
    <div class="absolute inset-0
                bg-[linear-gradient(rgba(59,130,246,0.04)_1px,transparent_1px),linear-gradient(90deg,rgba(59,130,246,0.04)_1px,transparent_1px)]
                bg-[size:48px_48px]
                dark:bg-[linear-gradient(rgba(96,165,250,0.04)_1px,transparent_1px),linear-gradient(90deg,rgba(96,165,250,0.04)_1px,transparent_1px)]"></div>

    <div class="absolute rounded-full pointer-events-none opacity-25 dark:opacity-15 blur-[120px]"
         style="width: 400px; height: 400px; left: -10%; top: 10%; background: radial-gradient(circle, #3b82f6 0%, #8b5cf6 70%);"></div>
    <div class="absolute rounded-full pointer-events-none opacity-25 dark:opacity-15 blur-[120px]"
         style="width: 450px; height: 450px; left: 60%; top: 45%; background: radial-gradient(circle, #8b5cf6 0%, #06b6d4 70%);"></div>

    @for($i = 0; $i < 15; $i++)
        @php
            $size = 1.5 + ($i % 2);
            $left = ($i * 27.7 + 13.2) % 100;
            $top = ($i * 23.3 + 17.1) % 100;
            $delay = $i * 0.4;
            $duration = 4 + ($i % 3);
            $color = $i % 2 === 0 ? '#3b82f6' : '#06b6d4';
        @endphp
        <div class="pointer-events-none absolute rounded-full opacity-0"
             style="width: {{ $size }}px; height: {{ $size }}px; left: {{ $left }}%; top: {{ $top }}%; background: {{ $color }}; animation: sparkle-twinkle {{ $duration }}s ease-in-out {{ $delay }}s infinite;"></div>
    @endfor
</div>

<section id="beranda" class="relative min-h-screen flex items-center pt-24 pb-16 z-10 scroll-mt-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="grid md:grid-cols-2 items-center gap-10 w-full">

            <div class="animate__animated animate__fadeInUp animate__delay-1s order-2 md:order-1">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold font-poppins leading-tight mb-3">
                    {{ $firstName }} <span class="bg-linear-to-br from-[#3b82f6] to-[#8b5cf6] bg-clip-text text-transparent">{{ $lastWord }}</span>
                </h1>
                <p class="text-lg sm:text-xl font-medium text-slate-600 dark:text-slate-300 mb-2">{{ $roleTitle }}</p>
                <p class="text-sm sm:text-base text-slate-500 dark:text-slate-400 max-w-lg leading-relaxed mb-8">
                    {{ $tagline }}
                </p>

                <div class="flex items-center gap-3 flex-wrap">
                    <a href="{{ $cvUrl }}"
                       target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-full bg-accent text-white text-sm font-semibold cursor-pointer transition-all duration-200 hover:bg-blue-600 hover:-translate-y-0.5 hover:shadow-[0_8px_24px_rgba(59,130,246,0.35)] active:translate-y-0">
                        <i class="ri-download-line"></i>Download CV
                    </a>
                    <a href="#proyek" @click.prevent="scrollToSection($event, '#proyek')"
                       class="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-full border-[1.5px] border-accent/30 text-accent dark:text-[#60a5fa] text-sm font-semibold cursor-pointer transition-all duration-200 hover:bg-accent/10 hover:border-accent hover:-translate-y-0.5 dark:hover:bg-accent/15 dark:hover:border-[#60a5fa]">
                        <i class="ri-eye-line"></i>Lihat Proyek
                    </a>
                </div>

                <div class="flex items-center gap-3 mt-8">
                    @foreach ($socials as $social)
                        <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $social['label'] }}"
                           class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-100 dark:bg-white/5 text-slate-600 dark:text-slate-400 hover:bg-accent hover:text-white dark:hover:bg-accent transition-all duration-300">
                            <i class="{{ $social['icon'] }}"></i>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-center md:justify-end order-1 md:order-2 animate__animated animate__fadeInUp animate__delay-2s">
                <div class="relative">
                    <div class="absolute -inset-4 bg-linear-to-br from-accent/20 via-purple-500/10 to-transparent rounded-full blur-3xl"></div>
                    <div class="relative w-64 h-64 sm:w-72 sm:h-72 lg:w-80 lg:h-80 rounded-full overflow-hidden border-4 border-white dark:border-white/10 shadow-xl">
                        <img src="{{ $heroImage }}" alt="{{ $profileName }}" class="w-full h-full object-cover">
                    </div>

                    <div class="absolute -bottom-2 -right-2 bg-white dark:bg-[#1a1a2e] rounded-xl px-4 py-2 shadow-lg border border-slate-100 dark:border-white/5 animate-float" style="animation-delay: 1s">
                        <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">Certificates</p>
                        <p class="text-lg font-bold bg-linear-to-br from-[#3b82f6] to-[#8b5cf6] bg-clip-text text-transparent"><span x-data="counter({{ $certificates->count() }}, '+')" x-text="value + suffix"></span></p>
                    </div>

                    <div class="absolute -top-2 -left-2 bg-white dark:bg-[#1a1a2e] rounded-xl px-4 py-2 shadow-lg border border-slate-100 dark:border-white/5 animate-float" style="animation-delay: 2s">
                        <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">Projects</p>
                        <p class="text-lg font-bold bg-linear-to-br from-[#3b82f6] to-[#8b5cf6] bg-clip-text text-transparent"><span x-data="counter({{ $projects->count() }}, '+')" x-text="value + suffix"></span></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<section class="py-10 relative z-10 scroll-mt-20" id="tentang">
    <div class="text-center mb-10 pt-10">
        <h2 class="font-poppins text-[1.75rem] sm:text-4xl font-bold leading-[1.2] text-slate-800 dark:text-slate-100">About Me</h2>
        <p class="mt-3 mx-auto text-[0.95rem] text-slate-500 dark:text-slate-400 max-w-lg">A brief story about my journey in tech and what drives me</p>
    </div>

    <div class="max-w-5xl mx-auto px-4 space-y-8">
        <div class="bg-white dark:bg-[#1a1a2e] border border-slate-200 dark:border-white/5 rounded-2xl transition-all duration-300 hover:border-accent/30 hover:-translate-y-1 hover:shadow-[0_12px_40px_rgba(0,0,0,0.08)] dark:hover:shadow-[0_12px_40px_rgba(59,130,246,0.08)] p-8 md:p-10"
             data-aos="fade-up" data-aos-duration="800">
            <div class="flex flex-col md:flex-row items-start gap-8">
                <div class="flex-shrink-0 mx-auto md:mx-0">
                    <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-full overflow-hidden border-4 border-accent/20 dark:border-accent/30 shadow-lg">
                        <img src="{{ $heroImage }}" alt="{{ $profileName }}" class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm sm:text-base leading-relaxed text-slate-600 dark:text-slate-300">
                        {!! $about1Html !!}
                    </p>
                    <p class="text-sm sm:text-base leading-relaxed text-slate-500 dark:text-slate-400 mt-4">
                        {{ $about2 }}
                    </p>
                    <div class="flex flex-wrap gap-2 mt-6">
                        @foreach ($chips as $chip)
                            <span class="px-3 py-1.5 text-xs font-medium rounded-full bg-slate-100 dark:bg-white/5 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-white/5 hover:border-accent/30 hover:text-accent dark:hover:text-accent transition-all duration-200 cursor-default">{{ $chip }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4" data-aos="fade-up" data-aos-duration="800" data-aos-delay="150">
            <div class="bg-white dark:bg-[#1a1a2e] border border-slate-200 dark:border-white/5 rounded-2xl transition-all duration-300 hover:border-accent/30 hover:-translate-y-1 hover:shadow-[0_12px_40px_rgba(0,0,0,0.08)] dark:hover:shadow-[0_12px_40px_rgba(59,130,246,0.08)] p-5 sm:p-6 text-center">
                <div class="w-10 h-10 sm:w-12 sm:h-12 mx-auto mb-3 rounded-xl bg-accent/10 flex items-center justify-center">
                    <i class="ri-code-box-line text-accent text-lg sm:text-xl"></i>
                </div>
                <p class="text-2xl sm:text-3xl font-bold bg-linear-to-br from-[#3b82f6] to-[#8b5cf6] bg-clip-text text-transparent"><span x-data="counter({{ $projects->count() }}, '+')" x-text="value + suffix"></span></p>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1.5 font-medium">Projects Completed</p>
            </div>
            <div class="bg-white dark:bg-[#1a1a2e] border border-slate-200 dark:border-white/5 rounded-2xl transition-all duration-300 hover:border-accent/30 hover:-translate-y-1 hover:shadow-[0_12px_40px_rgba(0,0,0,0.08)] dark:hover:shadow-[0_12px_40px_rgba(59,130,246,0.08)] p-5 sm:p-6 text-center">
                <div class="w-10 h-10 sm:w-12 sm:h-12 mx-auto mb-3 rounded-xl bg-accent/10 flex items-center justify-center">
                    <i class="ri-award-line text-accent text-lg sm:text-xl"></i>
                </div>
                <p class="text-2xl sm:text-3xl font-bold bg-linear-to-br from-[#3b82f6] to-[#8b5cf6] bg-clip-text text-transparent"><span x-data="counter({{ $certificates->count() }}, '+')" x-text="value + suffix"></span></p>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1.5 font-medium">Certifications</p>
            </div>
            <div class="bg-white dark:bg-[#1a1a2e] border border-slate-200 dark:border-white/5 rounded-2xl transition-all duration-300 hover:border-accent/30 hover:-translate-y-1 hover:shadow-[0_12px_40px_rgba(0,0,0,0.08)] dark:hover:shadow-[0_12px_40px_rgba(59,130,246,0.08)] p-5 sm:p-6 text-center">
                <div class="w-10 h-10 sm:w-12 sm:h-12 mx-auto mb-3 rounded-xl bg-accent/10 flex items-center justify-center">
                    <i class="ri-tools-line text-accent text-lg sm:text-xl"></i>
                </div>
                <p class="text-2xl sm:text-3xl font-bold bg-linear-to-br from-[#3b82f6] to-[#8b5cf6] bg-clip-text text-transparent"><span x-data="counter({{ $tools->count() }}, '+')" x-text="value + suffix"></span></p>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1.5 font-medium">Tools Mastered</p>
            </div>
        </div>
    </div>
</section>

<section class="py-10 relative z-10 scroll-mt-20" id="skills">
    <div class="text-center mb-8 pt-10">
        <h2 class="font-poppins text-[1.75rem] sm:text-4xl font-bold leading-[1.2] text-slate-800 dark:text-slate-100">Tools & Skills</h2>
        <p class="mt-3 mx-auto text-[0.95rem] text-slate-500 dark:text-slate-400 max-w-lg">Any tools and skills I use regularly</p>
    </div>

    <div class="relative max-w-5xl mx-auto px-4" data-aos="fade-up" data-aos-duration="600">
        <div x-data="carousel(16)">
            <div x-ref="track"
                 class="grid grid-flow-col grid-rows-2 gap-4 overflow-x-auto scrollbar-none snap-x snap-mandatory pb-4 auto-cols-[100%] sm:auto-cols-[calc(50%-0.5rem)] md:auto-cols-[calc(33.333%-0.67rem)] lg:auto-cols-[calc(25%-0.75rem)] scroll-smooth">
                <template x-for="t in tools" :key="t.id">
                    <div class="bg-white dark:bg-[#1a1a2e] border border-slate-200 dark:border-white/5 rounded-2xl transition-all duration-300 hover:border-accent/30 hover:-translate-y-1 hover:shadow-[0_12px_40px_rgba(0,0,0,0.08)] dark:hover:shadow-[0_12px_40px_rgba(59,130,246,0.08)] p-5 flex items-center gap-4 group cursor-pointer snap-start w-full min-w-0">
                        <div class="w-12 h-12 rounded-xl bg-slate-50 dark:bg-white/5 flex items-center justify-center flex-shrink-0 group-hover:bg-accent/10 transition-colors">
                            <img :src="t.img" :alt="t.nama" class="w-7 h-7 object-contain">
                        </div>
                        <div class="min-w-0">
                            <h4 class="font-semibold text-sm text-slate-800 dark:text-slate-200 group-hover:text-accent transition-colors truncate" x-text="t.nama"></h4>
                            <p class="text-xs text-slate-400 dark:text-slate-500 truncate" x-text="t.ket"></p>
                        </div>
                    </div>
                </template>
            </div>
            <div class="flex justify-center items-center gap-2 mt-4">
                <template x-for="i in pages" :key="i">
                    <button @click="go(i)"
                            class="h-2 rounded-full transition-all duration-500 cursor-pointer"
                            :class="current === i ? 'bg-accent w-6' : 'bg-slate-300 dark:bg-slate-600 w-2 hover:bg-slate-400 dark:hover:bg-slate-500'"
                            :aria-label="'Go to page ' + (i + 1)"></button>
                </template>
            </div>
        </div>
    </div>
</section>

<section class="py-10 relative z-10 scroll-mt-20" id="proyek">
    <div class="text-center mb-8 pt-10">
        <h2 class="font-poppins text-[1.75rem] sm:text-4xl font-bold leading-[1.2] text-slate-800 dark:text-slate-100">Recent Projects</h2>
        <p class="mt-3 mx-auto text-[0.95rem] text-slate-500 dark:text-slate-400 max-w-lg">Click on any project to see full details</p>
    </div>

    <div class="relative max-w-6xl mx-auto px-4" data-aos="fade-up" data-aos-duration="600">
        <div x-data="carousel(12)">
            <div x-ref="track"
                 class="grid grid-flow-col grid-rows-2 gap-6 overflow-x-auto scrollbar-none snap-x snap-mandatory pb-4 auto-cols-[100%] sm:auto-cols-[calc(50%-0.75rem)] lg:auto-cols-[calc(33.333%-1rem)] scroll-smooth">
                <template x-for="p in projects" :key="p.id">
                    <a :href="p.url"
                       class="block bg-white dark:bg-[#1a1a2e] border border-slate-200 dark:border-white/5 rounded-2xl transition-all duration-300 hover:border-accent/30 hover:-translate-y-1 hover:shadow-[0_12px_40px_rgba(0,0,0,0.08)] dark:hover:shadow-[0_12px_40px_rgba(59,130,246,0.08)] overflow-hidden group snap-start w-full min-w-0">
                        <div class="relative overflow-hidden">
                            <img :src="p.img" :alt="p.nama" class="w-full aspect-[600/383] object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                            <div class="absolute inset-0 bg-linear-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            <div class="absolute bottom-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                <span class="text-xs font-semibold px-3 py-1.5 rounded-full bg-white/90 dark:bg-black/60 text-slate-800 dark:text-white backdrop-blur-sm"><i class="ri-eye-line mr-1"></i>View</span>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xs font-medium text-accent" x-text="'#' + String(p.id).padStart(2, '0')"></span>
                                <span class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                                <span class="text-xs text-slate-400 dark:text-slate-500">Project</span>
                            </div>
                            <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 mb-1.5 group-hover:text-accent transition-colors" x-text="p.nama"></h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mb-3 line-clamp-2 leading-relaxed" x-text="p.desk"></p>
                            <div class="flex flex-wrap gap-1.5">
                                <template x-for="tool in p.tools" :key="tool">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium text-accent dark:text-[#60a5fa] bg-accent/10 dark:bg-accent/15 border border-accent/15 dark:border-accent/25 transition-all duration-200 hover:bg-accent/15 hover:-translate-y-px text-[10px]" x-text="tool"></span>
                                </template>
                            </div>
                        </div>
                    </a>
                </template>
            </div>
            <div class="flex justify-center items-center gap-2 mt-6">
                <template x-for="i in pages" :key="i">
                    <button @click="go(i)"
                            class="h-2 rounded-full transition-all duration-500 cursor-pointer"
                            :class="current === i ? 'bg-accent w-6' : 'bg-slate-300 dark:bg-slate-600 w-2 hover:bg-slate-400 dark:hover:bg-slate-500'"
                            :aria-label="'Go to page ' + (i + 1)"></button>
                </template>
            </div>
        </div>
    </div>
</section>

<section class="py-10 relative z-10 scroll-mt-20" id="experiences">
    <div class="text-center mb-8 pt-10">
        <h2 class="font-poppins text-[1.75rem] sm:text-4xl font-bold leading-[1.2] text-slate-800 dark:text-slate-100">My Experience</h2>
        <p class="mt-3 mx-auto text-[0.95rem] text-slate-500 dark:text-slate-400 max-w-lg">Click on any experience to see the full details</p>
    </div>

    <div class="max-w-3xl mx-auto relative pl-6 border-l-2 border-slate-200 dark:border-white/10 ml-4 sm:ml-auto">
        <template x-for="(e, i) in experiences" :key="e.id">
            <div class="relative mb-12 last:mb-0">
                <span class="absolute -left-[31px] top-1.5 w-4 h-4 rounded-full border-4 border-white dark:border-[#0a0a0f] shadow-sm"
                      :class="i === 0 ? 'bg-accent shadow-accent/50' : 'bg-slate-400'"></span>
                <a :href="e.url" class="block group rounded-2xl">
                    <div class="bg-white dark:bg-[#1a1a2e] border border-slate-200 dark:border-white/5 rounded-2xl transition-all duration-300 hover:border-accent/30 hover:-translate-y-1 hover:shadow-[0_12px_40px_rgba(0,0,0,0.08)] dark:hover:shadow-[0_12px_40px_rgba(59,130,246,0.08)] p-6">
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3 mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 group-hover:text-accent transition-colors" x-text="e.role"></h3>
                            <p class="text-sm font-semibold text-accent mb-1" x-text="e.company"></p>
                            <p class="text-xs text-slate-400 dark:text-slate-500 flex items-center gap-1">
                                <i class="ri-map-pin-line"></i><span x-text="e.location"></span>
                            </p>
                        </div>
                        <div class="flex items-center gap-2 self-start">
                            <span class="text-xs font-semibold px-3 py-1.5 rounded-full bg-slate-100 dark:bg-white/5 text-slate-500 dark:text-slate-400 whitespace-nowrap" x-text="e.duration"></span>
                            <span class="w-7 h-7 flex items-center justify-center rounded-full bg-accent/10 text-accent opacity-0 -translate-x-1 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300" aria-hidden="true">
                                <i class="ri-arrow-right-up-line text-sm"></i>
                            </span>
                        </div>
                    </div>
                    <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed mb-4" x-text="e.desc"></p>

                    <template x-if="e.practicumDesc">
                        <div class="mb-4 bg-slate-100/50 dark:bg-white/2 p-4 rounded-xl border border-slate-200/30 dark:border-white/5">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-400 mb-2">Practicum Responsibilities</h4>
                            <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed" x-text="e.practicumDesc"></p>
                        </div>
                    </template>

                    <template x-if="e.responsibilities && e.responsibilities.length > 0">
                        <div class="mb-4">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-400 mb-2">Key Responsibilities</h4>
                            <ul class="space-y-2">
                                <template x-for="(r, ri) in e.responsibilities" :key="ri">
                                    <li class="text-sm text-slate-500 dark:text-slate-400 flex items-start gap-2">
                                        <i class="ri-checkbox-circle-line text-accent text-sm mt-0.5 flex-shrink-0"></i>
                                        <span x-text="r"></span>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </template>

                    <template x-if="e.skills && e.skills.length > 0">
                        <div class="pt-3 border-t border-slate-100 dark:border-white/5">
                            <div class="flex flex-wrap gap-1.5 items-center">
                                <span class="text-xs text-slate-400 dark:text-slate-500 mr-1 font-medium">Skills:</span>
                                <template x-for="(s, si) in e.skills" :key="si">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium text-accent dark:text-[#60a5fa] bg-accent/10 dark:bg-accent/15 border border-accent/15 dark:border-accent/25 transition-all duration-200 hover:bg-accent/15 hover:-translate-y-px text-[10px] py-0.5 px-2" x-text="s"></span>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
                </a>
            </div>
        </template>
    </div>
</section>

<section class="py-10 relative z-10 scroll-mt-20" id="certificates">
    <div class="text-center mb-8 pt-10">
        <h2 class="font-poppins text-[1.75rem] sm:text-4xl font-bold leading-[1.2] text-slate-800 dark:text-slate-100">Certificates & Awards</h2>
        <p class="mt-3 mx-auto text-[0.95rem] text-slate-500 dark:text-slate-400 max-w-lg">Click on any certificate to see full details</p>
    </div>

    <div class="relative max-w-6xl mx-auto px-4" data-aos="fade-up" data-aos-duration="600">
        <div x-data="carousel(11)">
            <div x-ref="track"
                 class="grid grid-flow-col grid-rows-2 gap-6 overflow-x-auto scrollbar-none snap-x snap-mandatory pb-4 auto-cols-[100%] sm:auto-cols-[calc(50%-0.75rem)] lg:auto-cols-[calc(33.333%-1rem)] scroll-smooth">
                <template x-for="c in certificates" :key="c.id">
                    <a :href="c.url"
                       class="block bg-white dark:bg-[#1a1a2e] border border-slate-200 dark:border-white/5 rounded-2xl transition-all duration-300 hover:border-accent/30 hover:-translate-y-1 hover:shadow-[0_12px_40px_rgba(0,0,0,0.08)] dark:hover:shadow-[0_12px_40px_rgba(59,130,246,0.08)] overflow-hidden flex flex-col justify-between group snap-start w-full min-w-0">
                        <div>
                            <div class="relative h-48 w-full bg-slate-100 dark:bg-slate-900 flex items-center justify-center p-3 border-b border-slate-200/50 dark:border-white/5 overflow-hidden">
                                <img :src="c.img" :alt="c.nama" class="max-h-full max-w-full object-contain group-hover:scale-[1.03] transition-transform duration-300" loading="lazy">
                                <div class="absolute inset-0 bg-linear-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                <div class="absolute bottom-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <span class="text-xs font-semibold px-3 py-1.5 rounded-full bg-white/90 dark:bg-black/60 text-slate-800 dark:text-white backdrop-blur-sm"><i class="ri-eye-line mr-1"></i>View</span>
                                </div>
                            </div>
                            <div class="p-5">
                                <div class="flex items-center justify-between gap-2 text-xs text-slate-400 dark:text-slate-500 font-medium mb-1">
                                    <span x-text="c.penerbit"></span>
                                    <span class="flex items-center gap-1 text-[11px]"><i class="ri-calendar-line"></i><span x-text="c.tanggal"></span></span>
                                </div>
                                <h3 class="font-bold text-slate-800 dark:text-slate-100 text-base group-hover:text-accent transition-colors leading-snug" x-text="c.nama"></h3>
                            </div>
                        </div>
                    </a>
                </template>
            </div>
            <div class="flex justify-center items-center gap-2 mt-6">
                <template x-for="i in pages" :key="i">
                    <button @click="go(i)"
                            class="h-2 rounded-full transition-all duration-500 cursor-pointer"
                            :class="current === i ? 'bg-accent w-6' : 'bg-slate-300 dark:bg-slate-600 w-2 hover:bg-slate-400 dark:hover:bg-slate-500'"
                            :aria-label="'Go to page ' + (i + 1)"></button>
                </template>
            </div>
        </div>
    </div>
</section>

<section class="pt-6 pb-2 relative z-10 scroll-mt-20" id="kontak">
    <div class="text-center mb-8 pt-15">
        <h2 class="font-poppins text-[1.75rem] sm:text-4xl font-bold leading-[1.2] text-slate-800 dark:text-slate-100">Let's Talk</h2>
        <p class="mt-3 mx-auto text-[0.95rem] text-slate-500 dark:text-slate-400 max-w-lg">Have a project in mind or just want to say hi? Feel free to reach out directly!</p>
    </div>

    <div class="max-w-5xl mx-auto text-center" data-aos="fade-up" data-aos-duration="600" data-aos-delay="200">
        <div class="bg-white dark:bg-[#1a1a2e] border border-slate-200 dark:border-white/5 rounded-2xl transition-all duration-300 hover:border-accent/30 hover:-translate-y-1 hover:shadow-[0_12px_40px_rgba(0,0,0,0.08)] dark:hover:shadow-[0_12px_40px_rgba(59,130,246,0.08)] p-8 md:p-16">
            <p class="text-sm sm:text-base text-slate-500 dark:text-slate-400 mb-6 leading-relaxed max-w-xl mx-auto">
                I am always open to discussing new projects, collaboration opportunities, or just to say hi. Send your email and I will respond as soon as possible!
            </p>
            <p class="text-base sm:text-lg font-semibold text-accent">
                <i class="ri-mail-line mr-2"></i>{{ $email }}
            </p>
        </div>
    </div>
</section>

@endsection
