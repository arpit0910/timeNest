@props([
    'heading' => 'Ready to secure',
    'headingHighlight' => 'your workforce',
    'subtext' => '',
])

<section class="py-12 md:py-16 bg-black relative">
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="bg-black rounded-[2rem] overflow-hidden relative flex flex-col md:flex-row items-center justify-between p-6 md:p-8 border-[1.5px] border-[#2ad4a3]/80 shadow-[0_0_30px_rgba(42,212,163,0.15)]">
            
            {{-- Left Content --}}
            <div class="relative z-10 max-w-xl">
                <h3 class="text-4xl md:text-5xl font-bold text-white mb-6 leading-tight tracking-tight">
                    {{ $heading }}
                    @if($headingHighlight)
                    <span class="relative inline-block text-white mt-1">
                        <span class="relative z-10 px-2 py-0.5">{{ $headingHighlight }}</span>
                        <span class="absolute bottom-1 left-0 w-full h-[60%] bg-[#215fe5] -z-0 rounded-sm"></span>
                    </span>
                    @endif
                </h3>
                
                @if($subtext)
                <p class="text-neutral-300 text-lg mb-8 leading-relaxed font-medium">
                    {{ $subtext }}
                </p>
                @endif
                
                @if(isset($buttons))
                    <div class="flex flex-col sm:flex-row items-center gap-6">
                        {{ $buttons }}
                    </div>
                @endif
            </div>

            {{-- Right Illustration --}}
            @if(isset($visual))
                <div class="relative z-10 mt-8 md:mt-0 flex-shrink-0 w-56 h-56 md:w-64 md:h-64 flex items-center justify-center">
                    {{ $visual }}
                </div>
            @endif

        </div>
    </div>
</section>

