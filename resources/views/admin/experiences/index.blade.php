@extends('admin.layouts.app')

@section('title', 'Pengalaman')
@section('page_title', 'Pengalaman')

@section('content')
    <x-admin.page-title actionLabel="Tambah Pengalaman" actionRoute="admin.experiences.create" />

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-400 border-b border-slate-100">
                        <th class="px-4 py-3.5 w-12">No</th>
                        <th class="px-4 py-3.5">Posisi</th>
                        <th class="px-4 py-3.5 hidden md:table-cell">Perusahaan</th>
                        <th class="px-4 py-3.5 hidden sm:table-cell">Periode</th>
                        <th class="px-4 py-3.5 w-16">Logo</th>
                        <th class="px-4 py-3.5 w-14"><span class="sr-only">Urutkan</span></th>
                        <th class="px-4 py-3.5 text-right w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100" x-data="reorderTable('{{ route('admin.experiences.reorder') }}')">
                    @forelse ($experiences as $i => $exp)
                        <tr data-id="{{ $exp->id }}" class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-4 py-3 text-slate-500" data-order>{{ $i + 1 }}</td>
                            <td class="px-4 py-3">
                                <span class="font-semibold text-slate-800">{{ $exp->role }}</span>
                            </td>
                            <td class="px-4 py-3 hidden md:table-cell text-slate-500">{{ $exp->company }}</td>
                            <td class="px-4 py-3 hidden sm:table-cell text-slate-500">{{ $exp->duration ?? '-' }}</td>
                            <td class="px-4 py-3">
                                @if ($exp->gambar)
                                    <img src="{{ img_url($exp->gambar) }}" alt="{{ $exp->company }}"
                                         class="w-9 h-9 rounded-lg object-cover border border-slate-200 bg-slate-100">
                                @else
                                    <span class="inline-flex w-9 h-9 rounded-lg bg-slate-100 items-center justify-center text-xs font-bold text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span draggable="true"
                                      class="inline-flex w-8 h-8 items-center justify-center rounded-lg text-slate-300 hover:text-slate-500 hover:bg-slate-100 cursor-grab active:cursor-grabbing transition-colors"
                                      title="Geser untuk mengurutkan">
                                    <i class="ri-drag-move-2-line"></i>
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.experiences.edit', $exp) }}"
                                       class="p-2 rounded-lg text-slate-500 hover:text-accent hover:bg-accent/10 transition-colors" title="Edit">
                                        <i class="ri-pencil-line"></i>
                                    </a>
                                    <x-admin.delete-modal
                                        :action="route('admin.experiences.destroy', $exp)"
                                        item-name="{{ $exp->role }}"
                                        item-type="pengalaman" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center text-slate-400">
                                <i class="ri-inbox-line text-3xl block mb-2"></i>
                                Belum ada pengalaman. Klik "Tambah Pengalaman" untuk menambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
