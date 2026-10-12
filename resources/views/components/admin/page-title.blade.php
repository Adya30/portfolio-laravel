@props([
    'title' => '',
    'subtitle' => '',
    'actionLabel' => null,
    'actionRoute' => null,
])

<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div>
        <h2 class="font-poppins text-xl sm:text-2xl font-bold text-slate-800 dark:text-white">{{ $title }}</h2>
        @if ($subtitle)
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">{{ $subtitle }}</p>
        @endif
    </div>
    @if ($actionLabel && $actionRoute)
        <a href="{{ route($actionRoute) }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-orange-500 text-white text-sm font-semibold hover:bg-orange-600 hover:-translate-y-0.5 shadow-sm transition-all">
            <i class="ri-add-line"></i>{{ $actionLabel }}
        </a>
    @endif
</div>
