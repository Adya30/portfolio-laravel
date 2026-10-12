@extends('admin.layouts.app')

@section('title', 'Edit Subbab')
@section('page_title', 'Edit Subbab')

@section('content')
    <div class="w-full space-y-6">

        <nav class="flex flex-wrap items-center gap-x-2 gap-y-1 text-xs" aria-label="Breadcrumb">
            <a href="{{ route('admin.courses.index') }}"
               class="font-semibold text-slate-500 dark:text-slate-400 hover:text-orange-500 dark:hover:text-orange-400 transition-colors">Materi</a>
            <i class="ri-arrow-right-s-line text-slate-300 dark:text-slate-600" aria-hidden="true"></i>
            <a href="{{ route('admin.courses.show', $course) }}"
               class="font-semibold text-slate-500 dark:text-slate-400 hover:text-orange-500 dark:hover:text-orange-400 transition-colors truncate max-w-[14rem]">{{ $course->nama }}</a>
            <i class="ri-arrow-right-s-line text-slate-300 dark:text-slate-600" aria-hidden="true"></i>
            <span class="font-semibold text-slate-700 dark:text-white truncate max-w-[14rem]">{{ $subbabTitle ?: 'Subbab' }}</span>
        </nav>

        <div class="bg-white dark:bg-[#162032] rounded-2xl border border-slate-200/80 dark:border-white/10 shadow-xs p-4">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="flex min-w-0 items-center gap-3">
                    <span class="shrink-0 text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Subbab</span>
                    <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar pb-1">
                        @foreach ($subbabs as $si => $sb)
                            <a href="{{ route('admin.courses.subbab.edit', [$course, $sb['block_index']]) }}"
                               title="{{ $sb['judul'] ?: 'Subbab '.($si + 1) }}"
                               aria-label="Buka subbab {{ $si + 1 }}: {{ $sb['judul'] ?: 'Tanpa judul' }}"
                               @if ($sb['block_index'] === $blockIndex) aria-current="page" @endif
                               class="focus-ring shrink-0 w-8 h-8 rounded-lg text-xs font-bold flex items-center justify-center transition-colors
                                      {{ $sb['block_index'] === $blockIndex
                                          ? 'bg-orange-500 text-white shadow-sm'
                                          : 'bg-slate-100 dark:bg-white/5 text-slate-600 dark:text-slate-300 hover:bg-orange-500/10 hover:text-orange-500 dark:hover:text-orange-400' }}">
                                {{ $si + 1 }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    @if ($prevSubbab)
                        <a href="{{ route('admin.courses.subbab.edit', [$course, $prevSubbab['block_index']]) }}"
                           class="focus-ring inline-flex items-center gap-1.5 px-3 py-2 rounded-xl border border-slate-200 dark:border-white/10 text-slate-600 dark:text-slate-200 text-xs font-semibold hover:bg-slate-50 dark:hover:bg-white/5 hover:border-orange-500/40 hover:text-orange-500 dark:hover:text-orange-400 transition-colors">
                            <i class="ri-arrow-left-line" aria-hidden="true"></i>
                            <span class="hidden sm:inline">{{ Str::limit($prevSubbab['judul'] ?: 'Sebelumnya', 30) }}</span>
                            <span class="sm:hidden">Sebelumnya</span>
                        </a>
                    @endif
                    @if ($nextSubbab)
                        <a href="{{ route('admin.courses.subbab.edit', [$course, $nextSubbab['block_index']]) }}"
                           class="focus-ring inline-flex items-center gap-1.5 px-3 py-2 rounded-xl border border-slate-200 dark:border-white/10 text-slate-600 dark:text-slate-200 text-xs font-semibold hover:bg-slate-50 dark:hover:bg-white/5 hover:border-orange-500/40 hover:text-orange-500 dark:hover:text-orange-400 transition-colors">
                            <span class="hidden sm:inline">{{ Str::limit($nextSubbab['judul'] ?: 'Berikutnya', 30) }}</span>
                            <span class="sm:hidden">Berikutnya</span>
                            <i class="ri-arrow-right-line" aria-hidden="true"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.courses.subbab.update', [$course, $blockIndex]) }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="original_subbab_title" value="{{ $originalSubbabTitle }}">
            <input type="hidden" name="original_subbab_position" value="{{ $originalSubbabPosition }}">
            <input type="hidden" name="updated_at" value="{{ $course->updated_at->timestamp }}">

            <div class="bg-white dark:bg-[#162032] rounded-2xl border border-slate-200/80 dark:border-white/10 shadow-xs">
                <div class="px-6 py-4 border-b border-slate-100 dark:border-white/10 bg-slate-50/50 dark:bg-white/5">
                    <h3 class="font-poppins font-bold text-slate-800 dark:text-white text-sm flex items-center gap-2">
                        <i class="ri-stack-line text-orange-500"></i>Isi Subbab : {{ $subbabTitle }}
                    </h3>
                </div>

                <div>
                    @php $blocksValue = $subbabBlocks; $hideSubbab = true; @endphp
                    @include('admin.courses._blocks-editor')
                </div>
            </div>

            <div class="mt-8 flex flex-wrap items-center gap-3 pt-6 border-t border-slate-200/80 dark:border-white/10 pb-6">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-orange-500 text-white text-sm font-semibold hover:bg-orange-600 hover:-translate-y-0.5 transition-all shadow-sm cursor-pointer">
                    <i class="ri-save-line"></i>Simpan Subbab
                </button>
                <a href="{{ route('admin.courses.show', $course) }}"
                   class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-white/10 bg-white dark:bg-[#162032] text-slate-700 dark:text-slate-200 text-sm font-semibold hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                    Kembali ke Daftar Subbab
                </a>
                <span class="hidden text-xs text-slate-500 dark:text-slate-400 sm:ml-auto sm:block">
                    Tekan Simpan untuk menerapkan perubahan ke server.
                </span>
            </div>
        </form>
    </div>
@endsection
