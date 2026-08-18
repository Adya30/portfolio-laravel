@extends('layouts.course')

@section('topbar')
    <div class="fixed top-4 left-4 right-4 z-100 flex items-center justify-between pointer-events-none" x-cloak>
        <div class="pointer-events-auto">
            <button type="button" @click="toggleSidebar"
                    :aria-label="t('toggleSidebar')" :title="t('toggleSidebar')"
                    class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl border border-slate-200/80 dark:border-white/10 bg-white/90 dark:bg-[#0a0a0f]/90 text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400 hover:border-blue-300 dark:hover:border-blue-700 transition-all duration-300 cursor-pointer shadow-sm">
                <i class="ri-menu-line text-lg"></i>
            </button>
        </div>
        <div class="pointer-events-auto ml-auto flex items-center gap-2 p-1 rounded-xl border bg-white/90 dark:bg-[#0a0a0f]/90 border-slate-200 dark:border-white/10">
            @include('course._toggles')
        </div>
    </div>
@endsection

@section('content')

@php
    $nama = $course->nama;
    $namaIdn = $course->nama_idn ?? null;
    $desk = $course->desk ?? null;
    $deskIdn = $course->desk_idn ?? null;
    $blocks = $course->konten ?? [];
    $codeLangs = ['php', 'javascript', 'typescript', 'html', 'css', 'sql', 'python', 'bash', 'json', 'csharp', 'java'];
    $subbabs = [];
    foreach ($blocks as $idx => $block) {
        if (($block['type'] ?? '') === 'subbab') {
            $subbabs[] = ['id' => 'subbab-'.$idx, 'judul' => $block['judul'] ?? ''];
        }
    }
@endphp

<div class="relative z-20 flex min-h-screen pt-4">

    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
         class="fixed inset-0 z-105 bg-black/50 backdrop-blur-sm lg:hidden"></div>

    <aside x-cloak
           class="fixed top-4 left-4 z-110 flex flex-col w-80 max-w-[85vw] border border-slate-200 dark:border-white/10 h-[calc(100vh-2rem)] bg-white dark:bg-[#0a0a0f] rounded-2xl shadow-lg shadow-slate-200/50 dark:shadow-black/50 overflow-hidden transition-all duration-300 ease-in-out"
           :class="sidebarOpen
               ? 'translate-x-0 lg:w-80'
               : '-translate-x-[calc(100%+1rem)] lg:translate-x-0 lg:w-16'">

        <div :class="sidebarOpen ? 'hidden' : 'flex'"
             class="flex-col items-center gap-2 py-4 h-full overflow-y-auto custom-scrollbar">
            <a href="{{ route('course.index') }}"
               :title="t('backToOverview')" :aria-label="t('backToOverview')"
               class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-500 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-slate-100 dark:hover:bg-white/10 transition-colors">
                <i class="ri-arrow-left-line text-lg"></i>
            </a>
            <button type="button" @click="toggleSidebar"
                    :aria-label="t('toggleSidebar')" :title="t('toggleSidebar')"
                    class="w-9 h-9 flex items-center justify-center rounded-xl text-slate-500 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-slate-100 dark:hover:bg-white/10 transition-colors cursor-pointer">
                <i class="ri-menu-unfold-line text-lg"></i>
            </button>
            <div class="w-6 border-t border-slate-200 dark:border-white/10 my-1"></div>
            @foreach ($allCourses as $i => $item)
                @php $isActive = $item->id === $course->id; @endphp
                <a href="{{ route('course.show', $item) }}" title="{{ $item->nama }}"
                   class="w-9 h-9 flex items-center justify-center rounded-lg text-xs font-semibold transition-all duration-200
                          {{ $isActive
                              ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 border border-blue-200 dark:border-blue-700'
                              : 'text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/10 border border-transparent' }}">
                    {{ $i + 1 }}
                </a>
            @endforeach
        </div>

        <div :class="sidebarOpen ? '' : 'lg:hidden'"
             class="flex flex-col flex-1 min-h-0">
            <div class="p-5 border-b border-slate-200 dark:border-white/10 flex items-start justify-between gap-3">
                <div>
                    <a href="{{ route('course.index') }}"
                       class="text-xs font-medium uppercase tracking-wider text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors flex items-center mb-3 group">
                        <i class="ri-arrow-left-line mr-1.5 group-hover:-translate-x-1 transition-transform"></i>
                        <span x-text="t('backToOverview')">Back to Overview</span>
                    </a>
                    <h2 class="font-poppins font-semibold text-lg text-slate-900 dark:text-white flex items-center gap-2">
                        <i class="ri-book-open-line text-blue-600 dark:text-blue-400"></i>
                        <span x-text="t('course')">Course</span>
                    </h2>
                </div>
                <button type="button" @click="toggleSidebar"
                        :aria-label="t('toggleSidebar')" :title="t('toggleSidebar')"
                        class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/10 hover:text-slate-700 dark:hover:text-white transition-colors cursor-pointer shrink-0">
                    <i class="ri-close-line text-lg lg:hidden"></i>
                    <i class="ri-menu-line text-lg hidden lg:block"></i>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto custom-scrollbar p-3 space-y-1">
                @foreach ($allCourses as $i => $item)
                    @php $isActive = $item->id === $course->id; @endphp
                    <a href="{{ route('course.show', $item) }}"
                       class="flex items-start gap-3 p-2.5 rounded-xl text-sm transition-all duration-200
                          {{ $isActive
                              ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 font-semibold border border-blue-200 dark:border-blue-800'
                              : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/5 border border-transparent' }}">
                        <span class="flex items-center justify-center w-6 h-6 rounded-md text-xs shrink-0 border
                                     {{ $isActive
                                         ? 'bg-blue-100 dark:bg-blue-900/30 border-blue-200 dark:border-blue-700 text-blue-700 dark:text-blue-400 font-semibold'
                                         : 'bg-white dark:bg-[#0a0a0f] border-slate-200 dark:border-white/10 text-slate-500 dark:text-slate-400' }}">
                            {{ $i + 1 }}
                        </span>
                        <span class="line-clamp-2 leading-relaxed">{{ $item->nama }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </aside>

    @if (count($subbabs))
        <aside x-cloak x-data="tocSpy"
               class="hidden xl:flex flex-col fixed top-20 right-4 w-72 h-[calc(100vh-6rem)] border border-slate-200 dark:border-white/10 bg-white dark:bg-[#0a0a0f] rounded-2xl shadow-lg shadow-slate-200/50 dark:shadow-black/50 overflow-hidden z-30">
            <div class="p-4 border-b border-slate-200 dark:border-white/10">
                <h2 class="text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-400 flex items-center gap-1.5">
                    <i class="ri-list-unordered text-sm text-blue-600 dark:text-blue-400"></i>
                    <span x-text="t('onThisPage')">Sub Heading</span>
                </h2>
            </div>
            <nav class="flex-1 overflow-y-auto custom-scrollbar p-3 space-y-1">
                @foreach ($subbabs as $sub)
                    <a href="#{{ $sub['id'] }}"
                       class="block px-3 py-2 rounded-lg text-sm leading-snug transition-all duration-200 border-l-2"
                       :class="isActive('{{ $sub['id'] }}')
                           ? 'text-blue-700 dark:text-blue-400 font-semibold bg-blue-50 dark:bg-blue-900/20 border-blue-500'
                           : 'text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-slate-100 dark:hover:bg-white/5 border-transparent'">
                        {{ $sub['judul'] }}
                    </a>
                @endforeach
            </nav>
        </aside>
    @endif

    <main class="flex-1 w-full transition-all duration-300 ease-in-out xl:pr-[19rem]"
          :class="sidebarOpen ? 'lg:pl-[22rem]' : 'lg:pl-[5.5rem]'">
        <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">

            <header class="pt-16 sm:pt-14 lg:pt-2" data-aos="fade-up" data-aos-duration="600">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-50 dark:bg-blue-900/20 rounded-full text-xs font-medium text-blue-700 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
                    <i class="ri-book-open-line"></i>
                    <span x-text="t('chapter')">Chapter</span> {{ $courseIndex + 1 }} <span x-text="t('of')">of</span> {{ $totalCourses }}
                </span>
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-slate-900 dark:text-white leading-tight mt-3">
                    {{ $nama }}
                </h1>

                @if ($desk)
                    <p class="mt-3 text-base sm:text-lg text-slate-600 dark:text-slate-300 leading-relaxed">
                        {{ $desk }}
                    </p>
                @endif
            </header>

            {{-- Mobile TOC drawer (visible only on small screens where the right sidebar is hidden) --}}
            @if (count($subbabs))
                <div x-data="{ tocOpen: false }" class="xl:hidden mt-4">
                    <button type="button" @click="tocOpen = !tocOpen"
                            class="w-full flex items-center justify-between gap-2 px-4 py-2.5 rounded-xl border border-slate-200 dark:border-white/10 bg-white dark:bg-[#0a0a0f] text-sm font-semibold text-slate-700 dark:text-slate-300 hover:border-blue-300 dark:hover:border-blue-700 transition-all cursor-pointer">
                        <span class="flex items-center gap-2">
                            <i class="ri-list-unordered text-blue-600 dark:text-blue-400"></i>
                            <span x-text="t('onThisPage')">Sub Heading</span>
                        </span>
                        <i class="ri-arrow-down-s-line text-slate-400 transition-transform duration-200" :class="tocOpen && 'rotate-180'"></i>
                    </button>
                    <div x-show="tocOpen" x-cloak x-collapse
                         class="mt-2 rounded-xl border border-slate-200 dark:border-white/10 bg-white dark:bg-[#0a0a0f] overflow-hidden">
                        <nav class="p-3 space-y-1 max-h-60 overflow-y-auto custom-scrollbar">
                            @foreach ($subbabs as $sub)
                                <a href="#{{ $sub['id'] }}" @click="tocOpen = false"
                                   class="block px-3 py-2 rounded-lg text-sm leading-snug transition-all duration-200 border-l-2
                                          text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-slate-100 dark:hover:bg-white/5 border-transparent">
                                    {{ $sub['judul'] }}
                                </a>
                            @endforeach
                        </nav>
                    </div>
                </div>
            @endif

            @if (count($blocks))
                <article class="min-h-75 mt-4 sm:mt-6 space-y-4" data-aos="fade-up" data-aos-duration="600">
                    @foreach ($blocks as $block)
                        @php $type = $block['type'] ?? 'paragraf'; @endphp

                        @if ($type === 'subbab')
                            <h2 id="subbab-{{ $loop->index }}" class="scroll-mt-24 border-l-4 border-blue-600 dark:border-blue-400 pl-4 font-poppins text-xl sm:text-2xl font-bold text-slate-900 dark:text-white mt-8 mb-3">
                                {{ $block['judul'] ?? '' }}
                            </h2>
                        @elseif ($type === 'paragraf')
                            <div class="text-base sm:text-lg text-slate-700 dark:text-slate-300 leading-relaxed markdown-content">
                                {!! render_markdown($block['teks'] ?? '') !!}
                            </div>
                        @elseif ($type === 'gambar')
                            @php
                                $ukuran = $block['ukuran'] ?? 'penuh';
                                $sizeClass = match($ukuran) {
                                    'kecil' => 'max-w-xs',
                                    'sedang' => 'max-w-md',
                                    'besar' => 'max-w-2xl',
                                    default => 'max-w-full',
                                };
                            @endphp
                            <figure class="my-4 text-center">
                                <div class="inline-block rounded-xl overflow-hidden border border-slate-200 dark:border-white/10 bg-slate-100 dark:bg-slate-800 mx-auto {{ $sizeClass }}">
                                    <img src="{{ img_url($block['url'] ?? '') }}" alt="{{ $block['caption'] ?? $course->nama }}"
                                         class="w-full h-auto object-contain max-h-48 sm:max-h-80 md:max-h-135" loading="lazy">
                                </div>
                                @if (! empty($block['caption']))
                                    <figcaption class="mt-2 text-center text-xs text-slate-500 dark:text-slate-400">
                                        {{ $block['caption'] }}
                                    </figcaption>
                                @endif
                            </figure>
                        @elseif ($type === 'kode')
                            @php
                                $lang = in_array($block['bahasa'] ?? '', $codeLangs, true) ? $block['bahasa'] : 'plaintext';
                                $rawCode = $block['kode'] ?? '';
                                $lines = explode("\n", $rawCode);
                            @endphp
                            <div class="rounded-xl overflow-hidden border border-slate-200 dark:border-white/10 bg-[#0d1117] my-4">
                                {{-- Header --}}
                                <div class="flex items-center justify-between gap-2 sm:gap-3 px-3 sm:px-4 py-2 sm:py-2.5 bg-[#161b22] border-b border-slate-800 select-none">
                                    <div class="flex items-center gap-3">
                                        <div class="flex items-center gap-1.5">
                                            <span class="w-3 h-3 rounded-full bg-[#ff5f56]"></span>
                                            <span class="w-3 h-3 rounded-full bg-[#ffbd2e]"></span>
                                            <span class="w-3 h-3 rounded-full bg-[#27c93f]"></span>
                                        </div>
                                        <span class="px-2.5 py-0.5 rounded text-[11px] font-mono font-medium uppercase tracking-wider text-slate-300 bg-slate-800/80 border border-slate-700">
                                            {{ $lang }}
                                        </span>
                                    </div>
                                    <button type="button" @click="copyCode($el)" title="Salin kode"
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-medium text-slate-300 hover:text-white bg-slate-800 hover:bg-slate-700 border border-slate-700 transition-all cursor-pointer">
                                        <i class="ri-file-copy-line"></i><span x-text="t('copy')">Copy</span>
                                    </button>
                                </div>
                                <div class="overflow-x-auto custom-scrollbar bg-[#0d1117]">
                                    <div class="p-3 sm:p-5 font-mono text-xs sm:text-sm text-slate-100 leading-6 tab-size-4 flex min-w-full bg-[#0d1117]">
                                        <div class="select-none text-slate-500 text-right pr-2 sm:pr-4 border-r border-slate-800 shrink-0 font-mono text-xs sm:text-sm leading-6">
                                            @foreach ($lines as $lineIndex => $lineContent)
                                                <div>{{ $lineIndex + 1 }}</div>
                                            @endforeach
                                        </div>
                                        <pre class="pl-4 font-mono text-xs sm:text-sm leading-6 whitespace-pre overflow-x-visible bg-transparent"><code class="language-{{ $lang }} bg-transparent">{!! e($rawCode) !!}</code></pre>
                                    </div>
                                </div>
                            </div>
                        @elseif ($type === 'link')
                            @php $href = $block['href'] ?? '#'; $label = $block['label'] ?? $href; $desc = $block['desc'] ?? ''; @endphp
                            <div class="my-4">
                                <a href="{{ $href }}" target="_blank" rel="noopener noreferrer"
                                   class="group flex items-start gap-3 sm:gap-4 rounded-xl border border-blue-200 dark:border-blue-800 bg-blue-50/50 dark:bg-blue-900/10 hover:bg-blue-100/50 dark:hover:bg-blue-900/20 p-3 sm:p-5 transition-all duration-200">
                                    <div class="shrink-0 w-9 h-9 sm:w-10 sm:h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center mt-0.5">
                                        <i class="ri-external-link-line text-lg"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-sm sm:text-base text-blue-700 dark:text-blue-400 group-hover:underline truncate">{{ $label }}</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 truncate mt-0.5">{{ $href }}</p>
                                        @if ($desc)
                                            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 mt-1.5 leading-relaxed">{{ $desc }}</p>
                                        @endif
                                    </div>
                                    <div class="shrink-0 text-slate-400 dark:text-slate-500 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors mt-1">
                                        <i class="ri-arrow-right-up-line text-base"></i>
                                    </div>
                                </a>
                            </div>
                        @elseif ($type === 'pembatas')
                            @php $style = $block['style'] ?? 'garis'; @endphp
                            @if ($style === 'garis')
                                <hr class="my-6 border-slate-200 dark:border-white/10">
                            @elseif ($style === 'garis-tebal')
                                <hr class="my-6 border-2 border-slate-300 dark:border-white/20 rounded-full">
                            @elseif ($style === 'dots')
                                <div class="my-6 text-center text-slate-400 dark:text-slate-500 text-xl tracking-[0.6em] select-none">· · ·</div>
                            @elseif ($style === 'spasi')
                                <div class="my-8"></div>
                            @endif
                        @endif
                    @endforeach
                </article>
            @endif

            {{-- Navigation --}}
            <div class="mt-8 sm:mt-10 pt-5 sm:pt-6 border-t border-slate-200 dark:border-white/10 flex flex-col sm:flex-row justify-between gap-3 sm:gap-4">
                @if ($prev)
                    <a href="{{ route('course.show', $prev) }}"
                       class="group flex-1 min-w-0 p-3 sm:p-5 border rounded-xl hover:border-blue-300 dark:hover:border-blue-700 bg-white dark:bg-[#0a0a0f] hover:shadow-lg transition-all text-left">
                        <div class="text-xs font-medium text-blue-600 dark:text-blue-400 uppercase tracking-wider mb-1.5 flex items-center gap-1">
                            <i class="ri-arrow-left-line group-hover:-translate-x-1 transition-transform"></i>
                            <span x-text="t('previousChapter')">Previous Chapter</span>
                        </div>
                        <div class="font-semibold text-base sm:text-lg text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors flex items-center gap-2">
                            <span class="line-clamp-1">{{ $prev->nama }}</span>
                        </div>
                    </a>
                @else
                    <div class="flex-1"></div>
                @endif

                @if ($next)
                    <a href="{{ route('course.show', $next) }}"
                       class="group flex-1 min-w-0 p-3 sm:p-5 border rounded-xl hover:border-blue-300 dark:hover:border-blue-700 bg-white dark:bg-[#0a0a0f] hover:shadow-lg transition-all text-right">
                        <div class="text-xs font-medium text-blue-600 dark:text-blue-400 uppercase tracking-wider mb-1.5 flex items-center justify-end gap-1">
                            <span x-text="t('nextChapter')">Next Chapter</span>
                            <i class="ri-arrow-right-line group-hover:translate-x-1 transition-transform"></i>
                        </div>
                        <div class="font-semibold text-base sm:text-lg text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors flex items-center justify-end gap-2">
                            <span class="line-clamp-1">{{ $next->nama }}</span>
                        </div>
                    </a>
                @else
                    <div class="flex-1"></div>
                @endif
            </div>
        </section>
    </main>
</div>
@endsection
