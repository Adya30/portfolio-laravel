@php
    $menuItems = [
        ['id' => 'beranda', 'tKey' => 'navHome', 'label' => 'Home', 'href' => '#beranda', 'icon' => 'ri-home-5-line'],
        ['id' => 'tentang', 'tKey' => 'navAbout', 'label' => 'About', 'href' => '#tentang', 'icon' => 'ri-user-3-line'],
        [
            'id' => 'proyek',
            'tKey' => 'navProjects',
            'label' => 'Projects',
            'href' => '#proyek',
            'icon' => 'ri-folder-open-line',
        ],
        [
            'id' => 'experiences',
            'tKey' => 'navExperiences',
            'label' => 'Experiences',
            'href' => '#experiences',
            'icon' => 'ri-briefcase-line',
        ],
        [
            'id' => 'certificates',
            'tKey' => 'navCertificates',
            'label' => 'Certificates',
            'href' => '#certificates',
            'icon' => 'ri-award-line',
        ],
        [
            'id' => 'kontak',
            'tKey' => 'navContact',
            'label' => 'Contact',
            'href' => '#kontak',
            'icon' => 'ri-chat-3-line',
        ],
        [
            'id' => 'course',
            'tKey' => 'navCourse',
            'label' => 'Course',
            'href' => route('course.index'),
            'icon' => 'ri-book-open-line',
            'external' => true,
        ],
    ];
@endphp

<div class="fixed top-4 md:top-5 left-0 right-0 z-50 hidden md:block" x-cloak>
    <nav
        class="mx-auto w-[calc(100%-2.5rem)] max-w-6xl transition-all duration-300 rounded-2xl sm:rounded-3xl border border-slate-200/80 dark:border-white/10 bg-white/95 dark:bg-[#12121a]/95 backdrop-blur-md shadow-[0_10px_30px_-8px_rgba(0,0,0,0.08)] dark:shadow-[0_10px_30px_-8px_rgba(0,0,0,0.65)] py-2.5 px-6 lg:px-8">
        <div class="flex items-center justify-between gap-4">

            <a href="#beranda" @click.prevent="scrollToSection($event, '#beranda')"
                class="flex items-center font-poppins font-bold text-lg lg:text-xl tracking-tight select-none shrink-0 group transition-transform active:scale-95">
                <span class="text-orange-500">Adya</span>
                <span class="text-slate-900 dark:text-white">’s Portoflio</span>
            </a>

            <div class="flex items-center gap-1 lg:gap-2 xl:gap-3 overflow-x-auto scrollbar-none">
                @foreach ($menuItems as $item)
                    @if (!empty($item['external']))
                        <a href="{{ $item['href'] }}"
                            class="transition-all duration-300 select-none shrink-0 text-sm font-bold"
                            :class="active === '{{ $item['id'] }}'
                                ?
                                'bg-orange-500 text-white rounded-full px-4 lg:px-5 py-1.5 lg:py-2' :
                                'text-slate-900 dark:text-slate-100 hover:text-orange-500 dark:hover:text-orange-400 px-2.5 lg:px-3.5 py-1.5 lg:py-2'">
                            <span x-text="t('{{ $item['tKey'] }}')">{{ $item['label'] }}</span>
                        </a>
                    @else
                        <a href="{{ $item['href'] }}" @click.prevent="scrollToSection($event, '{{ $item['href'] }}')"
                            class="transition-all duration-300 select-none shrink-0 text-sm font-bold"
                            :class="active === '{{ $item['id'] }}'
                                ?
                                'bg-orange-500 text-white rounded-full px-4 lg:px-5 py-1.5 lg:py-2' :
                                'text-slate-900 dark:text-slate-100 hover:text-orange-500 dark:hover:text-orange-400 px-2.5 lg:px-3.5 py-1.5 lg:py-2'">
                            <span x-text="t('{{ $item['tKey'] }}')">{{ $item['label'] }}</span>
                        </a>
                    @endif
                @endforeach
            </div>

            <div class="flex items-center gap-2.5 shrink-0">
                <div
                    class="inline-flex items-center p-0.5 rounded-full border border-slate-300 dark:border-white/20 bg-slate-100/90 dark:bg-white/10 select-none">
                    <button @click="$store.lang.set('en')" type="button"
                        :class="$store.lang.current === 'en' ?
                            'bg-orange-500 text-white font-bold' :
                            'text-slate-600 dark:text-slate-300 hover:text-orange-500 dark:hover:text-orange-400 font-semibold'"
                        class="px-2.5 py-1 text-xs rounded-full transition-all duration-200 cursor-pointer">
                        ENG
                    </button>
                    <button @click="$store.lang.set('id')" type="button"
                        :class="$store.lang.current === 'id' ?
                            'bg-orange-500 text-white font-bold' :
                            'text-slate-600 dark:text-slate-300 hover:text-orange-500 dark:hover:text-orange-400 font-semibold'"
                        class="px-2.5 py-1 text-xs rounded-full transition-all duration-200 cursor-pointer">
                        IND
                    </button>
                </div>

                <button @click="toggleTheme" type="button"
                    class="w-8 h-8 lg:w-9 lg:h-9 rounded-xl bg-slate-100/90 dark:bg-white/10 hover:bg-slate-200/90 dark:hover:bg-white/20 border border-slate-300 dark:border-white/20 flex items-center justify-center text-slate-800 dark:text-slate-100 transition-all cursor-pointer active:scale-95 shrink-0"
                    :aria-label="dark ? 'Switch to light theme' : 'Switch to dark theme'">
                    <i class="text-sm lg:text-base leading-none"
                        :class="dark ? 'ri-sun-line text-amber-400' : 'ri-moon-line text-slate-800'"
                        aria-hidden="true"></i>
                </button>
            </div>

        </div>
    </nav>
