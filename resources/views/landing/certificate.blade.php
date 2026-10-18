@extends('layouts.app')

@section('content')
<x-page-background />

<section class="relative z-20 pt-[calc(5.5rem+env(safe-area-inset-top,0px))] pb-8 sm:pt-20 sm:pb-10 md:pt-24">
    <div class="w-[calc(100%-2.5rem)] max-w-6xl mx-auto space-y-3 sm:space-y-4">

        <div class="rounded-3xl border border-slate-200/90 dark:border-white/10 bg-white dark:bg-[#0f172a]/95 overflow-hidden shadow-none" data-aos="fade-up" data-aos-duration="700">
            <div class="grid lg:grid-cols-[1fr_320px] items-stretch divide-y lg:divide-y-0 lg:divide-x divide-slate-200/90 dark:divide-white/10">

                <div class="p-4 sm:p-6 lg:p-7 min-w-0 flex flex-col justify-between">
                    <div class="space-y-4 sm:space-y-5">
                        <header>
                            <h1 class="font-poppins text-xl sm:text-2xl lg:text-[2rem] font-bold leading-tight tracking-tight text-slate-900 dark:text-white" x-text='L(@json($certificate->nama), @json($certificate->nama_idn))'>
                                {{ $certificate->nama }}
                            </h1>
                        </header>

                        <div class="rounded-2xl border border-slate-200/80 dark:border-white/10 bg-slate-100/70 dark:bg-[#1e293b] p-1.5 sm:p-2 overflow-hidden">
                            <img src="{{ img_url($certificate->gambar) }}" alt="Sertifikat {{ $certificate->nama }} - {{ $certificate->penerbit ?? 'Adya Portfolio' }}" title="{{ $certificate->nama }}"
                                 class="w-full h-auto object-contain rounded-xl bg-white dark:bg-black/30" loading="lazy" decoding="async">
                        </div>

                        @if ($certificate->desk)
                            <div class="pt-3.5 sm:pt-4 border-t border-slate-200/90 dark:border-white/10">
                                <h2 class="font-poppins text-sm sm:text-base font-bold tracking-tight text-slate-900 dark:text-white mb-1.5" x-text="t('aboutThisCertificate')">
                                    About This Certificate
                                </h2>
                                <p class="prose-measure text-sm sm:text-[15px] text-slate-700 dark:text-slate-300 leading-relaxed whitespace-pre-line" x-text='L(@json($certificate->desk), @json($certificate->desk_idn))'>
                                    {{ $certificate->desk }}
                                </p>
                            </div>
                        @endif
                    </div>

                    @if ($prev || $next)
                        <div class="pt-4 mt-4 sm:pt-5 sm:mt-5 border-t border-slate-200/90 dark:border-white/10 flex items-center justify-between gap-3">
                            @if ($prev)
                                <a href="{{ route('certificate.show', $prev) }}"
                                   class="group inline-flex items-center gap-2 px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-full border border-slate-300 dark:border-white/20 bg-white dark:bg-white/5 hover:border-orange-500 hover:text-orange-500 text-slate-800 dark:text-slate-200 font-semibold text-xs sm:text-sm active:scale-95 transition-all">
                                    <i class="ri-arrow-left-line text-base shrink-0 group-hover:-translate-x-0.5 transition-transform" aria-hidden="true"></i>
                                    <span x-text="t('previousCertificate')">Prev Certificate</span>
                                </a>
                            @else
                                <span></span>
                            @endif

                            @if ($next)
                                <a href="{{ route('certificate.show', $next) }}"
                                   class="group inline-flex items-center justify-end gap-2 px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-full border border-slate-300 dark:border-white/20 bg-white dark:bg-white/5 hover:border-orange-500 hover:text-orange-500 text-slate-800 dark:text-slate-200 font-semibold text-xs sm:text-sm active:scale-95 transition-all ml-auto">
                                    <span x-text="t('nextCertificate')">Next Certificate</span>
                                    <i class="ri-arrow-right-line text-base shrink-0 group-hover:translate-x-0.5 transition-transform" aria-hidden="true"></i>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                <aside class="bg-slate-50/70 dark:bg-white/[0.02] p-4 sm:p-6 lg:p-7 flex flex-col justify-between">
                    <div class="lg:sticky lg:top-20 space-y-4 sm:space-y-5">
                        <div>
                            <h2 class="font-poppins text-sm sm:text-base font-bold tracking-tight text-slate-900 dark:text-white mb-2.5" x-text="t('certificateDetails')">
                                Certificate Details
                            </h2>
                            <ul class="space-y-2 text-xs sm:text-sm">
                                @if ($certificate->penerbit)
                                    <li class="flex items-center justify-between gap-3">
                                        <span class="text-slate-500 dark:text-slate-400" x-text="t('issuer')">Issuer</span>
                                        <span class="font-semibold text-slate-700 dark:text-slate-200 text-right">{{ $certificate->penerbit }}</span>
                                    </li>
                                @endif
                                @if ($certificate->tanggal)
                                    <li class="flex items-center justify-between gap-3">
                                        <span class="text-slate-500 dark:text-slate-400 flex items-center gap-1.5">
                                            <img src="{{ asset('images/icons/calendar.png') }}" alt="" class="w-3.5 h-3.5 object-contain inline-block shrink-0 dark:invert" aria-hidden="true">
                                            <span x-text="t('issued')">Issued</span>
                                        </span>
                                        <span class="font-semibold text-slate-700 dark:text-slate-200 text-right">{{ $certificate->tanggal }}</span>
                                    </li>
                                @endif
                            </ul>

                            @if ($certificate->link)
                                <a href="{{ $certificate->link }}" target="_blank" rel="noopener noreferrer"
                                    class="inline-flex items-center justify-center gap-2 w-full px-3.5 py-1.5 rounded-full bg-orange-500 hover:bg-orange-600 text-white font-bold text-xs sm:text-sm active:scale-95 transition-all mt-3.5 sm:mt-4">
                                    <i class="ri-external-link-line text-base" aria-hidden="true"></i>
                                    <span x-text="t('visitPlatform')">Visit</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>
@endsection
