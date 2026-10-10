@extends('layouts.app')

@section('content')
<x-page-background />

@php
    $fullDesk = $project->full_desk ?? $project->desk;
    $fullDeskIdn = $project->full_desk_idn ?? $project->desk_idn ?? null;
@endphp

<section class="relative z-20 pt-16 pb-8 sm:pt-20 sm:pb-10 md:pt-24">
    <div class="w-[calc(100%-2.5rem)] max-w-6xl mx-auto space-y-3 sm:space-y-4">
        <div class="rounded-3xl border border-slate-200/90 dark:border-white/10 bg-white dark:bg-[#12121a]/95 overflow-hidden shadow-none" data-aos="fade-up" data-aos-duration="700">
            <div class="grid lg:grid-cols-[1fr_320px] items-stretch divide-y lg:divide-y-0 lg:divide-x divide-slate-200/90 dark:divide-white/10">

                <div class="p-4 sm:p-6 lg:p-7 min-w-0 flex flex-col justify-between">
                    <div class="space-y-4 sm:space-y-5">
                        <header>
                            @if ($project->category)
                                <div class="mb-1.5">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-orange-500/10 text-orange-600 dark:text-orange-400 border border-orange-500/20">
                                        {{ $project->category->nama }}
                                    </span>
                                </div>
                            @endif
                            <h1 class="font-poppins text-xl sm:text-2xl lg:text-[2rem] font-bold leading-tight tracking-tight text-slate-900 dark:text-white">
                                {{ $project->nama }}
                            </h1>
                        </header>

                        <div class="rounded-2xl border border-slate-200/80 dark:border-white/10 bg-slate-100/70 dark:bg-[#181824] p-1.5 sm:p-2 overflow-hidden">
                            <img src="{{ img_url($project->gambar) }}" alt="{{ $project->nama }}" class="w-full h-auto object-cover rounded-xl" loading="lazy">
                        </div>

                        <div>
                            <h2 class="font-poppins text-sm sm:text-base font-bold tracking-tight text-slate-900 dark:text-white mb-1.5" x-text="t('aboutThisProject')">
                                About This Project
                            </h2>
                            <p class="prose-measure text-sm sm:text-[15px] text-slate-700 dark:text-slate-300 leading-relaxed whitespace-pre-line" x-text='L(@json($fullDesk), @json($fullDeskIdn))'>
                                {{ $fullDesk }}
                            </p>
                        </div>

                        <template x-if='L(@json($project->fitur ?? []), @json($project->fitur_idn ?? [])).length > 0'>
                            <div class="pt-3.5 sm:pt-4 border-t border-slate-200/90 dark:border-white/10">
                                <h2 class="font-poppins text-sm sm:text-base font-bold tracking-tight text-slate-900 dark:text-white mb-2" x-text="t('keyFeatures')">
                                    Key Features
                                </h2>
                                <div class="grid sm:grid-cols-2 gap-x-4 gap-y-1.5">
                                    <template x-for='(f, fi) in L(@json($project->fitur ?? []), @json($project->fitur_idn ?? []))' :key="fi">
                                        <div class="flex items-start gap-2 text-sm text-slate-700 dark:text-slate-300">
                                            <span class="w-1.5 h-1.5 rounded-full bg-orange-500 mt-2 shrink-0"></span>
                                            <span x-text="f"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="pt-4 mt-4 sm:pt-5 sm:mt-5 border-t border-slate-200/90 dark:border-white/10 flex flex-wrap items-center gap-2.5">
                        <a href="{{ route('landing') }}#proyek"
                           class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full border border-slate-300 dark:border-white/20 bg-white dark:bg-white/5 hover:border-orange-500 hover:text-orange-500 text-slate-800 dark:text-slate-200 font-semibold text-xs sm:text-sm active:scale-95 transition-all">
                            <i class="ri-arrow-left-line text-base" aria-hidden="true"></i>
                            <span x-text="t('backToProjects')">Back to Projects</span>
                        </a>
                    </div>
                </div>

                <aside class="bg-slate-50/70 dark:bg-white/[0.02] p-4 sm:p-6 lg:p-7 flex flex-col justify-between">
                    <div class="lg:sticky lg:top-20 space-y-4 sm:space-y-5">
                        <div>
                            <h2 class="font-poppins text-sm sm:text-base font-bold tracking-tight text-slate-900 dark:text-white mb-2.5" x-text="t('toolsSkillsUsed')">
                                Tools & Skills Used
                            </h2>
                            @if ($projectTools->isNotEmpty())
                                <div class="flex flex-wrap gap-1.5 sm:gap-2">
                                    @foreach ($projectTools as $tool)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-semibold bg-white dark:bg-white/5 border border-slate-200/90 dark:border-white/10 text-slate-700 dark:text-slate-300">
                                            {{ $tool->nama }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400" x-text="t('noToolsYet')">No tools are listed for this project yet.</p>
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

                        <div class="pt-3.5 sm:pt-4 border-t border-slate-200/90 dark:border-white/10">
                            <h2 class="font-poppins text-sm sm:text-base font-bold tracking-tight text-slate-900 dark:text-white mb-2" x-text="t('projectInfo')">
                                Project Info
                            </h2>
                            <ul class="space-y-2 text-xs sm:text-sm">
                                <li class="flex items-center justify-between gap-3">
                                    <span class="text-slate-500 dark:text-slate-400" x-text="t('toolsUsed')">Tools Used</span>
                                    <span class="font-semibold text-slate-700 dark:text-slate-200">{{ count($project->tools ?? []) }}</span>
                                </li>
                                <li class="flex items-center justify-between gap-3">
                                    <span class="text-slate-500 dark:text-slate-400" x-text="t('keyFeatures')">Key Features</span>
                                    <span class="font-semibold text-slate-700 dark:text-slate-200">{{ count($project->fitur ?? []) }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </aside>
            </div>
        </div>

        <div class="flex items-stretch justify-between gap-2.5 sm:gap-3 pt-0.5">
            @if ($prev)
                <a href="{{ route('project.show', $prev) }}"
                   class="rounded-2xl border border-slate-200/90 dark:border-white/10 bg-white dark:bg-[#12121a]/95 hover:border-orange-500/60 dark:hover:border-orange-500/60 group flex-1 min-w-0 p-3 sm:p-3.5 transition-all">
                    <span class="block text-[10px] sm:text-[11px] font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-0.5"><i class="ri-arrow-left-s-line mr-0.5" aria-hidden="true"></i><span x-text="t('previousProject')">Previous Project</span></span>
                    <span class="block font-bold text-xs sm:text-sm text-slate-900 dark:text-white truncate group-hover:text-orange-500 transition-colors">{{ $prev->nama }}</span>
                </a>
            @else
                <span class="flex-1"></span>
            @endif

            @if ($next)
                <a href="{{ route('project.show', $next) }}"
                   class="rounded-2xl border border-slate-200/90 dark:border-white/10 bg-white dark:bg-[#12121a]/95 hover:border-orange-500/60 dark:hover:border-orange-500/60 group flex-1 min-w-0 text-right p-3 sm:p-3.5 transition-all">
                    <span class="block text-[10px] sm:text-[11px] font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-0.5"><span x-text="t('nextProject')">Next Project</span><i class="ri-arrow-right-s-line ml-0.5" aria-hidden="true"></i></span>
                    <span class="block font-bold text-xs sm:text-sm text-slate-900 dark:text-white truncate group-hover:text-orange-500 transition-colors">{{ $next->nama }}</span>
                </a>
            @else
                <span class="flex-1"></span>
            @endif
        </div>
    </div>
</section>
@endsection
