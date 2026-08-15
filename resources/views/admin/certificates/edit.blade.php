@extends('admin.layouts.app')

@section('title', 'Edit Sertifikat')
@section('page_title', 'Edit Sertifikat')

@section('content')
    <x-admin.page-title title="Edit Sertifikat" subtitle="Perbarui data sertifikat" />

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 max-w-4xl">
        <form method="POST" action="{{ route('admin.certificates.update', $certificate) }}" enctype="multipart/form-data" class="grid sm:grid-cols-2 gap-5">
            @csrf
            @method('PUT')

            <div class="sm:col-span-2">
                <x-admin.field name="nama" label="Nama Sertifikat" :value="$certificate->nama" required />
            </div>

            <div>
                <x-admin.field name="penerbit" label="Penerbit" :value="$certificate->penerbit" />
            </div>

            <div>
                <x-admin.field name="tanggal" label="Tanggal" :value="$certificate->tanggal" />
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="desk" label="Deskripsi (English)" type="textarea" rows="3" :value="$certificate->desk"
                               help="Deskripsi detail yang tampil di modal sertifikat." />
            </div>

            <div class="sm:col-span-2 pt-4 border-t border-dashed border-slate-200">
                <p class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400">
                    <i class="ri-translate-2 text-accent"></i>Versi Bahasa Indonesia (opsional)
                </p>
                <p class="text-xs text-slate-400 mt-1">Kosongkan jika belum tersedia — pengunjung akan melihat versi Inggris.</p>
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="nama_idn" label="Nama Sertifikat (Indonesia)" :value="$certificate->nama_idn"
                               placeholder="Contoh: Sertifikasi Junior Web Developer" />
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="desk_idn" label="Deskripsi (Indonesia)" type="textarea" rows="3" :value="$certificate->desk_idn"
                               placeholder="Deskripsi dalam bahasa Indonesia" />
            </div>

            <div>
                <x-admin.field name="icon" label="Ikon (Remix Icon)" :value="$certificate->icon"
                               placeholder="Contoh: ri-award-line" help="Kelas ikon remixicon." />
            </div>

            <div class="sm:col-span-2">
                <x-admin.image-input name="gambar" label="Gambar Sertifikat" :current="$certificate->gambar" />
            </div>

            <div class="sm:col-span-2 flex items-center gap-3 pt-2 border-t border-slate-100">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-accent text-white text-sm font-semibold hover:bg-blue-600 transition-colors">
                    <i class="ri-save-line"></i>Simpan Perubahan
                </button>
                <a href="{{ route('admin.certificates.index') }}"
                   class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
