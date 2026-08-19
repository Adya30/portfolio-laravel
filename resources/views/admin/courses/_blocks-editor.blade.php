@php
    if (! isset($blocksValue)) {
        $blocksValue = old('konten', ($course ?? null)?->konten ?? []);
    }
    if (is_string($blocksValue)) {
        $blocksValue = json_decode($blocksValue, true) ?: [];
    }
    $blocksValue = is_array($blocksValue) ? $blocksValue : [];
@endphp

<div x-data="courseContentEditor(@js($blocksValue), @js(route('admin.courses.upload-image')))" class="space-y-6">
    <input type="hidden" name="konten" x-ref="kontenInput" value="{{ json_encode($blocksValue) }}">
    <div x-effect="$refs.kontenInput.value = JSON.stringify(blocks)"></div>

    {{-- Microsoft Word / Blogger Document Worksheet Paper --}}
    <div class="bg-white border border-slate-300 rounded-2xl shadow-xl p-6 sm:p-10 max-w-4xl mx-auto space-y-5 min-h-[550px] relative">
        {{-- Paper Top Ruler Line --}}
        <div class="border-b-2 border-dashed border-slate-200 pb-3 flex items-center justify-between text-xs text-slate-400 font-mono select-none">
            <span>Halaman Materi</span>
        </div>

        <div class="flex flex-wrap items-center gap-2 -mt-2">
            <div class="relative" x-data="{ blockMenuOpen: false }">
                <button type="button" @click="blockMenuOpen = !blockMenuOpen"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-accent text-white text-xs font-bold hover:bg-blue-600 transition-colors">
                    <i class="ri-add-line text-sm"></i> Tambah Blok
                    <i class="ri-arrow-down-s-line text-sm transition-transform" :class="blockMenuOpen && 'rotate-180'"></i>
                </button>
                <div x-show="blockMenuOpen" x-cloak @click.outside="blockMenuOpen = false"
                     class="absolute left-0 top-full mt-1.5 z-20 w-48 bg-white border border-slate-200 rounded-xl shadow-lg p-1.5 space-y-0.5">
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

        <template x-for="(block, i) in blocks" :key="i">
            <div class="group relative">

                <div :id="'blok-' + i"
                     draggable="true"
                     @dragstart="dragStart(i, $event)"
                     @dragover="dragOver(i, $event)"
                     @drop="dropBlock(i, $event)"
                     @dragend="dragEnd"
                     :class="draggedIndex === i ? 'opacity-40 border-dashed border-accent' : 'border-slate-200/90'"
                     class="bg-white border rounded-2xl p-4 sm:p-5 shadow-sm space-y-3 transition-all hover:border-accent/40">

                    {{-- Element Header & Actions --}}
                    <div class="flex items-center justify-between gap-3 border-b border-slate-100 pb-2.5">
                        <div class="flex items-center gap-2">
                            <span class="cursor-grab active:cursor-grabbing text-slate-400 hover:text-slate-700 transition-colors p-1"
                                  title="Tahan & geser untuk memindahkan posisi elemen ini">
                                <i class="ri-drag-move-2-line text-base"></i>
                            </span>
                            <span class="text-[11px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-lg bg-slate-100 text-slate-700 border border-slate-200"
                                  x-text="blockLabel(block.type)"></span>
                            <span class="text-xs text-slate-400 font-semibold">#<span x-text="i + 1"></span></span>
                        </div>

                        <div class="flex items-center gap-1">
                            <button type="button" @click="moveBlock(i, -1)"
                                    class="w-7 h-7 flex items-center justify-center rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors cursor-pointer" title="Naik">
                                <i class="ri-arrow-up-line text-sm"></i>
                            </button>
                            <button type="button" @click="moveBlock(i, 1)"
                                    class="w-7 h-7 flex items-center justify-center rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors cursor-pointer" title="Turun">
                                <i class="ri-arrow-down-line text-sm"></i>
                            </button>
                            <button type="button" @click="removeBlock(i)"
                                    @if ($hideSubbab ?? false) x-show="!(i === 0 && block.type === 'subbab')" @endif
                                    class="w-7 h-7 flex items-center justify-center rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 transition-colors cursor-pointer" title="Hapus">
                                <i class="ri-delete-bin-line text-sm"></i>
                            </button>
                        </div>
                    </div>

                    {{-- 1. Subbab / Heading --}}
                    <template x-if="block.type === 'subbab'">
                        <div class="pt-1">
                            <label class="block text-xs font-bold text-slate-500 mb-1.5">Judul Subbab (Subjudul Utama)</label>
                            <input type="text" x-model="block.judul" placeholder="Tulis judul subbab di sini..."
                                   class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-base font-poppins font-bold text-slate-800 placeholder:text-slate-400 outline-none focus:border-accent focus:bg-white focus:ring-4 focus:ring-accent/15 transition-all">
                        </div>
                    </template>

                    {{-- 1b. Sub Heading --}}
                    <template x-if="block.type === 'subheading'">
                        <div class="pt-1">
                            <label class="block text-xs font-bold text-slate-500 mb-1.5">Sub Heading (Judul Bagian)</label>
                            <input type="text" x-model="block.teks" placeholder="Tulis sub heading di sini..."
                                   class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm font-poppins font-semibold text-slate-800 placeholder:text-slate-400 outline-none focus:border-accent focus:bg-white focus:ring-4 focus:ring-accent/15 transition-all">
                            <p class="text-[11px] text-slate-400 mt-1">Judul bagian di dalam subbab. Tampil sebagai heading kecil di antara paragraf.</p>
                        </div>
                    </template>

                    {{-- 2. Paragraf / Text Block with Formatting Bar --}}
                    <template x-if="block.type === 'paragraf'">
                        <div class="paragraf-block pt-1 space-y-2">
                            <div class="flex items-center justify-between">
                                <label class="block text-xs font-bold text-slate-500">Isi Paragraf / Penjelasan Dokumen</label>

                                <div class="flex items-center gap-1">
                                    {{-- Alignment Buttons --}}
                                    <div class="flex items-center gap-0.5 bg-slate-100 p-1 rounded-lg border border-slate-200 text-xs mr-1">
                                        <button type="button" @click="block.align = 'kiri'"
                                                :class="block.align === 'kiri' ? 'bg-white text-accent shadow-sm' : 'text-slate-500 hover:bg-white'"
                                                class="px-2 py-0.5 rounded" title="Rata Kiri">
                                            <i class="ri-align-left"></i>
                                        </button>
                                        <button type="button" @click="block.align = 'tengah'"
                                                :class="block.align === 'tengah' ? 'bg-white text-accent shadow-sm' : 'text-slate-500 hover:bg-white'"
                                                class="px-2 py-0.5 rounded" title="Rata Tengah">
                                            <i class="ri-align-center"></i>
                                        </button>
                                        <button type="button" @click="block.align = 'kanan'"
                                                :class="block.align === 'kanan' ? 'bg-white text-accent shadow-sm' : 'text-slate-500 hover:bg-white'"
                                                class="px-2 py-0.5 rounded" title="Rata Kanan">
                                            <i class="ri-align-right"></i>
                                        </button>
                                        <button type="button" @click="block.align = 'justify'"
                                                :class="block.align === 'justify' ? 'bg-white text-accent shadow-sm' : 'text-slate-500 hover:bg-white'"
                                                class="px-2 py-0.5 rounded" title="Rata Kiri Kanan (Justify)">
                                            <i class="ri-align-justify"></i>
                                        </button>
                                    </div>

                                    {{-- Mini Text Formatting Toolbar --}}
                                    <div class="flex items-center gap-1 bg-slate-100 p-1 rounded-lg border border-slate-200 text-xs">
                                        <button type="button" @click="applyFormat(i, 'bold', $event.currentTarget)" class="px-2 py-0.5 font-bold hover:bg-white rounded" title="Tebal (Bold)">B</button>
                                        <button type="button" @click="applyFormat(i, 'italic', $event.currentTarget)" class="px-2 py-0.5 italic hover:bg-white rounded" title="Miring (Italic)">I</button>
                                        <button type="button" @click="applyFormat(i, 'underline', $event.currentTarget)" class="px-2 py-0.5 underline hover:bg-white rounded" title="Garis Bawah">U</button>
                                        <button type="button" @click="applyFormat(i, 'bullet', $event.currentTarget)" class="px-2 py-0.5 hover:bg-white rounded" title="Daftar Bullet">• List</button>
                                        <button type="button" @click="applyFormat(i, 'number', $event.currentTarget)" class="px-2 py-0.5 hover:bg-white rounded" title="Daftar Angka">1. List</button>
                                        <button type="button" @click="applyFormat(i, 'quote', $event.currentTarget)" class="px-2 py-0.5 hover:bg-white rounded" title="Kutipan">” Quote</button>
                                    </div>
                                </div>
                            </div>
                            <textarea x-model="block.teks"
                                      @paste="handleSmartPaste(i, $event)"
                                      rows="5" placeholder="Tulis isi paragraf / penjelasan di lembar kerja ini..."
                                      class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-3 text-sm text-slate-800 leading-relaxed placeholder:text-slate-400 outline-none focus:border-accent focus:bg-white focus:ring-4 focus:ring-accent/15 transition-all"></textarea>
                            <div class="flex items-center justify-between text-[11px] text-slate-400 pt-0.5">
                                <span class="flex items-center gap-1 text-accent font-medium">
                                    <i class="ri-magic-line"></i> Smart Copas Aktif (otomatis rapikan format list, bold, miring, quote, & tabel)
                                </span>
                            </div>
                        </div>
                    </template>

                    {{-- 3. Gambar / Image Upload --}}
                    <template x-if="block.type === 'gambar'">
                        <div class="space-y-4 pt-1">
                            <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-100 pb-2">
                                <label class="block text-xs font-bold text-slate-500">Gambar Ilustrasi Dokumen</label>
                                <div class="flex items-center gap-2">
                                    <label class="text-xs font-semibold text-slate-600">Ukuran Tampilan Gambar:</label>
                                    <select x-model="block.ukuran"
                                            class="rounded-xl border border-slate-200 bg-white px-3 py-1 text-xs font-semibold text-slate-800 outline-none focus:border-accent shadow-2xs">
                                        <option value="penuh">Penuh / Max (100%)</option>
                                        <option value="besar">Besar (75%)</option>
                                        <option value="sedang">Sedang (50%)</option>
                                        <option value="kecil">Kecil / Ringkas (25%)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row items-start gap-4">
                                <div class="w-full sm:w-48 h-32 rounded-2xl border border-slate-200 bg-slate-50 flex items-center justify-center overflow-hidden shrink-0 shadow-inner relative">
                                    <template x-if="block.url">
                                        <img :src="block.url" alt="Pratinjau gambar" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!block.url">
                                        <div class="text-center p-3 text-slate-400">
                                            <i class="ri-image-add-line text-3xl block mb-1 text-slate-300"></i>
                                            <span class="text-[11px]">Belum ada gambar</span>
                                        </div>
                                    </template>
                                </div>

                                <div class="flex-1 min-w-0 space-y-3 w-full">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-1">Unggah dari Komputer (Khusus WebP atau SVG)</label>
                                        <input type="file" accept=".webp,.svg,image/webp,image/svg+xml"
                                               @change="uploadImage(i, $event.target.files[0])"
                                               class="block w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-accent/10 file:text-xs file:font-bold file:text-accent hover:file:bg-accent/20 cursor-pointer">
                                        <p x-show="uploadingIndex === i" x-cloak class="text-xs text-accent font-semibold mt-1">
                                            <i class="ri-loader-4-line animate-spin"></i> Mengunggah gambar...
                                        </p>
                                        <p x-show="uploadError" x-cloak class="text-xs text-red-500 font-medium mt-1" x-text="uploadError"></p>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-slate-600 mb-1">Atau Tempel URL Gambar</label>
                                        <input type="text" x-model="block.url" placeholder="https://..."
                                               class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2 text-xs text-slate-800 placeholder:text-slate-400 outline-none focus:border-accent focus:bg-white transition-all">
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Caption / Keterangan Gambar (Opsional)</label>
                                <input type="text" x-model="block.caption" placeholder="Contoh: Ilustrasi alur kerja controller dan model di Laravel"
                                       class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2 text-xs text-slate-800 placeholder:text-slate-400 outline-none focus:border-accent focus:bg-white transition-all">
                            </div>
                        </div>
                    </template>

                    {{-- 4. Kode / Code Block --}}
                    <template x-if="block.type === 'kode'">
                        <div class="pt-1">
                            <div class="rounded-2xl border border-slate-700 overflow-hidden bg-[#0d1117] shadow-md">
                                <div class="flex items-center justify-between gap-3 px-4 py-2.5 bg-[#161b22] border-b border-slate-800">
                                    <div class="flex items-center gap-2">
                                        <div class="flex items-center gap-1.5">
                                            <span class="w-2.5 h-2.5 rounded-full bg-[#ff5f56]"></span>
                                            <span class="w-2.5 h-2.5 rounded-full bg-[#ffbd2e]"></span>
                                            <span class="w-2.5 h-2.5 rounded-full bg-[#27c93f]"></span>
                                        </div>
                                        <span class="text-[11px] font-mono text-slate-400 font-bold uppercase tracking-wider ml-1">Editor Kode Snippet (VS Code Dark Theme)</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <label class="text-[11px] font-medium text-slate-400">Bahasa:</label>
                                        <select x-model="block.bahasa"
                                                class="rounded-lg border border-slate-700 bg-slate-800 text-slate-200 px-2.5 py-1 text-xs font-mono outline-none focus:border-accent">
                                            <option value="php">PHP</option>
                                            <option value="javascript">JavaScript</option>
                                            <option value="typescript">TypeScript</option>
                                            <option value="html">HTML</option>
                                            <option value="css">CSS</option>
                                            <option value="sql">SQL</option>
                                            <option value="python">Python</option>
                                            <option value="bash">Bash / Shell</option>
                                            <option value="json">JSON</option>
                                            <option value="csharp">C#</option>
                                            <option value="java">Java</option>
                                            <option value="plaintext">Plain Text</option>
                                        </select>
                                    </div>
                                </div>
                                <textarea x-model="block.kode"
                                          @keydown.tab.prevent="insertTab($event)"
                                          rows="8"
                                          placeholder="// Tulis atau tempel contoh kode di sini (Tekan Tab untuk mentab/indentasi)..."
                                          class="w-full bg-[#0d1117] p-4 text-xs sm:text-sm font-mono text-slate-100 placeholder:text-slate-600 outline-none focus:ring-1 focus:ring-accent/40 tab-size-4 leading-relaxed whitespace-pre overflow-x-auto custom-scrollbar border-0 resize-y"></textarea>
                            </div>
                        </div>
                    </template>
                    {{-- 5. Link / Sisipan Link --}}
                    <template x-if="block.type === 'link'">
                        <div class="pt-1 space-y-3">
                            <label class="block text-xs font-bold text-slate-500 mb-1">Sisipan Link / Referensi</label>
                            <div class="space-y-2">
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-500 mb-1">URL / Tautan</label>
                                    <input type="url" x-model="block.href" placeholder="https://contoh.com/halaman"
                                           class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 outline-none focus:border-accent focus:bg-white focus:ring-4 focus:ring-accent/15 transition-all">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-500 mb-1">Label Tombol / Teks Anchor</label>
                                    <input type="text" x-model="block.label" placeholder="Contoh: Lihat Dokumentasi Resmi Laravel"
                                           class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 outline-none focus:border-accent focus:bg-white focus:ring-4 focus:ring-accent/15 transition-all">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-500 mb-1">Deskripsi Singkat (Opsional)</label>
                                    <input type="text" x-model="block.desc" placeholder="Contoh: Referensi untuk mempelajari lebih lanjut tentang Eloquent ORM"
                                           class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 outline-none focus:border-accent focus:bg-white focus:ring-4 focus:ring-accent/15 transition-all">
                                </div>
                            </div>
                            {{-- Live Preview --}}
                            <div class="mt-2 rounded-xl border border-accent/30 bg-accent/5 p-3.5 flex items-start gap-3">
                                <div class="shrink-0 w-8 h-8 rounded-lg bg-accent/15 text-accent flex items-center justify-center mt-0.5">
                                    <i class="ri-external-link-line text-base"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-accent truncate" x-text="block.label || 'Label Link (belum diisi)'"></p>
                                    <p class="text-xs text-slate-500 truncate mt-0.5" x-text="block.href || 'https://...' "></p>
                                    <p class="text-xs text-slate-400 mt-1" x-show="block.desc" x-text="block.desc"></p>
                                </div>
                            </div>
                        </div>
                    </template>

                    {{-- 6. Pembatas / Separator --}}
                    <template x-if="block.type === 'pembatas'">
                        <div class="pt-1 space-y-3">
                            <label class="block text-xs font-bold text-slate-500 mb-1">Pembatas / Pemisah Konten</label>
                            <div class="flex items-center gap-3">
                                <label class="text-xs font-semibold text-slate-600">Gaya Pembatas:</label>
                                <select x-model="block.style"
                                        class="rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-800 outline-none focus:border-accent shadow-2xs">
                                    <option value="garis">Garis Tipis</option>
                                    <option value="garis-tebal">Garis Tebal</option>
                                    <option value="dots">Titik-Titik (· · ·)</option>
                                    <option value="spasi">Spasi Kosong</option>
                                </select>
                            </div>
                            {{-- Preview --}}
                            <div class="py-3">
                                <template x-if="block.style === 'garis'">
                                    <hr class="border-slate-300">
                                </template>
                                <template x-if="block.style === 'garis-tebal'">
                                    <hr class="border-2 border-slate-400 rounded">
                                </template>
                                <template x-if="block.style === 'dots'">
                                    <div class="text-center text-slate-400 text-lg tracking-[0.5em] select-none">· · ·</div>
                                </template>
                                <template x-if="block.style === 'spasi'">
                                    <div class="h-8 rounded-lg border border-dashed border-slate-200 bg-slate-50 flex items-center justify-center">
                                        <span class="text-[10px] text-slate-300 select-none">SPASI KOSONG</span>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>

                    {{-- 7. Tabel / Table Data --}}
                    <template x-if="block.type === 'tabel'">
                        <div class="pt-1 space-y-4">
                            <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-100 pb-2">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500">Editor Tabel Data Dokumen</label>
                                    <p class="text-[11px] text-slate-400">Atur kolom & baris tabel. Teks sel mendukung format Markdown.</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button type="button" @click="addTableCol(i)"
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-100 border border-slate-200 text-slate-700 text-xs font-bold hover:bg-slate-200 transition-colors">
                                        <i class="ri-add-line"></i> Kolom
                                    </button>
                                    <button type="button" @click="addTableRow(i)"
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-accent/10 border border-accent/20 text-accent text-xs font-bold hover:bg-accent/20 transition-colors">
                                        <i class="ri-add-line"></i> Baris
                                    </button>
                                </div>
                            </div>

                            <div class="overflow-x-auto border border-slate-200 rounded-xl bg-white shadow-2xs">
                                <table class="w-full text-left text-xs">
                                    <thead class="bg-slate-50 border-b border-slate-200">
                                        <tr>
                                            <th class="p-2 w-10 text-center text-slate-400">#</th>
                                            <template x-for="(head, cIdx) in (block.headers || [])" :key="cIdx">
                                                <th class="p-2 min-w-[140px]">
                                                    <div class="flex items-center justify-between gap-1">
                                                        <input type="text" x-model="block.headers[cIdx]" placeholder="Judul Kolom..."
                                                               class="w-full rounded-lg border border-slate-300 px-2 py-1 text-xs font-bold text-slate-800 bg-white outline-none focus:border-accent">
                                                        <button type="button" @click="removeTableCol(i, cIdx)"
                                                                x-show="(block.headers || []).length > 1"
                                                                class="text-slate-400 hover:text-red-500 p-0.5" title="Hapus Kolom Ini">
                                                            <i class="ri-close-circle-line text-sm"></i>
                                                        </button>
                                                    </div>
                                                </th>
                                            </template>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        <template x-for="(row, rIdx) in (block.rows || [])" :key="rIdx">
                                            <tr class="hover:bg-slate-50/50 transition-colors">
                                                <td class="p-2 text-center text-slate-400 font-bold text-[10px]">
                                                    <div class="flex items-center justify-center gap-1">
                                                        <span x-text="rIdx + 1"></span>
                                                        <button type="button" @click="removeTableRow(i, rIdx)"
                                                                class="text-slate-400 hover:text-red-500" title="Hapus Baris Ini">
                                                            <i class="ri-delete-bin-line text-xs"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                                <template x-for="(cell, cIdx) in row" :key="cIdx">
                                                    <td class="p-2">
                                                        <input type="text" x-model="block.rows[rIdx][cIdx]" placeholder="Isi sel..."
                                                               class="w-full rounded-lg border border-slate-200 px-2 py-1 text-xs text-slate-700 bg-slate-50/50 outline-none focus:bg-white focus:border-accent transition-all">
                                                    </td>
                                                </template>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Keterangan / Caption Tabel (Opsional)</label>
                                <input type="text" x-model="block.caption" placeholder="Contoh: Tabel perbandingan fitur role pengguna"
                                       class="w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2 text-xs text-slate-800 placeholder:text-slate-400 outline-none focus:border-accent focus:bg-white transition-all">
                            </div>
                        </div>
                    </template>
                </div>

                {{-- In-Between Quick Insert Bar (shows on hover) --}}
                <div class="py-2 flex items-center justify-center opacity-0 group-hover:opacity-100 focus-within:opacity-100 transition-opacity">
                    <div class="inline-flex items-center gap-1 bg-white border border-slate-300 rounded-full px-3 py-1 shadow-md text-xs font-bold text-slate-700">
                        <span class="text-[10px] text-slate-400 mr-1 uppercase">Sisipkan di sini:</span>
                        @if (! ($hideSubbab ?? false))
                        <button type="button" @click="addBlockAt('subbab', i + 1)" class="px-2 py-0.5 rounded-md hover:bg-slate-100 hover:text-accent transition-colors">+ Subbab</button>
                        @endif
                        <button type="button" @click="addBlockAt('subheading', i + 1)" class="px-2 py-0.5 rounded-md hover:bg-slate-100 hover:text-accent transition-colors">+ Sub Heading</button>
                        <button type="button" @click="addBlockAt('paragraf', i + 1)" class="px-2 py-0.5 rounded-md hover:bg-slate-100 hover:text-accent transition-colors">+ Paragraf</button>
                        <button type="button" @click="addBlockAt('gambar', i + 1)" class="px-2 py-0.5 rounded-md hover:bg-slate-100 hover:text-accent transition-colors">+ Gambar</button>
                        <button type="button" @click="addBlockAt('kode', i + 1)" class="px-2 py-0.5 rounded-md hover:bg-slate-100 hover:text-accent transition-colors">+ Kode</button>
                        <button type="button" @click="addBlockAt('link', i + 1)" class="px-2 py-0.5 rounded-md hover:bg-slate-100 hover:text-accent transition-colors">+ Link</button>
                        <button type="button" @click="addBlockAt('pembatas', i + 1)" class="px-2 py-0.5 rounded-md hover:bg-slate-100 hover:text-accent transition-colors">+ Pembatas</button>
                        <button type="button" @click="addBlockAt('tabel', i + 1)" class="px-2 py-0.5 rounded-md hover:bg-slate-100 hover:text-accent transition-colors">+ Tabel</button>
                    </div>
                </div>
            </div>
        </template>

        {{-- Empty Lembar Kerja State --}}
        <div x-show="blocks.length === 0" x-cloak
             class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl p-12 text-center text-slate-400 space-y-3">
            <div class="w-14 h-14 mx-auto rounded-2xl bg-accent/10 text-accent flex items-center justify-center text-2xl">
                <i class="ri-file-text-line"></i>
            </div>
            <h4 class="font-poppins font-bold text-slate-700 text-base">Lembar Kerja Dokumen Kosong</h4>
            <p class="text-xs text-slate-400 max-w-md mx-auto">
                Gunakan toolbar di atas untuk menyisipkan subbab, teks penjelasan, gambar ilustrasi, atau contoh kode berwarna ke dalam lembar kerja.
            </p>
            <div class="pt-2 flex flex-wrap items-center justify-center gap-2">
                @if (! ($hideSubbab ?? false))
                <button type="button" @click="addBlock('subbab')" class="px-3 py-1.5 rounded-xl bg-accent text-white text-xs font-bold hover:bg-blue-600 transition-colors">+ Subbab</button>
                @endif
                <button type="button" @click="addBlock('subheading')" class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-bold hover:bg-slate-100 transition-colors">+ Sub Heading</button>
                <button type="button" @click="addBlock('paragraf')" class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-bold hover:bg-slate-100 transition-colors">+ Paragraf</button>
                <button type="button" @click="addBlock('gambar')" class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-bold hover:bg-slate-100 transition-colors">+ Gambar</button>
                <button type="button" @click="addBlock('kode')" class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-bold hover:bg-slate-100 transition-colors">+ Kode</button>
                <button type="button" @click="addBlock('link')" class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-bold hover:bg-slate-100 transition-colors">+ Link</button>
                <button type="button" @click="addBlock('pembatas')" class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-bold hover:bg-slate-100 transition-colors">+ Pembatas</button>
                <button type="button" @click="addBlock('tabel')" class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-bold hover:bg-slate-100 transition-colors">+ Tabel</button>
            </div>
        </div>
    </div>
</div>
