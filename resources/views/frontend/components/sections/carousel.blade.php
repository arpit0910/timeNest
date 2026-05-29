<div x-data="{ 
    activeSlide: 0, 
    slides: {{ count($slides) }},
    next() { this.activeSlide = (this.activeSlide + 1) % this.slides },
    prev() { this.activeSlide = (this.activeSlide - 1 + this.slides) % this.slides },
    init() { setInterval(() => this.next(), 5000) }
}" class="relative w-full max-w-5xl mx-auto overflow-hidden rounded-2xl bg-white border border-surface-border shadow-2xl">
    
    <div class="relative h-[400px] w-full">
        @foreach($slides as $index => $slide)
            <div x-show="activeSlide === {{ $index }}"
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 translate-x-12"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-500 absolute inset-0"
                 x-transition:leave-start="opacity-100 translate-x-0"
                 x-transition:leave-end="opacity-0 -translate-x-12"
                 class="absolute inset-0 flex flex-col md:flex-row items-center bg-white"
                 x-cloak>
                 
                <div class="w-full md:w-1/2 h-64 md:h-full bg-surface-50 flex items-center justify-center p-8 border-b md:border-b-0 md:border-r border-surface-border">
                    <img src="{{ $slide['image'] }}" alt="{{ $slide['title'] }}" class="max-w-full max-h-full object-contain drop-shadow-xl rounded-xl">
                </div>
                
                <div class="w-full md:w-1/2 p-10 md:p-14 text-left flex flex-col justify-center">
                    <x-frontend-base.badge variant="brand" class="mb-4 self-start">{{ $slide['badge'] ?? 'Feature' }}</x-frontend-base.badge>
                    <h3 class="font-display text-2xl lg:text-3xl font-bold text-content-strong mb-4">{{ $slide['title'] }}</h3>
                    <p class="text-content-muted text-base leading-relaxed mb-8">{{ $slide['description'] }}</p>
                    
                    @if(isset($slide['url']))
                        <a href="{{ $slide['url'] }}" class="text-brand-600 font-semibold hover:text-brand-700 flex items-center gap-2 group w-max">
                            Learn more 
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    
    {{-- Controls --}}
    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex items-center gap-3 bg-white/80 glass px-4 py-2 rounded-full border border-surface-border shadow-sm">
        <button @click="prev()" class="p-1 text-content-muted hover:text-content-strong transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></button>
        <div class="flex gap-2">
            <template x-for="i in slides">
                <button @click="activeSlide = i - 1" class="w-2 h-2 rounded-full transition-all" :class="activeSlide === i - 1 ? 'bg-brand-600 w-6' : 'bg-surface-border hover:bg-content-muted'"></button>
            </template>
        </div>
        <button @click="next()" class="p-1 text-content-muted hover:text-content-strong transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></button>
    </div>
</div>
