@php
    if (! isset($blocksValue)) {
        $blocksValue = old('konten', ($course ?? null)?->konten ?? []);
    }
    if (is_string($blocksValue)) {
        $blocksValue = json_decode($blocksValue, true) ?: [];
    }
    $blocksValue = is_array($blocksValue) ? $blocksValue : [];
    $autosaveKey = 'autosave_course_' . (($course ?? null)?->id ?? '0')
                 . '_block_' . ($blockIndex ?? 'main');
@endphp

<div x-data="courseContentEditor(@js($blocksValue), @js(route('admin.courses.upload-image')), @js($autosaveKey))" class="space-y-4">
    <input type="hidden" name="konten" x-ref="kontenInput" value="{{ json_encode($blocksValue) }}">
    <div x-effect="$refs.kontenInput.value = JSON.stringify(blocks)"></div>

    <div class="bg-white shadow-xl p-6 sm:p-8 max-w-4xl mx-auto relative">
        <div class="border-b border-slate-200 pb-3 flex items-center justify-between text-xs text-slate-400 font-mono select-none">
            <div class="flex items-center gap-3">
                <span class="font-semibold text-slate-600">Halaman Materi</span>
                <span class="text-slate-300">|</span>
                <div class="flex items-center gap-1 font-sans">
                    <button type="button" @click="undo()" :disabled="!canUndo()"
                            :class="canUndo() ? 'text-slate-600 hover:text-accent hover:bg-slate-100 cursor-pointer shadow-2xs bg-white border border-slate-200' : 'text-slate-300 cursor-not-allowed opacity-40 bg-slate-50 border border-slate-100'"
                            class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-xs font-semibold transition-all"
                            title="Undo perubahan (Ctrl+Z)">
                        <i class="ri-arrow-go-back-line text-sm"></i>
                        <span class="hidden sm:inline">Undo</span>
                    </button>
                    <button type="button" @click="redo()" :disabled="!canRedo()"
                            :class="canRedo() ? 'text-slate-600 hover:text-accent hover:bg-slate-100 cursor-pointer shadow-2xs bg-white border border-slate-200' : 'text-slate-300 cursor-not-allowed opacity-40 bg-slate-50 border border-slate-100'"
                            class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-xs font-semibold transition-all"
                            title="Redo perubahan (Ctrl+Y / Ctrl+Shift+Z)">
                        <i class="ri-arrow-go-forward-line text-sm"></i>
                        <span class="hidden sm:inline">Redo</span>
                    </button>
                </div>
            </div>
            <span x-show="autosaveStatus === 'saved'"
                  x-transition:enter="transition ease-out duration-300"
                  x-transition:enter-start="opacity-0 translate-y-1"
                  x-transition:enter-end="opacity-100 translate-y-0"
                  x-transition:leave="transition ease-in duration-200"
                  x-transition:leave-start="opacity-100"
                  x-transition:leave-end="opacity-0"
                  x-cloak
                  class="flex items-center gap-1 text-emerald-500 font-semibold text-[10px]">
                <i class="ri-checkbox-circle-fill"></i> Draft tersimpan otomatis
            </span>
        </div>

        <div class="flex flex-wrap items-center gap-2 py-3 border-b border-slate-100">
            <div class="relative" x-data="{ blockMenuOpen: false }">
                <button type="button" @click="blockMenuOpen = !blockMenuOpen"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-accent text-white text-xs font-bold hover:bg-blue-600 transition-colors">
                    <i class="ri-add-line text-sm"></i> Tambah Blok
                    <i class="ri-arrow-down-s-line text-sm transition-transform" :class="blockMenuOpen && 'rotate-180'"></i>
                </button>
                <div x-show="blockMenuOpen" x-cloak @click.outside="blockMenuOpen = false"
                     class="absolute left-0 top-full mt-1 z-20 w-48 bg-white border border-slate-200 rounded-xl shadow-lg p-1.5 space-y-0.5">
                    @if (! ($hideSubbab ?? false))
                    <button type="button" @click="addBlock('subbab'); blockMenuOpen = false"
                            class="flex items-center gap-2 w-full px-3 py-2 rounded-lg text-left text-xs font-semibold text-slate-700 hover:bg-slate-100 hover:text-accent transition-colors">
                        <i class="ri-heading text-accent text-sm"></i> Subbab
                    </button>
                    @endif
                    <button type="button" @click="addBlock('subheading'); blockMenuOpen = false"
                            class="flex items-center gap-2 w-full px-3 py-2 rounded-lg text-left text-xs font-semibold text-slate-700 hover:bg-slate-100 hover:text-accent transition-colors">
                        <i class="ri-h-2 text-accent text-sm"></i> Sub Heading
                    </button>
                    <button type="button" @click="addBlock('paragraf'); blockMenuOpen = false"
                            class="flex items-center gap-2 w-full px-3 py-2 rounded-lg text-left text-xs font-semibold text-slate-700 hover:bg-slate-100 hover:text-accent transition-colors">
                        <i class="ri-paragraph text-accent text-sm"></i> Paragraf
                    </button>
                    <button type="button" @click="addBlock('gambar'); blockMenuOpen = false"
                            class="flex items-center gap-2 w-full px-3 py-2 rounded-lg text-left text-xs font-semibold text-slate-700 hover:bg-slate-100 hover:text-accent transition-colors">
                        <i class="ri-image-line text-accent text-sm"></i> Gambar
                    </button>
                    <button type="button" @click="addBlock('kode'); blockMenuOpen = false"
                            class="flex items-center gap-2 w-full px-3 py-2 rounded-lg text-left text-xs font-semibold text-slate-700 hover:bg-slate-100 hover:text-accent transition-colors">
                        <i class="ri-code-box-line text-accent text-sm"></i> Kode
                    </button>
                    <button type="button" @click="addBlock('link'); blockMenuOpen = false"
                            class="flex items-center gap-2 w-full px-3 py-2 rounded-lg text-left text-xs font-semibold text-slate-700 hover:bg-slate-100 hover:text-accent transition-colors">
                        <i class="ri-external-link-line text-accent text-sm"></i> Link
                    </button>
                    <button type="button" @click="addBlock('pembatas'); blockMenuOpen = false"
                            class="flex items-center gap-2 w-full px-3 py-2 rounded-lg text-left text-xs font-semibold text-slate-700 hover:bg-slate-100 hover:text-accent transition-colors">
                        <i class="ri-separator text-accent text-sm"></i> Pembatas
                    </button>
                    <button type="button" @click="addBlock('tabel'); blockMenuOpen = false"
                            class="flex items-center gap-2 w-full px-3 py-2 rounded-lg text-left text-xs font-semibold text-slate-700 hover:bg-slate-100 hover:text-accent transition-colors">
                        <i class="ri-table-2 text-accent text-sm"></i> Tabel Data
                    </button>
                </div>
            </div>
        </div>

        <div class="min-h-[400px]">
            <template x-for="(block, i) in blocks" :key="i">
                <div>
                    <div class="border-t border-slate-200/70 my-0"></div>

                    <div :id="'blok-' + i"
                         :draggable="!(i === 0 && block.type === 'subbab')"
                         @dragstart="dragStart(i, $event)"
                         @dragover="dragOver(i, $event)"
                         @drop="dropBlock(i, $event)"
                         @dragend="dragEnd"
                         :class="draggedIndex === i ? 'opacity-40' : ''"
                         class="py-3 hover:bg-slate-50/50 transition-colors">

                        <div class="flex items-center justify-between gap-3 mb-2">
                            <div class="flex items-center gap-2">
                                <template x-if="!(i === 0 && block.type === 'subbab')">
                                    <span class="cursor-grab active:cursor-grabbing text-slate-300 hover:text-slate-500 transition-colors p-0.5"
                                          title="Tahan & geser untuk memindahkan">
                                        <i class="ri-drag-move-2-line text-sm"></i>
                                    </span>
                                </template>
                                <template x-if="i === 0 && block.type === 'subbab'">
                                    <span class="text-slate-400 p-0.5" title="Subbab utama terkunci di atas">
                                        <i class="ri-lock-2-line text-sm text-slate-400"></i>
                                    </span>
                                </template>
                                <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-slate-100 text-slate-600 border border-slate-200" x-text="blockLabel(block.type)"></span>
                            </div>

                            <div class="flex items-center gap-0.5" x-show="!(i === 0 && block.type === 'subbab')">
                                <button type="button" @click="moveBlock(i, -1)" :disabled="i <= 1 && blocks[0]?.type === 'subbab'"
                                        :class="(i <= 1 && blocks[0]?.type === 'subbab') || i === 0 ? 'opacity-30 cursor-not-allowed' : 'hover:text-slate-700 hover:bg-slate-100'"
                                        class="w-6 h-6 flex items-center justify-center rounded text-slate-400 transition-colors"
                                        title="Pindah ke atas">
                                    <i class="ri-arrow-up-line text-xs"></i>
                                </button>
                                <button type="button" @click="moveBlock(i, 1)" :disabled="i >= blocks.length - 1"
                                        :class="i >= blocks.length - 1 ? 'opacity-30 cursor-not-allowed' : 'hover:text-slate-700 hover:bg-slate-100'"
                                        class="w-6 h-6 flex items-center justify-center rounded text-slate-400 transition-colors"
                                        title="Pindah ke bawah">
                                    <i class="ri-arrow-down-line text-xs"></i>
                                </button>
                                <button type="button" @click="removeBlock(i)"
                                        class="w-6 h-6 flex items-center justify-center rounded text-slate-400 hover:text-red-500 hover:bg-red-50 transition-colors"
                                        title="Hapus blok">
                                    <i class="ri-delete-bin-line text-xs"></i>
                                </button>
                            </div>
                        </div>

                        <template x-if="block.type === 'subbab'">
                            <div>
                                <label :for="'subbab_judul_' + i" class="sr-only">Judul Subbab</label>
                                <input :id="'subbab_judul_' + i" type="text" x-model="block.judul" placeholder="Tulis judul subbab di sini..."
                                       class="w-full rounded-lg border border-slate-200 bg-slate-50/50 px-3 py-2 text-base font-poppins font-bold text-slate-800 placeholder:text-slate-400 outline-none focus:border-accent focus:bg-white focus:ring-2 focus:ring-accent/15 transition-all">
                            </div>
                        </template>

                        <template x-if="block.type === 'subheading'">
                            <div>
                                <label :for="'subheading_teks_' + i" class="sr-only">Sub Heading</label>
                                <input :id="'subheading_teks_' + i" type="text" x-model="block.teks" placeholder="Tulis sub heading di sini..."
                                       class="w-full rounded-lg border border-slate-200 bg-slate-50/50 px-3 py-1.5 text-sm font-poppins font-semibold text-slate-800 placeholder:text-slate-400 outline-none focus:border-accent focus:bg-white focus:ring-2 focus:ring-accent/15 transition-all">
                            </div>
                        </template>

                        <template x-if="block.type === 'paragraf'">
                            <div x-data="quillParagraphEditor(block, i)" class="space-y-1">
                                <div x-ref="quillBox" class="bg-white"></div>
                            </div>
                        </template>

                        <template x-if="block.type === 'gambar'">
                            <div class="space-y-2">
                                <div class="flex flex-wrap items-center gap-2">
                                    <label :for="'gambar_ukuran_' + i" class="sr-only">Ukuran Gambar</label>
                                    <select :id="'gambar_ukuran_' + i" x-model="block.ukuran"
                                            class="rounded-lg border border-slate-200 bg-white px-2 py-1 text-xs font-semibold text-slate-800 outline-none focus:border-accent">
                                        <option value="penuh">Penuh</option>
                                        <option value="besar">Besar</option>
                                        <option value="sedang">Sedang</option>
                                        <option value="kecil">Kecil</option>
                                    </select>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-20 h-16 rounded-lg border border-slate-200 bg-slate-50 flex items-center justify-center overflow-hidden shrink-0">
                                        <template x-if="block.url">
                                            <img :src="block.url" alt="Pratinjau" class="w-full h-full object-cover">
                                        </template>
                                        <template x-if="!block.url">
                                            <i class="ri-image-add-line text-2xl text-slate-300"></i>
                                        </template>
                                    </div>
                                    <div class="flex-1 min-w-0 space-y-1.5">
                                        <label :for="'gambar_file_' + i" class="sr-only">File Gambar</label>
                                        <input :id="'gambar_file_' + i" type="file" accept=".svg,.png,.jpg,.jpeg,.webp,image/svg+xml,image/png,image/jpeg,image/webp"
                                               @change="uploadImage(i, $event.target.files[0])"
                                               class="block w-full text-xs text-slate-600 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-accent/10 file:text-xs file:font-bold file:text-accent hover:file:bg-accent/20 cursor-pointer">
                                        <p x-show="uploadingIndex === i" x-cloak class="text-xs text-accent font-semibold">
                                            <i class="ri-loader-4-line animate-spin"></i> Mengunggah...
                                        </p>
                                        <label :for="'gambar_url_' + i" class="sr-only">URL Gambar</label>
                                        <input :id="'gambar_url_' + i" type="text" x-model="block.url" placeholder="Atau tempel URL gambar"
                                               class="w-full rounded-lg border border-slate-200 bg-slate-50/50 px-3 py-1.5 text-xs text-slate-800 placeholder:text-slate-400 outline-none focus:border-accent focus:bg-white transition-all">
                                    </div>
                                </div>
                                <label :for="'gambar_caption_' + i" class="sr-only">Caption Gambar</label>
                                <input :id="'gambar_caption_' + i" type="text" x-model="block.caption" placeholder="Caption gambar (opsional)"
                                       class="w-full rounded-lg border border-slate-200 bg-slate-50/50 px-3 py-1.5 text-xs text-slate-800 placeholder:text-slate-400 outline-none focus:border-accent focus:bg-white transition-all">
                            </div>
                        </template>

                        <template x-if="block.type === 'kode'">
                            <div>
                                <div class="rounded-lg border border-slate-700 overflow-hidden bg-[#0d1117]">
                                    <div class="flex items-center justify-between gap-3 px-3 py-1.5 bg-[#161b22] border-b border-slate-800">
                                        <div class="flex items-center gap-1.5">
                                            <span class="w-2 h-2 rounded-full bg-[#ff5f56]"></span>
                                            <span class="w-2 h-2 rounded-full bg-[#ffbd2e]"></span>
                                            <span class="w-2 h-2 rounded-full bg-[#27c93f]"></span>
                                        </div>
                                        <label :for="'kode_bahasa_' + i" class="sr-only">Bahasa Pemrograman</label>
                                        <select :id="'kode_bahasa_' + i" x-model="block.bahasa"
                                                class="rounded border border-slate-700 bg-slate-800 text-slate-200 px-2 py-0.5 text-xs font-mono outline-none focus:border-accent">
                                            <option value="php">PHP</option>
                                            <option value="javascript">JavaScript</option>
                                            <option value="typescript">TypeScript</option>
                                            <option value="html">HTML</option>
                                            <option value="css">CSS</option>
                                            <option value="sql">SQL</option>
                                            <option value="python">Python</option>
                                            <option value="bash">Bash</option>
                                            <option value="json">JSON</option>
                                            <option value="plaintext">Plain Text</option>
                                        </select>
                                    </div>
                                    <label :for="'kode_area_' + i" class="sr-only">Tulis Kode</label>
                                    <textarea :id="'kode_area_' + i" x-model="block.kode" @keydown.tab.prevent="insertTab($event)"
                                              rows="6" placeholder="// Tulis atau tempel kode di sini..."
                                              class="w-full bg-[#0d1117] p-3 text-xs font-mono text-slate-100 placeholder:text-slate-600 outline-none focus:ring-1 focus:ring-accent/40 resize-y border-0"></textarea>
                                </div>
                            </div>
                        </template>

                        <template x-if="block.type === 'link'">
                            <div class="space-y-2">
                                <label :for="'link_href_' + i" class="sr-only">URL Link</label>
                                <input :id="'link_href_' + i" type="url" x-model="block.href" placeholder="URL / Tautan"
                                       class="w-full rounded-lg border border-slate-200 bg-slate-50/50 px-3 py-1.5 text-sm text-slate-800 placeholder:text-slate-400 outline-none focus:border-accent focus:bg-white focus:ring-2 focus:ring-accent/15 transition-all">
                                <label :for="'link_label_' + i" class="sr-only">Label Link</label>
                                <input :id="'link_label_' + i" type="text" x-model="block.label" placeholder="Label tombol"
                                       class="w-full rounded-lg border border-slate-200 bg-slate-50/50 px-3 py-1.5 text-sm text-slate-800 placeholder:text-slate-400 outline-none focus:border-accent focus:bg-white focus:ring-2 focus:ring-accent/15 transition-all">
                                <label :for="'link_desc_' + i" class="sr-only">Deskripsi Link</label>
                                <input :id="'link_desc_' + i" type="text" x-model="block.desc" placeholder="Deskripsi singkat (opsional)"
                                       class="w-full rounded-lg border border-slate-200 bg-slate-50/50 px-3 py-1.5 text-sm text-slate-800 placeholder:text-slate-400 outline-none focus:border-accent focus:bg-white focus:ring-2 focus:ring-accent/15 transition-all">
                            </div>
                        </template>

                        <template x-if="block.type === 'pembatas'">
                            <div class="space-y-2">
                                <label :for="'pembatas_style_' + i" class="sr-only">Gaya Pembatas</label>
                                <select :id="'pembatas_style_' + i" x-model="block.style"
                                        class="rounded-lg border border-slate-200 bg-white px-2 py-1 text-xs font-semibold text-slate-800 outline-none focus:border-accent">
                                    <option value="garis">Garis Tipis</option>
                                    <option value="garis-tebal">Garis Tebal</option>
                                    <option value="dots">Titik-Titik</option>
                                    <option value="spasi">Spasi Kosong</option>
                                </select>
                                <div>
                                    <template x-if="block.style === 'garis'">
                                        <hr class="border-slate-300">
                                    </template>
                                    <template x-if="block.style === 'garis-tebal'">
                                        <hr class="border-2 border-slate-400 rounded">
                                    </template>
                                    <template x-if="block.style === 'dots'">
                                        <div class="text-center text-slate-400 text-base tracking-[0.5em] select-none">· · ·</div>
                                    </template>
                                    <template x-if="block.style === 'spasi'">
                                        <div class="h-6"></div>
                                    </template>
                                </div>
                            </div>
                        </template>

                        <template x-if="block.type === 'tabel'">
                            <div class="space-y-3" x-data="{ tableMode: 'edit' }">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <button type="button" @click="addTableCol(i)"
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-100 border border-slate-300 text-slate-700 text-xs font-bold hover:bg-slate-200 transition-colors">
                                            <i class="ri-add-line text-xs"></i> Tambah Kolom
                                        </button>
                                        <button type="button" @click="addTableRow(i)"
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-accent/10 border border-accent/30 text-accent text-xs font-bold hover:bg-accent/20 transition-colors">
                                            <i class="ri-add-line text-xs"></i> Tambah Baris
                                        </button>
                                    </div>

                                    <div class="flex items-center gap-1 bg-slate-100 p-0.5 rounded-lg border border-slate-200">
                                        <button type="button" @click="tableMode = 'edit'"
                                                :class="tableMode === 'edit' ? 'bg-white text-slate-800 shadow-xs font-bold' : 'text-slate-500 hover:text-slate-800 font-medium'"
                                                class="px-2.5 py-1 rounded-md text-xs transition-all flex items-center gap-1">
                                            <i class="ri-edit-line text-xs"></i> Mode Edit
                                        </button>
                                        <button type="button" @click="tableMode = 'preview'"
                                                :class="tableMode === 'preview' ? 'bg-white text-accent shadow-xs font-bold' : 'text-slate-500 hover:text-slate-800 font-medium'"
                                                class="px-2.5 py-1 rounded-md text-xs transition-all flex items-center gap-1">
                                            <i class="ri-eye-line text-xs"></i> Pratinjau Tabel
                                        </button>
                                    </div>
                                </div>


                                <!-- MODE EDIT -->
                                <div x-show="tableMode === 'edit'" class="overflow-x-auto border border-slate-300 rounded-xl bg-white shadow-xs">
                                    <table class="w-full text-left text-xs border-collapse">
                                        <thead class="bg-slate-100 border-b-2 border-slate-300">
                                            <tr>
                                                <th class="p-2 w-10 text-center text-slate-500 font-bold border border-slate-300">#</th>
                                                <template x-for="(head, cIdx) in (block.headers || [])" :key="cIdx">
                                                    <th class="p-2 min-w-[150px] border border-slate-300">
                                                        <div class="flex items-center justify-between gap-1.5">
                                                            <label :for="'tabel_header_' + i + '_' + cIdx" class="sr-only">Judul Kolom</label>
                                                            <input :id="'tabel_header_' + i + '_' + cIdx" type="text" x-model="block.headers[cIdx]" placeholder="Judul kolom..."
                                                                   class="w-full rounded border border-slate-300 px-2 py-1 text-xs font-bold text-slate-800 bg-white outline-none focus:border-accent focus:ring-1 focus:ring-accent/30">
                                                            <button type="button" @click="removeTableCol(i, cIdx)"
                                                                    x-show="(block.headers || []).length > 1"
                                                                    title="Hapus kolom ini"
                                                                    class="w-6 h-6 flex items-center justify-center rounded text-slate-400 hover:text-red-500 hover:bg-red-50 transition-colors shrink-0">
                                                                <i class="ri-close-line text-sm"></i>
                                                            </button>
                                                        </div>
                                                    </th>
                                                </template>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template x-for="(row, rIdx) in (block.rows || [])" :key="rIdx">
                                                <tr :class="rIdx % 2 === 0 ? 'bg-white' : 'bg-slate-50/70'" class="hover:bg-blue-50/30 transition-colors">
                                                    <td class="p-2 text-center text-slate-500 font-bold text-xs border border-slate-300 align-top">
                                                        <div class="flex flex-col items-center justify-center gap-1 pt-1">
                                                            <span x-text="rIdx + 1"></span>
                                                            <button type="button" @click="removeTableRow(i, rIdx)"
                                                                    title="Hapus baris ini"
                                                                    class="w-5 h-5 flex items-center justify-center rounded text-slate-400 hover:text-red-500 hover:bg-red-50 transition-colors">
                                                                <i class="ri-delete-bin-line text-xs"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <template x-for="(cell, cIdx) in row" :key="cIdx">
                                                         <td class="p-2 border border-slate-300 align-top">
                                                            <div class="relative group">
                                                                <label :for="'tabel_cell_' + i + '_' + rIdx + '_' + cIdx" class="sr-only">Isi Sel</label>
                                                                <textarea :id="'tabel_cell_' + i + '_' + rIdx + '_' + cIdx"
                                                                          x-model="block.rows[rIdx][cIdx]"
                                                                          placeholder="Isi sel... (`kode` untuk tanda kode)"
                                                                          rows="2"
                                                                          @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'"
                                                                          class="w-full rounded border border-slate-200 px-2 py-1.5 pr-8 text-xs text-slate-800 bg-white outline-none focus:border-accent focus:ring-1 focus:ring-accent/30 transition-all resize-none font-mono leading-relaxed"></textarea>
                                                                <button type="button" @click="wrapCellWithCode(i, rIdx, cIdx, $el.previousElementSibling)"
                                                                        title="Bungkus dengan tanda kode (`...`)"
                                                                        class="absolute top-1.5 right-1.5 px-2 py-0.5 rounded-md text-[10px] font-mono font-bold transition-all cursor-pointer shadow-xs flex items-center gap-1"
                                                                        :class="block.rows[rIdx][cIdx]?.startsWith('`') && block.rows[rIdx][cIdx]?.endsWith('`')
                                                                            ? 'bg-blue-600 text-white border border-blue-700 font-extrabold ring-2 ring-blue-400/40'
                                                                            : 'bg-blue-50 text-blue-700 border border-blue-200 hover:bg-blue-600 hover:text-white'">
                                                                    <i class="ri-code-line text-[11px]"></i>
                                                                    <span x-text="block.rows[rIdx][cIdx]?.startsWith('`') && block.rows[rIdx][cIdx]?.endsWith('`') ? 'Kode Aktif' : 'Kode'"></span>
                                                                </button>
                                                            </div>
                                                            <div x-show="block.rows[rIdx][cIdx] && (block.rows[rIdx][cIdx].includes('`') || block.rows[rIdx][cIdx].includes('*'))"
                                                                 class="mt-1.5 px-2.5 py-1.5 rounded-lg bg-slate-900 border border-slate-700 text-xs markdown-content shadow-xs"
                                                                 x-html="renderInlineMarkdown(block.rows[rIdx][cIdx])">
                                                            </div>
                                                         </td>
                                                    </template>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- MODE PRATINJAU TABEL -->
                                <div x-show="tableMode === 'preview'" class="overflow-x-auto rounded-xl border border-slate-300 shadow-sm bg-[#0d1117] p-3">
                                    <table class="w-full text-left text-xs sm:text-sm text-slate-200 border-collapse">
                                        <thead class="bg-slate-800 font-semibold text-white">
                                            <tr>
                                                <template x-for="(head, cIdx) in (block.headers || [])" :key="cIdx">
                                                    <th class="px-4 py-3 border border-slate-700 markdown-content"
                                                        x-html="renderInlineMarkdown(head)"></th>
                                                </template>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template x-for="(row, rIdx) in (block.rows || [])" :key="rIdx">
                                                <tr :class="rIdx % 2 === 0 ? 'bg-[#0d1117]' : 'bg-slate-800/40'" class="hover:bg-white/5 transition-colors">
                                                    <template x-for="(cell, cIdx) in row" :key="cIdx">
                                                        <td class="px-4 py-3 leading-relaxed border border-slate-700 markdown-content"
                                                            x-html="renderInlineMarkdown(cell)"></td>
                                                    </template>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>

                                <label :for="'tabel_caption_' + i" class="sr-only">Caption Tabel</label>
                                <input :id="'tabel_caption_' + i" type="text" x-model="block.caption" placeholder="Caption tabel (opsional)"
                                       class="w-full rounded-lg border border-slate-200 bg-slate-50/50 px-3 py-1.5 text-xs text-slate-800 placeholder:text-slate-400 outline-none focus:border-accent focus:bg-white transition-all">
                            </div>
                        </template>
                    </div>

                    <div class="relative py-2 flex items-center justify-center group">
                        <div class="absolute inset-x-0 top-1/2 -translate-y-1/2 border-t border-slate-200/50"></div>
                        <div class="relative z-10 flex items-center gap-1 bg-white px-2 py-1 rounded-full border border-slate-200 shadow-sm hover:border-accent/50 transition-all">
                            <span class="text-[9px] text-slate-400 font-medium mr-0.5">Tambah:</span>
                            @if (! ($hideSubbab ?? false))
                            <button type="button" @click="addBlockAt('subbab', i + 1)"
                                    class="px-1.5 py-0.5 rounded text-[10px] font-semibold text-slate-600 hover:bg-accent/10 hover:text-accent transition-colors"
                                    title="Tambah Subbab">
                                Subbab
                            </button>
                            @endif
                            <button type="button" @click="addBlockAt('subheading', i + 1)"
                                    class="px-1.5 py-0.5 rounded text-[10px] font-semibold text-slate-600 hover:bg-accent/10 hover:text-accent transition-colors"
                                    title="Tambah Sub Heading">
                                Heading
                            </button>
                            <button type="button" @click="addBlockAt('paragraf', i + 1)"
                                    class="px-1.5 py-0.5 rounded text-[10px] font-semibold text-slate-600 hover:bg-accent/10 hover:text-accent transition-colors"
                                    title="Tambah Paragraf">
                                Paragraf
                            </button>
                            <button type="button" @click="addBlockAt('gambar', i + 1)"
                                    class="px-1.5 py-0.5 rounded text-[10px] font-semibold text-slate-600 hover:bg-accent/10 hover:text-accent transition-colors"
                                    title="Tambah Gambar">
                                Gambar
                            </button>
                            <button type="button" @click="addBlockAt('kode', i + 1)"
                                    class="px-1.5 py-0.5 rounded text-[10px] font-semibold text-slate-600 hover:bg-accent/10 hover:text-accent transition-colors"
                                    title="Tambah Kode">
                                Kode
                            </button>
                            <button type="button" @click="addBlockAt('link', i + 1)"
                                    class="px-1.5 py-0.5 rounded text-[10px] font-semibold text-slate-600 hover:bg-accent/10 hover:text-accent transition-colors"
                                    title="Tambah Link">
                                Link
                            </button>
                            <button type="button" @click="addBlockAt('pembatas', i + 1)"
                                    class="px-1.5 py-0.5 rounded text-[10px] font-semibold text-slate-600 hover:bg-accent/10 hover:text-accent transition-colors"
                                    title="Tambah Pembatas">
                                Pembatas
                            </button>
                            <button type="button" @click="addBlockAt('tabel', i + 1)"
                                    class="px-1.5 py-0.5 rounded text-[10px] font-semibold text-slate-600 hover:bg-accent/10 hover:text-accent transition-colors"
                                    title="Tambah Tabel">
                                Tabel
                            </button>
                        </div>
                    </div>
                </div>
            </template>

            <div x-show="blocks.length === 0" x-cloak class="border-2 border-dashed border-slate-200 rounded-xl p-8 text-center text-slate-400 space-y-2 mt-3">
                <div class="w-12 h-12 mx-auto rounded-xl bg-accent/10 text-accent flex items-center justify-center text-xl">
                    <i class="ri-file-text-line"></i>
                </div>
                <h4 class="font-poppins font-bold text-slate-700 text-sm">Lembar Kerja Kosong</h4>
                <p class="text-xs text-slate-400 max-w-md mx-auto">Gunakan toolbar di atas untuk menambahkan blok konten.</p>
            </div>
        </div>
    </div>
</div>