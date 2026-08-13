@extends('admin.layouts.app')

@section('title', 'Tools')
@section('page_title', 'Tools')

@section('content')
    <x-admin.page-title
        title="Tools"
        subtitle="Daftar tools / skill yang tampil di landing page"
        actionLabel="Tambah Tool"
        actionRoute="admin.tools.create" />

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-400 border-b border-slate-100">
                        <th class="px-4 py-3.5 w-12">No</th>
                        <th class="px-4 py-3.5">Tool</th>
                        <th class="px-4 py-3.5">Kategori</th>
                        <th class="px-4 py-3.5 w-14"><span class="sr-only">Urutkan</span></th>
                        <th class="px-4 py-3.5 text-right w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100" x-data="reorderTable('{{ route('admin.tools.reorder') }}')">
                    @forelse ($tools as $i => $tool)
                        <tr data-id="{{ $tool->id }}" class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-4 py-3 text-slate-500" data-order>{{ $i + 1 }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center flex-shrink-0">
                                        <img src="{{ img_url($tool->gambar) }}" alt="{{ $tool->nama }}" class="w-6 h-6 object-contain">
                                    </div>
                                    <span class="font-semibold text-slate-800">{{ $tool->nama }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-slate-500">{{ $tool->ket ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <span draggable="true"
                                      class="inline-flex w-8 h-8 items-center justify-center rounded-lg text-slate-300 hover:text-slate-500 hover:bg-slate-100 cursor-grab active:cursor-grabbing transition-colors"
                                      title="Geser untuk mengurutkan">
                                    <i class="ri-drag-move-2-line"></i>
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.tools.edit', $tool) }}"
                                       class="p-2 rounded-lg text-slate-500 hover:text-accent hover:bg-accent/10 transition-colors" title="Edit">
                                        <i class="ri-pencil-line"></i>
                                    </a>
                                    <x-admin.delete-modal
                                        :action="route('admin.tools.destroy', $tool)"
                                        item-name="{{ $tool->nama }}"
                                        item-type="tool" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center text-slate-400">
                                <i class="ri-inbox-line text-3xl block mb-2"></i>
                                Belum ada tool. Klik "Tambah Tool" untuk menambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
