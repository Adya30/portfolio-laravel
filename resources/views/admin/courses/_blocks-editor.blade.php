@php
    if (! isset($blocksValue)) {
        $blocksValue = old('konten', ($course ?? null)?->konten ?? []);
    }
    if (is_string($blocksValue)) {
        $blocksValue = json_decode($blocksValue, true) ?: [];
    }
    $blocksValue = is_array($blocksValue) ? $blocksValue : [];
@endphp

<div x-data="courseContentEditor(@js($blocksValue), @js(route('admin.courses.upload-image')))" class="space-y-4">
    <input type="hidden" name="konten" x-ref="kontenInput" value="{{ json_encode($blocksValue) }}">
    <div x-effect="$refs.kontenInput.value = JSON.stringify(blocks)"></div>

    <div class="bg-white shadow-xl p-6 sm:p-8 max-w-4xl mx-auto relative">
        <div class="border-b border-slate-200 pb-3 flex items-center justify-between text-xs text-slate-400 font-mono select-none">
            <span>Halaman Materi</span>
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
                         draggable="true"
                         @dragstart="dragStart(i, $event)"
                         @dragover="dragOver(i, $event)"
                         @drop="dropBlock(i, $event)"
                         @dragend="dragEnd"
                         :class="draggedIndex === i ? 'opacity-40' : ''"
                         class="py-3 hover:bg-slate-50/50 transition-colors">

                        <div class="flex items-center justify-between gap-3 mb-2">
                            <div class="flex items-center gap-2">
                                <span class="cursor-grab active:cursor-grabbing text-slate-300 hover:text-slate-500 transition-colors p-0.5"
                                      title="Tahan & geser untuk memindahkan">
                                    <i class="ri-drag-move-2-line text-sm"></i>
                                </span>
                                <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-slate-100 text-slate-600 border border-slate-200"
                                      x-text="blockLabel(block.type)"></span>
                                <span class="text-[10px] text-slate-400 font-semibold">#<span x-text="i + 1"></span></span>
                            </div>

                            <div class="flex items-center gap-0.5">
                                <button type="button" @click="moveBlock(i, -1)"
                                        class="w-6 h-6 flex items-center justify-center rounded text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors">
                                    <i class="ri-arrow-up-line text-xs"></i>
                                </button>
                                <button type="button" @click="moveBlock(i, 1)"
                                        class="w-6 h-6 flex items-center justify-center rounded text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors">
                                    <i class="ri-arrow-down-line text-xs"></i>
                                </button>
                                <button type="button" @click="removeBlock(i)"
                                        @if ($hideSubbab ?? false) x-show="!(i === 0 && block.type === 'subbab')" @endif
                                        class="w-6 h-6 flex items-center justify-center rounded text-slate-400 hover:text-red-500 hover:bg-red-50 transition-colors">
                                    <i class="ri-delete-bin-line text-xs"></i>
                                </button>
                            </div>
                        </div>

                        <template x-if="block.type === 'subbab'">
                            <div>
                                <input type="text" x-model="block.judul" placeholder="Tulis judul subbab di sini..."
                                       class="w-full rounded-lg border border-slate-200 bg-slate-50/50 px-3 py-2 text-base font-poppins font-bold text-slate-800 placeholder:text-slate-400 outline-none focus:border-accent focus:bg-white focus:ring-2 focus:ring-accent/15 transition-all">
                            </div>
                        </template>

                        <template x-if="block.type === 'subheading'">
                            <div>
                                <input type="text" x-model="block.teks" placeholder="Tulis sub heading di sini..."
                                       class="w-full rounded-lg border border-slate-200 bg-slate-50/50 px-3 py-1.5 text-sm font-poppins font-semibold text-slate-800 placeholder:text-slate-400 outline-none focus:border-accent focus:bg-white focus:ring-2 focus:ring-accent/15 transition-all">
                            </div>
                        </template>

                        <template x-if="block.type === 'paragraf'">
                            <div class="space-y-1">
                                <div class="flex flex-wrap items-center gap-1">
                                    <div class="flex items-center gap-0.5 bg-slate-100 p-0.5 rounded border border-slate-200 text-xs">
                                        <button type="button" @click="block.align = 'kiri'"
                                                :class="block.align === 'kiri' ? 'bg-white text-accent shadow-sm' : 'text-slate-500 hover:bg-white'"
                                                class="px-1.5 py-0.5 rounded" title="Rata Kiri"><i class="ri-align-left text-xs"></i></button>
                                        <button type="button" @click="block.align = 'tengah'"
                                                :class="block.align === 'tengah' ? 'bg-white text-accent shadow-sm' : 'text-slate-500 hover:bg-white'"
                                                class="px-1.5 py-0.5 rounded" title="Rata Tengah"><i class="ri-align-center text-xs"></i></button>
                                        <button type="button" @click="block.align = 'kanan'"
                                                :class="block.align === 'kanan' ? 'bg-white text-accent shadow-sm' : 'text-slate-500 hover:bg-white'"
                                                class="px-1.5 py-0.5 rounded" title="Rata Kanan"><i class="ri-align-right text-xs"></i></button>
                                        <button type="button" @click="block.align = 'justify'"
                                                :class="block.align === 'justify' ? 'bg-white text-accent shadow-sm' : 'text-slate-500 hover:bg-white'"
                                                class="px-1.5 py-0.5 rounded" title="Justify"><i class="ri-align-justify text-xs"></i></button>
                                    </div>
                                    <div class="flex items-center gap-0.5 bg-slate-100 p-0.5 rounded border border-slate-200 text-xs">
                                        <button type="button" @click="applyFormat(i, 'bold', $event.currentTarget)" class="px-1.5 py-0.5 font-bold hover:bg-white rounded">B</button>
                                        <button type="button" @click="applyFormat(i, 'italic', $event.currentTarget)" class="px-1.5 py-0.5 italic hover:bg-white rounded">I</button>
                                        <button type="button" @click="applyFormat(i, 'underline', $event.currentTarget)" class="px-1.5 py-0.5 underline hover:bg-white rounded">U</button>
                                        <button type="button" @click="applyFormat(i, 'bullet', $event.currentTarget)" class="px-1.5 py-0.5 hover:bg-white rounded">• List</button>
                                        <button type="button" @click="applyFormat(i, 'number', $event.currentTarget)" class="px-1.5 py-0.5 hover:bg-white rounded">1. List</button>
                                        <button type="button" @click="applyFormat(i, 'quote', $event.currentTarget)" class="px-1.5 py-0.5 hover:bg-white rounded">" Quote</button>
                                    </div>
                                </div>
                                <textarea x-model="block.teks" @paste="handleSmartPaste(i, $event)"
                                          rows="4" placeholder="Tulis isi paragraf di sini..."
                                          class="w-full rounded-lg border border-slate-200 bg-slate-50/50 px-3 py-2 text-sm text-slate-800 leading-relaxed placeholder:text-slate-400 outline-none focus:border-accent focus:bg-white focus:ring-2 focus:ring-accent/15 transition-all"></textarea>
                            </div>
                        </template>

                        <template x-if="block.type === 'gambar'">
                            <div class="space-y-2">
                                <div class="flex flex-wrap items-center gap-2">
                                    <select x-model="block.ukuran"
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
                                        <input type="file" accept=".webp,.svg,image/webp,image/svg+xml"
                                               @change="uploadImage(i, $event.target.files[0])"
                                               class="block w-full text-xs text-slate-600 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-accent/10 file:text-xs file:font-bold file:text-accent hover:file:bg-accent/20 cursor-pointer">
                                        <p x-show="uploadingIndex === i" x-cloak class="text-xs text-accent font-semibold">
                                            <i class="ri-loader-4-line animate-spin"></i> Mengunggah...
                                        </p>
                                        <input type="text" x-model="block.url" placeholder="Atau tempel URL gambar"
                                               class="w-full rounded-lg border border-slate-200 bg-slate-50/50 px-3 py-1.5 text-xs text-slate-800 placeholder:text-slate-400 outline-none focus:border-accent focus:bg-white transition-all">
                                    </div>
                                </div>
                                <input type="text" x-model="block.caption" placeholder="Caption gambar (opsional)"
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
                                        <select x-model="block.bahasa"
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
                                    <textarea x-model="block.kode" @keydown.tab.prevent="insertTab($event)"
                                              rows="6" placeholder="// Tulis atau tempel kode di sini..."
                                              class="w-full bg-[#0d1117] p-3 text-xs font-mono text-slate-100 placeholder:text-slate-600 outline-none focus:ring-1 focus:ring-accent/40 resize-y border-0"></textarea>
                                </div>
                            </div>
                        </template>

                        <template x-if="block.type === 'link'">
                            <div class="space-y-2">
                                <input type="url" x-model="block.href" placeholder="URL / Tautan"
                                       class="w-full rounded-lg border border-slate-200 bg-slate-50/50 px-3 py-1.5 text-sm text-slate-800 placeholder:text-slate-400 outline-none focus:border-accent focus:bg-white focus:ring-2 focus:ring-accent/15 transition-all">
                                <input type="text" x-model="block.label" placeholder="Label tombol"
                                       class="w-full rounded-lg border border-slate-200 bg-slate-50/50 px-3 py-1.5 text-sm text-slate-800 placeholder:text-slate-400 outline-none focus:border-accent focus:bg-white focus:ring-2 focus:ring-accent/15 transition-all">
                                <input type="text" x-model="block.desc" placeholder="Deskripsi singkat (opsional)"
                                       class="w-full rounded-lg border border-slate-200 bg-slate-50/50 px-3 py-1.5 text-sm text-slate-800 placeholder:text-slate-400 outline-none focus:border-accent focus:bg-white focus:ring-2 focus:ring-accent/15 transition-all">
                            </div>
                        </template>

                        <template x-if="block.type === 'pembatas'">
                            <div class="space-y-2">
                                <select x-model="block.style"
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
                            <div class="space-y-2">
                                <div class="flex flex-wrap items-center gap-2">
                                    <button type="button" @click="addTableCol(i)"
                                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-slate-100 border border-slate-200 text-slate-700 text-xs font-bold hover:bg-slate-200 transition-colors">
                                        <i class="ri-add-line text-xs"></i> Kolom
                                    </button>
                                    <button type="button" @click="addTableRow(i)"
                                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-accent/10 border border-accent/20 text-accent text-xs font-bold hover:bg-accent/20 transition-colors">
                                        <i class="ri-add-line text-xs"></i> Baris
                                    </button>
                                </div>
                                <div class="overflow-x-auto border border-slate-200 rounded-lg bg-white">
                                    <table class="w-full text-left text-xs">
                                        <thead class="bg-slate-50 border-b border-slate-200">
                                            <tr>
                                                <th class="p-1 w-8 text-center text-slate-400">#</th>
                                                <template x-for="(head, cIdx) in (block.headers || [])" :key="cIdx">
                                                    <th class="p-1 min-w-[100px]">
                                                        <div class="flex items-center justify-between gap-1">
                                                            <input type="text" x-model="block.headers[cIdx]" placeholder="Judul"
                                                                   class="w-full rounded border border-slate-300 px-1.5 py-0.5 text-xs font-bold text-slate-800 bg-white outline-none focus:border-accent">
                                                            <button type="button" @click="removeTableCol(i, cIdx)"
                                                                    x-show="(block.headers || []).length > 1"
                                                                    class="text-slate-400 hover:text-red-500">
                                                                <i class="ri-close-circle-line text-xs"></i>
                                                            </button>
                                                        </div>
                                                    </th>
                                                </template>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            <template x-for="(row, rIdx) in (block.rows || [])" :key="rIdx">
                                                <tr class="hover:bg-slate-50/50">
                                                    <td class="p-1 text-center text-slate-400 font-bold text-[10px]">
                                                        <div class="flex items-center justify-center gap-0.5">
                                                            <span x-text="rIdx + 1"></span>
                                                            <button type="button" @click="removeTableRow(i, rIdx)"
                                                                    class="text-slate-400 hover:text-red-500">
                                                                <i class="ri-delete-bin-line text-[10px]"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <template x-for="(cell, cIdx) in row" :key="cIdx">
                                                        <td class="p-1">
                                                            <input type="text" x-model="block.rows[rIdx][cIdx]" placeholder="Isi sel..."
                                                                   class="w-full rounded border border-slate-200 px-1.5 py-0.5 text-xs text-slate-700 bg-slate-50/50 outline-none focus:bg-white focus:border-accent transition-all">
                                                        </td>
                                                    </template>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                                <input type="text" x-model="block.caption" placeholder="Caption tabel (opsional)"
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

            <div x-show="blocks.length === 0" x-cloak
                 class="border-2 border-dashed border-slate-200 rounded-xl p-8 text-center text-slate-400 space-y-2 mt-3">
                <div class="w-12 h-12 mx-auto rounded-xl bg-accent/10 text-accent flex items-center justify-center text-xl">
                    <i class="ri-file-text-line"></i>
                </div>
                <h4 class="font-poppins font-bold text-slate-700 text-sm">Lembar Kerja Kosong</h4>
                <p class="text-xs text-slate-400 max-w-md mx-auto">Gunakan toolbar di atas untuk menambahkan blok konten.</p>
            </div>
        </div>
    </div>
</div>
