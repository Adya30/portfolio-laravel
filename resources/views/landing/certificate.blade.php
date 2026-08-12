@extends('layouts.app')

@section('content')
<section class="relative z-10 pt-32 pb-16 sm:pt-36">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Breadcrumb --}}
        <nav class="flex flex-wrap items-center gap-1.5 text-xs font-medium text-slate-500 dark:text-slate-400 mb-8 animate__animated animate__fadeInUp" aria-label="Breadcrumb">
            <a href="{{ route('landing') }}#certificates" class="inline-flex items-center gap-1 hover:text-accent transition-colors">
                <i class="ri-home-4-line"></i> Home
            </a>
            <i class="ri-arrow-right-s-line text-slate-300 dark:text-slate-600"></i>
            <a href="{{ route('landing') }}#certificates" class="hover:text-accent transition-colors">Certificates</a>
            <i class="ri-arrow-right-s-line text-slate-300 dark:text-slate-600"></i>
            <span class="text-accent font-semibold truncate max-w-[220px]">{{ $certificate->nama }}</span>
        </nav>

        {{-- Two panels: left = title + photo + explanation, right = certificate details --}}
        <div class="grid lg:grid-cols-[1fr_320px] gap-8 lg:gap-10 items-start">

            {{-- LEFT PANEL --}}
            <div class="min-w-0">

                {{-- Header --}}
                <header class="mb-8" data-aos="fade-up" data-aos-duration="700">
                    <div class="flex items-center gap-2 text-xs font-semibold text-accent uppercase tracking-wider mb-3">
                        <i class="ri-award-line"></i>
                        Certificate #{{ str_pad($certificate->id, 2, '0', STR_PAD_LEFT) }}
                    </div>
                    <h1 class="font-poppins text-3xl sm:text-4xl lg:text-[2.75rem] font-bold leading-tight text-slate-800 dark:text-white mb-4">
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
                                <i class="{{ $certificate->icon }}"></i><span>Certificate</span>
                            </span>
                        @endif
                    </div>
                </header>

                {{-- Certificate image (foto) --}}
                <div class="rounded-2xl overflow-hidden border border-slate-200 dark:border-white/5 bg-slate-100 dark:bg-slate-900 p-6 sm:p-8 mb-6 shadow-lg" data-aos="fade-up" data-aos-delay="100">
                    <img src="{{ img_url($certificate->gambar) }}" alt="{{ $certificate->nama }}"
                         class="w-full h-auto object-contain rounded-xl bg-white dark:bg-[#0a0a0f]" loading="lazy">
                </div>

                {{-- Description (penjelasan) --}}
                @if ($certificate->desk)
                    <div class="bg-white dark:bg-[#1a1a2e] border border-slate-200 dark:border-white/5 rounded-2xl p-7 sm:p-9 mb-6" data-aos="fade-up" data-aos-delay="150">
                        <h2 class="font-poppins text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                            <i class="ri-information-line text-accent"></i> About This Certificate
                        </h2>
                        <p class="text-sm sm:text-[0.95rem] text-slate-600 dark:text-slate-300 leading-relaxed whitespace-pre-line">
                            {{ $certificate->desk }}
                        </p>
                    </div>
                @endif

                {{-- CTA --}}
                <div class="mb-4" data-aos="fade-up" data-aos-delay="200">
                    <a href="{{ route('landing') }}#certificates"
                       class="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-full border-[1.5px] border-accent/30 text-accent dark:text-[#60a5fa] text-sm font-semibold transition-all duration-200 hover:bg-accent/10 hover:border-accent hover:-translate-y-0.5 dark:hover:bg-accent/15 dark:hover:border-[#60a5fa]">
                        <i class="ri-arrow-left-line"></i> Back to Certificates
                    </a>
                </div>
            </div>

            {{-- RIGHT PANEL: certificate details --}}
            <aside class="lg:sticky lg:top-28 space-y-6" data-aos="fade-up" data-aos-delay="150">

                {{-- Certificate details --}}
                <div class="bg-white dark:bg-[#1a1a2e] border border-slate-200 dark:border-white/5 rounded-2xl p-7">
                    <h2 class="font-poppins text-base font-bold text-slate-800 dark:text-white mb-5 flex items-center gap-2">
                        <i class="ri-award-line text-accent text-lg"></i> Certificate Details
                    </h2>
                    <ul class="space-y-3.5 text-sm">
                        <li class="flex items-center justify-between gap-3">
                            <span class="text-slate-400 dark:text-slate-500 flex items-center gap-2">
                                <i class="ri-hashtag"></i> Certificate #
                            </span>
                            <span class="font-semibold text-slate-700 dark:text-slate-200">#{{ str_pad($certificate->id, 2, '0', STR_PAD_LEFT) }}</span>
                        </li>
                        @if ($certificate->penerbit)
                            <li class="flex items-center justify-between gap-3">
                                <span class="text-slate-400 dark:text-slate-500 flex items-center gap-2">
                                    <i class="ri-building-2-line"></i> Issuer
                                </span>
                                <span class="font-semibold text-slate-700 dark:text-slate-200 text-right">{{ $certificate->penerbit }}</span>
                            </li>
                        @endif
                        @if ($certificate->tanggal)
                            <li class="flex items-center justify-between gap-3">
                                <span class="text-slate-400 dark:text-slate-500 flex items-center gap-2">
                                    <i class="ri-calendar-line"></i> Issued
                                </span>
                                <span class="font-semibold text-slate-700 dark:text-slate-200 text-right">{{ $certificate->tanggal }}</span>
                            </li>
                        @endif
                        @if ($certificate->icon)
                            <li class="flex items-center justify-between gap-3">
                                <span class="text-slate-400 dark:text-slate-500 flex items-center gap-2">
                                    <i class="{{ $certificate->icon }}"></i> Type
                                </span>
                                <span class="font-semibold text-slate-700 dark:text-slate-200">Certificate</span>
                            </li>
                        @endif
                    </ul>
                </div>
            </aside>
        </div>

        {{-- Previous / Next navigation --}}
        <div class="flex items-stretch justify-between gap-4 border-t border-slate-200 dark:border-white/10 pt-8 mt-12">
            @if ($prev)
                <a href="{{ route('certificate.show', $prev) }}"
                   class="group flex-1 min-w-0 bg-white dark:bg-[#1a1a2e] border border-slate-200 dark:border-white/5 rounded-2xl p-5 transition-all duration-300 hover:border-accent/30 hover:-translate-y-1 hover:shadow-[0_12px_40px_rgba(0,0,0,0.08)] dark:hover:shadow-[0_12px_40px_rgba(59,130,246,0.08)]">
                    <span class="block text-xs font-medium text-slate-400 dark:text-slate-500 mb-1.5"><i class="ri-arrow-left-s-line mr-0.5"></i>Previous</span>
                    <span class="block font-semibold text-sm text-slate-700 dark:text-slate-200 truncate group-hover:text-accent transition-colors">{{ $prev->nama }}</span>
                </a>
            @else
                <span class="flex-1"></span>
            @endif

            <a href="{{ route('landing') }}#certificates" title="All Certificates"
               class="flex items-center justify-center px-5 rounded-2xl border border-slate-200 dark:border-white/10 text-xs font-semibold text-slate-500 dark:text-slate-400 hover:text-accent hover:border-accent/40 transition-all duration-300">
                <i class="ri-grid-fill mr-1.5"></i>All
            </a>

            @if ($next)
                <a href="{{ route('certificate.show', $next) }}"
                   class="group flex-1 min-w-0 text-right bg-white dark:bg-[#1a1a2e] border border-slate-200 dark:border-white/5 rounded-2xl p-5 transition-all duration-300 hover:border-accent/30 hover:-translate-y-1 hover:shadow-[0_12px_40px_rgba(0,0,0,0.08)] dark:hover:shadow-[0_12px_40px_rgba(59,130,246,0.08)]">
                    <span class="block text-xs font-medium text-slate-400 dark:text-slate-500 mb-1.5">Next<i class="ri-arrow-right-s-line ml-0.5"></i></span>
                    <span class="block font-semibold text-sm text-slate-700 dark:text-slate-200 truncate group-hover:text-accent transition-colors">{{ $next->nama }}</span>
                </a>
            @else
                <span class="flex-1"></span>
            @endif
        </div>
    </div>
</section>
@endsection
