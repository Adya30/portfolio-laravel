@php
    $blocks = is_array($blocks ?? null) ? $blocks : [];
    $codeLangs = ['php', 'javascript', 'typescript', 'html', 'css', 'sql', 'python', 'bash', 'json', 'csharp', 'java', 'plaintext'];
@endphp

<div class="space-y-4 pt-1">
    @foreach ($blocks as $block)
        @php $type = $block['type'] ?? ''; @endphp

        @if ($type === 'paragraf')
            @php
                $align = $block['align'] ?? 'kiri';
                $alignClass = match ($align) {
                    'tengah' => 'text-center',
                    'kanan' => 'text-right',
                    'justify' => 'text-justify',
                    default => 'text-left',
                };
                $teks = $block['teks'] ?? '';
            @endphp
            @if (trim($teks) !== '')
                <div class="w-full text-sm sm:text-[15px] leading-relaxed text-slate-700 dark:text-slate-300 markdown-content {{ $alignClass }}">
                    {!! render_markdown($teks) !!}
                </div>
            @endif
        @elseif ($type === 'gambar' && !empty($block['url']))
            @php
                $ukuran = $block['ukuran'] ?? 'penuh';
                [$sizeClass, $maxHClass] = match ($ukuran) {
                    'kecil' => ['max-w-[180px] sm:max-w-[220px]', 'max-h-48 sm:max-h-56'],
                    'sedang' => ['max-w-[320px] sm:max-w-[420px]', 'max-h-72 sm:max-h-96'],
                    'besar' => ['max-w-[520px] sm:max-w-[680px]', 'max-h-[75vh] sm:max-h-[520px]'],
                    default => ['w-full max-w-full', 'max-h-[85vh] sm:max-h-[660px]'],
                };
                $parentTitle = $title ?? (($project ?? null)?->nama ?? (($experience ?? null)?->role ?? 'Image'));
            @endphp
            <figure class="my-3 sm:my-4 text-center">
                <div class="inline-block rounded-2xl overflow-hidden border border-slate-200/90 dark:border-white/10 bg-slate-100/70 dark:bg-[#1e293b] p-1.5 sm:p-2 mx-auto {{ $sizeClass }} w-full shadow-2xs">
                    <img src="{{ img_url($block['url']) }}"
                         alt="{{ $block['caption'] ?? $parentTitle }}"
                         title="{{ $block['caption'] ?? $parentTitle }}"
                         class="mx-auto h-auto object-contain w-full rounded-xl {{ $maxHClass }}"
                         loading="lazy" decoding="async">
                </div>
                @if (!empty($block['caption']))
                    <figcaption class="mt-2 text-xs text-slate-500 dark:text-slate-400 italic">
                        {{ $block['caption'] }}
                    </figcaption>
                @endif
            </figure>
        @elseif ($type === 'kode' && !empty($block['kode']))
            @php
                $lang = in_array(strtolower($block['bahasa'] ?? ''), $codeLangs, true) ? strtolower($block['bahasa']) : 'plaintext';
                $rawCode = (string) $block['kode'];
                $lines = explode("\n", str_replace(["\r\n", "\r"], "\n", $rawCode));
                if (end($lines) === '') {
                    array_pop($lines);
                }
                if (empty($lines)) {
                    $lines = [''];
                }
            @endphp
            <div class="my-3 sm:my-4 rounded-2xl overflow-hidden border border-code-line bg-code shadow-xs">
                <div class="flex items-center justify-between gap-3 px-4 py-2 bg-code-header border-b border-code-line text-xs font-mono text-code-gutter select-none">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#ff5f56]"></span>
                        <span class="w-2.5 h-2.5 rounded-full bg-[#ffbd2e]"></span>
                        <span class="w-2.5 h-2.5 rounded-full bg-[#27c93f]"></span>
                    </div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-300">{{ $lang }}</span>
                </div>
                <div class="overflow-x-auto custom-scrollbar">
                    <div class="flex min-w-full font-code text-[12.5px] leading-6 sm:text-[13.5px]">
                        <div class="sticky left-0 z-10 min-w-10 shrink-0 select-none border-r border-code-line bg-code px-3 py-3.5 text-right tabular-nums text-code-gutter">
                            @foreach ($lines as $lineIndex => $lineContent)
                                <div>{{ $lineIndex + 1 }}</div>
                            @endforeach
                        </div>
                        <pre class="tab-size-4 whitespace-pre py-3.5 pl-4 pr-5 font-code text-code-text"><code class="language-{{ $lang }} font-code">{!! e($rawCode) !!}</code></pre>
                    </div>
                </div>
            </div>
        @elseif ($type === 'link')
            @php
                $href = $block['href'] ?? '#';
                $label = $block['label'] ?? $href;
                $desc = $block['desc'] ?? '';
            @endphp
            <div class="my-2">
                <a href="{{ $href }}" target="_blank" rel="noopener noreferrer"
                   class="group flex items-start gap-3 sm:gap-4 rounded-xl border border-blue-200 dark:border-blue-800 bg-blue-50/50 dark:bg-blue-900/10 hover:bg-blue-100/50 dark:hover:bg-blue-900/20 p-3.5 sm:p-4 transition-all duration-200">
                    <div class="shrink-0 w-9 h-9 sm:w-10 sm:h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center mt-0.5">
                        <i class="ri-external-link-line text-lg"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-sm sm:text-base text-blue-700 dark:text-blue-400 group-hover:underline truncate">{{ $label }}</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 truncate mt-0.5">{{ $href }}</p>
                        @if ($desc)
                            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 mt-1.5 leading-relaxed">{{ $desc }}</p>
                        @endif
                    </div>
                    <div class="shrink-0 text-slate-400 dark:text-slate-500 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors mt-1">
                        <i class="ri-arrow-right-up-line text-base"></i>
                    </div>
                </a>
            </div>
        @endif
    @endforeach
</div>
