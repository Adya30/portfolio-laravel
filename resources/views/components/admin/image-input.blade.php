@props([
    'name' => 'gambar',
    'label' => 'Gambar',
    'current' => null,
    'ratio' => 'free',
    'crop' => true,
    'help' => null,
])

@php
    $hasError = $errors->has($name) || $errors->has($name . '_url');
@endphp

<div
    x-data="imageUploader({
        name: @js($name),
        current: @js($current ? img_url($current) : ''),
        ratio: @js($ratio),
        crop: @js($crop),
    })"
    class="space-y-1.5"
>
    <label class="block text-sm font-semibold text-slate-700">{{ $label }}</label>
    @if ($help)
        <p class="text-xs text-slate-400">{{ $help }}</p>
    @endif

    <div class="flex items-start gap-4">

        <div class="relative w-24 h-24 rounded-xl border border-slate-200 bg-slate-50 flex items-center justify-center overflow-hidden shrink-0">
            <template x-if="previewSrc">
                <img :src="previewSrc" alt="Pratinjau {{ $label }}" class="w-full h-full object-cover">
            </template>
            <template x-if="!previewSrc">
                <i class="ri-image-line text-2xl text-slate-300"></i>
            </template>
            <span x-show="isSvg" x-cloak
                  class="absolute bottom-1 right-1 text-[9px] font-bold tracking-wide px-1.5 py-0.5 rounded-md bg-black/70 text-white uppercase">SVG</span>
        </div>

        <div class="flex-1 min-w-0 space-y-2.5">
            <input type="file" x-ref="fileInput" name="{{ $name }}"
                   accept=".jpg,.jpeg,.png,.gif,.webp,.svg,image/jpeg,image/png,image/gif,image/webp,image/svg+xml"
                   class="block w-full text-sm text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-slate-100 file:text-sm file:font-semibold file:text-slate-600 hover:file:bg-slate-200">

            <div x-show="fileName" x-cloak class="flex items-center gap-2 text-xs text-slate-500">
                <span class="truncate"><i class="ri-attachment-line mr-1 text-accent"></i><span x-text="fileName"></span></span>
                <button type="button" @click="clearSelection"
                        class="shrink-0 inline-flex items-center gap-1 font-medium text-red-500 hover:text-red-600 transition-colors">
                    <i class="ri-delete-bin-line"></i>Hapus pilihan
                </button>
            </div>

            <div class="flex items-center gap-2 text-xs text-slate-400">
                <span class="border-t border-slate-200 flex-1"></span> atau URL gambar
            </div>

            <input type="url" name="{{ $name }}_url" placeholder="https://contoh.com/gambar.png"
                   class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-sm text-slate-800 placeholder:text-slate-400 outline-none focus:border-accent focus:ring-4 focus:ring-accent/20 transition-all">
        </div>
    </div>

    @if ($hasError)
        @error($name)
            <p class="text-xs text-red-500 font-medium">{{ $message }}</p>
        @enderror
        @error($name . '_url')
            <p class="text-xs text-red-500 font-medium">{{ $message }}</p>
        @enderror
    @endif

    <div x-show="showCrop" x-cloak x-transition.opacity.duration.200ms
         class="fixed inset-0 z-200 flex items-center justify-center p-4" role="dialog" aria-modal="true">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="cancelCrop"></div>

        <div class="relative w-full max-w-2xl bg-white dark:bg-slate-900 rounded-2xl shadow-2xl overflow-hidden animate-scale-in"
             @click.stop>

            <div class="flex items-center justify-between px-5 py-3.5 border-b border-slate-100 dark:border-white/10">
                <h3 class="font-poppins font-bold text-slate-800 dark:text-white flex items-center gap-2">
                    <i class="ri-crop-2-line text-accent"></i>Crop Gambar
                </h3>
                <button type="button" @click="cancelCrop"
                        class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-slate-700 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-white/10 transition-colors cursor-pointer"
                        aria-label="Tutup">
                    <i class="ri-close-line"></i>
                </button>
            </div>

            <div class="relative bg-slate-950/90">
                <img x-ref="cropImage"
                     src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                     alt="Area crop" class="block w-full max-h-[55vh]">
            </div>

            <div class="px-5 py-4 space-y-4">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400 mr-1">Rasio:</span>
                    <template x-for="r in ratios" :key="r">
                        <button type="button" @click="setRatio(r)"
                                class="px-3 py-1.5 rounded-lg text-xs font-semibold border transition-all duration-200 cursor-pointer"
                                :class="ratio === r
                                    ? 'bg-accent text-white border-accent shadow-sm'
                                    : 'border-slate-200 dark:border-white/10 text-slate-500 dark:text-slate-400 hover:border-accent/40 hover:text-accent'"
                                x-text="ratioLabel(r)"></button>
                    </template>
                </div>

                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div class="flex items-center gap-2">
                        <button type="button" @click="rotate(-90)" title="Putar kiri"
                                class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-200 dark:border-white/10 text-slate-500 dark:text-slate-400 hover:text-accent hover:border-accent/40 transition-colors cursor-pointer">
                            <i class="ri-anticlockwise-2-fill"></i>
                        </button>
                        <button type="button" @click="rotate(90)" title="Putar kanan"
                                class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-200 dark:border-white/10 text-slate-500 dark:text-slate-400 hover:text-accent hover:border-accent/40 transition-colors cursor-pointer">
                            <i class="ri-clockwise-2-fill"></i>
                        </button>
                        <button type="button" @click="resetCrop"
                                class="h-9 px-3 inline-flex items-center gap-1.5 rounded-lg border border-slate-200 dark:border-white/10 text-xs font-semibold text-slate-500 dark:text-slate-400 hover:text-accent hover:border-accent/40 transition-colors cursor-pointer">
                            <i class="ri-refresh-line"></i>Reset
                        </button>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="button" @click="cancelCrop"
                                class="h-9 px-4 rounded-xl border border-slate-200 dark:border-white/10 text-sm font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-white/5 transition-colors cursor-pointer">
                            Batal
                        </button>
                        <button type="button" @click="applyCrop"
                                class="h-9 px-5 rounded-xl bg-accent text-white text-sm font-semibold hover:bg-blue-600 shadow-sm transition-colors cursor-pointer">
                            <i class="ri-check-line mr-1"></i>Terapkan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
