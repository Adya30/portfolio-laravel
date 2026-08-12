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
    $classes = 'w-full rounded-xl border bg-white px-3.5 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 outline-none transition-all ' . ($hasError
        ? 'border-red-300 focus:border-red-400 focus:ring-4 focus:ring-red-100'
        : 'border-slate-200 focus:border-accent focus:ring-4 focus:ring-accent/20');
@endphp

<div class="space-y-1.5">
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-semibold text-slate-700">
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
