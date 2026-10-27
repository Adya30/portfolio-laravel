@extends('layouts.app')

@section('content')
    <x-page-background />

    @php
        $fullDesk = $project->full_desk ?? $project->desk;
        $fullDeskIdn = $project->full_desk_idn ?? ($project->desk_idn ?? null);
    @endphp

    <section class="relative z-20 pt-[calc(5.5rem+env(safe-area-inset-top,0px))] pb-5 sm:pt-20 sm:pb-3 md:pt-24">
        <div class="w-[calc(100%-2.5rem)] max-w-6xl mx-auto space-y-3 sm:space-y-4">
            <div class="rounded-3xl border border-slate-200/90 dark:border-white/10 bg-white dark:bg-[#0f172a]/95 overflow-hidden shadow-none"
                data-aos="fade-up" data-aos-duration="700">
                <div
                    class="grid lg:grid-cols-[1fr_320px] items-stretch divide-y lg:divide-y-0 lg:divide-x divide-slate-200/90 dark:divide-white/10">

                    <div class="p-4 sm:p-6 lg:p-7 min-w-0 flex flex-col justify-between">
                        <div class="space-y-4 sm:space-y-5">
                            <header>
                                @if ($project->category)
                                    <div class="mb-1.5">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-orange-500/10 text-orange-600 dark:text-orange-400 border border-orange-500/20">
                                            {{ $project->category->nama }}
                                        </span>
                                    </div>
                                @endif
                                <h1
                                    class="font-poppins text-xl sm:text-2xl lg:text-[2rem] font-bold leading-tight tracking-tight text-slate-900 dark:text-white">
                                    {{ $project->nama }}
                                </h1>
                            </header>

                            <div
                                class="rounded-2xl border border-slate-200/80 dark:border-white/10 bg-slate-100/70 dark:bg-[#1e293b] p-1.5 sm:p-2 overflow-hidden">
                                <img src="{{ img_url($project->gambar) }}"
                                    alt="Preview Proyek {{ $project->nama }} - Portofolio Adya Handika Putra AP"
                                    title="{{ $project->nama }}" class="w-full h-auto object-cover rounded-xl"
                                    loading="lazy" decoding="async">
                            </div>

                            @php
                                $blocksEn = is_array($project->konten) ? $project->konten : [];
                                $blocksIdn = is_array($project->konten_idn) ? $project->konten_idn : [];
                                $hasBlocksEn = count($blocksEn) > 0;
                                $hasBlocksIdn = count($blocksIdn) > 0;
                                $hasBlocks = $hasBlocksEn || $hasBlocksIdn;
                            @endphp

                            @if ($hasBlocks)
                                <div class="space-y-4 pt-1">
                                    @if ($hasBlocksIdn)
                                        <div x-show="$store.lang.current === 'id'" x-cloak>
                                            @include('landing._project-blocks', ['blocks' => $blocksIdn])
                                        </div>
                                    @endif

                                    <div x-show="{{ $hasBlocksIdn ? '$store.lang.current !== \'id\'' : 'true' }}">
                                        @include('landing._project-blocks', [
                                            'blocks' => $hasBlocksEn ? $blocksEn : $blocksIdn,
                                        ])
                                    </div>
                                </div>
                            @else
                                <div>
                                    <h2 class="font-poppins text-sm sm:text-base font-bold tracking-tight text-slate-900 dark:text-white mb-1.5"
                                        x-text="t('aboutThisProject')">
                                        About This Project
                                    </h2>
                                    <p class="w-full text-sm sm:text-[15px] text-slate-700 dark:text-slate-300 leading-relaxed whitespace-pre-line"
                                        x-text='L(@json($fullDesk), @json($fullDeskIdn))'>
                                        {{ $fullDesk }}
                                    </p>
                                </div>
                            @endif
                        </div>

                        @if ($prev || $next)
                            <div
                                class="hidden lg:flex pt-4 mt-4 sm:pt-5 sm:mt-5 border-t border-slate-200/90 dark:border-white/10 items-center justify-between gap-3">
                                @if ($prev)
                                    <a href="{{ route('project.show', $prev) }}"
                                        class="group inline-flex items-center gap-2 px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-full border border-slate-300 dark:border-white/20 bg-white dark:bg-white/5 hover:border-orange-500 hover:text-orange-500 text-slate-800 dark:text-slate-200 font-semibold text-xs sm:text-sm active:scale-95 transition-all">
                                        <i class="ri-arrow-left-line text-base shrink-0 group-hover:-translate-x-0.5 transition-transform"
                                            aria-hidden="true"></i>
                                        <span x-text="t('previousProject')">Prev Project</span>
                                    </a>
                                @else
                                    <span></span>
                                @endif

                                @if ($next)
                                    <a href="{{ route('project.show', $next) }}"
                                        class="group inline-flex items-center justify-end gap-2 px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-full border border-slate-300 dark:border-white/20 bg-white dark:bg-white/5 hover:border-orange-500 hover:text-orange-500 text-slate-800 dark:text-slate-200 font-semibold text-xs sm:text-sm active:scale-95 transition-all ml-auto">
                                        <span x-text="t('nextProject')">Next Project</span>
                                        <i class="ri-arrow-right-line text-base shrink-0 group-hover:translate-x-0.5 transition-transform"
                                            aria-hidden="true"></i>
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>

                    <aside class="bg-slate-50/70 dark:bg-white/[0.02] p-4 sm:p-6 lg:p-7 flex flex-col justify-between">
                        <div class="lg:sticky lg:top-20 space-y-4 sm:space-y-5">
                            <div>
                                <h2 class="font-poppins text-sm sm:text-base font-bold tracking-tight text-slate-900 dark:text-white mb-2.5"
                                    x-text="t('toolsSkillsUsed')">
                                    Tools & Skills Used
                                </h2>
                                @if ($projectTools->isNotEmpty())
                                    <div class="flex flex-wrap gap-1.5 sm:gap-2">
                                        @foreach ($projectTools as $tool)
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-semibold bg-white dark:bg-white/5 border border-slate-200/90 dark:border-white/10 text-slate-700 dark:text-slate-300">
                                                {{ $tool->nama }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400"
                                        x-text="t('noToolsYet')">No tools are listed for this project yet.</p>
                                @endif

                                @if ($project->link || $project->link_live)
                                    <div class="mt-3.5 space-y-2">
                                        @if ($project->link)
                                            <a href="{{ $project->link }}" target="_blank" rel="noopener noreferrer"
                                                class="inline-flex items-center justify-center gap-2 w-full px-3.5 py-1.5 rounded-full border border-slate-300 dark:border-white/20 bg-white dark:bg-white/5 hover:border-orange-500 hover:text-orange-500 text-slate-800 dark:text-slate-200 font-bold text-xs sm:text-sm active:scale-95 transition-all">
                                                <i class="ri-github-fill text-base" aria-hidden="true"></i>
                                                <span x-text="t('sourceCode')">Source Code</span>
                                            </a>
                                        @endif
                                        @if ($project->link_live)
                                            <a href="{{ $project->link_live }}" target="_blank" rel="noopener noreferrer"
                                                class="inline-flex items-center justify-center gap-2 w-full px-3.5 py-1.5 rounded-full bg-orange-500 hover:bg-orange-600 text-white font-bold text-xs sm:text-sm active:scale-95 transition-all">
                                                <i class="ri-external-link-line text-base" aria-hidden="true"></i>
                                                <span x-text="t('visitWebsite')">Visit Website</span>
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if ($prev || $next)
                            <div
                                class="lg:hidden pt-4 mt-5 border-t border-slate-200/90 dark:border-white/10 flex items-center justify-between gap-3">
                                @if ($prev)
                                    <a href="{{ route('project.show', $prev) }}"
                                        class="group inline-flex items-center gap-2 px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-full border border-slate-300 dark:border-white/20 bg-white dark:bg-white/5 hover:border-orange-500 hover:text-orange-500 text-slate-800 dark:text-slate-200 font-semibold text-xs sm:text-sm active:scale-95 transition-all">
                                        <i class="ri-arrow-left-line text-base shrink-0 group-hover:-translate-x-0.5 transition-transform"
                                            aria-hidden="true"></i>
                                        <span x-text="t('previousProject')">Prev Project</span>
                                    </a>
                                @else
                                    <span></span>
                                @endif

                                @if ($next)
                                    <a href="{{ route('project.show', $next) }}"
                                        class="group inline-flex items-center justify-end gap-2 px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-full border border-slate-300 dark:border-white/20 bg-white dark:bg-white/5 hover:border-orange-500 hover:text-orange-500 text-slate-800 dark:text-slate-200 font-semibold text-xs sm:text-sm active:scale-95 transition-all ml-auto">
                                        <span x-text="t('nextProject')">Next Project</span>
                                        <i class="ri-arrow-right-line text-base shrink-0 group-hover:translate-x-0.5 transition-transform"
                                            aria-hidden="true"></i>
                                    </a>
                                @endif
                            </div>
                        @endif
                    </aside>
                </div>
            </div>
        </div>
    </section>
@endsection
