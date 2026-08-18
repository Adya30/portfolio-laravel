@extends('admin.layouts.app')

@section('title', 'Tambah Materi')
@section('page_title', 'Tambah Materi')

@section('content')
    <x-admin.page-title/>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 max-w-4xl">
        <form method="POST" action="{{ route('admin.courses.store') }}" enctype="multipart/form-data" class="grid sm:grid-cols-2 gap-5">
            @csrf

            <div class="sm:col-span-2">
                <x-admin.field name="nama" label="Nama Materi" required autofocus placeholder="Contoh: Pengenalan Laravel" />
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="desk" label="Deskripsi Singkat" type="textarea" rows="3"
                               help="Ringkasan yang tampil di panel materi pada halaman course." />
            </div>

            <div class="sm:col-span-2 pt-4 border-t border-dashed border-slate-200">
                <p class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400">
                    <i class="ri-stack-line text-accent"></i>Isi Materi (Blok Subbab)
                </p>
                <p class="text-xs text-slate-400 mt-1">Susun materi menjadi subbab. Setiap blok mendukung teks, gambar (webp), dan kode.</p>
            </div>

            <div class="sm:col-span-2">
                @include('admin.courses._blocks-editor')
            </div>

            <div class="sm:col-span-2">
                <x-admin.image-input name="gambar" label="Gambar Materi" />
            </div>

            <div class="sm:col-span-2 flex items-center gap-3 pt-2 border-t border-slate-100">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-accent text-white text-sm font-semibold hover:bg-blue-600 transition-colors">
                    <i class="ri-save-line"></i>Simpan
                </button>
                <a href="{{ route('admin.courses.index') }}"
                   class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
