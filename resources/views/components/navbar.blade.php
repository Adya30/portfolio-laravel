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
    $langBtnActive = 'bg-accent/90 backdrop-blur-md text-white shadow-sm';
    $langBtnInactive = 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-white/50 dark:hover:bg-white/10';
@endphp

<!-- Navbar Desktop -->
<div class="fixed top-4 left-0 right-0 z-50 hidden md:block" x-cloak>
    <nav class="mx-auto w-[calc(100%-2rem)] max-w-6xl transition-all duration-300 rounded-2xl border backdrop-blur-xl"
         :class="scrolled
            ? 'py-1 bg-white/40 dark:bg-slate-900/40 border-white/50 dark:border-white/10 shadow-[0_8px_32px_rgba(0,0,0,0.08)] dark:shadow-[0_8px_32px_rgba(0,0,0,0.25)]'
            : 'py-1.5 bg-white/10 dark:bg-slate-900/10 border-white/20 dark:border-white/5 shadow-none'">
        <div class="px-6 flex items-center justify-between">

            <a href="#beranda" @click.prevent="scrollToSection($event, '#beranda')"
               class="flex items-center gap-1 font-poppins font-bold text-lg tracking-tight select-none shrink-0 drop-shadow-sm">
                <span class="text-amber-500">Adya</span>
                <span class="text-slate-800 dark:text-white">'s Portfolio</span>
                <span class="text-cyan-500 dark:text-cyan-400">.</span>
            </a>

            <div class="flex items-center gap-2 lg:gap-4 min-w-0">
                <div class="flex items-center gap-1 lg:gap-3 overflow-x-auto scrollbar-none">
                    @foreach($menuItems as $item)
                        @if (! empty($item['external']))
                            <a href="{{ $item['href'] }}"
                               class="relative px-2.5 lg:px-3 py-3 text-xs font-semibold uppercase tracking-wider transition-all duration-300 group shrink-0 drop-shadow-sm"
                               :class="active === '{{ $item['id'] }}'
                                    ? 'text-cyan-600 dark:text-cyan-400'
                                    : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white'">
                                <span x-text="t('{{ $item['tKey'] }}')">{{ $item['label'] }}</span>
                                <span class="absolute bottom-1.5 left-2.5 right-2.5 lg:left-3 lg:right-3 h-[3px] bg-cyan-500 dark:bg-cyan-400 rounded-full transition-all duration-300"
                                    :class="active === '{{ $item['id'] }}'
                                            ? 'opacity-100 scale-x-100'
                                            : 'opacity-0 scale-x-0 group-hover:opacity-50 group-hover:scale-x-75'"></span>
                            </a>
                        @else
                            <a href="{{ $item['href'] }}" @click.prevent="scrollToSection($event, '{{ $item['href'] }}')"
                               class="relative px-2.5 lg:px-3 py-3 text-xs font-semibold uppercase tracking-wider transition-all duration-300 group shrink-0 drop-shadow-sm"
                               :class="active === '{{ $item['id'] }}'
                                    ? 'text-cyan-600 dark:text-cyan-400'
                                    : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white'">
                                <span x-text="t('{{ $item['tKey'] }}')">{{ $item['label'] }}</span>
                                <span class="absolute bottom-1.5 left-2.5 right-2.5 lg:left-3 lg:right-3 h-[3px] bg-cyan-500 dark:bg-cyan-400 rounded-full transition-all duration-300"
                                    :class="active === '{{ $item['id'] }}'
                                            ? 'opacity-100 scale-x-100'
                                            : 'opacity-0 scale-x-0 group-hover:opacity-50 group-hover:scale-x-75'"></span>
                            </a>
                        @endif
                    @endforeach
                </div>

                <div class="flex items-center rounded-xl border border-white/40 dark:border-white/10 bg-white/30 dark:bg-white/5 backdrop-blur-md overflow-hidden ml-1 shrink-0"
                     role="group" :aria-label="t('toggleLanguage')">
                    <button @click="$store.lang.set('en')" :class="$store.lang.current === 'en' ? '{{ $langBtnActive }}' : '{{ $langBtnInactive }}'"
                            class="{{ $langBtnBase }} px-2" aria-label="English">EN</button>
                    <button @click="$store.lang.set('id')" :class="$store.lang.current === 'id' ? '{{ $langBtnActive }}' : '{{ $langBtnInactive }}'"
                            class="{{ $langBtnBase }} px-2 border-l border-white/30 dark:border-white/5" aria-label="Bahasa Indonesia">ID</button>
                </div>

                <button @click="toggleTheme"
                        class="w-9 h-9 flex items-center justify-center rounded-xl border border-white/40 dark:border-white/10 bg-white/30 dark:bg-white/5 backdrop-blur-md text-slate-700 dark:text-yellow-400 hover:bg-white/60 dark:hover:bg-white/10 transition-all duration-300 cursor-pointer shrink-0"
                        aria-label="Toggle theme">
                    <i class="text-base drop-shadow-sm" :class="dark ? 'ri-sun-fill' : 'ri-moon-fill'"></i>
                </button>
            </div>
        </div>
    </nav>
