@extends('admin.layouts.app')

@section('title', 'Sertifikat')
@section('page_title', 'Sertifikat')

@section('content')
    <x-admin.page-title
        title="Sertifikat"
        subtitle="Daftar sertifikat & penghargaan yang tampil di landing page"
        actionLabel="Tambah Sertifikat"
        actionRoute="admin.certificates.create" />

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-400 border-b border-slate-100">
                        <th class="px-4 py-3.5 w-12">No</th>
                        <th class="px-4 py-3.5">Sertifikat</th>
                        <th class="px-4 py-3.5 hidden md:table-cell">Penerbit</th>
                        <th class="px-4 py-3.5 hidden sm:table-cell">Tanggal</th>
                        <th class="px-4 py-3.5 w-14"><span class="sr-only">Urutkan</span></th>
                        <th class="px-4 py-3.5 text-right w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100" x-data="reorderTable('{{ route('admin.certificates.reorder') }}')">
                    @forelse ($certificates as $i => $cert)
                        <tr data-id="{{ $cert->id }}" class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-4 py-3 text-slate-500" data-order>{{ $i + 1 }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-slate-50 border border-slate-100 flex items-center justify-center overflow-hidden flex-shrink-0">
                                        <img src="{{ img_url($cert->gambar) }}" alt="{{ $cert->nama }}" class="w-full h-full object-cover">
                                    </div>
                                    <span class="font-semibold text-slate-800">{{ $cert->nama }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 hidden md:table-cell text-slate-500">{{ $cert->penerbit ?? '-' }}</td>
                            <td class="px-4 py-3 hidden sm:table-cell text-slate-500">{{ $cert->tanggal ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <span draggable="true"
                                      class="inline-flex w-8 h-8 items-center justify-center rounded-lg text-slate-300 hover:text-slate-500 hover:bg-slate-100 cursor-grab active:cursor-grabbing transition-colors"
                                      title="Geser untuk mengurutkan">
                                    <i class="ri-drag-move-2-line"></i>
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.certificates.edit', $cert) }}"
                                       class="p-2 rounded-lg text-slate-500 hover:text-accent hover:bg-accent/10 transition-colors" title="Edit">
                                        <i class="ri-pencil-line"></i>
                                    </a>
                                    <x-admin.delete-modal
                                        :action="route('admin.certificates.destroy', $cert)"
                                        item-name="{{ $cert->nama }}"
                                        item-type="sertifikat" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-slate-400">
                                <i class="ri-inbox-line text-3xl block mb-2"></i>
                                Belum ada sertifikat. Klik "Tambah Sertifikat" untuk menambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
