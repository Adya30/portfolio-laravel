@extends('admin.layouts.app')

@section('title', 'Tambah Sertifikat')
@section('page_title', 'Tambah Sertifikat')

@section('content')
    <x-admin.page-title title="Tambah Sertifikat" subtitle="Isi data sertifikat baru" />

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 max-w-4xl">
        <form method="POST" action="{{ route('admin.certificates.store') }}" enctype="multipart/form-data" class="grid sm:grid-cols-2 gap-5">
            @csrf

            <div class="sm:col-span-2">
                <x-admin.field name="nama" label="Nama Sertifikat" required autofocus placeholder="Contoh: Junior Web Developer Certification" />
            </div>

            <div>
                <x-admin.field name="penerbit" label="Penerbit" placeholder="Contoh: Dicoding, HackerRank" />
            </div>

            <div>
                <x-admin.field name="tanggal" label="Tanggal" placeholder="Contoh: December 24, 2025" />
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="link" label="Link Platform" type="url" placeholder="https://..."
                               help="Link menuju halaman/platform sertifikat, mis. halaman kursus Dicoding atau badge HackerRank (opsional)." />
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="desk" label="Deskripsi (English)" type="textarea" rows="3"
                               help="Deskripsi detail yang tampil di modal sertifikat." />
            </div>

            <div class="sm:col-span-2 pt-4 border-t border-dashed border-slate-200">
                <p class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400">
                    <i class="ri-translate-2 text-accent"></i>Versi Bahasa Indonesia (opsional)
                </p>
                <p class="text-xs text-slate-400 mt-1">Kosongkan jika belum tersedia — pengunjung akan melihat versi Inggris.</p>
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="nama_idn" label="Nama Sertifikat (Indonesia)" placeholder="Contoh: Sertifikasi Junior Web Developer" />
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="desk_idn" label="Deskripsi (Indonesia)" type="textarea" rows="3"
                               placeholder="Deskripsi dalam bahasa Indonesia" />
            </div>

            <div class="sm:col-span-2">
                <x-admin.image-input name="gambar" label="Gambar Sertifikat" />
            </div>

            <div class="sm:col-span-2 flex items-center gap-3 pt-2 border-t border-slate-100">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-accent text-white text-sm font-semibold hover:bg-blue-600 transition-colors">
                    <i class="ri-save-line"></i>Simpan
                </button>
                <a href="{{ route('admin.certificates.index') }}"
                   class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
