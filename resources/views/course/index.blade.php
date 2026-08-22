@extends('layouts.course')

@section('content')
<x-page-background />

<section class="relative z-20 pt-20 sm:pt-24 pb-12 overflow-hidden">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <header class="text-center mb-10 sm:mb-12" data-aos="fade-up" data-aos-duration="600">
            <h1 class="font-poppins text-3xl sm:text-4xl md:text-5xl font-bold text-slate-900 dark:text-white tracking-tight mb-3 leading-tight">
                <span x-text="t('courseTitle')">Materi Pembelajaran</span>
            </h1>

            <p class="max-w-2xl mx-auto text-base sm:text-lg text-slate-600 dark:text-slate-300 leading-relaxed"
               x-text="t('courseSubtitle')">
                Kumpulan materi belajar untuk mengasah keahlianmu di bidang pengembangan web, pemrograman, dan desain UI.
            </p>
        </header>

        @if ($courses->isEmpty())
            <div class="max-w-xl mx-auto bg-white dark:bg-[#111827] border border-slate-200 dark:border-white/10 rounded-2xl p-10 text-center" data-aos="fade-up">
                <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-500 flex items-center justify-center text-3xl">
                    <i class="ri-book-open-line"></i>
                </div>
                <h3 class="font-poppins text-lg font-semibold text-slate-900 dark:text-white mb-2" x-text="t('noCoursesYet')">Belum ada materi yang ditambahkan.</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400">Nantikan tutorial dan panduan programming terbaru.</p>
            </div>
        @else
            <div x-data="courseSearch" class="space-y-8">
                <div class="max-w-xl mx-auto" data-aos="fade-up" data-aos-duration="600">
                    <div class="relative">
                        <i class="ri-search-line absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 text-lg pointer-events-none"></i>
                        <input type="text"
                               x-model="query"
                               @input="filter()"
                               placeholder="Cari materi..."
                               maxlength="100"
                               autocomplete="off"
                               autocorrect="off"
                               spellcheck="false"
                               class="w-full pl-11 pr-10 py-3 rounded-xl border border-slate-200 dark:border-white/10 bg-white dark:bg-[#0f172a] text-sm text-slate-800 dark:text-slate-200 placeholder:text-slate-400 dark:placeholder:text-slate-500 outline-none focus:border-blue-400 dark:focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                        <button x-show="query.length > 0" x-cloak @click="query = ''; filter()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 w-6 h-6 flex items-center justify-center rounded-full text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/10 transition-colors cursor-pointer">
                            <i class="ri-close-line text-base"></i>
                        </button>
                    </div>
                    <p x-show="query.length > 0 && visibleCount === 0" x-cloak
                       class="mt-3 text-center text-sm text-slate-500 dark:text-slate-400">
                        Tidak ditemukan materi yang cocok dengan "<span x-text="query"></span>".
                    </p>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8" x-ref="grid">
                    @foreach ($courses as $i => $course)
                        @php
                            $subbabCount = collect($course->konten ?? [])->where('type', 'subbab')->count();
                            $searchable = strtolower(strip_tags($course->nama.' '.$course->desk));
                        @endphp
                        <a href="{{ route('course.show', $course) }}"
                           data-search="{{ e($searchable) }}"
                           class="course-card group block bg-white dark:bg-[#0f172a] border border-slate-200 dark:border-white/10 rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-slate-200/50 dark:hover:shadow-black/30"
                           data-aos="fade-up" data-aos-duration="600" data-aos-delay="{{ ($i % 3) * 70 }}">

                            <div class="relative aspect-16/10 overflow-hidden bg-slate-100 dark:bg-slate-800">
                                @if ($course->gambar)
                                    <img src="{{ img_url($course->gambar) }}" alt="{{ $course->nama }}"
                                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-linear-to-br from-slate-50 to-slate-100 dark:from-slate-800 dark:to-slate-900">
                                        <i class="ri-book-2-line text-5xl text-slate-300 dark:text-slate-600"></i>
                                    </div>
                                @endif

                                <div class="absolute top-3 right-3">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-black/70 text-white text-xs font-medium backdrop-blur-sm">
                                        <i class="ri-file-list-line text-xs"></i>
                                        <span>{{ $subbabCount }} Subbab</span>
                                    </span>
                                </div>
                            </div>

                            <div class="p-5">
                                <h2 class="font-poppins text-lg font-semibold text-slate-900 dark:text-white mb-2 leading-snug group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                    {{ $course->nama }}
                                </h2>

                                @if ($course->desk)
                                    <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed line-clamp-2">
                                        {{ $course->desk }}
                                    </p>
                                @endif

                                <div class="mt-4 pt-4 border-t border-slate-100 dark:border-white/10 flex items-center justify-between">
                                    <span class="text-sm font-medium text-blue-600 dark:text-blue-400 group-hover:underline">
                                        <span x-text="t('viewDetails')">Lihat Detail</span>
                                    </span>
                                    <i class="ri-arrow-right-line text-blue-600 dark:text-blue-400 text-base transition-transform duration-300 group-hover:translate-x-1"></i>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
