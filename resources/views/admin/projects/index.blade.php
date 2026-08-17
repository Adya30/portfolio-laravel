@extends('admin.layouts.app')

@section('title', 'Kelola Project')
@section('page_title', 'Kelola Project')

@section('content')
    <x-admin.page-title actionLabel="Tambah Project" actionRoute="admin.projects.create" />

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-400 border-b border-slate-100">
                        <th class="px-4 py-3.5 w-12">No</th>
                        <th class="px-4 py-3.5">Project</th>
                        <th class="px-4 py-3.5 hidden md:table-cell">Deskripsi</th>
                        <th class="px-4 py-3.5 hidden lg:table-cell">Kategori</th>
                        <th class="px-4 py-3.5 w-14"><span class="sr-only">Urutkan</span></th>
                        <th class="px-4 py-3.5 text-right w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100" x-data="reorderTable('{{ route('admin.projects.reorder') }}')">
                    @forelse ($projects as $i => $project)
                        <tr data-id="{{ $project->id }}" class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-4 py-3 text-slate-500" data-order>{{ $i + 1 }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <img src="{{ img_url($project->gambar) }}" alt="{{ $project->nama }}"
                                         class="w-12 h-9 rounded-lg object-cover bg-slate-50 shrink-0">
                                    <span class="font-semibold text-slate-800">{{ $project->nama }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 hidden md:table-cell text-slate-500 max-w-md">
                                <span class="line-clamp-1">{{ $project->desk }}</span>
                            </td>
                            <td class="px-4 py-3 hidden lg:table-cell">
                                @if ($project->category)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium text-accent dark:text-[#60a5fa] bg-accent/10 border border-accent/15">
                                        <i class="ri-price-tag-3-line"></i>{{ $project->category->nama }}
                                    </span>
                                @else
                                    <span class="text-slate-400">-</span>
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
                                    <a href="{{ route('admin.projects.edit', $project) }}"
                                       class="p-2 rounded-lg text-slate-500 hover:text-accent hover:bg-accent/10 transition-colors" title="Edit">
                                        <i class="ri-pencil-line"></i>
                                    </a>
                                    <x-admin.delete-modal
                                        :action="route('admin.projects.destroy', $project)"
                                        item-name="{{ $project->nama }}"
                                        item-type="project" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-slate-400">
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
