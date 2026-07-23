<section class="py-32 bg-black relative marketing-cta">
    <div class="max-w-7xl mx-auto px-6">
        
        <div class="w-full bg-black rounded-3xl py-24 px-6 flex flex-col items-center justify-center text-center shadow-2xl">
            
            {{-- Status Badge --}}
            <div class="flex items-center gap-2 mb-8">
                <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                <span class="text-neutral-400 text-xs font-bold tracking-widest uppercase">Free 14-Day Trial</span>
            </div>
            
            {{-- Headline --}}
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-semibold text-white mb-6 tracking-tight max-w-4xl leading-tight marketing-heading">
                Tired of manual timesheets?
            </h2>
            
            {{-- Subtitle --}}
            <p class="text-neutral-400 text-lg md:text-xl mb-12 max-w-2xl font-medium">
                Join thousands of companies automating their workflow today.
            </p>
            
            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <x-ui.button href="{{ route('frontend.book-demo') }}" class="w-full sm:w-auto">Book a demo</x-ui.button>
                <x-ui.button variant="secondary" href="/contact" class="w-full sm:w-auto">Contact us</x-ui.button>
            </div>
            
        </div>
        
    </div>
</section>
