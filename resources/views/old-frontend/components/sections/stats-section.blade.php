<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 max-w-7xl mx-auto py-16 border-y border-white/5 bg-zinc-950/30 rounded-3xl px-6 md:px-12">
    @foreach($stats as $stat)
        <div class="flex flex-col items-center justify-center p-6 bg-zinc-900/40 border border-white/5 rounded-2xl relative overflow-hidden group hover:border-white/10 transition-colors duration-300">
            <!-- Glow background effect on hover -->
            <div class="absolute -inset-px bg-gradient-to-br from-indigo-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-2xl pointer-events-none"></div>

            <div class="flex items-baseline gap-0.5 text-4xl md:text-5xl lg:text-6xl font-display font-black text-white tracking-tight"
                 x-data="{ 
                     count: 0, 
                     target: parseFloat('{{ $stat['value'] }}'), 
                     isFloat: {{ strpos($stat['value'], '.') !== false ? 'true' : 'false' }},
                     init() {
                         let observer = new IntersectionObserver((entries) => {
                             entries.forEach(entry => {
                                 if (entry.isIntersecting) {
                                     this.animate();
                                     observer.disconnect();
                                 }
                             });
                         }, { threshold: 0.1 });
                         observer.observe(this.$el);
                     },
                     animate() {
                         let duration = 2000;
                         let startTime = null;
                         let step = (timestamp) => {
                             if (!startTime) startTime = timestamp;
                             let progress = Math.min((timestamp - startTime) / duration, 1);
                             let current = progress * this.target;
                             this.count = this.isFloat ? current.toFixed(1) : Math.floor(current);
                             if (progress < 1) {
                                 window.requestAnimationFrame(step);
                             } else {
                                 this.count = this.target;
                             }
                         };
                         window.requestAnimationFrame(step);
                     }
                 }">
                <span x-text="count">0</span><span class="text-indigo-400 font-medium">{{ $stat['suffix'] }}</span>
            </div>
            
            <p class="text-zinc-400 text-xs md:text-sm font-semibold tracking-wider uppercase mt-3 text-center">
                {{ $stat['label'] }}
            </p>
        </div>
    @endforeach
</div>
