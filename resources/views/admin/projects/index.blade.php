@extends('admin.layouts.app')

@section('title', 'Kelola Project')
@section('page_title', 'Kelola Project')

@section('content')
    <x-admin.page-title
        title="Kelola Project"
        subtitle="Daftar project yang tampil di landing page"
        actionLabel="Tambah Project"
        actionRoute="admin.projects.create" />

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-400 border-b border-slate-100">
                        <th class="px-4 py-3.5 w-12">No</th>
                        <th class="px-4 py-3.5">Project</th>
                        <th class="px-4 py-3.5 hidden md:table-cell">Deskripsi</th>
                        <th class="px-4 py-3.5 w-20">Urutan</th>
                        <th class="px-4 py-3.5 text-right w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($projects as $i => $project)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-4 py-3 text-slate-500">{{ $i + 1 }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <img src="{{ img_url($project->gambar) }}" alt="{{ $project->nama }}"
                                         class="w-12 h-9 rounded-lg object-cover bg-slate-50 flex-shrink-0">
                                    <span class="font-semibold text-slate-800">{{ $project->nama }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 hidden md:table-cell text-slate-500 max-w-md">
                                <span class="line-clamp-1">{{ $project->desk }}</span>
                            </td>
                            <td class="px-4 py-3 text-slate-500">{{ $project->sort_order }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.projects.edit', $project) }}"
                                       class="p-2 rounded-lg text-slate-500 hover:text-accent hover:bg-accent/10 transition-colors" title="Edit">
                                        <i class="ri-pencil-line"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.projects.destroy', $project) }}"
                                          onsubmit="return confirm('Yakin ingin menghapus project {{ $project->nama }}?')">
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
                                Belum ada project. Klik "Tambah Project" untuk menambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
