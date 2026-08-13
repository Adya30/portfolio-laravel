@extends('admin.layouts.app')

@section('title', 'Edit Project')
@section('page_title', 'Edit Project')

@section('content')
    <x-admin.page-title title="Edit Project" subtitle="Perbarui data project" />

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 max-w-4xl">
        <form method="POST" action="{{ route('admin.projects.update', $project) }}" enctype="multipart/form-data" class="grid sm:grid-cols-2 gap-5">
            @csrf
            @method('PUT')

            <div class="sm:col-span-2">
                <x-admin.field name="nama" label="Nama Project" :value="$project->nama" required />
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="desk" label="Deskripsi Singkat" type="textarea" rows="2" :value="$project->desk" required
                               help="Deskripsi singkat yang tampil di kartu project." />
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="full_desk" label="Deskripsi Lengkap" type="textarea" rows="4" :value="$project->full_desk"
                               help="Deskripsi detail yang tampil di modal project." />
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="link" label="Link Project" type="url" :value="$project->link"
                               placeholder="https://github.com/..." help="Link GitHub atau demo project." />
            </div>

            <div class="sm:col-span-2">
                <label for="category_id" class="block text-sm font-semibold text-slate-700">Kategori</label>
                <select name="category_id" id="category_id"
                        class="w-full rounded-xl border bg-white px-3.5 py-2.5 text-sm text-slate-800 outline-none transition-all border-slate-200 focus:border-accent focus:ring-4 focus:ring-accent/20 mt-1.5">
                    <option value="">Tanpa Kategori</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(old('category_id', $project->category_id ?? '') == $cat->id)>{{ $cat->nama }}</option>
                    @endforeach
                </select>
                <p class="text-xs text-slate-400 mt-1.5">Kelola kategori di menu "Kategori".</p>
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="tools" label="Teknologi (Tools)" type="textarea" rows="4"
                               :value="implode(PHP_EOL, $project->tools ?? [])"
                               help="Satu teknologi per baris. Contoh: Laravel, PHP, MySQL." />
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="fitur" label="Fitur Utama" type="textarea" rows="4"
                               :value="implode(PHP_EOL, $project->fitur ?? [])"
                               help="Satu fitur per baris." />
            </div>

            <div class="sm:col-span-2">
                <x-admin.image-input name="gambar" label="Gambar Project" :current="$project->gambar" />
            </div>

            <div class="sm:col-span-2 flex items-center gap-3 pt-2 border-t border-slate-100">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-accent text-white text-sm font-semibold hover:bg-blue-600 transition-colors">
                    <i class="ri-save-line"></i>Simpan Perubahan
                </button>
                <a href="{{ route('admin.projects.index') }}"
                   class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
