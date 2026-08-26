@php
    $menuItems = [
        ['id' => 'beranda', 'tKey' => 'navHome', 'label' => 'Home', 'href' => '#beranda', 'icon' => 'ri-home-5-line'],
        ['id' => 'tentang', 'tKey' => 'navAbout', 'label' => 'About', 'href' => '#tentang', 'icon' => 'ri-user-3-line'],
        ['id' => 'proyek', 'tKey' => 'navProjects', 'label' => 'Projects', 'href' => '#proyek', 'icon' => 'ri-folder-open-line'],
        ['id' => 'experiences', 'tKey' => 'navExperiences', 'label' => 'Experiences', 'href' => '#experiences', 'icon' => 'ri-briefcase-line'],
        ['id' => 'certificates', 'tKey' => 'navCertificates', 'label' => 'Certificates', 'href' => '#certificates', 'icon' => 'ri-award-line'],
        ['id' => 'kontak', 'tKey' => 'navContact', 'label' => 'Contact', 'href' => '#kontak', 'icon' => 'ri-chat-3-line'],
        ['id' => 'course', 'tKey' => 'navCourse', 'label' => 'Course', 'href' => route('course.index'), 'icon' => 'ri-book-open-line', 'external' => true],
    ];

    $langBtnBase = 'h-9 flex items-center justify-center text-xs font-bold cursor-pointer transition-all duration-300 select-none';
    $langBtnActive = 'bg-accent text-white shadow-sm';
    $langBtnInactive = 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-300/60 dark:hover:bg-white/5';

@endphp

<div class="fixed top-4 left-0 right-0 z-50 hidden md:block" x-cloak>

    <nav class="mx-auto w-[calc(100%-2rem)] max-w-6xl transition-all duration-300 rounded-2xl border backdrop-blur-md shadow-lg bg-white/70 dark:bg-[#0b1329]/90"
         :class="scrolled
            ? 'py-1 border-slate-200/50 dark:border-white/10 shadow-slate-200/40 dark:shadow-black/20'
            : 'py-1.5 border-slate-200/30 dark:border-white/5 shadow-slate-200/30 dark:shadow-black/10'">
        <div class="px-6 flex items-center justify-between">

            <a href="#beranda" @click.prevent="scrollToSection($event, '#beranda')"
               class="flex items-center gap-1 font-poppins font-bold text-lg tracking-tight select-none shrink-0">
                <span class="text-amber-500">Adya</span>
                <span class="text-slate-800 dark:text-white">'s Portfolio</span>
                <span class="text-cyan-500 dark:text-cyan-400">.</span>
            </a>

            <div class="flex items-center gap-2 lg:gap-4 min-w-0">
                <div class="flex items-center gap-1 lg:gap-3 overflow-x-auto scrollbar-none">
                    @foreach($menuItems as $item)
                        @if (! empty($item['external']))
                            <a href="{{ $item['href'] }}"
                               class="relative px-2.5 lg:px-3 py-3 text-xs font-semibold uppercase tracking-wider transition-all duration-300 group shrink-0"
                               :class="active === '{{ $item['id'] }}'
                                    ? 'text-cyan-500 dark:text-cyan-400'
                                    : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'">
                                <span x-text="t('{{ $item['tKey'] }}')">{{ $item['label'] }}</span>
                                <span class="absolute bottom-1.5 left-2.5 right-2.5 lg:left-3 lg:right-3 h-0.5 bg-cyan-500 dark:bg-cyan-400 rounded-full transition-all duration-300"
                                      :class="active === '{{ $item['id'] }}'
                                            ? 'opacity-100 scale-x-100'
                                            : 'opacity-0 scale-x-0 group-hover:opacity-50 group-hover:scale-x-75'"></span>
                            </a>
                        @else
                            <a href="{{ $item['href'] }}" @click.prevent="scrollToSection($event, '{{ $item['href'] }}')"
                               class="relative px-2.5 lg:px-3 py-3 text-xs font-semibold uppercase tracking-wider transition-all duration-300 group shrink-0"
                               :class="active === '{{ $item['id'] }}'
                                    ? 'text-cyan-500 dark:text-cyan-400'
                                    : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'">
                                <span x-text="t('{{ $item['tKey'] }}')">{{ $item['label'] }}</span>
                                <span class="absolute bottom-1.5 left-2.5 right-2.5 lg:left-3 lg:right-3 h-0.5 bg-cyan-500 dark:bg-cyan-400 rounded-full transition-all duration-300"
                                      :class="active === '{{ $item['id'] }}'
                                            ? 'opacity-100 scale-x-100'
                                            : 'opacity-0 scale-x-0 group-hover:opacity-50 group-hover:scale-x-75'"></span>
                            </a>
                        @endif
                    @endforeach
                </div>

                <div class="flex items-center rounded-lg border border-slate-200 dark:border-white/10 bg-slate-200/60 dark:bg-slate-950/40 overflow-hidden shadow-inner ml-1 shrink-0"
                     role="group" :aria-label="t('toggleLanguage')">
                    <button @click="$store.lang.set('en')" :class="$store.lang.current === 'en' ? '{{ $langBtnActive }}' : '{{ $langBtnInactive }}'"
                            class="{{ $langBtnBase }} px-2" aria-label="English">EN</button>
                    <button @click="$store.lang.set('id')" :class="$store.lang.current === 'id' ? '{{ $langBtnActive }}' : '{{ $langBtnInactive }}'"
                            class="{{ $langBtnBase }} px-2 border-l border-slate-200 dark:border-white/10" aria-label="Bahasa Indonesia">ID</button>
                </div>

                <button @click="toggleTheme"
                        class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-200 dark:border-white/10 bg-slate-200/60 dark:bg-slate-950/40 text-slate-700 dark:text-yellow-400 hover:bg-slate-300/80 dark:hover:bg-slate-900 transition-all duration-300 cursor-pointer shadow-inner shrink-0"
                        aria-label="Toggle theme">
                    <i class="text-base" :class="dark ? 'ri-sun-fill' : 'ri-moon-fill text-slate-600'"></i>
                </button>
            </div>
        </div>
    </nav>
