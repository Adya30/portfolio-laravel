@extends('layouts.app')

@section('content')
<section class="relative z-10 pt-32 pb-16 sm:pt-36">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Breadcrumb --}}
        <nav class="flex flex-wrap items-center gap-1.5 text-xs font-medium text-slate-500 dark:text-slate-400 mb-8 animate__animated animate__fadeInUp" aria-label="Breadcrumb">
            <a href="{{ route('landing') }}#experiences" class="inline-flex items-center gap-1 hover:text-accent transition-colors">
                <i class="ri-home-4-line"></i> Home
            </a>
            <i class="ri-arrow-right-s-line text-slate-300 dark:text-slate-600"></i>
            <a href="{{ route('landing') }}#experiences" class="hover:text-accent transition-colors">Experiences</a>
            <i class="ri-arrow-right-s-line text-slate-300 dark:text-slate-600"></i>
            <span class="text-accent font-semibold truncate max-w-[220px]">{{ $experience->role }}</span>
        </nav>

        {{-- Two panels: left = title + explanation, right = skills used --}}
        <div class="grid lg:grid-cols-[1fr_320px] gap-8 lg:gap-10 items-start">

            {{-- LEFT PANEL --}}
            <div class="min-w-0">

                {{-- Header --}}
                <header class="mb-8" data-aos="fade-up" data-aos-duration="700">
                    <div class="flex items-center gap-2 text-xs font-semibold text-accent uppercase tracking-wider mb-3">
                        <i class="ri-briefcase-4-line"></i>
                        Experience #{{ str_pad($experience->id, 2, '0', STR_PAD_LEFT) }}
                    </div>
                    <h1 class="font-poppins text-3xl sm:text-4xl lg:text-[2.75rem] font-bold leading-tight text-slate-800 dark:text-white mb-3">
                        {{ $experience->role }}
                    </h1>
                    <p class="text-base font-semibold text-accent mb-3">{{ $experience->company }}</p>

                    <div class="flex flex-wrap items-center gap-x-5 gap-y-2 text-sm text-slate-500 dark:text-slate-400">
                        <span class="flex items-center gap-1.5">
                            <i class="ri-calendar-line"></i>{{ $experience->duration }}
                        </span>
                        @if ($experience->location)
                            <span class="flex items-center gap-1.5">
                                <i class="ri-map-pin-line"></i>{{ $experience->location }}
                            </span>
                        @endif
                    </div>
                </header>

                {{-- Overview (penjelasan) --}}
                <div class="bg-white dark:bg-[#1a1a2e] border border-slate-200 dark:border-white/5 rounded-2xl p-7 sm:p-9 mb-6" data-aos="fade-up" data-aos-delay="100">
                    <h2 class="font-poppins text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                        <i class="ri-information-line text-accent"></i> Overview
                    </h2>
                    <p class="text-sm sm:text-[0.95rem] text-slate-600 dark:text-slate-300 leading-relaxed whitespace-pre-line">
                        {{ $experience->desk }}
                    </p>
                </div>

                {{-- Practicum responsibilities --}}
                @if ($experience->practicum_desc)
                    <div class="bg-white dark:bg-[#1a1a2e] border border-slate-200 dark:border-white/5 rounded-2xl p-7 sm:p-9 mb-6" data-aos="fade-up" data-aos-delay="150">
                        <h2 class="font-poppins text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                            <i class="ri-graduation-cap-line text-accent"></i> Practicum Responsibilities
                        </h2>
                        <p class="text-sm sm:text-[0.95rem] text-slate-600 dark:text-slate-300 leading-relaxed whitespace-pre-line">
                            {{ $experience->practicum_desc }}
                        </p>
                    </div>
                @endif

                {{-- Key responsibilities --}}
                @if (! empty($experience->responsibilities))
                    <div class="bg-white dark:bg-[#1a1a2e] border border-slate-200 dark:border-white/5 rounded-2xl p-7 sm:p-9 mb-6" data-aos="fade-up" data-aos-delay="200">
                        <h2 class="font-poppins text-lg font-bold text-slate-800 dark:text-white mb-5 flex items-center gap-2">
                            <i class="ri-task-line text-accent"></i> Key Responsibilities
                        </h2>
                        <ul class="space-y-3">
                            @foreach ($experience->responsibilities as $responsibility)
                                <li class="flex items-start gap-2.5 text-sm text-slate-600 dark:text-slate-300">
                                    <i class="ri-checkbox-circle-line text-accent mt-0.5 flex-shrink-0"></i>
                                    <span>{{ $responsibility }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- CTA --}}
                <div class="mb-4" data-aos="fade-up" data-aos-delay="250">
                    <a href="{{ route('landing') }}#experiences"
                       class="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-full border-[1.5px] border-accent/30 text-accent dark:text-[#60a5fa] text-sm font-semibold transition-all duration-200 hover:bg-accent/10 hover:border-accent hover:-translate-y-0.5 dark:hover:bg-accent/15 dark:hover:border-[#60a5fa]">
                        <i class="ri-arrow-left-line"></i> Back to Experiences
                    </a>
                </div>
            </div>

            {{-- RIGHT PANEL: skills used --}}
            <aside class="lg:sticky lg:top-28 space-y-6" data-aos="fade-up" data-aos-delay="150">

                {{-- Skills Used --}}
                <div class="bg-white dark:bg-[#1a1a2e] border border-slate-200 dark:border-white/5 rounded-2xl p-7">
                    <h2 class="font-poppins text-base font-bold text-slate-800 dark:text-white mb-5 flex items-center gap-2">
                        <i class="ri-tools-line text-accent text-lg"></i> Skills Used
                    </h2>
                    @if (! empty($experience->skills))
                        <ul class="space-y-3">
                            @foreach ($experience->skills as $skill)
                                <li class="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-300">
                                    <span class="w-8 h-8 flex-shrink-0 rounded-lg bg-accent/10 dark:bg-accent/15 text-accent dark:text-[#60a5fa] flex items-center justify-center">
                                        <i class="ri-vip-diamond-line text-sm"></i>
                                    </span>
                                    <span>{{ $skill }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm text-slate-400 dark:text-slate-500">No skills are listed for this experience yet.</p>
                    @endif
                </div>

                {{-- At a glance --}}
                <div class="bg-white dark:bg-[#1a1a2e] border border-slate-200 dark:border-white/5 rounded-2xl p-7">
                    <h2 class="font-poppins text-base font-bold text-slate-800 dark:text-white mb-5 flex items-center gap-2">
                        <i class="ri-information-line text-accent text-lg"></i> At a Glance
                    </h2>
                    <ul class="space-y-3.5 text-sm">
                        <li class="flex items-center justify-between gap-3">
                            <span class="text-slate-400 dark:text-slate-500 flex items-center gap-2">
                                <i class="ri-briefcase-4-line"></i> Company
                            </span>
                            <span class="font-semibold text-slate-700 dark:text-slate-200 text-right">{{ $experience->company }}</span>
                        </li>
                        <li class="flex items-center justify-between gap-3">
                            <span class="text-slate-400 dark:text-slate-500 flex items-center gap-2">
                                <i class="ri-calendar-line"></i> Duration
                            </span>
                            <span class="font-semibold text-slate-700 dark:text-slate-200 text-right">{{ $experience->duration }}</span>
                        </li>
                        @if ($experience->location)
                            <li class="flex items-center justify-between gap-3">
                                <span class="text-slate-400 dark:text-slate-500 flex items-center gap-2">
                                    <i class="ri-map-pin-line"></i> Location
                                </span>
                                <span class="font-semibold text-slate-700 dark:text-slate-200 text-right">{{ $experience->location }}</span>
                            </li>
                        @endif
                    </ul>
                </div>
            </aside>
        </div>

        {{-- Previous / Next navigation --}}
        <div class="flex items-stretch justify-between gap-4 border-t border-slate-200 dark:border-white/10 pt-8 mt-12">
            @if ($prev)
                <a href="{{ route('experience.show', $prev) }}"
                   class="group flex-1 min-w-0 bg-white dark:bg-[#1a1a2e] border border-slate-200 dark:border-white/5 rounded-2xl p-5 transition-all duration-300 hover:border-accent/30 hover:-translate-y-1 hover:shadow-[0_12px_40px_rgba(0,0,0,0.08)] dark:hover:shadow-[0_12px_40px_rgba(59,130,246,0.08)]">
                    <span class="block text-xs font-medium text-slate-400 dark:text-slate-500 mb-1.5"><i class="ri-arrow-left-s-line mr-0.5"></i>Previous</span>
                    <span class="block font-semibold text-sm text-slate-700 dark:text-slate-200 truncate group-hover:text-accent transition-colors">{{ $prev->role }}</span>
                </a>
            @else
                <span class="flex-1"></span>
            @endif

            <a href="{{ route('landing') }}#experiences" title="All Experiences"
               class="flex items-center justify-center px-5 rounded-2xl border border-slate-200 dark:border-white/10 text-xs font-semibold text-slate-500 dark:text-slate-400 hover:text-accent hover:border-accent/40 transition-all duration-300">
                <i class="ri-grid-fill mr-1.5"></i>All
            </a>

            @if ($next)
                <a href="{{ route('experience.show', $next) }}"
                   class="group flex-1 min-w-0 text-right bg-white dark:bg-[#1a1a2e] border border-slate-200 dark:border-white/5 rounded-2xl p-5 transition-all duration-300 hover:border-accent/30 hover:-translate-y-1 hover:shadow-[0_12px_40px_rgba(0,0,0,0.08)] dark:hover:shadow-[0_12px_40px_rgba(59,130,246,0.08)]">
                    <span class="block text-xs font-medium text-slate-400 dark:text-slate-500 mb-1.5">Next<i class="ri-arrow-right-s-line ml-0.5"></i></span>
                    <span class="block font-semibold text-sm text-slate-700 dark:text-slate-200 truncate group-hover:text-accent transition-colors">{{ $next->role }}</span>
                </a>
            @else
                <span class="flex-1"></span>
            @endif
        </div>
    </div>
</section>
@endsection
