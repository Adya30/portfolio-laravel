@extends('layouts.app')

@section('content')
<x-page-background />

<section class="relative z-20 pt-20 pb-16 sm:pt-24">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="bg-white dark:bg-[#1a1a2e] border border-slate-200 dark:border-white/5 rounded-3xl overflow-hidden shadow-xl shadow-slate-200/50 dark:shadow-black/20" data-aos="fade-up" data-aos-duration="700">
            <div class="grid lg:grid-cols-[1fr_320px] items-stretch divide-y lg:divide-y-0 lg:divide-x divide-slate-200 dark:divide-white/5">

                <div class="p-6 sm:p-8 lg:p-10 min-w-0 flex flex-col justify-between">
                    <div class="space-y-8">
                        <header>
                            <div class="flex items-start gap-5">
                                @if ($experience->gambar)
                                    <img src="{{ img_url($experience->gambar) }}" alt="{{ $experience->company }}"
                                         class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl object-cover border border-slate-200 dark:border-white/10 bg-slate-100 dark:bg-slate-800 shadow-sm shrink-0">
                                @else
                                    <span class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl shrink-0 flex items-center justify-center font-poppins font-bold text-2xl sm:text-3xl text-accent dark:text-[#60a5fa] bg-accent/10 dark:bg-accent/15 border border-slate-200 dark:border-white/5">
                                        {{ strtoupper(Str::substr(trim($experience->company), 0, 1)) }}
                                    </span>
                                @endif
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2 text-xs font-semibold text-accent uppercase tracking-wider mb-3">
                                        <span x-text="t('experience')">Experience</span>
                                    </div>
                                    <h1 class="font-poppins text-xl sm:text-xl lg:text-[2rem] font-bold leading-tight text-slate-800 dark:text-white mb-3" x-text='L(@json($experience->role), @json($experience->role_idn))'>
                                        {{ $experience->role }}
                                    </h1>
                                    <p class="text-base font-semibold text-accent mb-3">{{ $experience->company }}</p>
                                </div>
                            </div>
                        </header>

                        <div>
                            <h2 class="font-poppins text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                                <i class="ri-information-line text-accent"></i> <span x-text="t('overview')">Overview</span>
                            </h2>
                            <p class="text-sm sm:text-[0.95rem] text-slate-600 dark:text-slate-300 leading-relaxed whitespace-pre-line" x-text='L(@json($experience->desk), @json($experience->desk_idn))'>
                                {{ $experience->desk }}
                            </p>
                        </div>

                        @if ($experience->practicum_desc)
                            <div class="pt-6 border-t border-slate-200/60 dark:border-white/5">
                                <h2 class="font-poppins text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                                    <i class="ri-graduation-cap-line text-accent"></i> <span x-text="t('practicumResponsibilities')">Practicum Responsibilities</span>
                                </h2>
                                <p class="text-sm sm:text-[0.95rem] text-slate-600 dark:text-slate-300 leading-relaxed whitespace-pre-line" x-text='L(@json($experience->practicum_desc), @json($experience->practicum_desc_idn))'>
                                    {{ $experience->practicum_desc }}
                                </p>
                            </div>
                        @endif

                        @if (! empty($experience->responsibilities))
                            <div class="pt-6 border-t border-slate-200/60 dark:border-white/5">
                                <h2 class="font-poppins text-lg font-bold text-slate-800 dark:text-white mb-5 flex items-center gap-2">
                                    <i class="ri-task-line text-accent"></i> <span x-text="t('keyResponsibilities')">Key Responsibilities</span>
                                </h2>
                                <ul class="space-y-3">
                                    <template x-for='(r, ri) in L(@json($experience->responsibilities ?? []), @json($experience->responsibilities_idn ?? []))' :key="ri">
                                        <li class="flex items-start gap-2.5 text-sm text-slate-600 dark:text-slate-300">
                                            <i class="ri-checkbox-circle-line text-accent mt-0.5 shrink-0"></i>
                                            <span x-text="r"></span>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div class="pt-8 mt-8 border-t border-slate-200/60 dark:border-white/5 flex flex-wrap items-center gap-3">
                        <a href="{{ route('landing') }}#experiences"
                           class="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-full border-[1.5px] border-accent/30 text-accent dark:text-[#60a5fa] text-sm font-semibold transition-all duration-200 hover:bg-accent/10 hover:border-accent hover:-translate-y-0.5 dark:hover:bg-accent/15 dark:hover:border-[#60a5fa]">
                            <i class="ri-arrow-left-line"></i> <span x-text="t('backToExperiences')">Back to Experiences</span>
                        </a>
                    </div>
                </div>

                <aside class="bg-slate-50/50 dark:bg-[#161626]/40 p-6 sm:p-8 flex flex-col">
                    <div class="lg:sticky lg:top-28 space-y-8">
                        <div>
                            <h2 class="font-poppins text-base font-bold text-slate-800 dark:text-white mb-5 flex items-center gap-2">
                                <i class="ri-tools-line text-accent text-lg"></i> <span x-text="t('skillsUsed')">Skills Used</span>
                            </h2>
                            @if (! empty($experienceSkills) && $experienceSkills->isNotEmpty())
                                <ul class="space-y-2.5 list-disc pl-4 marker:text-accent/70 text-sm text-slate-600 dark:text-slate-300">
                                    @foreach ($experienceSkills as $skill)
                                        <li class="font-medium">{{ $skill->nama }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-sm text-slate-400 dark:text-slate-500" x-text="t('noSkillsYet')">No skills are listed for this experience yet.</p>
                            @endif
                        </div>

                        <div class="pt-6 border-t border-slate-200/60 dark:border-white/5">
                            <h2 class="font-poppins text-base font-bold text-slate-800 dark:text-white mb-5 flex items-center gap-2">
                                <i class="ri-information-line text-accent text-lg"></i> <span x-text="t('atAGlance')">At a Glance</span>
                            </h2>
                            <ul class="space-y-3.5 text-sm">
                                <li class="flex items-center justify-between gap-3">
                                    <span class="text-slate-400 dark:text-slate-500 flex items-center gap-2">
                                        <i class="ri-calendar-line"></i> <span x-text="t('duration')">Duration</span>
                                    </span>
                                    <span class="font-semibold text-slate-700 dark:text-slate-200 text-right">{{ $experience->duration }}</span>
                                </li>
                                @if ($experience->location)
                                    <li class="flex items-center justify-between gap-3">
                                        <span class="text-slate-400 dark:text-slate-500 flex items-center gap-2">
                                            <i class="ri-map-pin-line"></i> <span x-text="t('location')">Location</span>
                                        </span>
                                        <span class="font-semibold text-slate-700 dark:text-slate-200 text-right">{{ $experience->location }}</span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </aside>
            </div>
        </div>

        <div class="flex items-stretch justify-between gap-2 border-t border-slate-200 dark:border-white/10 pt-5 mt-12">
            @if ($prev)
                <a href="{{ route('experience.show', $prev) }}"
                   class="group flex-1 min-w-0 bg-white dark:bg-[#1a1a2e] border border-slate-200 dark:border-white/5 rounded-2xl p-5 transition-all duration-300 hover:shadow-[0_12px_40px_rgba(0,0,0,0.08)] dark:hover:shadow-[0_12px_40px_rgba(59,130,246,0.08)]">
                    <span class="block text-xs font-medium text-slate-400 dark:text-slate-500 mb-1.5"><i class="ri-arrow-left-s-line mr-0.5"></i><span x-text="t('previous')">Previous</span></span>
                    <span class="block font-semibold text-sm text-slate-700 dark:text-slate-200 truncate group-hover:text-accent transition-colors">{{ $prev->role }}</span>
                </a>
            @else
                <span class="flex-1"></span>
            @endif

            @if ($next)
                <a href="{{ route('experience.show', $next) }}"
                   class="group flex-1 min-w-0 text-right bg-white dark:bg-[#1a1a2e] border border-slate-200 dark:border-white/5 rounded-2xl p-5 transition-all duration-300 hover:shadow-[0_12px_40px_rgba(0,0,0,0.08)] dark:hover:shadow-[0_12px_40px_rgba(59,130,246,0.08)]">
                    <span class="block text-xs font-medium text-slate-400 dark:text-slate-500 mb-1.5"><span x-text="t('next')">Next</span><i class="ri-arrow-right-s-line ml-0.5"></i></span>
                    <span class="block font-semibold text-sm text-slate-700 dark:text-slate-200 truncate group-hover:text-accent transition-colors">{{ $next->role }}</span>
                </a>
            @else
                <span class="flex-1"></span>
            @endif
        </div>
    </div>
</section>
@endsection
