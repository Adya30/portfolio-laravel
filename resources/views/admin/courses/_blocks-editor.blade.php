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
                                        class="w-6 h-6 flex items-center justify-center rounded text-slate-500 hover:text-red-600 transition-colors"
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

                        {{-- Sub Heading 3 is indented here too, so the writer sees the
                             same hierarchy the reader will. --}}
                        <template x-if="block.type === 'subheading' || block.type === 'subheading3'">
                            <div :class="block.type === 'subheading3' && 'ml-4 border-l-2 border-blue-200 pl-3 sm:ml-6'">
                                <label :for="'subheading_teks_' + i" class="sr-only"
                                       x-text="block.type === 'subheading3' ? 'Sub Heading 3' : 'Sub Heading 2'"></label>
                                <input :id="'subheading_teks_' + i" type="text" x-model="block.teks"
                                       :placeholder="block.type === 'subheading3' ? 'Tulis sub heading tingkat 3...' : 'Tulis sub heading di sini...'"
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
                                <div class="rounded-lg border border-code-line overflow-hidden bg-code">
                                    <div class="flex items-center justify-between gap-3 px-3 py-1.5 bg-code-header border-b border-code-line">
                                        <div class="flex items-center gap-1.5">
                                            <span class="w-2 h-2 rounded-full bg-[#ff5f56]"></span>
                                            <span class="w-2 h-2 rounded-full bg-[#ffbd2e]"></span>
                                            <span class="w-2 h-2 rounded-full bg-[#27c93f]"></span>
                                        </div>
                                        <label :for="'kode_bahasa_' + i" class="sr-only">Bahasa Pemrograman</label>
                                        <select :id="'kode_bahasa_' + i" x-model="block.bahasa" data-language-select
                                                class="rounded border border-code-line bg-white/[0.06] text-code-text px-2 py-0.5 text-xs font-mono outline-none focus:border-accent">
                                            <option value="php">PHP</option>
                                            <option value="javascript">JavaScript</option>
                                            <option value="typescript">TypeScript</option>
                                            <option value="html">HTML</option>
                                            <option value="css">CSS</option>
                                            <option value="sql">SQL</option>
                                            <option value="python">Python</option>
                                            <option value="bash">Bash</option>
                                            <option value="json">JSON</option>
                                            <option value="csharp">C#</option>
                                            <option value="java">Java</option>
                                            <option value="plaintext">Plain Text</option>
                                        </select>
                                    </div>
                                    <label :for="'kode_area_' + i" class="sr-only">Tulis Kode</label>
                                    <textarea :id="'kode_area_' + i" x-model="block.kode" @keydown.tab.prevent="insertTab($event)"
                                              rows="6" placeholder="// Tulis atau tempel kode di sini..."
                                              class="w-full bg-code p-3 text-xs font-mono text-code-text placeholder:text-code-gutter outline-none focus:ring-1 focus:ring-accent/40 resize-y border-0"></textarea>
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
                                                class="focus-ring inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg border border-slate-200 bg-white text-slate-600 text-xs font-semibold hover:border-accent/40 hover:text-accent transition-colors">
                                            <i class="ri-add-line text-xs" aria-hidden="true"></i> Tambah Kolom
                                        </button>
                                        <button type="button" @click="addTableRow(i)"
                                                class="focus-ring inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg border border-slate-200 bg-white text-slate-600 text-xs font-semibold hover:border-accent/40 hover:text-accent transition-colors">
                                            <i class="ri-add-line text-xs" aria-hidden="true"></i> Tambah Baris
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


                                <div x-show="tableMode === 'edit'" class="overflow-x-auto rounded-xl border border-slate-200 bg-white shadow-xs">
                                    <table class="w-full text-left text-xs border-collapse">
                                        <thead class="bg-slate-50">
                                            <tr>
                                                <th class="p-2 w-10 text-center text-slate-400 font-bold border-b border-r border-slate-200"><span class="sr-only">Nomor baris</span>#</th>
                                                <template x-for="(head, cIdx) in (block.headers || [])" :key="cIdx">
                                                    <th class="p-2 min-w-[150px] border-b border-r border-slate-200 last:border-r-0">
                                                        <div class="flex items-center gap-1.5">
                                                            <label :for="'tabel_header_' + i + '_' + cIdx" class="sr-only">Judul Kolom</label>
                                                            <input :id="'tabel_header_' + i + '_' + cIdx" type="text" x-model="block.headers[cIdx]" placeholder="Judul kolom..."
                                                                   class="w-full rounded-lg border border-slate-200 px-2 py-1 text-xs font-bold text-slate-800 bg-white outline-none focus:border-accent focus:ring-2 focus:ring-accent/20">
                                                            <button type="button" @click="removeTableCol(i, cIdx)"
                                                                    x-show="(block.headers || []).length > 1"
                                                                    title="Hapus kolom ini" aria-label="Hapus kolom ini"
                                                                    class="focus-ring w-6 h-6 flex items-center justify-center rounded text-slate-500 hover:text-red-600 transition-colors shrink-0">
                                                                <i class="ri-close-line text-sm" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    </th>
                                                </template>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template x-for="(row, rIdx) in (block.rows || [])" :key="rIdx">
                                                <tr :class="rIdx % 2 === 0 ? 'bg-white hover:bg-blue-50/30' : 'bg-slate-50/60 hover:bg-blue-50/30'">
                                                    <td class="p-2 text-center align-top border-b border-r border-slate-200">
                                                        <div class="flex flex-col items-center justify-center gap-1 pt-1">
                                                            <span class="text-xs font-bold text-slate-400" x-text="rIdx + 1"></span>
                                                            <button type="button" @click="removeTableRow(i, rIdx)"
                                                                    title="Hapus baris ini" aria-label="Hapus baris ini"
                                                                    class="focus-ring w-5 h-5 flex items-center justify-center rounded text-slate-500 hover:text-red-600 transition-colors">
                                                                <i class="ri-delete-bin-line text-xs" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <template x-for="(cell, cIdx) in row" :key="cIdx">
                                                         <td class="p-2 align-top border-b border-r border-slate-200 last:border-r-0">
                                                            <div class="space-y-1.5">
                                                                <label :for="'tabel_cell_' + i + '_' + rIdx + '_' + cIdx" class="sr-only">Isi Sel</label>
                                                                <textarea :id="'tabel_cell_' + i + '_' + rIdx + '_' + cIdx"
                                                                          x-model="block.rows[rIdx][cIdx]"
                                                                          placeholder="Isi sel... (`kode` untuk tanda kode)"
                                                                          rows="2"
                                                                          @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'"
                                                                          class="w-full rounded-lg border border-slate-200 px-2 py-1.5 text-xs text-slate-800 bg-white outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition-all resize-none font-mono leading-relaxed"></textarea>

                                                                {{-- The code toggle sits under the field instead of
                                                                     overlapping the text it applies to. --}}
                                                                <button type="button"
                                                                        @click="wrapCellWithCode(i, rIdx, cIdx, $el.previousElementSibling)"
                                                                        :aria-pressed="isCellCode(i, rIdx, cIdx)"
                                                                        title="Bungkus isi sel dengan tanda kode (`...`)"
                                                                        class="focus-ring inline-flex items-center gap-1.5 px-2 py-1 rounded-lg border text-[11px] font-semibold transition-colors"
                                                                        :class="isCellCode(i, rIdx, cIdx)
                                                                            ? 'border-code-line bg-code text-code-text'
                                                                            : 'border-slate-200 bg-white text-code hover:border-code-line hover:bg-code hover:text-code-text'">
                                                                    <i class="text-xs" :class="isCellCode(i, rIdx, cIdx) ? 'ri-check-line' : 'ri-code-line'" aria-hidden="true"></i>
                                                                    <span x-text="isCellCode(i, rIdx, cIdx) ? 'Kode aktif' : 'Tandai kode'"></span>
                                                                </button>

                                                                <div x-show="isCellCode(i, rIdx, cIdx) || (block.rows[rIdx][cIdx] || '').includes('*')"
                                                                     class="markdown-content rounded-lg border border-slate-200 bg-slate-50 px-2.5 py-1.5 text-xs text-slate-700"
                                                                     x-html="renderInlineMarkdown(block.rows[rIdx][cIdx])"></div>
                                                            </div>
                                                         </td>
                                                    </template>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Preview uses the reader's own surface, so a code
                                     chip inside it stays readable. --}}
                                <div x-show="tableMode === 'preview'" class="overflow-x-auto rounded-xl border border-slate-300 shadow-sm bg-white p-3">
                                    <table class="w-full text-left text-xs sm:text-sm text-slate-700 border-collapse">
                                        <thead class="bg-slate-100 font-semibold text-slate-900">
                                            <tr>
                                                <template x-for="(head, cIdx) in (block.headers || [])" :key="cIdx">
                                                    <th class="px-4 py-3 border border-slate-200 markdown-content"
                                                        x-html="renderInlineMarkdown(head)"></th>
                                                </template>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template x-for="(row, rIdx) in (block.rows || [])" :key="rIdx">
                                                <tr :class="rIdx % 2 === 0 ? 'bg-white' : 'bg-slate-50/70'" class="hover:bg-blue-50/40 transition-colors">
                                                    <template x-for="(cell, cIdx) in row" :key="cIdx">
                                                        <td class="px-4 py-3 leading-relaxed border border-slate-200 markdown-content"
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

                    {{-- The palette unfolds in place rather than floating above the
                         page, so opening it never hides the block below. --}}
                    <div class="relative z-20" x-data="{ insertOpen: false }" @click.outside="insertOpen = false">
                        <div class="flex items-center gap-3 py-3">
                            <span class="h-px flex-1 bg-slate-200/70" aria-hidden="true"></span>
                            <button type="button" @click="insertOpen = !insertOpen" :aria-expanded="insertOpen"
                                    :class="insertOpen && 'border-accent/50 bg-accent/5 text-accent'"
                                    class="focus-ring inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-white px-3 py-1.5 text-[11px] font-semibold text-slate-600 transition-colors hover:border-accent/50 hover:text-accent">
                                <i class="ri-add-line text-sm transition-transform" :class="insertOpen && 'rotate-45'" aria-hidden="true"></i>
                                <span x-text="insertOpen ? 'Tutup' : 'Sisipkan blok'"></span>
                            </button>
                            <span class="h-px flex-1 bg-slate-200/70" aria-hidden="true"></span>
                        </div>

                        <div x-show="insertOpen" x-cloak x-collapse class="pb-3">
                            <div class="rounded-xl border border-slate-200 bg-slate-50/70 p-2.5">
                                <p class="px-1 pb-2 text-[10px] font-bold uppercase tracking-wider text-slate-500">Pilih jenis blok</p>
                                @include('admin.courses._block-palette', [
                                    'insertAt' => 'i + 1',
                                    'hideSubbab' => ($hideSubbab ?? false),
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            {{-- An empty sheet has no insert rows yet, so it carries its own way in. --}}
            <div x-show="blocks.length === 0" x-cloak class="border-2 border-dashed border-slate-200 rounded-xl p-8 text-center mt-3">
                <div class="w-12 h-12 mx-auto rounded-xl bg-accent/10 text-accent flex items-center justify-center text-xl">
                    <i class="ri-file-text-line" aria-hidden="true"></i>
                </div>
                <h4 class="font-poppins font-bold text-slate-700 text-sm mt-3">Lembar kerja kosong</h4>
                <p class="text-xs text-slate-500 max-w-md mx-auto mt-1">Pilih jenis blok pertama untuk mulai mengisi materi ini.</p>

                <div class="relative mt-4" x-data="{ insertOpen: false }" @click.outside="insertOpen = false">
                    <button type="button" @click="insertOpen = !insertOpen" :aria-expanded="insertOpen"
                            class="focus-ring inline-flex items-center gap-1.5 rounded-xl bg-accent px-4 py-2 text-xs font-bold text-white shadow-sm transition-colors hover:bg-blue-600">
                        <i class="ri-add-line text-sm" aria-hidden="true"></i>
                        <span x-text="insertOpen ? 'Tutup' : 'Tambah blok pertama'"></span>
                    </button>

                    <div x-show="insertOpen" x-cloak x-collapse class="mt-3 text-left">
                        <div class="rounded-xl border border-slate-200 bg-white p-2.5">
                            <p class="px-1 pb-2 text-[10px] font-bold uppercase tracking-wider text-slate-500">Pilih jenis blok</p>
                            @include('admin.courses._block-palette', [
                                'insertAt' => '0',
                                'hideSubbab' => ($hideSubbab ?? false),
                            ])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>