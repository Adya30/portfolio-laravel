@extends('admin.layouts.app')

@section('title', 'Subbab: '.$course->nama)
@section('page_title', 'Subbab Materi')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div class="min-w-0">
            <a href="{{ route('admin.courses.index') }}"
               class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-accent transition-colors mb-1.5">
                <i class="ri-arrow-left-line"></i>Kembali ke Index Materi
            </a>
            <h2 class="font-poppins text-xl sm:text-2xl font-bold text-slate-800 truncate">{{ $course->nama }}</h2>
            @if ($course->desk)
                <p class="text-sm text-slate-500 mt-0.5 line-clamp-2">{{ $course->desk }}</p>
            @endif
        </div>
        <form method="POST" action="{{ route('admin.courses.subbab.store', $course) }}">
            @csrf
            <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-accent text-white text-sm font-semibold hover:bg-blue-600 hover:-translate-y-0.5 transition-all shadow-sm">
                <i class="ri-add-line"></i>Tambah Subbab
            </button>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-6">
        <div class="flex items-center justify-between gap-3 border-b border-slate-100 pb-4">
            <div>
                <h3 class="font-poppins font-bold text-slate-800 text-base flex items-center gap-2">
                    <i class="ri-bookmark-line text-accent"></i>Daftar Subbab Materi
                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-accent/10 text-accent">{{ count($subbabs) }}</span>
                </h3>
            </div>
        </div>

        @if (empty($subbabs))
            <div class="py-14 text-center text-slate-400">
                <i class="ri-bookmark-line text-4xl block mb-3 text-slate-300"></i>
                <p class="text-sm font-semibold text-slate-600">Belum ada subbab pada materi ini.</p>
                <p class="text-xs text-slate-400 mt-1">Klik tombol <strong>"Tambah Subbab"</strong> untuk membuat subbab baru.</p>
                <form method="POST" action="{{ route('admin.courses.subbab.store', $course) }}">
                    @csrf
                    <button type="submit"
                            class="inline-flex items-center gap-2 mt-4 px-4 py-2.5 rounded-xl bg-accent text-white text-sm font-semibold hover:bg-blue-600 transition-colors">
                        <i class="ri-add-line"></i>Tambah Subbab
                    </button>
                </form>
            </div>
        @else
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($subbabs as $i => $subbab)
                    <div class="bg-slate-50/70 hover:bg-slate-100/80 border border-slate-200/80 rounded-2xl p-5 flex flex-col justify-between transition-all hover:shadow-md group">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between gap-2">
                                <span class="w-8 h-8 rounded-xl bg-accent/10 text-accent font-bold text-xs flex items-center justify-center">
                                    {{ $i + 1 }}
                                </span>
                                <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Subbab</span>
                            </div>

                            <div>
                                <h4 class="font-poppins font-bold text-slate-800 text-sm leading-snug group-hover:text-accent transition-colors line-clamp-2">
                                    {{ $subbab['judul'] ?: 'Subbab '.($i + 1) }}
                                </h4>
                            </div>
                        </div>

                        <div class="pt-4 mt-4 border-t border-slate-200/60 flex items-center justify-between">
                            <span class="text-xs text-slate-400">{{ count($subbabs) > 1 ? ($i + 1).'/'.count($subbabs) : '' }}</span>
                            <div class="flex items-center gap-1.5">
                                <x-admin.delete-modal
                                    :action="route('admin.courses.subbab.destroy', [$course, $subbab['block_index']])"
                                    item-name="{{ $subbab['judul'] ?: 'Subbab '.($i + 1) }}"
                                    item-type="subbab" />
                                <a href="{{ route('admin.courses.subbab.edit', [$course, $subbab['block_index']]) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-accent text-white text-xs font-semibold hover:bg-blue-600 transition-colors">
                                    <i class="ri-edit-line"></i>
                                    <span>Edit</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if (count($subbabs) && $totalBlocks > 0)
            <div class="pt-3 text-xs text-slate-400 border-t border-slate-100 flex items-center gap-2">
                <i class="ri-information-line text-accent text-sm"></i>
                <span>Total {{ $totalBlocks }} blok isi di materi ini. Gunakan editor untuk mengatur & menggeser urutan blok secara bebas.</span>
            </div>
        @endif
    </div>
@endsection
