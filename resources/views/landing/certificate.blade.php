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
                            <h1 class="font-poppins text-2xl sm:text-3xl lg:text-[2.75rem] font-bold leading-tight tracking-tight text-slate-900 dark:text-white mb-4" x-text='L(@json($certificate->nama), @json($certificate->nama_idn))'>
                                {{ $certificate->nama }}
                            </h1>
                        </header>

                        <div class="surface-muted p-4 sm:p-6 rounded-2xl">
                            <img src="{{ img_url($certificate->gambar) }}" alt="{{ $certificate->nama }}"
                                 class="w-full h-auto object-contain rounded-xl bg-white dark:bg-canvas-dark" loading="lazy">
                        </div>

                        @if ($certificate->desk)
                            <div class="pt-6 border-t border-line dark:border-white/10">
                                <h2 class="font-poppins text-lg font-bold tracking-tight text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                                    <i class="ri-information-line text-accent dark:text-accent-light" aria-hidden="true"></i> <span x-text="t('aboutThisCertificate')">About This Certificate</span>
                                </h2>
                                <p class="prose-measure text-sm sm:text-[0.95rem] text-slate-700 dark:text-slate-300 leading-relaxed whitespace-pre-line" x-text='L(@json($certificate->desk), @json($certificate->desk_idn))'>
                                    {{ $certificate->desk }}
                                </p>
                            </div>
                        @endif
                    </div>

                    <div class="pt-8 mt-8 border-t border-line dark:border-white/10 flex flex-wrap items-center gap-3">
                        <x-btn :href="route('landing') . '#certificates'" variant="secondary" size="md" icon="ri-arrow-left-line" class="rounded-full">
                            <span x-text="t('backToCertificates')">Back to Certificates</span>
                        </x-btn>
                    </div>
                </div>

                <!-- Sidebar (Aside) -->
                <aside class="bg-surface-muted dark:bg-white/[0.04] p-6 sm:p-8 flex flex-col">
                    <div class="lg:sticky lg:top-28 space-y-8">
                        <div>
                            <h2 class="font-poppins text-base font-bold tracking-tight text-slate-900 dark:text-white mb-5 flex items-center gap-2">
                                <i class="ri-award-line text-accent dark:text-accent-light text-lg" aria-hidden="true"></i> <span x-text="t('certificateDetails')">Certificate Details</span>
                            </h2>
                            <ul class="space-y-4 text-sm">
                                @if ($certificate->penerbit)
                                    <li class="flex items-center justify-between gap-3">
                                        <span class="text-slate-500 dark:text-slate-400 flex items-center gap-2">
                                            <i class="ri-building-2-line" aria-hidden="true"></i> <span x-text="t('issuer')">Issuer</span>
                                        </span>
                                        <span class="font-semibold text-slate-700 dark:text-slate-200 text-right">{{ $certificate->penerbit }}</span>
                                    </li>
                                @endif
                                @if ($certificate->tanggal)
                                    <li class="flex items-center justify-between gap-3">
                                        <span class="text-slate-500 dark:text-slate-400 flex items-center gap-2">
                                            <i class="ri-calendar-line" aria-hidden="true"></i> <span x-text="t('issued')">Issued</span>
                                        </span>
                                        <span class="font-semibold text-slate-700 dark:text-slate-200 text-right">{{ $certificate->tanggal }}</span>
                                    </li>
                                @endif
                            </ul>

                            @if ($certificate->link)
                                <x-btn :href="$certificate->link" target="_blank" icon="ri-external-link-line" class="w-full mt-6">
                                    <span x-text="t('visitPlatform')">Visit</span>
                                </x-btn>
                            @endif
                        </div>
                    </div>
                </aside>
            </div>
        </div>

        <!-- Pagination / Navigation (Prev/Next) -->
        <div class="flex items-stretch justify-between gap-3 sm:gap-4 border-t border-line dark:border-white/10 pt-6 mt-10">
            @if ($prev)
                <a href="{{ route('certificate.show', $prev) }}"
                   class="surface surface-interactive focus-ring group flex-1 min-w-0 rounded-2xl p-5">
                    <span class="block text-[11px] sm:text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5"><i class="ri-arrow-left-s-line mr-0.5" aria-hidden="true"></i><span x-text="t('previous')">Previous</span></span>
                    <span class="block font-bold text-sm sm:text-base text-slate-900 dark:text-white truncate group-hover:text-accent dark:group-hover:text-accent-light transition-colors">{{ $prev->nama }}</span>
                </a>
            @else
                <span class="flex-1"></span>
            @endif

            @if ($next)
                <a href="{{ route('certificate.show', $next) }}"
                   class="surface surface-interactive focus-ring group flex-1 min-w-0 text-right rounded-2xl p-5">
                    <span class="block text-[11px] sm:text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5"><span x-text="t('next')">Next</span><i class="ri-arrow-right-s-line ml-0.5" aria-hidden="true"></i></span>
                    <span class="block font-bold text-sm sm:text-base text-slate-900 dark:text-white truncate group-hover:text-accent dark:group-hover:text-accent-light transition-colors">{{ $next->nama }}</span>
                </a>
            @else
                <span class="flex-1"></span>
            @endif
        </div>
    </div>
</section>
@endsection
