<div class="relative w-full max-w-7xl mx-auto rounded-[32px] overflow-hidden bg-zinc-950 border border-white/5 group shadow-[0_24px_50px_-12px_rgba(0,0,0,0.8)] h-[550px] md:h-[650px] flex flex-col justify-end p-6 md:p-16 isolate"
     x-data="{ isOpen: false }">
    
    <!-- Background Image with Dark & Gradient Overlays -->
    <img src="{{ $story['bg_image'] }}" alt="Featured customer story" 
         class="absolute inset-0 w-full h-full object-cover opacity-50 group-hover:opacity-40 group-hover:scale-[1.02] transition-all duration-700 pointer-events-none">
    <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/50 to-transparent z-10 pointer-events-none"></div>
    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors duration-500 z-10 pointer-events-none"></div>

    <!-- Background Accent Glow -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-indigo-500/10 rounded-full blur-[120px] pointer-events-none"></div>

    <!-- Center Play Button Container -->
    <div class="absolute inset-0 flex items-center justify-center z-20">
        <button @click="isOpen = true" 
                class="w-20 h-20 md:w-24 md:h-24 rounded-full bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center cursor-pointer transition-all duration-500 hover:scale-110 hover:bg-indigo-600 hover:border-indigo-500 hover:shadow-[0_0_50px_rgba(99,102,241,0.5)] group/btn relative">
            <span class="absolute inset-0 rounded-full bg-white/10 animate-ping opacity-70 group-hover/btn:bg-indigo-600/30"></span>
            <svg class="w-8 h-8 md:w-10 md:h-10 text-white ml-1.5 transition-transform duration-300 group-hover/btn:scale-110" 
                 fill="currentColor" viewBox="0 0 24 24">
                <path d="M8 5v14l11-7z"/>
            </svg>
        </button>
    </div>

    <!-- Content Layer (Bottom Left) -->
    <div class="relative z-20 max-w-4xl space-y-6 text-left">
        <!-- Floating Glass Badge -->
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/5 backdrop-blur-md border border-white/10 text-xs font-semibold text-indigo-300 tracking-wide">
            <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-pulse"></span>
            Featured Customer Story
        </div>

        <!-- Big Bold Typography Quote -->
        <h3 class="text-2xl md:text-4xl lg:text-5xl font-display font-medium text-white leading-tight md:leading-normal tracking-tight">
            "{{ $story['quote'] }}"
        </h3>

        <!-- Customer Identity Meta -->
        <div class="flex flex-col sm:flex-row sm:items-center gap-4 pt-4 border-t border-white/10">
            <div class="flex items-center gap-3">
                <img src="{{ $story['avatar'] }}" alt="{{ $story['name'] }}" 
                     class="w-12 h-12 rounded-full border-2 border-white/20 object-cover shadow-md">
                <div>
                    <h4 class="font-bold text-white text-base md:text-lg">{{ $story['name'] }}</h4>
                    <p class="text-zinc-400 text-xs md:text-sm font-medium">{{ $story['role'] }} · {{ $story['company'] }}</p>
                </div>
            </div>
            
            <div class="hidden sm:block w-px h-8 bg-white/10"></div>

            <div class="flex items-center gap-2 text-indigo-400 text-sm font-bold bg-indigo-500/10 px-3.5 py-1.5 rounded-xl border border-indigo-500/20 w-fit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                {{ $story['outcome'] }}
            </div>
        </div>
    </div>

    <!-- Video Modal Portal (Lazy Loaded Video) -->
    <template x-teleport="body">
        <div x-show="isOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-zinc-950/90 backdrop-blur-xl"
             @keydown.escape.window="isOpen = false"
             style="display: none;">
            
            <!-- Backdrop Click to Close -->
            <div class="absolute inset-0" @click="isOpen = false"></div>

            <!-- Modal Content Card -->
            <div class="relative w-full max-w-5xl aspect-video rounded-3xl overflow-hidden bg-black border border-white/10 shadow-2xl z-10"
                 x-transition:enter="transition ease-out duration-300 transform scale-95"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200 transform scale-100"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95">
                
                <!-- Close Button -->
                <button @click="isOpen = false" 
                        class="absolute top-4 right-4 z-20 w-10 h-10 rounded-full bg-black/50 hover:bg-black/80 border border-white/10 text-white flex items-center justify-center cursor-pointer transition-colors duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <!-- Lazy Loaded iframe Embed -->
                <template x-if="isOpen">
                    <iframe class="w-full h-full" 
                            src="https://www.youtube.com/embed/{{ $story['video_id'] }}?autoplay=1&modestbranding=1&rel=0" 
                            title="TimeNest Customer Success Story" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                            allowfullscreen>
                    </iframe>
                </template>
            </div>
        </div>
    </template>
</div>
