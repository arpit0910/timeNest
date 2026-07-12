<div class="relative w-full rounded-2xl overflow-hidden bg-zinc-900/60 border border-white/5 group shadow-lg flex flex-col h-full isolate"
     x-data="{ isPlaying: false }">
    
    <!-- Video Player Frame Area -->
    <div class="relative w-full aspect-video overflow-hidden bg-zinc-950 border-b border-white/5">
        <template x-if="!isPlaying">
            <div class="absolute inset-0 cursor-pointer" @click="isPlaying = true">
                <!-- Thumbnail Image -->
                <img src="{{ $video['thumbnail'] }}" alt="{{ $video['name'] }}" 
                     class="w-full h-full object-cover opacity-70 group-hover:opacity-60 group-hover:scale-[1.03] transition-all duration-500" 
                     loading="lazy">
                <!-- Dark Tint Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-transparent to-black/10"></div>
                
                <!-- Play Button overlay -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-14 h-14 rounded-full bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center group-hover:scale-110 group-hover:bg-indigo-600 group-hover:border-indigo-500 transition-all duration-300 shadow-md">
                        <svg class="w-6 h-6 text-white ml-0.5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </div>
                </div>

                <!-- Short Outcome Badge (on thumbnail) -->
                <div class="absolute bottom-3 right-3 bg-indigo-500/90 text-white font-mono text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-md border border-indigo-400/20 backdrop-blur-sm shadow-sm">
                    {{ $video['outcome'] }}
                </div>
            </div>
        </template>

        <template x-if="isPlaying">
            <iframe class="absolute inset-0 w-full h-full" 
                    src="https://www.youtube.com/embed/{{ $video['video_id'] }}?autoplay=1&modestbranding=1&rel=0" 
                    title="Customer Review" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                    allowfullscreen>
            </iframe>
        </template>
    </div>

    <!-- Metadata Details Area -->
    <div class="p-6 flex flex-col flex-grow justify-between text-left relative">
        <div class="absolute -top-12 -left-12 w-24 h-24 bg-indigo-500/5 rounded-full blur-2xl pointer-events-none"></div>

        <p class="text-zinc-300 text-sm italic font-body leading-relaxed mb-6 flex-grow">
            "{{ $video['quote'] }}"
        </p>

        <div class="flex items-center gap-3 pt-4 border-t border-white/5">
            <div class="w-9 h-9 rounded-full bg-zinc-800 flex items-center justify-center text-zinc-300 font-display text-sm font-bold border border-white/5 overflow-hidden">
                {{ strtoupper(substr($video['name'], 0, 1)) }}
            </div>
            <div>
                <h4 class="font-bold text-white text-sm tracking-tight">{{ $video['name'] }}</h4>
                <p class="text-zinc-500 text-[11px] font-medium leading-none mt-1">{{ $video['role'] }} · <span class="text-indigo-400/80">{{ $video['company'] }}</span></p>
            </div>
        </div>
    </div>
</div>
