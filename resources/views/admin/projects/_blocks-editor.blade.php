@php
    if (old('blocks_data')) {
        $decoded = json_decode(old('blocks_data'), true);
        if (is_array($decoded) && !empty($decoded)) {
            $blocksValue = $decoded;
        }
    }
    $blocksValue = is_array($blocksValue ?? null) ? $blocksValue : [];
    if (empty($blocksValue)) {
        $blocksValue = [
            [
                'type' => 'paragraf',
                'teks' => '',
                'teks_idn' => '',
                'align' => 'kiri',
            ],
        ];
    }
    $autosaveKey = $autosaveKey ?? ('autosave_project_' . (($project ?? null)?->id ?? 'new'));
    $uploadUrl = $uploadUrl ?? route('admin.projects.upload-image');
@endphp

<div x-data="courseContentEditor(@js($blocksValue), @js($uploadUrl), @js($autosaveKey))" class="space-y-4">
    {{-- Hidden inputs yang disinkronkan otomatis untuk disimpan ke database --}}
    <input type="hidden" name="konten" x-ref="kontenInput" value="{{ json_encode($blocksValue) }}">
    <input type="hidden" name="konten_idn" x-ref="kontenIdnInput" value="{{ json_encode($blocksValue) }}">
    <input type="hidden" name="blocks_data" x-ref="blocksDataInput" value="{{ json_encode($blocksValue) }}">
    <div x-effect="
        if ($refs.kontenInput) $refs.kontenInput.value = serializeEnBlocks(blocks);
        if ($refs.kontenIdnInput) $refs.kontenIdnInput.value = serializeIdnBlocks(blocks);
        if ($refs.blocksDataInput) $refs.blocksDataInput.value = JSON.stringify(blocks);
    "></div>

    <div class="bg-white dark:bg-[#162032] p-5 sm:p-6 w-full relative">
        {{-- Toolbar Atas: Status Bahasa Aktif, Undo / Redo & Status Autosave --}}
        <div class="border-b border-slate-200 dark:border-white/10 pb-3 flex flex-wrap items-center justify-between gap-2 text-xs text-slate-400 select-none">
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold transition-all"
                      :class="langTab === 'en' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300' : 'bg-orange-100 text-orange-700 dark:bg-orange-900/40 dark:text-orange-300'">
                    <i :class="langTab === 'en' ? 'ri-global-line' : 'ri-translate-2'"></i>
                    <span x-text="langTab === 'en' ? 'Mengedit: English' : 'Mengedit: Indonesia'"></span>
                </span>
                <span class="text-slate-300 dark:text-slate-600">|</span>
                <div class="flex items-center gap-1 font-sans">
                    <button type="button" @click="undo()" :disabled="!canUndo()"
                            :class="canUndo() ? 'text-slate-600 hover:text-accent hover:bg-slate-100 cursor-pointer shadow-2xs bg-white border border-slate-200 dark:bg-white/5 dark:border-white/10 dark:text-slate-300' : 'text-slate-300 cursor-not-allowed opacity-40 bg-slate-50 border border-slate-100 dark:bg-white/5 dark:border-white/5 dark:text-slate-600'"
                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-semibold transition-all"
                            title="Undo perubahan (Ctrl+Z)">
                        <i class="ri-arrow-go-back-line text-sm"></i>
                        <span class="hidden sm:inline">Undo</span>
                    </button>
                    <button type="button" @click="redo()" :disabled="!canRedo()"
                            :class="canRedo() ? 'text-slate-600 hover:text-accent hover:bg-slate-100 cursor-pointer shadow-2xs bg-white border border-slate-200 dark:bg-white/5 dark:border-white/10 dark:text-slate-300' : 'text-slate-300 cursor-not-allowed opacity-40 bg-slate-50 border border-slate-100 dark:bg-white/5 dark:border-white/5 dark:text-slate-600'"
                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-semibold transition-all"
                            title="Redo perubahan (Ctrl+Y / Ctrl+Shift+Z)">
                        <i class="ri-arrow-go-forward-line text-sm"></i>
                        <span class="hidden sm:inline">Redo</span>
                    </button>
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                <span class="text-[11px] text-slate-500 dark:text-slate-400 font-mono" x-text="blocks.length + ' blok terdaftar'"></span>
                <span x-show="autosaveStatus === 'saved'"
                      x-transition:enter="transition ease-out duration-300"
                      x-transition:enter-start="opacity-0 translate-y-1"
                      x-transition:enter-end="opacity-100 translate-y-0"
                      x-transition:leave="transition ease-in duration-200"
                      x-transition:leave-start="opacity-100"
                      x-transition:leave-end="opacity-0"
                      x-cloak
                      class="flex items-center gap-1 text-emerald-500 font-semibold text-[11px]">
                    <i class="ri-checkbox-circle-fill"></i> Draft tersimpan
                </span>
            </div>
        </div>

        {{-- Daftar Blok Konten (Satu Daftar Sinkron untuk English & Indonesia) --}}
        <div class="min-h-[280px] pt-2">
            <template x-for="(block, i) in blocks" :key="i">
                <div>
                    <div :id="'blok-' + i"
                         :draggable="true"
                         @dragstart="dragStart(i, $event)"
                         @dragover="dragOver(i, $event)"
                         @drop="dropBlock(i, $event)"
                         @dragend="dragEnd"
                         :class="draggedIndex === i ? 'opacity-40' : ''"
                         class="py-3 px-3 my-2 rounded-xl border border-slate-200/80 dark:border-white/10 bg-slate-50/60 dark:bg-white/[0.02] hover:bg-slate-50 dark:hover:bg-white/[0.04] transition-all">

                        {{-- Baris Header Blok --}}
                        <div class="flex items-center justify-between gap-3 mb-2.5">
                            <div class="flex items-center gap-2">
                                <span class="cursor-grab active:cursor-grabbing text-slate-400 hover:text-slate-600 p-0.5"
                                      title="Tahan & geser untuk memindahkan posisi">
                                    <i class="ri-drag-move-2-line text-sm"></i>
                                </span>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-[11px] font-bold uppercase tracking-wider"
                                      :class="{
                                          'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300': block.type === 'paragraf',
                                          'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300': block.type === 'gambar',
                                          'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300': block.type === 'kode',
                                          'bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300': block.type === 'link',
                                      }">
                                    <i :class="{
                                        'ri-paragraph': block.type === 'paragraf',
                                        'ri-image-line': block.type === 'gambar',
                                        'ri-code-box-line': block.type === 'kode',
                                        'ri-external-link-line': block.type === 'link',
                                    }" class="text-xs"></i>
                                    <span x-text="block.type === 'paragraf' ? 'Paragraf' : (block.type === 'gambar' ? 'Gambar' : (block.type === 'kode' ? 'Kode' : 'Link'))"></span>
                                </span>
                                <span class="text-xs text-slate-400 font-mono" x-text="'#' + (i + 1)"></span>
                            </div>

                            <div class="flex items-center gap-0.5">
                                <button type="button" @click="moveBlock(i, -1)" :disabled="i === 0"
                                        :class="i === 0 ? 'opacity-30 cursor-not-allowed' : 'hover:text-slate-700 hover:bg-slate-200/70 text-slate-500'"
                                        class="w-6 h-6 flex items-center justify-center rounded transition-colors cursor-pointer"
                                        title="Pindah ke atas">
                                    <i class="ri-arrow-up-line text-xs"></i>
                                </button>
                                <button type="button" @click="moveBlock(i, 1)" :disabled="i >= blocks.length - 1"
                                        :class="i >= blocks.length - 1 ? 'opacity-30 cursor-not-allowed' : 'hover:text-slate-700 hover:bg-slate-200/70 text-slate-500'"
                                        class="w-6 h-6 flex items-center justify-center rounded transition-colors cursor-pointer"
                                        title="Pindah ke bawah">
                                    <i class="ri-arrow-down-line text-xs"></i>
                                </button>
                                <button type="button" @click="removeBlock(i)"
                                        class="w-6 h-6 flex items-center justify-center rounded text-slate-400 hover:text-red-600 transition-colors cursor-pointer"
                                        title="Hapus blok">
                                    <i class="ri-delete-bin-line text-xs"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Blok Paragraf --}}
                        <template x-if="block.type === 'paragraf'">
                            <div class="space-y-2">
                                {{-- Tab English Editor --}}
                                <div x-show="langTab === 'en'">
                                    <div class="flex items-center justify-between text-[11px] font-semibold text-slate-500 mb-1">
                                        <span class="flex items-center gap-1.5 text-blue-600 dark:text-blue-400">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                            Isi Paragraf (English)
                                        </span>
                                    </div>
                                    <div x-data="quillParagraphEditor(block, i, 'teks')" class="space-y-1">
                                        <div x-ref="quillBox" class="bg-white dark:bg-[#0c1322] rounded-xl overflow-hidden border border-slate-200 dark:border-white/10"></div>
                                    </div>
                                </div>

                                {{-- Tab Indonesia Editor --}}
                                <div x-show="langTab === 'id'">
                                    <div class="flex items-center justify-between text-[11px] font-semibold text-slate-500 mb-1">
                                        <span class="flex items-center gap-1.5 text-orange-600 dark:text-orange-400">
                                            <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>
                                            Isi Paragraf (Indonesia)
                                        </span>
                                        <button type="button" @click="copyTeksFromEn(block, i)"
                                                class="text-[11px] text-accent hover:underline inline-flex items-center gap-1 font-medium cursor-pointer"
                                                title="Salin teks dari versi English untuk diterjemahkan">
                                            <i class="ri-file-copy-line"></i> Salin dari English
                                        </button>
                                    </div>
                                    <div x-data="quillParagraphEditor(block, i, 'teks_idn')" class="space-y-1">
                                        <div x-ref="quillBox" class="bg-white dark:bg-[#0c1322] rounded-xl overflow-hidden border border-slate-200 dark:border-white/10"></div>
                                    </div>
                                </div>
                            </div>
                        </template>

                        {{-- Blok Gambar --}}
                        <template x-if="block.type === 'gambar'">
                            <div class="space-y-2.5">
                                <div class="flex flex-wrap items-center gap-2">
                                    <label :for="'gambar_ukuran_' + i" class="text-xs font-semibold text-slate-600 dark:text-slate-400">Ukuran Tampil:</label>
                                    <select :id="'gambar_ukuran_' + i" x-model="block.ukuran"
                                            class="rounded-lg border border-slate-200 dark:border-white/10 bg-white dark:bg-[#162032] px-2.5 py-1 text-xs font-semibold text-slate-800 dark:text-slate-200 outline-none focus:border-accent">
                                        <option value="penuh">Penuh (100%)</option>
                                        <option value="besar">Besar (Max-width besar)</option>
                                        <option value="sedang">Sedang (Proporsional)</option>
                                        <option value="kecil">Kecil (Thumbnail)</option>
                                    </select>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-24 h-20 rounded-xl border border-slate-200 dark:border-white/10 bg-white dark:bg-[#0c1322] flex items-center justify-center overflow-hidden shrink-0 shadow-2xs">
                                        <template x-if="block.url">
                                            <img :src="block.url" alt="Pratinjau" class="w-full h-full object-cover">
                                        </template>
                                        <template x-if="!block.url">
                                            <i class="ri-image-add-line text-2xl text-slate-300"></i>
                                        </template>
                                    </div>
                                    <div class="flex-1 min-w-0 space-y-1.5">
                                        <label :for="'gambar_file_' + i" class="sr-only">Upload File Gambar</label>
                                        <input :id="'gambar_file_' + i" type="file" accept=".svg,.png,.jpg,.jpeg,.webp,image/svg+xml,image/png,image/jpeg,image/webp"
                                               @change="uploadImage(i, $event.target.files[0])"
                                               class="block w-full text-xs text-slate-600 dark:text-slate-300 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-accent file:text-xs file:font-bold file:text-white hover:file:bg-blue-600 cursor-pointer">
                                        <p x-show="uploadingIndex === i" x-cloak class="text-xs text-accent font-semibold">
                                            <i class="ri-loader-4-line animate-spin"></i> Mengunggah gambar...
                                        </p>
                                        <label :for="'gambar_url_' + i" class="sr-only">URL Gambar</label>
                                        <input :id="'gambar_url_' + i" type="text" x-model="block.url" placeholder="Atau tempel URL gambar eksternal di sini..."
                                               class="w-full rounded-lg border border-slate-200 dark:border-white/10 bg-white dark:bg-[#162032] px-3 py-1.5 text-xs text-slate-800 dark:text-slate-200 placeholder:text-slate-400 outline-none focus:border-accent transition-all">
                                    </div>
                                </div>

                                {{-- Caption English --}}
                                <div x-show="langTab === 'en'">
                                    <label :for="'gambar_caption_en_' + i" class="block text-[11px] font-semibold text-slate-600 dark:text-slate-400 mb-1">Caption Gambar (English)</label>
                                    <input :id="'gambar_caption_en_' + i" type="text" x-model="block.caption" placeholder="Caption / image description (English, opsional)..."
                                           class="w-full rounded-lg border border-slate-200 dark:border-white/10 bg-white dark:bg-[#162032] px-3 py-1.5 text-xs text-slate-800 dark:text-slate-200 placeholder:text-slate-400 outline-none focus:border-accent transition-all">
                                </div>

                                {{-- Caption Indonesia --}}
                                <div x-show="langTab === 'id'">
                                    <label :for="'gambar_caption_id_' + i" class="block text-[11px] font-semibold text-slate-600 dark:text-slate-400 mb-1">Caption Gambar (Indonesia)</label>
                                    <input :id="'gambar_caption_id_' + i" type="text" x-model="block.caption_idn" placeholder="Caption / keterangan gambar (Indonesia, opsional)..."
                                           class="w-full rounded-lg border border-slate-200 dark:border-white/10 bg-white dark:bg-[#162032] px-3 py-1.5 text-xs text-slate-800 dark:text-slate-200 placeholder:text-slate-400 outline-none focus:border-accent transition-all">
                                </div>
                            </div>
                        </template>

                        {{-- Blok Kode Program (Universal / Bersama) --}}
                        <template x-if="block.type === 'kode'">
                            <div>
                                <div class="rounded-xl border border-code-line overflow-hidden bg-code shadow-xs">
                                    <div class="flex items-center justify-between gap-3 px-3 py-1.5 bg-code-header border-b border-code-line">
                                        <div class="flex items-center gap-1.5">
                                            <span class="w-2.5 h-2.5 rounded-full bg-[#ff5f56]"></span>
                                            <span class="w-2.5 h-2.5 rounded-full bg-[#ffbd2e]"></span>
                                            <span class="w-2.5 h-2.5 rounded-full bg-[#27c93f]"></span>
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
                                              rows="6" placeholder="// Tulis atau tempel potongan kode di sini..."
                                              class="w-full bg-code p-3 text-xs font-mono text-code-text placeholder:text-code-gutter outline-none focus:ring-1 focus:ring-accent/40 resize-y border-0"></textarea>
                                </div>
                            </div>
                        </template>

                        {{-- Blok Link Tautan --}}
                        <template x-if="block.type === 'link'">
                            <div class="space-y-2">
                                <div>
                                    <label :for="'link_href_' + i" class="block text-[11px] font-semibold text-slate-600 dark:text-slate-400 mb-1">Target URL / Tautan</label>
                                    <input :id="'link_href_' + i" type="url" x-model="block.href" placeholder="https://..."
                                           class="w-full rounded-lg border border-slate-200 dark:border-white/10 bg-white dark:bg-[#162032] px-3 py-1.5 text-xs text-slate-800 dark:text-slate-200 placeholder:text-slate-400 outline-none focus:border-accent focus:ring-2 focus:ring-accent/15 transition-all">
                                </div>

                                {{-- English Link Label & Desc --}}
                                <div x-show="langTab === 'en'" class="grid sm:grid-cols-2 gap-2">
                                    <div>
                                        <label :for="'link_label_en_' + i" class="block text-[11px] font-semibold text-slate-600 dark:text-slate-400 mb-1">Link Label (English)</label>
                                        <input :id="'link_label_en_' + i" type="text" x-model="block.label" placeholder="e.g. API Documentation"
                                               class="w-full rounded-lg border border-slate-200 dark:border-white/10 bg-white dark:bg-[#162032] px-3 py-1.5 text-xs text-slate-800 dark:text-slate-200 placeholder:text-slate-400 outline-none focus:border-accent focus:ring-2 focus:ring-accent/15 transition-all">
                                    </div>
                                    <div>
                                        <label :for="'link_desc_en_' + i" class="block text-[11px] font-semibold text-slate-600 dark:text-slate-400 mb-1">Description (English, optional)</label>
                                        <input :id="'link_desc_en_' + i" type="text" x-model="block.desc" placeholder="e.g. Visit the project repository"
                                               class="w-full rounded-lg border border-slate-200 dark:border-white/10 bg-white dark:bg-[#162032] px-3 py-1.5 text-xs text-slate-800 dark:text-slate-200 placeholder:text-slate-400 outline-none focus:border-accent focus:ring-2 focus:ring-accent/15 transition-all">
                                    </div>
                                </div>

                                {{-- Indonesia Link Label & Desc --}}
                                <div x-show="langTab === 'id'" class="grid sm:grid-cols-2 gap-2">
                                    <div>
                                        <label :for="'link_label_id_' + i" class="block text-[11px] font-semibold text-slate-600 dark:text-slate-400 mb-1">Judul / Label Tautan (Indonesia)</label>
                                        <input :id="'link_label_id_' + i" type="text" x-model="block.label_idn" placeholder="Contoh: Dokumentasi API"
                                               class="w-full rounded-lg border border-slate-200 dark:border-white/10 bg-white dark:bg-[#162032] px-3 py-1.5 text-xs text-slate-800 dark:text-slate-200 placeholder:text-slate-400 outline-none focus:border-accent focus:ring-2 focus:ring-accent/15 transition-all">
                                    </div>
                                    <div>
                                        <label :for="'link_desc_id_' + i" class="block text-[11px] font-semibold text-slate-600 dark:text-slate-400 mb-1">Keterangan Singkat (Indonesia, opsional)</label>
                                        <input :id="'link_desc_id_' + i" type="text" x-model="block.desc_idn" placeholder="Contoh: Kunjungi repositori proyek terkait"
                                               class="w-full rounded-lg border border-slate-200 dark:border-white/10 bg-white dark:bg-[#162032] px-3 py-1.5 text-xs text-slate-800 dark:text-slate-200 placeholder:text-slate-400 outline-none focus:border-accent focus:ring-2 focus:ring-accent/15 transition-all">
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Tombol Sisipkan Blok Antara --}}
                    <div class="relative z-20" x-data="{ insertOpen: false }" @click.outside="insertOpen = false">
                        <div class="flex items-center justify-center py-2">
                            <button type="button" @click="insertOpen = !insertOpen" :aria-expanded="insertOpen"
                                    :class="insertOpen ? 'border-accent/50 bg-accent/10 text-accent' : 'border-slate-200 dark:border-white/10 bg-white dark:bg-[#162032] text-slate-600 dark:text-slate-300 hover:border-accent/50 hover:text-accent'"
                                    class="focus-ring inline-flex items-center gap-1.5 rounded-full border px-3 py-1 text-[11px] font-semibold transition-colors shadow-2xs cursor-pointer">
                                <i class="ri-add-line text-xs transition-transform" :class="insertOpen && 'rotate-45'" aria-hidden="true"></i>
                                <span x-text="insertOpen ? 'Tutup' : 'Sisipkan blok'"></span>
                            </button>
                        </div>

                        <div x-show="insertOpen" x-cloak x-collapse class="pb-3">
                            <div class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50/80 dark:bg-white/5 p-3">
                                <p class="px-1 pb-2 text-[10px] font-bold uppercase tracking-wider text-slate-500">Pilih jenis blok</p>
                                @include('admin.projects._block-palette', [
                                    'insertAt' => 'i + 1',
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            {{-- Keadaan Kosong (Empty State) --}}
            <div x-show="blocks.length === 0" x-cloak class="border-2 border-dashed border-slate-200 dark:border-white/10 rounded-2xl p-8 text-center my-3 bg-slate-50/40 dark:bg-white/[0.01]">
                <div class="w-12 h-12 mx-auto rounded-xl bg-accent/10 text-accent flex items-center justify-center text-2xl">
                    <i class="ri-layout-masonry-line" aria-hidden="true"></i>
                </div>
                <h4 class="font-poppins font-bold text-slate-800 dark:text-white text-sm mt-3">Isi Konten Project Masih Kosong</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 max-w-md mx-auto mt-1">
                    Susun konten project menggunakan blok paragraf, gambar ilustrasi, cuplikan kode, atau link tautan. Jumlah blok tersinkronisasi otomatis antara bahasa English dan Indonesia.
                </p>

                <div class="relative mt-4" x-data="{ insertOpen: false }" @click.outside="insertOpen = false">
                    <button type="button" @click="insertOpen = !insertOpen" :aria-expanded="insertOpen"
                            class="focus-ring inline-flex items-center gap-1.5 rounded-xl bg-accent px-4 py-2 text-xs font-bold text-white shadow-sm transition-colors hover:bg-blue-600 cursor-pointer">
                        <i class="ri-add-line text-sm" aria-hidden="true"></i>
                        <span x-text="insertOpen ? 'Tutup' : 'Tambah blok pertama'"></span>
                    </button>

                    <div x-show="insertOpen" x-cloak x-collapse class="mt-3 text-left max-w-md mx-auto">
                        <div class="rounded-xl border border-slate-200 dark:border-white/10 bg-white dark:bg-[#162032] p-3 shadow-sm">
                            <p class="px-1 pb-2 text-[10px] font-bold uppercase tracking-wider text-slate-500">Pilih jenis blok pertama</p>
                            @include('admin.projects._block-palette', [
                                'insertAt' => '0',
                            ])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
