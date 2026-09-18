@extends('layouts.app')

@section('content')
<x-page-background />

@php
    $fullDesk = $project->full_desk ?? $project->desk;
    $fullDeskIdn = $project->full_desk_idn ?? $project->desk_idn ?? null;
@endphp

<section class="relative z-20 pt-24 pb-16 sm:pt-28 sm:pb-20 md:pt-32 overflow-x-clip">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Main Glass Card -->
        <div class="bg-white/40 dark:bg-[#1a1a2e]/40 backdrop-blur-xl border border-white/50 dark:border-white/10 rounded-3xl overflow-hidden" data-aos="fade-up" data-aos-duration="700">
            <div class="grid lg:grid-cols-[1fr_340px] items-stretch divide-y lg:divide-y-0 lg:divide-x divide-white/40 dark:divide-white/10">

                <div class="p-6 sm:p-8 lg:p-10 min-w-0 flex flex-col justify-between">
                    <div class="space-y-8">
                        <header>
                            <div class="flex flex-wrap items-center gap-2 text-xs font-semibold text-accent uppercase tracking-wider mb-3">
                                <i class="ri-folder-open-line"></i>
                                <span x-text="t('project')">Project</span>
                            </div>
                            <h1 class="font-poppins text-2xl sm:text-3xl lg:text-[2.75rem] font-bold leading-tight text-slate-800 dark:text-white mb-4">
                                {{ $project->nama }}
                            </h1>
                            @if ($project->category)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-medium normal-case tracking-normal text-accent dark:text-[#60a5fa] bg-white/50 dark:bg-white/5 border border-white/50 dark:border-white/10">
                                    <i class="ri-price-tag-3-line"></i>{{ $project->category->nama }}
                                </span>
                            @endif
                        </header>

                        <div class="border border-white/50 dark:border-white/10 bg-white/50 dark:bg-white/5 backdrop-blur-md rounded-2xl overflow-hidden p-2">
                            <img src="{{ img_url($project->gambar) }}" alt="{{ $project->nama }}" class="w-full h-auto object-cover rounded-xl" loading="lazy">
                        </div>

                        <div>
                            <h2 class="font-poppins text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                                <i class="ri-information-line text-accent"></i> <span x-text="t('aboutThisProject')">About This Project</span>
                            </h2>
                            <p class="text-sm sm:text-[0.95rem] text-slate-700 dark:text-slate-300 leading-relaxed whitespace-pre-line" x-text='L(@json($fullDesk), @json($fullDeskIdn))'>
                                {{ $fullDesk }}
                            </p>
                        </div>

                        <template x-if='L(@json($project->fitur ?? []), @json($project->fitur_idn ?? [])).length > 0'>
                            <div class="pt-6 border-t border-white/40 dark:border-white/10">
                                <h2 class="font-poppins text-lg font-bold text-slate-800 dark:text-white mb-5 flex items-center gap-2">
                                    <i class="ri-star-line text-accent"></i> <span x-text="t('keyFeatures')">Key Features</span>
                                </h2>
                                <div class="grid sm:grid-cols-2 gap-x-6 gap-y-3">
                                    <template x-for='(f, fi) in L(@json($project->fitur ?? []), @json($project->fitur_idn ?? []))' :key="fi">
                                        <div class="flex items-start gap-2.5 text-sm text-slate-700 dark:text-slate-300">
                                            <span class="w-1.5 h-1.5 rounded-full bg-accent mt-1.5 shrink-0"></span>
                                            <span x-text="f"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="pt-8 mt-8 border-t border-white/40 dark:border-white/10 flex flex-wrap items-center gap-3">
                        <a href="{{ route('landing') }}#proyek"
                           class="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-full bg-white/40 dark:bg-white/5 backdrop-blur-md border border-white/50 dark:border-white/10 text-accent dark:text-[#60a5fa] text-sm font-semibold transition-all duration-300 ease-out hover:bg-accent hover:border-accent hover:text-white dark:hover:bg-accent hover:-translate-y-1">
                            <i class="ri-arrow-left-line"></i> <span x-text="t('backToProjects')">Back to Projects</span>
                        </a>
                    </div>
                </div>

                <!-- Sidebar (Aside) -->
                <aside class="bg-white/30 dark:bg-white/5 p-6 sm:p-8 flex flex-col">
                    <div class="lg:sticky lg:top-28 space-y-8">
                        <div>
                            <h2 class="font-poppins text-base font-bold text-slate-800 dark:text-white mb-5 flex items-center gap-2">
                                <i class="ri-tools-line text-accent text-lg"></i> <span x-text="t('toolsSkillsUsed')">Tools & Skills Used</span>
                            </h2>
                            @if ($projectTools->isNotEmpty())
                                <ul class="space-y-2.5 list-disc pl-4 marker:text-accent/70 text-sm text-slate-700 dark:text-slate-300">
                                    @foreach ($projectTools as $tool)
                                        <li class="font-medium">{{ $tool->nama }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-sm text-slate-500 dark:text-slate-400" x-text="t('noToolsYet')">No tools are listed for this project yet.</p>
                            @endif

                            @if ($project->link || $project->link_live)
                                <div class="mt-7 space-y-2.5">
                                    @if ($project->link)
                                        <a href="{{ $project->link }}" target="_blank" rel="noopener noreferrer"
                                           class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-white/50 dark:bg-white/10 backdrop-blur-md text-accent dark:text-[#60a5fa] text-sm font-semibold border border-white/50 dark:border-white/10 transition-all duration-300 ease-out hover:bg-accent hover:text-white hover:border-accent hover:-translate-y-1">
                                            <i class="ri-github-fill"></i> <span x-text="t('sourceCode')">Source Code</span>
                                        </a>
                                    @endif
                                    @if ($project->link_live)
                                        <a href="{{ $project->link_live }}" target="_blank" rel="noopener noreferrer"
                                           class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-accent/90 backdrop-blur-md border border-white/20 text-white text-sm font-semibold transition-all duration-300 ease-out hover:bg-blue-600 hover:-translate-y-1">
                                            <i class="ri-external-link-line"></i> <span x-text="t('visitWebsite')">Visit Website</span>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="pt-6 border-t border-white/40 dark:border-white/10">
                            <h2 class="font-poppins text-base font-bold text-slate-800 dark:text-white mb-5 flex items-center gap-2">
                                <i class="ri-information-line text-accent text-lg"></i> <span x-text="t('projectInfo')">Project Info</span>
                            </h2>
                            <ul class="space-y-3.5 text-sm">
                                <li class="flex items-center justify-between gap-3">
                                    <span class="text-slate-500 dark:text-slate-400 flex items-center gap-2">
                                        <i class="ri-vip-diamond-line"></i> <span x-text="t('toolsUsed')">Tools Used</span>
                                    </span>
                                    <span class="font-semibold text-slate-700 dark:text-slate-200">{{ count($project->tools ?? []) }}</span>
                                </li>
                                <li class="flex items-center justify-between gap-3">
                                    <span class="text-slate-500 dark:text-slate-400 flex items-center gap-2">
                                        <i class="ri-star-line"></i> <span x-text="t('keyFeatures')">Key Features</span>
                                    </span>
                                    <span class="font-semibold text-slate-700 dark:text-slate-200">{{ count($project->fitur ?? []) }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </aside>
            </div>
        </div>

        <!-- Pagination / Navigation (Prev/Next) -->
        <div class="flex items-stretch justify-between gap-3 sm:gap-4 border-t border-white/30 dark:border-white/10 pt-6 mt-10">
            @if ($prev)
                <a href="{{ route('project.show', $prev) }}"
                   class="group flex-1 min-w-0 bg-white/40 dark:bg-[#1a1a2e]/40 backdrop-blur-xl border border-white/50 dark:border-white/10 rounded-2xl p-5 transition-all duration-300 ease-out hover:bg-white/60 dark:hover:bg-[#1a1a2e]/60 hover:border-accent/40 dark:hover:border-accent/40 hover:-translate-y-1">
                    <span class="block text-[11px] sm:text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5"><i class="ri-arrow-left-s-line mr-0.5"></i><span x-text="t('previousProject')">Previous Project</span></span>
                    <span class="block font-bold text-sm sm:text-base text-slate-800 dark:text-slate-200 truncate group-hover:text-accent transition-colors">{{ $prev->nama }}</span>
                </a>
            @else
                <span class="flex-1"></span>
            @endif

            @if ($next)
                <a href="{{ route('project.show', $next) }}"
                   class="group flex-1 min-w-0 text-right bg-white/40 dark:bg-[#1a1a2e]/40 backdrop-blur-xl border border-white/50 dark:border-white/10 rounded-2xl p-5 transition-all duration-300 ease-out hover:bg-white/60 dark:hover:bg-[#1a1a2e]/60 hover:border-accent/40 dark:hover:border-accent/40 hover:-translate-y-1">
                    <span class="block text-[11px] sm:text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5"><span x-text="t('nextProject')">Next Project</span><i class="ri-arrow-right-s-line ml-0.5"></i></span>
                    <span class="block font-bold text-sm sm:text-base text-slate-800 dark:text-slate-200 truncate group-hover:text-accent transition-colors">{{ $next->nama }}</span>
                </a>
            @else
                <span class="flex-1"></span>
            @endif
        </div>
    </div>
</section>
@endsection
