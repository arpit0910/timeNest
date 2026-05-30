<section class="py-16 border-y border-surface-border bg-surface-card/50 {{ $class ?? '' }} overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 lg:gap-12">
            @foreach($stats as $stat)
                <div class="text-center group hover:-translate-y-1 transition-all duration-300" 
                     x-data="{ shown: false }" 
                     x-init="const obs = new IntersectionObserver(([e]) => { if(e.isIntersecting) { shown = true; obs.disconnect(); } }, {threshold: 0.1}); obs.observe($el);">
                    <p class="font-display text-4xl lg:text-5xl font-bold text-content-strong mb-3 tracking-tight group-hover:text-brand-600 transition-colors duration-300"
                       :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
                       style="transition: all 0.7s cubic-bezier(0.16, 1, 0.3, 1) {{ $loop->index * 150 }}ms;"
                    >
                        {{ $stat['prefix'] ?? '' }}<span 
                            x-data="{ count: 0, target: {{ $stat['value'] }} }" 
                            x-init="$watch('shown', val => { 
                                if(val) {
                                    let start = null; 
                                    const duration = 2000; 
                                    const step = (timestamp) => { 
                                        if (!start) start = timestamp; 
                                        const progress = Math.min((timestamp - start) / duration, 1);
                                        const easeOutQuart = 1 - Math.pow(1 - progress, 4);
                                        count = Math.floor(easeOutQuart * target); 
                                        if (progress < 1) window.requestAnimationFrame(step); 
                                        else count = target; 
                                    }; 
                                    window.requestAnimationFrame(step);
                                }
                            })" 
                            x-text="target >= 1000 ? count.toLocaleString() : count"
                        >0</span><span class="text-brand-500">{{ $stat['suffix'] ?? '' }}</span>
                    </p>
                    <p class="text-content-muted text-xs sm:text-sm font-bold uppercase tracking-widest group-hover:text-content-strong transition-colors duration-300"
                       :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
                       style="transition: all 0.7s cubic-bezier(0.16, 1, 0.3, 1) {{ $loop->index * 150 + 100 }}ms;"
                    >{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