</div>

<!-- Navbar Mobile -->
<nav class="fixed top-[calc(0.75rem+env(safe-area-inset-top,0px))] left-2.5 right-2.5 sm:left-4 sm:right-4 z-50 md:hidden max-w-full" x-cloak>
    <div class="relative rounded-2xl border border-white/40 dark:border-white/10 bg-white/40 dark:bg-slate-900/40 backdrop-blur-xl shadow-[0_8px_32px_rgba(0,0,0,0.08)] dark:shadow-[0_8px_32px_rgba(0,0,0,0.25)] overflow-hidden">
        <div class="flex items-center justify-between gap-1.5 py-1.5 px-2">

            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-1 overflow-x-auto scrollbar-none py-0.5 px-0.5 scroll-smooth">
                    @foreach($menuItems as $item)
                        @if (! empty($item['external']))
                            <a href="{{ $item['href'] }}"
                               class="flex flex-col items-center justify-center py-1 px-2 min-w-[48px] rounded-xl transition-all duration-300 shrink-0 select-none drop-shadow-sm"
                               :class="active === '{{ $item['id'] }}'
                                    ? 'text-cyan-600 dark:text-cyan-400 bg-white/50 dark:bg-white/10 font-semibold border border-white/40 dark:border-white/5'
                                    : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-white/30 dark:hover:bg-white/5 border border-transparent'">
                                <i class="{{ $item['icon'] }} text-sm leading-none mb-0.5"></i>
                                <span class="text-[9px] leading-tight font-medium tracking-tight whitespace-nowrap" x-text="t('{{ $item['tKey'] }}')">{{ $item['label'] }}</span>
                            </a>
                        @else
                            <a href="{{ $item['href'] }}" @click.prevent="scrollToSection($event, '{{ $item['href'] }}')"
                               class="flex flex-col items-center justify-center py-1 px-2 min-w-[48px] rounded-xl transition-all duration-300 shrink-0 select-none drop-shadow-sm"
                               :class="active === '{{ $item['id'] }}'
                                    ? 'text-cyan-600 dark:text-cyan-400 bg-white/50 dark:bg-white/10 font-semibold border border-white/40 dark:border-white/5'
                                    : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-slate-100 hover:bg-white/30 dark:hover:bg-white/5 border border-transparent'">
                                <i class="{{ $item['icon'] }} text-sm leading-none mb-0.5"></i>
                                <span class="text-[9px] leading-tight font-medium tracking-tight whitespace-nowrap" x-text="t('{{ $item['tKey'] }}')">{{ $item['label'] }}</span>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="w-px h-6 bg-slate-300/50 dark:bg-white/10 shrink-0 mx-0.5"></div>

            <div class="flex items-center gap-1.5 shrink-0 pl-1">
                <div class="flex items-center rounded-lg border border-white/40 dark:border-white/10 bg-white/30 dark:bg-white/5 backdrop-blur-md overflow-hidden"
                     role="group" :aria-label="t('toggleLanguage')">
                    <button @click="$store.lang.set('en')" :class="$store.lang.current === 'en' ? '{{ $langBtnActive }}' : '{{ $langBtnInactive }}'"
                            class="h-7 px-1.5 flex items-center justify-center text-[10px] font-bold cursor-pointer transition-all duration-200 select-none" aria-label="English">EN</button>
                    <button @click="$store.lang.set('id')" :class="$store.lang.current === 'id' ? '{{ $langBtnActive }}' : '{{ $langBtnInactive }}'"
                            class="h-7 px-1.5 flex items-center justify-center text-[10px] font-bold cursor-pointer transition-all duration-200 select-none border-l border-white/30 dark:border-white/5" aria-label="Bahasa Indonesia">ID</button>
                </div>

                <button @click="toggleTheme"
                        class="w-7 h-7 flex items-center justify-center rounded-lg border border-white/40 dark:border-white/10 bg-white/30 dark:bg-white/5 backdrop-blur-md text-slate-700 dark:text-yellow-400 hover:bg-white/60 dark:hover:bg-white/10 transition-all duration-200 cursor-pointer shrink-0"
                        aria-label="Toggle theme">
                    <i class="text-xs drop-shadow-sm" :class="dark ? 'ri-sun-fill' : 'ri-moon-fill'"></i>
                </button>
            </div>

        </div>
    </div>
</nav>
