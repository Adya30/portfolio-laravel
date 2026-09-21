@extends('admin.layouts.app')

@section('title', 'Edit Subbab')
@section('page_title', 'Edit Subbab')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">

        {{-- The editor sits two levels below the materi list, so the way back is
             stated instead of implied. --}}
        <nav class="flex flex-wrap items-center gap-x-2 gap-y-1 text-xs" aria-label="Breadcrumb">
            <a href="{{ route('admin.courses.index') }}"
               class="font-semibold text-slate-500 hover:text-accent transition-colors">Materi</a>
            <i class="ri-arrow-right-s-line text-slate-300" aria-hidden="true"></i>
            <a href="{{ route('admin.courses.show', $course) }}"
               class="font-semibold text-slate-500 hover:text-accent transition-colors truncate max-w-[14rem]">{{ $course->nama }}</a>
            <i class="ri-arrow-right-s-line text-slate-300" aria-hidden="true"></i>
            <span class="font-semibold text-slate-700 truncate max-w-[14rem]">{{ $subbabTitle ?: 'Subbab' }}</span>
        </nav>

        {{-- Subbab pager: jump to any subbab, or step through in order. --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="flex min-w-0 items-center gap-3">
                    <span class="shrink-0 text-[11px] font-bold uppercase tracking-wider text-slate-500">Subbab</span>
                    <div class="flex items-center gap-1.5 overflow-x-auto scrollbar-none pb-1">
                        @foreach ($subbabs as $si => $sb)
                            <a href="{{ route('admin.courses.subbab.edit', [$course, $sb['block_index']]) }}"
                               title="{{ $sb['judul'] ?: 'Subbab '.($si + 1) }}"
                               aria-label="Buka subbab {{ $si + 1 }}: {{ $sb['judul'] ?: 'Tanpa judul' }}"
                               @if ($sb['block_index'] === $blockIndex) aria-current="page" @endif
                               class="focus-ring shrink-0 w-8 h-8 rounded-lg text-xs font-bold flex items-center justify-center transition-colors
                                      {{ $sb['block_index'] === $blockIndex
                                          ? 'bg-accent text-white shadow-sm'
                                          : 'bg-slate-100 text-slate-500 hover:bg-accent/10 hover:text-accent' }}">
                                {{ $si + 1 }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    @if ($prevSubbab)
                        <a href="{{ route('admin.courses.subbab.edit', [$course, $prevSubbab['block_index']]) }}"
                           class="focus-ring inline-flex items-center gap-1.5 px-3 py-2 rounded-xl border border-slate-200 text-slate-600 text-xs font-semibold hover:bg-slate-50 hover:border-accent/40 transition-colors">
                            <i class="ri-arrow-left-line" aria-hidden="true"></i>
                            <span class="hidden sm:inline">{{ Str::limit($prevSubbab['judul'] ?: 'Sebelumnya', 30) }}</span>
                            <span class="sm:hidden">Sebelumnya</span>
                        </a>
                    @endif
                    @if ($nextSubbab)
                        <a href="{{ route('admin.courses.subbab.edit', [$course, $nextSubbab['block_index']]) }}"
                           class="focus-ring inline-flex items-center gap-1.5 px-3 py-2 rounded-xl border border-slate-200 text-slate-600 text-xs font-semibold hover:bg-slate-50 hover:border-accent/40 transition-colors">
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

            {{-- No overflow-hidden here: the block editor opens dropdown menus that
                 must paint over the material below instead of being clipped. --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-poppins font-bold text-slate-800 text-sm flex items-center gap-2">
                        <i class="ri-stack-line text-accent"></i>Isi Subbab : {{ $subbabTitle }}
                    </h3>
                </div>

                <div>
                    @php $blocksValue = $subbabBlocks; $hideSubbab = true; @endphp
                    @include('admin.courses._blocks-editor')
                </div>
            </div>

            {{-- Save bar stays in view however long the material gets. --}}
            <div class="sticky bottom-0 z-10 mt-6 flex flex-wrap items-center gap-3 border-t border-slate-200 bg-slate-100/95 py-3.5 backdrop-blur">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-accent text-white text-sm font-semibold hover:bg-blue-600 hover:-translate-y-0.5 transition-all shadow-sm">
                    <i class="ri-save-line"></i>Simpan Subbab
                </button>
                <a href="{{ route('admin.courses.show', $course) }}"
                   class="px-5 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors">
                    Kembali ke Daftar Subbab
                </a>
                <span class="hidden text-xs text-slate-500 sm:ml-auto sm:block">
                    Tekan Simpan untuk menerapkan perubahan ke server.
                </span>
            </div>
        </form>
    </div>
@endsection
