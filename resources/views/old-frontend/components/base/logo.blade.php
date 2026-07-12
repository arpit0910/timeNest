@props([
    'size' => 'md',
    'variant' => 'full',
])

@php
    $svgClasses = match($size) {
        'sm' => 'w-6 h-6',
        'md' => 'w-8 h-8',
        'lg' => 'w-12 h-12',
        default => 'w-8 h-8',
    };

    $textClasses = match($size) {
        'sm' => 'text-lg',
        'md' => 'text-xl',
        'lg' => 'text-3xl',
        default => 'text-xl',
    };
@endphp

@if($variant === 'full')
<div class="flex items-center gap-2">
@endif
    <svg class="{{ $svgClasses }} shrink-0" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
        {{-- Outer Arc (270deg clock motif, open bottom-right) --}}
        <path d="M28 16 A12 12 0 1 0 16 28" stroke="#6366f1" stroke-width="1.8" stroke-linecap="round" />
        {{-- Inner Nest Lines (Concentric) --}}
        <path d="M23 16 A7 7 0 1 0 16 23" stroke="#cbd5e1" stroke-width="1.8" stroke-linecap="round" />
        <path d="M19 16 A3 3 0 1 0 16 19" stroke="#cbd5e1" stroke-width="1.8" stroke-linecap="round" />
    </svg>
@if($variant === 'full')
    <span class="font-display font-bold tracking-tight {{ $textClasses }}">
        <span class="text-white">Time</span><span class="text-[#6366f1]">Nest</span>
    </span>
</div>
@endif
