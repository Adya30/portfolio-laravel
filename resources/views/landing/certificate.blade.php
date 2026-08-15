@extends('layouts.app')

@section('content')
<x-page-background />

<section class="relative z-20 pt-20 pb-16 sm:pt-24">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <nav class="flex flex-wrap items-center gap-1.5 text-xs font-medium text-slate-500 dark:text-slate-400 mb-8 animate__animated animate__fadeInUp" aria-label="Breadcrumb">
            <a href="{{ route('landing') }}#certificates" class="inline-flex items-center gap-1 hover:text-accent transition-colors">
                <i class="ri-home-4-line"></i> <span x-text="t('home')">Home</span>
            </a>
            <i class="ri-arrow-right-s-line text-slate-300 dark:text-slate-600"></i>
            <a href="{{ route('landing') }}#certificates" class="hover:text-accent transition-colors" x-text="t('certificatesBreadcrumb')">Certificates</a>
            <i class="ri-arrow-right-s-line text-slate-300 dark:text-slate-600"></i>
            <span class="text-accent font-semibold truncate max-w-55" x-text='L(@json($certificate->nama), @json($certificate->nama_idn))'>{{ $certificate->nama }}</span>
        </nav>

        <div class="bg-white dark:bg-[#1a1a2e] border border-slate-200 dark:border-white/5 rounded-3xl overflow-hidden shadow-xl shadow-slate-200/50 dark:shadow-black/20" data-aos="fade-up" data-aos-duration="700">
            <div class="grid lg:grid-cols-[1fr_320px] items-stretch divide-y lg:divide-y-0 lg:divide-x divide-slate-200 dark:divide-white/5">

                <div class="p-6 sm:p-8 lg:p-10 min-w-0 flex flex-col justify-between">
                    <div class="space-y-8">
                        <header>
                            <div class="flex items-center gap-2 text-xs font-semibold text-accent uppercase tracking-wider mb-3">
                                <i class="ri-award-line"></i>
                                <span x-text="t('certificate')">Certificate</span> #{{ str_pad($certificate->id, 2, '0', STR_PAD_LEFT) }}
                            </div>
                            <h1 class="font-poppins text-3xl sm:text-4xl lg:text-[2.75rem] font-bold leading-tight text-slate-800 dark:text-white mb-4" x-text='L(@json($certificate->nama), @json($certificate->nama_idn))'>
                                {{ $certificate->nama }}
                            </h1>

                            <div class="flex flex-wrap items-center gap-x-5 gap-y-2 text-sm text-slate-500 dark:text-slate-400">
                                @if ($certificate->penerbit)
                                    <span class="flex items-center gap-1.5">
                                        <i class="ri-building-2-line"></i>{{ $certificate->penerbit }}
                                    </span>
                                @endif
                                @if ($certificate->tanggal)
                                    <span class="flex items-center gap-1.5">
                                        <i class="ri-calendar-line"></i>{{ $certificate->tanggal }}
                                    </span>
                                @endif
                                @if ($certificate->icon)
                                    <span class="flex items-center gap-1.5">
                                        <i class="{{ $certificate->icon }}"></i><span x-text="t('certificate')">Certificate</span>
                                    </span>
                                @endif
                            </div>
                        </header>

                        <div class="bg-slate-100 dark:bg-slate-900 p-4 sm:p-6 rounded-2xl border border-slate-200/80 dark:border-white/5">
                            <img src="{{ img_url($certificate->gambar) }}" alt="{{ $certificate->nama }}"
                                 class="w-full h-auto object-contain rounded-xl bg-white dark:bg-[#0a0a0f]" loading="lazy">
                        </div>

                        @if ($certificate->desk)
                            <div class="pt-6 border-t border-slate-200/60 dark:border-white/5">
                                <h2 class="font-poppins text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                                    <i class="ri-information-line text-accent"></i> <span x-text="t('aboutThisCertificate')">About This Certificate</span>
                                </h2>
                                <p class="text-sm sm:text-[0.95rem] text-slate-600 dark:text-slate-300 leading-relaxed whitespace-pre-line" x-text='L(@json($certificate->desk), @json($certificate->desk_idn))'>
                                    {{ $certificate->desk }}
                                </p>
                            </div>
                        @endif
                    </div>

                    <div class="pt-8 mt-8 border-t border-slate-200/60 dark:border-white/5 flex flex-wrap items-center gap-3">
                        <a href="{{ route('landing') }}#certificates"
                           class="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-full border-[1.5px] border-accent/30 text-accent dark:text-[#60a5fa] text-sm font-semibold transition-all duration-200 hover:bg-accent/10 hover:border-accent hover:-translate-y-0.5 dark:hover:bg-accent/15 dark:hover:border-[#60a5fa]">
                            <i class="ri-arrow-left-line"></i> <span x-text="t('backToCertificates')">Back to Certificates</span>
                        </a>
                    </div>
                </div>

                <aside class="bg-slate-50/50 dark:bg-[#161626]/40 p-6 sm:p-8 flex flex-col">
                    <div class="lg:sticky lg:top-28 space-y-8">
                        <div>
                            <h2 class="font-poppins text-base font-bold text-slate-800 dark:text-white mb-5 flex items-center gap-2">
                                <i class="ri-award-line text-accent text-lg"></i> <span x-text="t('certificateDetails')">Certificate Details</span>
                            </h2>
                            <ul class="space-y-3.5 text-sm">
                                <li class="flex items-center justify-between gap-3">
                                    <span class="text-slate-400 dark:text-slate-500 flex items-center gap-2">
                                        <i class="ri-hashtag"></i> <span x-text="t('certificate')">Certificate</span> #
                                    </span>
                                    <span class="font-semibold text-slate-700 dark:text-slate-200">#{{ str_pad($certificate->id, 2, '0', STR_PAD_LEFT) }}</span>
                                </li>
                                @if ($certificate->penerbit)
                                    <li class="flex items-center justify-between gap-3">
                                        <span class="text-slate-400 dark:text-slate-500 flex items-center gap-2">
                                            <i class="ri-building-2-line"></i> <span x-text="t('issuer')">Issuer</span>
                                        </span>
                                        <span class="font-semibold text-slate-700 dark:text-slate-200 text-right">{{ $certificate->penerbit }}</span>
                                    </li>
                                @endif
                                @if ($certificate->tanggal)
                                    <li class="flex items-center justify-between gap-3">
                                        <span class="text-slate-400 dark:text-slate-500 flex items-center gap-2">
                                            <i class="ri-calendar-line"></i> <span x-text="t('issued')">Issued</span>
                                        </span>
                                        <span class="font-semibold text-slate-700 dark:text-slate-200 text-right">{{ $certificate->tanggal }}</span>
                                    </li>
                                @endif
                                @if ($certificate->icon)
                                    <li class="flex items-center justify-between gap-3">
                                        <span class="text-slate-400 dark:text-slate-500 flex items-center gap-2">
                                            <i class="{{ $certificate->icon }}"></i> <span x-text="t('type')">Type</span>
                                        </span>
                                        <span class="font-semibold text-slate-700 dark:text-slate-200" x-text="t('certificate')">Certificate</span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </aside>
            </div>
        </div>

        <div class="flex items-stretch justify-between gap-4 border-t border-slate-200 dark:border-white/10 pt-8 mt-12">
            @if ($prev)
                <a href="{{ route('certificate.show', $prev) }}"
                   class="group flex-1 min-w-0 bg-white dark:bg-[#1a1a2e] border border-slate-200 dark:border-white/5 rounded-2xl p-5 transition-all duration-300 hover:shadow-[0_12px_40px_rgba(0,0,0,0.08)] dark:hover:shadow-[0_12px_40px_rgba(59,130,246,0.08)]">
                    <span class="block text-xs font-medium text-slate-400 dark:text-slate-500 mb-1.5"><i class="ri-arrow-left-s-line mr-0.5"></i><span x-text="t('previous')">Previous</span></span>
                    <span class="block font-semibold text-sm text-slate-700 dark:text-slate-200 truncate group-hover:text-accent transition-colors">{{ $prev->nama }}</span>
                </a>
            @else
                <span class="flex-1"></span>
            @endif

            @if ($next)
                <a href="{{ route('certificate.show', $next) }}"
                   class="group flex-1 min-w-0 text-right bg-white dark:bg-[#1a1a2e] border border-slate-200 dark:border-white/5 rounded-2xl p-5 transition-all duration-300 hover:shadow-[0_12px_40px_rgba(0,0,0,0.08)] dark:hover:shadow-[0_12px_40px_rgba(59,130,246,0.08)]">
                    <span class="block text-xs font-medium text-slate-400 dark:text-slate-500 mb-1.5"><span x-text="t('next')">Next</span><i class="ri-arrow-right-s-line ml-0.5"></i></span>
                    <span class="block font-semibold text-sm text-slate-700 dark:text-slate-200 truncate group-hover:text-accent transition-colors">{{ $next->nama }}</span>
                </a>
            @else
                <span class="flex-1"></span>
            @endif
        </div>
    </div>
</section>
@endsection
