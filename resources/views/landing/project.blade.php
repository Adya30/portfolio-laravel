@extends('layouts.app')

@section('content')
<x-page-background />

@php
    $fullDesk = $project->full_desk ?? $project->desk;
    $fullDeskIdn = $project->full_desk_idn ?? $project->desk_idn ?? null;
@endphp

<section class="relative z-20 pt-24 pb-16 sm:pt-28 sm:pb-20 md:pt-32 overflow-x-clip">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Main Card -->
        <div class="surface rounded-2xl overflow-hidden" data-aos="fade-up" data-aos-duration="700">
            <div class="grid lg:grid-cols-[1fr_340px] items-stretch divide-y lg:divide-y-0 lg:divide-x divide-line dark:divide-white/10">

                <div class="p-6 sm:p-8 lg:p-10 min-w-0 flex flex-col justify-between">
                    <div class="space-y-8">
                        <header>
                            <h1 class="font-poppins text-2xl sm:text-3xl lg:text-[2.75rem] font-bold leading-tight tracking-tight text-slate-900 dark:text-white mb-4">
                                {{ $project->nama }}
                            </h1>
                            @if ($project->category)
                                <span class="chip text-accent dark:text-accent-light">
                                    <i class="ri-price-tag-3-line" aria-hidden="true"></i>{{ $project->category->nama }}
                                </span>
                            @endif
                        </header>

                        <div class="surface-muted rounded-2xl overflow-hidden p-2">
                            <img src="{{ img_url($project->gambar) }}" alt="{{ $project->nama }}" class="w-full h-auto object-cover rounded-xl" loading="lazy">
                        </div>

                        <div>
                            <h2 class="font-poppins text-lg font-bold tracking-tight text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                                <i class="ri-information-line text-accent dark:text-accent-light" aria-hidden="true"></i> <span x-text="t('aboutThisProject')">About This Project</span>
                            </h2>
                            <p class="prose-measure text-sm sm:text-[0.95rem] text-slate-700 dark:text-slate-300 leading-relaxed whitespace-pre-line" x-text='L(@json($fullDesk), @json($fullDeskIdn))'>
                                {{ $fullDesk }}
                            </p>
                        </div>

                        <template x-if='L(@json($project->fitur ?? []), @json($project->fitur_idn ?? [])).length > 0'>
                            <div class="pt-6 border-t border-line dark:border-white/10">
                                <h2 class="font-poppins text-lg font-bold tracking-tight text-slate-900 dark:text-white mb-5 flex items-center gap-2">
                                    <i class="ri-star-line text-accent dark:text-accent-light" aria-hidden="true"></i> <span x-text="t('keyFeatures')">Key Features</span>
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

                    <div class="pt-8 mt-8 border-t border-line dark:border-white/10 flex flex-wrap items-center gap-3">
                        <x-btn :href="route('landing') . '#proyek'" variant="secondary" size="md" icon="ri-arrow-left-line" class="rounded-full">
                            <span x-text="t('backToProjects')">Back to Projects</span>
                        </x-btn>
                    </div>
                </div>

                <!-- Sidebar (Aside) -->
                <aside class="bg-surface-muted dark:bg-white/[0.04] p-6 sm:p-8 flex flex-col">
                    <div class="lg:sticky lg:top-28 space-y-8">
                        <div>
                            <h2 class="font-poppins text-base font-bold tracking-tight text-slate-900 dark:text-white mb-5 flex items-center gap-2">
                                <i class="ri-tools-line text-accent dark:text-accent-light text-lg" aria-hidden="true"></i> <span x-text="t('toolsSkillsUsed')">Tools & Skills Used</span>
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
                                        <x-btn :href="$project->link" target="_blank" variant="secondary" icon="ri-github-fill" class="w-full">
                                            <span x-text="t('sourceCode')">Source Code</span>
                                        </x-btn>
                                    @endif
                                    @if ($project->link_live)
                                        <x-btn :href="$project->link_live" target="_blank" icon="ri-external-link-line" class="w-full">
                                            <span x-text="t('visitWebsite')">Visit Website</span>
                                        </x-btn>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="pt-6 border-t border-line dark:border-white/10">
                            <h2 class="font-poppins text-base font-bold tracking-tight text-slate-900 dark:text-white mb-5 flex items-center gap-2">
                                <i class="ri-information-line text-accent dark:text-accent-light text-lg" aria-hidden="true"></i> <span x-text="t('projectInfo')">Project Info</span>
                            </h2>
                            <ul class="space-y-3.5 text-sm">
                                <li class="flex items-center justify-between gap-3">
                                    <span class="text-slate-500 dark:text-slate-400 flex items-center gap-2">
                                        <i class="ri-vip-diamond-line" aria-hidden="true"></i> <span x-text="t('toolsUsed')">Tools Used</span>
                                    </span>
                                    <span class="font-semibold text-slate-700 dark:text-slate-200">{{ count($project->tools ?? []) }}</span>
                                </li>
                                <li class="flex items-center justify-between gap-3">
                                    <span class="text-slate-500 dark:text-slate-400 flex items-center gap-2">
                                        <i class="ri-star-line" aria-hidden="true"></i> <span x-text="t('keyFeatures')">Key Features</span>
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
        <div class="flex items-stretch justify-between gap-3 sm:gap-4 border-t border-line dark:border-white/10 pt-6 mt-10">
            @if ($prev)
                <a href="{{ route('project.show', $prev) }}"
                   class="surface surface-interactive focus-ring group flex-1 min-w-0 rounded-2xl p-5">
                    <span class="block text-[11px] sm:text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5"><i class="ri-arrow-left-s-line mr-0.5" aria-hidden="true"></i><span x-text="t('previousProject')">Previous Project</span></span>
                    <span class="block font-bold text-sm sm:text-base text-slate-900 dark:text-white truncate group-hover:text-accent dark:group-hover:text-accent-light transition-colors">{{ $prev->nama }}</span>
                </a>
            @else
                <span class="flex-1"></span>
            @endif

            @if ($next)
                <a href="{{ route('project.show', $next) }}"
                   class="surface surface-interactive focus-ring group flex-1 min-w-0 text-right rounded-2xl p-5">
                    <span class="block text-[11px] sm:text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5"><span x-text="t('nextProject')">Next Project</span><i class="ri-arrow-right-s-line ml-0.5" aria-hidden="true"></i></span>
                    <span class="block font-bold text-sm sm:text-base text-slate-900 dark:text-white truncate group-hover:text-accent dark:group-hover:text-accent-light transition-colors">{{ $next->nama }}</span>
                </a>
            @else
                <span class="flex-1"></span>
            @endif
        </div>
    </div>
</section>
@endsection
