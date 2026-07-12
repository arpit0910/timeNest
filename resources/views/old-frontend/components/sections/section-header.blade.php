<div class="{{ $align === 'center' ? 'text-center' : 'text-left' }} max-w-3xl {{ $align === 'center' ? 'mx-auto' : '' }} mb-12 {{ $class }}">
    @if($badge)
        <x-frontend-base.badge color="teal" class="mb-4">{{ $badge }}</x-frontend-base.badge>
    @endif
    <h2 class="font-display text-3xl sm:text-4xl font-bold text-content-strong mb-4">{{ $title }}</h2>
    @if($subtitle)
        <p class="text-content-muted text-lg leading-relaxed">{{ $subtitle }}</p>
    @endif
</div>
