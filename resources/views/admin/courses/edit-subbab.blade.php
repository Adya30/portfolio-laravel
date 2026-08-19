@extends('admin.layouts.app')

@section('title', 'Edit Subbab: '.$subbabTitle)
@section('page_title', 'Edit Subbab')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4">
            <div class="flex items-center justify-between gap-3">
                <div class="flex items-center gap-1.5 overflow-x-auto scrollbar-hide">
                    @foreach ($subbabs as $si => $sb)
                        <a href="{{ route('admin.courses.subbab.edit', [$course, $sb['block_index']]) }}"
                           @if ($sb['block_index'] === $blockIndex)
                               class="shrink-0 w-8 h-8 rounded-lg bg-accent text-white text-xs font-bold flex items-center justify-center shadow-sm"
                           @else
                               class="shrink-0 w-8 h-8 rounded-lg bg-slate-100 text-slate-500 text-xs font-bold flex items-center justify-center hover:bg-accent/10 hover:text-accent transition-colors"
                           @endif
                           title="{{ $sb['judul'] ?: 'Subbab '.($si + 1) }}">
                            {{ $si + 1 }}
                        </a>
                    @endforeach
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    @if ($prevSubbab)
                        <a href="{{ route('admin.courses.subbab.edit', [$course, $prevSubbab['block_index']]) }}"
                           class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl border border-slate-200 text-slate-600 text-xs font-semibold hover:bg-slate-50 hover:border-accent/40 transition-colors">
                            <i class="ri-arrow-left-line"></i>
                            <span class="hidden sm:inline">{{ Str::limit($prevSubbab['judul'] ?: 'Sebelumnya', 30) }}</span>
                            <span class="sm:hidden">Prev</span>
                        </a>
                    @endif
                    @if ($nextSubbab)
                        <a href="{{ route('admin.courses.subbab.edit', [$course, $nextSubbab['block_index']]) }}"
                           class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl border border-slate-200 text-slate-600 text-xs font-semibold hover:bg-slate-50 hover:border-accent/40 transition-colors">
                            <span class="hidden sm:inline">{{ Str::limit($nextSubbab['judul'] ?: 'Berikutnya', 30) }}</span>
                            <span class="sm:hidden">Next</span>
                            <i class="ri-arrow-right-line"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.courses.subbab.update', [$course, $blockIndex]) }}">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
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

            <div class="flex items-center gap-3 mt-6 pb-6">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-accent text-white text-sm font-semibold hover:bg-blue-600 transition-colors">
                    <i class="ri-save-line"></i>Simpan Subbab
                </button>
                <a href="{{ route('admin.courses.show', $course) }}"
                   class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
