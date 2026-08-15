@php
    $menuItems = [
        ['id' => 'beranda', 'tKey' => 'navHome', 'label' => 'Home', 'href' => '#beranda', 'icon' => 'ri-home-5-line'],
        ['id' => 'tentang', 'tKey' => 'navAbout', 'label' => 'About', 'href' => '#tentang', 'icon' => 'ri-user-line'],
        ['id' => 'skills', 'tKey' => 'navSkills', 'label' => 'Skills', 'href' => '#skills', 'icon' => 'ri-tools-line'],
        ['id' => 'proyek', 'tKey' => 'navProjects', 'label' => 'Projects', 'href' => '#proyek', 'icon' => 'ri-folder-open-line'],
        ['id' => 'experiences', 'tKey' => 'navExperiences', 'label' => 'Experiences', 'href' => '#experiences', 'icon' => 'ri-briefcase-line'],
        ['id' => 'certificates', 'tKey' => 'navCertificates', 'label' => 'Certificates', 'href' => '#certificates', 'icon' => 'ri-award-line'],
        ['id' => 'kontak', 'tKey' => 'navContact', 'label' => 'Contact', 'href' => '#kontak', 'icon' => 'ri-chat-3-line'],
    ];

    $langBtnBase = 'h-9 flex items-center justify-center text-xs font-bold cursor-pointer transition-all duration-300 select-none';
    $langBtnActive = 'bg-accent text-white shadow-sm';
    $langBtnInactive = 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-300/60 dark:hover:bg-white/5';

@endphp

<div class="fixed top-4 left-0 right-0 z-100 hidden md:block" x-cloak>

    <nav class="mx-auto w-[calc(100%-2rem)] max-w-6xl transition-all duration-300 rounded-2xl border backdrop-blur-md shadow-lg bg-white/70 dark:bg-[#0b1329]/90"
         :class="scrolled
            ? 'py-1 border-slate-200/50 dark:border-white/10 shadow-slate-200/40 dark:shadow-black/20'
            : 'py-1.5 border-slate-200/30 dark:border-white/5 shadow-slate-200/30 dark:shadow-black/10'">
        <div class="px-6 flex items-center justify-between">

            <a href="#beranda" @click.prevent="scrollToSection($event, '#beranda')"
               class="flex items-center gap-1 font-poppins font-bold text-lg tracking-tight select-none">
                <span class="text-amber-500">Adya</span>
                <span class="text-slate-800 dark:text-white">'s Portfolio</span>
                <span class="text-cyan-500 dark:text-cyan-400">.</span>
            </a>

            <div class="flex items-center gap-2 lg:gap-4">
                @foreach($menuItems as $item)
                    <a href="{{ $item['href'] }}" @click.prevent="scrollToSection($event, '{{ $item['href'] }}')"
                       class="relative px-3 py-4 text-xs font-semibold uppercase tracking-wider transition-all duration-300 group"
                       :class="active === '{{ $item['id'] }}'
                            ? 'text-cyan-500 dark:text-cyan-400'
                            : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'">
                        <span x-text="t('{{ $item['tKey'] }}')">{{ $item['label'] }}</span>
                        <span class="absolute bottom-2 left-3 right-3 h-0.5 bg-cyan-500 dark:bg-cyan-400 rounded-full transition-all duration-300"
                              :class="active === '{{ $item['id'] }}'
                                    ? 'opacity-100 scale-x-100'
                                    : 'opacity-0 scale-x-0 group-hover:opacity-50 group-hover:scale-x-75'"></span>
                    </a>
                @endforeach

                <div class="flex items-center rounded-lg border border-slate-200 dark:border-white/10 bg-slate-200/60 dark:bg-slate-950/40 overflow-hidden shadow-inner ml-1"
                     role="group" :aria-label="t('toggleLanguage')">
                    <button @click="$store.lang.set('en')" :class="$store.lang.current === 'en' ? '{{ $langBtnActive }}' : '{{ $langBtnInactive }}'"
                            class="{{ $langBtnBase }} px-2" aria-label="English">EN</button>
                    <button @click="$store.lang.set('id')" :class="$store.lang.current === 'id' ? '{{ $langBtnActive }}' : '{{ $langBtnInactive }}'"
                            class="{{ $langBtnBase }} px-2 border-l border-slate-200 dark:border-white/10" aria-label="Bahasa Indonesia">ID</button>
                </div>

                <button @click="toggleTheme"
                        class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-200 dark:border-white/10 bg-slate-200/60 dark:bg-slate-950/40 text-slate-700 dark:text-yellow-400 hover:bg-slate-300/80 dark:hover:bg-slate-900 transition-all duration-300 cursor-pointer shadow-inner"
                        aria-label="Toggle theme">
                    <i class="text-base" :class="dark ? 'ri-sun-fill' : 'ri-moon-fill text-slate-600'"></i>
                </button>
            </div>
        </div>
    </nav>
</div>

<nav class="fixed top-[calc(1rem+env(safe-area-inset-top,0px))] left-4 right-4 z-100 md:hidden" x-cloak>
    <div class="relative rounded-2xl border border-slate-200/50 dark:border-white/10 bg-slate-100/95 dark:bg-[#0b1329]/95 backdrop-blur-2xl shadow-lg shadow-slate-200/20 dark:shadow-black/30">
        <div class="flex items-center justify-between gap-1 overflow-x-auto scrollbar-none py-2 px-3">

            <div class="flex items-center gap-1 flex-1 overflow-x-auto scrollbar-none">
                @foreach($menuItems as $item)
                    <a href="{{ $item['href'] }}" @click.prevent="scrollToSection($event, '{{ $item['href'] }}')"
                       class="flex flex-col items-center justify-center p-1.5 min-w-14.5 rounded-xl transition-all duration-300"
                       :class="active === '{{ $item['id'] }}'
                            ? 'text-cyan-500 dark:text-cyan-400 bg-slate-200/70 dark:bg-white/5'
                            : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200'">
                        <i class="{{ $item['icon'] }} text-base mb-0.5"></i>
                        <span class="text-[9px] font-medium tracking-wide whitespace-nowrap" x-text="t('{{ $item['tKey'] }}')">{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </div>

            <div class="w-px h-6 bg-slate-200 dark:bg-white/10 mx-2 shrink-0"></div>

            <div class="flex items-center rounded-xl bg-slate-200/60 dark:bg-white/5 overflow-hidden shrink-0"
                 role="group" :aria-label="t('toggleLanguage')">
                <button @click="$store.lang.set('en')" :class="$store.lang.current === 'en' ? '{{ $langBtnActive }}' : '{{ $langBtnInactive }}'"
                        class="{{ $langBtnBase }} px-2.5" aria-label="English">EN</button>
                <button @click="$store.lang.set('id')" :class="$store.lang.current === 'id' ? '{{ $langBtnActive }}' : '{{ $langBtnInactive }}'"
                        class="{{ $langBtnBase }} px-2.5 border-l border-slate-200 dark:border-white/10" aria-label="Bahasa Indonesia">ID</button>
            </div>

            <button @click="toggleTheme"
                    class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-200/60 dark:bg-white/5 text-slate-700 dark:text-yellow-400 shrink-0 ml-2"
                    aria-label="Toggle theme">
                <i class="text-base" :class="dark ? 'ri-sun-fill' : 'ri-moon-fill text-slate-600'"></i>
            </button>
        </div>
    </div>
</nav>
