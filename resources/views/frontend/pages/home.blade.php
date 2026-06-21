<x-frontend-layout.app metaTitle="TimeNest — The Workforce OS Your Team Actually Uses">
<!-- SECTION 1: HERO -->
<section class="relative min-h-screen flex items-center justify-center bg-surface overflow-hidden pt-24 pb-16 lg:pt-32 lg:pb-24">
    <!-- Grid Background -->
    <div class="absolute inset-0 bg-grid z-0"></div>
    
    <!-- Top Gradient Glow -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-brand-500/20 blur-[120px] rounded-full pointer-events-none z-0"></div>

    <div class="max-w-7xl mx-auto px-6 relative z-10 w-full">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-8 items-center">
            
            <!-- Hero Text -->
            <div class="text-center lg:text-left flex flex-col items-center lg:items-start">
                <!-- Eyebrow -->
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-brand-500/30 bg-brand-500/10 text-brand-400 text-sm font-medium mb-6">
                    <span class="w-2 h-2 rounded-full bg-brand-500 animate-pulse"></span>
                    Now in Early Access &middot; Join 200+ teams
                </div>
                
                <!-- Headline -->
                <h1 class="text-display-md lg:text-display-2xl text-content-strong mb-6 leading-tight tracking-tight">
                    The Workforce OS<br/>
                    <span class="text-gradient-brand">Your Team Actually Uses</span>
                </h1>
                
                <!-- Subheadline -->
                <p class="text-lg text-content max-w-2xl mb-8 leading-relaxed">
                    TimeNest brings attendance, time logs, leaves, shifts, and AI insights into one unified platform &mdash; built for freelancers, growing teams, and enterprise organizations.
                </p>
                
                <!-- CTAs -->
                <div class="flex flex-col sm:flex-row items-center gap-4 mb-6">
                    <a href="/register" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-brand-500 hover:bg-brand-600 text-white font-semibold transition-colors shadow-lg shadow-brand-500/25 flex items-center justify-center gap-2">
                        Start Free Trial
                    </a>
                    <a href="#features-section" class="w-full sm:w-auto px-6 py-3 rounded-xl border border-surface-border text-content hover:border-brand-500 hover:text-content-strong transition-colors flex items-center justify-center gap-2 group">
                        See How It Works
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
                
                <!-- Social Proof -->
                <p class="text-sm text-content-muted flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Trusted by teams in 12+ countries &middot; No credit card required
                </p>
            </div>
            
            <!-- Visual Element (Dashboard Mockup) -->
            <div class="relative mt-8 lg:mt-0" style="perspective: 1000px;">
                <style>
                    @keyframes float-mockup {
                        0%, 100% { transform: translateY(0); }
                        50% { transform: translateY(-8px); }
                    }
                    @keyframes stagger-bar {
                        from { transform: translateY(100%); opacity: 0; }
                        to { transform: translateY(0); opacity: 1; }
                    }
                </style>
                <div class="rounded-2xl border border-surface-border glass-dark p-6 glow-brand transform transition-transform" style="animation: float-mockup 4s ease-in-out infinite;">
                    <!-- Mockup Header -->
                    <div class="flex items-center justify-between border-b border-surface-border/50 pb-4 mb-6">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-surface-border"></div>
                            <div class="w-3 h-3 rounded-full bg-surface-border"></div>
                            <div class="w-3 h-3 rounded-full bg-surface-border"></div>
                        </div>
                        <div class="text-sm font-medium text-content">TimeNest Dashboard</div>
                        <div class="w-6 h-6 rounded-full bg-brand-500/20 text-brand-400 flex items-center justify-center text-xs font-bold border border-brand-500/30">JD</div>
                    </div>
                    
                    <!-- Stat Cards -->
                    <div class="grid grid-cols-3 gap-3 mb-6">
                        <div class="bg-surface-100 border border-surface-border rounded-xl p-3">
                            <div class="text-xs text-content-muted mb-1">Present</div>
                            <div class="text-2xl font-bold text-content-strong">142</div>
                        </div>
                        <div class="bg-surface-100 border border-surface-border rounded-xl p-3">
                            <div class="text-xs text-content-muted mb-1">On Leave</div>
                            <div class="text-2xl font-bold text-content-strong">8</div>
                        </div>
                        <div class="bg-surface-100 border border-surface-border rounded-xl p-3">
                            <div class="text-xs text-content-muted mb-1">Late</div>
                            <div class="text-2xl font-bold text-content-strong">3</div>
                        </div>
                    </div>
                    
                    <!-- Chart -->
                    <div class="bg-surface-100 border border-surface-border rounded-xl p-4 h-32 flex items-end justify-between gap-2 overflow-hidden relative">
                        @php
                            $heights = ['40%', '65%', '85%', '50%', '90%', '20%', '10%'];
                            $delays = ['0s', '0.1s', '0.2s', '0.3s', '0.4s', '0.5s', '0.6s'];
                        @endphp
                        @foreach($heights as $index => $height)
                            <div class="w-full bg-brand-500 rounded-t-sm" 
                                 style="height: {{ $height }}; animation: stagger-bar 0.8s ease-out {{ $delays[$index] }} both;"></div>
                        @endforeach
                    </div>
                    
                    <!-- Bottom Row -->
                    <div class="mt-4 flex items-center justify-end gap-2 text-xs text-content-muted">
                        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                        Last sync: just now
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- SECTION 2: LOGO / TRUST BAR -->
<section class="py-10 border-y border-surface-border bg-surface-50">
    <div class="max-w-7xl mx-auto px-6">
        <p class="text-sm text-content-muted text-center mb-6">Trusted by teams at</p>
        <div class="flex flex-wrap items-center justify-center gap-8 lg:gap-16">
            <div class="text-lg font-semibold text-content-light grayscale mix-blend-luminosity">Acumen</div>
            <div class="h-4 border-r border-surface-border hidden md:block"></div>
            <div class="text-lg font-semibold text-content-light grayscale mix-blend-luminosity">Driftwork</div>
            <div class="h-4 border-r border-surface-border hidden md:block"></div>
            <div class="text-lg font-semibold text-content-light grayscale mix-blend-luminosity">Stacklane</div>
            <div class="h-4 border-r border-surface-border hidden md:block"></div>
            <div class="text-lg font-semibold text-content-light grayscale mix-blend-luminosity">Veloria</div>
            <div class="h-4 border-r border-surface-border hidden lg:block"></div>
            <div class="text-lg font-semibold text-content-light grayscale mix-blend-luminosity">Nexbridge</div>
            <div class="h-4 border-r border-surface-border hidden lg:block"></div>
            <div class="text-lg font-semibold text-content-light grayscale mix-blend-luminosity">Orbitops</div>
        </div>
    </div>
