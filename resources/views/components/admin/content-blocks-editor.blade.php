@props([
    'name' => 'konten',
    'label' => 'Blok Konten Detail',
    'help' => 'Tambahkan blok paragraf dan gambar pendukung yang akan tampil di halaman detail.',
    'value' => [],
    'uploadUrl' => '',
])

@php
    $initialValue = old($name, $value ?? []);
    if (is_string($initialValue)) {
        $initialValue = json_decode($initialValue, true) ?: [];
    }
    $initialValue = is_array($initialValue) ? $initialValue : [];
@endphp

<div x-data="contentBlocksEditor(@js($initialValue), @js($uploadUrl))" class="space-y-3">
    <input type="hidden" name="{{ $name }}" x-ref="blocksInput" :value="JSON.stringify(blocks)">
    <div x-effect="$refs.blocksInput.value = JSON.stringify(blocks)"></div>

    <div class="flex items-center justify-between border-b border-slate-200 pb-2.5">
        <div>
            <label class="block text-sm font-semibold text-slate-800">{{ $label }}</label>
            @if ($help)
                <p class="text-xs text-slate-400 mt-0.5">{{ $help }}</p>
            @endif
        </div>
        <div class="flex items-center gap-2">
            <button type="button" @click="addParagraph()"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                <i class="ri-paragraph text-sm"></i>
                <span>+ Tambah Paragraf</span>
            </button>
            <button type="button" @click="addImage()"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-50 hover:bg-blue-100 text-blue-700 transition-colors">
                <i class="ri-image-add-line text-sm"></i>
                <span>+ Tambah Gambar</span>
            </button>
        </div>
    </div>

    <template x-if="uploadError">
        <div class="p-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs flex items-center justify-between">
            <span x-text="uploadError"></span>
            <button type="button" @click="uploadError = ''" class="text-red-500 hover:text-red-700">
                <i class="ri-close-line"></i>
            </button>
        </div>
    </template>

    <div class="space-y-3">
        <template x-for="(block, i) in blocks" :key="i">
            <div :id="'content-block-' + i"
                 class="p-4 rounded-xl border border-slate-200 bg-slate-50/70 hover:bg-slate-50 transition-all space-y-3">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-xs font-semibold uppercase tracking-wider"
                              :class="block.type === 'gambar' ? 'bg-blue-100 text-blue-700' : 'bg-slate-200 text-slate-700'">
                            <i :class="block.type === 'gambar' ? 'ri-image-line' : 'ri-text'" class="text-xs"></i>
                            <span x-text="block.type === 'gambar' ? 'Blok Gambar' : 'Blok Paragraf'"></span>
                        </span>
                        <span class="text-xs text-slate-400 font-mono" x-text="'#' + (i + 1)"></span>
                    </div>

                    <div class="flex items-center gap-1">
                        <button type="button" @click="moveBlock(i, -1)" :disabled="i === 0"
                                :class="i === 0 ? 'opacity-30 cursor-not-allowed' : 'hover:bg-slate-200 text-slate-600'"
                                class="w-7 h-7 flex items-center justify-center rounded-lg text-xs transition-colors"
                                title="Pindah ke atas">
                            <i class="ri-arrow-up-line"></i>
                        </button>
                        <button type="button" @click="moveBlock(i, 1)" :disabled="i === blocks.length - 1"
                                :class="i === blocks.length - 1 ? 'opacity-30 cursor-not-allowed' : 'hover:bg-slate-200 text-slate-600'"
                                class="w-7 h-7 flex items-center justify-center rounded-lg text-xs transition-colors"
                                title="Pindah ke bawah">
                            <i class="ri-arrow-down-line"></i>
                        </button>
                        <button type="button" @click="removeBlock(i)"
                                class="w-7 h-7 flex items-center justify-center rounded-lg text-xs text-red-500 hover:bg-red-50 transition-colors"
                                title="Hapus blok">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </div>
                </div>

                <template x-if="block.type === 'paragraf'">
                    <div>
                        <textarea x-model="block.teks" rows="3"
                                  placeholder="Tulis paragraf penjelasan di sini..."
                                  class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 outline-none focus:border-accent focus:ring-4 focus:ring-accent/15 transition-all"></textarea>
                    </div>
                </template>

                <template x-if="block.type === 'gambar'">
                    <div class="space-y-3">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                            <div class="w-24 h-20 rounded-xl border border-slate-200 bg-white flex items-center justify-center overflow-hidden shrink-0 relative">
                                <template x-if="block.url">
                                    <img :src="block.url" alt="Pratinjau" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!block.url && uploadingIndex !== i">
                                    <i class="ri-image-add-line text-2xl text-slate-300"></i>
                                </template>
                                <template x-if="uploadingIndex === i">
                                    <div class="flex items-center justify-center">
                                        <i class="ri-loader-4-line text-2xl text-accent animate-spin"></i>
                                    </div>
                                </template>
                            </div>

                            <div class="flex-1 w-full space-y-2">
                                <div class="flex flex-wrap items-center gap-2">
                                    <input type="file" accept="image/png,image/jpeg,image/webp,image/svg+xml"
                                           @change="uploadImage(i, $event.target.files[0])"
                                           class="text-xs text-slate-500 file:mr-2.5 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-accent file:text-white hover:file:bg-blue-600 file:cursor-pointer cursor-pointer">

                                    <div class="flex items-center gap-1.5 ml-auto">
                                        <label class="text-xs font-semibold text-slate-600">Ukuran:</label>
                                        <select x-model="block.ukuran"
                                                class="rounded-lg border border-slate-200 bg-white px-2 py-1 text-xs font-semibold text-slate-800 outline-none focus:border-accent">
                                            <option value="penuh">Penuh (100%)</option>
                                            <option value="besar">Besar (Max 2XL)</option>
                                            <option value="sedang">Sedang (Max MD)</option>
                                            <option value="kecil">Kecil (Max XS)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="space-y-1">
                                    <input type="url" x-model="block.url" placeholder="Atau tempel URL gambar (Cloudinary/eksternal)..."
                                           class="w-full rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs text-slate-800 placeholder:text-slate-400 outline-none focus:border-accent">
                                </div>
                            </div>
                        </div>

                        <div>
                            <input type="text" x-model="block.caption" placeholder="Keterangan / Caption gambar (opsional)..."
                                   class="w-full rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs text-slate-800 placeholder:text-slate-400 outline-none focus:border-accent">
                        </div>
                    </div>
                </template>
            </div>
        </template>

        <template x-if="blocks.length === 0">
            <div class="p-6 rounded-2xl border-2 border-dashed border-slate-200 text-center space-y-2 bg-slate-50/50">
                <i class="ri-layout-masonry-line text-3xl text-slate-300 block"></i>
                <p class="text-xs text-slate-500">Belum ada blok konten detail. Anda dapat menambahkan beberapa gambar dan paragraf untuk memperkaya halaman detail.</p>
                <div class="flex items-center justify-center gap-2 pt-1">
                    <button type="button" @click="addParagraph()"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 transition-colors">
                        <i class="ri-paragraph"></i>
                        <span>+ Paragraf</span>
                    </button>
                    <button type="button" @click="addImage()"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-500 hover:bg-blue-600 text-white transition-colors">
                        <i class="ri-image-add-line"></i>
                        <span>+ Gambar</span>
                    </button>
                </div>
            </div>
        </template>
    </div>
</div>
