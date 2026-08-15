@extends('admin.layouts.app')

@section('title', 'Tambah Project')
@section('page_title', 'Tambah Project')

@section('content')
    <x-admin.page-title title="Tambah Project" subtitle="Isi data project baru" />

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 max-w-4xl">
        <form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data" class="grid sm:grid-cols-2 gap-5">
            @csrf

            <div class="sm:col-span-2">
                <x-admin.field name="nama" label="Nama Project" required autofocus />
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="desk" label="Deskripsi Singkat (English)" type="textarea" rows="2" required
                               help="Deskripsi singkat yang tampil di kartu project." />
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="full_desk" label="Deskripsi Lengkap (English)" type="textarea" rows="4"
                               help="Deskripsi detail yang tampil di modal project." />
            </div>

            <div class="sm:col-span-2 pt-4 border-t border-dashed border-slate-200">
                <p class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400">
                    <i class="ri-translate-2 text-accent"></i>Versi Bahasa Indonesia (opsional)
                </p>
                <p class="text-xs text-slate-400 mt-1">Kosongkan jika belum tersedia — pengunjung akan melihat versi Inggris.</p>
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="desk_idn" label="Deskripsi Singkat (Indonesia)" type="textarea" rows="2"
                               placeholder="Deskripsi singkat dalam bahasa Indonesia" />
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="full_desk_idn" label="Deskripsi Lengkap (Indonesia)" type="textarea" rows="4"
                               placeholder="Deskripsi detail dalam bahasa Indonesia" />
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="link" label="Link GitHub" type="url" placeholder="https://github.com/..."
                               help="Link repository GitHub project (opsional)." />
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="link_live" label="Link Live / Demo" type="url" placeholder="https://contoh.com"
                               help="Link website live / demo project (opsional)." />
            </div>

            <div class="sm:col-span-2">
                <label for="category_id" class="block text-sm font-semibold text-slate-700">Kategori</label>
                <select name="category_id" id="category_id"
                        class="w-full rounded-xl border bg-white px-3.5 py-2.5 text-sm text-slate-800 outline-none transition-all border-slate-200 focus:border-accent focus:ring-4 focus:ring-accent/20 mt-1.5">
                    <option value="">Tanpa Kategori</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(old('category_id', '') == $cat->id)>{{ $cat->nama }}</option>
                    @endforeach
                </select>
                <p class="text-xs text-slate-400 mt-1.5">Kelola kategori di menu "Kategori".</p>
            </div>

            <div class="sm:col-span-2">
                <x-admin.tools-picker :tools="$tools" :selected="old('tools', [])" />
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="fitur" label="Fitur Utama (English)" type="textarea" rows="4"
                               help="Satu fitur per baris." />
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="fitur_idn" label="Fitur Utama (Indonesia)" type="textarea" rows="4"
                               help="Satu fitur per baris. Kosongkan untuk memakai versi Inggris." />
            </div>

            <div class="sm:col-span-2">
                <x-admin.image-input name="gambar" label="Gambar Project" />
            </div>

            <div class="sm:col-span-2 flex items-center gap-3 pt-2 border-t border-slate-100">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-accent text-white text-sm font-semibold hover:bg-blue-600 transition-colors">
                    <i class="ri-save-line"></i>Simpan
                </button>
                <a href="{{ route('admin.projects.index') }}"
                   class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