</section>

<!-- SECTION 3: PLATFORM OVERVIEW / WHAT IS TIMENEST -->
<section id="features-section" class="section-pad bg-surface relative">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-content-muted font-bold tracking-wider uppercase text-sm mb-3 block">THE PLATFORM</span>
            <h2 class="text-display-md lg:text-display-lg text-content-strong mb-6">Everything workforce. Nothing wasted.</h2>
            <p class="text-lg text-content-muted">
                One platform to manage your people, time, and operations &mdash; whether you're a solo freelancer or running a 500-person company.
            </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-6">
            <!-- Card 1 -->
            <div class="glass-dark border border-surface-border rounded-2xl p-8 hover:border-brand-500/50 transition-colors group">
                <div class="w-12 h-12 rounded-xl bg-brand-500/10 flex items-center justify-center text-brand-500 mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <h3 class="text-xl font-bold text-content-strong mb-3">Enterprise Workforce Control</h3>
                <p class="text-content-muted mb-6">Manage multi-department teams with granular role permissions, geo-fenced attendance, shift policies, and automated approval workflows.</p>
                <a href="{{ route('frontend.product.organizations') }}" class="text-brand-500 font-medium flex items-center gap-2 hover:gap-3 transition-all">
                    Explore for Organizations &rarr;
                </a>
            </div>
            
            <!-- Card 2 -->
            <div class="glass-dark border border-surface-border rounded-2xl p-8 hover:border-[#8b5cf6]/50 transition-colors group">
                <div class="w-12 h-12 rounded-xl bg-[#8b5cf6]/10 flex items-center justify-center text-[#8b5cf6] mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-content-strong mb-3">Solo &amp; Freelance Ready</h3>
                <p class="text-content-muted mb-6">Track client hours, log billable time, manage your own leave &mdash; all from one clean workspace that grows with your workload.</p>
                <a href="{{ route('frontend.product.freelancers') }}" class="text-[#8b5cf6] font-medium flex items-center gap-2 hover:gap-3 transition-all">
                    Explore for Freelancers &rarr;
                </a>
            </div>
            
            <!-- Card 3 -->
            <div class="glass-dark border border-surface-border rounded-2xl p-8 hover:border-[#f59e0b]/50 transition-colors group">
                <div class="w-12 h-12 rounded-xl bg-[#f59e0b]/10 flex items-center justify-center text-[#f59e0b] mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-content-strong mb-3">Freelance Team Workspace</h3>
                <p class="text-content-muted mb-6">Collaborate with your crew &mdash; shared attendance tracking, team timesheets, member directories, and unified reporting.</p>
                <a href="{{ route('frontend.product.workspace') }}" class="text-[#f59e0b] font-medium flex items-center gap-2 hover:gap-3 transition-all">
                    Explore Workspace &rarr;
                </a>
            </div>
        </div>
    </div>
