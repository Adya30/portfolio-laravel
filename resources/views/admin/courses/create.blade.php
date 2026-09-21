@extends('admin.layouts.app')

@section('title', 'Tambah Materi')
@section('page_title', 'Tambah Materi')

@section('content')
    <form method="POST" action="{{ route('admin.courses.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="max-w-4xl space-y-6">
            {{-- Step 1 of 2. Saying so up front is what makes the redirect to the
                 subbab page after saving feel expected rather than surprising. --}}
            <div class="flex items-start gap-3 rounded-2xl border border-accent/20 bg-accent/5 px-4 py-3.5">
                <i class="ri-information-line text-accent text-lg leading-none mt-0.5"></i>
                <p class="text-xs text-slate-600 leading-relaxed">
                    <span class="font-bold text-slate-700">Langkah 1 dari 2.</span>
                    Isi informasi dasar materi di bawah ini. Setelah disimpan, Anda akan diarahkan ke halaman
                    <span class="font-semibold text-slate-700">Subbab</span> untuk menambahkan isi materi
                    (paragraf, kode, gambar, tabel).
                </p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-poppins font-bold text-slate-800 text-sm flex items-center gap-2">
                        <i class="ri-file-text-line text-accent"></i>Informasi Utama Materi
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5">Isi data dasar materi yang akan ditampilkan di halaman course.</p>
                </div>

                <div class="p-6 space-y-5">
                    <div class="grid sm:grid-cols-2 gap-5">
                        <div class="sm:col-span-2">
                            <x-admin.field name="nama" label="Nama Materi" required autofocus placeholder="Contoh: Pengenalan Laravel" />
                        </div>

                        <div class="sm:col-span-2">
                            <x-admin.field name="desk" label="Deskripsi Singkat" type="textarea" rows="3"
                                           placeholder="Ringkasan singkat tentang materi ini..."
                                           help="Tampil di halaman indeks dan detail materi sebagai gambaran umum." />
                        </div>

                        <div>
                            <x-admin.field name="sort_order" label="Urutan Tampil" type="number" value="0"
                                           placeholder="0" help="Posisi materi di halaman indeks (urut dari kecil)." />
                        </div>
                    </div>
                </div>
            </div>



            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-poppins font-bold text-slate-800 text-sm flex items-center gap-2">
                        <i class="ri-image-line text-accent"></i>Gambar Sampul Materi
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5">Gambar yang ditampilkan di kartu materi pada halaman indeks.</p>
                </div>

                <div class="p-6">
                    <x-admin.image-input name="gambar" label="Gambar Materi" />
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3 pb-6">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-accent text-white text-sm font-semibold hover:bg-blue-600 hover:-translate-y-0.5 transition-all shadow-sm">
                    <i class="ri-save-line"></i>Simpan &amp; Lanjut ke Subbab
                </button>
                <a href="{{ route('admin.courses.index') }}"
                   class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors">
                    Batal
                </a>
            </div>
        </div>
    </form>
@endsection
