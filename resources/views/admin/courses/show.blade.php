@extends('admin.layouts.app')

@section('title', 'Subbab: '.$course->nama)
@section('page_title', 'Subbab Materi')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4 mb-5">
        <div class="min-w-0">
            <a href="{{ route('admin.courses.index') }}"
               class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-accent transition-colors mb-1">
                <i class="ri-arrow-left-line"></i>Kembali ke Index Materi
            </a>
            <h2 class="font-poppins text-xl sm:text-2xl font-bold text-slate-800 truncate">{{ $course->nama }}</h2>
            @if ($course->desk)
                <p class="text-xs text-slate-400 mt-0.5 line-clamp-1 max-w-lg">{{ $course->desk }}</p>
            @endif
        </div>
        <form method="POST" action="{{ route('admin.courses.subbab.store', $course) }}">
            @csrf
            <input type="hidden" name="updated_at" value="{{ $course->updated_at->timestamp }}">
            <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-accent text-white text-sm font-semibold hover:bg-blue-600 hover:-translate-y-0.5 transition-all shadow-sm">
                <i class="ri-add-line"></i>Tambah Subbab
            </button>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-5 py-3.5 border-b border-slate-200 flex items-center justify-between gap-3 bg-slate-50/80">
            <div>
                <h3 class="font-poppins font-bold text-slate-800 text-sm flex items-center gap-2">
                    <i class="ri-bookmark-line text-accent"></i>Daftar Subbab
                    <span class="text-[11px] font-semibold px-2 py-0.5 rounded-full bg-accent/10 text-accent">{{ count($subbabs) }}</span>
                </h3>
            </div>
            @if (count($subbabs) > 1)
                <p class="text-[11px] text-slate-400 hidden sm:block">Tahan & geser <i class="ri-drag-move-2-line"></i> untuk mengurutkan.</p>
            @endif
        </div>

        @if (empty($subbabs))
            <div class="py-14 text-center text-slate-400">
                <i class="ri-bookmark-line text-4xl block mb-3 text-slate-300"></i>
                <p class="text-sm font-semibold text-slate-600">Belum ada subbab pada materi ini.</p>
                <p class="text-xs text-slate-400 mt-1">Klik tombol <strong>"Tambah Subbab"</strong> untuk membuat subbab baru.</p>
                <form method="POST" action="{{ route('admin.courses.subbab.store', $course) }}">
                    @csrf
                    <input type="hidden" name="updated_at" value="{{ $course->updated_at->timestamp }}">
                    <button type="submit"
                            class="inline-flex items-center gap-2 mt-4 px-4 py-2.5 rounded-xl bg-accent text-white text-sm font-semibold hover:bg-blue-600 transition-colors">
                        <i class="ri-add-line"></i>Tambah Subbab
                    </button>
                </form>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm border-collapse">
                    <thead>
                        <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-400 bg-slate-50/80">
                            <th class="px-4 py-3 w-12 text-center border-b-2 border-slate-200">No</th>
                            <th class="px-4 py-3 border-b-2 border-slate-200">Subbab</th>
                            <th class="px-4 py-3 w-14 text-center border-b-2 border-slate-200"><span class="sr-only">Urutkan</span></th>
                            <th class="px-4 py-3 text-right w-44 border-b-2 border-slate-200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200/60" x-data="reorderTable('{{ route('admin.courses.subbab.reorder', $course) }}')">
                        @foreach ($subbabs as $i => $subbab)
                            <tr data-id="{{ $subbab['block_index'] }}" class="hover:bg-slate-50/70 transition-colors border-b border-slate-100">
                                <td class="px-4 py-3 text-center font-bold text-slate-400 text-xs border-r border-slate-100/80" data-order>{{ $i + 1 }}</td>
                                <td class="px-4 py-3 border-r border-slate-100/80">
                                    <div class="flex items-center gap-3">
                                        <span class="w-8 h-8 rounded-xl bg-accent/10 text-accent font-bold text-xs flex items-center justify-center shrink-0 border border-accent/20" data-order>
                                            {{ $i + 1 }}
                                        </span>
                                        <a href="{{ route('admin.courses.subbab.edit', [$course, $subbab['block_index']]) }}"
                                           class="font-poppins font-bold text-slate-800 hover:text-accent transition-colors block leading-snug text-sm">
                                            {{ $subbab['judul'] ?: 'Subbab '.($i + 1) }}
                                        </a>
                                    </div>
                                </td>

                                <td class="px-4 py-3 text-center border-r border-slate-100/80">
                                    <span draggable="true"
                                          class="inline-flex w-8 h-8 items-center justify-center rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 cursor-grab active:cursor-grabbing transition-colors"
                                          title="Tahan & geser untuk mengurutkan">
                                        <i class="ri-drag-move-2-line text-base"></i>
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('admin.courses.subbab.edit', [$course, $subbab['block_index']]) }}"
                                           title="Edit judul & isi subbab ini"
                                           aria-label="Info subbab {{ $subbab['judul'] ?: 'Subbab '.($i + 1) }}"
                                           class="focus-ring inline-flex items-center gap-1.5 px-2.5 py-2 rounded-lg border border-slate-200 text-slate-600 text-xs font-semibold hover:border-accent/40 hover:text-accent hover:bg-accent/5 transition-colors">
                                            <i class="ri-pencil-line text-base"></i>
                                            <span class="hidden xl:inline">Info</span>
                                        </a>
                                        <x-admin.delete-modal
                                            :action="route('admin.courses.subbab.destroy', [$course, $subbab['block_index']])"
                                            item-name="{{ $subbab['judul'] ?: 'Subbab '.($i + 1) }}"
                                            item-type="subbab" />
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>
@endsection
