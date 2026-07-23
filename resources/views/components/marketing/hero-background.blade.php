@if (request()->routeIs('frontend.home'))
<div class="absolute inset-0 z-0 overflow-hidden bg-black" id="dotted-surface-container" aria-hidden="true">
    {{-- The animated surface is intentionally exclusive to the home page. --}}

    {{-- Subtle Center Radial Glow to highlight hero text --}}
    <div class="absolute top-[10%] left-1/2 -translate-x-1/2 w-[900px] h-[600px] bg-accent-600/10 rounded-full filter blur-[150px] pointer-events-none z-10"></div>
</div>
@else
<div class="absolute inset-0 z-0 overflow-hidden bg-black" aria-hidden="true">
    <div class="absolute inset-0 marketing-hero-glow"></div>
</div>
@endif
