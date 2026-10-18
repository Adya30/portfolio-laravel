@extends('admin.layouts.app')

@section('title', 'Tambah Project')
@section('page_title', 'Tambah Project')

@section('content')
    <div class="w-full space-y-6">
        {{-- Breadcrumb Navigasi --}}
        <nav class="flex flex-wrap items-center gap-x-2 gap-y-1 text-xs" aria-label="Breadcrumb">
            <a href="{{ route('admin.projects.index') }}"
                class="font-semibold text-slate-500 dark:text-slate-400 hover:text-accent transition-colors">Kelola
                Project</a>
            <i class="ri-arrow-right-s-line text-slate-300 dark:text-slate-600" aria-hidden="true"></i>
            <span class="text-slate-400">Tambah Project Baru</span>
        </nav>

        <form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid lg:grid-cols-12 gap-6 items-start">
                {{-- Kolom Kiri: Informasi Utama & Blok Isi Konten --}}
                <div class="lg:col-span-8 space-y-6">
                    {{-- Informasi Dasar Project --}}
                    <div
                        class="bg-white dark:bg-[#162032] rounded-2xl border border-slate-200/80 dark:border-white/10 shadow-xs p-6 space-y-4">

                        <x-admin.field name="nama" label="Nama Project" required autofocus />
                    </div>

                    {{-- Bagian Isi Konten (Mode Blok seperti Materi) --}}
                    <div x-data="{ langTab: 'en' }"
                        class="bg-white dark:bg-[#162032] rounded-2xl border border-slate-200/80 dark:border-white/10 shadow-xs overflow-hidden">
                        <div
                            class="px-6 py-4 border-b border-slate-100 dark:border-white/10 bg-slate-50/50 dark:bg-white/5 flex flex-wrap items-center justify-between gap-3">
                            <div>
                                <h3
                                    class="font-poppins font-bold text-slate-800 dark:text-white text-sm flex items-center gap-2">
                                    <i class="ri-stack-line text-accent"></i>Bagian Isi Konten Project (Mode Blok)
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
                                'uploadUrl' => route('admin.projects.upload-image'),
                                'autosaveKey' => 'autosave_project_new',
                            ])
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Link Sebelahnya (GitHub & Live Demo) & Metadata Project --}}
                <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-4">
                    {{-- Link Sebelahnya: GitHub & Live Demo --}}
                    <div
                        class="bg-white dark:bg-[#162032] rounded-2xl border border-slate-200/80 dark:border-white/10 shadow-xs p-6 space-y-4">
                        <div class="border-b border-slate-100 dark:border-white/10 pb-3">
                            <h3
                                class="font-poppins font-bold text-slate-800 dark:text-white text-sm flex items-center gap-2">
                                <i class="ri-external-link-line text-accent"></i>Tautan Sebelahnya (Links)
                            </h3>
                        </div>

                        <x-admin.field name="link" label="Link GitHub" type="url"
                            placeholder="https://github.com/..." help="Link repository GitHub project (opsional)." />

                        <x-admin.field name="link_live" label="Link Live / Demo" type="url"
                            placeholder="https://contoh.com" help="Link website live / demo project (opsional)." />
                    </div>

                    {{-- Sampul / Thumbnail --}}
                    <div
                        class="bg-white dark:bg-[#162032] rounded-2xl border border-slate-200/80 dark:border-white/10 shadow-xs p-6 space-y-4">
                        <div class="border-b border-slate-100 dark:border-white/10 pb-3">
                            <h3
                                class="font-poppins font-bold text-slate-800 dark:text-white text-sm flex items-center gap-2">
                                <i class="ri-image-line text-accent"></i>Thumbnail Utama
                            </h3>
                        </div>

                        <x-admin.image-input name="gambar" label="Gambar Utama Project" />
                    </div>

                    {{-- Kategori & Tools --}}
                    <div
                        class="bg-white dark:bg-[#162032] rounded-2xl border border-slate-200/80 dark:border-white/10 shadow-xs p-6 space-y-4">
                        <div class="border-b border-slate-100 dark:border-white/10 pb-3">
                            <h3
                                class="font-poppins font-bold text-slate-800 dark:text-white text-sm flex items-center gap-2">
                                <i class="ri-price-tag-3-line text-accent"></i>Kategori &amp; Teknologi
                            </h3>
                        </div>

                        <div>
                            <label for="category_id"
                                class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-1.5">Kategori</label>
                            <select name="category_id" id="category_id"
                                class="w-full rounded-xl border bg-white dark:bg-[#0c1322] px-3.5 py-2.5 text-xs font-semibold text-slate-800 dark:text-slate-200 outline-none transition-all border-slate-200 dark:border-white/10 focus:border-accent focus:ring-2 focus:ring-accent/20">
                                <option value="">Tanpa Kategori</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" @selected(old('category_id', '') == $cat->id)>{{ $cat->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <x-admin.tools-picker :tools="$tools" :selected="old('tools', [])" />
                        </div>
                    </div>

                    {{-- Tombol Aksi Simpan --}}
                    <div
                        class="bg-white dark:bg-[#162032] rounded-2xl border border-slate-200/80 dark:border-white/10 shadow-xs p-5 space-y-3">
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-accent text-white text-sm font-bold hover:bg-blue-600 hover:-translate-y-0.5 transition-all shadow-sm cursor-pointer">
                            <i class="ri-save-line text-base"></i>Simpan Project
                        </button>
                        <a href="{{ route('admin.projects.index') }}"
                            class="block text-center px-4 py-2 rounded-xl border border-slate-200 dark:border-white/10 text-slate-600 dark:text-slate-300 text-xs font-semibold hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