</div>

<nav class="fixed top-[calc(0.75rem+env(safe-area-inset-top,0px))] left-2.5 right-2.5 sm:left-4 sm:right-4 z-50 md:hidden max-w-full" x-cloak>
    <div class="relative rounded-2xl border border-slate-200/60 dark:border-white/10 bg-white/90 dark:bg-[#0b1329]/95 backdrop-blur-2xl shadow-lg shadow-slate-200/25 dark:shadow-black/40 overflow-hidden">
        <div class="flex items-center justify-between gap-1.5 py-1.5 px-2">

            {{-- Scrollable Nav Links --}}
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-1 overflow-x-auto scrollbar-none py-0.5 px-0.5 scroll-smooth">
                    @foreach($menuItems as $item)
                        @if (! empty($item['external']))
                            <a href="{{ $item['href'] }}"
                               class="flex flex-col items-center justify-center py-1 px-2 min-w-[48px] rounded-xl transition-all duration-300 shrink-0 select-none"
                               :class="active === '{{ $item['id'] }}'
                                    ? 'text-cyan-500 dark:text-cyan-400 bg-cyan-500/10 dark:bg-cyan-400/10 font-semibold'
                                    : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200'">
                                <i class="{{ $item['icon'] }} text-sm leading-none mb-0.5"></i>
                                <span class="text-[9px] leading-tight font-medium tracking-tight whitespace-nowrap" x-text="t('{{ $item['tKey'] }}')">{{ $item['label'] }}</span>
                            </a>
                        @else
                            <a href="{{ $item['href'] }}" @click.prevent="scrollToSection($event, '{{ $item['href'] }}')"
                               class="flex flex-col items-center justify-center py-1 px-2 min-w-[48px] rounded-xl transition-all duration-300 shrink-0 select-none"
                               :class="active === '{{ $item['id'] }}'
                                    ? 'text-cyan-500 dark:text-cyan-400 bg-cyan-500/10 dark:bg-cyan-400/10 font-semibold'
                                    : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200'">
                                <i class="{{ $item['icon'] }} text-sm leading-none mb-0.5"></i>
                                <span class="text-[9px] leading-tight font-medium tracking-tight whitespace-nowrap" x-text="t('{{ $item['tKey'] }}')">{{ $item['label'] }}</span>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="w-px h-5 bg-slate-200 dark:bg-white/10 shrink-0 mx-0.5"></div>

            {{-- Actions: Language and Theme --}}
            <div class="flex items-center gap-1 shrink-0">
                <div class="flex items-center rounded-lg border border-slate-200 dark:border-white/10 bg-slate-200/60 dark:bg-slate-950/40 overflow-hidden shadow-inner"
                     role="group" :aria-label="t('toggleLanguage')">
                    <button @click="$store.lang.set('en')" :class="$store.lang.current === 'en' ? '{{ $langBtnActive }}' : '{{ $langBtnInactive }}'"
                            class="h-7 px-1.5 flex items-center justify-center text-[10px] font-bold cursor-pointer transition-all duration-200 select-none" aria-label="English">EN</button>
                    <button @click="$store.lang.set('id')" :class="$store.lang.current === 'id' ? '{{ $langBtnActive }}' : '{{ $langBtnInactive }}'"
                            class="h-7 px-1.5 flex items-center justify-center text-[10px] font-bold cursor-pointer transition-all duration-200 select-none border-l border-slate-200 dark:border-white/10" aria-label="Bahasa Indonesia">ID</button>
                </div>

                <button @click="toggleTheme"
                        class="w-7 h-7 flex items-center justify-center rounded-lg border border-slate-200 dark:border-white/10 bg-slate-200/60 dark:bg-slate-950/40 text-slate-700 dark:text-yellow-400 hover:bg-slate-300/80 dark:hover:bg-slate-900 transition-all duration-200 cursor-pointer shadow-inner shrink-0"
                        aria-label="Toggle theme">
                    <i class="text-xs" :class="dark ? 'ri-sun-fill' : 'ri-moon-fill text-slate-600'"></i>
                </button>
            </div>

        </div>
    </div>
</nav>
