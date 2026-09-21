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

    $shellScrolled =
        'bg-white/95 dark:bg-[#101018]/95 border-line dark:border-white/10 shadow-[0_10px_30px_-16px_rgba(15,23,42,0.45)] dark:shadow-[0_10px_30px_-16px_rgba(0,0,0,0.85)]';
    $shellTop =
        'bg-white/90 dark:bg-[#101018]/85 border-line/70 dark:border-white/10 shadow-[0_2px_14px_-8px_rgba(15,23,42,0.28)] dark:shadow-none';

    $linkActive = 'text-accent dark:text-accent-light';
    $linkIdle = 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white';

    $langBtnBase = 'h-9 flex items-center justify-center text-xs font-bold cursor-pointer transition-all duration-300 select-none';
    $langBtnActive = 'bg-accent text-white';
    $langBtnInactive = 'text-slate-600 dark:text-slate-300 hover:bg-white dark:hover:bg-white/10 hover:text-slate-900 dark:hover:text-white';
@endphp

<!-- Navbar Desktop -->
<div class="fixed top-4 left-0 right-0 z-50 hidden md:block" x-cloak>
    <nav class="mx-auto w-[calc(100%-2rem)] max-w-6xl transition-all duration-300 rounded-2xl border py-2"
         :class="scrolled ? '{{ $shellScrolled }}' : '{{ $shellTop }}'">
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
                        @php $linkClasses = 'relative px-2.5 lg:px-3 py-3 text-xs font-semibold uppercase tracking-wider transition-all duration-300 group shrink-0'; @endphp
                        @if (! empty($item['external']))
                            <a href="{{ $item['href'] }}"
                               class="{{ $linkClasses }}"
                               :class="active === '{{ $item['id'] }}' ? '{{ $linkActive }}' : '{{ $linkIdle }}'">
                                <span x-text="t('{{ $item['tKey'] }}')">{{ $item['label'] }}</span>
                                <span class="absolute bottom-1.5 left-2.5 right-2.5 lg:left-3 lg:right-3 h-0.5 rounded-full bg-accent transition-all duration-300"
                                    :class="active === '{{ $item['id'] }}'
                                            ? 'opacity-100 scale-x-100'
                                            : 'opacity-0 scale-x-0 group-hover:opacity-50 group-hover:scale-x-75'"></span>
                            </a>
                        @else
                            <a href="{{ $item['href'] }}" @click.prevent="scrollToSection($event, '{{ $item['href'] }}')"
                               class="{{ $linkClasses }}"
                               :class="active === '{{ $item['id'] }}' ? '{{ $linkActive }}' : '{{ $linkIdle }}'">
                                <span x-text="t('{{ $item['tKey'] }}')">{{ $item['label'] }}</span>
                                <span class="absolute bottom-1.5 left-2.5 right-2.5 lg:left-3 lg:right-3 h-0.5 rounded-full bg-accent transition-all duration-300"
                                    :class="active === '{{ $item['id'] }}'
                                            ? 'opacity-100 scale-x-100'
                                            : 'opacity-0 scale-x-0 group-hover:opacity-50 group-hover:scale-x-75'"></span>
                            </a>
                        @endif
                    @endforeach
                </div>

                <div class="flex items-center rounded-xl border border-line dark:border-white/10 bg-slate-100 dark:bg-white/5 overflow-hidden ml-1 shrink-0"
                     role="group" :aria-label="t('toggleLanguage')">
                    <button @click="$store.lang.set('en')" :class="$store.lang.current === 'en' ? '{{ $langBtnActive }}' : '{{ $langBtnInactive }}'"
                            class="{{ $langBtnBase }} px-2" aria-label="English">EN</button>
                    <button @click="$store.lang.set('id')" :class="$store.lang.current === 'id' ? '{{ $langBtnActive }}' : '{{ $langBtnInactive }}'"
                            class="{{ $langBtnBase }} px-2" aria-label="Bahasa Indonesia">ID</button>
                </div>

                <button @click="toggleTheme" type="button"
                        class="icon-btn w-9 h-9 shrink-0"
                        :aria-label="dark ? 'Switch to light theme' : 'Switch to dark theme'">
                    <i class="text-base" :class="dark ? 'ri-sun-fill text-amber-400' : 'ri-moon-fill'" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </nav>
