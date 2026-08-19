@extends('admin.layouts.app')

@section('title', 'Tambah User Baru')
@section('page_title', 'Tambah User Baru')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.users.index') }}"
           class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-accent transition-colors">
            <i class="ri-arrow-left-line"></i> Kembali ke Daftar User
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <h2 class="text-lg font-bold text-slate-800 font-poppins mb-6 pb-4 border-b border-slate-100">
            Form Tambah Pengguna Baru
        </h2>

        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Ahmad Subagja" required
                       class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 outline-none focus:border-accent focus:bg-white focus:ring-4 focus:ring-accent/15 transition-all @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-xs text-red-500 mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Contoh: user@domain.com" required
                       class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 outline-none focus:border-accent focus:bg-white focus:ring-4 focus:ring-accent/15 transition-all @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-xs text-red-500 mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Password</label>
                <input type="password" name="password" placeholder="Minimal 6 karakter" required
                       class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 outline-none focus:border-accent focus:bg-white focus:ring-4 focus:ring-accent/15 transition-all @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="text-xs text-red-500 mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Role / Hak Akses</label>
                <select name="role" required
                        class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 outline-none focus:border-accent focus:bg-white focus:ring-4 focus:ring-accent/15 transition-all @error('role') border-red-500 @enderror">
                    <option value="materi" {{ old('role') === 'materi' ? 'selected' : '' }}>Akses Materi (Hanya Mengakses & Mengedit Materi Course)</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrator (Akses Penuh Seluruh Menu)</option>
                </select>
                @error('role')
                    <p class="text-xs text-red-500 mt-1.5 font-medium">{{ $message }}</p>
                @enderror
                <p class="text-[11px] text-slate-400 mt-2">
                    <i class="ri-information-line"></i> User dengan role <b>Akses Materi</b> hanya akan melihat dan mengelola menu Materi saat login.
                </p>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('admin.users.index') }}"
                   class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-xs font-bold hover:bg-slate-100 transition-colors">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 rounded-xl bg-accent text-white text-xs font-bold hover:bg-blue-600 transition-all shadow-sm">
                    Simpan User Baru
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
