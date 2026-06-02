@if($variant === 'middle')
    <!-- Middle CTA -->
    <section class="py-20 lg:py-28 bg-brand-900 relative overflow-hidden border-y border-brand-800">
        <div class="absolute inset-0 bg-gradient-to-tr from-brand-950 to-indigo-900 pointer-events-none"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-4xl h-96 bg-brand-500/20 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="max-w-4xl mx-auto px-6 lg:px-8 text-center relative z-10">
            <h2 class="font-display text-4xl lg:text-5xl font-bold text-white tracking-tight mb-6">
                See how TimeNest fits your organization
            </h2>
            <p class="text-xl text-brand-100 font-body mb-10 max-w-2xl mx-auto">
                Stop juggling multiple platforms. Manage your entire workforce operations in a unified environment.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <button @click="$dispatch('open-book-demo')" class="w-full sm:w-auto px-8 py-4 bg-white text-brand-900 rounded-xl font-bold hover:bg-slate-50 transition-colors shadow-lg shadow-white/10">
                    Book a Demo
                </button>
                <a href="/contact" class="w-full sm:w-auto px-8 py-4 border border-white/20 text-white rounded-xl font-bold hover:bg-white/10 transition-colors">
                    Contact Sales
                </a>
            </div>
        </div>
    </section>
@else
    <!-- Final CTA -->
    <section class="py-24 lg:py-32 bg-black relative overflow-hidden">
        <!-- Abstract glowing background -->
        <div class="absolute inset-0 bg-[url('/img/noise.png')] opacity-20 mix-blend-overlay pointer-events-none"></div>
        <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-3/4 h-80 bg-indigo-500/30 rounded-[100%] blur-[120px] pointer-events-none"></div>
        
        <div class="max-w-5xl mx-auto px-6 lg:px-8 text-center relative z-10">
            <h2 class="font-display text-5xl lg:text-7xl font-black text-white tracking-tight mb-8">
                Ready to simplify your workforce operations?
            </h2>
            <p class="text-xl lg:text-2xl text-slate-400 font-body mb-12 max-w-3xl mx-auto">
                Join modern teams who have switched to TimeNest and reduced their administrative overhead by 40%.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <button @click="$dispatch('open-book-demo')" class="w-full sm:w-auto px-10 py-5 bg-brand-500 text-white rounded-xl font-bold text-lg hover:bg-brand-400 transition-colors shadow-lg shadow-brand-500/20">
                    Book a Live Demo
                </button>
            </div>
        </div>
    </section>
@endif
