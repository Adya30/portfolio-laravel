@props([
    'name' => 'gambar',
    'label' => 'Gambar',
    'current' => null,
])

@php
    $hasError = $errors->has($name) || $errors->has($name . '_url');
@endphp

<div class="space-y-1.5">
    <label class="block text-sm font-semibold text-slate-700">{{ $label }}</label>

    <div class="flex items-start gap-4">
        <div class="w-24 h-24 rounded-xl border border-slate-200 bg-slate-50 flex items-center justify-center overflow-hidden flex-shrink-0">
            @if ($current && img_url($current))
                <img src="{{ img_url($current) }}" alt="Pratinjau" class="w-full h-full object-cover">
            @else
                <i class="ri-image-line text-2xl text-slate-300"></i>
            @endif
        </div>

        <div class="flex-1 space-y-2.5">
            <input type="file" name="{{ $name }}" accept="image/*"
                   class="block w-full text-sm text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-slate-100 file:text-sm file:font-semibold file:text-slate-600 hover:file:bg-slate-200">

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
</div>
