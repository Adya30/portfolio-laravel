@extends('layouts.app')

@section('content')
<section class="relative z-10 pt-24 pb-16 sm:pt-36">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <nav class="flex flex-wrap items-center gap-1.5 text-xs font-medium text-slate-500 dark:text-slate-400 mb-8 animate__animated animate__fadeInUp" aria-label="Breadcrumb">
            <a href="{{ route('landing') }}#proyek" class="inline-flex items-center gap-1 hover:text-accent transition-colors">
                <i class="ri-home-4-line"></i> Home
            </a>
            <i class="ri-arrow-right-s-line text-slate-300 dark:text-slate-600"></i>
            <a href="{{ route('landing') }}#proyek" class="hover:text-accent transition-colors">Projects</a>
            <i class="ri-arrow-right-s-line text-slate-300 dark:text-slate-600"></i>
            <span class="text-accent font-semibold truncate max-w-[220px]">{{ $project->nama }}</span>
        </nav>

        <div class="grid lg:grid-cols-[1fr_360px] gap-8 lg:gap-10 items-start">

            <div class="min-w-0">

                <header class="mb-8" data-aos="fade-up" data-aos-duration="700">
                    <div class="flex flex-wrap items-center gap-2 text-xs font-semibold text-accent uppercase tracking-wider mb-3">
                        <i class="ri-folder-open-line"></i>
                        Project #{{ str_pad($project->id, 2, '0', STR_PAD_LEFT) }}
                        @if ($project->category)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-medium normal-case tracking-normal text-accent dark:text-[#60a5fa] bg-accent/10 border border-accent/15">
                                <i class="ri-price-tag-3-line"></i>{{ $project->category->nama }}
                            </span>
                        @endif
                    </div>
                    <h1 class="font-poppins text-3xl sm:text-4xl lg:text-[2.75rem] font-bold leading-tight text-slate-800 dark:text-white mb-4">
                        {{ $project->nama }}
                    </h1>
                    <p class="text-sm sm:text-base text-slate-500 dark:text-slate-400 leading-relaxed max-w-2xl">{{ $project->desk }}</p>
                </header>

                <div class="bg-white dark:bg-[#1a1a2e] border border-slate-200 dark:border-white/5 rounded-2xl overflow-hidden shadow-lg mb-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-slate-100 dark:bg-slate-900">
                        <img src="{{ img_url($project->gambar) }}" alt="{{ $project->nama }}" class="w-full object-cover" loading="lazy">
                    </div>
                    <div class="p-7 sm:p-9 border-t border-slate-200/50 dark:border-white/5">
                        <h2 class="font-poppins text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                            <i class="ri-information-line text-accent"></i> About This Project
                        </h2>
                        <p class="text-sm sm:text-[0.95rem] text-slate-600 dark:text-slate-300 leading-relaxed whitespace-pre-line">
                            {{ $project->full_desk ?? $project->desk }}
                        </p>
                    </div>
                </div>

                @if (! empty($project->fitur))
                    <div class="bg-white dark:bg-[#1a1a2e] border border-slate-200 dark:border-white/5 rounded-2xl p-7 sm:p-9 mb-6" data-aos="fade-up" data-aos-delay="200">
                        <h2 class="font-poppins text-lg font-bold text-slate-800 dark:text-white mb-5 flex items-center gap-2">
                            <i class="ri-star-line text-accent"></i> Key Features
                        </h2>
                        <div class="grid sm:grid-cols-2 gap-x-6 gap-y-3">
                            @foreach ($project->fitur as $fitur)
                                <div class="flex items-start gap-2.5 text-sm text-slate-600 dark:text-slate-300">
                                    <span class="w-1.5 h-1.5 rounded-full bg-accent mt-1.5 flex-shrink-0"></span>
                                    <span>{{ $fitur }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="flex flex-wrap items-center gap-3 mb-4" data-aos="fade-up" data-aos-delay="250">
                    <a href="{{ route('landing') }}#proyek"
                       class="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-full border-[1.5px] border-accent/30 text-accent dark:text-[#60a5fa] text-sm font-semibold transition-all duration-200 hover:bg-accent/10 hover:border-accent hover:-translate-y-0.5 dark:hover:bg-accent/15 dark:hover:border-[#60a5fa]">
                        <i class="ri-arrow-left-line"></i> Back to Projects
                    </a>
                </div>
            </div>

            <aside class="lg:sticky lg:top-28 space-y-6" data-aos="fade-up" data-aos-delay="150">

                <div class="bg-white dark:bg-[#1a1a2e] border border-slate-200 dark:border-white/5 rounded-2xl p-7">
                    <h2 class="font-poppins text-base font-bold text-slate-800 dark:text-white mb-5 flex items-center gap-2">
                        <i class="ri-tools-line text-accent text-lg"></i> Tools & Skills Used
                    </h2>
                    @if (! empty($project->tools))
                        <ul class="space-y-3">
                            @foreach ($project->tools as $tool)
                                <li class="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-300">
                                    <span class="w-8 h-8 flex-shrink-0 rounded-lg bg-accent/10 dark:bg-accent/15 text-accent dark:text-[#60a5fa] flex items-center justify-center">
                                        <i class="ri-vip-diamond-line text-sm"></i>
                                    </span>
                                    <span>{{ $tool }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm text-slate-400 dark:text-slate-500">No tools are listed for this project yet.</p>
                    @endif

                    @if ($project->link)
                        <a href="{{ $project->link }}" target="_blank" rel="noopener noreferrer"
                           class="mt-7 w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-accent/10 dark:bg-accent/15 text-accent dark:text-[#60a5fa] text-sm font-semibold border border-accent/20 dark:border-accent/25 transition-all duration-200 hover:bg-accent hover:text-white hover:-translate-y-0.5 hover:shadow-[0_8px_20px_rgba(59,130,246,0.25)]">
                            <i class="ri-external-link-line"></i> Visit Website
                        </a>
                    @endif
                </div>

                <div class="bg-white dark:bg-[#1a1a2e] border border-slate-200 dark:border-white/5 rounded-2xl p-7">
                    <h2 class="font-poppins text-base font-bold text-slate-800 dark:text-white mb-5 flex items-center gap-2">
                        <i class="ri-information-line text-accent text-lg"></i> Project Info
                    </h2>
                    <ul class="space-y-3.5 text-sm">
                        <li class="flex items-center justify-between gap-3">
                            <span class="text-slate-400 dark:text-slate-500 flex items-center gap-2">
                                <i class="ri-hashtag"></i> Project Number
                            </span>
                            <span class="font-semibold text-slate-700 dark:text-slate-200">#{{ str_pad($project->id, 2, '0', STR_PAD_LEFT) }}</span>
                        </li>
                        <li class="flex items-center justify-between gap-3">
                            <span class="text-slate-400 dark:text-slate-500 flex items-center gap-2">
                                <i class="ri-vip-diamond-line"></i> Tools Used
                            </span>
                            <span class="font-semibold text-slate-700 dark:text-slate-200">{{ count($project->tools ?? []) }}</span>
                        </li>
                        <li class="flex items-center justify-between gap-3">
                            <span class="text-slate-400 dark:text-slate-500 flex items-center gap-2">
                                <i class="ri-star-line"></i> Key Features
                            </span>
                            <span class="font-semibold text-slate-700 dark:text-slate-200">{{ count($project->fitur ?? []) }}</span>
                        </li>
                    </ul>
                </div>
            </aside>
        </div>

        <div class="flex items-stretch justify-between gap-4 border-t border-slate-200 dark:border-white/10 pt-8 mt-12">
            @if ($prev)
                <a href="{{ route('project.show', $prev) }}"
                   class="group flex-1 min-w-0 bg-white dark:bg-[#1a1a2e] border border-slate-200 dark:border-white/5 rounded-2xl p-5 transition-all duration-300 hover:border-accent/30 hover:-translate-y-1 hover:shadow-[0_12px_40px_rgba(0,0,0,0.08)] dark:hover:shadow-[0_12px_40px_rgba(59,130,246,0.08)]">
                    <span class="block text-xs font-medium text-slate-400 dark:text-slate-500 mb-1.5"><i class="ri-arrow-left-s-line mr-0.5"></i>Previous Project</span>
                    <span class="block font-semibold text-sm text-slate-700 dark:text-slate-200 truncate group-hover:text-accent transition-colors">{{ $prev->nama }}</span>
                </a>
            @else
                <span class="flex-1"></span>
            @endif

            <a href="{{ route('landing') }}#proyek" title="All Projects"
               class="flex items-center justify-center px-5 rounded-2xl border border-slate-200 dark:border-white/10 text-xs font-semibold text-slate-500 dark:text-slate-400 hover:text-accent hover:border-accent/40 transition-all duration-300">
                <i class="ri-grid-fill mr-1.5"></i>All
            </a>

            @if ($next)
                <a href="{{ route('project.show', $next) }}"
                   class="group flex-1 min-w-0 text-right bg-white dark:bg-[#1a1a2e] border border-slate-200 dark:border-white/5 rounded-2xl p-5 transition-all duration-300 hover:border-accent/30 hover:-translate-y-1 hover:shadow-[0_12px_40px_rgba(0,0,0,0.08)] dark:hover:shadow-[0_12px_40px_rgba(59,130,246,0.08)]">
                    <span class="block text-xs font-medium text-slate-400 dark:text-slate-500 mb-1.5">Next Project<i class="ri-arrow-right-s-line ml-0.5"></i></span>
                    <span class="block font-semibold text-sm text-slate-700 dark:text-slate-200 truncate group-hover:text-accent transition-colors">{{ $next->nama }}</span>
                </a>
            @else
                <span class="flex-1"></span>
            @endif
        </div>
    </div>
</section>
@endsection
