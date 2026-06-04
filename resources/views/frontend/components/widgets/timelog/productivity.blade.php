<section class="py-16 lg:py-24 bg-slate-50 relative border-y border-slate-200 overflow-hidden" id="timelog">
    <div class="absolute inset-0 bg-gradient-to-br from-white/60 via-slate-50/50 to-white/60 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20 items-start">

            <!-- Left Side: Widget Stack -->
            <div class="lg:col-span-7 space-y-6 order-2 lg:order-1">

                {{-- ═══════════════════════════════════ --}}
                {{-- Widget A: Today's Worklogs Dashboard --}}
                {{-- ═══════════════════════════════════ --}}
                <div class="bg-white rounded-3xl border border-slate-200 shadow-lg shadow-slate-200/50 relative overflow-hidden"
                     x-data="{ loaded: false }" x-init="setTimeout(() => { loaded = true }, 500)">

                    <!-- Header -->
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-indigo-50 flex items-center justify-center">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <h5 class="font-display font-semibold text-slate-900 text-sm">Today's Worklogs</h5>
                        </div>
                        <span class="text-xs font-bold font-mono text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-100">8h 20m logged</span>
                    </div>

                    <!-- Project Worklogs -->
                    <div class="px-6 py-6 space-y-4">
                        <!-- Project 1 -->
                        <div class="p-4 rounded-xl border border-slate-100 bg-slate-50/50">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-2.5 h-2.5 rounded-full bg-indigo-500"></div>
                                    <div>
                                        <h6 class="font-bold text-slate-800 text-sm">Website Redesign</h6>
                                        <p class="text-[10px] text-slate-400 font-mono mt-0.5">Frontend Task</p>
                                    </div>
                                </div>
                                <span class="text-xs font-mono font-bold text-indigo-600">4h 00m</span>
                            </div>
                            <div class="w-full h-1.5 bg-slate-200 rounded-full overflow-hidden">
                                <div class="h-full bg-indigo-500 rounded-full transition-all duration-[2000ms] ease-out" :style="loaded ? 'width: 48%' : 'width: 0%'"></div>
                            </div>
                        </div>

                        <!-- Project 2 -->
                        <div class="p-4 rounded-xl border border-slate-100 bg-slate-50/50">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>
                                    <div>
                                        <h6 class="font-bold text-slate-800 text-sm">API Development</h6>
                                        <p class="text-[10px] text-slate-400 font-mono mt-0.5">Backend Task</p>
                                    </div>
                                </div>
                                <span class="text-xs font-mono font-bold text-emerald-600">3h 00m</span>
                            </div>
                            <div class="w-full h-1.5 bg-slate-200 rounded-full overflow-hidden">
                                <div class="h-full bg-emerald-500 rounded-full transition-all duration-[2000ms] ease-out delay-200" :style="loaded ? 'width: 36%' : 'width: 0%'"></div>
                            </div>
                        </div>

                        <!-- Project 3 -->
                        <div class="p-4 rounded-xl border border-slate-100 bg-slate-50/50">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-2.5 h-2.5 rounded-full bg-amber-400"></div>
                                    <div>
                                        <h6 class="font-bold text-slate-800 text-sm">Meetings & Standups</h6>
                                        <p class="text-[10px] text-slate-400 font-mono mt-0.5">Internal</p>
                                    </div>
                                </div>
                                <span class="text-xs font-mono font-bold text-amber-600">1h 20m</span>
                            </div>
                            <div class="w-full h-1.5 bg-slate-200 rounded-full overflow-hidden">
                                <div class="h-full bg-amber-400 rounded-full transition-all duration-[2000ms] ease-out delay-[400ms]" :style="loaded ? 'width: 16%' : 'width: 0%'"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Compliance Footer -->
                    <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-5 text-[11px]">
                            <span class="text-slate-400">Required: <span class="font-bold text-slate-700">8h</span></span>
                            <span class="text-slate-400">Completed: <span class="font-bold text-emerald-600">8h 20m</span></span>
                        </div>
                        <span class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-100">Compliant ✓</span>
                    </div>
                </div>

                {{-- ═══════════════════════════════════ --}}
                {{-- Widget B: Timesheet Approval Pipeline --}}
                {{-- ═══════════════════════════════════ --}}
                <div class="bg-white rounded-3xl border border-slate-200 shadow-lg shadow-slate-200/50 p-6"
                     x-data="{ step: 1 }" x-init="setInterval(() => { step = step >= 4 ? 1 : step + 1 }, 3000)">
                    <h5 class="font-display font-semibold text-slate-900 text-sm mb-6 flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        </div>
                        Timesheet Approval Lifecycle
                    </h5>

                    <!-- Fixed height horizontal pipeline -->
                    <div class="relative" style="min-height: 72px;">
                        <div class="flex items-start justify-between relative">
                            <!-- Connecting line -->
                            <div class="absolute top-4 left-0 right-0 h-0.5 bg-slate-100 pointer-events-none"></div>
                            <div class="absolute top-4 left-0 h-0.5 bg-indigo-500 transition-all duration-1000 ease-out pointer-events-none" :style="`width: ${(step - 1) * 33.33}%`"></div>

                            <!-- Draft -->
                            <div class="flex flex-col items-center gap-2 relative z-10">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center transition-all duration-500"
                                     :class="step >= 1 ? 'bg-indigo-500 text-white shadow-md' : 'bg-slate-200 text-slate-400'">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </div>
                                <span class="text-[11px] font-semibold transition-colors duration-500" :class="step >= 1 ? 'text-indigo-600' : 'text-slate-400'">Draft</span>
                            </div>
                            <!-- Submitted -->
                            <div class="flex flex-col items-center gap-2 relative z-10">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center transition-all duration-500"
                                     :class="step >= 2 ? (step === 2 ? 'bg-amber-400 text-white ring-4 ring-amber-50 scale-110' : 'bg-indigo-500 text-white shadow-md') : 'bg-slate-200 text-slate-400'">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                </div>
                                <span class="text-[11px] font-semibold transition-colors duration-500" :class="step === 2 ? 'text-amber-500' : (step > 2 ? 'text-indigo-600' : 'text-slate-400')">Submitted</span>
                            </div>
                            <!-- Reviewing -->
                            <div class="flex flex-col items-center gap-2 relative z-10">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center transition-all duration-500"
                                     :class="step >= 3 ? (step === 3 ? 'bg-indigo-500 text-white ring-4 ring-indigo-50 scale-110' : 'bg-indigo-500 text-white shadow-md') : 'bg-slate-200 text-slate-400'">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <span class="text-[11px] font-semibold transition-colors duration-500" :class="step === 3 ? 'text-indigo-500' : (step > 3 ? 'text-indigo-600' : 'text-slate-400')">Reviewing</span>
                            </div>
                            <!-- Approved -->
                            <div class="flex flex-col items-center gap-2 relative z-10">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center transition-all duration-500"
                                     :class="step >= 4 ? 'bg-emerald-500 text-white shadow-[0_0_15px_rgba(16,185,129,0.3)] scale-110' : 'bg-white border-2 border-slate-200 text-slate-300'">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </div>
                                <span class="text-[11px] font-bold transition-colors duration-500" :class="step >= 4 ? 'text-emerald-600' : 'text-slate-400'">Locked</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Side: Content (sticky) -->
            <div class="lg:col-span-5 lg:sticky lg:top-28 lg:self-start order-1 lg:order-2">
                <x-frontend-base.badge variant="accent" class="mb-5">Productivity Logs & Compliance</x-frontend-base.badge>
                <h2 class="font-display text-4xl lg:text-5xl font-bold text-slate-900 tracking-tight mb-5">
                    Connect time spent to <span class="text-indigo-600">actual outcomes.</span>
                </h2>
                <p class="text-lg text-slate-600 font-body mb-10 leading-relaxed">
                    Stop guessing where the hours go. Map worklogs directly to projects, milestones, and tasks. Our timesheet lifecycle ensures accurate data from drafting to locked approvals.
                </p>

                <ul class="space-y-5">
                    <li class="flex items-start gap-3.5 text-slate-700 font-medium">
                        <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        Project & task level granularity
                    </li>
                    <li class="flex items-start gap-3.5 text-slate-700 font-medium">
                        <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        Multi-tier approval workflows
                    </li>
                    <li class="flex items-start gap-3.5 text-slate-700 font-medium">
                        <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        Automatic lock on payroll generation
                    </li>
                    <li class="flex items-start gap-3.5 text-slate-700 font-medium">
                        <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        Compliance validation & overtime tracking
                    </li>
                </ul>

                <!-- CTA -->
                <div class="mt-10 flex flex-wrap items-center gap-4">
                    <button @click="$dispatch('open-book-demo')" class="inline-flex items-center gap-2 px-6 py-3 bg-slate-900 text-white text-sm font-bold rounded-xl hover:bg-slate-800 transition-all shadow-md shadow-slate-900/10 group">
                        See it in action
                        <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </button>
                    <a href="/solutions/timelog" class="text-sm font-semibold text-slate-500 hover:text-indigo-600 transition-colors">Learn more →</a>
                </div>

                <!-- Trust strip -->
                <div class="mt-10 pt-8 border-t border-slate-100">
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <p class="text-2xl font-bold font-display text-slate-900">4<span class="text-base text-slate-400">-tier</span></p>
                            <p class="text-[11px] text-slate-400 font-medium mt-1">Approval depth</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold font-display text-slate-900">Auto</p>
                            <p class="text-[11px] text-slate-400 font-medium mt-1">Payroll lock</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold font-display text-slate-900">100<span class="text-base text-slate-400">%</span></p>
                            <p class="text-[11px] text-slate-400 font-medium mt-1">Audit trail</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
