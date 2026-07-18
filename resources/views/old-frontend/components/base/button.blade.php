@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $buttonClasses()]) }}>
        <span class="btn-shine"></span>
        <span class="relative z-10 inline-flex items-center justify-center gap-2">
            @if($iconLeft)<span class="w-4 h-4">{!! $iconLeft !!}</span>@endif
            @if($loading)<svg class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>@endif
            {{ $slot }}
            @if($iconRight)<span class="w-4 h-4 inline-flex transition-transform duration-300 group-hover:translate-x-1">{!! $iconRight !!}</span>@endif
        </span>
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $buttonClasses()]) }} @if($disabled) disabled @endif>
        <span class="btn-shine"></span>
        <span class="relative z-10 inline-flex items-center justify-center gap-2">
            @if($iconLeft)<span class="w-4 h-4">{!! $iconLeft !!}</span>@endif
            @if($loading)<svg class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>@endif
            {{ $slot }}
            @if($iconRight)<span class="w-4 h-4 inline-flex transition-transform duration-300 group-hover:translate-x-1">{!! $iconRight !!}</span>@endif
        </span>
    </button>
@endif


