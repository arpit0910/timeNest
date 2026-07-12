<x-frontend-layout.app
    metaTitle="TimeNest — The Work Operating System for Modern Teams"
    metaDescription="Complete workforce management for organizations, freelancer tools, and collaborative workspaces. One platform for every workflow."
>
    {{-- Section 1: Hero --}}
    <section class="relative pt-32 pb-14 lg:pt-48 lg:pb-20 overflow-hidden" 
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
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/60 backdrop-blur-md border border-slate-200/80 shadow-[0_2px_8px_-2px_rgba(0,0,0,0.05)] mb-8 cursor-pointer hover:border-brand-500/30 hover:shadow-md transition-all duration-300">
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-teal-500"></span>
                    </span>
                    <span class="text-[13px] font-semibold text-slate-800 tracking-wide">TimeNest 2.0 is now live</span>
                    <svg class="w-3.5 h-3.5 text-slate-400 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </div>
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
    <section class="py-16 sm:py-20 lg:py-24 bg-gradient-to-b from-white via-slate-50/40 to-white overflow-hidden relative border-t border-slate-100/80"
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
            <div class="absolute inset-y-0 left-0 w-12 sm:w-20 md:w-32 bg-gradient-to-r from-white to-transparent pointer-events-none z-10"></div>
            <div class="absolute inset-y-0 right-0 w-12 sm:w-20 md:w-32 bg-gradient-to-l from-white to-transparent pointer-events-none z-10"></div>

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
    <section class="py-12 sm:py-16 lg:py-20 bg-slate-50/50 border-y border-slate-100/80 overflow-hidden relative"
             x-data="{ show: false }"
             x-init="const obs = new IntersectionObserver(([entry]) => { if (entry.isIntersecting) { show = true; obs.disconnect(); } }, { threshold: 0.05 }); obs.observe($el);"
    >
        <!-- Ambient background glows for premium visual context -->
        <div class="absolute top-0 left-1/4 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] bg-gradient-to-br from-indigo-500/5 via-transparent to-transparent rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 right-1/4 translate-x-1/2 translate-y-1/2 w-[700px] h-[700px] bg-gradient-to-br from-teal-500/5 via-transparent to-transparent rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-20 transition-all duration-1000 transform"
                 :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                <x-frontend-base.badge variant="primary" class="mb-4">Capabilities</x-frontend-base.badge>
                <h2 class="font-display text-3xl lg:text-5xl font-bold text-content-strong mb-4 tracking-tight">Everything that runs your business. <span class="text-brand-500">In one platform.</span></h2>
                <p class="text-content-muted text-lg lg:text-xl font-body">Ditch the tool sprawl. TimeNest consolidates your operations, workforce management, and freelancer tools into a single source of truth.</p>
            </div>

            <!-- Capabilities Grid: Desktop = 2-col grid, Mobile = carousel -->
            <div class="transition-all duration-1000 delay-300 transform animate-hero-fade-up"
                 :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
                 x-data="{ capSlide: 0, capTotal: 4 }">

                {{-- Desktop: Normal 2x2 grid (hidden on mobile) --}}
                <div class="hidden md:grid md:grid-cols-2 gap-8">

                    <!-- Capability 1: Workforce & HR Operations -->
                    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 lg:p-8 shadow-sm flex flex-col justify-between hover:shadow-md hover:border-slate-300 transition-all duration-300 group">
                        <div class="flex items-start gap-4 mb-6">
                            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center border border-indigo-100 shrink-0 group-hover:bg-indigo-500 group-hover:text-white group-hover:border-indigo-500 transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest">Workforce & HR</span>
                                <h3 class="font-display text-xl font-bold text-slate-800 mt-1">Workforce & HR Operations</h3>
                                <p class="text-content-muted text-xs leading-relaxed mt-2">Manage employees and freelancers in one unified directory. Set shift schedules, approve leaves, and verify logins automatically.</p>
                                <div class="flex flex-wrap gap-1.5 mt-3">
                                    <span class="text-[9px] font-semibold px-2.5 py-0.5 rounded-full bg-slate-50 text-slate-500 border border-slate-200/50">Biometric Clock-ins</span>
                                    <span class="text-[9px] font-semibold px-2.5 py-0.5 rounded-full bg-slate-50 text-slate-500 border border-slate-200/50">Visual Rostering</span>
                                    <span class="text-[9px] font-semibold px-2.5 py-0.5 rounded-full bg-slate-50 text-slate-500 border border-slate-200/50">Conflict-Free Leaves</span>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
                            @include('frontend.partials.widgets.attendance')
                            @include('frontend.partials.widgets.team-status')
                            @include('frontend.partials.widgets.leave-requests')
                            @include('frontend.partials.widgets.shift-schedule')
                        </div>
                    </div>

                    <!-- Capability 2: Operations & Project Workflows -->
                    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 lg:p-8 shadow-sm flex flex-col justify-between hover:shadow-md hover:border-slate-300 transition-all duration-300 group">
                        <div class="flex items-start gap-4 mb-6">
                            <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center border border-teal-100 shrink-0 group-hover:bg-teal-500 group-hover:text-white group-hover:border-teal-500 transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-[10px] font-bold text-teal-600 uppercase tracking-widest">Operations & Tasks</span>
                                <h3 class="font-display text-xl font-bold text-slate-800 mt-1">Operations & Project Workflows</h3>
                                <p class="text-content-muted text-xs leading-relaxed mt-2">Connect task milestones directly to team capacity. Setup multi-stage approval paths to automate operations and department structures.</p>
                                <div class="flex flex-wrap gap-1.5 mt-3">
                                    <span class="text-[9px] font-semibold px-2.5 py-0.5 rounded-full bg-slate-50 text-slate-500 border border-slate-200/50">Kanban Boards</span>
                                    <span class="text-[9px] font-semibold px-2.5 py-0.5 rounded-full bg-slate-50 text-slate-500 border border-slate-200/50">Sprint Velocity</span>
                                    <span class="text-[9px] font-semibold px-2.5 py-0.5 rounded-full bg-slate-50 text-slate-500 border border-slate-200/50">Custom Approval Chains</span>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
                            @include('frontend.partials.widgets.approval-workflow')
                            @include('frontend.partials.widgets.projects')
                            @include('frontend.partials.widgets.tasks')
                            @include('frontend.partials.widgets.department-structure')
                        </div>
                    </div>

                    <!-- Capability 3: Financial Operations & Billing -->
                    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 lg:p-8 shadow-sm flex flex-col justify-between hover:shadow-md hover:border-slate-300 transition-all duration-300 group">
                        <div class="flex items-start gap-4 mb-6">
                            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-100 shrink-0 group-hover:bg-amber-500 group-hover:text-white group-hover:border-amber-500 transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-[10px] font-bold text-amber-600 uppercase tracking-widest">Finance & Billings</span>
                                <h3 class="font-display text-xl font-bold text-slate-800 mt-1">Financial Operations & Billing</h3>
                                <p class="text-content-muted text-xs leading-relaxed mt-2">Run payroll instantly based on tracked hours, authorize employee business expenses, and automate client invoice cycles.</p>
                                <div class="flex flex-wrap gap-1.5 mt-3">
                                    <span class="text-[9px] font-semibold px-2.5 py-0.5 rounded-full bg-slate-50 text-slate-500 border border-slate-200/50">Automated Payroll</span>
                                    <span class="text-[9px] font-semibold px-2.5 py-0.5 rounded-full bg-slate-50 text-slate-500 border border-slate-200/50">Expense Approvals</span>
                                    <span class="text-[9px] font-semibold px-2.5 py-0.5 rounded-full bg-slate-50 text-slate-500 border border-slate-200/50">Client Revenue logs</span>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
                            @include('frontend.partials.widgets.cashflow')
                            @include('frontend.partials.widgets.payroll')
                            @include('frontend.partials.widgets.expense-tracking')
                            @include('frontend.partials.widgets.client-revenue')
                        </div>
                    </div>

                    <!-- Capability 4: AI Insights & Security Governance -->
                    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 lg:p-8 shadow-sm flex flex-col justify-between hover:shadow-md hover:border-slate-300 transition-all duration-300 group">
                        <div class="flex items-start gap-4 mb-6">
                            <div class="w-12 h-12 rounded-2xl bg-violet-50 text-violet-600 flex items-center justify-center border border-violet-100 shrink-0 group-hover:bg-violet-500 group-hover:text-white group-hover:border-violet-500 transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-[10px] font-bold text-violet-600 uppercase tracking-widest">AI & Governance</span>
                                <h3 class="font-display text-xl font-bold text-slate-800 mt-1">AI Insights & Security Governance</h3>
                                <p class="text-content-muted text-xs leading-relaxed mt-2">Leverage machine learning to identify burnout, detect attendance fraud, and secure your systems with detailed logs.</p>
                                <div class="flex flex-wrap gap-1.5 mt-3">
                                    <span class="text-[9px] font-semibold px-2.5 py-0.5 rounded-full bg-slate-50 text-slate-500 border border-slate-200/50">Predictive Anomaly Scans</span>
                                    <span class="text-[9px] font-semibold px-2.5 py-0.5 rounded-full bg-slate-50 text-slate-500 border border-slate-200/50">SOC2 Compliance Auditing</span>
                                    <span class="text-[9px] font-semibold px-2.5 py-0.5 rounded-full bg-slate-50 text-slate-500 border border-slate-200/50">Access Audit Trails</span>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
                            @include('frontend.partials.widgets.ai-copilot')
                            @include('frontend.partials.widgets.ai-insights')
                            @include('frontend.partials.widgets.audit-trail')
                            @include('frontend.partials.widgets.compliance-tracker')
                        </div>
                    </div>

                </div>

                {{-- Mobile: Swipeable carousel (shown only on mobile) --}}
                <div class="md:hidden relative overflow-hidden">
                    <div class="relative">
                        @php
                            $capCards = [
                                [
                                    'color' => 'indigo', 'label' => 'Workforce & HR', 'title' => 'Workforce & HR Operations',
                                    'desc' => 'Manage employees and freelancers in one unified directory. Set shift schedules, approve leaves, and verify logins automatically.',
                                    'tags' => ['Biometric Clock-ins', 'Visual Rostering', 'Conflict-Free Leaves'],
                                    'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z',
                                    'widgets' => ['attendance', 'team-status', 'leave-requests', 'shift-schedule']
                                ],
                                [
                                    'color' => 'teal', 'label' => 'Operations & Tasks', 'title' => 'Operations & Project Workflows',
                                    'desc' => 'Connect task milestones directly to team capacity. Setup multi-stage approval paths to automate operations.',
                                    'tags' => ['Kanban Boards', 'Sprint Velocity', 'Custom Approval Chains'],
                                    'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
                                    'widgets' => ['approval-workflow', 'projects', 'tasks', 'department-structure']
                                ],
                                [
                                    'color' => 'amber', 'label' => 'Finance & Billings', 'title' => 'Financial Operations & Billing',
                                    'desc' => 'Run payroll instantly based on tracked hours, authorize employee business expenses, and automate client invoice cycles.',
                                    'tags' => ['Automated Payroll', 'Expense Approvals', 'Client Revenue logs'],
                                    'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1',
                                    'widgets' => ['cashflow', 'payroll', 'expense-tracking', 'client-revenue']
                                ],
                                [
                                    'color' => 'violet', 'label' => 'AI & Governance', 'title' => 'AI Insights & Security Governance',
                                    'desc' => 'Leverage machine learning to identify burnout, detect attendance fraud, and secure your systems with detailed logs.',
                                    'tags' => ['Predictive Anomaly Scans', 'SOC2 Compliance Auditing', 'Access Audit Trails'],
                                    'icon' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z',
                                    'widgets' => ['ai-copilot', 'ai-insights', 'audit-trail', 'compliance-tracker']
                                ],
                            ];
                        @endphp

                        @foreach($capCards as $ci => $cap)
                            <div x-show="capSlide === {{ $ci }}"
                                 x-transition:enter="transition ease-out duration-400"
                                 x-transition:enter-start="opacity-0 translate-x-8"
                                 x-transition:enter-end="opacity-100 translate-x-0"
                                 x-transition:leave="transition ease-in duration-200 absolute inset-0"
                                 x-transition:leave-start="opacity-100 translate-x-0"
                                 x-transition:leave-end="opacity-0 -translate-x-8"
                                 x-cloak
                                 class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm">
                                <div class="flex items-start gap-3 mb-5">
                                    <div class="w-10 h-10 rounded-xl bg-{{ $cap['color'] }}-50 text-{{ $cap['color'] }}-600 flex items-center justify-center border border-{{ $cap['color'] }}-100 shrink-0">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $cap['icon'] }}" /></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="text-[9px] font-bold text-{{ $cap['color'] }}-600 uppercase tracking-widest">{{ $cap['label'] }}</span>
                                        <h3 class="font-display text-lg font-bold text-slate-800 mt-0.5 leading-tight">{{ $cap['title'] }}</h3>
                                        <p class="text-content-muted text-xs leading-relaxed mt-1.5">{{ $cap['desc'] }}</p>
                                        <div class="flex flex-wrap gap-1 mt-2">
                                            @foreach($cap['tags'] as $tag)
                                                <span class="text-[8px] font-semibold px-2 py-0.5 rounded-full bg-slate-50 text-slate-500 border border-slate-200/50">{{ $tag }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-3">
                                    @foreach($cap['widgets'] as $w)
                                        @include('frontend.partials.widgets.' . $w)
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Mobile carousel controls --}}
                    <div class="flex items-center justify-center gap-2 mt-5">
                        <button @click="capSlide = (capSlide - 1 + capTotal) % capTotal" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-white hover:shadow-sm border border-transparent hover:border-slate-200 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <template x-for="i in capTotal">
                            <button @click="capSlide = i - 1" class="h-1.5 rounded-full transition-all duration-400" :class="capSlide === i - 1 ? 'w-7 bg-gradient-to-r from-brand-500 to-indigo-500' : 'w-1.5 bg-slate-200 hover:bg-slate-400'"></button>
                        </template>
                        <button @click="capSlide = (capSlide + 1) % capTotal" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-white hover:shadow-sm border border-transparent hover:border-slate-200 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Section 3: Dashboard Product Showcase --}}
    <section class="py-12 sm:py-16 lg:py-20 bg-white overflow-hidden"
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
                <!-- Fade overlays to smooth the scrolling effect -->
                <div class="absolute top-0 inset-x-0 h-6 sm:h-12 md:h-16 bg-gradient-to-b from-white to-transparent pointer-events-none z-10"></div>
                <div class="absolute bottom-0 inset-x-0 h-6 sm:h-12 md:h-16 bg-gradient-to-t from-white to-transparent pointer-events-none z-10"></div>
                
                <!-- Dual Column Layout -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 h-full p-4 md:p-6 pause-hover">
                    
                    <!-- Left Column: Scrolling Down (Top to Bottom) -->
                    <div class="flex flex-col gap-6 animate-marquee-down">
                        
                        <!-- Cards Set 1 -->
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
                            <div class="relative overflow-hidden aspect-[4/3] bg-slate-100">
                                <img src="/images/mockups/hero-dashboard.png" alt="Work OS Dashboard" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-4 bg-slate-50/50 border-t border-slate-100 flex flex-col gap-3">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800">Work OS Dashboard</h4>
                                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wide mt-0.5 mb-2">Central Command Hub</p>
                                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">Monitor real-time operations, team attendance, and live financial metrics all from a single, intuitive interface.</p>
                                </div>
                                <div class="flex flex-wrap gap-1.5">
                                    <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-indigo-50 text-indigo-600 border border-indigo-100/50">Core</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-indigo-50 text-indigo-600 border border-indigo-100/50">Real-time</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-indigo-50 text-indigo-600 border border-indigo-100/50">Insights</span>
                                        
                                </div>
                            </div>
                        </div>
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
                            <div class="relative overflow-hidden aspect-[4/3] bg-slate-100">
                                <img src="/images/mockups/workforce_scheduler.png" alt="Workforce Scheduler" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-4 bg-slate-50/50 border-t border-slate-100 flex flex-col gap-3">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800">Workforce Scheduler</h4>
                                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wide mt-0.5 mb-2">Shift & Roster Manager</p>
                                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">Easily drag and drop shifts, manage employee time-offs, and instantly detect scheduling conflicts before they happen.</p>
                                </div>
                                <div class="flex flex-wrap gap-1.5">
                                    <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-emerald-50 text-emerald-600 border border-emerald-100/50">Roster</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-emerald-50 text-emerald-600 border border-emerald-100/50">Shifts</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-emerald-50 text-emerald-600 border border-emerald-100/50">Conflicts</span>
                                        
                                </div>
                            </div>
                        </div>
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
                            <div class="relative overflow-hidden aspect-[4/3] bg-slate-100">
                                <img src="/images/mockups/compliance_audit.png" alt="Compliance & Audit" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-4 bg-slate-50/50 border-t border-slate-100 flex flex-col gap-3">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800">Compliance & Audit</h4>
                                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wide mt-0.5 mb-2">Immutable Event Logging</p>
                                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">Automatically maintain a strict audit trail of every data change to guarantee SOC2 and GDPR compliance effortlessly.</p>
                                </div>
                                <div class="flex flex-wrap gap-1.5">
                                    <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-rose-50 text-rose-600 border border-rose-100/50">Audit</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-rose-50 text-rose-600 border border-rose-100/50">SOC2</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-rose-50 text-rose-600 border border-rose-100/50">GDPR</span>
                                        
                                </div>
                            </div>
                        </div>
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
                            <div class="relative overflow-hidden aspect-[4/3] bg-slate-100">
                                <img src="/images/mockups/mega_menu_ai.png" alt="AI Intelligence Core" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-4 bg-slate-50/50 border-t border-slate-100 flex flex-col gap-3">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800">AI Intelligence Core</h4>
                                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wide mt-0.5 mb-2">Automated Operations Rules</p>
                                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">Leverage machine learning to flag potential burnout, optimize your task delegations, and automatically approve workflows.</p>
                                </div>
                                <div class="flex flex-wrap gap-1.5">
                                    <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-cyan-50 text-cyan-600 border border-cyan-100/50">Automation</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-cyan-50 text-cyan-600 border border-cyan-100/50">ML</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-cyan-50 text-cyan-600 border border-cyan-100/50">Rules</span>
                                        
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden flex flex-col hover:scale-[1.02] hover:shadow-md hover:border-slate-300/80 transition-all duration-300 select-none">
                            <div class="flex items-center justify-between px-3 py-2 bg-slate-50 border-b border-slate-100 browser-glass-top shrink-0">
                                <div class="flex items-center gap-1.5 w-1/4">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                </div>
                                <div class="bg-white border border-slate-200/50 rounded py-0.5 px-2 text-[9px] text-slate-400 font-mono text-center flex items-center justify-center gap-1 shadow-sm max-w-[150px] truncate">
                                    <svg class="w-2.5 h-2.5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                                    <span class="truncate">timenest.com/payroll</span>
                                </div>
                                <div class="w-1/4"></div>
                            </div>
                            <div class="relative overflow-hidden aspect-[4/3] bg-slate-100">
                                <img src="/images/mockups/finance_ledger.png" alt="Payroll Automations" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-4 bg-slate-50/50 border-t border-slate-100 flex flex-col gap-3">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800">Payroll Automations</h4>
                                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wide mt-0.5 mb-2">Seamless Contractor Payouts</p>
                                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">Directly link tracked hours and approved shifts to integrated payroll systems, ensuring everyone is paid accurately and on time.</p>
                                </div>
                                <div class="flex flex-wrap gap-1.5">
                                    <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-amber-50 text-amber-600 border border-amber-100/50">Payroll</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-amber-50 text-amber-600 border border-amber-100/50">Finance</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-amber-50 text-amber-600 border border-amber-100/50">Sync</span>
                                        
                                </div>
                            </div>
                        </div>

                        <!-- Cards Set 2 (Duplicated for infinite scroll) -->
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
                            <div class="relative overflow-hidden aspect-[4/3] bg-slate-100">
                                <img src="/images/mockups/hero-dashboard.png" alt="Work OS Dashboard" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-4 bg-slate-50/50 border-t border-slate-100 flex flex-col gap-3">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800">Work OS Dashboard</h4>
                                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wide mt-0.5 mb-2">Central Command Hub</p>
                                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">Monitor real-time operations, team attendance, and live financial metrics all from a single, intuitive interface.</p>
                                </div>
                                <div class="flex flex-wrap gap-1.5">
                                    <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-indigo-50 text-indigo-600 border border-indigo-100/50">Core</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-indigo-50 text-indigo-600 border border-indigo-100/50">Real-time</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-indigo-50 text-indigo-600 border border-indigo-100/50">Insights</span>
                                        
                                </div>
                            </div>
                        </div>
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
                            <div class="relative overflow-hidden aspect-[4/3] bg-slate-100">
                                <img src="/images/mockups/workforce_scheduler.png" alt="Workforce Scheduler" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-4 bg-slate-50/50 border-t border-slate-100 flex flex-col gap-3">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800">Workforce Scheduler</h4>
                                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wide mt-0.5 mb-2">Shift & Roster Manager</p>
                                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">Easily drag and drop shifts, manage employee time-offs, and instantly detect scheduling conflicts before they happen.</p>
                                </div>
                                <div class="flex flex-wrap gap-1.5">
                                    <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-emerald-50 text-emerald-600 border border-emerald-100/50">Roster</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-emerald-50 text-emerald-600 border border-emerald-100/50">Shifts</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-emerald-50 text-emerald-600 border border-emerald-100/50">Conflicts</span>
                                        
                                </div>
                            </div>
                        </div>
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
                            <div class="relative overflow-hidden aspect-[4/3] bg-slate-100">
                                <img src="/images/mockups/compliance_audit.png" alt="Compliance & Audit" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-4 bg-slate-50/50 border-t border-slate-100 flex flex-col gap-3">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800">Compliance & Audit</h4>
                                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wide mt-0.5 mb-2">Immutable Event Logging</p>
                                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">Automatically maintain a strict audit trail of every data change to guarantee SOC2 and GDPR compliance effortlessly.</p>
                                </div>
                                <div class="flex flex-wrap gap-1.5">
                                    <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-rose-50 text-rose-600 border border-rose-100/50">Audit</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-rose-50 text-rose-600 border border-rose-100/50">SOC2</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-rose-50 text-rose-600 border border-rose-100/50">GDPR</span>
                                        
                                </div>
                            </div>
                        </div>
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
                            <div class="relative overflow-hidden aspect-[4/3] bg-slate-100">
                                <img src="/images/mockups/mega_menu_ai.png" alt="AI Intelligence Core" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-4 bg-slate-50/50 border-t border-slate-100 flex flex-col gap-3">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800">AI Intelligence Core</h4>
                                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wide mt-0.5 mb-2">Automated Operations Rules</p>
                                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">Leverage machine learning to flag potential burnout, optimize your task delegations, and automatically approve workflows.</p>
                                </div>
                                <div class="flex flex-wrap gap-1.5">
                                    <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-cyan-50 text-cyan-600 border border-cyan-100/50">Automation</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-cyan-50 text-cyan-600 border border-cyan-100/50">ML</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-cyan-50 text-cyan-600 border border-cyan-100/50">Rules</span>
                                        
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden flex flex-col hover:scale-[1.02] hover:shadow-md hover:border-slate-300/80 transition-all duration-300 select-none">
                            <div class="flex items-center justify-between px-3 py-2 bg-slate-50 border-b border-slate-100 browser-glass-top shrink-0">
                                <div class="flex items-center gap-1.5 w-1/4">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                </div>
                                <div class="bg-white border border-slate-200/50 rounded py-0.5 px-2 text-[9px] text-slate-400 font-mono text-center flex items-center justify-center gap-1 shadow-sm max-w-[150px] truncate">
                                    <svg class="w-2.5 h-2.5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                                    <span class="truncate">timenest.com/payroll</span>
                                </div>
                                <div class="w-1/4"></div>
                            </div>
                            <div class="relative overflow-hidden aspect-[4/3] bg-slate-100">
                                <img src="/images/mockups/finance_ledger.png" alt="Payroll Automations" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-4 bg-slate-50/50 border-t border-slate-100 flex flex-col gap-3">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800">Payroll Automations</h4>
                                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wide mt-0.5 mb-2">Seamless Contractor Payouts</p>
                                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">Directly link tracked hours and approved shifts to integrated payroll systems, ensuring everyone is paid accurately and on time.</p>
                                </div>
                                <div class="flex flex-wrap gap-1.5">
                                    <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-amber-50 text-amber-600 border border-amber-100/50">Payroll</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-amber-50 text-amber-600 border border-amber-100/50">Finance</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-amber-50 text-amber-600 border border-amber-100/50">Sync</span>
                                        
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Right Column: Scrolling Up (Bottom to Top) -->
                    <div class="hidden md:flex flex-col gap-6 animate-marquee-up">
                        
                        <!-- Cards Set 1 -->
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
                            <div class="relative overflow-hidden aspect-[4/3] bg-slate-100">
                                <img src="/images/mockups/ai-analytics.png" alt="AI Analytics Hub" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-4 bg-slate-50/50 border-t border-slate-100 flex flex-col gap-3">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800">AI Analytics Hub</h4>
                                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wide mt-0.5 mb-2">Predictive Forecasting</p>
                                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">Analyze historical workflow data to predict upcoming resource bottlenecks and forecast future revenue growth accurately.</p>
                                </div>
                                <div class="flex flex-wrap gap-1.5">
                                    <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-violet-50 text-violet-600 border border-violet-100/50">Analytics</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-violet-50 text-violet-600 border border-violet-100/50">Forecast</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-violet-50 text-violet-600 border border-violet-100/50">Reports</span>
                                        
                                </div>
                            </div>
                        </div>
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
                            <div class="relative overflow-hidden aspect-[4/3] bg-slate-100">
                                <img src="/images/mockups/finance_ledger.png" alt="Financial Invoicing" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-4 bg-slate-50/50 border-t border-slate-100 flex flex-col gap-3">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800">Financial Invoicing</h4>
                                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wide mt-0.5 mb-2">Ledger & Payments</p>
                                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">Create beautiful, automated invoices for clients based on tracked billable hours and automatically chase late payments.</p>
                                </div>
                                <div class="flex flex-wrap gap-1.5">
                                    <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-amber-50 text-amber-600 border border-amber-100/50">Finance</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-amber-50 text-amber-600 border border-amber-100/50">Invoices</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-amber-50 text-amber-600 border border-amber-100/50">Billing</span>
                                        
                                </div>
                            </div>
                        </div>
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
                            <div class="relative overflow-hidden aspect-[4/3] bg-slate-100">
                                <img src="/images/mockups/mega_menu_solutions.png" alt="Enterprise Solutions" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-4 bg-slate-50/50 border-t border-slate-100 flex flex-col gap-3">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800">Enterprise Solutions</h4>
                                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wide mt-0.5 mb-2">Global Scalability</p>
                                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">Designed to scale with massive teams, offering custom permission hierarchies, single sign-on (SSO), and dedicated support.</p>
                                </div>
                                <div class="flex flex-wrap gap-1.5">
                                    <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-blue-50 text-blue-600 border border-blue-100/50">Enterprise</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-blue-50 text-blue-600 border border-blue-100/50">Scale</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-blue-50 text-blue-600 border border-blue-100/50">SSO</span>
                                        
                                </div>
                            </div>
                        </div>
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
                            <div class="relative overflow-hidden aspect-[4/3] bg-slate-100">
                                <img src="/images/mockups/mega_menu_resources.png" alt="Collaborative Workspaces" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-4 bg-slate-50/50 border-t border-slate-100 flex flex-col gap-3">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800">Collaborative Workspaces</h4>
                                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wide mt-0.5 mb-2">Shared Team Portals</p>
                                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">Foster team collaboration with shared project views, internal chat integrations, and securely isolated client portals.</p>
                                </div>
                                <div class="flex flex-wrap gap-1.5">
                                    <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-teal-50 text-teal-600 border border-teal-100/50">Workspace</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-teal-50 text-teal-600 border border-teal-100/50">Portals</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-teal-50 text-teal-600 border border-teal-100/50">Chat</span>
                                        
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden flex flex-col hover:scale-[1.02] hover:shadow-md hover:border-slate-300/80 transition-all duration-300 select-none">
                            <div class="flex items-center justify-between px-3 py-2 bg-slate-50 border-b border-slate-100 browser-glass-top shrink-0">
                                <div class="flex items-center gap-1.5 w-1/4">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                </div>
                                <div class="bg-white border border-slate-200/50 rounded py-0.5 px-2 text-[9px] text-slate-400 font-mono text-center flex items-center justify-center gap-1 shadow-sm max-w-[150px] truncate">
                                    <svg class="w-2.5 h-2.5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                                    <span class="truncate">timenest.com/crm-sync</span>
                                </div>
                                <div class="w-1/4"></div>
                            </div>
                            <div class="relative overflow-hidden aspect-[4/3] bg-slate-100">
                                <img src="/images/mockups/ai-analytics.png" alt="Client CRM Sync" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-4 bg-slate-50/50 border-t border-slate-100 flex flex-col gap-3">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800">Client CRM Sync</h4>
                                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wide mt-0.5 mb-2">Sales Pipeline Tracking</p>
                                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">Keep your operations aligned with sales by syncing directly with your CRM, bridging the gap between closing and execution.</p>
                                </div>
                                <div class="flex flex-wrap gap-1.5">
                                    <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-rose-50 text-rose-600 border border-rose-100/50">CRM</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-rose-50 text-rose-600 border border-rose-100/50">Sync</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-rose-50 text-rose-600 border border-rose-100/50">Sales</span>
                                        
                                </div>
                            </div>
                        </div>

                        <!-- Cards Set 2 (Duplicated for infinite scroll) -->
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
                            <div class="relative overflow-hidden aspect-[4/3] bg-slate-100">
                                <img src="/images/mockups/ai-analytics.png" alt="AI Analytics Hub" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-4 bg-slate-50/50 border-t border-slate-100 flex flex-col gap-3">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800">AI Analytics Hub</h4>
                                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wide mt-0.5 mb-2">Predictive Forecasting</p>
                                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">Analyze historical workflow data to predict upcoming resource bottlenecks and forecast future revenue growth accurately.</p>
                                </div>
                                <div class="flex flex-wrap gap-1.5">
                                    <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-violet-50 text-violet-600 border border-violet-100/50">Analytics</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-violet-50 text-violet-600 border border-violet-100/50">Forecast</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-violet-50 text-violet-600 border border-violet-100/50">Reports</span>
                                        
                                </div>
                            </div>
                        </div>
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
                            <div class="relative overflow-hidden aspect-[4/3] bg-slate-100">
                                <img src="/images/mockups/finance_ledger.png" alt="Financial Invoicing" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-4 bg-slate-50/50 border-t border-slate-100 flex flex-col gap-3">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800">Financial Invoicing</h4>
                                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wide mt-0.5 mb-2">Ledger & Payments</p>
                                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">Create beautiful, automated invoices for clients based on tracked billable hours and automatically chase late payments.</p>
                                </div>
                                <div class="flex flex-wrap gap-1.5">
                                    <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-amber-50 text-amber-600 border border-amber-100/50">Finance</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-amber-50 text-amber-600 border border-amber-100/50">Invoices</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-amber-50 text-amber-600 border border-amber-100/50">Billing</span>
                                        
                                </div>
                            </div>
                        </div>
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
                            <div class="relative overflow-hidden aspect-[4/3] bg-slate-100">
                                <img src="/images/mockups/mega_menu_solutions.png" alt="Enterprise Solutions" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-4 bg-slate-50/50 border-t border-slate-100 flex flex-col gap-3">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800">Enterprise Solutions</h4>
                                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wide mt-0.5 mb-2">Global Scalability</p>
                                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">Designed to scale with massive teams, offering custom permission hierarchies, single sign-on (SSO), and dedicated support.</p>
                                </div>
                                <div class="flex flex-wrap gap-1.5">
                                    <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-blue-50 text-blue-600 border border-blue-100/50">Enterprise</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-blue-50 text-blue-600 border border-blue-100/50">Scale</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-blue-50 text-blue-600 border border-blue-100/50">SSO</span>
                                        
                                </div>
                            </div>
                        </div>
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
                            <div class="relative overflow-hidden aspect-[4/3] bg-slate-100">
                                <img src="/images/mockups/mega_menu_resources.png" alt="Collaborative Workspaces" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-4 bg-slate-50/50 border-t border-slate-100 flex flex-col gap-3">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800">Collaborative Workspaces</h4>
                                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wide mt-0.5 mb-2">Shared Team Portals</p>
                                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">Foster team collaboration with shared project views, internal chat integrations, and securely isolated client portals.</p>
                                </div>
                                <div class="flex flex-wrap gap-1.5">
                                    <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-teal-50 text-teal-600 border border-teal-100/50">Workspace</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-teal-50 text-teal-600 border border-teal-100/50">Portals</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-teal-50 text-teal-600 border border-teal-100/50">Chat</span>
                                        
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl border border-slate-200/60 shadow-sm overflow-hidden flex flex-col hover:scale-[1.02] hover:shadow-md hover:border-slate-300/80 transition-all duration-300 select-none">
                            <div class="flex items-center justify-between px-3 py-2 bg-slate-50 border-b border-slate-100 browser-glass-top shrink-0">
                                <div class="flex items-center gap-1.5 w-1/4">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                </div>
                                <div class="bg-white border border-slate-200/50 rounded py-0.5 px-2 text-[9px] text-slate-400 font-mono text-center flex items-center justify-center gap-1 shadow-sm max-w-[150px] truncate">
                                    <svg class="w-2.5 h-2.5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                                    <span class="truncate">timenest.com/crm-sync</span>
                                </div>
                                <div class="w-1/4"></div>
                            </div>
                            <div class="relative overflow-hidden aspect-[4/3] bg-slate-100">
                                <img src="/images/mockups/ai-analytics.png" alt="Client CRM Sync" class="w-full h-full object-cover object-top">
                                <div class="absolute inset-0 browser-sheen pointer-events-none"></div>
                            </div>
                            <div class="px-4 py-4 bg-slate-50/50 border-t border-slate-100 flex flex-col gap-3">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800">Client CRM Sync</h4>
                                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wide mt-0.5 mb-2">Sales Pipeline Tracking</p>
                                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">Keep your operations aligned with sales by syncing directly with your CRM, bridging the gap between closing and execution.</p>
                                </div>
                                <div class="flex flex-wrap gap-1.5">
                                    <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-rose-50 text-rose-600 border border-rose-100/50">CRM</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-rose-50 text-rose-600 border border-rose-100/50">Sync</span>
                                        <span class="text-[9px] font-semibold px-2 py-0.5 rounded bg-rose-50 text-rose-600 border border-rose-100/50">Sales</span>
                                        
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>

    {{-- Section 4: Role-Based Problem Statement --}}
    <section class="py-12 sm:py-16 lg:py-20 bg-white" x-data="{ activeTab: 'founders' }">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="font-display text-3xl lg:text-4xl font-bold text-content-strong mb-4">Built for everyone who runs work</h2>
                <p class="text-content-muted text-lg">Whether you're a founder scaling a company or a freelancer managing clients, TimeNest adapts to your specific workflow.</p>
            </div>

            <div class="flex overflow-x-auto flex-nowrap md:flex-wrap justify-start md:justify-center gap-2.5 mb-12 pb-2 scrollbar-hide">
                @foreach([
                    'founders' => ['Founders', 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6'], 
                    'hr' => ['HR Teams', 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'], 
                    'operations' => ['Operations', 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z'], 
                    'finance' => ['Finance Teams', 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z'],
                    'leads' => ['Team Leads', 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z'],
                    'projects' => ['Project Managers', 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01'],
                    'freelancers' => ['Freelancers', 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'], 
                    'agencies' => ['Agencies', 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                    'enterprise' => ['Enterprise Teams', 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                    'ai' => ['AI-Powered Teams', 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z']
                ] as $key => [$label, $icon])
                    <button @click="activeTab = '{{ $key }}'" :class="activeTab === '{{ $key }}' ? 'bg-brand-500 text-white shadow-md shadow-brand-500/20' : 'bg-white border border-surface-border text-content-muted hover:text-content-strong hover:bg-surface-50'" class="px-5 py-3 rounded-xl text-sm font-body font-medium transition-all cursor-pointer flex items-center gap-2 whitespace-nowrap shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/></svg>
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            <div class="relative rounded-2xl border border-surface-border bg-white shadow-xl shadow-surface-border/30 overflow-hidden min-h-[640px] lg:min-h-[500px]">
                @php
                    $roleData = [
                        'founders' => [
                            'color' => 'indigo',
                            'pain' => 'Juggling 5+ tools for HR, attendance, leaves, and payroll. No unified view of workforce health and ballooning software costs.',
                            'solution' => 'One platform to manage your entire workforce. Real-time executive dashboards, AI-powered insights, and automated workflows.'
                        ],
                        'hr' => [
                            'color' => 'emerald',
                            'pain' => 'Manual attendance tracking via spreadsheets, leave conflicts, shift scheduling nightmares, and scary compliance gaps.',
                            'solution' => 'Automated attendance, smart leave management, visual shift builder, and AI fraud detection to keep everything honest.'
                        ],
                        'operations' => [
                            'color' => 'blue',
                            'pain' => 'Department silos, broken manual approval chains via email, and zero visibility into team performance or resource allocation.',
                            'solution' => 'Centralized department and team management. Custom workflows, role-based granular permissions, and operational analytics.'
                        ],
                        'finance' => [
                            'color' => 'amber',
                            'pain' => 'Slow payroll runs, manual expense validation, fragmented invoice processing, and zero automated forecasting.',
                            'solution' => 'Complete automated financial operations. Instant payroll runs, real-time expense approvals, and auto-matching invoices.'
                        ],
                        'leads' => [
                            'color' => 'violet',
                            'pain' => 'Overloaded team members, hidden burnout, untracked hours, and chaotic shift handovers.',
                            'solution' => 'Direct visibility into workload capacity, sprint velocity tracking, and automatic capacity distribution.'
                        ],
                        'projects' => [
                            'color' => 'cyan',
                            'pain' => 'Missing project milestones, delayed deliverables, untracked time logs, and manually created progress reports.',
                            'solution' => 'Centralized boards, automatic timeline mapping, live developer time-logs, and instant milestone statuses.'
                        ],
                        'freelancers' => [
                            'color' => 'teal',
                            'pain' => 'Scattered client data, manual invoicing processes, no accurate revenue tracking, and zero business intelligence.',
                            'solution' => 'All-in-one freelancer platform. CRM, invoicing, task management, and AI revenue forecasting — core features forever free.'
                        ],
                        'agencies' => [
                            'color' => 'fuchsia',
                            'pain' => 'Managing a freelance team without proper tools. No shared projects, no unified invoicing, and no team utilization analytics.',
                            'solution' => 'Freelance Workspace — a collaborative environment for agencies. Shared projects, shared invoicing, and team analytics.'
                        ],
                        'enterprise' => [
                            'color' => 'slate',
                            'pain' => 'Regulatory compliance audit anxiety, lack of fine-grained roles, no activity trails, and compromised security logs.',
                            'solution' => 'Full enterprise governance, comprehensive automated audit trail logs, granular permission matrices, and security analytics.'
                        ],
                        'ai' => [
                            'color' => 'rose',
                            'pain' => 'Unprocessed operational data, manual schedule creation, slow support resolution, and missed financial trends.',
                            'solution' => 'Autonomous workforce copilot. Real-time predictive anomaly alerts, automated shift planning, and direct productivity insights.'
                        ]
                    ];

                    $colorMaps = [
                        'indigo' => [
                            'bg' => 'bg-indigo-50 border-indigo-100',
                            'border_l' => 'border-l-indigo-500', 
                            'text' => 'text-indigo-600',
                            'from' => 'from-indigo-500/[0.015]',
                            'hover' => 'hover:bg-indigo-500/[0.03] hover:border-indigo-100/40'
                        ],
                        'emerald' => [
                            'bg' => 'bg-emerald-50 border-emerald-100',
                            'border_l' => 'border-l-emerald-500', 
                            'text' => 'text-emerald-600',
                            'from' => 'from-emerald-500/[0.015]',
                            'hover' => 'hover:bg-emerald-500/[0.03] hover:border-emerald-100/40'
                        ],
                        'blue' => [
                            'bg' => 'bg-blue-50 border-blue-100',
                            'border_l' => 'border-l-blue-500', 
                            'text' => 'text-blue-600',
                            'from' => 'from-blue-500/[0.015]',
                            'hover' => 'hover:bg-blue-500/[0.03] hover:border-blue-100/40'
                        ],
                        'amber' => [
                            'bg' => 'bg-amber-50 border-amber-100',
                            'border_l' => 'border-l-amber-500', 
                            'text' => 'text-amber-600',
                            'from' => 'from-amber-500/[0.015]',
                            'hover' => 'hover:bg-amber-500/[0.03] hover:border-amber-100/40'
                        ],
                        'violet' => [
                            'bg' => 'bg-violet-50 border-violet-100',
                            'border_l' => 'border-l-violet-500', 
                            'text' => 'text-violet-600',
                            'from' => 'from-violet-500/[0.015]',
                            'hover' => 'hover:bg-violet-500/[0.03] hover:border-violet-100/40'
                        ],
                        'cyan' => [
                            'bg' => 'bg-cyan-50 border-cyan-100',
                            'border_l' => 'border-l-cyan-500', 
                            'text' => 'text-cyan-600',
                            'from' => 'from-cyan-500/[0.015]',
                            'hover' => 'hover:bg-cyan-500/[0.03] hover:border-cyan-100/40'
                        ],
                        'teal' => [
                            'bg' => 'bg-teal-50 border-teal-100',
                            'border_l' => 'border-l-teal-500', 
                            'text' => 'text-teal-600',
                            'from' => 'from-teal-500/[0.015]',
                            'hover' => 'hover:bg-teal-500/[0.03] hover:border-teal-100/40'
                        ],
                        'fuchsia' => [
                            'bg' => 'bg-fuchsia-50 border-fuchsia-100',
                            'border_l' => 'border-l-fuchsia-500', 
                            'text' => 'text-fuchsia-600',
                            'from' => 'from-fuchsia-500/[0.015]',
                            'hover' => 'hover:bg-fuchsia-500/[0.03] hover:border-fuchsia-100/40'
                        ],
                        'slate' => [
                            'bg' => 'bg-slate-50 border-slate-200',
                            'border_l' => 'border-l-slate-500', 
                            'text' => 'text-slate-600',
                            'from' => 'from-slate-500/[0.015]',
                            'hover' => 'hover:bg-slate-500/[0.03] hover:border-slate-200/40'
                        ],
                        'rose' => [
                            'bg' => 'bg-rose-50 border-rose-100',
                            'border_l' => 'border-l-rose-500', 
                            'text' => 'text-rose-600',
                            'from' => 'from-rose-500/[0.015]',
                            'hover' => 'hover:bg-rose-500/[0.03] hover:border-rose-100/40'
                        ],
                    ];
                @endphp

                @foreach($roleData as $key => $data)
                    <div x-show="activeTab === '{{ $key }}'" 
                         x-transition:enter="transition ease-out duration-355 delay-150" 
                         x-transition:enter-start="opacity-0 scale-98 translate-y-2" 
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0" 
                         x-transition:leave="transition ease-in duration-150 absolute inset-0 w-full h-full p-6 sm:p-8 lg:p-12" 
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0" 
                         x-transition:leave-end="opacity-0 scale-98 translate-y-2" 
                         x-cloak 
                         class="p-6 sm:p-8 lg:p-12"
                    >
                        <div class="grid lg:grid-cols-12 gap-12 items-center">
                            
                            <!-- Left: Pain & Solution -->
                            <div class="lg:col-span-5 space-y-6">
                                <!-- The Pain Block -->
                                <div class="border-l-3 border-red-500/60 bg-gradient-to-r from-red-500/[0.015] to-transparent p-5 rounded-r-2xl border border-transparent transition-all duration-300 hover:bg-red-500/[0.03] hover:border-red-100/40">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center border border-red-100">
                                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        </div>
                                        <h3 class="font-display text-base font-bold text-slate-800 tracking-tight">The Pain</h3>
                                    </div>
                                    <p class="text-content-muted text-[13px] leading-relaxed">{{ $data['pain'] }}</p>
                                </div>
                                
                                <!-- The Solution Block -->
                                <div class="border-l-3 {{ $colorMaps[$data['color']]['border_l'] }}/60 bg-gradient-to-r {{ $colorMaps[$data['color']]['from'] }} to-transparent p-5 rounded-r-2xl border border-transparent transition-all duration-300 {{ $colorMaps[$data['color']]['hover'] }}">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="w-8 h-8 rounded-lg {{ $colorMaps[$data['color']]['bg'] }} flex items-center justify-center border">
                                            <svg class="w-4 h-4 {{ $colorMaps[$data['color']]['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                        <h3 class="font-display text-base font-bold text-slate-800 tracking-tight">TimeNest Solution</h3>
                                    </div>
                                    <p class="text-content-muted text-[13px] leading-relaxed">{{ $data['solution'] }}</p>
                                </div>
                            </div>

                            <!-- Right: Replicas Showcase (Operational Cards) -->
                            <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @if($key === 'founders')
                                    @include('frontend.partials.widgets.cashflow')
                                    @include('frontend.partials.widgets.analytics')
                                    @include('frontend.partials.widgets.ai-revenue-forecast')
                                    @include('frontend.partials.widgets.workforce-summary')
                                @elseif($key === 'hr')
                                    @include('frontend.partials.widgets.attendance')
                                    @include('frontend.partials.widgets.leave-requests')
                                    @include('frontend.partials.widgets.shift-schedule')
                                    @include('frontend.partials.widgets.employee-directory')
                                @elseif($key === 'operations')
                                    @include('frontend.partials.widgets.approval-workflow')
                                    @include('frontend.partials.widgets.projects')
                                    @include('frontend.partials.widgets.tasks')
                                    @include('frontend.partials.widgets.department-structure')
                                @elseif($key === 'finance')
                                    @include('frontend.partials.widgets.payroll')
                                    @include('frontend.partials.widgets.expense-tracking')
                                    @include('frontend.partials.widgets.freelancer-invoice')
                                    @include('frontend.partials.widgets.client-revenue')
                                @elseif($key === 'leads')
                                    @include('frontend.partials.widgets.team-capacity')
                                    @include('frontend.partials.widgets.sprint-tracking')
                                    @include('frontend.partials.widgets.team-status')
                                    @include('frontend.partials.widgets.productivity-metrics')
                                @elseif($key === 'projects')
                                    @include('frontend.partials.widgets.kanban-board')
                                    @include('frontend.partials.widgets.milestone-tracker')
                                    @include('frontend.partials.widgets.projects')
                                    @include('frontend.partials.widgets.timelogs')
                                @elseif($key === 'freelancers')
                                    @include('frontend.partials.widgets.freelancer-invoice')
                                    @include('frontend.partials.widgets.clients')
                                    @include('frontend.partials.widgets.tasks')
                                    @include('frontend.partials.widgets.ai-revenue-forecast')
                                @elseif($key === 'agencies')
                                    @include('frontend.partials.widgets.workspace-hub')
                                    @include('frontend.partials.widgets.projects')
                                    @include('frontend.partials.widgets.freelancer-invoice')
                                    @include('frontend.partials.widgets.team-status')
                                @elseif($key === 'enterprise')
                                    @include('frontend.partials.widgets.audit-trail')
                                    @include('frontend.partials.widgets.role-matrix')
                                    @include('frontend.partials.widgets.compliance-tracker')
                                    @include('frontend.partials.widgets.asset-tracking')
                                @elseif($key === 'ai')
                                    @include('frontend.partials.widgets.ai-copilot')
                                    @include('frontend.partials.widgets.ai-insights')
                                    @include('frontend.partials.widgets.ai-revenue-forecast')
                                    @include('frontend.partials.widgets.workforce-heatmap')
                                @endif
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Section 3: Deep Dive Features --}}
    <section class="py-12 sm:py-16 lg:py-20 bg-surface-50 border-y border-surface-border overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-10 lg:gap-16 items-center">
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
                
                <div class="relative mt-8 lg:mt-0">
                    <div class="absolute inset-0 bg-gradient-to-tr from-brand-500/20 to-indigo-500/20 rounded-[2rem] sm:rounded-[2.5rem] transform rotate-1 sm:rotate-3 scale-102 sm:scale-105"></div>
                    <div class="relative bg-white rounded-2xl shadow-xl shadow-surface-border/50 border border-surface-border p-2">
                        <img src="/images/mockups/ai-analytics.png" alt="AI Analytics Dashboard" class="w-full rounded-xl border border-surface-border/50">
                        
                        {{-- Floating Element --}}
                        <div class="absolute -bottom-4 left-4 sm:-bottom-6 sm:-left-6 bg-white p-3.5 sm:p-4 rounded-xl shadow-lg border border-surface-border flex items-center gap-3 sm:gap-4 animate-slide-up" style="animation-delay: 500ms;">
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
        <div class="mt-12 sm:mt-16 lg:mt-20 px-0">
            <x-frontend-sections.carousel :slides="[
                ['title' => 'Real-time AI Analytics', 'description' => 'Instantly detect anomalies in attendance data, forecast revenue, and monitor productivity trends — all without running a single manual report. TimeNest AI continuously scans your data streams and surfaces actionable insights directly in your dashboard, so you can act on problems before they escalate.', 'badge' => 'TimeNest AI', 'image' => '/images/mockups/ai-analytics.png', 'url' => route('frontend.ai'), 'tags' => ['Anomaly Detection', 'Revenue Forecast', 'Trend Analysis', 'Predictive Alerts']],
                ['title' => 'Smart Shift Builder', 'description' => 'Drag-and-drop shift scheduling with automated conflict resolution, fatigue-rule checks, and labor law compliance baked in. TimeNest cross-references employee availability, skill matrices, and overtime limits to build optimal rosters in seconds — saving your HR team hours every week.', 'badge' => 'Workforce Core', 'image' => '/images/mockups/hero-dashboard.png', 'url' => '#', 'tags' => ['Drag & Drop', 'Auto-Conflict Resolution', 'Overtime Guards', 'Skill Matching']],
                ['title' => 'Collaborative Workspaces', 'description' => 'Share projects, manage freelance teams, and consolidate invoicing into one unified platform designed for creative agencies. Assign collaborators, track deliverables across milestones, and generate unified client billing — all from a single workspace without juggling multiple tools.', 'badge' => 'Agencies', 'image' => '/images/mockups/compliance_audit.png', 'url' => '#', 'tags' => ['Shared Projects', 'Freelancer Billing', 'Client Portal', 'Team Analytics']],
                ['title' => 'Automated Payroll Engine', 'description' => 'Calculate salaries, deductions, bonuses, and tax withholdings automatically based on tracked attendance hours and approved overtime. TimeNest generates payslips, handles multi-currency disbursement for international teams, and keeps a complete audit trail for every pay cycle.', 'badge' => 'Finance Suite', 'image' => '/images/mockups/finance_ledger.png', 'url' => '#', 'tags' => ['Auto Payslips', 'Tax Calculations', 'Multi-Currency', 'Audit Trail']],
                ['title' => 'Enterprise Compliance Hub', 'description' => 'Stay ahead of regulatory requirements with automated compliance monitoring, immutable audit logs, and SOC2-ready security controls. TimeNest tracks every system action, enforces role-based access policies, and generates compliance reports on demand — giving your security team peace of mind.', 'badge' => 'Enterprise', 'image' => '/images/mockups/workforce_scheduler.png', 'url' => '#', 'tags' => ['SOC2 Ready', 'Immutable Logs', 'RBAC Policies', 'Auto Reports']],
            ]" />
        </div>
    </section>

    {{-- Section 4: Product Lines Cards --}}
    <section class="py-12 sm:py-16 lg:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14 lg:mb-16">
                <x-frontend-base.badge variant="primary" class="mb-4">Platform Products</x-frontend-base.badge>
                <h2 class="font-display text-3xl lg:text-4xl font-bold text-content-strong mb-4">Three products, one platform</h2>
                <p class="text-content-muted text-lg">TimeNest isn't one tool — it's three powerful operating systems unified under a single platform. Choose the product that fits your workflow, and scale seamlessly without ever migrating data.</p>
            </div>
            
            @php
                $products = [
                    [
                        'title' => 'For Organizations',
                        'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                        'desc' => 'Complete workforce and operations management for companies of any size. Unify HR, attendance, shifts, approvals, and departmental workflows into a single real-time operating system.',
                        'audience' => ['Startups', 'SMBs', 'Enterprises', 'Distributed Teams'],
                        'stats' => [['label' => 'Employees', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z'], ['label' => 'Attendance', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'], ['label' => 'Approvals', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z']],
                        'features' => ['Employee Directory & Profiles', 'Attendance Tracking & GPS', 'Leave Management', 'Shift Scheduling & Rostering', 'Departments & Teams', 'Roles & Permissions', 'Multi-Level Approvals', 'Workforce Analytics', 'Audit Logs', 'Compliance Monitoring'],
                        'bestFor' => 'Managing Employees',
                        'basis' => 'Employee-Based',
                        'cta' => 'Book Organization Demo',
                        'url' => route('frontend.book-demo'),
                        'color' => 'brand',
                        'widgetType' => 'org',
                    ],
                    [
                        'title' => 'For Freelancers',
                        'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                        'desc' => 'Everything a solo freelancer needs to manage clients, revenue, and projects from one dashboard. Run your entire freelance business — CRM, invoicing, tasks, and AI forecasting — forever free.',
                        'audience' => ['Solo Freelancers', 'Consultants', 'Creators', 'Independent Professionals'],
                        'stats' => [['label' => 'Clients', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'], ['label' => 'Invoices', 'icon' => 'M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z'], ['label' => 'Projects', 'icon' => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2z']],
                        'features' => ['Client CRM & Lead Tracking', 'Professional Invoicing', 'Quotations & Proposals', 'Revenue Analytics', 'Project Management', 'Task Tracking & Kanban', 'Document Management', 'Payment Tracking', 'AI Revenue Forecasting', 'Time Logging'],
                        'bestFor' => 'Running Your Solo Business',
                        'basis' => 'Individual-Based',
                        'cta' => 'Start Freelancing Free',
                        'url' => '/register',
                        'color' => 'indigo',
                        'widgetType' => 'freelancer',
                    ],
                    [
                        'title' => 'Freelance Workspace',
                        'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
                        'desc' => 'A collaborative workspace for freelance teams, agencies, and studios. Share projects, consolidate invoicing, and track team utilization — without corporate overhead.',
                        'audience' => ['Agencies', 'Studios', 'Consulting Teams', 'Collaborative Freelance Groups'],
                        'stats' => [['label' => 'Collaborators', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z'], ['label' => 'Projects', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'], ['label' => 'Reporting', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z']],
                        'features' => ['Collaborator Management', 'Shared Projects & Files', 'Shared Client Billing', 'Workspace Analytics', 'Team Utilization Tracking', 'Revenue Visibility', 'Collaborative Reporting', 'Shared Task Management', 'Agency Workflows', 'Shared Documents'],
                        'bestFor' => 'Managing Collaborative Freelance Teams',
                        'basis' => 'Collaborator-Based',
                        'cta' => 'Launch Your Workspace',
                        'url' => route('frontend.pricing'),
                        'color' => 'amber',
                        'pro' => true,
                        'widgetType' => 'workspace',
                    ],
                ];
            @endphp

            <div class="grid md:grid-cols-3 gap-6 lg:gap-8">
                @foreach($products as $product)
                    <div class="group rounded-2xl border border-surface-border bg-white p-6 sm:p-8 lg:p-9 hover:border-{{ $product['color'] }}-300 hover:shadow-2xl hover:shadow-{{ $product['color'] }}-500/10 hover:-translate-y-1 transition-all duration-400 flex flex-col relative overflow-hidden">
                        
                        {{-- Background glow on hover --}}
                        <div class="absolute inset-0 bg-gradient-to-br from-{{ $product['color'] }}-50/0 via-transparent to-{{ $product['color'] }}-50/0 group-hover:from-{{ $product['color'] }}-50/40 group-hover:to-{{ $product['color'] }}-50/20 transition-all duration-500 pointer-events-none"></div>
                        
                        {{-- Ghost icon --}}
                        <div class="absolute top-0 right-0 p-8 opacity-[0.03] group-hover:opacity-[0.08] transition-opacity duration-500">
                            <svg class="w-32 h-32 text-{{ $product['color'] }}-600 -mr-10 -mt-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="{{ $product['icon'] }}"/></svg>
                        </div>
                        
                        {{-- Icon container with hover animation --}}
                        <div class="w-14 h-14 rounded-xl bg-{{ $product['color'] }}-50 flex items-center justify-center mb-5 text-{{ $product['color'] }}-600 border border-{{ $product['color'] }}-100 relative z-10 group-hover:bg-{{ $product['color'] }}-500 group-hover:text-white group-hover:border-{{ $product['color'] }}-500 group-hover:shadow-lg group-hover:shadow-{{ $product['color'] }}-500/25 transition-all duration-300">
                            <svg class="w-6 h-6 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $product['icon'] }}"/></svg>
                        </div>
                        
                        {{-- Title --}}
                        <h3 class="font-display text-2xl font-bold text-content-strong mb-2 relative z-10">{{ $product['title'] }}</h3>
                        
                        {{-- Audience tag --}}
                        <div class="flex items-center gap-1.5 mb-4 relative z-10">
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Ideal For:</span>
                            <span class="text-[10px] font-medium text-slate-500">{{ implode(' • ', $product['audience']) }}</span>
                        </div>
                        
                        @if(isset($product['pro']))

                        @endif
                        
                        {{-- Description --}}
                        <p class="text-content-muted text-sm leading-relaxed mb-5 relative z-10">{{ $product['desc'] }}</p>
                        
                        {{-- Stats micro-badges row --}}
                        <div class="flex items-center gap-2 mb-6 relative z-10">
                            @foreach($product['stats'] as $stat)
                                <div class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg bg-slate-50 border border-slate-100 group-hover:bg-{{ $product['color'] }}-50/50 group-hover:border-{{ $product['color'] }}-100/50 transition-colors duration-300">
                                    <svg class="w-3.5 h-3.5 text-{{ $product['color'] }}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/></svg>
                                    <span class="text-[10px] font-semibold text-slate-600">{{ $stat['label'] }}</span>
                                </div>
                            @endforeach
                        </div>

                        {{-- Mini Dashboard Preview Widget --}}
                        <div class="relative z-10 mb-6 rounded-xl border border-slate-200/60 bg-gradient-to-br from-slate-50 to-white p-3 overflow-hidden">
                            @if($product['widgetType'] === 'org')
                                {{-- Organization: Attendance mini-widget --}}
                                <div x-data="{ present: 47, total: 52, rate: 90.4 }" x-init="setInterval(() => { present = present === 47 ? 50 : present === 50 ? 52 : 47; rate = Math.round(present/total*1000)/10; }, 3000)">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Today's Attendance</span>
                                        <span class="text-[8px] font-bold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200 flex items-center gap-0.5 animate-pulse">
                                            <span class="w-1 h-1 rounded-full bg-emerald-500"></span> Live
                                        </span>
                                    </div>
                                    <div class="flex items-end justify-between">
                                        <div>
                                            <span class="text-lg font-bold text-slate-800 transition-all duration-500" x-text="present + '/' + total"></span>
                                            <span class="text-[9px] text-slate-400 ml-1">employees</span>
                                        </div>
                                        <span class="text-xs font-bold transition-all duration-500" :class="rate > 95 ? 'text-emerald-600' : 'text-amber-600'" x-text="rate + '%'"></span>
                                    </div>
                                    <div class="w-full h-1.5 bg-slate-100 rounded-full mt-2 overflow-hidden">
                                        <div class="h-full rounded-full transition-all duration-700 ease-out" :class="rate > 95 ? 'bg-emerald-500' : 'bg-amber-500'" :style="'width: ' + rate + '%'"></div>
                                    </div>
                                </div>
                            @elseif($product['widgetType'] === 'freelancer')
                                {{-- Freelancer: Revenue mini-widget --}}
                                <div x-data="{ revenue: 284500, invoices: 12, paid: 9 }" x-init="setInterval(() => { revenue += Math.floor(Math.random() * 15000); paid = Math.min(paid + 1, invoices); }, 4000)">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Revenue This Month</span>
                                        <span class="text-[8px] font-bold text-indigo-600 bg-indigo-50 px-1.5 py-0.5 rounded border border-indigo-200">Tracking</span>
                                    </div>
                                    <div class="flex items-end justify-between">
                                        <div>
                                            <span class="text-lg font-bold text-slate-800 transition-all duration-500" x-text="'₹' + revenue.toLocaleString()"></span>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-[9px] text-slate-400 block" x-text="paid + '/' + invoices + ' paid'"></span>
                                        </div>
                                    </div>
                                    <div class="flex gap-1 mt-2">
                                        <template x-for="i in invoices">
                                            <div class="flex-1 h-1.5 rounded-full transition-all duration-500" :class="i <= paid ? 'bg-indigo-500' : 'bg-slate-100'"></div>
                                        </template>
                                    </div>
                                </div>
                            @elseif($product['widgetType'] === 'workspace')
                                {{-- Workspace: Team utilization mini-widget --}}
                                <div x-data="{ members: [{n:'Sarah K.', u:92}, {n:'James L.', u:78}, {n:'Maria R.', u:85}] }">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Team Utilization</span>
                                        <span class="text-[8px] font-bold text-amber-600 bg-amber-50 px-1.5 py-0.5 rounded border border-amber-200">3 Active</span>
                                    </div>
                                    <div class="space-y-1.5">
                                        <template x-for="m in members" :key="m.n">
                                            <div class="flex items-center gap-2">
                                                <span class="text-[9px] font-medium text-slate-600 w-14 truncate" x-text="m.n"></span>
                                                <div class="flex-1 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                                    <div class="h-full bg-amber-500 rounded-full transition-all duration-700" :style="'width: ' + m.u + '%'"></div>
                                                </div>
                                                <span class="text-[9px] font-bold text-slate-500 w-7 text-right" x-text="m.u + '%'"></span>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        {{-- Differentiation block --}}
                        <div class="relative z-10 mb-6 flex items-center gap-3 px-3.5 py-2.5 rounded-lg bg-{{ $product['color'] }}-50/60 border border-{{ $product['color'] }}-100/60">
                            <svg class="w-4 h-4 text-{{ $product['color'] }}-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            <div>
                                <span class="text-[9px] font-bold text-{{ $product['color'] }}-500 uppercase tracking-widest">Best For</span>
                                <p class="text-xs font-bold text-{{ $product['color'] }}-800 leading-tight">{{ $product['bestFor'] }}</p>
                            </div>
                        </div>
                        
                        {{-- Feature list --}}
                        <div class="mb-8 flex-1 relative z-10">
                            <h4 class="text-[10px] font-semibold text-content-strong uppercase tracking-widest mb-3">Platform Features</h4>
                            <ul class="grid grid-cols-1 gap-2">
                                @foreach($product['features'] as $f)
                                    <li class="flex items-center gap-2 text-[13px] text-content-muted">
                                        <svg class="w-4 h-4 text-{{ $product['color'] }}-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        {{ $f }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        
                        {{-- CTA Button --}}
                        <x-frontend-base.button :href="$product['url']" variant="outline" class="w-full relative z-10 bg-white border-surface-border hover:bg-{{ $product['color'] }}-50 hover:text-{{ $product['color'] }}-700 hover:border-{{ $product['color'] }}-200 transition-all duration-300">{{ $product['cta'] }}</x-frontend-base.button>
                        
                        {{-- Product comparison indicator --}}
                        <div class="relative z-10 mt-4 pt-4 border-t border-slate-100 flex items-center justify-center gap-2">
                            <svg class="w-3.5 h-3.5 text-{{ $product['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $product['icon'] }}"/></svg>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $product['basis'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Section 5: AI Platform (Refined) --}}
    <section class="py-16 sm:py-24 lg:py-32 bg-slate-950 relative overflow-hidden text-white border-y border-white/5">
        
        <!-- Ambient Deep Background Layering -->
        <div class="absolute inset-0 bg-slate-950 pointer-events-none">
            <!-- Core Deep Gradients -->
            <div class="absolute top-0 right-0 w-[1000px] h-[800px] bg-brand-600/10 rounded-full blur-[120px] translate-x-1/3 -translate-y-1/4"></div>
            <div class="absolute bottom-0 left-0 w-[800px] h-[600px] bg-indigo-600/10 rounded-full blur-[100px] -translate-x-1/3 translate-y-1/4"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-emerald-500/5 rounded-full blur-[120px] mix-blend-screen"></div>
            
            <!-- AI Data Visualization SVG Pattern (Very Low Opacity) -->
            <div class="absolute inset-0 opacity-[0.03] bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNMCAwaDQwdjQwSDBWMHptMjAgMjBjNS41MjMgMCAxMC00LjQ3NyAxMC0xMFMzMS41MjMgMCAyNiAwSDB2MjZoMjZ6IiBmaWxsPSIjZmZmZmZmIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiLz48L3N2Zz4=')] mix-blend-overlay"></div>
        </div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8">
            <!-- Grid container: stacks vertically on mobile/tablet, side-by-side on lg -->
            <div class="grid lg:grid-cols-[1fr_400px] xl:grid-cols-[1fr_480px] gap-12 lg:gap-16 items-start">
                
                <!-- LEFT CONTENT AREA -->
                <div class="flex flex-col gap-12">
                    
                    <!-- Header Group -->
                    <div>
                        <!-- Rebuilt Announcement Pill -->
                        <div class="inline-flex items-center gap-2.5 px-3 py-1.5 rounded-full bg-white/5 border border-brand-500/30 backdrop-blur-md mb-6 shadow-[0_0_15px_rgba(14,165,233,0.15)]">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-500"></span>
                            </span>
                            <span class="text-xs font-bold text-white tracking-wide uppercase">TimeNest AI</span>
                        </div>
                        
                        <h2 class="font-display text-4xl lg:text-5xl xl:text-6xl font-bold text-white mb-6 leading-[1.1] tracking-tight">
                            Intelligence embedded into <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-300 to-indigo-300">every workflow.</span>
                        </h2>
                        <p class="text-lg lg:text-xl text-slate-300/80 mb-8 leading-relaxed max-w-2xl font-body">
                            We didn't just bolt on a chatbot. TimeNest AI monitors your operations in the background, surfacing insights, detecting anomalies, and automating routine tasks before you even ask.
                        </p>
                    </div>
                    
                    <!-- AI Capabilities Grid (Rich Cards) -->
                    <div class="grid sm:grid-cols-2 gap-5">
                        
                        <!-- Card 1: Workforce Analyst -->
                        <div class="bg-white/[0.03] border border-white/10 rounded-2xl p-6 hover:bg-white/[0.06] hover:border-brand-500/50 hover:shadow-[0_0_30px_rgba(14,165,233,0.15)] transition-all duration-300 group relative overflow-hidden flex flex-col justify-between h-full">
                            <div class="absolute inset-0 bg-gradient-to-b from-brand-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                            
                            <div class="relative z-10 mb-6">
                                <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300 border border-white/5">
                                    <svg class="w-5 h-5 text-brand-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                </div>
                                <h3 class="font-display font-semibold text-white mb-2 text-lg">Workforce Analyst</h3>
                                <p class="text-slate-400 text-sm leading-relaxed">Detects attendance anomalies, leave abuse patterns, and overtime burnout risks.</p>
                            </div>
                                
                            <!-- Mini UI Element -->
                            <div class="relative z-10 bg-black/30 rounded-lg p-3 border border-white/5 flex flex-col gap-2 mt-auto">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] text-slate-400 uppercase font-bold">Burnout Risk</span>
                                    <span class="text-[10px] text-rose-400 font-bold bg-rose-500/10 px-1.5 py-0.5 rounded border border-rose-500/20">High (15% OT)</span>
                                </div>
                                <div class="w-full h-1 bg-slate-800 rounded-full overflow-hidden">
                                    <div class="w-[85%] h-full bg-rose-500 rounded-full relative overflow-hidden">
                                        <div class="absolute inset-0 bg-white/20 animate-pulse"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card 2: Fraud Detection -->
                        <div class="bg-white/[0.03] border border-white/10 rounded-2xl p-6 hover:bg-white/[0.06] hover:border-rose-500/50 hover:shadow-[0_0_30px_rgba(244,63,94,0.15)] transition-all duration-300 group relative overflow-hidden flex flex-col justify-between h-full">
                            <div class="absolute inset-0 bg-gradient-to-b from-rose-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                            
                            <div class="relative z-10 mb-6">
                                <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300 border border-white/5">
                                    <svg class="w-5 h-5 text-rose-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </div>
                                <h3 class="font-display font-semibold text-white mb-2 text-lg">Fraud Detection</h3>
                                <p class="text-slate-400 text-sm leading-relaxed">Identifies location spoofing, buddy punching, and suspicious reimbursement claims.</p>
                            </div>
                                
                            <!-- Mini UI Element -->
                            <div class="relative z-10 bg-black/30 rounded-lg p-3 border border-white/5 flex flex-col gap-2 mt-auto">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                    <span class="text-[10px] text-slate-300 font-medium font-mono">IP: 192.168.1.1 (VPN)</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">Spoof Prob.</span>
                                    <span class="text-[10px] text-amber-400 font-bold bg-amber-500/10 px-1.5 py-0.5 rounded border border-amber-500/20">89.2%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Card 3: Executive Dashboard -->
                        <div class="bg-white/[0.03] border border-white/10 rounded-2xl p-6 hover:bg-white/[0.06] hover:border-indigo-500/50 hover:shadow-[0_0_30px_rgba(99,102,241,0.15)] transition-all duration-300 group relative overflow-hidden flex flex-col justify-between h-full">
                            <div class="absolute inset-0 bg-gradient-to-b from-indigo-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                            
                            <div class="relative z-10 mb-6">
                                <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300 border border-white/5">
                                    <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 13v-1m4 1v-3m4 3V8M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                                </div>
                                <h3 class="font-display font-semibold text-white mb-2 text-lg">Executive Intelligence</h3>
                                <p class="text-slate-400 text-sm leading-relaxed">Ask complex business queries in plain English and instantly get visual data answers.</p>
                            </div>
                                
                            <!-- Mini UI Element -->
                            <div class="relative z-10 bg-black/30 rounded-lg p-3 border border-white/5 mt-auto">
                                <p class="text-[10px] text-indigo-300 font-mono mb-2 truncate">> "Compare Q2 vs Q3 spend"</p>
                                <div class="flex items-end gap-1.5 h-6">
                                    <div class="w-full bg-indigo-500/40 rounded-t h-[40%] transition-all duration-300 group-hover:h-[45%]"></div>
                                    <div class="w-full bg-indigo-500/60 rounded-t h-[60%] transition-all duration-300 group-hover:h-[65%]"></div>
                                    <div class="w-full bg-indigo-400 rounded-t h-[80%] transition-all duration-300 group-hover:h-[85%]"></div>
                                    <div class="w-full bg-brand-400 rounded-t h-[100%] shadow-[0_0_8px_rgba(56,189,248,0.4)]"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Card 4: Freelancer Assistant -->
                        <div class="bg-white/[0.03] border border-white/10 rounded-2xl p-6 hover:bg-white/[0.06] hover:border-emerald-500/50 hover:shadow-[0_0_30px_rgba(16,185,129,0.15)] transition-all duration-300 group relative overflow-hidden flex flex-col justify-between h-full">
                            <div class="absolute inset-0 bg-gradient-to-b from-emerald-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                            
                            <div class="relative z-10 mb-6">
                                <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300 border border-white/5">
                                    <svg class="w-5 h-5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <h3 class="font-display font-semibold text-white mb-2 text-lg">Freelancer Assistant</h3>
                                <p class="text-slate-400 text-sm leading-relaxed">Smart invoice categorization, payment risk assessment, and precise revenue prediction.</p>
                            </div>
                                
                            <!-- Mini UI Element -->
                            <div class="relative z-10 bg-black/30 rounded-lg p-3 border border-white/5 flex flex-col gap-2 mt-auto">
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] text-slate-400 font-medium">Inv #4092</span>
                                    <span class="text-[10px] text-emerald-400 font-bold flex items-center gap-1 bg-emerald-500/10 px-1.5 py-0.5 rounded border border-emerald-500/20"><svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg> Categorized</span>
                                </div>
                                <div class="h-1.5 w-full bg-slate-800 rounded-full overflow-hidden">
                                    <div class="w-full h-full bg-emerald-500/60 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- AI Benefits Row (3 Horizontal Cards) -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 border-t border-white/10 pt-10">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center border border-white/10 shrink-0 shadow-inner">
                                <svg class="w-4 h-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-white">24/7 Monitoring</h4>
                                <p class="text-[11px] text-slate-400">Processes data continuously</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center border border-white/10 shrink-0 shadow-inner">
                                <svg class="w-4 h-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-white">Instant Insights</h4>
                                <p class="text-[11px] text-slate-400">Intelligence in seconds</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center border border-white/10 shrink-0 shadow-inner">
                                <svg class="w-4 h-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" /></svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-white">Predictive Analysis</h4>
                                <p class="text-[11px] text-slate-400">Forecast before problems</p>
                            </div>
                        </div>
                    </div>

                </div>
                
                <!-- RIGHT AI AGENT PANEL (LIVE) -->
                <div class="relative w-full flex flex-col gap-6" x-data="aiLivePanel()" x-init="startEngine()">
                    <!-- Panel Container -->
                    <div class="bg-slate-900/80 border border-white/10 rounded-3xl p-6 sm:p-8 backdrop-blur-xl shadow-2xl relative overflow-hidden shrink-0">
                        
                        <!-- Top Ambient Glow -->
                        <div class="absolute -top-20 -left-20 w-60 h-60 bg-brand-500/20 rounded-full blur-[60px] pointer-events-none transition-opacity duration-1000"
                             :class="activeState === 'analyzing' ? 'opacity-100' : 'opacity-40'"></div>
                        
                        <!-- Agent Header -->
                        <div class="flex items-start gap-4 mb-8 relative z-10">
                            <div class="w-12 h-12 rounded-full bg-slate-800 flex items-center justify-center shrink-0 border border-slate-700 relative shadow-inner">
                                <div class="absolute inset-0 rounded-full border-2 border-brand-500/30 animate-ping" style="animation-duration: 3s"></div>
                                <svg class="w-6 h-6 text-brand-400 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="text-white font-bold font-display text-lg">TimeNest Engine</p>
                                    <span class="text-[9px] uppercase tracking-widest font-bold px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Online</span>
                                </div>
                                <p class="text-brand-300 text-sm font-mono mt-1 transition-all duration-300" x-text="statusMessage"></p>
                            </div>
                        </div>
                        
                        <!-- Activity Skeleton -->
                        <div class="space-y-3 mb-6 relative z-10">
                            <div class="bg-white/5 rounded-xl p-4 border border-white/5 relative overflow-hidden">
                                <!-- Shimmer Effect -->
                                <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/10 to-transparent animate-[shimmer_2s_infinite]"></div>
                                
                                <div class="h-3 bg-white/10 rounded w-3/4 mb-4"></div>
                                <div class="h-2 bg-white/5 rounded w-full mb-2"></div>
                                <div class="h-2 bg-white/5 rounded w-5/6"></div>
                            </div>
                        </div>

                        <!-- Live Insight Cards Stream (Absolute Positioning for Crossfade) -->
                        <div class="relative h-[180px] sm:h-[160px] z-10">
                            
                            <!-- Insight 1: Anomaly -->
                            <div class="absolute inset-0 bg-slate-800/80 rounded-xl p-5 border border-amber-500/30 border-l-4 border-l-amber-500 transition-all duration-700 transform flex flex-col justify-center shadow-lg"
                                 :class="activeInsight === 0 ? 'opacity-100 translate-y-0 scale-100 pointer-events-auto' : 'opacity-0 translate-y-4 scale-95 pointer-events-none'">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-4 h-4 text-amber-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    <h4 class="text-white font-bold text-sm">Attendance Anomaly</h4>
                                </div>
                                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed">Design team has logged 15% more overtime this week compared to monthly average. Risk of burnout is high.</p>
                                <div class="mt-4 flex items-center gap-2">
                                    <span class="text-[10px] text-amber-300 bg-amber-500/10 border border-amber-500/20 px-2 py-1 rounded font-mono">Action Recommended</span>
                                </div>
                            </div>

                            <!-- Insight 2: Revenue Forecast -->
                            <div class="absolute inset-0 bg-slate-800/80 rounded-xl p-5 border border-brand-500/30 border-l-4 border-l-brand-500 transition-all duration-700 transform flex flex-col justify-center shadow-lg"
                                 :class="activeInsight === 1 ? 'opacity-100 translate-y-0 scale-100 pointer-events-auto' : 'opacity-0 translate-y-4 scale-95 pointer-events-none'">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-4 h-4 text-brand-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                    <h4 class="text-white font-bold text-sm">Revenue Projection Up</h4>
                                </div>
                                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed">Based on current billable hours across active projects, Q3 revenue is projected to exceed targets by 8.5%.</p>
                                <div class="mt-4 flex items-center gap-2">
                                    <span class="text-[10px] text-brand-300 bg-brand-500/10 border border-brand-500/20 px-2 py-1 rounded font-mono">Positive Trend</span>
                                </div>
                            </div>

                            <!-- Insight 3: Payroll Risk -->
                            <div class="absolute inset-0 bg-slate-800/80 rounded-xl p-5 border border-rose-500/30 border-l-4 border-l-rose-500 transition-all duration-700 transform flex flex-col justify-center shadow-lg"
                                 :class="activeInsight === 2 ? 'opacity-100 translate-y-0 scale-100 pointer-events-auto' : 'opacity-0 translate-y-4 scale-95 pointer-events-none'">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-4 h-4 text-rose-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                    <h4 class="text-white font-bold text-sm">Payroll Compliance</h4>
                                </div>
                                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed">2 remote contractors have expiring compliance documents in the next 7 days. Automatic holds have been staged.</p>
                                <div class="mt-4 flex items-center gap-2">
                                    <span class="text-[10px] text-rose-300 bg-rose-500/10 border border-rose-500/20 px-2 py-1 rounded font-mono">Review Required</span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Card 1: AI Actions Today (Timeline) -->
                    <div class="bg-slate-900/60 border border-white/10 rounded-3xl p-6 backdrop-blur-xl shadow-xl relative overflow-hidden group">
                        <div class="absolute inset-0 bg-gradient-to-r from-brand-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                        <div class="flex items-center gap-3 mb-5 relative z-10">
                            <div class="w-8 h-8 rounded-full bg-brand-500/20 flex items-center justify-center border border-brand-500/30">
                                <svg class="w-4 h-4 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            </div>
                            <h4 class="text-white font-bold text-sm tracking-wide">AI Actions Executed Today</h4>
                        </div>
                        
                        <div class="relative pl-3 space-y-4 border-l border-white/10 ml-3 z-10">
                            <div class="relative">
                                <div class="absolute -left-[17px] top-1 w-2.5 h-2.5 rounded-full bg-brand-500 shadow-[0_0_8px_rgba(14,165,233,0.8)]"></div>
                                <p class="text-xs text-white font-medium">Anomaly detected</p>
                                <p class="text-[10px] text-slate-400 mt-0.5 font-mono">10:42 AM • Attendance</p>
                            </div>
                            <div class="relative">
                                <div class="absolute -left-[17px] top-1 w-2.5 h-2.5 rounded-full bg-brand-500/50"></div>
                                <p class="text-xs text-slate-200">Manager notified via Slack</p>
                                <p class="text-[10px] text-slate-400 mt-0.5 font-mono">10:43 AM • Escalation</p>
                            </div>
                            <div class="relative">
                                <div class="absolute -left-[17px] top-1 w-2.5 h-2.5 rounded-full border border-white/30 bg-slate-900"></div>
                                <p class="text-xs text-slate-400">Resolution generated</p>
                                <p class="text-[10px] text-slate-500 mt-0.5 font-mono">Pending Approval</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Predicted Business Risks -->
                    <div class="bg-slate-900/60 border border-white/10 rounded-3xl p-6 backdrop-blur-xl shadow-xl relative overflow-hidden group">
                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                        <div class="flex items-center gap-3 mb-5 relative z-10">
                            <div class="w-8 h-8 rounded-full bg-indigo-500/20 flex items-center justify-center border border-indigo-500/30">
                                <svg class="w-4 h-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                            </div>
                            <h4 class="text-white font-bold text-sm tracking-wide">Predicted Business Risks</h4>
                        </div>
                        
                        <div class="space-y-4 relative z-10">
                            <div>
                                <div class="flex justify-between text-xs mb-1.5">
                                    <span class="text-slate-300">Expected overtime increase</span>
                                    <span class="text-rose-400 font-bold">18%</span>
                                </div>
                                <div class="h-1.5 w-full bg-white/5 rounded-full overflow-hidden">
                                    <div class="h-full bg-rose-500 rounded-full w-[18%] shadow-[0_0_8px_rgba(244,63,94,0.5)]"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-xs mb-1.5">
                                    <span class="text-slate-300">Revenue forecast confidence</span>
                                    <span class="text-emerald-400 font-bold">97%</span>
                                </div>
                                <div class="h-1.5 w-full bg-white/5 rounded-full overflow-hidden">
                                    <div class="h-full bg-emerald-500 rounded-full w-[97%] shadow-[0_0_8px_rgba(16,185,129,0.5)]"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Automation Success Rate -->
                    <div class="bg-slate-900/60 border border-white/10 rounded-3xl p-6 backdrop-blur-xl shadow-xl relative overflow-hidden flex items-center justify-between group">
                        <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                        <div class="relative z-10">
                            <p class="text-[10px] text-slate-400 font-bold tracking-widest uppercase mb-1">Automation Success</p>
                            <div class="flex items-end gap-2">
                                <span class="text-3xl font-display font-bold text-white">99.9<span class="text-lg text-slate-500">%</span></span>
                                <span class="flex items-center text-[10px] text-emerald-400 mb-1.5 bg-emerald-500/10 border border-emerald-500/20 px-1.5 py-0.5 rounded font-mono">
                                    <svg class="w-3 h-3 mr-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
                                    Reliable
                                </span>
                            </div>
                        </div>
                        <div class="relative w-12 h-12 z-10">
                            <svg class="w-full h-full -rotate-90" viewBox="0 0 36 36">
                                <path class="text-white/10" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3" />
                                <path class="text-emerald-500 drop-shadow-[0_0_4px_rgba(16,185,129,0.5)]" stroke-dasharray="99.9, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3" />
                            </svg>
                        </div>
                    </div>

                </div>
        </div>
        
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('aiLivePanel', () => ({
                    activeState: 'analyzing',
                    activeInsight: 0,
                    statusMessages: [
                        'Analyzing workforce trends...',
                        'Checking attendance anomalies...',
                        'Reviewing payroll compliance...',
                        'Forecasting monthly revenue...',
                        'Compiling executive summary...'
                    ],
                    statusIndex: 0,
                    
                    get statusMessage() {
                        return this.statusMessages[this.statusIndex];
                    },
                    
                    startEngine() {
                        setInterval(() => {
                            this.statusIndex = (this.statusIndex + 1) % this.statusMessages.length;
                            this.activeState = this.statusIndex % 2 === 0 ? 'processing' : 'analyzing';
                        }, 3000);
                        
                        setInterval(() => {
                            this.activeInsight = (this.activeInsight + 1) % 3;
                        }, 8000);
                    }
                }));
            });
        </script>
        
        <style>
            @keyframes shimmer {
                100% {
                    transform: translateX(100%);
                }
            }
        </style>
    </section>

    {{-- Section 6: Stats Strip --}}
    <x-frontend-sections.stats-strip :stats="$stats" />

    {{-- Section 7: AI Workforce Assessment --}}
    <section class="py-20 lg:py-32 bg-slate-50 overflow-hidden relative border-y border-slate-200" id="ai-assessment"
             x-data="{ 
                 step: 'input', // 'input', 'analyzing', 'report'
                 
                 // Inputs
                 employees: 150, 
                 hrSize: 3, 
                 avgSalary: 60000, 
                 approvalsPerMonth: 500,
                 attendanceProcessingHrs: 24,

                 // Analysis State
                 analysisSteps: [
                     'Reviewing workforce size...',
                     'Evaluating HR workload...',
                     'Calculating approval bottlenecks...',
                     'Analyzing attendance inefficiencies...',
                     'Estimating payroll overhead...',
                     'Building optimization model...',
                     'Generating business report...'
                 ],
                 currentStepIndex: -1,
                 analysisMessages: [],
                 
                 applyPreset(preset) {
                     if (preset === 'Startup') {
                         this.employees = 15; this.hrSize = 1; this.approvalsPerMonth = 50; this.attendanceProcessingHrs = 4;
                     } else if (preset === 'SME') {
                         this.employees = 80; this.hrSize = 2; this.approvalsPerMonth = 300; this.attendanceProcessingHrs = 16;
                     } else if (preset === 'Growing Company') {
                         this.employees = 250; this.hrSize = 5; this.approvalsPerMonth = 800; this.attendanceProcessingHrs = 40;
                     } else if (preset === 'Enterprise') {
                         this.employees = 1500; this.hrSize = 25; this.approvalsPerMonth = 5000; this.attendanceProcessingHrs = 120;
                     }
                 },

                 async analyze() {
                     // Basic validation
                     if(this.employees < 1) this.employees = 1;
                     
                     this.step = 'analyzing';
                     this.currentStepIndex = 0;
                     this.analysisMessages = [];
                     
                     // Simulated intelligence messages
                     const simulatedMessages = [
                         'Your HR team appears to spend a significant amount of time on repetitive administrative processes.',
                         'I found excessive manual approval processing relative to your workforce size.',
                         'Attendance operations consume approximately ' + this.attendanceProcessingHrs + ' hours monthly.',
                         'Payroll preparation appears highly repetitive.',
                         'Potential automation opportunities detected.'
                     ];

                     for (let i = 0; i < this.analysisSteps.length; i++) {
                         this.currentStepIndex = i;
                         
                         // Add a simulated message occasionally
                         if (i % 2 === 1 && Math.floor(i/2) < simulatedMessages.length) {
                             this.analysisMessages.push(simulatedMessages[Math.floor(i/2)]);
                         }
                         
                         // Wait 600-900ms per step to feel like it's thinking
                         await new Promise(r => setTimeout(r, 600 + Math.random() * 300));
                     }
                     
                     this.step = 'report';
                 },

                 reset() {
                     this.step = 'input';
                     this.currentStepIndex = -1;
                     this.analysisMessages = [];
                 },

                 // Calculations
                 get attendanceSaved() { return Math.round(this.attendanceProcessingHrs * 0.85); },
                 get approvalSaved() { return Math.round((this.approvalsPerMonth * 5) / 60 * 0.9); },
                 get payrollSaved() { return Math.round(this.employees * 0.15); }, // estimate
                 get totalMonthlyHrsSaved() { return this.attendanceSaved + this.approvalSaved + this.payrollSaved; },
                 get annualCapitalSaved() { return Math.round((this.totalMonthlyHrsSaved * 12 * this.avgSalary) / (22 * 8 * 12)); },
                 get efficiencyGain() { return Math.min(Math.round(this.totalMonthlyHrsSaved / (this.hrSize * 160) * 100), 95) || 0; },
                 
                 get executiveSummary() {
                     return `Based on your workforce size of ${this.employees} employees and an HR structure of ${this.hrSize} professionals, TimeNest AI estimates that your organization could reduce administrative effort by approximately ${this.efficiencyGain}%.`;
                 }
             }">
        
        <!-- Background Ambient Lighting -->
        <div class="absolute top-1/2 left-0 -translate-y-1/2 w-[600px] h-[600px] bg-gradient-to-r from-indigo-500/5 to-purple-500/5 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <!-- Header Group -->
            <div class="text-center max-w-3xl mx-auto mb-12 lg:mb-16">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white border border-slate-200 shadow-sm mb-6 cursor-default">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                    <span class="text-[11px] font-bold text-slate-700 tracking-widest uppercase">AI Workforce Assessment</span>
                </div>
                <h2 class="font-display text-4xl lg:text-5xl font-bold text-slate-900 mb-6 tracking-tight">Discover hidden operational costs in under 60 seconds.</h2>
                <p class="text-slate-600 text-lg font-body leading-relaxed max-w-2xl mx-auto">TimeNest AI analyzes workforce operations, attendance workflows, approval bottlenecks, payroll effort, and administrative overhead to estimate your potential savings.</p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start relative z-10">
                
                <!-- LEFT SIDE: INPUTS & PRESETS -->
                <div class="lg:col-span-5 bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm h-max sticky top-32">
                    <div class="mb-8">
                        <h3 class="font-display text-lg font-bold text-slate-900 mb-4">Quick Presets</h3>
                        <div class="flex flex-wrap gap-2">
                            <button @click="applyPreset('Startup')" class="px-4 py-2 rounded-xl text-xs font-semibold border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-colors">Startup</button>
                            <button @click="applyPreset('SME')" class="px-4 py-2 rounded-xl text-xs font-semibold border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-colors">SME</button>
                            <button @click="applyPreset('Growing Company')" class="px-4 py-2 rounded-xl text-xs font-semibold border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-colors">Growing Company</button>
                            <button @click="applyPreset('Enterprise')" class="px-4 py-2 rounded-xl text-xs font-semibold border border-indigo-100 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 transition-colors">Enterprise</button>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- Employee Size -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-2">How many employees do you have?</label>
                            <input type="number" x-model.number="employees" min="1" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-900 font-mono text-lg transition-all" placeholder="e.g. 150">
                        </div>
                        
                        <!-- HR Size -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-2">How many people manage HR operations?</label>
                            <input type="number" x-model.number="hrSize" min="1" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-900 font-mono text-lg transition-all" placeholder="e.g. 3">
                        </div>

                        <!-- Avg Salary -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-2">Average Monthly Salary (₹)</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-mono text-lg">₹</span>
                                <input type="number" x-model.number="avgSalary" min="1" class="w-full pl-8 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-900 font-mono text-lg transition-all" placeholder="60000">
                            </div>
                        </div>

                        <!-- Approvals -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-2">Manual Approvals / Month</label>
                            <input type="number" x-model.number="approvalsPerMonth" min="1" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-900 font-mono text-lg transition-all" placeholder="e.g. 500">
                        </div>

                        <!-- Attendance Hours -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-2">Attendance Processing Hours / Month</label>
                            <input type="number" x-model.number="attendanceProcessingHrs" min="1" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-900 font-mono text-lg transition-all" placeholder="e.g. 24">
                        </div>
                    </div>

                    <button @click="analyze()" :disabled="step === 'analyzing'"
                            class="mt-8 w-full flex items-center justify-center gap-2 py-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold transition-all disabled:opacity-50 disabled:cursor-not-allowed shadow-md shadow-slate-900/10">
                        <svg x-show="step !== 'analyzing'" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        <svg x-show="step === 'analyzing'" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <span x-text="step === 'analyzing' ? 'AI is analyzing...' : (step === 'report' ? 'Recalculate Data' : 'Analyze My Organization')"></span>
                    </button>
                </div>
                
                <!-- RIGHT SIDE: AI WORKSPACE & REPORT -->
                <div class="lg:col-span-7 bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden min-h-[700px] flex flex-col relative">
                    
                    <!-- TOP BAR: AI IDENTIFIER -->
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/80 backdrop-blur-sm sticky top-0 z-20">
                        <div class="flex items-center gap-3">
                            <div class="relative w-8 h-8 rounded-lg bg-indigo-100 flex items-center justify-center border border-indigo-200">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                                <span class="absolute -top-1 -right-1 flex h-2.5 w-2.5" x-show="step === 'analyzing'">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500 border-2 border-white"></span>
                                </span>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900 leading-tight">TimeNest AI Analyst</h4>
                                <p class="text-[10px] font-semibold text-slate-500 uppercase tracking-widest font-mono" x-text="step === 'analyzing' ? 'Processing...' : (step === 'report' ? 'Report Generated' : 'Ready')"></p>
                            </div>
                        </div>
                        <div x-show="step === 'report'" x-cloak>
                            <button @click="reset()" class="text-xs font-bold text-slate-500 hover:text-slate-900 underline underline-offset-2">Reset Session</button>
                        </div>
                    </div>

                    <div class="flex-grow p-6 sm:p-8 relative overflow-y-auto" style="scroll-behavior: smooth;" x-ref="reportContainer">
                        
                        <!-- STATE 1: INITIAL/EMPTY -->
                        <div x-show="step === 'input'" class="absolute inset-0 flex flex-col items-center justify-center text-center p-8 bg-slate-50/50">
                            <div class="w-20 h-20 rounded-full bg-indigo-50 flex items-center justify-center mb-6">
                                <svg class="w-10 h-10 text-indigo-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            </div>
                            <h3 class="text-xl font-bold font-display text-slate-900 mb-2">Awaiting Organizational Data</h3>
                            <p class="text-slate-500 text-sm max-w-sm font-body">Provide your company details and click analyze. TimeNest AI will process your operational bottlenecks and generate a customized efficiency report.</p>
                        </div>

                        <!-- STATE 2: ANALYZING (CONVERSATION/STEPS) -->
                        <div x-show="step === 'analyzing'" x-cloak class="flex flex-col space-y-6 pb-20">
                            
                            <!-- Analysis Progress Steps -->
                            <div class="space-y-3">
                                <template x-for="(task, index) in analysisSteps" :key="index">
                                    <div class="flex items-center gap-3 transition-opacity duration-500" :class="index <= currentStepIndex ? 'opacity-100' : 'opacity-0 hidden'">
                                        <div class="w-5 h-5 rounded-full flex items-center justify-center shrink-0"
                                             :class="index < currentStepIndex ? 'bg-emerald-100 text-emerald-600' : (index === currentStepIndex ? 'bg-indigo-100 text-indigo-600' : '')">
                                            <!-- Completed Check -->
                                            <svg x-show="index < currentStepIndex" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                            <!-- Spinner -->
                                            <svg x-show="index === currentStepIndex" class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        </div>
                                        <span class="text-sm font-semibold font-mono"
                                              :class="index < currentStepIndex ? 'text-slate-700' : 'text-indigo-600 animate-pulse'" x-text="task"></span>
                                    </div>
                                </template>
                            </div>

                            <!-- Simulated Messages Stream -->
                            <div class="pt-6 border-t border-slate-100 space-y-4" x-effect="$refs.reportContainer.scrollTop = $refs.reportContainer.scrollHeight">
                                <template x-for="(msg, idx) in analysisMessages" :key="idx">
                                    <div class="flex gap-4 animate-hero-fade-up">
                                        <div class="w-8 h-8 rounded-full bg-indigo-50 border border-indigo-100 flex items-center justify-center shrink-0">
                                            <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                        </div>
                                        <div class="bg-indigo-50 text-indigo-900 text-sm font-medium font-body p-4 rounded-2xl rounded-tl-sm shadow-sm leading-relaxed max-w-[85%]">
                                            <span x-text="msg"></span>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- STATE 3: REPORT -->
                        <div x-show="step === 'report'" x-cloak class="space-y-10 animate-hero-fade-up pb-10" x-effect="if (step === 'report') $refs.reportContainer.scrollTop = 0">
                            
                            <!-- Section: Executive Summary -->
                            <div>
                                <h3 class="text-2xl font-bold font-display text-slate-900 mb-4 tracking-tight">Business Impact Report</h3>
                                <div class="bg-indigo-900 rounded-2xl p-6 relative overflow-hidden shadow-lg">
                                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-500/30 rounded-full blur-3xl"></div>
                                    <p class="text-indigo-50 text-base sm:text-lg leading-relaxed relative z-10 font-body" x-text="executiveSummary"></p>
                                </div>
                            </div>

                            <!-- Section: Visual AI Insights (Big Metrics) -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div class="p-5 rounded-2xl border border-slate-200 bg-slate-50 flex flex-col justify-center items-center text-center shadow-sm">
                                    <span class="text-[10px] uppercase font-bold tracking-widest text-emerald-600 font-mono mb-2 flex items-center gap-1.5"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> Cost Recovery</span>
                                    <span class="text-3xl font-display font-bold text-slate-900" x-text="'₹' + Number(annualCapitalSaved).toLocaleString()"></span>
                                    <span class="text-[10px] text-slate-500 mt-1 uppercase font-bold tracking-widest">Est. Annual</span>
                                </div>
                                <div class="p-5 rounded-2xl border border-slate-200 bg-slate-50 flex flex-col justify-center items-center text-center shadow-sm">
                                    <span class="text-[10px] uppercase font-bold tracking-widest text-indigo-600 font-mono mb-2 flex items-center gap-1.5"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> Time Recovered</span>
                                    <span class="text-3xl font-display font-bold text-slate-900" x-text="Number(totalMonthlyHrsSaved).toLocaleString()"></span>
                                    <span class="text-[10px] text-slate-500 mt-1 uppercase font-bold tracking-widest">Hours / Month</span>
                                </div>
                                <div class="p-5 rounded-2xl border border-slate-200 bg-slate-50 flex flex-col justify-center items-center text-center shadow-sm">
                                    <span class="text-[10px] uppercase font-bold tracking-widest text-brand-600 font-mono mb-2 flex items-center gap-1.5"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg> Efficiency Gain</span>
                                    <span class="text-3xl font-display font-bold text-slate-900" x-text="'+' + efficiencyGain + '%'"></span>
                                    <span class="text-[10px] text-slate-500 mt-1 uppercase font-bold tracking-widest">Ops Capacity</span>
                                </div>
                            </div>

                            <!-- Section: Scenario Comparison -->
                            <div>
                                <h4 class="text-sm font-bold uppercase tracking-widest text-slate-400 font-mono mb-4">Operations Comparison</h4>
                                <div class="border border-slate-200 rounded-2xl overflow-x-auto shadow-sm">
                                    <table class="w-full text-left text-sm font-body min-w-[500px]">
                                        <thead class="bg-slate-50 border-b border-slate-200">
                                            <tr>
                                                <th class="py-3 px-4 font-semibold text-slate-600 text-xs sm:text-sm">Metric</th>
                                                <th class="py-3 px-4 font-semibold text-slate-600 text-xs sm:text-sm">Current</th>
                                                <th class="py-3 px-4 font-bold text-indigo-600 bg-indigo-50/50 text-xs sm:text-sm">With TimeNest</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            <tr class="hover:bg-slate-50/50 transition-colors">
                                                <td class="py-3 px-4 font-medium text-slate-900">Attendance Processing</td>
                                                <td class="py-3 px-4 text-slate-600" x-text="attendanceProcessingHrs + ' hrs'"></td>
                                                <td class="py-3 px-4 font-bold text-emerald-600 bg-emerald-50/30" x-text="(attendanceProcessingHrs - attendanceSaved) + ' hrs'"></td>
                                            </tr>
                                            <tr class="hover:bg-slate-50/50 transition-colors">
                                                <td class="py-3 px-4 font-medium text-slate-900">Approval Routing</td>
                                                <td class="py-3 px-4 text-slate-600">Manual Chains</td>
                                                <td class="py-3 px-4 font-bold text-emerald-600 bg-emerald-50/30">Automated</td>
                                            </tr>
                                            <tr class="hover:bg-slate-50/50 transition-colors">
                                                <td class="py-3 px-4 font-medium text-slate-900">Payroll Preparation</td>
                                                <td class="py-3 px-4 text-slate-600">Spreadsheets</td>
                                                <td class="py-3 px-4 font-bold text-emerald-600 bg-emerald-50/30">One-Click Sync</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Section: Key Findings / Savings Breakdown -->
                            <div>
                                <h4 class="text-sm font-bold uppercase tracking-widest text-slate-400 font-mono mb-4">Key Finding Highlights</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="border border-slate-200 rounded-xl p-5 flex gap-4 items-start shadow-sm bg-white hover:border-slate-300 transition-colors">
                                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center shrink-0 border border-blue-100">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        </div>
                                        <div>
                                            <h5 class="font-bold text-slate-900 text-sm">Attendance Automation</h5>
                                            <p class="text-xs text-slate-500 mt-1 font-body">High manual effort detected. Automation can save <span x-text="attendanceSaved"></span> hours monthly.</p>
                                        </div>
                                    </div>
                                    <div class="border border-slate-200 rounded-xl p-5 flex gap-4 items-start shadow-sm bg-white hover:border-slate-300 transition-colors">
                                        <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center shrink-0 border border-amber-100">
                                            <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                        </div>
                                        <div>
                                            <h5 class="font-bold text-slate-900 text-sm">Approval Bottlenecks</h5>
                                            <p class="text-xs text-slate-500 mt-1 font-body">Routing delays identified. Streamlining can recover <span x-text="approvalSaved"></span> hours monthly.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Recommendations -->
                            <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-6 shadow-sm">
                                <h4 class="text-sm font-bold uppercase tracking-widest text-indigo-900 font-mono mb-4">Recommended Actions</h4>
                                <ul class="space-y-4 font-body">
                                    <li class="flex items-start gap-3">
                                        <span class="bg-indigo-600 text-white text-[10px] font-bold px-2 py-0.5 rounded shrink-0">Priority 1</span>
                                        <span class="text-sm font-medium text-slate-800">Centralize approval workflows across managers to eliminate routing bottlenecks.</span>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <span class="bg-indigo-400 text-white text-[10px] font-bold px-2 py-0.5 rounded shrink-0">Priority 2</span>
                                        <span class="text-sm font-medium text-slate-800">Automate biometric and geofenced attendance tracking to recover <span class="font-bold" x-text="attendanceSaved"></span> hours.</span>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <span class="bg-indigo-300 text-indigo-900 text-[10px] font-bold px-2 py-0.5 rounded shrink-0">Priority 3</span>
                                        <span class="text-sm font-medium text-slate-800">Enable one-click payroll sync to reduce manual calculations and entry errors.</span>
                                    </li>
                                </ul>
                            </div>

                            <!-- Export / Next Steps -->
                            <div class="flex flex-col sm:flex-row items-center gap-4 pt-6 border-t border-slate-200">
                                <a href="{{ route('frontend.book-demo') }}" class="w-full sm:w-auto px-6 py-3.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm transition-colors text-center shadow-md shadow-indigo-600/20">Book a Consultation</a>
                                <button onclick="alert('PDF generation and Email Export features will be integrated with the backend services.')" class="w-full sm:w-auto px-6 py-3.5 rounded-xl border border-slate-300 hover:bg-slate-50 text-slate-700 font-bold text-sm transition-colors flex items-center justify-center gap-2 bg-white shadow-sm">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                    Download Full Report
                                </button>
                            </div>
                            
                        </div>

                    </div>
                </div>
            </div>
            
        </div>
    </section>

    {{-- Section 8: Customer Stories Ecosystem (Premium SaaS Level) --}}
    <x-frontend-sections.testimonial-section :stories="$customerStories" />

    {{-- Section 9: Security & Compliance --}}
    <section class="py-10 sm:py-12 lg:py-14 bg-surface-50 border-y border-surface-border">
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

    {{-- Section 10: FAQ / Trust Center (Scalable Knowledge Center) --}}
    @php
    $getSvg = function($icon) {
        switch($icon) {
            case 'sparkles':
                return '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 21l-.813-5.096L3 15l5.187-.813L9 9l.813 5.187L15 15l-5.187.813zM19.07 4.93a10 10 0 010 14.14M4.93 19.07a10 10 0 010-14.14"/></svg>';
            case 'office-building':
                return '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5"/></svg>';
            case 'user':
                return '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>';
            case 'users':
                return '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>';
            case 'clock':
                return '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
            case 'document-text':
                return '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>';
            case 'cpu-chip':
                return '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>';
            case 'credit-card':
                return '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>';
            case 'shield-check':
                return '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>';
            case 'puzzle-piece':
                return '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/></svg>';
            case 'rocket':
                return '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 00-1 1v1a2 2 0 002 2h1a1 1 0 001-1v-1.586l4.707-4.707C10.923 11.563 11 11.28 11 11V9.586l4.707-4.707C15.823 4.763 16 4.48 16 4.2V2.778M9 9h.01M9 13h.01M9 17h.01"/></svg>';
            case 'briefcase':
                return '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>';
            case 'light-bulb':
                return '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>';
            default:
                return '<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
        }
    };
    @endphp

    <section class="py-24 lg:py-32 bg-slate-50 relative border-t border-slate-200/60" id="faq"
             x-data="{ 
                 activeCategory: 'General', 
                 activeSubcategory: 'All',
                 searchQuery: '',
                 sortMethod: 'popular',
                 currentPage: 1,
                 itemsPerPage: 10,
                 expandedIds: [],
                 faqData: {{ Js::from($faqs) }},
                 
                 init() {
                     // Auto-expand first question of active category
                     let firstQ = this.faqData.questions.find(q => q.category === this.activeCategory);
                     if (firstQ) this.expandedIds = [firstQ.id];
                 },

                 get allSubcategories() {
                     let qs = this.faqData.questions.filter(q => q.category === this.activeCategory);
                     let subcats = [...new Set(qs.map(q => q.subcategory).filter(Boolean))];
                     return ['All', ...subcats];
                 },

                 get filteredQuestions() {
                     let qs = [...this.faqData.questions];
                     
                     // If no search, filter by category & subcategory
                     if (this.searchQuery.trim() === '') {
                         qs = qs.filter(q => q.category === this.activeCategory);
                         if (this.activeSubcategory !== 'All') {
                             qs = qs.filter(q => q.subcategory === this.activeSubcategory);
                         }
                     } else {
                         // Global search
                         let query = this.searchQuery.toLowerCase().trim();
                         qs = qs.filter(q => 
                             q.q.toLowerCase().includes(query) || 
                             q.a.toLowerCase().includes(query) || 
                             q.category.toLowerCase().includes(query) || 
                             (q.subcategory && q.subcategory.toLowerCase().includes(query)) ||
                             (q.tags && q.tags.some(t => t.toLowerCase().includes(query)))
                         );
                     }

                     // Apply sorting
                     if (this.sortMethod === 'popular') {
                         qs.sort((a, b) => (b.is_popular ? 1 : 0) - (a.is_popular ? 1 : 0));
                     } else if (this.sortMethod === 'alphabetical') {
                         qs.sort((a, b) => a.q.localeCompare(b.q));
                     } else if (this.sortMethod === 'updated') {
                         qs.sort((a, b) => b.updated_at.localeCompare(a.updated_at));
                     }
                     return qs;
                 },

                 get paginatedQuestions() {
                     let start = (this.currentPage - 1) * this.itemsPerPage;
                     return this.filteredQuestions.slice(start, start + this.itemsPerPage);
                 },

                 get totalPages() {
                     return Math.ceil(this.filteredQuestions.length / this.itemsPerPage) || 1;
                 },

                 get searchMatches() {
                     if (this.searchQuery.trim().length < 2) return [];
                     let query = this.searchQuery.toLowerCase().trim();
                     return this.faqData.questions.filter(q => 
                         q.q.toLowerCase().includes(query) || 
                         q.category.toLowerCase().includes(query) || 
                         (q.subcategory && q.subcategory.toLowerCase().includes(query))
                     ).slice(0, 5);
                 },

                 toggleQuestion(id) {
                     if (this.expandedIds.includes(id)) {
                         this.expandedIds = this.expandedIds.filter(x => x !== id);
                     } else {
                         this.expandedIds.push(id);
                     }
                 },

                 isExpanded(id) {
                     return this.expandedIds.includes(id);
                 },

                 selectSearchResult(result) {
                     this.activeCategory = result.category;
                     this.activeSubcategory = 'All';
                     this.searchQuery = '';
                     
                     this.$nextTick(() => {
                         let idx = this.filteredQuestions.findIndex(q => q.id === result.id);
                         if (idx !== -1) {
                             this.currentPage = Math.floor(idx / this.itemsPerPage) + 1;
                         }
                         if (!this.expandedIds.includes(result.id)) {
                             this.expandedIds.push(result.id);
                         }
                         
                         setTimeout(() => {
                             let el = document.getElementById('faq-' + result.id);
                             if (el) {
                                 el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                             }
                         }, 100);
                     });
                 },

                 navigateToQuestion(id) {
                     let qObj = this.faqData.questions.find(q => q.id === id);
                     if (qObj) {
                         this.selectSearchResult(qObj);
                     }
                 },

                 expandAll() {
                     let visibleIds = this.paginatedQuestions.map(q => q.id);
                     this.expandedIds = [...new Set([...this.expandedIds, ...visibleIds])];
                 },

                 collapseAll() {
                     let visibleIds = this.paginatedQuestions.map(q => q.id);
                     this.expandedIds = this.expandedIds.filter(id => !visibleIds.includes(id));
                 },

                 getCategoryCount(cat) {
                     return this.faqData.questions.filter(q => q.category === cat).length;
                 }
             }">
        
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto mb-12">
                <x-frontend-base.badge color="brand" size="md" class="mb-6">Knowledge Base</x-frontend-base.badge>
                <h2 class="font-display text-4xl lg:text-5xl font-bold text-slate-900 mb-6 tracking-tight">Everything you need to know.</h2>
                <p class="text-slate-600 text-lg lg:text-xl font-body">Clear answers to help you make an informed decision about migrating your workforce to TimeNest.</p>
            </div>

            <!-- Statistics Badge Row -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-y-6 md:gap-y-0 gap-x-4 max-w-4xl mx-auto mb-16 border-y border-slate-200 py-6 md:py-8">
                <div class="text-center">
                    <span class="text-2xl md:text-3xl font-display font-black text-slate-900 leading-none">250+</span>
                    <p class="text-[10px] text-slate-500 font-semibold uppercase tracking-wider mt-1.5 font-mono">Knowledge Articles</p>
                </div>
                <div class="text-center border-l border-slate-200">
                    <span class="text-2xl md:text-3xl font-display font-black text-slate-900 leading-none">35+</span>
                    <p class="text-[10px] text-slate-500 font-semibold uppercase tracking-wider mt-1.5 font-mono">Product Features</p>
                </div>
                <div class="text-center md:border-l border-slate-200">
                    <span class="text-2xl md:text-3xl font-display font-black text-slate-900 leading-none">24/7</span>
                    <p class="text-[10px] text-slate-500 font-semibold uppercase tracking-wider mt-1.5 font-mono">Support Coverage</p>
                </div>
                <div class="text-center border-l border-slate-200">
                    <span class="text-2xl md:text-3xl font-display font-black text-slate-900 leading-none">98%</span>
                    <p class="text-[10px] text-slate-500 font-semibold uppercase tracking-wider mt-1.5 font-mono">Questions Answered</p>
                </div>
            </div>

            <!-- Most Popular Questions Panel -->
            <div class="max-w-7xl mx-auto mb-16 p-6 rounded-3xl bg-white border border-slate-200 shadow-sm text-left">
                <h3 class="text-xs font-bold uppercase tracking-widest text-slate-400 font-mono mb-4">Most Popular Questions</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach(collect($faqs['questions'])->filter(fn($q) => $q['is_popular'])->take(4) as $pQuest)
                        <button @click="navigateToQuestion('{{ $pQuest['id'] }}')"
                                class="flex items-center justify-between p-4 rounded-xl border border-slate-100 bg-slate-50 hover:bg-slate-100 hover:border-slate-200 hover:shadow-sm text-left group transition-all duration-300 cursor-pointer">
                            <div>
                                <span class="text-xs font-semibold text-indigo-600 bg-indigo-50 border border-indigo-100 px-2 py-0.5 rounded font-mono uppercase tracking-wider">{{ $pQuest['category'] }}</span>
                                <p class="text-slate-900 font-display font-semibold text-sm sm:text-base mt-2 group-hover:text-indigo-600 transition-colors">{{ $pQuest['q'] }}</p>
                            </div>
                            <span class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-400 group-hover:text-indigo-600 group-hover:border-indigo-200 shrink-0 ml-4 transition-all">
                                &rarr;
                            </span>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Global Search Section -->
            <div class="max-w-3xl mx-auto mb-16 relative">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" /></svg>
                    </div>
                    <input x-model="searchQuery" type="text" placeholder="Search across all categories, subcategories, and answers..." 
                           class="w-full pl-12 pr-4 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 shadow-sm transition-all text-base font-body text-slate-900 placeholder-slate-400">
                </div>

                <!-- Instant Search Dropdown Overlay -->
                <div x-show="searchQuery.trim().length >= 2" 
                     x-cloak
                     class="absolute left-0 right-0 mt-2 bg-white rounded-2xl border border-slate-200/80 shadow-2xl z-50 p-2 space-y-1 text-left max-h-96 overflow-y-auto"
                     @click.away="searchQuery = ''">
                    
                    <div class="px-3 py-2 border-b border-slate-100">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest font-mono">Global Search Matches</p>
                    </div>

                    <!-- Match list -->
                    <template x-for="match in searchMatches" :key="match.id">
                        <button @click="selectSearchResult(match)"
                                class="w-full text-left p-3 hover:bg-slate-50 rounded-xl transition-colors cursor-pointer block border border-transparent hover:border-slate-100 group">
                            <div class="flex items-center justify-between">
                                <span class="font-display font-semibold text-slate-900 text-sm group-hover:text-indigo-600 transition-colors" x-text="match.q"></span>
                                <svg class="w-3.5 h-3.5 text-slate-300 group-hover:text-indigo-500 transform transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                            <div class="flex items-center gap-1.5 mt-1.5">
                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider font-mono" x-text="match.category"></span>
                                <span class="text-slate-300 text-[9px]">&bull;</span>
                                <span class="text-[9px] font-bold text-slate-500 font-mono" x-text="match.subcategory"></span>
                            </div>
                        </button>
                    </template>

                    <!-- Empty state match -->
                    <div x-show="searchMatches.length === 0" class="py-6 text-center text-slate-400 text-sm font-body">
                        No matches found. Try general keywords like "location", "pricing", or "SSO".
                    </div>
                </div>
            </div>

            <!-- Mobile Category Chips (Horizontal Swipe) -->
            <div class="lg:hidden flex overflow-x-auto gap-2 pb-6 scrollbar-hide -mx-6 px-6 select-none" x-show="searchQuery.trim() === ''">
                @foreach($faqs['categories'] as $catName => $catMeta)
                    <button @click="activeCategory = '{{ $catName }}'; activeSubcategory = 'All'; currentPage = 1; expandedIds = []"
                            class="px-4 py-2.5 rounded-xl border text-xs font-semibold tracking-tight whitespace-nowrap transition-all duration-300 cursor-pointer flex items-center gap-2"
                            :class="activeCategory === '{{ $catName }}'
                                ? 'bg-slate-900 text-white border-slate-900 shadow-md scale-[1.02]'
                                : 'bg-white text-slate-600 border-slate-200/80 hover:bg-slate-50'">
                        {!! $getSvg($catMeta['icon']) !!}
                        <span>{{ $catName }}</span>
                        <span class="px-1.5 py-0.5 rounded-full text-[9px] font-mono leading-none"
                              :class="activeCategory === '{{ $catName }}' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-500'">
                            {{ count(collect($faqs['questions'])->filter(fn($q) => $q['category'] === $catName)) }}
                        </span>
                    </button>
                @endforeach
            </div>

            <!-- Core Explorer Grid Layout -->
            <div class="flex flex-col lg:flex-row gap-12 lg:gap-16 items-start relative">
                
                <!-- Left Sidebar (Desktop Categories list) -->
                <div class="hidden lg:flex w-full lg:w-1/3 flex-col gap-3 sticky top-32 shrink-0 select-none" x-show="searchQuery.trim() === ''">
                    <div class="px-2 pb-2">
                        <h4 class="text-xs font-bold uppercase tracking-widest text-slate-400 font-mono">Browse Categories</h4>
                    </div>

                    @foreach($faqs['categories'] as $catName => $catMeta)
                        <button @click="activeCategory = '{{ $catName }}'; activeSubcategory = 'All'; currentPage = 1; expandedIds = []"
                                class="text-left p-4 rounded-2xl border transition-all duration-300 cursor-pointer group flex items-start gap-4"
                                :class="activeCategory === '{{ $catName }}'
                                    ? 'bg-slate-900 border-slate-900 text-white shadow-xl shadow-slate-900/10 scale-[1.01]'
                                    : 'bg-white border-slate-200/60 text-slate-700 hover:border-slate-300 hover:bg-slate-50/50 hover:shadow-sm'">
                            
                            <!-- Icon wrapper -->
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 border transition-colors duration-300"
                                 :class="activeCategory === '{{ $catName }}' 
                                     ? 'bg-white/10 border-white/10 text-indigo-400' 
                                     : 'bg-slate-50 border-slate-100 text-slate-400 group-hover:text-indigo-600 group-hover:border-indigo-100'">
                                {!! $getSvg($catMeta['icon']) !!}
                            </div>

                            <!-- Details -->
                            <div class="flex-grow">
                                <div class="flex items-center justify-between">
                                    <span class="font-display font-bold text-sm tracking-tight"
                                          :class="activeCategory === '{{ $catName }}' ? 'text-white' : 'text-slate-950 group-hover:text-indigo-600'">
                                        {{ $catName }}
                                    </span>
                                    <!-- count badge -->
                                    <span class="px-1.5 py-0.5 rounded-full text-[10px] font-mono leading-none"
                                          :class="activeCategory === '{{ $catName }}' ? 'bg-white/25 text-white' : 'bg-slate-100 text-slate-500'">
                                        {{ count(collect($faqs['questions'])->filter(fn($q) => $q['category'] === $catName)) }}
                                    </span>
                                </div>
                                <p class="text-[11px] leading-relaxed mt-1 font-body"
                                   :class="activeCategory === '{{ $catName }}' ? 'text-slate-400' : 'text-slate-500'">
                                    {{ $catMeta['description'] }}
                                </p>
                            </div>
                        </button>
                    @endforeach
                </div>

                <!-- Right Side: Question Explorer Area -->
                <div class="w-full lg:w-2/3 min-h-[600px] flex flex-col justify-between space-y-6">
                    
                    <!-- Search Mode Header -->
                    <div x-show="searchQuery.trim() !== ''" class="mb-4 text-left">
                        <h3 class="text-xl font-bold text-slate-950 font-display">
                            Search Results for "<span class="text-indigo-600" x-text="searchQuery"></span>"
                            <span class="text-xs font-semibold ml-2 px-2.5 py-1 rounded-full bg-slate-200 text-slate-600" x-text="filteredQuestions.length"></span>
                        </h3>
                    </div>

                    <!-- Category Mode Filters Bar -->
                    <div x-show="searchQuery.trim() === ''" class="space-y-4 text-left">
                        <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                            <h3 class="text-xl font-bold text-slate-950 font-display flex items-center gap-2">
                                <span x-text="activeCategory"></span>
                                <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-slate-200 text-slate-600" x-text="filteredQuestions.length"></span>
                            </h3>
                        </div>

                        <!-- Subcategory Horizontal Chips Scrollable -->
                        <div class="flex items-center gap-1.5 overflow-x-auto pb-2 scrollbar-hide select-none">
                            <template x-for="subcat in allSubcategories" :key="subcat">
                                <button @click="activeSubcategory = subcat; currentPage = 1"
                                        class="px-3.5 py-1.5 rounded-lg border text-xs font-semibold tracking-tight whitespace-nowrap transition-colors duration-200 cursor-pointer"
                                        :class="activeSubcategory === subcat
                                            ? 'bg-indigo-600 border-indigo-500 text-white shadow-sm'
                                            : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-slate-900'">
                                    <span x-text="subcat"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- Controls / Sort Bar -->
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-0 bg-slate-100/60 p-2.5 rounded-xl border border-slate-200/50">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 font-mono"
                              x-text="'Showing ' + (filteredQuestions.length ? ((currentPage-1)*itemsPerPage + 1) : 0) + '–' + Math.min(currentPage * itemsPerPage, filteredQuestions.length) + ' of ' + filteredQuestions.length + ' questions'">
                        </span>
                        
                        <div class="flex flex-wrap items-center justify-center gap-3">
                            <!-- Sort -->
                            <select x-model="sortMethod" 
                                    class="text-[11px] font-semibold bg-white border border-slate-200 rounded-lg px-2 py-1 text-slate-600 focus:outline-none focus:ring-1 focus:ring-indigo-500 font-body">
                                <option value="popular">Sort: Popularity</option>
                                <option value="alphabetical">Sort: Alphabetical</option>
                                <option value="updated">Sort: Recently Updated</option>
                            </select>

                            <!-- Accordion Toggles -->
                            <div class="flex items-center gap-1">
                                <button @click="expandAll()" class="text-[10px] font-bold text-slate-500 hover:text-slate-900 border border-slate-200 bg-white px-2 py-1 rounded-md transition-colors cursor-pointer">Expand All</button>
                                <button @click="collapseAll()" class="text-[10px] font-bold text-slate-500 hover:text-slate-900 border border-slate-200 bg-white px-2 py-1 rounded-md transition-colors cursor-pointer">Collapse All</button>
                            </div>
                        </div>
                    </div>

                    <!-- Questions Accordion Loop Grid -->
                    <div class="space-y-4 text-left">
                        <template x-for="faq in paginatedQuestions" :key="faq.id">
                            <div :id="'faq-' + faq.id"
                                 class="rounded-2xl border bg-white overflow-hidden transition-all duration-300 shadow-sm"
                                 :class="isExpanded(faq.id) ? 'border-indigo-500 ring-1 ring-indigo-500/10 shadow-md bg-slate-50/50' : 'border-slate-200/80 hover:border-slate-300 hover:shadow-sm'">
                                
                                <button @click="toggleQuestion(faq.id)"
                                        class="w-full flex items-start sm:items-center justify-between px-5 py-4 text-left cursor-pointer focus:outline-none group">
                                    <div class="pr-4 space-y-1.5">
                                        <!-- badges row -->
                                        <div class="flex items-center gap-2">
                                            <template x-if="faq.label">
                                                <span class="text-[9px] font-black uppercase tracking-wider px-2 py-0.5 rounded font-mono"
                                                      :class="faq.label === 'Popular' 
                                                          ? 'bg-amber-100 text-amber-800 border border-amber-200/50' 
                                                          : 'bg-emerald-100 text-emerald-800 border border-emerald-200/50'"
                                                      x-text="faq.label"></span>
                                            </template>
                                            <template x-if="searchQuery.trim() !== ''">
                                                <span class="text-[8px] font-black text-slate-400 bg-slate-100 px-1.5 py-0.5 rounded font-mono uppercase tracking-widest"
                                                      x-text="faq.category + ' > ' + faq.subcategory"></span>
                                            </template>
                                        </div>
                                        <span class="font-display font-bold text-slate-900 text-base sm:text-lg group-hover:text-indigo-600 transition-colors duration-200 leading-tight block"
                                              :class="isExpanded(faq.id) ? 'text-indigo-600' : ''" 
                                              x-text="faq.q"></span>
                                    </div>

                                    <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 border transition-all duration-300"
                                         :class="isExpanded(faq.id) 
                                             ? 'bg-indigo-100 border-indigo-200 text-indigo-600 rotate-180 shadow-inner' 
                                             : 'bg-slate-50 border-slate-100 text-slate-400 group-hover:bg-slate-100'">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </button>

                                <!-- Collapsible content -->
                                <div x-show="isExpanded(faq.id)" x-collapse>
                                    <div class="px-5 pb-5 pt-1 text-slate-600 leading-relaxed text-sm sm:text-base font-body border-t border-slate-200/40">
                                        <div class="space-y-4" x-html="faq.a"></div>
                                        
                                        <!-- Last Updated timestamp -->
                                        <div class="text-[10px] text-slate-400 font-mono mt-4 flex items-center gap-1.5 select-none">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span x-text="faq.updated_at"></span>
                                        </div>

                                        <!-- Related Questions panel -->
                                        <template x-if="faq.related_questions && faq.related_questions.length > 0">
                                            <div class="mt-6 pt-4 border-t border-slate-200 select-none">
                                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest font-mono block mb-2.5">Related Questions</span>
                                                <div class="flex flex-wrap gap-2">
                                                    <template x-for="reqId in faq.related_questions">
                                                        <button @click="navigateToQuestion(reqId)" 
                                                                class="flex items-center gap-1 text-xs font-semibold text-indigo-600 hover:text-indigo-700 bg-indigo-50 hover:bg-indigo-100/80 border border-indigo-200/50 px-3 py-1.5 rounded-lg transition-colors cursor-pointer select-none">
                                                            <span class="max-w-[200px] sm:max-w-xs truncate inline-block" x-text="faqData.questions.find(q => q.id === reqId)?.q"></span> <span>&rarr;</span>
                                                        </button>
                                                    </template>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                            </div>
                        </template>

                        <!-- Empty state questions -->
                        <div x-show="filteredQuestions.length === 0" 
                             class="text-center py-16 bg-white rounded-3xl border border-slate-200 border-dashed">
                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H13.01" /></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 mb-2 font-display">No matches found</h3>
                            <p class="text-slate-500 font-body max-w-md mx-auto">We couldn't find any questions matching your query. Try searching for other tags, or check other categories.</p>
                            <button @click="searchQuery = ''; activeSubcategory = 'All'; currentPage = 1" class="mt-6 text-sm font-bold text-indigo-600 hover:text-indigo-700 bg-indigo-50 px-4 py-2 rounded-full transition-colors cursor-pointer">Reset Explorer</button>
                        </div>
                    </div>

                    <!-- Pagination Navigation footer block -->
                    <div x-show="totalPages > 1" 
                         class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 border-t border-slate-200 select-none">
                        <!-- Left indicator -->
                        <span class="text-xs text-slate-500 font-body"
                              x-text="'Page ' + currentPage + ' of ' + totalPages"></span>
                        
                        <!-- Nav buttons -->
                        <div class="flex items-center gap-1">
                            <!-- Prev -->
                            <button @click="currentPage = Math.max(currentPage - 1, 1)"
                                    class="w-10 h-10 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 flex items-center justify-center cursor-pointer transition-colors disabled:opacity-30 disabled:pointer-events-none"
                                    :disabled="currentPage === 1">
                                &larr;
                            </button>
                            <!-- Pages Desktop -->
                            <div class="hidden sm:flex items-center gap-1">
                                <template x-for="pIdx in totalPages" :key="pIdx">
                                    <button @click="currentPage = pIdx"
                                            class="w-10 h-10 rounded-xl text-xs font-bold font-mono transition-all cursor-pointer border"
                                            :class="currentPage === pIdx
                                                ? 'bg-slate-900 text-white border-slate-900 shadow-md scale-105'
                                                : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50'"
                                            x-text="pIdx">
                                    </button>
                                </template>
                            </div>
                            
                            <!-- Page Mobile Status -->
                            <div class="flex sm:hidden items-center justify-center px-4 h-10 rounded-xl border border-slate-200 bg-white text-xs font-bold font-mono text-slate-600"
                                 x-text="currentPage + ' / ' + totalPages">
                            </div>

                            <!-- Next -->
                            <button @click="currentPage = Math.min(currentPage + 1, totalPages)"
                                    class="w-10 h-10 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 flex items-center justify-center cursor-pointer transition-colors disabled:opacity-30 disabled:pointer-events-none"
                                    :disabled="currentPage === totalPages">
                                &rarr;
                            </button>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </section>

    {{-- Section 11: Enterprise CTA (Workforce Operating System) --}}
    <section class="bg-black relative overflow-hidden py-16 sm:py-20 lg:py-24 border-y border-slate-900">
        
        {{-- Concentric Gold Rings in Background --}}
        <div class="absolute right-0 top-1/2 -translate-y-1/2 h-[150%] w-auto opacity-10 pointer-events-none hidden lg:block">
            <svg class="h-full w-auto" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="400" cy="200" r="80" stroke="#f59e0b" stroke-width="1" stroke-dasharray="2 4"/>
                <circle cx="400" cy="200" r="130" stroke="#f59e0b" stroke-width="1" stroke-dasharray="2 4"/>
                <circle cx="400" cy="200" r="180" stroke="#f59e0b" stroke-width="1" stroke-dasharray="2 4"/>
                <circle cx="400" cy="200" r="230" stroke="#f59e0b" stroke-width="1" stroke-dasharray="2 4"/>
                <circle cx="400" cy="200" r="280" stroke="#f59e0b" stroke-width="1" stroke-dasharray="2 4"/>
                <circle cx="400" cy="200" r="330" stroke="#f59e0b" stroke-width="1" stroke-dasharray="2 4"/>
                <circle cx="400" cy="200" r="380" stroke="#f59e0b" stroke-width="1" stroke-dasharray="2 4"/>
            </svg>
        </div>

        {{-- Golden Radial Glow on the Right --}}
        <div class="absolute right-0 top-0 w-[400px] h-full bg-gradient-to-l from-amber-500/10 via-transparent to-transparent pointer-events-none blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center relative z-10">
                
                <!-- Left: Headline and Paragraph -->
                <div class="lg:col-span-7 text-left">
                    {{-- Ready Badge --}}
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/20 mb-6">
                        <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-amber-500 font-body">READY TO TRANSFORM YOUR OPERATIONS?</span>
                    </div>

                    {{-- Headline --}}
                    <h2 class="font-display text-4xl sm:text-5xl font-bold tracking-tight text-white mb-6 leading-tight">
                        See TimeNest in action.<br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-amber-200">Tailored for your team.</span>
                    </h2>

                    {{-- Description --}}
                    <p class="text-slate-400 text-sm sm:text-base max-w-xl leading-relaxed font-body">
                        Book a personalized demo and discover how TimeNest can streamline your workforce operations, boost productivity, and drive growth.
                    </p>
                </div>

                <!-- Right: CTAs and Trust Items -->
                <div class="lg:col-span-5 flex flex-col items-stretch lg:items-start w-full">
                    {{-- Action Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-4 mb-8 w-full justify-start">
                        <a href="{{ route('frontend.book-demo') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 h-12 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-sm transition-all shadow-lg shadow-amber-500/10 shrink-0 group">
                            <svg class="w-4 h-4 shrink-0 text-slate-950" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>Book a Personalized Demo</span>
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1 shrink-0 text-slate-950" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                        <a href="{{ route('frontend.contact') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 h-12 rounded-xl border border-amber-500/30 hover:border-amber-400 text-slate-200 hover:text-white font-semibold text-sm transition-all bg-transparent hover:bg-white/5 shrink-0 group">
                            <svg class="w-4 h-4 shrink-0 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 18v-6a9 9 0 0118 0v6M2 12a1 1 0 011-1h1.5a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zm18 0a1 1 0 011-1h1.5a1 1 0 011 1v5a1 1 0 01-1 1H20a1 1 0 011-1h1.5a1 1 0 011 1v5a1 1 0 01-1 1H21a1 1 0 01-1-1v-5z"/>
                            </svg>
                            <span>Talk to Solutions Team</span>
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1 shrink-0 text-slate-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>

                    {{-- Trust Grid --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-x-8 gap-y-4 items-center border-t border-slate-900/80 pt-8 mt-8 w-full">
                        <!-- Indicator 1: Enterprise Security -->
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <div class="flex flex-col text-left">
                                <span class="text-xs font-semibold text-white leading-tight font-display">Enterprise</span>
                                <span class="text-[10px] text-slate-400 font-body">Security</span>
                            </div>
                        </div>
                        
                        <!-- Indicator 2: Dedicated Onboarding -->
                        <div class="flex items-center gap-2 md:border-l md:border-slate-900/80 md:pl-4">
                            <svg class="w-5 h-5 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <div class="flex flex-col text-left">
                                <span class="text-xs font-semibold text-white leading-tight font-display">Dedicated</span>
                                <span class="text-[10px] text-slate-400 font-body">Onboarding</span>
                            </div>
                        </div>

                        <!-- Indicator 3: Expert Support -->
                        <div class="flex items-center gap-2 md:border-l md:border-slate-900/80 md:pl-4">
                            <svg class="w-5 h-5 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 18v-6a9 9 0 0118 0v6M2 12a1 1 0 011-1h1.5a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zm18 0a1 1 0 011-1h1.5a1 1 0 011 1v5a1 1 0 01-1 1H20a1 1 0 011-1h1.5a1 1 0 011 1v5a1 1 0 01-1 1H21a1 1 0 01-1-1v-5z"/>
                            </svg>
                            <div class="flex flex-col text-left">
                                <span class="text-xs font-semibold text-white leading-tight font-display">Expert</span>
                                <span class="text-[10px] text-slate-400 font-body">Support</span>
                            </div>
                        </div>

                        <!-- Indicator 4: Global Scale -->
                        <div class="flex items-center gap-2 md:border-l md:border-slate-900/80 md:pl-4">
                            <svg class="w-5 h-5 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                            </svg>
                            <div class="flex flex-col text-left">
                                <span class="text-xs font-semibold text-white leading-tight font-display">Global</span>
                                <span class="text-[10px] text-slate-400 font-body">Scale</span>
                            </div>
                        </div>
                    </div>

                    {{-- Star Line --}}
                    <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mt-6 pt-4 border-t border-slate-900/40">
                        <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                        <span>Trusted by 1000+ teams across 20+ countries</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Section 12: Light-Themed Trust & Support Panel --}}
    <section class="py-20 md:py-28 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <!-- Light Themed Trust & Support Panel -->
            <div class="bg-gradient-to-br from-white to-slate-50 border border-slate-200/60 rounded-3xl p-8 lg:p-12 shadow-xl shadow-slate-200/20 relative overflow-hidden group">
                <!-- Grid background -->
                <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808008_1px,transparent_1px),linear-gradient(to_bottom,#80808008_1px,transparent_1px)] bg-[size:16px_16px] pointer-events-none"></div>
                
                <!-- Ambient blur glows -->
                <div class="absolute -top-40 -left-40 w-80 h-80 bg-indigo-500/5 rounded-full blur-3xl pointer-events-none transition-all duration-1000 group-hover:bg-indigo-500/10"></div>
                <div class="absolute -bottom-40 -right-40 w-80 h-80 bg-amber-500/5 rounded-full blur-3xl pointer-events-none transition-all duration-1000 group-hover:bg-amber-500/10"></div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center relative z-10">
                    <!-- Left: Text content -->
                    <div class="lg:col-span-8 text-left">
                        <p class="text-slate-600 text-lg sm:text-xl font-body leading-relaxed max-w-3xl">
                            Stop guessing how to map your attendance rules, approval chains, and contractor invoices. Our product architects will design a <span class="font-semibold text-slate-900 underline decoration-indigo-500/40 decoration-2 underline-offset-4">tailored deployment plan</span> specifically for your organization's operational needs.
                        </p>
                    </div>

                    <!-- Right: Stack of Buttons -->
                    <div class="lg:col-span-4 flex flex-col gap-3 w-full sm:max-w-xs lg:max-w-none lg:ml-auto">
                        <a href="{{ route('frontend.faqs.index') }}" class="flex items-center justify-center h-12 px-6 rounded-xl border border-slate-200 bg-white text-slate-700 font-semibold text-sm hover:bg-slate-50 hover:border-slate-300 hover:text-slate-900 transition-all shadow-sm hover:shadow active:scale-[0.98]">
                            Explore Documentation
                        </a>
                        <a href="{{ route('frontend.book-demo') }}" class="flex items-center justify-center h-12 px-6 rounded-xl bg-slate-950 text-white font-semibold text-sm hover:bg-black transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 active:scale-[0.98] duration-200">
                            Schedule Demo
                        </a>
                        <a href="{{ route('frontend.contact') }}" class="flex items-center justify-center h-12 px-6 rounded-xl border border-slate-200 bg-white text-slate-700 font-semibold text-sm hover:bg-slate-50 hover:border-slate-300 hover:text-slate-900 transition-all shadow-sm hover:shadow active:scale-[0.98]">
                            Contact Team
                        </a>
                    </div>
                </div>

                <!-- Bottom: Divider & 3 Stats columns -->
                <div class="border-t border-slate-200/80 mt-10 pt-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-0 items-center justify-between text-left">
                        <!-- Stat 1 -->
                        <div class="md:pr-8 flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5 font-body">AVERAGE RESPONSE</span>
                                <span class="text-lg font-bold text-slate-900 font-display">&lt; 2 Hours</span>
                            </div>
                        </div>
                        
                        <!-- Stat 2 -->
                        <div class="md:px-8 md:border-l md:border-slate-200 flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5 font-body">IMPLEMENTATION</span>
                                <span class="text-lg font-bold text-slate-900 font-display">Guided Support</span>
                            </div>
                        </div>

                        <!-- Stat 3 -->
                        <div class="md:pl-8 md:border-l md:border-slate-200 flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5 font-body">ENTERPRISE</span>
                                <span class="text-lg font-bold text-slate-900 font-display">Dedicated CSM</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-frontend-layout.app>
