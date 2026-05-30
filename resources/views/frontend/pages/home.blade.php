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
            
            {{-- Ticker Component --}}
            <div class="mt-24 pt-10 border-t border-surface-border/50 opacity-0 animate-hero-fade-up" style="animation-delay: 1000ms;">
                <p class="text-center text-sm font-semibold text-content-muted uppercase tracking-wider mb-8">Trusted by forward-thinking teams globally</p>
                <x-frontend-sections.ticker :items="[
                    ['name' => 'Acme Corp', 'icon' => '<path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M13 10V3L4 14h7v7l9-11h-7z\'/>'],
                    ['name' => 'Stark Industries', 'icon' => '<path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4\'/>'],
                    ['name' => 'Wayne Ent', 'icon' => '<path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3\'/>'],
                    ['name' => 'Globex', 'icon' => '<path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9\'/>'],
                    ['name' => 'Soylent', 'icon' => '<path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10\'/>'],
                    ['name' => 'Initech', 'icon' => '<path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z\'/>'],
                ]" />
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

            <!-- Premium Browser Showcase Container with Tilt Parallax -->
            <div class="relative mx-auto max-w-6xl transition-all duration-1000 delay-400 transform"
                 :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
                 x-data="{ rotateX: 0, rotateY: 0, scale: 1, shadow: 12 }"
                 @mousemove="
                     const rect = $el.getBoundingClientRect();
                     const px = ($event.clientX - rect.left) / rect.width - 0.5;
                     const py = ($event.clientY - rect.top) / rect.height - 0.5;
                     rotateX = py * -8;
                     rotateY = px * 8;
                     scale = 1.015;
                     shadow = 24;
                 "
                 @mouseleave="
                     rotateX = 0;
                     rotateY = 0;
                     scale = 1;
                     shadow = 12;
                 "
                 :style="`transform: perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(${scale}, ${scale}, 1);`"
            >
                <!-- Decorative Glow behind Dashboard Preview -->
                <div class="absolute inset-0 bg-gradient-to-tr from-brand-500/10 to-indigo-500/10 rounded-[2.5rem] transform rotate-1 scale-102 blur-3xl pointer-events-none"></div>
                
                <!-- Browser Window Container -->
                <div class="relative rounded-2xl border border-slate-200/80 bg-white overflow-hidden browser-chrome-frame transition-all duration-300"
                     :style="`box-shadow: 0 ${shadow}px ${shadow * 3}px -${shadow / 2}px rgba(15, 23, 42, 0.12)`"
                >
                    <!-- Browser Header Bar -->
                    <div class="flex items-center justify-between px-4 py-3 bg-slate-50 border-b border-slate-100 browser-glass-top shrink-0 select-none">
                        <!-- Mac style window controls -->
                        <div class="flex items-center gap-1.5 w-1/4">
                            <span class="w-2.5 h-2.5 rounded-full bg-rose-400"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                        </div>
                        <!-- URL address bar -->
                        <div class="w-2/4 max-w-md bg-white border border-slate-200/50 rounded-lg py-1 px-3 text-[10px] text-slate-400 font-mono text-center flex items-center justify-center gap-1.5 shadow-sm">
                            <svg class="w-3 h-3 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                            <span>timenest.com/dashboard</span>
                        </div>
                        <!-- Spacing block -->
                        <div class="w-1/4 flex justify-end">
                            <div class="flex gap-1.5">
                                <span class="w-3.5 h-1 bg-slate-300 rounded-sm"></span>
                                <span class="w-2 h-2 border border-slate-300 rounded-sm"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Dashboard Image Screen with Reflection Sheen -->
                    <div class="relative overflow-hidden aspect-[16/10] sm:aspect-[16/9.5] md:aspect-[16/9] lg:max-h-[500px]">
                        <img src="/images/mockups/hero-dashboard.png" alt="TimeNest Work OS Dashboard" class="w-full h-full object-cover object-top">
                        <div class="absolute inset-0 browser-sheen"></div>
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
