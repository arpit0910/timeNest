<section class="py-12 border-b border-surface-border {{ $class }}">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center">
        <p class="text-content-light text-sm font-body mb-8">{{ $title }}</p>
        <div class="flex items-center justify-center gap-12 flex-wrap opacity-40">
            @if(count($logos) > 0)
                @foreach($logos as $logo)
                    <div class="h-8 text-content-muted">{!! $logo !!}</div>
                @endforeach
            @else
                {{-- Placeholder logos --}}
                @foreach(['Acme Corp', 'Stellar Inc', 'NovaTech', 'QuantumHR', 'CloudSync', 'DataPrime'] as $name)
                    <div class="font-display text-lg font-bold text-content-muted tracking-wider">{{ $name }}</div>
                @endforeach
            @endif
        </div>
    </div>
</section>
