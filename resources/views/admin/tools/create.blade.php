@extends('admin.layouts.app')

@section('title', 'Tambah Tool')
@section('page_title', 'Tambah Tool')

@section('content')
    <x-admin.page-title title="Tambah Tool" subtitle="Isi data tool baru" />

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 max-w-2xl">
        <form method="POST" action="{{ route('admin.tools.store') }}" enctype="multipart/form-data" class="grid sm:grid-cols-2 gap-5">
            @csrf

            <div class="sm:col-span-2">
                <x-admin.field name="nama" label="Nama Tool" required autofocus placeholder="Contoh: Laravel" />
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="ket" label="Kategori" placeholder="Contoh: Framework, Language, Database"
                               help="Keterangan singkat yang tampil di bawah nama tool." />
            </div>

            <div class="sm:col-span-2">
                <x-admin.image-input name="gambar" label="Ikon Tool" ratio="1" />
            </div>

            <div class="sm:col-span-2 md:col-span-1">
                <x-admin.field name="sort_order" label="Urutan" type="number" value="0"
                               help="Semakin kecil angkanya, semakin awal tampil." />
            </div>

            <div class="sm:col-span-2 flex items-center gap-3 pt-2 border-t border-slate-100">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-accent text-white text-sm font-semibold hover:bg-blue-600 transition-colors">
                    <i class="ri-save-line"></i>Simpan
                </button>
                <a href="{{ route('admin.tools.index') }}"
                   class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
