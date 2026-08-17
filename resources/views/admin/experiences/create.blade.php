@extends('admin.layouts.app')

@section('title', 'Tambah Pengalaman')
@section('page_title', 'Tambah Pengalaman')

@section('content')
    <x-admin.page-title/>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 max-w-4xl">
        <form method="POST" action="{{ route('admin.experiences.store') }}" enctype="multipart/form-data" class="grid sm:grid-cols-2 gap-5">
            @csrf

            <div>
                <x-admin.field name="role" label="Posisi" required autofocus placeholder="Contoh: Web Developer" />
            </div>

            <div>
                <x-admin.field name="company" label="Perusahaan / Organisasi" required placeholder="Contoh: PT Maju Jaya" />
            </div>

            <div>
                <x-admin.field name="duration" label="Periode" placeholder="Contoh: Jan 2022 - Jan 2023" />
            </div>

            <div>
                <x-admin.field name="location" label="Lokasi" placeholder="Contoh: Banyuwangi" />
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="desk" label="Deskripsi (English)" type="textarea" rows="4" required
                               help="Deskripsi singkat tentang peran dan tanggung jawab." />
            </div>

            <div class="sm:col-span-2 pt-4 border-t border-dashed border-slate-200">
                <p class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400">
                    <i class="ri-translate-2 text-accent"></i>Versi Bahasa Indonesia (opsional)
                </p>
                <p class="text-xs text-slate-400 mt-1">Kosongkan jika belum tersedia — pengunjung akan melihat versi Inggris.</p>
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="role_idn" label="Posisi (Indonesia)" placeholder="Contoh: Staf Hubungan Eksternal" />
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="desk_idn" label="Deskripsi (Indonesia)" type="textarea" rows="4"
                               placeholder="Deskripsi dalam bahasa Indonesia" />
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="practicum_desc_idn" label="Deskripsi Praktikum (Indonesia)" type="textarea" rows="3"
                               placeholder="Deskripsi praktikum dalam bahasa Indonesia" />
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="responsibilities_idn" label="Tanggung Jawab Utama (Indonesia)" type="textarea" rows="4"
                               help="Satu tanggung jawab per baris. Kosongkan untuk memakai versi Inggris." />
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="practicum_desc" label="Deskripsi Praktikum (opsional)" type="textarea" rows="3"
                               help="Khusus untuk posisi asisten praktikum. Kosongkan jika tidak ada." />
            </div>

            <div class="sm:col-span-2">
                <x-admin.image-input name="gambar" label="Logo / Foto Perusahaan" ratio="1"
                                     help="Kosongkan untuk memakai inisial perusahaan otomatis." />
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="responsibilities" label="Tanggung Jawab Utama" type="textarea" rows="4"
                               help="Satu tanggung jawab per baris." />
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="skills" label="Skill" type="textarea" rows="3"
                               help="Satu skill per baris. Contoh: Python, Git & Version Control." />
            </div>

            <div class="sm:col-span-2 flex items-center gap-3 pt-2 border-t border-slate-100">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-accent text-white text-sm font-semibold hover:bg-blue-600 transition-colors">
                    <i class="ri-save-line"></i>Simpan
                </button>
                <a href="{{ route('admin.experiences.index') }}"
                   class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
