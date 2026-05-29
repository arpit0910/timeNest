<div class="relative rounded-xl border {{ $highlighted ? 'border-brand-500 bg-surface-card shadow-xl shadow-brand-500/10' : 'border-surface-border bg-surface-card' }} p-8 flex flex-col {{ $class }}">
    @if($badge)
        <div class="absolute -top-3 left-1/2 -translate-x-1/2">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-brand-500 text-content-strong">{{ $badge }}</span>
        </div>
    @endif

    <div class="mb-6">
        <h3 class="font-display text-xl font-bold text-content-strong mb-2">{{ $name }}</h3>
        <p class="text-content-muted text-sm">{{ $description }}</p>
    </div>

    <div class="mb-6">
        <span class="font-display text-4xl font-bold text-content-strong">{{ $price }}</span>
        @if($period)
            <span class="text-content-muted text-sm">{{ $period }}</span>
        @endif
    </div>

    <ul class="space-y-3 mb-8 flex-1">
        @foreach($features as $feature)
            <li class="flex items-start gap-3 text-sm">
                <svg class="w-5 h-5 text-brand-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span class="text-content">{{ $feature }}</span>
            </li>
        @endforeach
    </ul>

    <x-frontend-base.button
        :href="$ctaUrl"
        :variant="$highlighted ? 'primary' : 'outline'"
        :color="$highlighted ? 'brand' : 'white'"
        size="lg"
        class="w-full"
    >
        {{ $ctaText }}
    </x-frontend-base.button>
</div>
