<div class="space-y-12 max-w-7xl mx-auto" x-data="{ activeIndex: 0, total: {{ count($caseStudies) }} }">
    <!-- Section Header for Carousel -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div class="text-left max-w-xl">
            <h3 class="text-zinc-500 font-mono text-xs uppercase tracking-widest font-bold mb-2">Success Stories In Detail</h3>
            <h4 class="text-2xl md:text-3xl font-display font-bold text-white tracking-tight">How our customers achieve operational excellence.</h4>
        </div>
        
        <!-- Navigation Buttons -->
        <div class="flex items-center gap-3">
            <button @click="activeIndex = (activeIndex - 1 + total) % total" 
                    class="w-12 h-12 rounded-xl bg-zinc-900 border border-white/5 text-zinc-400 hover:text-white hover:border-white/10 hover:bg-zinc-800 flex items-center justify-center cursor-pointer transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <button @click="activeIndex = (activeIndex + 1) % total" 
                    class="w-12 h-12 rounded-xl bg-zinc-900 border border-white/5 text-zinc-400 hover:text-white hover:border-white/10 hover:bg-zinc-800 flex items-center justify-center cursor-pointer transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Carousel Container -->
    <div class="relative overflow-hidden w-full rounded-3xl border border-white/5 bg-zinc-950/40 p-4 md:p-8">
        <div class="flex transition-transform duration-500 ease-out" 
             :style="'transform: translateX(-' + (activeIndex * 100) + '%)'">
            
            @foreach($caseStudies as $study)
                <div class="w-full shrink-0 px-2">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                        
                        <!-- Left Side: Case Study Information (7 cols) -->
                        <div class="lg:col-span-7 space-y-6 text-left p-2 md:p-6">
                            <div class="flex items-center gap-4">
                                <span class="text-indigo-400 font-display text-2xl font-black uppercase tracking-wider">{{ $study['company'] }}</span>
                                <span class="w-1.5 h-1.5 rounded-full bg-zinc-700"></span>
                                <span class="text-zinc-400 text-xs md:text-sm font-medium">{{ $study['industry'] }}</span>
                            </div>

                            <div class="inline-flex items-center gap-2 bg-zinc-900 border border-white/5 px-3 py-1 rounded-xl text-xs text-zinc-400 font-medium font-mono">
                                Team Size: {{ $study['team_size'] }}
                            </div>

                            <h5 class="text-lg md:text-xl font-display font-medium text-white">Business Outcomes:</h5>
                            
                            <ul class="space-y-3">
                                @foreach($study['results'] as $result)
                                    <li class="flex items-start gap-3">
                                        <span class="w-5 h-5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0 mt-0.5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </span>
                                        <span class="text-zinc-300 text-sm md:text-base font-body">{{ $result }}</span>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="pt-6">
                                <a href="#" 
                                   class="inline-flex items-center gap-2 bg-zinc-900 hover:bg-zinc-800 border border-white/10 text-white font-medium text-xs md:text-sm px-5 py-2.5 rounded-xl transition-all duration-300 cursor-pointer shadow-md">
                                    Read Full Story
                                    <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- Right Side: Imagery (5 cols) -->
                        <div class="lg:col-span-5 h-[280px] md:h-[380px] rounded-2xl overflow-hidden border border-white/5 relative group/img">
                            <img src="{{ $study['image'] }}" alt="{{ $study['company'] }} case study" 
                                 class="w-full h-full object-cover group-hover/img:scale-105 transition-transform duration-700 opacity-80">
                            <div class="absolute inset-0 bg-gradient-to-t from-zinc-950/80 to-transparent"></div>
                        </div>

                    </div>
                </div>
            @endforeach

        </div>
    </div>

    <!-- Pagination Dots -->
    <div class="flex items-center justify-center gap-2 pt-4">
        @foreach($caseStudies as $index => $study)
            <button @click="activeIndex = {{ $index }}" 
                    class="h-2 rounded-full transition-all duration-300 cursor-pointer"
                    :class="activeIndex === {{ $index }} ? 'w-8 bg-indigo-500' : 'w-2 bg-zinc-800 hover:bg-zinc-700'"></button>
        @endforeach
    </div>
</div>


