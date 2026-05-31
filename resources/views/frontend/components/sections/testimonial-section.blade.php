<section class="py-24 md:py-32 bg-zinc-950 text-white relative overflow-hidden flex flex-col gap-24 border-b border-white/5"
         x-data="{ activeFilter: 'All' }">
    
    <!-- Background Design Details -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-[1px] bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>
    <div class="absolute top-20 right-0 w-96 h-96 bg-indigo-500/5 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-20 left-0 w-96 h-96 bg-indigo-500/5 rounded-full blur-[120px] pointer-events-none"></div>

    <!-- 1. Header Area -->
    <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center space-y-4 relative z-10">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-xs font-mono font-bold text-indigo-400 uppercase tracking-wider">
            Customer Stories
        </span>
        <h2 class="text-4xl md:text-5xl lg:text-6xl font-display font-black tracking-tight text-white max-w-4xl mx-auto leading-tight md:leading-none">
            Trusted by teams that refuse to waste time.
        </h2>
        <p class="text-zinc-400 text-base md:text-lg max-w-2xl mx-auto font-body">
            See how organizations, agencies, startups, and remote teams are transforming operations with TimeNest.
        </p>
    </div>

    <!-- 2. Scrolling Logos Strip -->
    <x-frontend-sections.company-logo-strip :logos="$stories['logos']" />

    <!-- 3. Featured Hero Story Card -->
    <div class="max-w-7xl mx-auto px-6 lg:px-8 w-full">
        <x-frontend-sections.featured-story :story="$stories['featured']" />
    </div>

    <!-- 4. Video Testimonials Grid -->
    <div class="max-w-7xl mx-auto px-6 lg:px-8 w-full">
        <x-frontend-sections.video-testimonials :videos="$stories['videos']" />
    </div>

    <!-- 5. Testimonial Masonry Grid & Filters -->
    <div class="max-w-7xl mx-auto px-6 lg:px-8 w-full text-center space-y-8">
        <div class="space-y-3">
            <h3 class="text-zinc-500 font-mono text-xs uppercase tracking-widest font-bold">What Customers Are Saying</h3>
            <h4 class="text-2xl md:text-3xl font-display font-bold text-white tracking-tight">Decisions backed by operations leads.</h4>
        </div>

        <!-- Filter Component -->
        <x-frontend-sections.customer-filters :categories="$stories['categories']" />

        <!-- Masonry Grid -->
        <div class="columns-1 md:columns-2 lg:columns-3 gap-6 space-y-6 pt-6 text-left">
            @foreach($stories['testimonials'] as $card)
                <div class="break-inside-avoid bg-zinc-900/40 border border-white/5 hover:border-white/10 rounded-3xl p-8 transition-all duration-500 relative group flex flex-col justify-between"
                     x-show="activeFilter === 'All' || {{ Js::from($card['categories']) }}.includes(activeFilter)"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     style="break-inside: avoid;">
                    
                    <!-- Hover Glow Effect -->
                    <div class="absolute -inset-px bg-gradient-to-br from-indigo-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-3xl pointer-events-none"></div>

                    <!-- Card Body Content based on Variant -->
                    <div class="space-y-6 relative z-10">
                        @if($card['variant'] === 'stats')
                            <!-- Variant 4: Statistics Card -->
                            <div class="space-y-1">
                                <div class="text-4xl md:text-5xl font-display font-black text-indigo-400 tracking-tight">
                                    {{ $card['stats_number'] }}
                                </div>
                                <div class="text-zinc-400 text-xs font-mono uppercase tracking-wider">
                                    {{ $card['stats_label'] }}
                                </div>
                            </div>
                        @elseif($card['variant'] === 'case_study')
                            <!-- Variant 5: Mini Case Study (Before/After) -->
                            <div class="grid grid-cols-2 gap-4 p-4 rounded-2xl bg-zinc-950 border border-white/5 text-xs font-mono">
                                <div>
                                    <div class="text-zinc-500 uppercase tracking-widest font-bold mb-1">Before</div>
                                    <div class="text-rose-400 font-semibold line-through decoration-rose-500/50">{{ $card['before'] }}</div>
                                </div>
                                <div class="border-l border-white/5 pl-4">
                                    <div class="text-indigo-400 uppercase tracking-widest font-bold mb-1">After</div>
                                    <div class="text-emerald-400 font-semibold flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        {{ $card['after'] }}
                                    </div>
                                </div>
                            </div>
                        @elseif($card['variant'] === 'logo')
                            <!-- Variant 3: Company Logo styled tag -->
                            <div class="w-fit px-3 py-1 rounded-lg bg-white/5 border border-white/10 text-xs font-display font-black tracking-widest text-zinc-300 uppercase">
                                {{ $card['logo'] }}
                            </div>
                        @endif

                        <!-- Standard Quote text -->
                        <p class="text-zinc-300 text-base md:text-lg leading-relaxed font-body">
                            "{{ $card['content'] }}"
                        </p>
                    </div>

                    <!-- Card Footer (Identity Info) -->
                    <div class="flex items-center gap-3 mt-8 pt-6 border-t border-white/5 relative z-10">
                        @if(isset($card['avatar']))
                            <img src="{{ $card['avatar'] }}" alt="{{ $card['name'] }}" class="w-10 h-10 rounded-full border border-white/10 object-cover shadow-sm">
                        @else
                            <div class="w-10 h-10 rounded-full bg-zinc-800 border border-white/5 flex items-center justify-center font-bold text-sm text-zinc-300">
                                {{ strtoupper(substr($card['name'], 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <h5 class="font-bold text-white text-sm tracking-tight leading-none">{{ $card['name'] }}</h5>
                            <p class="text-zinc-500 text-xs mt-1.5 leading-none">{{ $card['role'] }} · <span class="text-indigo-400/80 font-medium">{{ $card['company'] }}</span></p>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    </div>

    <!-- 6. Results Section (Stats Counter) -->
    <x-frontend-sections.stats-section :stats="$stories['stats']" />

    <!-- 7. Detailed Case Study Carousel -->
    <div class="max-w-7xl mx-auto px-6 lg:px-8 w-full">
        <x-frontend-sections.case-study-carousel :caseStudies="$stories['case_studies']" />
    </div>

    <!-- 8. Infinite Testimonial Wall -->
    <x-frontend-sections.testimonial-wall :wall="$stories['wall']" />

    <!-- 9. Trust Indicators Area -->
    <div class="max-w-7xl mx-auto px-6 lg:px-8 w-full text-center relative z-10">
        <div class="flex flex-col md:flex-row items-center justify-center gap-8 md:gap-16 py-8 border-t border-white/5">
            <!-- 5 Star Review Badge -->
            <div class="space-y-1.5 text-center md:text-left">
                <div class="flex items-center justify-center md:justify-start gap-1">
                    @for($i=0; $i<5; $i++)
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endfor
                </div>
                <div class="text-zinc-300 font-bold font-display text-sm tracking-tight">4.9/5 Average User Rating</div>
            </div>

            <!-- Vertical Divider -->
            <div class="hidden md:block w-px h-10 bg-white/10"></div>

            <!-- Three stats statements -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 md:gap-12 text-center md:text-left">
                <div>
                    <h6 class="text-white font-bold text-lg leading-none">5,000+</h6>
                    <p class="text-zinc-500 text-xs mt-1">Teams Trusted TimeNest</p>
                </div>
                <div>
                    <h6 class="text-white font-bold text-lg leading-none">98%</h6>
                    <p class="text-zinc-500 text-xs mt-1">Monthly Retention Rate</p>
                </div>
                <div>
                    <h6 class="text-white font-bold text-lg leading-none">1M+</h6>
                    <p class="text-zinc-500 text-xs mt-1">Work Hours Managed</p>
                </div>
            </div>
        </div>
    </div>

</section>
