<section {{ $attributes->merge(['class' => 'relative pt-32 pb-14 lg:pt-48 lg:pb-20 overflow-hidden']) }}
    x-data="{ mx: 0, my: 0 }" 
    @mousemove.window="mx = ($event.clientX / window.innerWidth - 0.5) * 4; my = ($event.clientY / window.innerHeight - 0.5) * 3"
>
    {{-- Layer 1: Gradient Background --}}
    <div class="absolute inset-0 bg-gradient-to-b from-slate-50 via-white to-white pointer-events-none"></div>
    <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/4 w-[900px] h-[600px] bg-gradient-to-br from-teal-100/40 via-indigo-100/30 to-purple-100/20 rounded-full blur-3xl opacity-60 pointer-events-none"></div>

    {{-- Layer 2: Hero Content --}}
    <div class="relative z-30 max-w-7xl mx-auto px-6 lg:px-8 text-center">
        {{-- Announcement Pill --}}
        @if($badgeText)
        <div class="opacity-0 animate-hero-fade-up" style="animation-delay: 0ms;">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/60 backdrop-blur-md border border-slate-200/80 shadow-[0_2px_8px_-2px_rgba(0,0,0,0.05)] mb-8 cursor-pointer hover:border-brand-500/30 hover:shadow-md transition-all duration-300">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-teal-500"></span>
                </span>
                <span class="text-[13px] font-semibold text-slate-800 tracking-wide">{{ $badgeText }}</span>
            </div>
        </div>
        @endif
        
        {{-- Main Heading with mouse parallax --}}
        <div :style="'transform: translate3d(' + mx + 'px, ' + my + 'px, 0)'" class="transition-transform duration-700 ease-out">
            <h1 class="font-display text-5xl lg:text-7xl font-bold text-content-strong tracking-tight mb-2 leading-tight">
                <span class="block opacity-0 animate-hero-fade-up" style="animation-delay: 200ms;">{{ $title }}</span>
                <span class="relative inline-block opacity-0 animate-hero-fade-up" style="animation-delay: 400ms;">
                    <span class="hero-text-glow"></span>
                    <span class="relative text-gradient-animated">for Modern Teams</span>
                </span>
            </h1>
        </div>
        
        {{-- Subheading --}}
        <p class="text-lg lg:text-xl text-content-body max-w-3xl mx-auto mb-10 leading-relaxed font-body opacity-0 animate-hero-fade-up" style="animation-delay: 600ms;">
            {{ $subtitle }}
        </p>
        
        {{-- CTA Buttons --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 opacity-0 animate-hero-fade-up" style="animation-delay: 800ms;">
            <x-frontend-base.button href="#" variant="primary" color="brand" size="lg" class="w-full sm:w-auto h-14 px-8 text-base">
                Start for Free
            </x-frontend-base.button>
            <button @click="$dispatch('open-book-demo')" class="w-full sm:w-auto h-14 px-8 text-base font-semibold rounded-xl border border-brand-200 text-brand-600 hover:bg-brand-50 hover:border-brand-300 transition-colors">
                Book a Demo
            </button>
        </div>
    </div>
</section>
