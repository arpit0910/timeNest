<div class="space-y-6 w-full relative overflow-hidden py-10 bg-zinc-950/40 border-y border-white/5">
    <!-- Gradient Edge Fade Masks -->
    <div class="absolute left-0 top-0 bottom-0 w-24 md:w-48 bg-gradient-to-r from-zinc-950 to-transparent z-10 pointer-events-none"></div>
    <div class="absolute right-0 top-0 bottom-0 w-24 md:w-48 bg-gradient-to-l from-zinc-950 to-transparent z-10 pointer-events-none"></div>

    <!-- Row 1: Scrolling Left (Normal Slow) -->
    <div class="flex overflow-hidden pause-hover select-none">
        <div class="flex gap-6 items-center justify-around min-w-full shrink-0 animate-marquee-horizontal-slow">
            @foreach($wall as $item)
                <div class="flex items-center gap-3 px-5 py-3 rounded-2xl bg-zinc-900 border border-white/5 shadow-md shrink-0">
                    <img src="{{ $item['avatar'] }}" alt="{{ $item['name'] }}" class="w-8 h-8 rounded-full border border-white/10 object-cover">
                    <div>
                        <div class="flex items-center gap-1.5">
                            <span class="font-bold text-white text-xs">{{ $item['name'] }}</span>
                            <span class="text-zinc-500 text-[10px]">{{ $item['company'] }}</span>
                        </div>
                        <p class="text-zinc-400 text-xs mt-0.5 font-body">"{{ $item['text'] }}"</p>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Duplicate Row 1 for Seamless Loop -->
        <div class="flex gap-6 items-center justify-around min-w-full shrink-0 animate-marquee-horizontal-slow" aria-hidden="true">
            @foreach($wall as $item)
                <div class="flex items-center gap-3 px-5 py-3 rounded-2xl bg-zinc-900 border border-white/5 shadow-md shrink-0">
                    <img src="{{ $item['avatar'] }}" alt="{{ $item['name'] }}" class="w-8 h-8 rounded-full border border-white/10 object-cover">
                    <div>
                        <div class="flex items-center gap-1.5">
                            <span class="font-bold text-white text-xs">{{ $item['name'] }}</span>
                            <span class="text-zinc-500 text-[10px]">{{ $item['company'] }}</span>
                        </div>
                        <p class="text-zinc-400 text-xs mt-0.5 font-body">"{{ $item['text'] }}"</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Row 2: Scrolling Right (Reverse Slow) -->
    <div class="flex overflow-hidden pause-hover select-none">
        <div class="flex gap-6 items-center justify-around min-w-full shrink-0 animate-marquee-horizontal-reverse-slow">
            @foreach(array_reverse($wall) as $item)
                <div class="flex items-center gap-3 px-5 py-3 rounded-2xl bg-zinc-900 border border-white/5 shadow-md shrink-0">
                    <img src="{{ $item['avatar'] }}" alt="{{ $item['name'] }}" class="w-8 h-8 rounded-full border border-white/10 object-cover">
                    <div>
                        <div class="flex items-center gap-1.5">
                            <span class="font-bold text-white text-xs">{{ $item['name'] }}</span>
                            <span class="text-zinc-500 text-[10px]">{{ $item['company'] }}</span>
                        </div>
                        <p class="text-zinc-400 text-xs mt-0.5 font-body">"{{ $item['text'] }}"</p>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Duplicate Row 2 for Seamless Loop -->
        <div class="flex gap-6 items-center justify-around min-w-full shrink-0 animate-marquee-horizontal-reverse-slow" aria-hidden="true">
            @foreach(array_reverse($wall) as $item)
                <div class="flex items-center gap-3 px-5 py-3 rounded-2xl bg-zinc-900 border border-white/5 shadow-md shrink-0">
                    <img src="{{ $item['avatar'] }}" alt="{{ $item['name'] }}" class="w-8 h-8 rounded-full border border-white/10 object-cover">
                    <div>
                        <div class="flex items-center gap-1.5">
                            <span class="font-bold text-white text-xs">{{ $item['name'] }}</span>
                            <span class="text-zinc-500 text-[10px]">{{ $item['company'] }}</span>
                        </div>
                        <p class="text-zinc-400 text-xs mt-0.5 font-body">"{{ $item['text'] }}"</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
