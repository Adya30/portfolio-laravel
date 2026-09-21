@extends('layouts.app')

@section('content')
<x-page-background />

<section class="relative z-20 pt-24 pb-16 sm:pt-28 sm:pb-20 md:pt-32 overflow-x-clip">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Main Card -->
        <div class="surface rounded-2xl overflow-hidden" data-aos="fade-up" data-aos-duration="700">
            <div class="grid lg:grid-cols-[1fr_320px] items-stretch divide-y lg:divide-y-0 lg:divide-x divide-line dark:divide-white/10">

                <div class="p-6 sm:p-8 lg:p-10 min-w-0 flex flex-col justify-between">
                    <div class="space-y-8">
                        <header>
                            <div class="flex items-start gap-5">
                                @if ($experience->gambar)
                                    <img src="{{ img_url($experience->gambar) }}" alt="{{ $experience->company }}"
                                         class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl object-cover surface-muted shrink-0" loading="lazy">
                                @else
                                    <span class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl shrink-0 flex items-center justify-center font-poppins font-bold text-2xl sm:text-3xl text-accent dark:text-accent-light surface-muted">
                                        {{ strtoupper(Str::substr(trim($experience->company), 0, 1)) }}
                                    </span>
                                @endif
                                <div class="min-w-0 flex-1">
                                    <h1 class="font-poppins text-xl sm:text-2xl lg:text-[2rem] font-bold leading-tight tracking-tight text-slate-900 dark:text-white mb-2" x-text='L(@json($experience->role), @json($experience->role_idn))'>
                                        {{ $experience->role }}
                                    </h1>
                                    <p class="text-base font-semibold text-slate-600 dark:text-slate-300">{{ $experience->company }}</p>
                                </div>
                            </div>
                        </header>

                        <div>
                            <h2 class="font-poppins text-lg font-bold tracking-tight text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                                <i class="ri-information-line text-accent dark:text-accent-light" aria-hidden="true"></i> <span x-text="t('overview')">Overview</span>
                            </h2>
                            <p class="prose-measure text-sm sm:text-[0.95rem] text-slate-700 dark:text-slate-300 leading-relaxed whitespace-pre-line" x-text='L(@json($experience->desk), @json($experience->desk_idn))'>
                                {{ $experience->desk }}
                            </p>
                        </div>

                        @if ($experience->practicum_desc)
                            <div class="pt-6 border-t border-line dark:border-white/10">
                                <h2 class="font-poppins text-lg font-bold tracking-tight text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                                    <i class="ri-graduation-cap-line text-accent dark:text-accent-light" aria-hidden="true"></i> <span x-text="t('practicumResponsibilities')">Practicum Responsibilities</span>
                                </h2>
                                <p class="prose-measure text-sm sm:text-[0.95rem] text-slate-700 dark:text-slate-300 leading-relaxed whitespace-pre-line" x-text='L(@json($experience->practicum_desc), @json($experience->practicum_desc_idn))'>
                                    {{ $experience->practicum_desc }}
                                </p>
                            </div>
                        @endif

                        @if (! empty($experience->responsibilities))
                            <div class="pt-6 border-t border-line dark:border-white/10">
                                <h2 class="font-poppins text-lg font-bold tracking-tight text-slate-900 dark:text-white mb-5 flex items-center gap-2">
                                    <i class="ri-task-line text-accent dark:text-accent-light" aria-hidden="true"></i> <span x-text="t('keyResponsibilities')">Key Responsibilities</span>
                                </h2>
                                <ul class="prose-measure space-y-3">
                                    <template x-for='(r, ri) in L(@json($experience->responsibilities ?? []), @json($experience->responsibilities_idn ?? []))' :key="ri">
                                        <li class="flex items-start gap-3 text-sm text-slate-700 dark:text-slate-300">
                                            <i class="ri-checkbox-circle-line text-accent dark:text-accent-light mt-0.5 shrink-0" aria-hidden="true"></i>
                                            <span x-text="r"></span>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div class="pt-8 mt-8 border-t border-line dark:border-white/10 flex flex-wrap items-center gap-3">
                        <x-btn :href="route('landing') . '#experiences'" variant="secondary" size="md" icon="ri-arrow-left-line" class="rounded-full">
                            <span x-text="t('backToExperiences')">Back to Experiences</span>
                        </x-btn>
                    </div>
                </div>

                <!-- Sidebar (Aside) -->
                <aside class="bg-surface-muted dark:bg-white/[0.04] p-6 sm:p-8 flex flex-col">
                    <div class="lg:sticky lg:top-28 space-y-8">
                        <div>
                            <h2 class="font-poppins text-base font-bold tracking-tight text-slate-900 dark:text-white mb-5 flex items-center gap-2">
                                <i class="ri-tools-line text-accent dark:text-accent-light text-lg" aria-hidden="true"></i> <span x-text="t('skillsUsed')">Skills Used</span>
                            </h2>
                            @if (! empty($experienceSkills) && $experienceSkills->isNotEmpty())
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($experienceSkills as $skill)
                                        <span class="chip">
                                            {{ $skill->nama }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-slate-500 dark:text-slate-400" x-text="t('noSkillsYet')">No skills are listed for this experience yet.</p>
                            @endif
                        </div>

                        <div class="pt-6 border-t border-line dark:border-white/10">
                            <h2 class="font-poppins text-base font-bold tracking-tight text-slate-900 dark:text-white mb-5 flex items-center gap-2">
                                <i class="ri-information-line text-accent dark:text-accent-light text-lg" aria-hidden="true"></i> <span x-text="t('atAGlance')">At a Glance</span>
                            </h2>
                            <ul class="space-y-4 text-sm">
                                <li class="flex items-center justify-between gap-3">
                                    <span class="text-slate-500 dark:text-slate-400 flex items-center gap-2">
                                        <i class="ri-calendar-line text-accent/70" aria-hidden="true"></i> <span x-text="t('duration')">Duration</span>
                                    </span>
                                    <span class="font-semibold text-slate-700 dark:text-slate-200 text-right">{{ $experience->duration }}</span>
                                </li>
                                @if ($experience->location)
                                    <li class="flex items-center justify-between gap-3">
                                        <span class="text-slate-500 dark:text-slate-400 flex items-center gap-2">
                                            <i class="ri-map-pin-line text-slate-400" aria-hidden="true"></i> <span x-text="t('location')">Location</span>
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

        <!-- Pagination / Navigation (Prev/Next) -->
        <div class="flex items-stretch justify-between gap-3 sm:gap-4 border-t border-line dark:border-white/10 pt-6 mt-10">
            @if ($prev)
                <a href="{{ route('experience.show', $prev) }}"
                   class="surface surface-interactive focus-ring group flex-1 min-w-0 rounded-2xl p-5">
                    <span class="block text-[11px] sm:text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5"><i class="ri-arrow-left-s-line mr-0.5" aria-hidden="true"></i><span x-text="t('previous')">Previous</span></span>
                    <span class="block font-bold text-sm sm:text-base text-slate-900 dark:text-white truncate group-hover:text-accent dark:group-hover:text-accent-light transition-colors">{{ $prev->role }}</span>
                </a>
            @else
                <span class="flex-1"></span>
            @endif

            @if ($next)
                <a href="{{ route('experience.show', $next) }}"
                   class="surface surface-interactive focus-ring group flex-1 min-w-0 text-right rounded-2xl p-5">
                    <span class="block text-[11px] sm:text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5"><span x-text="t('next')">Next</span><i class="ri-arrow-right-s-line ml-0.5" aria-hidden="true"></i></span>
                    <span class="block font-bold text-sm sm:text-base text-slate-900 dark:text-white truncate group-hover:text-accent dark:group-hover:text-accent-light transition-colors">{{ $next->role }}</span>
                </a>
            @else
                <span class="flex-1"></span>
            @endif
        </div>
    </div>
</section>
@endsection
