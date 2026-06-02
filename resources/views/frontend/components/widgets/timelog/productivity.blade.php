<section class="py-16 lg:py-24 bg-slate-50 relative border-y border-slate-200 overflow-hidden" id="timelog">
    <!-- Background Design Details -->
    <div class="absolute inset-0 bg-gradient-to-br from-white/60 via-slate-50/50 to-white/60 pointer-events-none"></div>
    <div class="absolute top-1/2 left-0 w-96 h-96 bg-brand-500/5 rounded-full blur-3xl -translate-y-1/2 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            
            <!-- Left Side: Visuals & Widgets -->
            <div class="relative order-2 lg:order-1">
                <!-- Large Background Card -->
                <div class="absolute inset-0 bg-gradient-to-br from-white to-slate-50 border border-slate-200 rounded-3xl transform rotate-2 scale-[1.03] opacity-60 pointer-events-none shadow-sm"></div>
                
                <div class="relative bg-white rounded-3xl border border-slate-200 shadow-md p-6 sm:p-8 flex flex-col gap-8">
                    
                    <!-- Today's Productivity -->
                    <div x-data="{ loaded: false, timeA: 0, timeB: 0 }" x-init="setTimeout(() => { loaded = true; let i = setInterval(() => { if(timeA < 240) timeA+=5; if(timeB < 180) timeB+=5; if(timeA >= 240 && timeB >= 180) clearInterval(i); }, 20); }, 500)">
                        <div class="flex items-center justify-between mb-6 border-b border-slate-100 pb-4">
                            <h5 class="font-display font-bold text-slate-900 flex items-center gap-2">
                                <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Today's Worklogs
                            </h5>
                            <span class="text-xs font-bold font-mono text-emerald-600 uppercase tracking-wider bg-emerald-50 px-2 py-1 rounded">8h 20m logged</span>
                        </div>
                        
                        <div class="space-y-4">
                            <!-- Project A -->
                            <div class="group flex flex-col p-4 rounded-xl border border-slate-100 bg-slate-50 hover:-translate-y-0.5 hover:bg-white hover:border-slate-200 hover:shadow-md transition-all duration-300">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></div>
                                        <div>
                                            <h6 class="font-bold text-slate-900 text-sm group-hover:text-indigo-600 transition-colors">Project A: Core Platform</h6>
                                        </div>
                                    </div>
                                    <span class="text-xs font-mono font-bold text-indigo-600" x-text="Math.floor(timeA/60) + 'h ' + (timeA%60 < 10 ? '0' : '') + (timeA%60) + 'm'"></span>
                                </div>
                                <div class="w-full h-1.5 bg-slate-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-indigo-500 rounded-full transition-all duration-[2000ms] ease-out" :style="loaded ? 'width: 55%' : 'width: 0%'"></div>
                                </div>
                            </div>
                            
                            <!-- Project B -->
                            <div class="group flex flex-col p-4 rounded-xl border border-slate-100 bg-slate-50 hover:-translate-y-0.5 hover:bg-white hover:border-slate-200 hover:shadow-md transition-all duration-300">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                                        <div>
                                            <h6 class="font-bold text-slate-900 text-sm group-hover:text-emerald-600 transition-colors">Project B: Mobile App</h6>
                                        </div>
                                    </div>
                                    <span class="text-xs font-mono font-bold text-emerald-600" x-text="Math.floor(timeB/60) + 'h ' + (timeB%60 < 10 ? '0' : '') + (timeB%60) + 'm'"></span>
                                </div>
                                <div class="w-full h-1.5 bg-slate-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-emerald-500 rounded-full transition-all duration-[2000ms] ease-out delay-300" :style="loaded ? 'width: 40%' : 'width: 0%'"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Approval Lifecycle -->
                    <div class="pt-6 border-t border-slate-100" x-data="{ step: 1 }" x-init="setInterval(() => { step = step >= 4 ? 1 : step + 1 }, 2500)">
                        <h5 class="font-display font-semibold text-sm text-slate-900 mb-6 uppercase tracking-wider font-mono">Timesheet Approval Lifecycle</h5>
                        <div class="flex items-center justify-between relative text-xs">
                            <!-- Line connecting statuses -->
                            <div class="absolute top-4 left-0 right-0 h-0.5 bg-slate-100 pointer-events-none -z-10"></div>
                            <div class="absolute top-4 left-0 h-0.5 bg-brand-500 transition-all duration-1000 ease-in-out pointer-events-none -z-10" :style="`width: ${(step - 1) * 33.33}%`"></div>
                            
                            <!-- Draft -->
                            <div class="flex flex-col items-center gap-2 transition-all duration-500" :class="step >= 1 ? 'opacity-100' : 'opacity-50'">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold transition-all duration-500" :class="step >= 1 ? 'bg-brand-500 text-white shadow-md' : 'bg-slate-200 text-slate-400'">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span class="font-semibold transition-colors duration-500" :class="step >= 1 ? 'text-brand-600' : 'text-slate-400'">Draft</span>
                            </div>
                            <!-- Submitted -->
                            <div class="flex flex-col items-center gap-2 transition-all duration-500" :class="step >= 2 ? 'opacity-100' : 'opacity-50'">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold transition-all duration-500" :class="step === 2 ? 'bg-amber-400 text-white ring-4 ring-amber-50 scale-110' : (step > 2 ? 'bg-brand-500 text-white shadow-md' : 'bg-slate-200 text-slate-400')">
                                    <svg class="w-4 h-4" :class="step === 2 ? 'animate-pulse' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span class="font-semibold transition-colors duration-500" :class="step === 2 ? 'text-amber-500' : (step > 2 ? 'text-brand-600' : 'text-slate-400')">Submitted</span>
                            </div>
                            <!-- Manager Review -->
                            <div class="flex flex-col items-center gap-2 transition-all duration-500" :class="step >= 3 ? 'opacity-100' : 'opacity-50'">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold transition-all duration-500" :class="step === 3 ? 'bg-indigo-500 text-white ring-4 ring-indigo-50 scale-110' : (step > 3 ? 'bg-brand-500 text-white shadow-md' : 'bg-slate-200 text-slate-400')">
                                    <svg class="w-4 h-4" :class="step === 3 ? 'animate-ping opacity-50 absolute' : 'hidden'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <svg class="w-4 h-4 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <span class="font-semibold transition-colors duration-500" :class="step === 3 ? 'text-indigo-500' : (step > 3 ? 'text-brand-600' : 'text-slate-400')">Reviewing</span>
                            </div>
                            <!-- Approved -->
                            <div class="flex flex-col items-center gap-2 transition-all duration-500" :class="step >= 4 ? 'opacity-100' : 'opacity-50'">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold transition-all duration-500" :class="step >= 4 ? 'bg-emerald-500 text-white shadow-[0_0_15px_rgba(16,185,129,0.3)] scale-110' : 'bg-white border-2 border-slate-200 text-slate-300'">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span class="font-bold transition-colors duration-500" :class="step >= 4 ? 'text-emerald-600' : 'text-slate-400'">Approved</span>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            
            <!-- Right Side: Content -->
            <div class="order-1 lg:order-2">
                <x-frontend-base.badge variant="accent" class="mb-4">Timelog & Productivity</x-frontend-base.badge>
                <h2 class="font-display text-4xl lg:text-5xl font-bold text-slate-900 tracking-tight mb-6">
                    Connect time spent to <span class="text-brand-500">actual outcomes.</span>
                </h2>
                <p class="text-lg text-slate-600 font-body mb-8 leading-relaxed">
                    Stop guessing where the hours go. Map worklogs directly to projects, milestones, and tasks. Our timesheet lifecycle ensures accurate data from drafting to locked approvals.
                </p>
                
                <ul class="space-y-4 mb-8">
                    <li class="flex items-start gap-3 text-slate-700 font-medium">
                        <svg class="w-6 h-6 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Project & Task level granularity
                    </li>
                    <li class="flex items-start gap-3 text-slate-700 font-medium">
                        <svg class="w-6 h-6 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Multi-tier approval workflows
                    </li>
                    <li class="flex items-start gap-3 text-slate-700 font-medium">
                        <svg class="w-6 h-6 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Automatic lock on payroll generation
                    </li>
                </ul>
            </div>
            
        </div>
    </div>
</section>
