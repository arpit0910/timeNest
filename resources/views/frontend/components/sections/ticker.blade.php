<div class="relative overflow-hidden flex bg-surface-50 py-10 border-y border-surface-border">
    {{-- Gradient fades for smooth edge hiding --}}
    <div class="absolute top-0 bottom-0 left-0 w-32 bg-gradient-to-r from-surface-50 to-transparent z-10"></div>
    <div class="absolute top-0 bottom-0 right-0 w-32 bg-gradient-to-l from-surface-50 to-transparent z-10"></div>
    
    <div class="flex animate-[ticker_30s_linear_infinite] whitespace-nowrap">
        {{-- First set of items --}}
        <div class="flex items-center gap-16 px-8">
            @foreach($items as $item)
                <div class="flex items-center gap-3 text-content-muted hover:text-content-strong transition-colors cursor-pointer group">
                    <div class="w-10 h-10 rounded-xl bg-white border border-surface-border flex items-center justify-center group-hover:border-brand-500 group-hover:shadow-md transition-all">
                        <svg class="w-5 h-5 text-content-muted group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $item['icon'] !!}</svg>
                    </div>
                    <span class="font-display font-semibold text-lg">{{ $item['name'] }}</span>
                </div>
            @endforeach
        </div>
        
        {{-- Duplicate set for infinite loop --}}
        <div class="flex items-center gap-16 px-8">
            @foreach($items as $item)
                <div class="flex items-center gap-3 text-content-muted hover:text-content-strong transition-colors cursor-pointer group">
                    <div class="w-10 h-10 rounded-xl bg-white border border-surface-border flex items-center justify-center group-hover:border-brand-500 group-hover:shadow-md transition-all">
                        <svg class="w-5 h-5 text-content-muted group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $item['icon'] !!}</svg>
                    </div>
                    <span class="font-display font-semibold text-lg">{{ $item['name'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
@keyframes ticker {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
</style>
