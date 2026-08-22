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
        <div class="p-5 border-b border-slate-100 flex items-center justify-between gap-3 bg-slate-50/50">
            <div>
                <h3 class="font-poppins font-bold text-slate-800 text-base flex items-center gap-2">
                    <i class="ri-bookmark-line text-accent"></i>Daftar Subbab Materi
                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-accent/10 text-accent">{{ count($subbabs) }}</span>
                </h3>
            </div>
            @if (count($subbabs) > 1)
                <p class="text-xs text-slate-400 hidden sm:block">Tahan dan geser icon <i class="ri-drag-move-2-line"></i> untuk mengurutkan posisi subbab.</p>
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
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-400 border-b border-slate-100 bg-slate-50/30">
                            <th class="px-4 py-3.5 w-12 text-center">No</th>
                            <th class="px-4 py-3.5">Subbab</th>
                            <th class="px-4 py-3.5 hidden md:table-cell">Konten Blok</th>
                            <th class="px-4 py-3.5 w-14 text-center"><span class="sr-only">Urutkan</span></th>
                            <th class="px-4 py-3.5 text-right w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100" x-data="reorderTable('{{ route('admin.courses.subbab.reorder', $course) }}')">
                        @foreach ($subbabs as $i => $subbab)
                            <tr data-id="{{ $subbab['block_index'] }}" class="hover:bg-slate-50/70 transition-colors">
                                <td class="px-4 py-3.5 text-center font-bold text-slate-400 text-xs" data-order>{{ $i + 1 }}</td>
                                <td class="px-4 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <span class="w-8 h-8 rounded-xl bg-accent/10 text-accent font-bold text-xs flex items-center justify-center shrink-0" data-order>
                                            {{ $i + 1 }}
                                        </span>
                                        <a href="{{ route('admin.courses.subbab.edit', [$course, $subbab['block_index']]) }}"
                                           class="font-poppins font-bold text-slate-800 hover:text-accent transition-colors block leading-snug">
                                            {{ $subbab['judul'] ?: 'Subbab '.($i + 1) }}
                                        </a>
                                    </div>
                                </td>
                                <td class="px-4 py-3.5 hidden md:table-cell">
                                    <div class="flex flex-wrap items-center gap-1.5 text-xs text-slate-500">
                                        @php $stats = $subbab['stats'] ?? []; @endphp
                                        @if (($stats['paragraf'] ?? 0) > 0)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 font-medium">
                                                <i class="ri-paragraph text-slate-400"></i>{{ $stats['paragraf'] }} Paragraf
                                            </span>
                                        @endif
                                        @if (($stats['subheading'] ?? 0) > 0)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 font-medium">
                                                <i class="ri-h-2 text-slate-400"></i>{{ $stats['subheading'] }} Sub Heading
                                            </span>
                                        @endif
                                        @if (($stats['gambar'] ?? 0) > 0)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 font-medium">
                                                <i class="ri-image-line text-slate-400"></i>{{ $stats['gambar'] }} Gambar
                                            </span>
                                        @endif
                                        @if (($stats['kode'] ?? 0) > 0)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 font-medium">
                                                <i class="ri-code-box-line text-slate-400"></i>{{ $stats['kode'] }} Kode
                                            </span>
                                        @endif
                                        @if (empty(array_filter($stats)))
                                            <span class="text-slate-400 italic text-xs">Belum ada blok isi</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3.5 text-center">
                                    <span draggable="true"
                                          class="inline-flex w-8 h-8 items-center justify-center rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 cursor-grab active:cursor-grabbing transition-colors"
                                          title="Tahan & geser baris ini untuk mengurutkan posisi subbab">
                                        <i class="ri-drag-move-2-line text-base"></i>
                                    </span>
                                </td>
                                <td class="px-4 py-3.5">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('admin.courses.subbab.edit', [$course, $subbab['block_index']]) }}"
                                           class="p-2 rounded-lg text-slate-500 hover:text-accent hover:bg-accent/10 transition-colors" title="Edit Subbab">
                                            <i class="ri-pencil-line text-base"></i>
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

        @if (count($subbabs) && $totalBlocks > 0)
            <div class="p-4 text-xs text-slate-400 border-t border-slate-100 flex items-center gap-2">
                <i class="ri-information-line text-accent text-sm"></i>
                <span>Total {{ $totalBlocks }} blok isi di materi ini. Tahan &amp; geser ikon <i class="ri-drag-move-2-line"></i> untuk mengubah urutan posisi subbab secara langsung.</span>
            </div>
        @endif
    </div>
@endsection
