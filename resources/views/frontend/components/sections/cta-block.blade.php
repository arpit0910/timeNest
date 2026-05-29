<section class="relative py-24 bg-surface overflow-hidden {{ $class }}">
    <div class="absolute inset-0 bg-gradient-to-b from-brand-500/5 to-transparent"></div>
    <div class="relative z-10 max-w-4xl mx-auto px-6 lg:px-8 text-center">
        <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4">{{ $headline }}</h2>
        @if($subheadline)
            <p class="text-slate-400 text-lg mb-8">{{ $subheadline }}</p>
        @endif
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            @if($primaryCtaText)
                <x-frontend-base.button :href="$primaryCtaUrl" variant="primary" color="brand" size="lg">{{ $primaryCtaText }}</x-frontend-base.button>
            @endif
            @if($secondaryCtaText)
                <x-frontend-base.button :href="$secondaryCtaUrl" variant="outline" color="white" size="lg">{{ $secondaryCtaText }}</x-frontend-base.button>
            @endif
        </div>
    </div>
</section>
