{{-- Decorative page background shared by the landing and detail pages:
     subtle grid, two blurred gradient blobs, and twinkling sparkles. --}}
<div class="fixed inset-0 pointer-events-none overflow-hidden z-0" aria-hidden="true">
    <div class="absolute inset-0
                bg-[linear-gradient(rgba(59,130,246,0.04)_1px,transparent_1px),linear-gradient(90deg,rgba(59,130,246,0.04)_1px,transparent_1px)]
                bg-size-[48px_48px]
                dark:bg-[linear-gradient(rgba(96,165,250,0.04)_1px,transparent_1px),linear-gradient(90deg,rgba(96,165,250,0.04)_1px,transparent_1px)]"></div>

    <div class="absolute rounded-full pointer-events-none opacity-25 dark:opacity-15 blur-[120px]"
         style="width: 400px; height: 400px; left: -10%; top: 10%; background: radial-gradient(circle, #3b82f6 0%, #8b5cf6 70%);"></div>
    <div class="absolute rounded-full pointer-events-none opacity-25 dark:opacity-15 blur-[120px]"
         style="width: 450px; height: 450px; left: 60%; top: 45%; background: radial-gradient(circle, #8b5cf6 0%, #06b6d4 70%);"></div>

    @for($i = 0; $i < 15; $i++)
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
</div>
