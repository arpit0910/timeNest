<span {{ $attributes->merge(['class' => $badgeClasses()]) }}>
    @if($dot)
        <span class="relative flex h-2 w-2">
            @if($pulse)
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75 {{ $dotColorClass() }}"></span>
            @endif
            <span class="relative inline-flex rounded-full h-2 w-2 {{ $dotColorClass() }}"></span>
        </span>
    @endif
    {{ $slot }}
</span>
