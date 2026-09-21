{{-- Quiet, theme-aware page backdrop: one faint grid plus a single soft glow. --}}
<div class="fixed inset-0 z-0 pointer-events-none overflow-hidden" aria-hidden="true">
    <div class="absolute inset-0 bg-canvas dark:bg-canvas-dark"></div>

    <div class="absolute inset-0
                bg-[linear-gradient(rgba(15,23,42,0.045)_1px,transparent_1px),linear-gradient(90deg,rgba(15,23,42,0.045)_1px,transparent_1px)]
                bg-size-[64px_64px]
                dark:bg-[linear-gradient(rgba(148,163,184,0.07)_1px,transparent_1px),linear-gradient(90deg,rgba(148,163,184,0.07)_1px,transparent_1px)]"
         style="mask-image: radial-gradient(ellipse 85% 70% at 50% 30%, #000 35%, transparent 100%);
                -webkit-mask-image: radial-gradient(ellipse 85% 70% at 50% 30%, #000 35%, transparent 100%);"></div>

    <div class="absolute -top-40 left-1/2 h-[600px] w-[min(1100px,130vw)] -translate-x-1/2 opacity-70 dark:opacity-55"
         style="background: radial-gradient(50% 50% at 50% 50%, rgb(59 130 246 / 0.16), transparent 70%);"></div>
</div>
