@extends('admin.layouts.app')

@section('title', 'Pengalaman')
@section('page_title', 'Pengalaman')

@section('content')
    <x-admin.page-title
        title="Pengalaman"
        subtitle="Daftar pengalaman / riwayat yang tampil di landing page"
        actionLabel="Tambah Pengalaman"
        actionRoute="admin.experiences.create" />

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-400 border-b border-slate-100">
                        <th class="px-4 py-3.5 w-12">No</th>
                        <th class="px-4 py-3.5">Posisi</th>
                        <th class="px-4 py-3.5 hidden md:table-cell">Perusahaan</th>
                        <th class="px-4 py-3.5 hidden sm:table-cell">Periode</th>
                        <th class="px-4 py-3.5 w-20">Urutan</th>
                        <th class="px-4 py-3.5 text-right w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($experiences as $i => $exp)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-4 py-3 text-slate-500">{{ $i + 1 }}</td>
                            <td class="px-4 py-3">
                                <span class="font-semibold text-slate-800">{{ $exp->role }}</span>
                            </td>
                            <td class="px-4 py-3 hidden md:table-cell text-slate-500">{{ $exp->company }}</td>
                            <td class="px-4 py-3 hidden sm:table-cell text-slate-500">{{ $exp->duration ?? '-' }}</td>
                            <td class="px-4 py-3 text-slate-500">{{ $exp->sort_order }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.experiences.edit', $exp) }}"
                                       class="p-2 rounded-lg text-slate-500 hover:text-accent hover:bg-accent/10 transition-colors" title="Edit">
                                        <i class="ri-pencil-line"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.experiences.destroy', $exp) }}"
                                          onsubmit="return confirm('Yakin ingin menghapus pengalaman {{ $exp->role }}?')">
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
                            <td colspan="6" class="px-4 py-12 text-center text-slate-400">
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
