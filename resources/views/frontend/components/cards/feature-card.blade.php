<div class="group rounded-xl border border-surface-border bg-surface-card p-6 hover:border-brand-500/30 hover:shadow-lg hover:shadow-brand-500/5 transition-all duration-300 {{ $class }}">
    @if($icon)
        <div class="w-10 h-10 rounded-lg bg-brand-500/10 flex items-center justify-center mb-4 group-hover:bg-brand-500/20 transition-colors">
            <span class="text-brand-400 w-5 h-5">{!! $icon !!}</span>
        </div>
    @endif
    <h3 class="font-display text-lg font-semibold text-content-strong mb-2">{{ $title }}</h3>
    <p class="text-content-muted text-sm leading-relaxed">{{ $description }}</p>
    @if($href)
        <a href="{{ $href }}" class="inline-flex items-center gap-1 text-brand-400 text-sm mt-3 hover:text-brand-300 transition-colors">
            Learn more
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    @endif
</div>
