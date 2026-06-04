<section class="py-16 lg:py-24 bg-white relative border-y border-slate-100 overflow-hidden" id="projects">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20 items-start">

            <!-- Left Side: Content -->
            <div class="lg:col-span-5 lg:sticky lg:top-28 lg:self-start">
                <x-frontend-base.badge variant="accent" class="mb-5">Projects & Deadlines</x-frontend-base.badge>
                <h2 class="font-display text-4xl lg:text-5xl font-bold text-slate-900 tracking-tight mb-5">
                    Where time meets <span class="text-indigo-600">deliverables.</span>
                </h2>
                <p class="text-lg text-slate-600 font-body mb-10 leading-relaxed">
                    Connect employee productivity directly to project milestones. Track estimates against actuals, and ensure deadlines are met with full visibility.
                </p>

                <ul class="space-y-5">
                    <li class="flex items-start gap-3.5 text-slate-700 font-medium">
                        <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        Project → Milestone → Task hierarchy
                    </li>
                    <li class="flex items-start gap-3.5 text-slate-700 font-medium">
                        <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        Deadline tracking with status indicators
                    </li>
                    <li class="flex items-start gap-3.5 text-slate-700 font-medium">
                        <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        Estimate vs actual time comparison
                    </li>
                    <li class="flex items-start gap-3.5 text-slate-700 font-medium">
                        <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        Worklog-to-task mapping
                    </li>
                    <li class="flex items-start gap-3.5 text-slate-700 font-medium">
                        <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        Progress visualization per milestone
                    </li>
                </ul>

                <!-- CTA -->
                <div class="mt-10 flex flex-wrap items-center gap-4">
                    <button @click="$dispatch('open-book-demo')" class="inline-flex items-center gap-2 px-6 py-3 bg-slate-900 text-white text-sm font-bold rounded-xl hover:bg-slate-800 transition-all shadow-md shadow-slate-900/10 group">
                        See it in action
                        <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </button>
                    <a href="/solutions/projects" class="text-sm font-semibold text-slate-500 hover:text-indigo-600 transition-colors">Learn more →</a>
                </div>

                <!-- Trust strip -->
                <div class="mt-10 pt-8 border-t border-slate-100">
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <p class="text-2xl font-bold font-display text-slate-900">3<span class="text-base text-slate-400">-level</span></p>
                            <p class="text-[11px] text-slate-400 font-medium mt-1">Hierarchy</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold font-display text-slate-900">Live</p>
                            <p class="text-[11px] text-slate-400 font-medium mt-1">Progress</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold font-display text-slate-900">Est<span class="text-base text-slate-400">vs</span>Act</p>
                            <p class="text-[11px] text-slate-400 font-medium mt-1">Comparison</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Project Widgets -->
            <div class="lg:col-span-7 space-y-6">

                {{-- ═══════════════════════════════════ --}}
                {{-- Widget A: Project Card              --}}
                {{-- ═══════════════════════════════════ --}}
                <div class="bg-white rounded-3xl border border-slate-200 shadow-lg shadow-slate-200/50 relative overflow-hidden"
                     x-data="{ loaded: false }" x-init="setTimeout(() => { loaded = true }, 600)">

                    <!-- Header -->
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-indigo-50 flex items-center justify-center">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                            </div>
                            <h5 class="font-display font-semibold text-slate-900 text-sm">Mobile App v2.0</h5>
                        </div>
                        <span class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-100">On Track</span>
                    </div>

                    <div class="px-6 py-6">
                        <!-- Milestone -->
                        <div class="mb-6">
                            <div class="flex items-center gap-2 mb-1">
                                <svg class="w-3.5 h-3.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/></svg>
                                <span class="text-[11px] text-slate-400 font-mono uppercase tracking-wider">Milestone</span>
                            </div>
                            <h6 class="text-sm font-bold text-slate-800">Authentication Module</h6>
                        </div>

                        <!-- Task: Login API -->
                        <div class="p-5 rounded-xl border border-slate-100 bg-slate-50/50 mb-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-7 h-7 rounded-lg bg-indigo-50 flex items-center justify-center">
                                        <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    </div>
                                    <div>
                                        <h6 class="text-sm font-bold text-slate-800">Login API Integration</h6>
                                        <p class="text-[10px] text-slate-400 font-mono mt-0.5">Task · In Progress</p>
                                    </div>
                                </div>
                                <span class="text-lg font-bold font-display text-indigo-600">75%</span>
                            </div>

                            <!-- Progress bar -->
                            <div class="w-full h-2 bg-slate-200 rounded-full overflow-hidden mb-4">
                                <div class="h-full bg-gradient-to-r from-indigo-500 to-indigo-400 rounded-full transition-all duration-[2500ms] ease-out" :style="loaded ? 'width: 75%' : 'width: 0%'"></div>
                            </div>

                            <!-- Stats row -->
                            <div class="flex items-center justify-between text-[11px]">
                                <div class="flex items-center gap-4">
                                    <span class="text-slate-400">Estimated: <span class="font-bold text-slate-700">12h</span></span>
                                    <span class="text-slate-400">Logged: <span class="font-bold text-indigo-600">9h</span></span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span class="text-slate-400">Deadline: <span class="font-bold text-slate-700">June 25</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ═══════════════════════════════════ --}}
                {{-- Widgets B & C: Tasks + Estimate     --}}
                {{-- ═══════════════════════════════════ --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                    <!-- Widget B: Task Hierarchy -->
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-lg shadow-slate-200/50 p-6">
                        <h5 class="font-display font-semibold text-slate-900 text-sm mb-5 flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                            </div>
                            Task Hierarchy
                        </h5>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between px-3 py-2.5 rounded-xl bg-emerald-50/50 border border-emerald-100/50">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-5 h-5 rounded-md bg-emerald-100 flex items-center justify-center">
                                        <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span class="text-xs font-bold text-slate-700">Login API</span>
                                </div>
                                <span class="text-[10px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">75%</span>
                            </div>
                            <div class="flex items-center justify-between px-3 py-2.5 rounded-xl bg-indigo-50/50 border border-indigo-100/50">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-5 h-5 rounded-md bg-indigo-100 flex items-center justify-center">
                                        <div class="w-2 h-2 rounded-full bg-indigo-400 animate-pulse"></div>
                                    </div>
                                    <span class="text-xs font-bold text-slate-700">OAuth Setup</span>
                                </div>
                                <span class="text-[10px] font-semibold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-md">40%</span>
                            </div>
                            <div class="flex items-center justify-between px-3 py-2.5 rounded-xl bg-slate-50 border border-slate-100">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-5 h-5 rounded-md bg-slate-100 flex items-center justify-center">
                                        <div class="w-2 h-2 rounded-full bg-slate-300"></div>
                                    </div>
                                    <span class="text-xs font-bold text-slate-700">Session Mgmt</span>
                                </div>
                                <span class="text-[10px] font-semibold text-slate-400 bg-slate-50 px-2 py-0.5 rounded-md">0%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Widget C: Estimate vs Actual -->
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-lg shadow-slate-200/50 p-6"
                         x-data="{ loaded: false }" x-init="setTimeout(() => { loaded = true }, 800)">
                        <h5 class="font-display font-semibold text-slate-900 text-sm mb-5 flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            </div>
                            Estimate vs Actual
                        </h5>

                        <div class="space-y-5">
                            <!-- Estimated -->
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-[11px] text-slate-400 font-medium">Estimated</span>
                                    <span class="text-xs font-bold font-mono text-slate-700">12h</span>
                                </div>
                                <div class="w-full h-2 bg-slate-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-slate-400 rounded-full transition-all duration-[2000ms] ease-out" :style="loaded ? 'width: 100%' : 'width: 0%'"></div>
                                </div>
                            </div>

                            <!-- Actual -->
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-[11px] text-slate-400 font-medium">Actual</span>
                                    <span class="text-xs font-bold font-mono text-indigo-600">9h</span>
                                </div>
                                <div class="w-full h-2 bg-slate-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-indigo-500 rounded-full transition-all duration-[2000ms] ease-out delay-300" :style="loaded ? 'width: 75%' : 'width: 0%'"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Summary -->
                        <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-[11px] text-slate-400 font-medium">3h remaining</span>
                            <span class="text-[11px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">On schedule</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