</div>

<!-- Navbar Mobile -->
<nav class="fixed top-[calc(0.75rem+env(safe-area-inset-top,0px))] left-2.5 right-2.5 sm:left-4 sm:right-4 z-50 md:hidden max-w-full" x-cloak>
    <div class="relative rounded-2xl border border-line dark:border-white/10 bg-white/95 dark:bg-[#101018]/95 shadow-[0_10px_30px_-16px_rgba(15,23,42,0.45)] dark:shadow-[0_10px_30px_-16px_rgba(0,0,0,0.85)] overflow-hidden">
        <div class="flex items-center justify-between gap-1.5 py-1.5 px-2">

            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-1 overflow-x-auto scrollbar-none py-0.5 px-0.5 scroll-smooth">
                    @foreach($menuItems as $item)
                        @php $itemClasses = 'flex flex-col items-center justify-center py-1 px-2 min-w-[48px] rounded-xl transition-all duration-300 shrink-0 select-none border'; @endphp
                        @php $itemActive = 'text-accent dark:text-accent-light bg-accent/10 border-accent/20 font-semibold'; @endphp
                        @php $itemIdle = 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-white/5 border-transparent'; @endphp
                        @if (! empty($item['external']))
                            <a href="{{ $item['href'] }}"
                               class="{{ $itemClasses }}"
                               :class="active === '{{ $item['id'] }}' ? '{{ $itemActive }}' : '{{ $itemIdle }}'">
                                <i class="{{ $item['icon'] }} text-sm leading-none mb-0.5" aria-hidden="true"></i>
                                <span class="text-[9px] leading-tight font-medium tracking-tight whitespace-nowrap" x-text="t('{{ $item['tKey'] }}')">{{ $item['label'] }}</span>
                            </a>
                        @else
                            <a href="{{ $item['href'] }}" @click.prevent="scrollToSection($event, '{{ $item['href'] }}')"
                               class="{{ $itemClasses }}"
                               :class="active === '{{ $item['id'] }}' ? '{{ $itemActive }}' : '{{ $itemIdle }}'">
                                <i class="{{ $item['icon'] }} text-sm leading-none mb-0.5" aria-hidden="true"></i>
                                <span class="text-[9px] leading-tight font-medium tracking-tight whitespace-nowrap" x-text="t('{{ $item['tKey'] }}')">{{ $item['label'] }}</span>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="w-px h-6 bg-slate-200 dark:bg-white/10 shrink-0 mx-0.5"></div>

            <div class="flex items-center gap-1.5 shrink-0 pl-1">
                <div class="flex items-center rounded-lg border border-line dark:border-white/10 bg-slate-100 dark:bg-white/5 overflow-hidden"
                     role="group" :aria-label="t('toggleLanguage')">
                    <button @click="$store.lang.set('en')" :class="$store.lang.current === 'en' ? '{{ $langBtnActive }}' : '{{ $langBtnInactive }}'"
                            class="h-7 px-1.5 flex items-center justify-center text-[10px] font-bold cursor-pointer transition-all duration-200 select-none" aria-label="English">EN</button>
                    <button @click="$store.lang.set('id')" :class="$store.lang.current === 'id' ? '{{ $langBtnActive }}' : '{{ $langBtnInactive }}'"
                            class="h-7 px-1.5 flex items-center justify-center text-[10px] font-bold cursor-pointer transition-all duration-200 select-none" aria-label="Bahasa Indonesia">ID</button>
                </div>

                <button @click="toggleTheme" type="button"
                        class="icon-btn w-7 h-7 shrink-0"
                        :aria-label="dark ? 'Switch to light theme' : 'Switch to dark theme'">
                    <i class="text-xs" :class="dark ? 'ri-sun-fill text-amber-400' : 'ri-moon-fill'" aria-hidden="true"></i>
                </button>
            </div>

        </div>
    </div>
</nav>
