@props([
    'name' => '',
    'label' => '',
    'type' => 'text',
    'value' => null,
    'placeholder' => '',
    'help' => null,
    'rows' => 3,
    'required' => false,
    'autofocus' => false,
])

@php
    $hasError = $errors->has($name);
    $classes = 'w-full rounded-xl border bg-white dark:bg-[#162032] px-3.5 py-2.5 text-sm text-slate-800 dark:text-white placeholder:text-slate-400 outline-none transition-all ' . ($hasError
        ? 'border-red-300 dark:border-red-500 focus:border-red-400 focus:ring-4 focus:ring-red-100 dark:focus:ring-red-900/30'
        : 'border-slate-200 dark:border-white/10 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/20');
@endphp

<div class="space-y-1.5">
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-semibold text-slate-700 dark:text-slate-200">
            {{ $label }} @if ($required)<span class="text-red-500">*</span>@endif
        </label>
    @endif

    @if ($type === 'textarea')
        <textarea name="{{ $name }}" id="{{ $name }}" rows="{{ $rows }}" placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }}
                  class="{{ $classes }}">{{ old($name, $value) }}</textarea>
    @else
        <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" value="{{ old($name, $value) }}"
               placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }} {{ $autofocus ? 'autofocus' : '' }}
               class="{{ $classes }}">
    @endif

    @if ($help)
        <p class="text-xs text-slate-400">{{ $help }}</p>
    @endif

    @error($name)
        <p class="text-xs text-red-500 font-medium">{{ $message }}</p>
    @enderror
</div>
