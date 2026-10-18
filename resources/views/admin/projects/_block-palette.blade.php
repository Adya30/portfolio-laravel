{{-- Palette of block types for Projects.
     Excludes: heading (subbab, subheading), garis (pembatas), and tabel.
     Only includes: Paragraf, Gambar, Kode, Link.
     Callers pass:
       $insertAt — the Alpine expression for the index to insert at
--}}
@php
    $blockTypes = [
        ['type' => 'paragraf', 'label' => 'Paragraf', 'icon' => 'ri-paragraph', 'desc' => 'Teks dengan format editor'],
        ['type' => 'gambar', 'label' => 'Gambar', 'icon' => 'ri-image-line', 'desc' => 'Foto atau screenshot'],
        ['type' => 'kode', 'label' => 'Kode Program', 'icon' => 'ri-code-box-line', 'desc' => 'Cuplikan kode dengan sintaks'],
        ['type' => 'link', 'label' => 'Link Tautan', 'icon' => 'ri-external-link-line', 'desc' => 'Kartu tautan eksternal'],
    ];
@endphp

<div class="flex flex-wrap gap-2">
    @foreach ($blockTypes as $blockType)
        <button type="button"
                @click="addBlockAt('{{ $blockType['type'] }}', {{ $insertAt }}); insertOpen = false"
                class="focus-ring inline-flex items-center gap-1.5 rounded-lg border border-slate-200 dark:border-white/10 bg-white dark:bg-[#162032] px-3 py-1.5 text-xs font-semibold text-slate-700 dark:text-slate-300 transition-colors hover:border-accent/50 hover:bg-accent/5 hover:text-accent shadow-2xs cursor-pointer">
            <i class="{{ $blockType['icon'] }} text-xs text-accent" aria-hidden="true"></i>
            <span>{{ $blockType['label'] }}</span>
        </button>
    @endforeach
</div>
