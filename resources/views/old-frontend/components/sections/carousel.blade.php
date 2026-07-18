<div x-data="{ 
    activeSlide: 0, 
    slides: {{ count($slides) }},
    direction: 1,
    autoplayInterval: null,
    next() { this.direction = 1; this.activeSlide = (this.activeSlide + 1) % this.slides },
    prev() { this.direction = -1; this.activeSlide = (this.activeSlide - 1 + this.slides) % this.slides },
    startAutoplay() {
        this.autoplayInterval = setInterval(() => { this.direction = 1; this.next(); }, 6000);
    },
    stopAutoplay() {
        if (this.autoplayInterval) {
            clearInterval(this.autoplayInterval);
            this.autoplayInterval = null;
        }
    },
    init() { this.startAutoplay() }
}" 
@mouseenter="stopAutoplay()" 
@mouseleave="startAutoplay()"
class="relative w-full max-w-6xl mx-auto">

    {{-- Ambient glow behind the card --}}
    <div class="absolute -inset-4 bg-gradient-to-r from-brand-500/8 via-indigo-500/6 to-violet-500/8 rounded-[2.5rem] blur-2xl pointer-events-none"></div>

    {{-- Main card --}}
    <div class="relative rounded-2xl sm:rounded-3xl bg-white border border-neutral-200/60 shadow-lg shadow-neutral-200/50 overflow-hidden">

        {{-- Slide container --}}
        <div class="relative w-full">
            @foreach($slides as $index => $slide)
                <div x-show="activeSlide === {{ $index }}"
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 translate-x-8"
                     x-transition:enter-end="opacity-100 translate-x-0"
                     x-transition:leave="transition ease-in duration-300 absolute inset-0"
                     x-transition:leave-start="opacity-100 translate-x-0"
                     x-transition:leave-end="opacity-0 -translate-x-8"
                     class="w-full"
                     :class="activeSlide === {{ $index }} ? '' : 'absolute inset-0'"
                     x-cloak>

                    <div class="flex flex-col md:flex-row">
                        {{-- Image panel — bigger images --}}
                        <div class="relative w-full md:w-[50%] lg:w-[52%] bg-gradient-to-br from-neutral-50 via-indigo-50/40 to-brand-50/30 shrink-0">
                            {{-- Decorative grid dots --}}
                            <div class="absolute inset-0 opacity-[0.04]" style="background-image: radial-gradient(circle, #6366f1 1px, transparent 1px); background-size: 20px 20px;"></div>
                            
                            <div class="relative flex items-center justify-center p-5 sm:p-8 md:p-8 lg:p-10 min-h-[220px] sm:min-h-[280px] md:min-h-[360px]">
                                <div class="relative group/img w-full max-w-md">
                                    {{-- Subtle image shadow --}}
                                    <div class="absolute -inset-3 bg-gradient-to-br from-brand-500/10 to-indigo-500/10 rounded-2xl blur-xl opacity-0 group-hover/img:opacity-100 transition-opacity duration-500"></div>
                                    <img src="{{ $slide['image'] }}" 
                                         alt="{{ $slide['title'] }}" 
                                         class="relative w-full h-auto object-contain rounded-xl shadow-md shadow-neutral-900/8 border border-white/80 bg-white/60 backdrop-blur-sm ring-1 ring-neutral-900/[0.04] hover:shadow-lg hover:scale-[1.02] transition-all duration-500">
                                </div>
                            </div>

                            {{-- Decorative accent line --}}
                            <div class="hidden md:block absolute right-0 top-[15%] bottom-[15%] w-px bg-gradient-to-b from-transparent via-neutral-200/80 to-transparent"></div>
                        </div>

                        {{-- Content panel --}}
                        <div class="w-full md:w-[50%] lg:w-[48%] p-5 sm:p-8 md:p-8 lg:p-12 flex flex-col justify-center">
                            {{-- Badge --}}
                            <div class="mb-3 sm:mb-4">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold tracking-wide bg-brand-50 text-brand-700 border border-brand-200/60 ring-1 ring-brand-500/10">
                                    <span class="w-1.5 h-1.5 rounded-full bg-brand-500 animate-pulse"></span>
                                    {{ $slide['badge'] ?? 'Feature' }}
                                </span>
                            </div>

                            {{-- Title --}}
                            <h3 class="font-display text-lg sm:text-xl lg:text-2xl xl:text-[1.7rem] font-bold text-neutral-900 mb-3 leading-[1.2] tracking-tight">{{ $slide['title'] }}</h3>
                            
                            {{-- Divider --}}
                            <div class="w-12 h-0.5 bg-gradient-to-r from-brand-400 to-indigo-400 rounded-full mb-3 sm:mb-4"></div>

                            {{-- Description --}}
                            <p class="text-neutral-500 text-[13px] sm:text-sm lg:text-[15px] leading-relaxed mb-4 sm:mb-5">{{ $slide['description'] }}</p>

                            {{-- Keyword badges --}}
                            @if(isset($slide['tags']))
                                <div class="flex flex-wrap gap-1.5 mb-5 sm:mb-6">
                                    @foreach($slide['tags'] as $tag)
                                        <span class="text-[10px] sm:text-[11px] font-semibold px-2.5 py-1 rounded-full bg-neutral-50 text-neutral-600 border border-neutral-200/60">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            @endif
                            
                            {{-- CTA --}}
                            @if(isset($slide['url']))
                                <a href="{{ $slide['url'] }}" 
                                   class="inline-flex items-center gap-2 text-sm font-semibold text-brand-600 hover:text-brand-700 group/cta w-max px-4 py-2 -ml-4 rounded-lg hover:bg-brand-50/60 transition-all duration-300">
                                    <span>Learn more</span>
                                    <svg class="w-4 h-4 group-hover/cta:translate-x-1.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Bottom controls bar --}}
        <div class="relative border-t border-neutral-100 bg-neutral-50/50">
            <div class="flex items-center justify-between px-4 sm:px-6 md:px-8 py-3 sm:py-3.5">
                {{-- Slide counter --}}
                <div class="text-xs font-medium text-neutral-400 tracking-wider tabular-nums">
                    <span class="text-neutral-700" x-text="String(activeSlide + 1).padStart(2, '0')">01</span>
                    <span class="mx-1.5 text-neutral-300">/</span>
                    <span>{{ str_pad(count($slides), 2, '0', STR_PAD_LEFT) }}</span>
                </div>

                {{-- Dot indicators --}}
                <div class="flex items-center gap-1.5 sm:gap-2">
                    <template x-for="i in slides">
                        <button @click="activeSlide = i - 1" 
                                class="relative h-1.5 rounded-full transition-all duration-500 ease-out"
                                :class="activeSlide === i - 1 
                                    ? 'w-6 sm:w-8 bg-gradient-to-r from-brand-500 to-indigo-500' 
                                    : 'w-1.5 bg-neutral-200 hover:bg-neutral-400'">
                        </button>
                    </template>
                </div>

                {{-- Nav buttons --}}
                <div class="flex items-center gap-1.5">
                    <button @click="prev()" 
                            class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg flex items-center justify-center text-neutral-400 hover:text-neutral-700 hover:bg-white hover:shadow-sm border border-transparent hover:border-neutral-200 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button @click="next()" 
                            class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg flex items-center justify-center text-neutral-400 hover:text-neutral-700 hover:bg-white hover:shadow-sm border border-transparent hover:border-neutral-200 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            {{-- Progress bar --}}
            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-neutral-100">
                <div class="h-full bg-gradient-to-r from-brand-400 to-indigo-400 transition-all duration-500 ease-out rounded-full"
                     :style="'width: ' + ((activeSlide + 1) / slides * 100) + '%'"></div>
            </div>
        </div>
    </div>
</div>


