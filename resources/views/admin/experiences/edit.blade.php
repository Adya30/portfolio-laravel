@extends('admin.layouts.app')

@section('title', 'Edit Pengalaman')
@section('page_title', 'Edit Pengalaman')

@section('content')
    <x-admin.page-title title="Edit Pengalaman" subtitle="Perbarui data pengalaman" />

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 max-w-4xl">
        <form method="POST" action="{{ route('admin.experiences.update', $experience) }}" enctype="multipart/form-data" class="grid sm:grid-cols-2 gap-5">
            @csrf
            @method('PUT')

            <div>
                <x-admin.field name="role" label="Posisi" :value="$experience->role" required />
            </div>

            <div>
                <x-admin.field name="company" label="Perusahaan / Organisasi" :value="$experience->company" required />
            </div>

            <div>
                <x-admin.field name="duration" label="Periode" :value="$experience->duration" />
            </div>

            <div>
                <x-admin.field name="location" label="Lokasi" :value="$experience->location" />
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="desk" label="Deskripsi (English)" type="textarea" rows="4" :value="$experience->desk" required
                               help="Deskripsi singkat tentang peran dan tanggung jawab." />
            </div>

            <div class="sm:col-span-2 pt-4 border-t border-dashed border-slate-200">
                <p class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400">
                    <i class="ri-translate-2 text-accent"></i>Versi Bahasa Indonesia (opsional)
                </p>
                <p class="text-xs text-slate-400 mt-1">Kosongkan jika belum tersedia — pengunjung akan melihat versi Inggris.</p>
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="role_idn" label="Posisi (Indonesia)" :value="$experience->role_idn"
                               placeholder="Contoh: Staf Hubungan Eksternal" />
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="desk_idn" label="Deskripsi (Indonesia)" type="textarea" rows="4" :value="$experience->desk_idn"
                               placeholder="Deskripsi dalam bahasa Indonesia" />
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="practicum_desc_idn" label="Deskripsi Praktikum (Indonesia)" type="textarea" rows="3" :value="$experience->practicum_desc_idn"
                               placeholder="Deskripsi praktikum dalam bahasa Indonesia" />
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="responsibilities_idn" label="Tanggung Jawab Utama (Indonesia)" type="textarea" rows="4"
                               :value="implode(PHP_EOL, $experience->responsibilities_idn ?? [])"
                               help="Satu tanggung jawab per baris. Kosongkan untuk memakai versi Inggris." />
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="practicum_desc" label="Deskripsi Praktikum (opsional)" type="textarea" rows="3" :value="$experience->practicum_desc"
                               help="Khusus untuk posisi asisten praktikum. Kosongkan jika tidak ada." />
            </div>

            <div class="sm:col-span-2">
                <x-admin.image-input name="gambar" label="Logo / Foto Perusahaan" :current="$experience->gambar" ratio="1"
                                     help="Kosongkan untuk memakai inisial perusahaan otomatis." />
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="responsibilities" label="Tanggung Jawab Utama" type="textarea" rows="4"
                               :value="implode(PHP_EOL, $experience->responsibilities ?? [])"
                               help="Satu tanggung jawab per baris." />
            </div>

            <div class="sm:col-span-2">
                <x-admin.field name="skills" label="Skill" type="textarea" rows="3"
                               :value="implode(PHP_EOL, $experience->skills ?? [])"
                               help="Satu skill per baris. Contoh: Python, Git & Version Control." />
            </div>

            <div class="sm:col-span-2 flex items-center gap-3 pt-2 border-t border-slate-100">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-accent text-white text-sm font-semibold hover:bg-blue-600 transition-colors">
                    <i class="ri-save-line"></i>Simpan Perubahan
                </button>
                <a href="{{ route('admin.experiences.index') }}"
                   class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
