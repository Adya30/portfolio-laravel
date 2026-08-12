@props([
    'title' => '',
    'subtitle' => '',
    'actionLabel' => null,
    'actionRoute' => null,
])

<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div>
        <h2 class="font-poppins text-xl sm:text-2xl font-bold text-slate-800">{{ $title }}</h2>
        @if ($subtitle)
            <p class="text-sm text-slate-500 mt-0.5">{{ $subtitle }}</p>
        @endif
    </div>
    @if ($actionLabel && $actionRoute)
        <a href="{{ route($actionRoute) }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-accent text-white text-sm font-semibold hover:bg-blue-600 hover:-translate-y-0.5 transition-all">
            <i class="ri-add-line"></i>{{ $actionLabel }}
        </a>
    @endif
</div>
