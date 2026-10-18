@extends('admin.layouts.app')

@section('title', 'Tambah Pengalaman')
@section('page_title', 'Tambah Pengalaman')

@section('content')
    <div class="w-full space-y-6">
        {{-- Breadcrumb Navigasi --}}
        <nav class="flex flex-wrap items-center gap-x-2 gap-y-1 text-xs" aria-label="Breadcrumb">
            <a href="{{ route('admin.experiences.index') }}"
                class="font-semibold text-slate-500 dark:text-slate-400 hover:text-accent transition-colors">Kelola
                Pengalaman</a>
            <i class="ri-arrow-right-s-line text-slate-300 dark:text-slate-600" aria-hidden="true"></i>
            <span class="text-slate-400">Tambah Pengalaman Baru</span>
        </nav>

        <form method="POST" action="{{ route('admin.experiences.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid lg:grid-cols-12 gap-6 items-start">
                {{-- Kolom Kiri: Informasi Utama & Blok Isi Konten --}}
                <div class="lg:col-span-8 space-y-6">
                    {{-- Informasi Dasar Pengalaman --}}
                    <div class="bg-white dark:bg-[#162032] rounded-2xl border border-slate-200/80 dark:border-white/10 shadow-xs p-6 space-y-4">
                        <div class="border-b border-slate-100 dark:border-white/10 pb-3">
                            <h3 class="font-poppins font-bold text-slate-800 dark:text-white text-sm flex items-center gap-2">
                                <i class="ri-briefcase-line text-accent"></i>Informasi Posisi & Perusahaan
                            </h3>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <x-admin.field name="role" label="Posisi / Jabatan (English)" required autofocus placeholder="Contoh: Web Developer" />
                            </div>
                            <div>
                                <x-admin.field name="role_idn" label="Posisi / Jabatan (Indonesia)" placeholder="Contoh: Pengembang Web" />
                            </div>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <x-admin.field name="company" label="Perusahaan / Organisasi" required placeholder="Contoh: PT Maju Jaya / BEM FASILKOM UNEJ" />
                            </div>
                            <div>
                                <x-admin.field name="duration" label="Periode" placeholder="Contoh: Jan 2022 - Jan 2023" />
                            </div>
                            <div>
                                <x-admin.field name="location" label="Lokasi" placeholder="Contoh: Banyuwangi / Remote" />
                            </div>
                        </div>
                    </div>

                    {{-- Bagian Isi Konten Experience (Mode Blok seperti Project) --}}
                    <div x-data="{ langTab: 'en' }"
                        class="bg-white dark:bg-[#162032] rounded-2xl border border-slate-200/80 dark:border-white/10 shadow-xs overflow-hidden">
                        <div
                            class="px-6 py-4 border-b border-slate-100 dark:border-white/10 bg-slate-50/50 dark:bg-white/5 flex flex-wrap items-center justify-between gap-3">
                            <div>
                                <h3
                                    class="font-poppins font-bold text-slate-800 dark:text-white text-sm flex items-center gap-2">
                                    <i class="ri-stack-line text-accent"></i>Bagian Isi Konten Pengalaman (Mode Blok)
                                </h3>
                            </div>

                            {{-- Tab Switcher English / Indonesia --}}
                            <div
                                class="inline-flex items-center p-0.5 rounded-xl border border-slate-200 dark:border-white/10 bg-slate-100 dark:bg-white/5 text-xs font-semibold">
                                <button type="button"
                                    @click="langTab = 'en'; $nextTick(() => window.dispatchEvent(new Event('resize')))"
                                    :class="langTab === 'en' ?
                                        'bg-white dark:bg-[#162032] text-accent shadow-2xs font-bold' :
                                        'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white'"
                                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg transition-all cursor-pointer">
                                    <span class="w-2 h-2 rounded-full"
                                        :class="langTab === 'en' ? 'bg-accent' : 'bg-slate-300 dark:bg-slate-600'"></span>
                                    <span>English</span>
                                </button>
                                <button type="button"
                                    @click="langTab = 'id'; $nextTick(() => window.dispatchEvent(new Event('resize')))"
                                    :class="langTab === 'id' ?
                                        'bg-white dark:bg-[#162032] text-accent shadow-2xs font-bold' :
                                        'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white'"
                                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg transition-all cursor-pointer">
                                    <span class="w-2 h-2 rounded-full"
                                        :class="langTab === 'id' ? 'bg-accent' : 'bg-slate-300 dark:bg-slate-600'"></span>
                                    <span>Indonesia</span>
                                </button>
                            </div>
                        </div>

                        {{-- Editor Blok Konten (Sinkron English & Indonesia) --}}
                        <div>
                            @include('admin.projects._blocks-editor', [
                                'blocksValue' => old('blocks_data') ? json_decode(old('blocks_data'), true) : ($blocksValue ?? []),
                                'uploadUrl' => route('admin.experiences.upload-image'),
                                'autosaveKey' => 'autosave_experience_new',
                            ])
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Logo / Foto, Skills, dan Aksi Simpan --}}
                <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-4">
                    {{-- Logo / Foto Perusahaan --}}
                    <div class="bg-white dark:bg-[#162032] rounded-2xl border border-slate-200/80 dark:border-white/10 shadow-xs p-6 space-y-4">
                        <div class="border-b border-slate-100 dark:border-white/10 pb-3">
                            <h3 class="font-poppins font-bold text-slate-800 dark:text-white text-sm flex items-center gap-2">
                                <i class="ri-image-line text-accent"></i>Logo / Foto Perusahaan
                            </h3>
                        </div>
                        <x-admin.image-input name="gambar" label="Logo / Foto" ratio="1"
                            help="Kosongkan untuk memakai inisial nama perusahaan otomatis." />
                    </div>

                    {{-- Keahlian / Skills Digunakan --}}
                    @php
                        $skillsRaw = old('skills', []);
                        $skillsText = is_array($skillsRaw) ? implode("\n", $skillsRaw) : ($skillsRaw ?? '');
                    @endphp
                    <div class="bg-white dark:bg-[#162032] rounded-2xl border border-slate-200/80 dark:border-white/10 shadow-xs p-6 space-y-4">
                        <div class="border-b border-slate-100 dark:border-white/10 pb-3">
                            <h3 class="font-poppins font-bold text-slate-800 dark:text-white text-sm flex items-center gap-2">
                                <i class="ri-tools-line text-accent"></i>Keahlian (Skills)
                            </h3>
                        </div>
                        <x-admin.field name="skills" label="Skill Digunakan" type="textarea" rows="4"
                            :value="$skillsText"
                            help="Satu skill per baris. Contoh: Python, Git, Tailwind CSS." />
                    </div>

                    {{-- Pengaturan Tambahan --}}
                    <div class="bg-white dark:bg-[#162032] rounded-2xl border border-slate-200/80 dark:border-white/10 shadow-xs p-6 space-y-4">
                        <div class="border-b border-slate-100 dark:border-white/10 pb-3">
                            <h3 class="font-poppins font-bold text-slate-800 dark:text-white text-sm flex items-center gap-2">
                                <i class="ri-settings-3-line text-accent"></i>Pengaturan Tambahan
                            </h3>
                        </div>
                        <x-admin.field name="sort_order" label="Urutan Tampil" type="number" min="0" value="0"
                            help="Angka lebih kecil tampil lebih awal." />
                    </div>

                    {{-- Tombol Aksi Simpan --}}
                    <div class="bg-white dark:bg-[#162032] rounded-2xl border border-slate-200/80 dark:border-white/10 shadow-xs p-5">
                        <div class="flex items-center gap-3">
                            <button type="submit"
                                class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-accent text-white font-bold text-sm hover:bg-blue-600 transition-all shadow-sm cursor-pointer">
                                <i class="ri-save-line text-base"></i>Simpan Pengalaman
                            </button>
                            <a href="{{ route('admin.experiences.index') }}"
                                class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-white/10 text-slate-600 dark:text-slate-300 font-semibold text-sm hover:bg-slate-100 dark:hover:bg-white/5 transition-all text-center">
                                Batal
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
