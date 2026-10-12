@extends('admin.layouts.app')

@section('title', 'Kelola User')
@section('page_title', 'Kelola User')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white dark:bg-[#162032] p-5 rounded-2xl border border-slate-200 dark:border-white/10 shadow-xs">
        <div>
            <h2 class="text-lg font-bold text-slate-800 dark:text-white font-poppins">Daftar Pengguna Panel Admin</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Kelola hak akses akun pengguna untuk peran Administrator dan Pengelola Materi.</p>
        </div>
        <a href="{{ route('admin.users.create') }}"
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-orange-500 text-white text-xs font-bold hover:bg-orange-600 transition-all duration-200 shadow-sm">
            <i class="ri-user-add-line text-sm"></i>
            <span>Tambah User Baru</span>
        </a>
    </div>

    @if (session('error'))
        <div class="flex items-center gap-2 bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-800/40 text-red-700 dark:text-red-300 text-sm font-medium px-4 py-3 rounded-xl">
            <i class="ri-error-warning-line text-lg"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-[#162032] rounded-2xl border border-slate-200 dark:border-white/10 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                <thead class="bg-slate-50/80 dark:bg-[#131c2e] border-b border-slate-200 dark:border-white/10 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">#</th>
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Role / Hak Akses</th>
                        <th class="px-6 py-4">Tanggal Dibuat</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-white/5 font-medium">
                    @forelse ($users as $index => $u)
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-white/5 transition-colors">
                            <td class="px-6 py-4 text-xs font-bold text-slate-400 dark:text-slate-500">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-orange-500/15 text-orange-600 dark:text-orange-400 flex items-center justify-center font-bold text-xs">
                                        {{ strtoupper(substr($u->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-800 dark:text-white">{{ $u->name }}</div>
                                        @if ($u->id === auth()->id())
                                            <span class="inline-block text-[10px] text-orange-500 dark:text-orange-400 font-semibold">(Akun Anda)</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-xs font-mono text-slate-600 dark:text-slate-300">{{ $u->email }}</td>
                            <td class="px-6 py-4">
                                @if ($u->isAdmin())
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-500/15 text-amber-700 dark:text-amber-300 border border-amber-500/30">
                                        <i class="ri-shield-star-line text-xs"></i> Administrator
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-sky-500/15 text-sky-700 dark:text-sky-300 border border-sky-500/30">
                                        <i class="ri-book-open-line text-xs"></i> Akses Materi Hanya
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-400 dark:text-slate-500">
                                {{ $u->created_at ? $u->created_at->format('d M Y H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.users.edit', $u) }}"
                                       class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-500 dark:text-slate-400 hover:text-orange-500 dark:hover:text-orange-400 hover:bg-orange-500/10 dark:hover:bg-white/5 transition-colors"
                                       title="Edit User">
                                        <i class="ri-pencil-line"></i>
                                    </a>
                                    @if ($u->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.users.destroy', $u) }}"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus user {{ $u->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-500/10 transition-colors cursor-pointer"
                                                    title="Hapus User">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400 dark:text-slate-500">
                                <i class="ri-user-unfollow-line text-3xl block mb-2 text-slate-300 dark:text-slate-600"></i>
                                <span>Belum ada pengguna terdaftar.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
