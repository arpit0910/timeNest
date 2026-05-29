<section class="py-16 border-y border-surface-border bg-surface-card/50 {{ $class }}">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            @foreach($stats as $stat)
                <div class="text-center">
                    <p class="font-display text-4xl font-bold text-white mb-1">
                        {{ $stat['value'] }}<span class="text-brand-400">{{ $stat['suffix'] ?? '' }}</span>
                    </p>
                    <p class="text-slate-400 text-sm">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
