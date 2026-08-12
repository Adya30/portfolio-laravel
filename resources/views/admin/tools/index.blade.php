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
                        <th class="px-4 py-3.5 w-20">Urutan</th>
                        <th class="px-4 py-3.5 text-right w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($tools as $i => $tool)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-4 py-3 text-slate-500">{{ $i + 1 }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center flex-shrink-0">
                                        <img src="{{ img_url($tool->gambar) }}" alt="{{ $tool->nama }}" class="w-6 h-6 object-contain">
                                    </div>
                                    <span class="font-semibold text-slate-800">{{ $tool->nama }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-slate-500">{{ $tool->ket ?? '-' }}</td>
                            <td class="px-4 py-3 text-slate-500">{{ $tool->sort_order }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.tools.edit', $tool) }}"
                                       class="p-2 rounded-lg text-slate-500 hover:text-accent hover:bg-accent/10 transition-colors" title="Edit">
                                        <i class="ri-pencil-line"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.tools.destroy', $tool) }}"
                                          onsubmit="return confirm('Yakin ingin menghapus tool {{ $tool->nama }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="p-2 rounded-lg text-slate-500 hover:text-red-500 hover:bg-red-50 transition-colors" title="Hapus">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </form>
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
