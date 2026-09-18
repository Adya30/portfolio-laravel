<div class="fixed inset-0 pointer-events-none overflow-hidden z-0" aria-hidden="true">
    <div class="absolute inset-0 bg-slate-200 dark:bg-transparent"></div>

    <div class="absolute inset-0
                bg-[linear-gradient(rgba(15,23,42,0.12)_1px,transparent_1px),linear-gradient(90deg,rgba(15,23,42,0.12)_1px,transparent_1px)]
                bg-size-[56px_56px]
                dark:bg-[linear-gradient(rgba(96,165,250,0.06)_1px,transparent_1px),linear-gradient(90deg,rgba(96,165,250,0.06)_1px,transparent_1px)]"
         style="mask-image: radial-gradient(ellipse 90% 80% at 50% 40%, black 50%, transparent 100%);
                -webkit-mask-image: radial-gradient(ellipse 90% 80% at 50% 40%, black 50%, transparent 100%);"></div>

    <div class="absolute rounded-full pointer-events-none opacity-20 dark:opacity-10 blur-[160px]"
         style="width: 450px; height: 450px; left: -10%; top: 10%; background: radial-gradient(circle, #3b82f6 0%, #8b5cf6 70%);"></div>
    <div class="absolute rounded-full pointer-events-none opacity-20 dark:opacity-10 blur-[160px]"
         style="width: 500px; height: 500px; left: 60%; top: 45%; background: radial-gradient(circle, #8b5cf6 0%, #06b6d4 70%);"></div>

    @for($i = 0; $i < 12; $i++)
        @php
            $size = 1.5 + ($i % 2);
            $left = ($i * 27.7 + 13.2) % 100;
            $top = ($i * 23.3 + 17.1) % 100;
            $delay = $i * 0.4;
            $duration = 4 + ($i % 3);
            $color = $i % 2 === 0 ? '#3b82f6' : '#06b6d4';
        @endphp
        <div class="pointer-events-none absolute rounded-full opacity-0"
             style="width: {{ $size }}px; height: {{ $size }}px; left: {{ $left }}%; top: {{ $top }}%; background: {{ $color }}; animation: sparkle-twinkle {{ $duration }}s ease-in-out {{ $delay }}s infinite;"></div>
    @endfor

    <div class="absolute inset-0 overflow-hidden opacity-[0.20] dark:opacity-[0.10] select-none font-mono text-slate-900/30 dark:text-white pointer-events-none">
        <span class="absolute text-8xl font-bold" style="right: 12%; top: 22%; ;">;</span>
    </div>
</div>
