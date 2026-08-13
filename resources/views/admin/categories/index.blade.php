@extends('admin.layouts.app')

@section('title', 'Kategori')
@section('page_title', 'Kategori')

@section('content')
    <x-admin.page-title
        title="Kategori"
        subtitle="Kategori untuk mengelompokkan project di landing page"
        actionLabel="Tambah Kategori"
        actionRoute="admin.categories.create" />

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-400 border-b border-slate-100">
                        <th class="px-4 py-3.5 w-12">No</th>
                        <th class="px-4 py-3.5">Nama Kategori</th>
                        <th class="px-4 py-3.5 w-24">Jumlah Project</th>
                        <th class="px-4 py-3.5 text-right w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($categories as $i => $category)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-4 py-3 text-slate-500">{{ $i + 1 }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <span class="w-9 h-9 rounded-lg bg-accent/10 text-accent flex items-center justify-center flex-shrink-0">
                                        <i class="ri-price-tag-3-line"></i>
                                    </span>
                                    <span class="font-semibold text-slate-800">{{ $category->nama }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-slate-500">{{ $category->projects_count }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                       class="p-2 rounded-lg text-slate-500 hover:text-accent hover:bg-accent/10 transition-colors" title="Edit">
                                        <i class="ri-pencil-line"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                                          onsubmit="return confirm('Yakin ingin menghapus kategori {{ $category->nama }}? Project di dalamnya akan menjadi tanpa kategori.')">
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
                            <td colspan="4" class="px-4 py-12 text-center text-slate-400">
                                <i class="ri-price-tag-3-line text-3xl block mb-2"></i>
                                Belum ada kategori. Klik "Tambah Kategori" untuk menambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
