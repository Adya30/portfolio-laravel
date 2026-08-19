@extends('layouts.course')

@section('topbar')
    <div class="fixed top-4 left-4 right-4 z-100 flex items-center justify-between pointer-events-none" x-cloak>
        <div class="pointer-events-auto">
            <a href="{{ route('course.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl border backdrop-blur-xl shadow-lg bg-white/80 dark:bg-[#0b1329]/80 border-slate-200/60 dark:border-white/10 text-xs font-bold text-slate-700 dark:text-slate-200 hover:text-blue-600 dark:hover:text-blue-400 hover:border-blue-300/30 dark:hover:border-blue-500/30 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                <i class="ri-arrow-left-line text-base text-blue-600 dark:text-blue-400"></i>
                <span x-text="t('backToOverview')">Kembali ke Daftar Materi</span>
            </a>
        </div>
        <div class="pointer-events-auto ml-auto flex items-center gap-2 p-1 rounded-2xl border backdrop-blur-xl shadow-lg bg-white/80 dark:bg-[#0b1329]/80 border-slate-200/60 dark:border-white/10">
            @include('course._toggles')
        </div>
    </div>
@endsection

@section('content')

@php
    $nama = $course->nama;
    $desk = $course->desk ?? null;
    $deskIdn = $course->desk_idn ?? null;
    $blocks = $course->konten ?? [];

    $subbabs = [];
    $currentSubbabBlocks = 0;
    foreach ($blocks as $idx => $block) {
        if (($block['type'] ?? '') === 'subbab') {
            $subbabs[] = [
                'index' => $idx,
                'judul' => $block['judul'] ?? '',
                'block_count' => 0,
            ];
            $currentSubbabBlocks = 0;
        } elseif (!empty($subbabs)) {
            $subbabs[count($subbabs) - 1]['block_count']++;
        }
    }
@endphp

<section class="relative z-20 pt-24 sm:pt-28 pb-16 overflow-hidden">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">


        {{-- Course Header --}}
        <header class="mb-10" data-aos="fade-up" data-aos-duration="600">
            <h1 class="font-poppins text-3xl sm:text-4xl md:text-5xl font-bold text-slate-900 dark:text-white leading-tight">
                {{ $nama }}
            </h1>

            @if ($desk)
                <p class="mt-4 text-base sm:text-lg text-slate-600 dark:text-slate-300 leading-relaxed max-w-3xl">
                    {{ $desk }}
                </p>
            @endif

            <div class="mt-5 flex items-center gap-3 text-sm text-slate-500 dark:text-slate-400">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 border border-blue-200 dark:border-blue-800 text-xs font-medium">
                    <i class="ri-file-list-line"></i>
                    {{ count($subbabs) }} <span x-text="t('subchapters')">Subbab</span>
                </span>
            </div>
        </header>

        {{-- Subbab List --}}
        @if (count($subbabs))
            <div data-aos="fade-up" data-aos-duration="600">
                <h2 class="font-poppins text-lg font-bold text-slate-900 dark:text-white mb-5 flex items-center gap-2">
                    <i class="ri-list-unordered text-blue-600 dark:text-blue-400"></i>
                    <span x-text="t('tableOfContents')">Daftar Subbab</span>
                </h2>

                <div class="space-y-3">
                    @foreach ($subbabs as $i => $sub)
                        <a href="{{ route('course.subbab', [$course, $sub['index']]) }}"
                           class="group flex items-center gap-4 p-4 sm:p-5 bg-white dark:bg-[#0f172a] border border-slate-200 dark:border-white/10 rounded-2xl transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-slate-200/50 dark:hover:shadow-black/30 hover:border-blue-300 dark:hover:border-blue-700"
                           data-aos="fade-up" data-aos-duration="600" data-aos-delay="{{ $i * 50 }}">

                            <div class="shrink-0 w-11 h-11 rounded-xl bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 flex items-center justify-center text-blue-600 dark:text-blue-400 font-bold text-sm transition-colors group-hover:bg-blue-100 dark:group-hover:bg-blue-900/30">
                                {{ $i + 1 }}
                            </div>

                            <div class="flex-1 min-w-0">
                                <h3 class="font-poppins font-semibold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors leading-snug">
                                    {{ $sub['judul'] ?: 'Subbab '.($i + 1) }}
                                </h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                    {{ $sub['block_count'] }} blok konten
                                </p>
                            </div>

                            <div class="shrink-0 text-slate-400 dark:text-slate-500 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-all duration-300 group-hover:translate-x-1">
                                <i class="ri-arrow-right-line text-lg"></i>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @else
            <div class="text-center py-16 bg-white dark:bg-[#111827] border border-slate-200 dark:border-white/10 rounded-2xl" data-aos="fade-up">
                <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-500 flex items-center justify-center text-3xl">
                    <i class="ri-book-open-line"></i>
                </div>
                <h3 class="font-poppins text-lg font-semibold text-slate-900 dark:text-white mb-2">Belum ada subbab</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">Materi ini belum memiliki subbab pembelajaran.</p>
            </div>
        @endif
    </div>
</section>
@endsection
