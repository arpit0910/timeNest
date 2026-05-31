<div class="w-full relative overflow-hidden py-10 bg-zinc-950 border-y border-white/5">
    <!-- Gradient Masks for Premium Fade Effect at Edges -->
    <div class="absolute left-0 top-0 bottom-0 w-24 md:w-48 bg-gradient-to-r from-zinc-950 to-transparent z-10 pointer-events-none"></div>
    <div class="absolute right-0 top-0 bottom-0 w-24 md:w-48 bg-gradient-to-l from-zinc-950 to-transparent z-10 pointer-events-none"></div>

    <div class="flex overflow-hidden pause-hover select-none">
        <!-- First group of logos -->
        <div class="flex gap-16 items-center justify-around min-w-full shrink-0 animate-marquee-horizontal-slow">
            @foreach($logos as $logo)
                <div class="flex items-center gap-2 group cursor-pointer">
                    <!-- Stylized Dot -->
                    <span class="w-2 h-2 rounded-full bg-indigo-500/30 group-hover:bg-indigo-500 transition-colors duration-300"></span>
                    <span class="text-zinc-600 group-hover:text-zinc-300 font-display text-base md:text-lg font-bold tracking-widest uppercase transition-colors duration-300">
                        {{ $logo }}
                    </span>
                </div>
            @endforeach
        </div>
        <!-- Duplicated group of logos for seamless loop -->
        <div class="flex gap-16 items-center justify-around min-w-full shrink-0 animate-marquee-horizontal-slow" aria-hidden="true">
            @foreach($logos as $logo)
                <div class="flex items-center gap-2 group cursor-pointer">
                    <!-- Stylized Dot -->
                    <span class="w-2 h-2 rounded-full bg-indigo-500/30 group-hover:bg-indigo-500 transition-colors duration-300"></span>
                    <span class="text-zinc-600 group-hover:text-zinc-300 font-display text-base md:text-lg font-bold tracking-widest uppercase transition-colors duration-300">
                        {{ $logo }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>
</div>
