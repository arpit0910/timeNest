<x-frontend-layout.app
    metaTitle="TimeNest — The Work Operating System for Modern Teams"
    metaDescription="Complete workforce management for organizations, freelancer tools, and collaborative workspaces. One platform for every workflow."
>
    {{-- Section 1: Hero --}}
    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-24 overflow-hidden" 
        x-data="{ mx: 0, my: 0 }" 
        @mousemove.window="mx = ($event.clientX / window.innerWidth - 0.5) * 4; my = ($event.clientY / window.innerHeight - 0.5) * 3"
    >
        {{-- Layer 1: Gradient Background --}}
        <div class="absolute inset-0 bg-gradient-to-b from-slate-50 via-white to-white pointer-events-none"></div>
        <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/4 w-[900px] h-[600px] bg-gradient-to-br from-teal-100/40 via-indigo-100/30 to-purple-100/20 rounded-full blur-3xl opacity-60 pointer-events-none"></div>

        {{-- Layer 2: Hero Content --}}
        <div class="relative z-30 max-w-7xl mx-auto px-6 lg:px-8 text-center">
            {{-- Announcement Pill --}}
            <div class="opacity-0 animate-hero-fade-up" style="animation-delay: 0ms;">
                <x-frontend-base.badge color="teal" size="md" :dot="true" :pulse="true" class="mb-8 inline-flex">
                    TimeNest 2.0 is now live
                </x-frontend-base.badge>
            </div>
            
            {{-- Main Heading with mouse parallax --}}
            <div :style="'transform: translate3d(' + mx + 'px, ' + my + 'px, 0)'" class="transition-transform duration-700 ease-out">
                <h1 class="font-display text-5xl lg:text-7xl font-bold text-content-strong tracking-tight mb-2 leading-tight">
                    <span class="block opacity-0 animate-hero-fade-up" style="animation-delay: 200ms;">The Work Operating System</span>
                    <span class="relative inline-block opacity-0 animate-hero-fade-up" style="animation-delay: 400ms;">
                        <span class="hero-text-glow"></span>
                        <span class="relative text-gradient-animated">for Modern Teams</span>
                    </span>
                </h1>
            </div>
            
            {{-- Subheading --}}
            <p class="text-lg lg:text-xl text-content-muted max-w-3xl mx-auto mb-10 leading-relaxed font-body opacity-0 animate-hero-fade-up" style="animation-delay: 600ms;">
                Manage employees, freelancers, and collaborative workspaces in one powerful platform. 
                From automated attendance tracking to AI-powered revenue forecasting — everything your team needs to scale.
            </p>
            
            {{-- CTA Buttons --}}
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 opacity-0 animate-hero-fade-up" style="animation-delay: 800ms;">
                <x-frontend-base.button href="/register" variant="primary" color="brand" size="lg" class="w-full sm:w-auto h-14 px-8 text-base" iconRight="<svg class='w-4 h-4' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2.5' d='M9 5l7 7-7 7'/></svg>">
                    Start for Free
                </x-frontend-base.button>
                <x-frontend-base.button href="{{ route('frontend.book-demo') }}" variant="outline" color="brand" size="lg" class="w-full sm:w-auto h-14 px-8 text-base">
                    Book a Demo
                </x-frontend-base.button>
            </div>
        </div>
    </section>

    {{-- Section 1.5: Standalone Premium Showcase (Ecosystem & Trusted Partners Marquee) --}}
    <section class="py-28 bg-gradient-to-b from-white via-slate-50/40 to-white overflow-hidden relative border-t border-slate-100/80"
             x-data="{ show: false }"
             x-init="const obs = new IntersectionObserver(([entry]) => { if (entry.isIntersecting) { show = true; obs.disconnect(); } }, { threshold: 0.05 }); obs.observe($el);"
    >
        <!-- Ambient background glows -->
        <div class="absolute top-1/2 left-1/4 -translate-x-1/2 -translate-y-1/2 w-[550px] h-[550px] bg-gradient-to-r from-indigo-500/5 to-teal-500/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-1/2 right-1/4 translate-x-1/2 -translate-y-1/2 w-[550px] h-[550px] bg-gradient-to-r from-violet-500/5 to-brand-500/5 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center relative z-10 mb-16 transition-all duration-1000 transform"
             :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
        >
            <x-frontend-base.badge variant="accent" class="mb-4">Ecosystem Showcase</x-frontend-base.badge>
            <h2 class="font-display text-3xl lg:text-4xl font-bold text-content-strong mb-4 tracking-tight">
                Trusted by forward-thinking teams, agencies and growing organizations.
            </h2>
            <p class="text-content-muted text-base lg:text-lg max-w-3xl mx-auto font-body">
                Built for modern workforce operations, attendance, projects, finance and AI-powered workflows.
            </p>
        </div>

        <!-- Infinite Scrolling Horizontal Marquee -->
        <div class="relative w-full overflow-hidden select-none transition-all duration-1000 delay-300 transform pause-hover"
             :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
        >
            <!-- Fade overlays to hide edges -->
            <div class="absolute inset-y-0 left-0 w-32 md:w-48 bg-gradient-to-r from-white via-white/80 to-transparent pointer-events-none z-10"></div>
            <div class="absolute inset-y-0 right-0 w-32 md:w-48 bg-gradient-to-l from-white via-white/80 to-transparent pointer-events-none z-10"></div>

            <div class="flex gap-6 whitespace-nowrap animate-marquee-horizontal p-4">
                
                <!-- Group 1 of 8 Cards -->
                <!-- Card 1: Acme Corp -->
                <div class="group inline-flex items-center gap-4 bg-white/70 backdrop-blur-sm border border-slate-200/60 p-4 pr-6 rounded-2xl shadow-sm hover:shadow-md hover:border-brand-500 hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="w-12 h-12 rounded-xl bg-slate-50 text-slate-500 flex items-center justify-center transition-all duration-300 group-hover:bg-brand-500 group-hover:text-white group-hover:shadow-lg group-hover:shadow-brand-500/20">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div class="flex flex-col text-left">
                        <span class="text-sm font-bold text-slate-800 tracking-tight transition-colors duration-300 group-hover:text-brand-950">Acme Corp</span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Workforce Management</span>
                    </div>
                </div>

                <!-- Card 2: Wayne Enterprises -->
                <div class="group inline-flex items-center gap-4 bg-white/70 backdrop-blur-sm border border-slate-200/60 p-4 pr-6 rounded-2xl shadow-sm hover:shadow-md hover:border-indigo-500 hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="w-12 h-12 rounded-xl bg-slate-50 text-slate-500 flex items-center justify-center transition-all duration-300 group-hover:bg-indigo-500 group-hover:text-white group-hover:shadow-lg group-hover:shadow-indigo-500/20">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div class="flex flex-col text-left">
                        <span class="text-sm font-bold text-slate-800 tracking-tight transition-colors duration-300 group-hover:text-indigo-950">Wayne Ent.</span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Security & Compliance</span>
                    </div>
                </div>

                <!-- Card 3: Initech -->
                <div class="group inline-flex items-center gap-4 bg-white/70 backdrop-blur-sm border border-slate-200/60 p-4 pr-6 rounded-2xl shadow-sm hover:shadow-md hover:border-emerald-500 hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="w-12 h-12 rounded-xl bg-slate-50 text-slate-500 flex items-center justify-center transition-all duration-300 group-hover:bg-emerald-500 group-hover:text-white group-hover:shadow-lg group-hover:shadow-emerald-500/20">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                    <div class="flex flex-col text-left">
                        <span class="text-sm font-bold text-slate-800 tracking-tight transition-colors duration-300 group-hover:text-emerald-950">Initech</span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">AI Automation</span>
                    </div>
                </div>

                <!-- Card 4: Stark Industries -->
                <div class="group inline-flex items-center gap-4 bg-white/70 backdrop-blur-sm border border-slate-200/60 p-4 pr-6 rounded-2xl shadow-sm hover:shadow-md hover:border-violet-500 hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="w-12 h-12 rounded-xl bg-slate-50 text-slate-500 flex items-center justify-center transition-all duration-300 group-hover:bg-violet-500 group-hover:text-white group-hover:shadow-lg group-hover:shadow-violet-500/20">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <div class="flex flex-col text-left">
                        <span class="text-sm font-bold text-slate-800 tracking-tight transition-colors duration-300 group-hover:text-violet-950">Stark Industries</span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Enterprise Operations</span>
                    </div>
                </div>

                <!-- Card 5: Globex Corp -->
                <div class="group inline-flex items-center gap-4 bg-white/70 backdrop-blur-sm border border-slate-200/60 p-4 pr-6 rounded-2xl shadow-sm hover:shadow-md hover:border-blue-500 hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="w-12 h-12 rounded-xl bg-slate-50 text-slate-500 flex items-center justify-center transition-all duration-300 group-hover:bg-blue-500 group-hover:text-white group-hover:shadow-lg group-hover:shadow-blue-500/20">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                    </div>
                    <div class="flex flex-col text-left">
                        <span class="text-sm font-bold text-slate-800 tracking-tight transition-colors duration-300 group-hover:text-blue-950">Globex Corp</span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Operations Management</span>
                    </div>
                </div>

                <!-- Card 6: Tyrell Corp -->
                <div class="group inline-flex items-center gap-4 bg-white/70 backdrop-blur-sm border border-slate-200/60 p-4 pr-6 rounded-2xl shadow-sm hover:shadow-md hover:border-amber-500 hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="w-12 h-12 rounded-xl bg-slate-50 text-slate-500 flex items-center justify-center transition-all duration-300 group-hover:bg-amber-500 group-hover:text-white group-hover:shadow-lg group-hover:shadow-amber-500/20">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <div class="flex flex-col text-left">
                        <span class="text-sm font-bold text-slate-800 tracking-tight transition-colors duration-300 group-hover:text-amber-950">Tyrell Corp</span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Bio-Tech Engineering</span>
                    </div>
                </div>

                <!-- Card 7: Hooli -->
                <div class="group inline-flex items-center gap-4 bg-white/70 backdrop-blur-sm border border-slate-200/60 p-4 pr-6 rounded-2xl shadow-sm hover:shadow-md hover:border-cyan-500 hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="w-12 h-12 rounded-xl bg-slate-50 text-slate-500 flex items-center justify-center transition-all duration-300 group-hover:bg-cyan-500 group-hover:text-white group-hover:shadow-lg group-hover:shadow-cyan-500/20">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                        </svg>
                    </div>
                    <div class="flex flex-col text-left">
                        <span class="text-sm font-bold text-slate-800 tracking-tight transition-colors duration-300 group-hover:text-cyan-950">Hooli</span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Cloud Workspace</span>
                    </div>
                </div>

                <!-- Card 8: Cyberdyne Systems -->
                <div class="group inline-flex items-center gap-4 bg-white/70 backdrop-blur-sm border border-slate-200/60 p-4 pr-6 rounded-2xl shadow-sm hover:shadow-md hover:border-rose-500 hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="w-12 h-12 rounded-xl bg-slate-50 text-slate-500 flex items-center justify-center transition-all duration-300 group-hover:bg-rose-500 group-hover:text-white group-hover:shadow-lg group-hover:shadow-rose-500/20">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                        </svg>
                    </div>
                    <div class="flex flex-col text-left">
                        <span class="text-sm font-bold text-slate-800 tracking-tight transition-colors duration-300 group-hover:text-rose-950">Cyberdyne Systems</span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">AI Robotics & Dev</span>
                    </div>
                </div>


                <!-- Group 2 of 8 Cards (Duplicated for seamless loop) -->
                <!-- Card 1 Duplicate -->
                <div class="group inline-flex items-center gap-4 bg-white/70 backdrop-blur-sm border border-slate-200/60 p-4 pr-6 rounded-2xl shadow-sm hover:shadow-md hover:border-brand-500 hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="w-12 h-12 rounded-xl bg-slate-50 text-slate-500 flex items-center justify-center transition-all duration-300 group-hover:bg-brand-500 group-hover:text-white group-hover:shadow-lg group-hover:shadow-brand-500/20">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div class="flex flex-col text-left">
                        <span class="text-sm font-bold text-slate-800 tracking-tight transition-colors duration-300 group-hover:text-brand-950">Acme Corp</span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Workforce Management</span>
                    </div>
                </div>

                <!-- Card 2 Duplicate -->
                <div class="group inline-flex items-center gap-4 bg-white/70 backdrop-blur-sm border border-slate-200/60 p-4 pr-6 rounded-2xl shadow-sm hover:shadow-md hover:border-indigo-500 hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="w-12 h-12 rounded-xl bg-slate-50 text-slate-500 flex items-center justify-center transition-all duration-300 group-hover:bg-indigo-500 group-hover:text-white group-hover:shadow-lg group-hover:shadow-indigo-500/20">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div class="flex flex-col text-left">
                        <span class="text-sm font-bold text-slate-800 tracking-tight transition-colors duration-300 group-hover:text-indigo-950">Wayne Ent.</span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Security & Compliance</span>
                    </div>
                </div>

                <!-- Card 3 Duplicate -->
                <div class="group inline-flex items-center gap-4 bg-white/70 backdrop-blur-sm border border-slate-200/60 p-4 pr-6 rounded-2xl shadow-sm hover:shadow-md hover:border-emerald-500 hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="w-12 h-12 rounded-xl bg-slate-50 text-slate-500 flex items-center justify-center transition-all duration-300 group-hover:bg-emerald-500 group-hover:text-white group-hover:shadow-lg group-hover:shadow-emerald-500/20">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                    <div class="flex flex-col text-left">
                        <span class="text-sm font-bold text-slate-800 tracking-tight transition-colors duration-300 group-hover:text-emerald-950">Initech</span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">AI Automation</span>
                    </div>
                </div>

                <!-- Card 4 Duplicate -->
                <div class="group inline-flex items-center gap-4 bg-white/70 backdrop-blur-sm border border-slate-200/60 p-4 pr-6 rounded-2xl shadow-sm hover:shadow-md hover:border-violet-500 hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="w-12 h-12 rounded-xl bg-slate-50 text-slate-500 flex items-center justify-center transition-all duration-300 group-hover:bg-violet-500 group-hover:text-white group-hover:shadow-lg group-hover:shadow-violet-500/20">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <div class="flex flex-col text-left">
                        <span class="text-sm font-bold text-slate-800 tracking-tight transition-colors duration-300 group-hover:text-violet-950">Stark Industries</span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Enterprise Operations</span>
                    </div>
                </div>

                <!-- Card 5 Duplicate -->
                <div class="group inline-flex items-center gap-4 bg-white/70 backdrop-blur-sm border border-slate-200/60 p-4 pr-6 rounded-2xl shadow-sm hover:shadow-md hover:border-blue-500 hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="w-12 h-12 rounded-xl bg-slate-50 text-slate-500 flex items-center justify-center transition-all duration-300 group-hover:bg-blue-500 group-hover:text-white group-hover:shadow-lg group-hover:shadow-blue-500/20">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                    </div>
                    <div class="flex flex-col text-left">
                        <span class="text-sm font-bold text-slate-800 tracking-tight transition-colors duration-300 group-hover:text-blue-950">Globex Corp</span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Operations Management</span>
                    </div>
                </div>

                <!-- Card 6 Duplicate -->
                <div class="group inline-flex items-center gap-4 bg-white/70 backdrop-blur-sm border border-slate-200/60 p-4 pr-6 rounded-2xl shadow-sm hover:shadow-md hover:border-amber-500 hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="w-12 h-12 rounded-xl bg-slate-50 text-slate-500 flex items-center justify-center transition-all duration-300 group-hover:bg-amber-500 group-hover:text-white group-hover:shadow-lg group-hover:shadow-amber-500/20">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <div class="flex flex-col text-left">
                        <span class="text-sm font-bold text-slate-800 tracking-tight transition-colors duration-300 group-hover:text-amber-950">Tyrell Corp</span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Bio-Tech Engineering</span>
                    </div>
                </div>

                <!-- Card 7 Duplicate -->
                <div class="group inline-flex items-center gap-4 bg-white/70 backdrop-blur-sm border border-slate-200/60 p-4 pr-6 rounded-2xl shadow-sm hover:shadow-md hover:border-cyan-500 hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="w-12 h-12 rounded-xl bg-slate-50 text-slate-500 flex items-center justify-center transition-all duration-300 group-hover:bg-cyan-500 group-hover:text-white group-hover:shadow-lg group-hover:shadow-cyan-500/20">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                        </svg>
                    </div>
                    <div class="flex flex-col text-left">
                        <span class="text-sm font-bold text-slate-800 tracking-tight transition-colors duration-300 group-hover:text-cyan-950">Hooli</span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Cloud Workspace</span>
                    </div>
                </div>

                <!-- Card 8 Duplicate -->
                <div class="group inline-flex items-center gap-4 bg-white/70 backdrop-blur-sm border border-slate-200/60 p-4 pr-6 rounded-2xl shadow-sm hover:shadow-md hover:border-rose-500 hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                    <div class="w-12 h-12 rounded-xl bg-slate-50 text-slate-500 flex items-center justify-center transition-all duration-300 group-hover:bg-rose-500 group-hover:text-white group-hover:shadow-lg group-hover:shadow-rose-500/20">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                        </svg>
                    </div>
                    <div class="flex flex-col text-left">
                        <span class="text-sm font-bold text-slate-800 tracking-tight transition-colors duration-300 group-hover:text-rose-950">Cyberdyne Systems</span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">AI Robotics & Dev</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Section 2: How TimeNest Powers Work (Visualization Cards Showcase) --}}
    <section class="py-24 bg-slate-50/50 border-y border-slate-100/80 overflow-hidden"
             x-data="{ show: false }"
             x-init="const obs = new IntersectionObserver(([entry]) => { if (entry.isIntersecting) { show = true; obs.disconnect(); } }, { threshold: 0.05 }); obs.observe($el);"
    >
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 transition-all duration-1000 transform"
                 :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                <x-frontend-base.badge variant="primary" class="mb-4">Capabilities</x-frontend-base.badge>
                <h2 class="font-display text-3xl lg:text-5xl font-bold text-content-strong mb-4 tracking-tight">Everything that runs your business. <span class="text-brand-500">In one platform.</span></h2>
                <p class="text-content-muted text-lg lg:text-xl font-body">Ditch the tool sprawl. TimeNest consolidates your operations, workforce management, and freelancer tools into a single source of truth.</p>
            </div>

            <!-- Bento Showcase Grid with Staggered Viewport Entry -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 content-start transition-all duration-1000 delay-300 transform"
                 :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'">
                
                {{-- Card 1: Attendance --}}
                <div class="animate-float-gentle duration-[6s] hover:scale-[1.02] transition-transform duration-300">
                    @include('frontend.partials.widgets.attendance')
                </div>
                
                {{-- Card 2: Team Status --}}
                <div class="animate-float-gentle-reverse duration-[7s] hover:scale-[1.02] transition-transform duration-300">
                    @include('frontend.partials.widgets.team-status')
                </div>
                
                {{-- Card 3: Cashflow --}}
                <div class="animate-float-gentle duration-[8s] hover:scale-[1.02] transition-transform duration-300">
                    @include('frontend.partials.widgets.cashflow')
                </div>
                
                {{-- Card 4: Payroll --}}
                <div class="animate-float-gentle-reverse duration-[9s] hover:scale-[1.02] transition-transform duration-300">
                    @include('frontend.partials.widgets.payroll')
                </div>
                
                {{-- Card 5: Sales Pipeline --}}
                <div class="animate-float-gentle-reverse duration-[6.5s] hover:scale-[1.02] transition-transform duration-300">
                    @include('frontend.partials.widgets.sales')
                </div>
                
                {{-- Card 6: Projects --}}
                <div class="animate-float-gentle duration-[7.5s] hover:scale-[1.02] transition-transform duration-300">
                    @include('frontend.partials.widgets.projects')
                </div>
                
                {{-- Card 7: Analytics --}}
                <div class="animate-float-gentle-reverse duration-[8.5s] hover:scale-[1.02] transition-transform duration-300">
                    @include('frontend.partials.widgets.analytics')
                </div>
                
                {{-- Card 8: AI Copilot --}}
                <div class="animate-float-gentle duration-[9.5s] hover:scale-[1.02] transition-transform duration-300">
                    @include('frontend.partials.widgets.ai-copilot')
                </div>

                {{-- Card 9: Freelancer Invoice --}}
                <div class="animate-float-gentle duration-[7s] hover:scale-[1.02] transition-transform duration-300 lg:col-span-2">
                    @include('frontend.partials.widgets.freelancer-invoice')
                </div>

                {{-- Card 10: Workspace Hub --}}
                <div class="animate-float-gentle-reverse duration-[8s] hover:scale-[1.02] transition-transform duration-300 lg:col-span-2">
                    @include('frontend.partials.widgets.workspace-hub')
                </div>
            </div>
        </div>
    </section>

    {{-- Section 3: Dashboard Product Showcase --}}
    <section class="py-24 bg-white overflow-hidden"
             x-data="{ show: false }"
             x-init="const obs = new IntersectionObserver(([entry]) => { if (entry.isIntersecting) { show = true; obs.disconnect(); } }, { threshold: 0.05 }); obs.observe($el);"
    >
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 transition-all duration-1000 transform"
                 :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                <x-frontend-base.badge variant="accent" class="mb-4">Product Showcase</x-frontend-base.badge>
                <h2 class="font-display text-3xl lg:text-5xl font-bold text-content-strong mb-4 tracking-tight">The visual cockpit of your <span class="text-indigo-600">entire operations.</span></h2>
                <p class="text-content-muted text-lg lg:text-xl font-body">Get a birds-eye view of active projects, cashflow metrics, contractor invoice progress, and team attendance anomalies in real time.</p>
            </div>

            <!-- Highlight Cards Stats Strip directly above Dashboard -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl mx-auto mb-16 transition-all duration-1000 delay-200 transform"
                 :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                
                <!-- Card 1: Attendance Compliance -->
                <div class="bg-slate-50 border border-slate-200/60 p-6 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 text-center flex flex-col justify-center"
                     x-data="{ count: 0, target: 99.2 }"
                     x-init="
                         const obs = new IntersectionObserver(([entry]) => {
                             if (entry.isIntersecting) {
                                 obs.disconnect();
                                 let start = 0;
                                 let interval = setInterval(() => {
                                     start += 1.5;
                                     if (start >= target) {
                                         count = target;
                                         clearInterval(interval);
                                     } else {
                                         count = Math.round(start * 10) / 10;
                                     }
                                 }, 15);
                             }
                         }, { threshold: 0.1 });
                         obs.observe($el);
                     "
                >
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-2">Attendance Compliance</p>
                    <h3 class="text-3xl lg:text-4xl font-bold text-brand-600 tracking-tight font-display" x-text="count.toFixed(1) + '%'">0%</h3>
                </div>

                <!-- Card 2: AI Insights Generated -->
                <div class="bg-slate-50 border border-slate-200/60 p-6 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 text-center flex flex-col justify-center"
                     x-data="{ count: 0, target: 2341 }"
                     x-init="
                         const obs = new IntersectionObserver(([entry]) => {
                             if (entry.isIntersecting) {
                                 obs.disconnect();
                                 let start = 0;
                                 let interval = setInterval(() => {
                                     start += 45;
                                     if (start >= target) {
                                         count = target;
                                         clearInterval(interval);
                                     } else {
                                         count = Math.round(start);
                                     }
                                 }, 15);
                             }
                         }, { threshold: 0.1 });
                         obs.observe($el);
                     "
                >
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-2">AI Insights Generated</p>
                    <h3 class="text-3xl lg:text-4xl font-bold text-indigo-600 tracking-tight font-display" x-text="count.toLocaleString()">0</h3>
                </div>

                <!-- Card 3: Projects Managed -->
                <div class="bg-slate-50 border border-slate-200/60 p-6 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 text-center flex flex-col justify-center"
                     x-data="{ count: 0, target: 18400 }"
                     x-init="
                         const obs = new IntersectionObserver(([entry]) => {
                             if (entry.isIntersecting) {
                                 obs.disconnect();
                                 let start = 0;
                                 let interval = setInterval(() => {
                                     start += 350;
                                     if (start >= target) {
                                         count = target;
                                         clearInterval(interval);
                                     } else {
                                         count = Math.round(start);
                                     }
                                 }, 15);
                             }
                         }, { threshold: 0.1 });
                         obs.observe($el);
                     "
                >
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-2">Projects Managed</p>
                    <h3 class="text-3xl lg:text-4xl font-bold text-teal-600 tracking-tight font-display" x-text="count.toLocaleString() + '+'">0+</h3>
                </div>

                <!-- Card 4: Payroll Accuracy -->
                <div class="bg-slate-50 border border-slate-200/60 p-6 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 text-center flex flex-col justify-center"
                     x-data="{ count: 0, target: 99.99 }"
                     x-init="
                         const obs = new IntersectionObserver(([entry]) => {
                             if (entry.isIntersecting) {
                                 obs.disconnect();
                                 let start = 0;
                                 let interval = setInterval(() => {
                                     start += 1.6;
                                     if (start >= target) {
                                         count = target;
                                         clearInterval(interval);
                                     } else {
                                         count = Math.round(start * 100) / 100;
                                     }
                                 }, 15);
                             }
                         }, { threshold: 0.1 });
                         obs.observe($el);
                     "
                >
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-2">Payroll Accuracy</p>
                    <h3 class="text-3xl lg:text-4xl font-bold text-amber-600 tracking-tight font-display" x-text="count.toFixed(2) + '%'">0%</h3>
                </div>
            </div>

            <!-- Premium Two-Column Vertical Scrolling Showcase (Marquee) -->
            <div class="relative mx-auto max-w-6xl h-[650px] lg:h-[750px] w-full rounded-3xl border border-slate-200/80 bg-slate-50/50 overflow-hidden shadow-inner transition-all duration-1000 delay-400 transform"
                 :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
            >
                <!-- Fade overlays to blend top and bottom transitions -->
                <div class="absolute top-0 inset-x-0 h-32 bg-gradient-to-b from-white via-white/80 to-transparent pointer-events-none z-10"></div>
                <div class="absolute bottom-0 inset-x-0 h-32 bg-gradient-to-t from-white via-white/80 to-transparent pointer-events-none z-10"></div>
                
                <!-- Dual Column Layout -->
                <div class="grid grid-cols-2 gap-4 md:gap-6 h-full p-4 md:p-6 pause-hover">
                    
                    <!-- Left Column: Scrolling Down (Top to Bottom) -->
                    <div class="flex flex-col gap-6 animate-marquee-down">
                        
                        <!-- Cards Set 1 -->
                        <!-- Card 1: Work OS Dashboard -->
                        <div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden flex flex-col hover:scale-[1.02] hover:shadow-md hover:border-slate-300/80 transition-all duration-300 select-none">
                            <div class="flex items-center justify-between px-3 py-2 bg-slate-50 border-b border-slate-100 browser-glass-top shrink-0">
                                <div class="flex items-center gap-1.5 w-1/4">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                </div>
                                <div class="bg-white border border-slate-200/50 rounded py-0.5 px-2 text-[9px] text-slate-400 font-mono text-center flex items-center justify-center gap-1 shadow-sm max-w-[150px] truncate">
                                    <svg class="w-2.5 h-2.5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                                    <span class="truncate">timenest.com/dashboard</span>
                                </div>
                                <div class="w-1/4"></div>
                            </div>
                            <div class="relative overflow-hidden aspect-[16/10] bg-slate-100">
                                <img src="/images/mockups/hero-dashboard.png" alt="Work OS Dashboard" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-3 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800">Work OS Dashboard</h4>
                                    <p class="text-[9px] text-slate-400">Central Command Hub</p>
                                </div>
                                <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-indigo-50 text-indigo-600 border border-indigo-100/50">Core</span>
                            </div>
                        </div>

                        <!-- Card 2: Workforce Scheduler -->
                        <div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden flex flex-col hover:scale-[1.02] hover:shadow-md hover:border-slate-300/80 transition-all duration-300 select-none">
                            <div class="flex items-center justify-between px-3 py-2 bg-slate-50 border-b border-slate-100 browser-glass-top shrink-0">
                                <div class="flex items-center gap-1.5 w-1/4">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                </div>
                                <div class="bg-white border border-slate-200/50 rounded py-0.5 px-2 text-[9px] text-slate-400 font-mono text-center flex items-center justify-center gap-1 shadow-sm max-w-[150px] truncate">
                                    <svg class="w-2.5 h-2.5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                                    <span class="truncate">timenest.com/scheduler</span>
                                </div>
                                <div class="w-1/4"></div>
                            </div>
                            <div class="relative overflow-hidden aspect-[16/10] bg-slate-100">
                                <img src="/images/mockups/workforce_scheduler.png" alt="Workforce Scheduler" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-3 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800">Workforce Scheduler</h4>
                                    <p class="text-[9px] text-slate-400">Shift & Roster Manager</p>
                                </div>
                                <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-emerald-50 text-emerald-600 border border-emerald-100/50">Roster</span>
                            </div>
                        </div>

                        <!-- Card 3: Compliance & Audit -->
                        <div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden flex flex-col hover:scale-[1.02] hover:shadow-md hover:border-slate-300/80 transition-all duration-300 select-none">
                            <div class="flex items-center justify-between px-3 py-2 bg-slate-50 border-b border-slate-100 browser-glass-top shrink-0">
                                <div class="flex items-center gap-1.5 w-1/4">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                </div>
                                <div class="bg-white border border-slate-200/50 rounded py-0.5 px-2 text-[9px] text-slate-400 font-mono text-center flex items-center justify-center gap-1 shadow-sm max-w-[150px] truncate">
                                    <svg class="w-2.5 h-2.5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                                    <span class="truncate">timenest.com/compliance</span>
                                </div>
                                <div class="w-1/4"></div>
                            </div>
                            <div class="relative overflow-hidden aspect-[16/10] bg-slate-100">
                                <img src="/images/mockups/compliance_audit.png" alt="Compliance & Audit" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-3 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800">Compliance & Audit</h4>
                                    <p class="text-[9px] text-slate-400">Immutable Event Logging</p>
                                </div>
                                <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-rose-50 text-rose-600 border border-rose-100/50">Audit</span>
                            </div>
                        </div>

                        <!-- Card 4: AI Intelligence Core -->
                        <div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden flex flex-col hover:scale-[1.02] hover:shadow-md hover:border-slate-300/80 transition-all duration-300 select-none">
                            <div class="flex items-center justify-between px-3 py-2 bg-slate-50 border-b border-slate-100 browser-glass-top shrink-0">
                                <div class="flex items-center gap-1.5 w-1/4">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                </div>
                                <div class="bg-white border border-slate-200/50 rounded py-0.5 px-2 text-[9px] text-slate-400 font-mono text-center flex items-center justify-center gap-1 shadow-sm max-w-[150px] truncate">
                                    <svg class="w-2.5 h-2.5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                                    <span class="truncate">timenest.com/ai-core</span>
                                </div>
                                <div class="w-1/4"></div>
                            </div>
                            <div class="relative overflow-hidden aspect-[16/10] bg-slate-100">
                                <img src="/images/mockups/mega_menu_ai.png" alt="AI Intelligence Core" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-3 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800">AI Intelligence Core</h4>
                                    <p class="text-[9px] text-slate-400">Automated Operations Rules</p>
                                </div>
                                <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-cyan-50 text-cyan-600 border border-cyan-100/50">Automation</span>
                            </div>
                        </div>

                        <!-- Cards Set 2 (Duplicated for infinite scroll) -->
                        <!-- Card 1 Duplicate -->
                        <div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden flex flex-col hover:scale-[1.02] hover:shadow-md hover:border-slate-300/80 transition-all duration-300 select-none">
                            <div class="flex items-center justify-between px-3 py-2 bg-slate-50 border-b border-slate-100 browser-glass-top shrink-0">
                                <div class="flex items-center gap-1.5 w-1/4">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                </div>
                                <div class="bg-white border border-slate-200/50 rounded py-0.5 px-2 text-[9px] text-slate-400 font-mono text-center flex items-center justify-center gap-1 shadow-sm max-w-[150px] truncate">
                                    <svg class="w-2.5 h-2.5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                                    <span class="truncate">timenest.com/dashboard</span>
                                </div>
                                <div class="w-1/4"></div>
                            </div>
                            <div class="relative overflow-hidden aspect-[16/10] bg-slate-100">
                                <img src="/images/mockups/hero-dashboard.png" alt="Work OS Dashboard" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-3 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800">Work OS Dashboard</h4>
                                    <p class="text-[9px] text-slate-400">Central Command Hub</p>
                                </div>
                                <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-indigo-50 text-indigo-600 border border-indigo-100/50">Core</span>
                            </div>
                        </div>

                        <!-- Card 2 Duplicate -->
                        <div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden flex flex-col hover:scale-[1.02] hover:shadow-md hover:border-slate-300/80 transition-all duration-300 select-none">
                            <div class="flex items-center justify-between px-3 py-2 bg-slate-50 border-b border-slate-100 browser-glass-top shrink-0">
                                <div class="flex items-center gap-1.5 w-1/4">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                </div>
                                <div class="bg-white border border-slate-200/50 rounded py-0.5 px-2 text-[9px] text-slate-400 font-mono text-center flex items-center justify-center gap-1 shadow-sm max-w-[150px] truncate">
                                    <svg class="w-2.5 h-2.5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                                    <span class="truncate">timenest.com/scheduler</span>
                                </div>
                                <div class="w-1/4"></div>
                            </div>
                            <div class="relative overflow-hidden aspect-[16/10] bg-slate-100">
                                <img src="/images/mockups/workforce_scheduler.png" alt="Workforce Scheduler" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-3 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800">Workforce Scheduler</h4>
                                    <p class="text-[9px] text-slate-400">Shift & Roster Manager</p>
                                </div>
                                <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-emerald-50 text-emerald-600 border border-emerald-100/50">Roster</span>
                            </div>
                        </div>

                        <!-- Card 3 Duplicate -->
                        <div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden flex flex-col hover:scale-[1.02] hover:shadow-md hover:border-slate-300/80 transition-all duration-300 select-none">
                            <div class="flex items-center justify-between px-3 py-2 bg-slate-50 border-b border-slate-100 browser-glass-top shrink-0">
                                <div class="flex items-center gap-1.5 w-1/4">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                </div>
                                <div class="bg-white border border-slate-200/50 rounded py-0.5 px-2 text-[9px] text-slate-400 font-mono text-center flex items-center justify-center gap-1 shadow-sm max-w-[150px] truncate">
                                    <svg class="w-2.5 h-2.5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                                    <span class="truncate">timenest.com/compliance</span>
                                </div>
                                <div class="w-1/4"></div>
                            </div>
                            <div class="relative overflow-hidden aspect-[16/10] bg-slate-100">
                                <img src="/images/mockups/compliance_audit.png" alt="Compliance & Audit" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-3 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800">Compliance & Audit</h4>
                                    <p class="text-[9px] text-slate-400">Immutable Event Logging</p>
                                </div>
                                <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-rose-50 text-rose-600 border border-rose-100/50">Audit</span>
                            </div>
                        </div>

                        <!-- Card 4 Duplicate -->
                        <div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden flex flex-col hover:scale-[1.02] hover:shadow-md hover:border-slate-300/80 transition-all duration-300 select-none">
                            <div class="flex items-center justify-between px-3 py-2 bg-slate-50 border-b border-slate-100 browser-glass-top shrink-0">
                                <div class="flex items-center gap-1.5 w-1/4">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                </div>
                                <div class="bg-white border border-slate-200/50 rounded py-0.5 px-2 text-[9px] text-slate-400 font-mono text-center flex items-center justify-center gap-1 shadow-sm max-w-[150px] truncate">
                                    <svg class="w-2.5 h-2.5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                                    <span class="truncate">timenest.com/ai-core</span>
                                </div>
                                <div class="w-1/4"></div>
                            </div>
                            <div class="relative overflow-hidden aspect-[16/10] bg-slate-100">
                                <img src="/images/mockups/mega_menu_ai.png" alt="AI Intelligence Core" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-3 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800">AI Intelligence Core</h4>
                                    <p class="text-[9px] text-slate-400">Automated Operations Rules</p>
                                </div>
                                <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-cyan-50 text-cyan-600 border border-cyan-100/50">Automation</span>
                            </div>
                        </div>

                    </div>

                    <!-- Right Column: Scrolling Up (Bottom to Top) -->
                    <div class="flex flex-col gap-6 animate-marquee-up">
                        
                        <!-- Cards Set 1 -->
                        <!-- Card 1: AI Analytics Hub -->
                        <div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden flex flex-col hover:scale-[1.02] hover:shadow-md hover:border-slate-300/80 transition-all duration-300 select-none">
                            <div class="flex items-center justify-between px-3 py-2 bg-slate-50 border-b border-slate-100 browser-glass-top shrink-0">
                                <div class="flex items-center gap-1.5 w-1/4">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                </div>
                                <div class="bg-white border border-slate-200/50 rounded py-0.5 px-2 text-[9px] text-slate-400 font-mono text-center flex items-center justify-center gap-1 shadow-sm max-w-[150px] truncate">
                                    <svg class="w-2.5 h-2.5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                                    <span class="truncate">timenest.com/ai-analytics</span>
                                </div>
                                <div class="w-1/4"></div>
                            </div>
                            <div class="relative overflow-hidden aspect-[16/10] bg-slate-100">
                                <img src="/images/mockups/ai-analytics.png" alt="AI Analytics Hub" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-3 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800">AI Analytics Hub</h4>
                                    <p class="text-[9px] text-slate-400">Predictive Forecasting</p>
                                </div>
                                <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-violet-50 text-violet-600 border border-violet-100/50">Analytics</span>
                            </div>
                        </div>

                        <!-- Card 2: Financial Invoicing -->
                        <div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden flex flex-col hover:scale-[1.02] hover:shadow-md hover:border-slate-300/80 transition-all duration-300 select-none">
                            <div class="flex items-center justify-between px-3 py-2 bg-slate-50 border-b border-slate-100 browser-glass-top shrink-0">
                                <div class="flex items-center gap-1.5 w-1/4">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                </div>
                                <div class="bg-white border border-slate-200/50 rounded py-0.5 px-2 text-[9px] text-slate-400 font-mono text-center flex items-center justify-center gap-1 shadow-sm max-w-[150px] truncate">
                                    <svg class="w-2.5 h-2.5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                                    <span class="truncate">timenest.com/billing</span>
                                </div>
                                <div class="w-1/4"></div>
                            </div>
                            <div class="relative overflow-hidden aspect-[16/10] bg-slate-100">
                                <img src="/images/mockups/finance_ledger.png" alt="Financial Invoicing" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-3 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800">Financial Invoicing</h4>
                                    <p class="text-[9px] text-slate-400">Ledger & Payments</p>
                                </div>
                                <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-amber-50 text-amber-600 border border-amber-100/50">Finance</span>
                            </div>
                        </div>

                        <!-- Card 3: Enterprise Solutions -->
                        <div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden flex flex-col hover:scale-[1.02] hover:shadow-md hover:border-slate-300/80 transition-all duration-300 select-none">
                            <div class="flex items-center justify-between px-3 py-2 bg-slate-50 border-b border-slate-100 browser-glass-top shrink-0">
                                <div class="flex items-center gap-1.5 w-1/4">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                </div>
                                <div class="bg-white border border-slate-200/50 rounded py-0.5 px-2 text-[9px] text-slate-400 font-mono text-center flex items-center justify-center gap-1 shadow-sm max-w-[150px] truncate">
                                    <svg class="w-2.5 h-2.5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                                    <span class="truncate">timenest.com/enterprise</span>
                                </div>
                                <div class="w-1/4"></div>
                            </div>
                            <div class="relative overflow-hidden aspect-[16/10] bg-slate-100">
                                <img src="/images/mockups/mega_menu_solutions.png" alt="Enterprise Solutions" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-3 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800">Enterprise Solutions</h4>
                                    <p class="text-[9px] text-slate-400">Global Scalability</p>
                                </div>
                                <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-blue-50 text-blue-600 border border-blue-100/50">Enterprise</span>
                            </div>
                        </div>

                        <!-- Card 4: Collaborative Workspaces -->
                        <div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden flex flex-col hover:scale-[1.02] hover:shadow-md hover:border-slate-300/80 transition-all duration-300 select-none">
                            <div class="flex items-center justify-between px-3 py-2 bg-slate-50 border-b border-slate-100 browser-glass-top shrink-0">
                                <div class="flex items-center gap-1.5 w-1/4">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                </div>
                                <div class="bg-white border border-slate-200/50 rounded py-0.5 px-2 text-[9px] text-slate-400 font-mono text-center flex items-center justify-center gap-1 shadow-sm max-w-[150px] truncate">
                                    <svg class="w-2.5 h-2.5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                                    <span class="truncate">timenest.com/workspaces</span>
                                </div>
                                <div class="w-1/4"></div>
                            </div>
                            <div class="relative overflow-hidden aspect-[16/10] bg-slate-100">
                                <img src="/images/mockups/mega_menu_resources.png" alt="Collaborative Workspaces" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-3 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800">Collaborative Workspaces</h4>
                                    <p class="text-[9px] text-slate-400">Shared Team Portals</p>
                                </div>
                                <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-teal-50 text-teal-600 border border-teal-100/50">Workspace</span>
                            </div>
                        </div>

                        <!-- Cards Set 2 (Duplicated for infinite scroll) -->
                        <!-- Card 1 Duplicate -->
                        <div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden flex flex-col hover:scale-[1.02] hover:shadow-md hover:border-slate-300/80 transition-all duration-300 select-none">
                            <div class="flex items-center justify-between px-3 py-2 bg-slate-50 border-b border-slate-100 browser-glass-top shrink-0">
                                <div class="flex items-center gap-1.5 w-1/4">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                </div>
                                <div class="bg-white border border-slate-200/50 rounded py-0.5 px-2 text-[9px] text-slate-400 font-mono text-center flex items-center justify-center gap-1 shadow-sm max-w-[150px] truncate">
                                    <svg class="w-2.5 h-2.5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                                    <span class="truncate">timenest.com/ai-analytics</span>
                                </div>
                                <div class="w-1/4"></div>
                            </div>
                            <div class="relative overflow-hidden aspect-[16/10] bg-slate-100">
                                <img src="/images/mockups/ai-analytics.png" alt="AI Analytics Hub" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-3 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800">AI Analytics Hub</h4>
                                    <p class="text-[9px] text-slate-400">Predictive Forecasting</p>
                                </div>
                                <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-violet-50 text-violet-600 border border-violet-100/50">Analytics</span>
                            </div>
                        </div>

                        <!-- Card 2 Duplicate -->
                        <div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden flex flex-col hover:scale-[1.02] hover:shadow-md hover:border-slate-300/80 transition-all duration-300 select-none">
                            <div class="flex items-center justify-between px-3 py-2 bg-slate-50 border-b border-slate-100 browser-glass-top shrink-0">
                                <div class="flex items-center gap-1.5 w-1/4">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                </div>
                                <div class="bg-white border border-slate-200/50 rounded py-0.5 px-2 text-[9px] text-slate-400 font-mono text-center flex items-center justify-center gap-1 shadow-sm max-w-[150px] truncate">
                                    <svg class="w-2.5 h-2.5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                                    <span class="truncate">timenest.com/billing</span>
                                </div>
                                <div class="w-1/4"></div>
                            </div>
                            <div class="relative overflow-hidden aspect-[16/10] bg-slate-100">
                                <img src="/images/mockups/finance_ledger.png" alt="Financial Invoicing" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-3 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800">Financial Invoicing</h4>
                                    <p class="text-[9px] text-slate-400">Ledger & Payments</p>
                                </div>
                                <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-amber-50 text-amber-600 border border-amber-100/50">Finance</span>
                            </div>
                        </div>

                        <!-- Card 3 Duplicate -->
                        <div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden flex flex-col hover:scale-[1.02] hover:shadow-md hover:border-slate-300/80 transition-all duration-300 select-none">
                            <div class="flex items-center justify-between px-3 py-2 bg-slate-50 border-b border-slate-100 browser-glass-top shrink-0">
                                <div class="flex items-center gap-1.5 w-1/4">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                </div>
                                <div class="bg-white border border-slate-200/50 rounded py-0.5 px-2 text-[9px] text-slate-400 font-mono text-center flex items-center justify-center gap-1 shadow-sm max-w-[150px] truncate">
                                    <svg class="w-2.5 h-2.5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                                    <span class="truncate">timenest.com/enterprise</span>
                                </div>
                                <div class="w-1/4"></div>
                            </div>
                            <div class="relative overflow-hidden aspect-[16/10] bg-slate-100">
                                <img src="/images/mockups/mega_menu_solutions.png" alt="Enterprise Solutions" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-3 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800">Enterprise Solutions</h4>
                                    <p class="text-[9px] text-slate-400">Global Scalability</p>
                                </div>
                                <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-blue-50 text-blue-600 border border-blue-100/50">Enterprise</span>
                            </div>
                        </div>

                        <!-- Card 4 Duplicate -->
                        <div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden flex flex-col hover:scale-[1.02] hover:shadow-md hover:border-slate-300/80 transition-all duration-300 select-none">
                            <div class="flex items-center justify-between px-3 py-2 bg-slate-50 border-b border-slate-100 browser-glass-top shrink-0">
                                <div class="flex items-center gap-1.5 w-1/4">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                </div>
                                <div class="bg-white border border-slate-200/50 rounded py-0.5 px-2 text-[9px] text-slate-400 font-mono text-center flex items-center justify-center gap-1 shadow-sm max-w-[150px] truncate">
                                    <svg class="w-2.5 h-2.5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                                    <span class="truncate">timenest.com/workspaces</span>
                                </div>
                                <div class="w-1/4"></div>
                            </div>
                            <div class="relative overflow-hidden aspect-[16/10] bg-slate-100">
                                <img src="/images/mockups/mega_menu_resources.png" alt="Collaborative Workspaces" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-3 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800">Collaborative Workspaces</h4>
                                    <p class="text-[9px] text-slate-400">Shared Team Portals</p>
                                </div>
                                <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-teal-50 text-teal-600 border border-teal-100/50">Workspace</span>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>

    {{-- Section 4: Role-Based Problem Statement --}}
    <section class="py-24 bg-white" x-data="{ activeTab: 'founders' }">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="font-display text-3xl lg:text-4xl font-bold text-content-strong mb-4">Built for everyone who runs work</h2>
                <p class="text-content-muted text-lg">Whether you're a founder scaling a company or a freelancer managing clients, TimeNest adapts to your specific workflow.</p>
            </div>

            <div class="flex flex-wrap justify-center gap-2 mb-12">
                @foreach([
                    'founders' => ['Founders', 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6'], 
                    'hr' => ['HR Teams', 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'], 
                    'operations' => ['Operations', 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z'], 
                    'freelancers' => ['Freelancers', 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'], 
                    'agencies' => ['Agencies', 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4']
                ] as $key => [$label, $icon])
                    <button @click="activeTab = '{{ $key }}'" :class="activeTab === '{{ $key }}' ? 'bg-brand-500 text-white shadow-md shadow-brand-500/20' : 'bg-white border border-surface-border text-content-muted hover:text-content-strong hover:bg-surface-50'" class="px-5 py-3 rounded-xl text-sm font-body font-medium transition-all cursor-pointer flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/></svg>
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            <div class="rounded-2xl border border-surface-border bg-white shadow-xl shadow-surface-border/30 overflow-hidden">
                @php
                    $roleData = [
                        'founders' => [
                            'pain' => 'Juggling 5+ tools for HR, attendance, leaves, and payroll. No unified view of workforce health and ballooning software costs.',
                            'solution' => 'One platform to manage your entire workforce. Real-time executive dashboards, AI-powered insights, and automated workflows.',
                            'modules' => ['Employee Management', 'AI Executive Dashboard', 'Analytics & Reports', 'Approvals & Workflows']
                        ],
                        'hr' => [
                            'pain' => 'Manual attendance tracking via spreadsheets, leave conflicts, shift scheduling nightmares, and scary compliance gaps.',
                            'solution' => 'Automated attendance, smart leave management, visual shift builder, and AI fraud detection to keep everything honest.',
                            'modules' => ['Attendance & Shifts', 'Leave Management', 'AI Fraud Detection', 'Audit Logs']
                        ],
                        'operations' => [
                            'pain' => 'Department silos, broken manual approval chains via email, and zero visibility into team performance or resource allocation.',
                            'solution' => 'Centralized department and team management. Custom workflows, role-based granular permissions, and operational analytics.',
                            'modules' => ['Departments & Teams', 'Workflows & Approvals', 'Roles & Permissions', 'Analytics']
                        ],
                        'freelancers' => [
                            'pain' => 'Scattered client data, manual invoicing processes, no accurate revenue tracking, and zero business intelligence.',
                            'solution' => 'All-in-one freelancer platform. CRM, invoicing, task management, and AI revenue forecasting — core features forever free.',
                            'modules' => ['Clients & Leads', 'Invoices & Payments', 'Tasks & Projects', 'Revenue Tracking']
                        ],
                        'agencies' => [
                            'pain' => 'Managing a freelance team without proper tools. No shared projects, no unified invoicing, and no team utilization analytics.',
                            'solution' => 'Freelance Workspace — a collaborative environment for agencies. Shared projects, shared invoicing, and team analytics.',
                            'modules' => ['Collaborator Management', 'Shared Projects & Tasks', 'Shared Invoices', 'Workspace Analytics']
                        ],
                    ];
                @endphp

                @foreach($roleData as $key => $data)
                    <div x-show="activeTab === '{{ $key }}'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-cloak class="p-8 lg:p-12">
                        <div class="grid lg:grid-cols-12 gap-12 items-center">
                            
                            <!-- Left: Pain & Solution -->
                            <div class="lg:col-span-5 space-y-8">
                                <div class="space-y-3">
                                    <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center border border-red-100">
                                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    </div>
                                    <h3 class="font-display text-lg font-bold text-slate-800">The Pain</h3>
                                    <p class="text-content-muted text-sm leading-relaxed">{{ $data['pain'] }}</p>
                                </div>
                                
                                <div class="space-y-3 border-t border-slate-100 pt-6">
                                    <div class="w-10 h-10 rounded-xl bg-brand-50 flex items-center justify-center border border-brand-100">
                                        <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <h3 class="font-display text-lg font-bold text-slate-800">TimeNest Solution</h3>
                                    <p class="text-content-muted text-sm leading-relaxed">{{ $data['solution'] }}</p>
                                </div>
                            </div>

                            <!-- Right: Replicas Showcase (Operational Cards) -->
                            <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @if($key === 'founders')
                                    @include('frontend.partials.widgets.cashflow')
                                    @include('frontend.partials.widgets.analytics')
                                    <div class="sm:col-span-2">
                                        @include('frontend.partials.widgets.sales')
                                    </div>
                                @elseif($key === 'hr')
                                    @include('frontend.partials.widgets.attendance')
                                    @include('frontend.partials.widgets.leave-requests')
                                    <div class="sm:col-span-2">
                                        @include('frontend.partials.widgets.team-status')
                                    </div>
                                @elseif($key === 'operations')
                                    @include('frontend.partials.widgets.payroll')
                                    @include('frontend.partials.widgets.projects')
                                    <div class="sm:col-span-2">
                                        @include('frontend.partials.widgets.tasks')
                                    </div>
                                @elseif($key === 'freelancers')
                                    @include('frontend.partials.widgets.freelancer-invoice')
                                    @include('frontend.partials.widgets.projects')
                                    <div class="sm:col-span-2">
                                        @include('frontend.partials.widgets.clients')
                                    </div>
                                @elseif($key === 'agencies')
                                    @include('frontend.partials.widgets.workspace-hub')
                                    @include('frontend.partials.widgets.ai-copilot')
                                    <div class="sm:col-span-2">
                                        @include('frontend.partials.widgets.team-status')
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Section 3: Deep Dive Features --}}
    <section class="py-24 bg-surface-50 border-y border-surface-border overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    <x-frontend-base.badge variant="accent" class="mb-6">Intelligent Core</x-frontend-base.badge>
                    <h2 class="font-display text-3xl lg:text-5xl font-bold text-content-strong mb-6 leading-tight">Everything you need to manage work, <span class="text-indigo-600">beautifully designed.</span></h2>
                    <p class="text-lg text-content-muted mb-8 leading-relaxed">
                        TimeNest isn't just a collection of tools. It's a deeply integrated ecosystem where attendance data feeds into payroll, project tasks feed into invoices, and AI connects the dots.
                    </p>
                    
                    <div class="space-y-6">
                        @foreach([
                            ['Employee Mgmt', 'Maintain a single source of truth for your entire workforce with rich profiles and documentation.'],
                            ['Smart Attendance', 'Geofenced clock-ins, biometric support, and real-time shift tracking.'],
                            ['Approval Workflows', 'Build custom multi-step approval chains for leaves, expenses, and operational changes.']
                        ] as [$title, $desc])
                            <div class="flex items-start gap-4">
                                <div class="w-8 h-8 rounded-lg bg-white border border-surface-border shadow-sm flex items-center justify-center shrink-0 mt-1">
                                    <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div>
                                    <h4 class="font-display font-bold text-content-strong mb-1">{{ $title }}</h4>
                                    <p class="text-content-muted text-sm">{{ $desc }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-10">
                        <x-frontend-base.link href="{{ route('frontend.solutions.show', 'workforce-management') }}" class="text-brand-600 font-semibold hover:text-brand-700">Explore all features &rarr;</x-frontend-base.link>
                    </div>
                </div>
                
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-tr from-brand-500/20 to-indigo-500/20 rounded-[2.5rem] transform rotate-3 scale-105"></div>
                    <div class="relative bg-white rounded-2xl shadow-xl shadow-surface-border/50 border border-surface-border p-2">
                        <img src="/images/mockups/ai-analytics.png" alt="AI Analytics Dashboard" class="w-full rounded-xl border border-surface-border/50">
                        
                        {{-- Floating Element --}}
                        <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-xl shadow-lg border border-surface-border flex items-center gap-4 animate-slide-up" style="animation-delay: 500ms;">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            </div>
                            <div>
                                <p class="text-xs text-content-muted font-medium uppercase tracking-wider">Productivity</p>
                                <p class="font-display font-bold text-content-strong text-xl">+24.5%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-20">
            <x-frontend-sections.carousel :slides="[
                ['title' => 'Real-time AI Analytics', 'description' => 'Instantly detect anomalies in attendance data, forecast revenue, and monitor productivity trends without running a single manual report.', 'badge' => 'TimeNest AI', 'image' => '/images/mockups/ai-analytics.png', 'url' => route('frontend.ai')],
                ['title' => 'Smart Shift Builder', 'description' => 'Drag-and-drop shift scheduling with automated conflict resolution. TimeNest ensures complete compliance with labor laws automatically.', 'badge' => 'Workforce Core', 'image' => '/images/mockups/hero-dashboard.png', 'url' => '#'],
                ['title' => 'Collaborative Workspaces', 'description' => 'Share projects, manage freelance teams, and consolidate invoicing into one unified platform for your creative agency.', 'badge' => 'Agencies', 'image' => '/images/mockups/ai-analytics.png', 'url' => '#'],
            ]" />
        </div>
    </section>

    {{-- Section 4: Product Lines Cards --}}
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="font-display text-3xl lg:text-4xl font-bold text-content-strong mb-4">Three products, one platform</h2>
                <p class="text-content-muted text-lg">Choose the product that fits your workflow right now, and seamlessly scale as your business grows without ever migrating data.</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                @foreach([
                    ['title' => 'For Organizations', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'desc' => 'Complete workforce and operations management for companies. Unify HR, attendance, shifts, and departmental workflows.', 'features' => ['Employee Directory & Profiles', 'Real-time Attendance & GPS', 'Shift Builder & Leave Rules', 'Multi-level Approvals'], 'cta' => 'Book Demo', 'url' => route('frontend.book-demo'), 'color' => 'brand'],
                    ['title' => 'For Freelancers', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'desc' => 'Everything a solo freelancer needs to manage clients, revenue, and projects. Run your entire freelance business from one dashboard.', 'features' => ['Client CRM & Lead Tracking', 'Professional Invoicing', 'Task & Project Kanban', 'Revenue Forecasting'], 'cta' => 'Start Free', 'url' => '/register', 'color' => 'indigo'],
                    ['title' => 'Freelance Workspace', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'desc' => 'A collaborative workspace for freelance teams, agencies, and studios. Work together without full corporate overhead.', 'features' => ['Collaborator Management', 'Shared Projects & Files', 'Unified Client Billing', 'Team Utilization Analytics'], 'cta' => 'Upgrade to Pro', 'url' => route('frontend.pricing'), 'color' => 'amber', 'pro' => true],
                ] as $product)
                    <div class="group rounded-2xl border border-surface-border bg-white p-8 hover:border-{{ $product['color'] }}-300 hover:shadow-xl hover:shadow-{{ $product['color'] }}-500/10 transition-all duration-300 flex flex-col relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-8 opacity-5 group-hover:opacity-10 transition-opacity">
                            <svg class="w-32 h-32 text-{{ $product['color'] }}-600 -mr-10 -mt-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="{{ $product['icon'] }}"/></svg>
                        </div>
                        
                        <div class="w-14 h-14 rounded-xl bg-{{ $product['color'] }}-50 flex items-center justify-center mb-6 text-{{ $product['color'] }}-600 border border-{{ $product['color'] }}-100 relative z-10">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $product['icon'] }}"/></svg>
                        </div>
                        
                        <h3 class="font-display text-2xl font-bold text-content-strong mb-3 relative z-10">{{ $product['title'] }}</h3>
                        
                        @if(isset($product['pro']))
                            <x-frontend-base.badge variant="pro" class="mb-4 self-start relative z-10">Requires Pro</x-frontend-base.badge>
                        @endif
                        
                        <p class="text-content-muted text-base leading-relaxed mb-8 relative z-10">{{ $product['desc'] }}</p>
                        
                        <div class="mb-8 flex-1 relative z-10">
                            <h4 class="text-xs font-semibold text-content-strong uppercase tracking-wider mb-4">Core Features</h4>
                            <ul class="space-y-3">
                                @foreach($product['features'] as $f)
                                    <li class="flex items-start gap-3 text-sm text-content-muted">
                                        <svg class="w-5 h-5 text-{{ $product['color'] }}-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        {{ $f }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        
                        <x-frontend-base.button :href="$product['url']" variant="outline" class="w-full relative z-10 bg-white border-surface-border hover:bg-{{ $product['color'] }}-50 hover:text-{{ $product['color'] }}-700 hover:border-{{ $product['color'] }}-200">{{ $product['cta'] }}</x-frontend-base.button>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Section 5: AI Platform --}}
    <section class="py-24 bg-brand-900 relative overflow-hidden text-white">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Ik0zNiA0MmwxMC0xMGw0IDQgMTItMTJWMTJIMTB2MTZMMjIgMTZsMTAgMTB6IiBmaWxsPSIjZmZmZmZmIiBmaWxsLW9wYWNpdHk9IjAuMDIiLz48L2c+PC9zdmc+')] opacity-20"></div>
        <div class="absolute right-0 top-0 w-[800px] h-[800px] bg-brand-500/20 rounded-full blur-[120px] pointer-events-none translate-x-1/3 -translate-y-1/3"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    <x-frontend-base.badge variant="accent" class="mb-6 bg-white/10 text-brand-100 border-white/20">TimeNest AI</x-frontend-base.badge>
                    <h2 class="font-display text-3xl lg:text-5xl font-bold text-white mb-6 leading-tight">Intelligence embedded into every workflow.</h2>
                    <p class="text-lg text-brand-100/80 mb-10 leading-relaxed">
                        We didn't just bolt on a chatbot. TimeNest AI monitors your operations in the background, surfacing insights, detecting anomalies, and automating routine administrative tasks before you even ask.
                    </p>
                    
                    <div class="grid sm:grid-cols-2 gap-6">
                        @foreach([
                            ['AI Workforce Analyst', 'Detect attendance anomalies, leave abuse patterns, and overtime risks.', 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'],
                            ['AI Fraud Detection', 'Identify location spoofing, fake attendance, and suspicious reimbursements.', 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                            ['AI Executive Dashboards', 'Ask complex business queries in plain English and get visual answers.', 'M8 13v-1m4 1v-3m4 3V8M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z'],
                            ['AI Freelancer Assistant', 'Smart invoice categorization, payment risk assessment, and revenue prediction.', 'M13 10V3L4 14h7v7l9-11h-7z'],
                        ] as [$title, $desc, $icon])
                            <div class="bg-white/5 border border-white/10 p-5 rounded-xl hover:bg-white/10 transition-colors">
                                <svg class="w-6 h-6 text-brand-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $icon }}"/></svg>
                                <h3 class="font-display font-semibold text-white mb-2">{{ $title }}</h3>
                                <p class="text-brand-100/70 text-sm leading-relaxed">{{ $desc }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="relative hidden lg:block">
                    <div class="bg-surface/50 border border-white/10 rounded-2xl p-8 backdrop-blur-md shadow-2xl">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-12 h-12 rounded-full bg-brand-500/20 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6 text-brand-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <div>
                                <p class="text-white font-medium">TimeNest AI Agent</p>
                                <p class="text-brand-200/60 text-sm">Analyzing current month operations...</p>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="bg-white/10 rounded-xl p-4 border border-white/5 animate-pulse">
                                <div class="h-4 bg-white/20 rounded w-3/4 mb-3"></div>
                                <div class="h-3 bg-white/10 rounded w-full mb-2"></div>
                                <div class="h-3 bg-white/10 rounded w-5/6"></div>
                            </div>
                            <div class="bg-white/5 rounded-xl p-4 border border-white/5 border-l-4 border-l-amber-500">
                                <h4 class="text-white font-medium mb-1">Anomaly Detected</h4>
                                <p class="text-brand-100/70 text-sm">Design team has logged 15% more overtime this week compared to monthly average. Risk of burnout is high.</p>
                            </div>
                            <div class="bg-white/5 rounded-xl p-4 border border-white/5 border-l-4 border-l-brand-500">
                                <h4 class="text-white font-medium mb-1">Revenue Forecast</h4>
                                <p class="text-brand-100/70 text-sm">Based on current billable hours, Q3 revenue is projected to exceed targets by 8.5%.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Section 6: Stats Strip --}}
    <x-frontend-sections.stats-strip :stats="$stats" />

    {{-- Section 7: Interactive ROI Calculator --}}
    <section class="py-24 bg-surface-50 border-y border-surface-border" x-data="{ 
        employees: 50, 
        hrSize: 3, 
        avgSalary: 50000, 
        get timeSaved() { return Math.round(this.employees * 0.5 + this.hrSize * 8) }, 
        get moneySaved() { return Math.round((this.timeSaved * 12 * this.avgSalary) / (22 * 8 * 12)) }, 
        get productivity() { return Math.min(Math.round(this.employees * 0.15 + this.hrSize * 2), 45) } 
    }">
        <div class="max-w-6xl mx-auto px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="font-display text-3xl lg:text-4xl font-bold text-content-strong mb-4">Calculate your exact ROI</h2>
                <p class="text-content-muted text-lg">See how much time and money TimeNest can save your organization by eliminating manual tasks and tool sprawl.</p>
            </div>
            
            <div class="rounded-3xl border border-surface-border bg-white shadow-xl p-8 lg:p-12">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <div class="space-y-10">
                        <div>
                            <div class="flex justify-between mb-3">
                                <label class="text-sm font-bold text-content-strong uppercase tracking-wider">Number of Employees</label>
                                <span class="font-display font-bold text-brand-600" x-text="employees"></span>
                            </div>
                            <input type="range" min="10" max="1000" x-model="employees" class="w-full h-2 bg-surface-border rounded-lg appearance-none cursor-pointer accent-brand-500">
                        </div>
                        <div>
                            <div class="flex justify-between mb-3">
                                <label class="text-sm font-bold text-content-strong uppercase tracking-wider">HR/Ops Team Size</label>
                                <span class="font-display font-bold text-brand-600" x-text="hrSize"></span>
                            </div>
                            <input type="range" min="1" max="20" x-model="hrSize" class="w-full h-2 bg-surface-border rounded-lg appearance-none cursor-pointer accent-brand-500">
                        </div>
                        <div>
                            <div class="flex justify-between mb-3">
                                <label class="text-sm font-bold text-content-strong uppercase tracking-wider">Avg Monthly Salary (₹)</label>
                                <span class="font-display font-bold text-brand-600" x-text="'₹' + Number(avgSalary).toLocaleString()"></span>
                            </div>
                            <input type="range" min="15000" max="200000" step="5000" x-model="avgSalary" class="w-full h-2 bg-surface-border rounded-lg appearance-none cursor-pointer accent-brand-500">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="rounded-2xl bg-brand-50 p-6 border border-brand-100 flex flex-col justify-center shadow-sm">
                            <p class="text-brand-700 text-sm font-medium mb-2 uppercase tracking-wider">Time Saved Monthly</p>
                            <p class="font-display text-4xl font-bold text-brand-600 mb-1" x-text="timeSaved + ' hrs'"></p>
                            <p class="text-brand-600/70 text-xs">Automating approvals & attendance</p>
                        </div>
                        <div class="rounded-2xl bg-indigo-50 p-6 border border-indigo-100 flex flex-col justify-center shadow-sm">
                            <p class="text-indigo-700 text-sm font-medium mb-2 uppercase tracking-wider">Productivity Boost</p>
                            <p class="font-display text-4xl font-bold text-indigo-600 mb-1" x-text="'+' + productivity + '%'"></p>
                            <p class="text-indigo-600/70 text-xs">Due to centralized workflows</p>
                        </div>
                        <div class="sm:col-span-2 rounded-2xl bg-green-50 p-8 border border-green-100 flex flex-col justify-center shadow-sm relative overflow-hidden">
                            <svg class="absolute right-0 bottom-0 text-green-200/50 w-32 h-32 -mr-8 -mb-8 transform rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="text-green-700 text-sm font-medium mb-2 uppercase tracking-wider relative z-10">Estimated Annual Savings</p>
                            <p class="font-display text-5xl font-bold text-green-600 relative z-10" x-text="'₹' + Number(moneySaved).toLocaleString()"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Section 8: Testimonials --}}
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <x-frontend-sections.section-header title="Loved by forward-thinking teams" subtitle="Don't just take our word for it. Here's what our users have to say about TimeNest." badge="Testimonials" />
            
            <div class="grid md:grid-cols-3 gap-6 mt-12">
                @foreach($testimonials as $t)
                    <div class="bg-white rounded-2xl p-8 shadow-lg shadow-surface-border/20 border border-surface-border">
                        <div class="flex items-center gap-1 mb-6">
                            @for($i=0; $i<$t['rating']; $i++)
                                <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <p class="text-content-strong text-lg mb-8 leading-relaxed">"{{ $t['content'] }}"</p>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-brand-100 flex items-center justify-center text-brand-700 font-bold font-display">
                                {{ substr($t['name'], 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-content-strong">{{ $t['name'] }}</h4>
                                <p class="text-sm text-content-muted">{{ $t['role'] }}, {{ $t['company'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Section 9: Security & Compliance --}}
    <section class="py-16 bg-surface-50 border-y border-surface-border">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                @foreach([
                    ['M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'Enterprise Security'], 
                    ['M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'Data Encryption'], 
                    ['M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01', 'Complete Audit Logs'], 
                    ['M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'GDPR Ready']
                ] as [$icon, $label])
                    <div class="flex flex-col items-center justify-center">
                        <div class="w-12 h-12 rounded-xl bg-white border border-surface-border shadow-sm flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $icon }}"/></svg>
                        </div>
                        <p class="text-content-strong font-semibold text-sm uppercase tracking-wider">{{ $label }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Section 10: FAQ --}}
    <section class="py-24 bg-white">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="font-display text-3xl font-bold text-content-strong mb-4">Frequently Asked Questions</h2>
                <p class="text-content-muted text-lg">Everything you need to know about implementing TimeNest for your organization.</p>
            </div>
            <x-frontend-sections.faq-block :faqs="$faqs" />
        </div>
    </section>

    {{-- Section 11: Final CTA --}}
    <section class="py-24 bg-brand-900 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-brand-600 to-indigo-600 opacity-90"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Ik0zNiA0MmwxMC0xMGw0IDQgMTItMTJWMTJIMTB2MTZMMjIgMTZsMTAgMTB6IiBmaWxsPSIjZmZmZmZmIiBmaWxsLW9wYWNpdHk9IjAuMDUiLz48L2c+PC9zdmc+')]"></div>
        
        <div class="relative z-10 max-w-4xl mx-auto px-6 lg:px-8 text-center">
            <h2 class="font-display text-4xl lg:text-5xl font-bold text-white mb-6">Stop stitching tools together.</h2>
            <p class="text-xl text-white/80 mb-10 max-w-2xl mx-auto">Join thousands of teams running their entire workforce, operations, and freelancers on a single, intelligent platform.</p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <x-frontend-base.button href="/register" variant="primary" color="white" size="lg" class="w-full sm:w-auto h-14 px-8 text-brand-700 bg-white hover:bg-surface-50 shadow-xl">
                    Start for Free
                </x-frontend-base.button>
                <x-frontend-base.button href="{{ route('frontend.book-demo') }}" variant="outline" color="white" size="lg" class="w-full sm:w-auto h-14 px-8 text-white border-white/30 hover:bg-white/10">
                    Book a Demo
                </x-frontend-base.button>
            </div>
            <p class="text-white/60 text-sm mt-6">No credit card required. 14-day free trial on Pro plans.</p>
        </div>
    </section>
</x-frontend-layout.app>
