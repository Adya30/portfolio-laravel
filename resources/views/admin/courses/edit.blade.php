@extends('admin.layouts.app')

@section('title', 'Edit Materi')
@section('page_title', 'Edit Materi')

@section('content')
    <x-admin.page-title/>

    <form method="POST" action="{{ route('admin.courses.update', $course) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="max-w-4xl space-y-6">
            {{-- Main Info Card --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-poppins font-bold text-slate-800 text-sm flex items-center gap-2">
                        <i class="ri-file-text-line text-accent"></i>Informasi Utama Materi
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5">Edit data dasar materi yang ditampilkan di halaman course.</p>
                </div>

                <div class="p-6 space-y-5">
                    <div class="grid sm:grid-cols-2 gap-5">
                        <div class="sm:col-span-2">
                            <x-admin.field name="nama" label="Nama Materi" :value="$course->nama" required />
                        </div>

                        <div class="sm:col-span-2">
                            <x-admin.field name="desk" label="Deskripsi Singkat" type="textarea" rows="3" :value="$course->desk"
                                           help="Tampil di halaman indeks dan detail materi sebagai gambaran umum." />
                        </div>

                        <div>
                            <x-admin.field name="sort_order" label="Urutan Tampil" type="number" :value="$course->sort_order"
                                           help="Posisi materi di halaman indeks (urut dari kecil)." />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Image Card --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-poppins font-bold text-slate-800 text-sm flex items-center gap-2">
                        <i class="ri-image-line text-accent"></i>Gambar Sampul Materi
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5">Gambar yang ditampilkan di kartu materi pada halaman indeks.</p>
                </div>

                <div class="p-6">
                    <x-admin.image-input name="gambar" label="Gambar Materi" :current="$course->gambar" />
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex items-center gap-3 pb-6">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-accent text-white text-sm font-semibold hover:bg-blue-600 transition-colors">
                    <i class="ri-save-line"></i>Simpan Perubahan
                </button>
                <a href="{{ route('admin.courses.show', $course) }}"
                   class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors">
                    Batal
                </a>
            </div>
        </div>
    </form>
@endsection
