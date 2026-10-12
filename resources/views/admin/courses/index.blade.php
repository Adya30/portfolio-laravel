@extends('admin.layouts.app')

@section('title', 'Kelola Materi')
@section('page_title', 'Kelola Materi')

@section('content')
    <div>
        {{-- Toolbar: what this page manages on the left, the single primary
             action on the right. The page title itself lives in the app header. --}}
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <p class="text-sm text-slate-500 dark:text-slate-400">
                @if ($courses->isEmpty())
                    Belum ada materi yang terdaftar.
                @else
                    <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $courses->count() }}</span> materi
                    <span class="mx-1.5 text-slate-300 dark:text-slate-600">·</span>
                    <span class="inline-flex items-center gap-1">
                        geser <i class="ri-drag-move-2-line text-slate-400"></i> untuk mengubah urutan tampil
                    </span>
                @endif
            </p>

            <a href="{{ route('admin.courses.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-orange-500 text-white text-sm font-semibold hover:bg-orange-600 hover:-translate-y-0.5 transition-all shadow-sm">
                <i class="ri-add-line"></i>Tambah Materi
            </a>
        </div>

        @if ($courses->isEmpty())
            <div class="bg-white dark:bg-[#162032] rounded-2xl border border-slate-200 dark:border-white/10 p-12 text-center text-slate-400 shadow-sm">
                <i class="ri-book-open-line text-4xl block mb-3 text-slate-300 dark:text-slate-600"></i>
                <p class="font-semibold text-slate-600 dark:text-slate-200">Belum ada materi pembelajaran.</p>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 mb-4">Mulai dengan membuat materi pertama, lalu tambahkan subbab dan isinya.</p>
                <a href="{{ route('admin.courses.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-orange-500 text-white text-xs font-semibold hover:bg-orange-600 transition-all">
                    <i class="ri-add-line"></i>Tambah Materi
                </a>
            </div>
        @else
            <div class="bg-white dark:bg-[#162032] rounded-2xl border border-slate-200 dark:border-white/10 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-400 bg-slate-50/80 dark:bg-[#131c2e]">
                                <th class="px-4 py-3.5 w-12 text-center border-b-2 border-slate-200 dark:border-white/10">No</th>
                                <th class="px-4 py-3.5 border-b-2 border-slate-200 dark:border-white/10">Materi</th>
                                <th class="px-4 py-3.5 hidden md:table-cell border-b-2 border-slate-200 dark:border-white/10">Deskripsi</th>
                                <th class="px-4 py-3.5 w-14 text-center border-b-2 border-slate-200 dark:border-white/10"><span class="sr-only">Urutkan</span></th>
                                <th class="px-4 py-3.5 text-right w-52 border-b-2 border-slate-200 dark:border-white/10">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200/60 dark:divide-white/5" x-data="reorderTable('{{ route('admin.courses.reorder') }}')">
                            @foreach ($courses as $i => $course)
                                <tr data-id="{{ $course->id }}" class="hover:bg-slate-50/70 dark:hover:bg-white/5 transition-colors border-b border-slate-100 dark:border-white/5">
                                    <td class="px-4 py-3.5 text-center font-bold text-slate-400 dark:text-slate-400 text-xs border-r border-slate-100/80 dark:border-white/5" data-order>{{ $i + 1 }}</td>
                                    <td class="px-4 py-3.5 border-r border-slate-100/80 dark:border-white/5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-white/10 flex items-center justify-center overflow-hidden shrink-0 shadow-2xs">
                                                @if ($course->gambar)
                                                    <img src="{{ img_url($course->gambar) }}" alt="{{ $course->nama }}" class="w-full h-full object-cover" loading="lazy">
                                                @else
                                                    <i class="ri-book-open-line text-orange-500 text-lg"></i>
                                                @endif
                                            </div>
                                            <div class="min-w-0">
                                                <a href="{{ route('admin.courses.show', $course) }}"
                                                   class="font-poppins font-bold text-slate-800 dark:text-white hover:text-orange-500 dark:hover:text-orange-400 transition-colors block leading-snug"
                                                   title="Kelola subbab & isi materi">{{ $course->nama }}</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5 hidden md:table-cell text-slate-500 dark:text-slate-400 max-w-xs truncate text-xs border-r border-slate-100/80 dark:border-white/5">{{ $course->desk ?? '-' }}</td>
                                    <td class="px-4 py-3.5 text-center border-r border-slate-100/80 dark:border-white/5">
                                        <span draggable="true"
                                              class="inline-flex w-8 h-8 items-center justify-center rounded-lg text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-white/10 cursor-grab active:cursor-grabbing transition-colors"
                                              title="Tahan & geser baris ini untuk mengurutkan posisi">
                                            <i class="ri-drag-move-2-line text-base"></i>
                                        </span>
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a href="{{ route('admin.courses.show', $course) }}"
                                               title="Kelola subbab & isi materi"
                                               aria-label="Kelola subbab materi {{ $course->nama }}"
                                               class="inline-flex items-center gap-1.5 px-2.5 py-2 rounded-lg border border-slate-200 dark:border-white/10 text-slate-600 dark:text-slate-200 text-xs font-semibold hover:border-orange-500/40 hover:text-orange-500 dark:hover:text-orange-400 hover:bg-orange-500/5 dark:hover:bg-white/5 transition-colors">
                                                <i class="ri-bookmark-line text-base"></i>
                                                <span class="hidden xl:inline">Subbab</span>
                                            </a>
                                            <a href="{{ route('admin.courses.edit', $course) }}"
                                               title="Edit nama, deskripsi & gambar sampul"
                                               aria-label="Edit informasi materi {{ $course->nama }}"
                                               class="inline-flex items-center gap-1.5 px-2.5 py-2 rounded-lg border border-slate-200 dark:border-white/10 text-slate-600 dark:text-slate-200 text-xs font-semibold hover:border-orange-500/40 hover:text-orange-500 dark:hover:text-orange-400 hover:bg-orange-500/5 dark:hover:bg-white/5 transition-colors">
                                                <i class="ri-pencil-line text-base"></i>
                                                <span class="hidden xl:inline">Info</span>
                                            </a>
                                            <x-admin.delete-modal
                                                :action="route('admin.courses.destroy', $course)"
                                                item-name="{{ $course->nama }}"
                                                item-type="materi" />
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection
