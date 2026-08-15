@extends('layouts.app')

@section('content')
<x-page-background />

@php
    $fullDesk = $project->full_desk ?? $project->desk;
    $fullDeskIdn = $project->full_desk_idn ?? $project->desk_idn ?? null;
@endphp

<section class="relative z-20 pt-20 pb-16 sm:pt-24">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <nav class="flex flex-wrap items-center gap-1.5 text-xs font-medium text-slate-500 dark:text-slate-400 mb-8 animate__animated animate__fadeInUp" aria-label="Breadcrumb">
            <a href="{{ route('landing') }}#proyek" class="inline-flex items-center gap-1 hover:text-accent transition-colors">
                <i class="ri-home-4-line"></i> <span x-text="t('home')">Home</span>
            </a>
            <i class="ri-arrow-right-s-line text-slate-300 dark:text-slate-600"></i>
            <a href="{{ route('landing') }}#proyek" class="hover:text-accent transition-colors" x-text="t('projectsBreadcrumb')">Projects</a>
            <i class="ri-arrow-right-s-line text-slate-300 dark:text-slate-600"></i>
            <span class="text-accent font-semibold truncate max-w-55">{{ $project->nama }}</span>
        </nav>

        <div class="bg-white dark:bg-[#1a1a2e] border border-slate-200 dark:border-white/5 rounded-3xl overflow-hidden shadow-xl shadow-slate-200/50 dark:shadow-black/20" data-aos="fade-up" data-aos-duration="700">
            <div class="grid lg:grid-cols-[1fr_340px] items-stretch divide-y lg:divide-y-0 lg:divide-x divide-slate-200 dark:divide-white/5">

                <div class="p-6 sm:p-8 lg:p-10 min-w-0 flex flex-col justify-between">
                    <div class="space-y-8">
                        <header>
                            <div class="flex flex-wrap items-center gap-2 text-xs font-semibold text-accent uppercase tracking-wider mb-3">
                                <i class="ri-folder-open-line"></i>
                                <span x-text="t('project')">Project</span> #{{ str_pad($project->id, 2, '0', STR_PAD_LEFT) }}
                                @if ($project->category)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-medium normal-case tracking-normal text-accent dark:text-[#60a5fa] bg-accent/10 border border-accent/15">
                                        <i class="ri-price-tag-3-line"></i>{{ $project->category->nama }}
                                    </span>
                                @endif
                            </div>
                            <h1 class="font-poppins text-3xl sm:text-4xl lg:text-[2.75rem] font-bold leading-tight text-slate-800 dark:text-white mb-4">
                                {{ $project->nama }}
                            </h1>
                            <p class="text-sm sm:text-base text-slate-500 dark:text-slate-400 leading-relaxed max-w-2xl" x-text='L(@json($project->desk), @json($project->desk_idn))'>{{ $project->desk }}</p>
                        </header>

                        <div class="rounded-2xl overflow-hidden border border-slate-200 dark:border-white/5 bg-slate-100 dark:bg-slate-900 shadow-sm">
                            <img src="{{ img_url($project->gambar) }}" alt="{{ $project->nama }}" class="w-full object-cover" loading="lazy">
                        </div>

                        <div>
                            <h2 class="font-poppins text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                                <i class="ri-information-line text-accent"></i> <span x-text="t('aboutThisProject')">About This Project</span>
                            </h2>
                            <p class="text-sm sm:text-[0.95rem] text-slate-600 dark:text-slate-300 leading-relaxed whitespace-pre-line" x-text='L(@json($fullDesk), @json($fullDeskIdn))'>
                                {{ $fullDesk }}
                            </p>
                        </div>

                        <template x-if='L(@json($project->fitur ?? []), @json($project->fitur_idn ?? [])).length > 0'>
                            <div class="pt-6 border-t border-slate-200/60 dark:border-white/5">
                                <h2 class="font-poppins text-lg font-bold text-slate-800 dark:text-white mb-5 flex items-center gap-2">
                                    <i class="ri-star-line text-accent"></i> <span x-text="t('keyFeatures')">Key Features</span>
                                </h2>
                                <div class="grid sm:grid-cols-2 gap-x-6 gap-y-3">
                                    <template x-for='(f, fi) in L(@json($project->fitur ?? []), @json($project->fitur_idn ?? []))' :key="fi">
                                        <div class="flex items-start gap-2.5 text-sm text-slate-600 dark:text-slate-300">
                                            <span class="w-1.5 h-1.5 rounded-full bg-accent mt-1.5 shrink-0"></span>
                                            <span x-text="f"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="pt-8 mt-8 border-t border-slate-200/60 dark:border-white/5 flex flex-wrap items-center gap-3">
                        <a href="{{ route('landing') }}#proyek"
                           class="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-full border-[1.5px] border-accent/30 text-accent dark:text-[#60a5fa] text-sm font-semibold transition-all duration-200 hover:bg-accent/10 hover:border-accent hover:-translate-y-0.5 dark:hover:bg-accent/15 dark:hover:border-[#60a5fa]">
                            <i class="ri-arrow-left-line"></i> <span x-text="t('backToProjects')">Back to Projects</span>
                        </a>
                    </div>
                </div>

                <aside class="bg-slate-50/50 dark:bg-[#161626]/40 p-6 sm:p-8 flex flex-col">
                    <div class="lg:sticky lg:top-28 space-y-8">
                        <div>
                            <h2 class="font-poppins text-base font-bold text-slate-800 dark:text-white mb-5 flex items-center gap-2">
                                <i class="ri-tools-line text-accent text-lg"></i> <span x-text="t('toolsSkillsUsed')">Tools & Skills Used</span>
                            </h2>
                             @if ($projectTools->isNotEmpty())
                                 <ul class="space-y-3">
                                     @foreach ($projectTools as $tool)
                                         @php
                                             $iconUrl = tool_icon_url($tool->nama, $tool->gambar ?? null);
                                         @endphp
                                         <li class="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-300">
                                             <span class="w-8 h-8 shrink-0 rounded-lg bg-slate-100 dark:bg-white/10 border border-slate-200/50 dark:border-white/5 flex items-center justify-center overflow-hidden p-1.5 shadow-2xs">
                                                 @if ($iconUrl)
                                                     <img src="{{ $iconUrl }}" alt="{{ $tool->nama }}" class="w-5 h-5 object-contain">
                                                 @else
                                                     <i class="ri-vip-diamond-line text-sm text-accent dark:text-[#60a5fa]"></i>
                                                 @endif
                                             </span>
                                             <span class="font-medium">{{ $tool->nama }}</span>
                                         </li>
                                     @endforeach
                                 </ul>
                            @else
                                <p class="text-sm text-slate-400 dark:text-slate-500" x-text="t('noToolsYet')">No tools are listed for this project yet.</p>
                            @endif

                            @if ($project->link || $project->link_live)
                                <div class="mt-7 space-y-2.5">
                                    @if ($project->link)
                                        <a href="{{ $project->link }}" target="_blank" rel="noopener noreferrer"
                                           class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-accent/10 dark:bg-accent/15 text-accent dark:text-[#60a5fa] text-sm font-semibold border border-accent/20 dark:border-accent/25 transition-all duration-200 hover:bg-accent hover:text-white hover:-translate-y-0.5 hover:shadow-[0_8px_20px_rgba(59,130,246,0.25)]">
                                            <i class="ri-github-fill"></i> <span x-text="t('sourceCode')">Source Code</span>
                                        </a>
                                    @endif
                                    @if ($project->link_live)
                                        <a href="{{ $project->link_live }}" target="_blank" rel="noopener noreferrer"
                                           class="w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-accent text-white text-sm font-semibold transition-all duration-200 hover:bg-blue-600 hover:-translate-y-0.5 hover:shadow-[0_8px_20px_rgba(59,130,246,0.25)]">
                                            <i class="ri-external-link-line"></i> <span x-text="t('visitWebsite')">Visit Website</span>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="pt-6 border-t border-slate-200/60 dark:border-white/5">
                            <h2 class="font-poppins text-base font-bold text-slate-800 dark:text-white mb-5 flex items-center gap-2">
                                <i class="ri-information-line text-accent text-lg"></i> <span x-text="t('projectInfo')">Project Info</span>
                            </h2>
                            <ul class="space-y-3.5 text-sm">
                                <li class="flex items-center justify-between gap-3">
                                    <span class="text-slate-400 dark:text-slate-500 flex items-center gap-2">
                                        <i class="ri-hashtag"></i> <span x-text="t('projectNumber')">Project Number</span>
                                    </span>
                                    <span class="font-semibold text-slate-700 dark:text-slate-200">#{{ str_pad($project->id, 2, '0', STR_PAD_LEFT) }}</span>
                                </li>
                                <li class="flex items-center justify-between gap-3">
                                    <span class="text-slate-400 dark:text-slate-500 flex items-center gap-2">
                                        <i class="ri-vip-diamond-line"></i> <span x-text="t('toolsUsed')">Tools Used</span>
                                    </span>
                                    <span class="font-semibold text-slate-700 dark:text-slate-200">{{ count($project->tools ?? []) }}</span>
                                </li>
                                <li class="flex items-center justify-between gap-3">
                                    <span class="text-slate-400 dark:text-slate-500 flex items-center gap-2">
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

        <div class="flex items-stretch justify-between gap-4 border-t border-slate-200 dark:border-white/10 pt-8 mt-12">
            @if ($prev)
                <a href="{{ route('project.show', $prev) }}"
                   class="group flex-1 min-w-0 bg-white dark:bg-[#1a1a2e] border border-slate-200 dark:border-white/5 rounded-2xl p-5 transition-all duration-300 hover:shadow-[0_12px_40px_rgba(0,0,0,0.08)] dark:hover:shadow-[0_12px_40px_rgba(59,130,246,0.08)]">
                    <span class="block text-xs font-medium text-slate-400 dark:text-slate-500 mb-1.5"><i class="ri-arrow-left-s-line mr-0.5"></i><span x-text="t('previousProject')">Previous Project</span></span>
                    <span class="block font-semibold text-sm text-slate-700 dark:text-slate-200 truncate group-hover:text-accent transition-colors">{{ $prev->nama }}</span>
                </a>
            @else
                <span class="flex-1"></span>
            @endif

            @if ($next)
                <a href="{{ route('project.show', $next) }}"
                   class="group flex-1 min-w-0 text-right bg-white dark:bg-[#1a1a2e] border border-slate-200 dark:border-white/5 rounded-2xl p-5 transition-all duration-300 hover:shadow-[0_12px_40px_rgba(0,0,0,0.08)] dark:hover:shadow-[0_12px_40px_rgba(59,130,246,0.08)]">
                    <span class="block text-xs font-medium text-slate-400 dark:text-slate-500 mb-1.5"><span x-text="t('nextProject')">Next Project</span><i class="ri-arrow-right-s-line ml-0.5"></i></span>
                    <span class="block font-semibold text-sm text-slate-700 dark:text-slate-200 truncate group-hover:text-accent transition-colors">{{ $next->nama }}</span>
                </a>
            @else
                <span class="flex-1"></span>
            @endif
        </div>
    </div>
</section>
@endsection