</section>

<!-- SECTION 4: CORE FEATURES SHOWCASE -->
<section class="section-pad bg-surface-50 border-y border-surface-border overflow-hidden">
    <!-- Feature A -->
    <div class="max-w-7xl mx-auto px-6 mb-24 lg:mb-32">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
            <div class="lg:w-1/2">
                <h2 class="text-display-sm lg:text-display-md text-content-strong mb-6">Clock in. Know who's where. Always.</h2>
                <p class="text-lg text-content-muted">
                    Real-time attendance tracking with geo-fence enforcement. Set per-branch radius rules &mdash; strict block or flexible flagging. Every clock-in is stamped with location, device, and time.
                </p>
            </div>
            <div class="lg:w-1/2 w-full">
                <!-- Visual A -->
                <div class="relative w-full aspect-video md:aspect-[4/3] rounded-2xl bg-surface-100 border border-surface-border flex items-center justify-center p-8 overflow-hidden">
                    <!-- Map/Radar Base -->
                    <div class="absolute w-48 h-48 border-2 border-dashed border-brand-500/30 rounded-full animate-[spin_20s_linear_infinite]"></div>
                    <div class="absolute w-32 h-32 border border-brand-500/20 rounded-full bg-brand-500/5"></div>
                    
                    <!-- Center Pin -->
                    <div class="relative z-10 w-10 h-10 bg-brand-500 rounded-full shadow-lg shadow-brand-500/30 flex items-center justify-center mb-16 text-white">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                    </div>
                    
                    <!-- Status Card -->
                    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 bg-surface glass-dark border border-surface-border rounded-xl p-3 shadow-xl flex items-center gap-3 w-64">
                        <div>
                            <div class="text-sm font-semibold text-content-strong flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                Checked In
                            </div>
                            <div class="text-xs text-content-muted">09:02 AM &middot; Mumbai Branch</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Feature B -->
    <div class="max-w-7xl mx-auto px-6 mb-24 lg:mb-32">
        <div class="flex flex-col-reverse lg:flex-row items-center gap-12 lg:gap-20">
            <div class="lg:w-1/2 w-full">
                <!-- Visual B -->
                <div class="relative w-full aspect-video md:aspect-[4/3] rounded-2xl bg-surface-100 border border-surface-border p-8 flex flex-col justify-center">
                    <div class="grid grid-cols-7 gap-2 mb-6 max-w-sm mx-auto w-full">
                        <!-- Grid 5 rows of 7 -->
                        @for($i=1; $i<=35; $i++)
                            @php
                                $class = 'bg-surface border-surface-border';
                                if(in_array($i, [12, 13])) $class = 'bg-brand-500 border-brand-500'; // Approved
                                if($i == 19) $class = 'bg-amber-500 border-amber-500'; // Pending
                                if($i == 26) $class = 'bg-red-500 border-red-500'; // Rejected
                            @endphp
                            <div class="aspect-square rounded border {{ $class }}"></div>
                        @endfor
                    </div>
                    
                    <div class="flex items-center justify-center gap-4 text-xs font-medium">
                        <div class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-brand-500"></span> Approved</div>
                        <div class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-amber-500"></span> Pending</div>
                        <div class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-red-500"></span> Rejected</div>
                    </div>
                </div>
            </div>
            <div class="lg:w-1/2">
                <h2 class="text-display-sm lg:text-display-md text-content-strong mb-6">Leave requests that don't need chasing.</h2>
                <p class="text-lg text-content-muted">
                    Configurable leave policies per organization. Auto-approval or multi-level approval flows. Employees see their balance in real time. Managers get notified instantly.
                </p>
            </div>
        </div>
    </div>

    <!-- Feature C -->
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
            <div class="lg:w-1/2">
                <h2 class="text-display-sm lg:text-display-md text-content-strong mb-6">Your workforce data, finally making sense.</h2>
                <p class="text-lg text-content-muted">
                    TimeNest AI surfaces attendance anomalies, flags unusual patterns, forecasts leave conflicts, and gives managers the context they need &mdash; without manual reports.
                </p>
            </div>
            <div class="lg:w-1/2 w-full">
                <!-- Visual C -->
                <div class="relative w-full aspect-video md:aspect-[4/3] rounded-2xl bg-surface-100 border border-surface-border flex flex-col justify-end overflow-hidden p-6">
                    <!-- Chart Lines SVG -->
                    <svg class="absolute inset-0 w-full h-full text-brand-500/20" preserveAspectRatio="none" viewBox="0 0 100 100">
                        <path d="M0 100 L 0 60 Q 25 40, 50 70 T 100 30 L 100 100 Z" fill="currentColor"/>
                        <path d="M0 60 Q 25 40, 50 70 T 100 30" fill="none" stroke="#6366f1" stroke-width="2" vector-effect="non-scaling-stroke"/>
                    </svg>
                    
                    <!-- AI Insight Card -->
                    <div class="relative z-10 glass-dark border border-surface-border rounded-xl p-4 mb-4 ml-auto max-w-xs shadow-lg">
                        <div class="flex items-center gap-2 mb-1">
                            <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            <span class="text-xs font-bold uppercase text-brand-400">AI Insight</span>
                        </div>
                        <p class="text-sm text-content-strong">Attendance dipped 18% this Friday.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SECTION 5: FEATURE GRID (QUICK WINS) -->
