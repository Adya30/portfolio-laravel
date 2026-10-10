@extends('layouts.app')

@section('content')
    <x-page-background />

    <section class="relative z-20 pt-16 pb-8 sm:pt-20 sm:pb-10 md:pt-24">
        <div class="w-[calc(100%-2.5rem)] max-w-6xl mx-auto space-y-3 sm:space-y-4">

            <div class="rounded-3xl border border-slate-200/90 dark:border-white/10 bg-white dark:bg-[#12121a]/95 overflow-hidden shadow-none"
                data-aos="fade-up" data-aos-duration="700">
                <div
                    class="grid lg:grid-cols-[1fr_320px] items-stretch divide-y lg:divide-y-0 lg:divide-x divide-slate-200/90 dark:divide-white/10">

                    <div class="p-4 sm:p-6 lg:p-7 min-w-0 flex flex-col justify-between">
                        <div class="space-y-4 sm:space-y-5">
                            <header>
                                <div class="flex items-start gap-3 sm:gap-3.5">
                                    @if ($experience->gambar)
                                        <img src="{{ img_url($experience->gambar) }}" alt="{{ $experience->company }}"
                                            class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl object-cover border border-slate-200/80 dark:border-white/10 bg-slate-100/70 dark:bg-[#181824] shrink-0"
                                            loading="lazy">
                                    @else
                                        <span
                                            class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl shrink-0 flex items-center justify-center font-poppins font-bold text-base sm:text-lg text-orange-500 border border-slate-200/80 dark:border-white/10 bg-orange-500/10">
                                            {{ strtoupper(Str::substr(trim($experience->company), 0, 1)) }}
                                        </span>
                                    @endif
                                    <div class="min-w-0 flex-1">
                                        <h1 class="font-poppins text-base sm:text-lg lg:text-[1.5rem] font-bold leading-tight tracking-tight text-slate-900 dark:text-white mb-0.5"
                                            x-text='L(@json($experience->role), @json($experience->role_idn))'>
                                            {{ $experience->role }}
                                        </h1>
                                        <p class="text-xs sm:text-sm font-semibold text-slate-600 dark:text-slate-300">
                                            {{ $experience->company }}</p>
                                    </div>
                                </div>
                            </header>

                            <div>
                                <h2 class="font-poppins text-sm sm:text-base font-bold tracking-tight text-slate-900 dark:text-white mb-1.5"
                                    x-text="t('overview')">
                                    Overview
                                </h2>
                                <p class="prose-measure text-sm sm:text-[15px] text-slate-700 dark:text-slate-300 leading-relaxed whitespace-pre-line"
                                    x-text='L(@json($experience->desk), @json($experience->desk_idn))'>
                                    {{ $experience->desk }}
                                </p>
                            </div>

                            @if ($experience->practicum_desc)
                                <div class="pt-3.5 sm:pt-4 border-t border-slate-200/90 dark:border-white/10">
                                    <h2 class="font-poppins text-sm sm:text-base font-bold tracking-tight text-slate-900 dark:text-white mb-1.5"
                                        x-text="t('practicumResponsibilities')">
                                        Practicum Responsibilities
                                    </h2>
                                    <p class="prose-measure text-sm sm:text-[15px] text-slate-700 dark:text-slate-300 leading-relaxed whitespace-pre-line"
                                        x-text='L(@json($experience->practicum_desc), @json($experience->practicum_desc_idn))'>
                                        {{ $experience->practicum_desc }}
                                    </p>
                                </div>
                            @endif

                            @if (!empty($experience->responsibilities))
                                <div class="pt-3.5 sm:pt-4 border-t border-slate-200/90 dark:border-white/10">
                                    <h2 class="font-poppins text-sm sm:text-base font-bold tracking-tight text-slate-900 dark:text-white mb-2"
                                        x-text="t('keyResponsibilities')">
                                        Key Responsibilities
                                    </h2>
                                    <ul class="prose-measure space-y-1.5">
                                        <template
                                            x-for='(r, ri) in L(@json($experience->responsibilities ?? []), @json($experience->responsibilities_idn ?? []))'
                                            :key="ri">
                                            <li class="flex items-start gap-2 text-sm text-slate-700 dark:text-slate-300">
                                                <span class="w-1.5 h-1.5 rounded-full bg-orange-500 mt-2 shrink-0"></span>
                                                <span x-text="r"></span>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            @endif
                        </div>

                        <div
                            class="pt-4 mt-4 sm:pt-5 sm:mt-5 border-t border-slate-200/90 dark:border-white/10 flex flex-wrap items-center gap-2.5">
                            <a href="{{ route('landing') }}#experiences"
                                class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full border border-slate-300 dark:border-white/20 bg-white dark:bg-white/5 hover:border-orange-500 hover:text-orange-500 text-slate-800 dark:text-slate-200 font-semibold text-xs sm:text-sm active:scale-95 transition-all">
                                <i class="ri-arrow-left-line text-base" aria-hidden="true"></i>
                                <span x-text="t('backToExperiences')">Back to Experiences</span>
                            </a>
                        </div>
                    </div>

                    <aside class="bg-slate-50/70 dark:bg-white/[0.02] p-4 sm:p-6 lg:p-7 flex flex-col justify-between">
                        <div class="lg:sticky lg:top-20 space-y-4 sm:space-y-5">
                            <div>
                                <h2 class="font-poppins text-sm sm:text-base font-bold tracking-tight text-slate-900 dark:text-white mb-2.5"
                                    x-text="t('skillsUsed')">
                                    Skills Used
                                </h2>
                                @if (!empty($experienceSkills) && $experienceSkills->isNotEmpty())
                                    <div class="flex flex-wrap gap-1.5 sm:gap-2">
                                        @foreach ($experienceSkills as $skill)
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-semibold bg-white dark:bg-white/5 border border-slate-200/90 dark:border-white/10 text-slate-700 dark:text-slate-300">
                                                {{ $skill->nama }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400"
                                        x-text="t('noSkillsYet')">No skills are listed for this experience yet.</p>
                                @endif
                            </div>

                            <div class="pt-3.5 sm:pt-4 border-t border-slate-200/90 dark:border-white/10">
                                <h2 class="font-poppins text-sm sm:text-base font-bold tracking-tight text-slate-900 dark:text-white mb-2"
                                    x-text="t('atAGlance')">
                                    At a Glance
                                </h2>
                                <ul class="space-y-2 text-xs sm:text-sm">
                                    <li class="flex items-center justify-between gap-3">
                                        <span class="text-slate-500 dark:text-slate-400 flex items-center gap-1.5">
                                            <img src="{{ asset('images/icons/calendar.png') }}" alt=""
                                                class="w-3.5 h-3.5 object-contain inline-block shrink-0 dark:invert"
                                                aria-hidden="true">
                                            <span x-text="t('duration')">Duration</span>
                                        </span>
                                        <span
                                            class="font-semibold text-slate-700 dark:text-slate-200 text-right">{{ $experience->duration }}</span>
                                    </li>
                                    @if ($experience->location)
                                        <li class="flex items-center justify-between gap-3">
                                            <span class="text-slate-500 dark:text-slate-400 flex items-center gap-1.5">
                                                <i class="ri-map-pin-line text-slate-400" aria-hidden="true"></i>
                                                <span x-text="t('location')">Location</span>
                                            </span>
                                            <span
                                                class="font-semibold text-slate-700 dark:text-slate-200 text-right">{{ $experience->location }}</span>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>

            <div class="flex items-stretch justify-between gap-2.5 sm:gap-3 pt-0.5">
                @if ($prev)
                    <a href="{{ route('experience.show', $prev) }}"
                        class="rounded-2xl border border-slate-200/90 dark:border-white/10 bg-white dark:bg-[#12121a]/95 hover:border-orange-500/60 dark:hover:border-orange-500/60 group flex-1 min-w-0 p-3 sm:p-3.5 transition-all">
                        <span
                            class="block text-[10px] sm:text-[11px] font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-0.5"><i
                                class="ri-arrow-left-s-line mr-0.5" aria-hidden="true"></i><span
                                x-text="t('previous')">Previous</span></span>
                        <span
                            class="block font-bold text-xs sm:text-sm text-slate-900 dark:text-white truncate group-hover:text-orange-500 transition-colors">{{ $prev->role }}</span>
                    </a>
                @else
                    <span class="flex-1"></span>
                @endif

                @if ($next)
                    <a href="{{ route('experience.show', $next) }}"
                        class="rounded-2xl border border-slate-200/90 dark:border-white/10 bg-white dark:bg-[#12121a]/95 hover:border-orange-500/60 dark:hover:border-orange-500/60 group flex-1 min-w-0 text-right p-3 sm:p-3.5 transition-all">
                        <span
                            class="block text-[10px] sm:text-[11px] font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-0.5"><span
                                x-text="t('next')">Next</span><i class="ri-arrow-right-s-line ml-0.5"
                                aria-hidden="true"></i></span>
                        <span
                            class="block font-bold text-xs sm:text-sm text-slate-900 dark:text-white truncate group-hover:text-orange-500 transition-colors">{{ $next->role }}</span>
                    </a>
                @else
                    <span class="flex-1"></span>
                @endif
            </div>
        </div>
    </section>
@endsection
