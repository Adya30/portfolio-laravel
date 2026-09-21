@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'target' => null,
    'type' => 'button',
    'icon' => null,
    'iconPosition' => 'left',
])

@php
    $variantClasses = [
        'primary' => 'btn-primary',
        'secondary' => 'btn-secondary',
        'ghost' => 'btn-ghost',
    ];

    $sizeClasses = [
        'sm' => 'btn-sm',
        'md' => 'btn-md',
        'lg' => 'btn-lg',
    ];

    $classes = trim(
        'btn ' . ($variantClasses[$variant] ?? 'btn-primary') . ' ' . ($sizeClasses[$size] ?? 'btn-md'),
    );
@endphp

@if ($href)
    <a href="{{ $href }}" @if ($target) target="{{ $target }}" rel="noopener noreferrer" @endif
        {{ $attributes->class([$classes]) }}>
        @if ($icon && $iconPosition === 'left')
            <i class="{{ $icon }} text-base leading-none" aria-hidden="true"></i>
        @endif
        {{ $slot }}
        @if ($icon && $iconPosition === 'right')
            <i class="{{ $icon }} text-base leading-none" aria-hidden="true"></i>
        @endif
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->class([$classes]) }}>
        @if ($icon && $iconPosition === 'left')
            <i class="{{ $icon }} text-base leading-none" aria-hidden="true"></i>
        @endif
        {{ $slot }}
        @if ($icon && $iconPosition === 'right')
            <i class="{{ $icon }} text-base leading-none" aria-hidden="true"></i>
        @endif
    </button>
@endif
