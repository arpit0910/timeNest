<div class="{{ $align === 'center' ? 'text-center' : 'text-left' }} max-w-3xl {{ $align === 'center' ? 'mx-auto' : '' }} mb-12 {{ $class }}">
    @if($badge)
        <x-frontend-base.badge variant="brand" class="mb-4">{{ $badge }}</x-frontend-base.badge>
    @endif
    <h2 class="font-display text-3xl sm:text-4xl font-bold text-white mb-4">{{ $title }}</h2>
    @if($subtitle)
        <p class="text-slate-400 text-lg leading-relaxed">{{ $subtitle }}</p>
    @endif
</div>