<section class="section-pad bg-surface border-b border-surface-border">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <span class="text-content-muted font-bold tracking-wider uppercase text-sm mb-3 block">BUILT FOR REAL TEAMS</span>
            <h2 class="text-display-md text-content-strong">Everything you need. Nothing you don't.</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $features = [
                    ['Geo-Fence Attendance', 'Branch-level radius enforcement with strict or flexible modes.', 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z'],
                    ['Shift Management', 'Build rotating shifts, assign teams, track adherence automatically.', 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ['Leave Policies', 'Carry-forward rules, leave types, accrual logic — fully configurable.', 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                    ['Multi-Level Approvals', 'Auto, single, or multi-step approval chains per policy.', 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                    ['Employee Directory', 'Searchable org-wide directory with roles, departments, and status.', 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                    ['Time Logs', 'Billable hour tracking for freelancers and project-based teams.', 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ['Role Permissions', 'Granular permission control without writing a single line of code.', 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ['Audit Trail', 'Every action logged. Every change tracked. Full accountability.', 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01']
                ];
            @endphp
            
            @foreach($features as [$title, $body, $icon])
                <div class="p-6 rounded-xl border border-surface-border hover:border-brand-500/30 bg-surface-100 transition">
                    <svg class="w-5 h-5 text-brand-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/></svg>
                    <h3 class="font-semibold text-content-strong text-sm mb-1">{{ $title }}</h3>
                    <p class="text-content-muted text-sm">{{ $body }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- SECTION 6: AI PLATFORM TEASER -->
<section class="section-pad relative border-b border-surface-border overflow-hidden">
    <div class="absolute inset-0" style="background: radial-gradient(ellipse at 50% 0%, rgba(99,102,241,0.12) 0%, transparent 70%);"></div>
    
    <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
        <span class="text-content-muted font-bold tracking-wider uppercase text-sm mb-3 block">AI PLATFORM</span>
        <h2 class="text-display-lg text-content-strong mb-4">Your workforce, intelligently managed.</h2>
        <p class="text-lg text-content-muted mb-10 max-w-2xl mx-auto">
            TimeNest AI doesn't just show you data &mdash; it tells you what it means and what to do next.
        </p>
        
        <div class="flex overflow-x-auto pb-4 -mx-6 px-6 lg:mx-0 lg:px-0 lg:justify-center gap-3 mb-10 scrollbar-hide">
            @foreach([
                'Attendance Anomaly Detection',
                'Leave Conflict Forecasting',
                'Productivity Pattern Analysis',
                'AI Executive Dashboard',
                'Fraud Detection'
            ] as $pill)
                <div class="whitespace-nowrap px-4 py-2 rounded-full border border-surface-border bg-surface text-content text-sm flex-shrink-0">
                    {{ $pill }}
                </div>
            @endforeach
        </div>
        
        <a href="{{ route('frontend.ai') ?? '#' }}" class="inline-block px-6 py-3 rounded-xl border border-brand-500 text-brand-400 hover:bg-brand-500 hover:text-white transition-colors">
            Explore the AI Platform &rarr;
        </a>
    </div>
</section>

<!-- SECTION 7: SOCIAL PROOF / TESTIMONIALS -->
<section class="section-pad bg-surface border-b border-surface-border">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <span class="text-content-muted font-bold tracking-wider uppercase text-sm mb-3 block">WHAT TEAMS SAY</span>
            <h2 class="text-display-md text-content-strong">Built for the teams who showed up.</h2>
        </div>
        
        <div class="grid md:grid-cols-3 gap-6">
            <!-- Testimonial 1 -->
            <div class="glass-dark border border-surface-border rounded-2xl p-8 flex flex-col">
                <div class="flex gap-1 text-brand-500 mb-4">
                    @for($i=0; $i<5; $i++)
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <blockquote class="text-content italic mb-6 flex-grow text-sm">"We went from messy spreadsheets to a fully automated attendance and leave system in under a week. TimeNest just works."</blockquote>
                <div class="flex items-center gap-3 mt-auto">
                    <div class="w-10 h-10 rounded-full bg-brand-500/20 text-brand-500 flex items-center justify-center font-semibold text-sm">RS</div>
                    <div>
                        <div class="text-content-strong font-semibold text-sm">Riya Sharma</div>
                        <div class="text-xs text-content-muted">HR Manager, Acumen Corp</div>
                    </div>
                </div>
            </div>
            
            <!-- Testimonial 2 -->
            <div class="glass-dark border border-surface-border rounded-2xl p-8 flex flex-col">
                <div class="flex gap-1 text-brand-500 mb-4">
                    @for($i=0; $i<5; $i++)
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <blockquote class="text-content italic mb-6 flex-grow text-sm">"As a freelancer managing multiple clients, TimeNest's time log and workspace features saved me hours every week."</blockquote>
                <div class="flex items-center gap-3 mt-auto">
                    <div class="w-10 h-10 rounded-full bg-[#8b5cf6]/20 text-[#8b5cf6] flex items-center justify-center font-semibold text-sm">MW</div>
                    <div>
                        <div class="text-content-strong font-semibold text-sm">Marcus Webb</div>
                        <div class="text-xs text-content-muted">Independent Consultant</div>
                    </div>
                </div>
            </div>
            
            <!-- Testimonial 3 -->
            <div class="glass-dark border border-surface-border rounded-2xl p-8 flex flex-col">
                <div class="flex gap-1 text-brand-500 mb-4">
                    @for($i=0; $i<5; $i++)
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <blockquote class="text-content italic mb-6 flex-grow text-sm">"The multi-level approval workflow is exactly what our 200-person team needed. No more chasing managers on Slack."</blockquote>
                <div class="flex items-center gap-3 mt-auto">
                    <div class="w-10 h-10 rounded-full bg-[#f59e0b]/20 text-[#f59e0b] flex items-center justify-center font-semibold text-sm">PN</div>
                    <div>
                        <div class="text-content-strong font-semibold text-sm">Priya Nair</div>
                        <div class="text-xs text-content-muted">COO, Stacklane</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SECTION 8: PRICING TEASER -->
<section class="section-pad bg-surface border-b border-surface-border">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-content-muted font-bold tracking-wider uppercase text-sm mb-3 block">PRICING</span>
            <h2 class="text-display-md text-content-strong mb-4">Start free. Scale when ready.</h2>
            <p class="text-lg text-content-muted">No credit card required. No hidden fees. Full access to core features on the free plan.</p>
        </div>
        
        <div class="grid md:grid-cols-2 gap-8 max-w-3xl mx-auto mb-10">
            <!-- Free Plan -->
            <div class="border border-surface-border rounded-2xl p-8 flex flex-col bg-surface-50">
                <div class="inline-block px-3 py-1 rounded-full bg-surface-200 text-content-strong text-xs font-bold uppercase tracking-wider mb-6 w-max">Free Forever</div>
                <div class="text-4xl font-bold text-content-strong mb-6">$0<span class="text-lg text-content-muted font-normal">/month</span></div>
                <ul class="space-y-3 mb-8 flex-grow text-sm text-content">
                    @foreach(['Up to 5 members', 'Attendance & Time Logs', 'Basic Leave Management', '1 Organization'] as $item)
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-content-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ $item }}
                        </li>
                    @endforeach
                </ul>
                <a href="/register" class="block w-full py-3 px-4 rounded-xl border border-surface-border text-center text-content-strong hover:bg-surface-100 transition-colors font-medium">Get Started Free</a>
            </div>
            
            <!-- Pro Plan -->
            <div class="border border-brand-500 glow-brand-sm rounded-2xl p-8 flex flex-col bg-surface relative">
                <div class="absolute -top-3 left-1/2 -translate-x-1/2 px-3 py-1 rounded-full bg-brand-500 text-white text-xs font-bold uppercase tracking-wider">Most Popular</div>
                <div class="text-4xl font-bold text-content-strong mb-6 mt-2">$12<span class="text-lg text-content-muted font-normal">/member/month</span></div>
                <ul class="space-y-3 mb-8 flex-grow text-sm text-content">
                    @foreach(['Unlimited members', 'All Free features', 'Multi-level Approvals', 'Geo-Fence Enforcement', 'AI Workforce Insights', 'Priority Support'] as $item)
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ $item }}
                        </li>
                    @endforeach
                </ul>
                <a href="/register" class="block w-full py-3 px-4 rounded-xl bg-brand-500 text-white text-center hover:bg-brand-600 transition-colors font-medium">Start 14-Day Trial</a>
            </div>
        </div>
        
        <div class="text-center text-sm text-content-muted">
            Need enterprise? <a href="{{ route('frontend.contact') ?? '#' }}" class="text-brand-500 hover:text-brand-400">Talk to us &rarr;</a>
        </div>
    </div>
</section>

<!-- SECTION 9: FINAL CTA -->
<section class="relative py-24 overflow-hidden" style="background: linear-gradient(135deg, #312e81 0%, #1e1b4b 40%, #0a0a0f 100%);">
    <div class="absolute inset-0 bg-grid opacity-30 mix-blend-overlay"></div>
    <div class="max-w-4xl mx-auto px-6 relative z-10 text-center">
        <h2 class="text-display-lg lg:text-display-xl text-white mb-4">Your team deserves better tools.</h2>
        <p class="text-lg text-indigo-200/80 mb-10 max-w-2xl mx-auto">
            Join thousands of freelancers and teams using TimeNest to manage their workforce with clarity and confidence.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-6">
            <a href="/register" class="px-8 py-4 rounded-xl bg-white text-indigo-950 font-semibold text-base hover:bg-indigo-50 transition-colors">
                Start Free &mdash; No Card Needed
            </a>
            <a href="{{ route('frontend.book-demo') ?? '#' }}" class="px-8 py-4 rounded-xl border border-white/30 text-white font-medium hover:bg-white/10 transition-colors">
                Book a Demo
            </a>
        </div>
        <div class="flex flex-wrap justify-center items-center gap-4 text-xs text-indigo-300">
            <span class="flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Free plan forever</span>
            <span class="flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Setup in under 5 minutes</span>
            <span class="flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Cancel anytime</span>
        </div>
    </div>
</section>
</x-frontend-layout.app>
