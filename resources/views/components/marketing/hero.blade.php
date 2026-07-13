<section class="relative pt-32 pb-20 md:pt-40 md:pb-28 overflow-hidden min-h-[90vh] flex flex-col justify-center">
    
    {{-- Ambient Background Layer (External SVG) --}}
    <x-marketing.hero-background />
    
    {{-- Main Content --}}
    <div class="relative max-w-7xl mx-auto px-6 w-full flex flex-col items-center">
        
        {{-- Headline & Text (Highest z-index) --}}
        <div class="text-center max-w-3xl mx-auto flex flex-col items-center relative z-40">
            <div class="animate-fade-up">
                <x-ui.pill-badge class="mb-6">
                    <x-slot:icon>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </x-slot:icon>
                    Trusted by growing teams
                </x-ui.pill-badge>
            </div>
            
            <h1 class="text-5xl md:text-7xl font-extrabold text-slate-900 tracking-tight leading-[1.1] mb-6 animate-fade-up delay-100">
                The Workforce Platform <br />
                Built for Trust & Speed
            </h1>
            
            <p class="text-lg md:text-xl text-slate-500 max-w-[600px] leading-relaxed mb-10 animate-fade-up delay-200">
                TimeNest unifies attendance, leave, worklogs, and secure team chat in one platform — encrypted end-to-end, and fast enough to keep up with your team.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 animate-fade-up delay-300 w-full sm:w-auto">
                <x-ui.button href="#" class="w-full sm:w-auto">Book a demo</x-ui.button>
                <x-ui.button variant="secondary" href="#" class="w-full sm:w-auto">Talk to Expert</x-ui.button>
            </div>
        </div>

        {{-- Floating Elements Container --}}
        <div class="relative w-full mt-24 md:mt-16 flex flex-col md:block items-center gap-8">
            
            {{-- Network Diagram (Centered) --}}
            <div class="relative md:absolute md:top-24 md:left-1/2 md:-translate-x-1/2 w-full flex justify-center z-20">
                <x-marketing.hero-network-diagram />
            </div>

            {{-- Stat Card (Upper Left on Desktop) --}}
            <div class="relative md:absolute md:-top-10 md:left-4 lg:left-12 z-30 animate-float">
                <x-marketing.hero-stat-card />
            </div>

            {{-- Security Badge (Upper Right on Desktop) --}}
            <div class="relative md:absolute md:-top-4 md:right-4 lg:right-12 z-30">
                <x-marketing.hero-security-badge />
            </div>
            
            {{-- Spacer for mobile flow --}}
            <div class="h-8 md:h-[400px]"></div>
        </div>
        
    </div>
</section>