</div>

<nav class="fixed top-[calc(0.75rem+env(safe-area-inset-top,0px))] left-3 right-3 z-50 md:hidden max-w-full" x-cloak>
    <div
        class="relative rounded-2xl sm:rounded-3xl border border-slate-200/80 dark:border-white/10 bg-white/95 dark:bg-[#12121a]/95 backdrop-blur-md shadow-[0_10px_25px_-5px_rgba(0,0,0,0.08)] dark:shadow-[0_10px_25px_-5px_rgba(0,0,0,0.7)] px-3 py-2 flex items-center justify-between gap-2">

        <div class="flex-1 min-w-0 overflow-x-auto scrollbar-none py-0.5 scroll-smooth pr-1">
            <div class="w-full min-w-max flex items-center justify-between gap-1 sm:gap-1.5">
                @foreach ($menuItems as $item)
                    @if (!empty($item['external']))
                        <a href="{{ $item['href'] }}"
                            :title="t('{{ $item['tKey'] }}')"
                            :aria-label="t('{{ $item['tKey'] }}')"
                            class="flex items-center justify-center shrink-0 transition-all duration-300 active:scale-95 select-none"
                            :class="active === '{{ $item['id'] }}'
                                ? 'bg-orange-500 text-white rounded-full px-3 py-1.5 gap-1.5 shadow-sm'
                                : 'w-8 h-8 rounded-full text-slate-700 dark:text-slate-300 hover:text-orange-500 dark:hover:text-orange-400 hover:bg-slate-100 dark:hover:bg-white/10'">
                            <i class="{{ $item['icon'] }} text-base leading-none shrink-0" aria-hidden="true"></i>
                            <span x-show="active === '{{ $item['id'] }}'"
                                x-transition:enter="transition-all ease-out duration-200"
                                x-transition:enter-start="opacity-0 max-w-0"
                                x-transition:enter-end="opacity-100 max-w-xs"
                                class="text-xs font-bold whitespace-nowrap overflow-hidden"
                                x-text="t('{{ $item['tKey'] }}')">
                                {{ $item['label'] }}
                            </span>
                        </a>
                    @else
                        <a href="{{ $item['href'] }}" @click.prevent="active = '{{ $item['id'] }}'; scrollToSection($event, '{{ $item['href'] }}')"
                            :title="t('{{ $item['tKey'] }}')"
                            :aria-label="t('{{ $item['tKey'] }}')"
                            class="flex items-center justify-center shrink-0 transition-all duration-300 active:scale-95 select-none cursor-pointer"
                            :class="active === '{{ $item['id'] }}'
                                ? 'bg-orange-500 text-white rounded-full px-3 py-1.5 gap-1.5 shadow-sm'
                                : 'w-8 h-8 rounded-full text-slate-700 dark:text-slate-300 hover:text-orange-500 dark:hover:text-orange-400 hover:bg-slate-100 dark:hover:bg-white/10'">
                            <i class="{{ $item['icon'] }} text-base leading-none shrink-0" aria-hidden="true"></i>
                            <span x-show="active === '{{ $item['id'] }}'"
                                x-transition:enter="transition-all ease-out duration-200"
                                x-transition:enter-start="opacity-0 max-w-0"
                                x-transition:enter-end="opacity-100 max-w-xs"
                                class="text-xs font-bold whitespace-nowrap overflow-hidden"
                                x-text="t('{{ $item['tKey'] }}')">
                                {{ $item['label'] }}
                            </span>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="w-px h-5 bg-slate-200 dark:bg-white/10 shrink-0"></div>

        <div class="flex items-center gap-1.5 shrink-0">
            <div
                class="inline-flex items-center p-0.5 rounded-full border border-slate-300 dark:border-white/20 bg-slate-100/90 dark:bg-white/10 select-none">
                <button @click="$store.lang.set('en')" type="button"
                    :class="$store.lang.current === 'en' ?
                        'bg-orange-500 text-white font-bold' :
                        'text-slate-600 dark:text-slate-300 hover:text-orange-500 dark:hover:text-orange-400 font-semibold'"
                    class="px-2 py-0.5 text-[10px] rounded-full transition-all duration-200 cursor-pointer">
                    ENG
                </button>
                <button @click="$store.lang.set('id')" type="button"
                    :class="$store.lang.current === 'id' ?
                        'bg-orange-500 text-white font-bold' :
                        'text-slate-600 dark:text-slate-300 hover:text-orange-500 dark:hover:text-orange-400 font-semibold'"
                    class="px-2 py-0.5 text-[10px] rounded-full transition-all duration-200 cursor-pointer">
                    IND
                </button>
            </div>

            <button @click="toggleTheme" type="button"
                class="w-7 h-7 rounded-lg bg-slate-100/90 dark:bg-white/10 hover:bg-slate-200/90 dark:hover:bg-white/20 border border-slate-300 dark:border-white/20 flex items-center justify-center text-slate-800 dark:text-slate-100 transition-all cursor-pointer shrink-0"
                :aria-label="dark ? 'Switch to light theme' : 'Switch to dark theme'">
                <i class="text-xs leading-none"
                    :class="dark ? 'ri-sun-line text-amber-400' : 'ri-moon-line text-slate-800'"
                    aria-hidden="true"></i>
            </button>
        </div>

    </div>
</nav>
