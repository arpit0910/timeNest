<section class="relative pt-32 pb-20 md:pt-40 md:pb-28 overflow-hidden min-h-[90vh] flex flex-col justify-center bg-black">
    
    {{-- Ambient Background Layer (External SVG) --}}
    <x-marketing.hero-background />
    
    {{-- Main Content --}}
    <div class="relative max-w-7xl mx-auto px-6 w-full flex flex-col items-center">
        
        {{-- Headline & Text (Highest z-index) --}}
        <div class="text-center max-w-3xl mx-auto flex flex-col items-center relative z-40">
            <div class="animate-fade-up">
            </div>
            
            <h1 class="text-5xl md:text-7xl font-extrabold text-white tracking-tight leading-[1.1] mb-6 animate-fade-up delay-100 marketing-heading">
                The Workforce Platform Built for Trust & Speed
            </h1>
            
            <p class="text-lg md:text-xl text-neutral-400 max-w-[600px] leading-relaxed mb-10 animate-fade-up delay-200">
                TimeNest unifies attendance, leave, worklogs, and secure team chat in one platform — encrypted end-to-end, and fast enough to keep up with your team.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 animate-fade-up delay-300 w-full sm:w-auto">
                <x-ui.button href="{{ route('frontend.book-demo') }}" class="w-full sm:w-auto">Book a demo</x-ui.button>
                <x-ui.button variant="secondary" href="/contact" class="w-full sm:w-auto">Talk to Expert</x-ui.button>
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
            <div class="relative md:absolute md:-top-4 md:right-4 lg:right-12 z-30 animate-float-alt">
                <x-marketing.hero-security-badge />
            </div>
            
            {{-- Spacer for mobile flow --}}
            <div class="h-8 md:h-[400px]"></div>
        </div>
        
    </div>
</section>

