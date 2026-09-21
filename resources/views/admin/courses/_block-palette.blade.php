{{-- Palette of block types, shared by every "insert a block" control.
     Callers pass:
       $insertAt   — the Alpine expression for the index to insert at
       $hideSubbab — drop the "Subbab" entry inside a subbab editor
     Each button closes the caller's panel, so the caller's Alpine scope has to
     expose an `insertOpen` flag. --}}
@php
    $blockTypes = [
        ['type' => 'subbab', 'label' => 'Subbab', 'icon' => 'ri-heading', 'subbabOnly' => true],
        ['type' => 'subheading', 'label' => 'Sub Heading 2', 'icon' => 'ri-h-2'],
        ['type' => 'subheading3', 'label' => 'Sub Heading 3', 'icon' => 'ri-h-3'],
        ['type' => 'paragraf', 'label' => 'Paragraf', 'icon' => 'ri-paragraph'],
        ['type' => 'gambar', 'label' => 'Gambar', 'icon' => 'ri-image-line'],
        ['type' => 'kode', 'label' => 'Kode', 'icon' => 'ri-code-box-line'],
        ['type' => 'link', 'label' => 'Link', 'icon' => 'ri-external-link-line'],
        ['type' => 'pembatas', 'label' => 'Pembatas', 'icon' => 'ri-separator'],
        ['type' => 'tabel', 'label' => 'Tabel Data', 'icon' => 'ri-table-2'],
    ];
@endphp

<div class="flex flex-wrap gap-1.5">
    @foreach ($blockTypes as $blockType)
        @continue(($blockType['subbabOnly'] ?? false) && ($hideSubbab ?? false))

        <button type="button"
                @click="addBlockAt('{{ $blockType['type'] }}', {{ $insertAt }}); insertOpen = false"
                class="focus-ring inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-2.5 py-1.5 text-[11px] font-semibold text-slate-600 transition-colors hover:border-accent/50 hover:bg-accent/5 hover:text-accent">
            <i class="{{ $blockType['icon'] }} text-xs text-accent" aria-hidden="true"></i>
            {{ $blockType['label'] }}
        </button>
    @endforeach
</div>
