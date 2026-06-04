<section class="py-16 lg:py-24 bg-white relative border-y border-slate-100 overflow-hidden" id="leave-management">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20 items-start">

            <!-- Left Side: Content -->
            <div class="lg:col-span-5 lg:sticky lg:top-28 lg:self-start">
                <x-frontend-base.badge variant="accent" class="mb-5">Leave & Workforce Availability</x-frontend-base.badge>
                <h2 class="font-display text-4xl lg:text-5xl font-bold text-slate-900 tracking-tight mb-5">
                    Requests that <span class="text-indigo-600">update your engine</span> automatically.
                </h2>
                <p class="text-lg text-slate-600 font-body mb-10 leading-relaxed">
                    When a Work From Home or Extra Working Day request is approved, TimeNest automatically adjusts the employee's attendance rules for that specific day.
                </p>

                <ul class="space-y-5">
                    <li class="flex items-start gap-3.5 text-slate-700 font-medium">
                        <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        WFH auto-adjusts geo-fence rules
                    </li>
                    <li class="flex items-start gap-3.5 text-slate-700 font-medium">
                        <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        EWD enables weekend/holiday clock-in
                    </li>
                    <li class="flex items-start gap-3.5 text-slate-700 font-medium">
                        <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        Standard leaves prevent false absences
                    </li>
                    <li class="flex items-start gap-3.5 text-slate-700 font-medium">
                        <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        Half-day & emergency handling
                    </li>
                    <li class="flex items-start gap-3.5 text-slate-700 font-medium">
                        <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        Team calendar synchronization
                    </li>
                </ul>

                <!-- CTA -->
                <div class="mt-10 flex flex-wrap items-center gap-4">
                    <button @click="$dispatch('open-book-demo')" class="inline-flex items-center gap-2 px-6 py-3 bg-slate-900 text-white text-sm font-bold rounded-xl hover:bg-slate-800 transition-all shadow-md shadow-slate-900/10 group">
                        See it in action
                        <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </button>
                    <a href="/solutions/leave" class="text-sm font-semibold text-slate-500 hover:text-indigo-600 transition-colors">Learn more →</a>
                </div>

                <!-- Trust strip -->
                <div class="mt-10 pt-8 border-t border-slate-100">
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <p class="text-2xl font-bold font-display text-slate-900">6</p>
                            <p class="text-[11px] text-slate-400 font-medium mt-1">Leave types</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold font-display text-slate-900">Auto</p>
                            <p class="text-[11px] text-slate-400 font-medium mt-1">Engine sync</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold font-display text-slate-900">Real<span class="text-base text-slate-400">time</span></p>
                            <p class="text-[11px] text-slate-400 font-medium mt-1">Calendar</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Workflow Simulation Widgets -->
            <div class="lg:col-span-7 space-y-6">

                {{-- ═══════════════════════════════════════ --}}
                {{-- Widget A: WFH Leave Pipeline           --}}
                {{-- ═══════════════════════════════════════ --}}
                <div class="bg-white rounded-3xl border border-slate-200 shadow-lg shadow-slate-200/50 relative overflow-hidden"
                     x-data="{ step: 0 }" x-init="setInterval(() => { step = step >= 4 ? 0 : step + 1 }, 3000)">

                    <!-- Header Bar -->
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-indigo-50 flex items-center justify-center">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <h5 class="font-display font-semibold text-slate-900 text-sm">WFH Request Pipeline</h5>
                        </div>
                        <div class="flex items-center gap-2.5 px-3 py-1.5 rounded-full transition-all duration-500"
                             :class="step >= 4 ? 'bg-emerald-50' : (step >= 1 ? 'bg-indigo-50' : 'bg-slate-50')">
                            <div class="w-2 h-2 rounded-full transition-all duration-500"
                                 :class="step >= 4 ? 'bg-emerald-500' : (step >= 1 ? 'bg-indigo-400 animate-pulse' : 'bg-slate-300')"></div>
                            <span class="text-[11px] font-mono font-semibold transition-all duration-500"
                                  :class="step >= 4 ? 'text-emerald-600' : (step >= 1 ? 'text-indigo-500' : 'text-slate-400')"
                                  x-text="step >= 4 ? 'Completed' : (step >= 1 ? 'Processing...' : 'Idle')"></span>
                        </div>
                    </div>

                    <!-- Employee Info -->
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-3.5">
                            <img src="https://ui-avatars.com/api/?name=Sarah+Chen&background=4f46e5&color=fff&size=64&font-size=0.38&bold=true&format=svg" alt="Sarah Chen" class="w-9 h-9 rounded-full object-cover shadow-md shadow-indigo-500/20 ring-2 ring-white">
                            <div>
                                <p class="text-sm font-bold text-slate-800 leading-snug">Sarah Chen</p>
                                <p class="text-[11px] text-slate-400 font-mono mt-0.5">Product Design · Remote</p>
                            </div>
                        </div>
                        <span class="text-xs font-semibold px-3 py-1.5 rounded-lg transition-all duration-500"
                              :class="step >= 4 ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-slate-100 text-slate-500 border border-slate-200'"
                              x-text="step >= 4 ? 'Approved ✓' : 'WFH · Fri, June 6'"></span>
                    </div>

                    <!-- 4-Step Pipeline -->
                    <div class="px-6 py-8" style="min-height: 380px;">
                        <div class="relative">
                            <!-- Connector Line -->
                            <div class="absolute left-[17px] top-6 bottom-6 w-0.5 bg-slate-100 rounded-full">
                                <div class="absolute top-0 left-0 w-full rounded-full bg-gradient-to-b from-indigo-400 to-emerald-400 transition-all duration-1000 ease-out"
                                     :style="`height: ${step >= 4 ? 100 : step >= 3 ? 72 : step >= 2 ? 44 : step >= 1 ? 16 : 0}%`"></div>
                            </div>

                            <div class="space-y-8">
                                <!-- Step 1: Leave Request -->
                                <div class="flex items-start gap-5 relative">
                                    <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 relative z-10 transition-all duration-500 border-2"
                                         :class="step >= 1 ? (step === 1 ? 'bg-indigo-50 border-indigo-400 shadow-[0_0_16px_rgba(99,102,241,0.2)]' : 'bg-indigo-500 border-indigo-500 shadow-md shadow-indigo-200') : 'bg-white border-slate-200'">
                                        <svg x-show="step < 2" class="w-4 h-4 transition-colors duration-500" :class="step >= 1 ? 'text-indigo-500' : 'text-slate-300'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <svg x-show="step >= 2" class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <div class="flex-grow min-w-0 pt-1">
                                        <div class="flex items-center justify-between mb-2">
                                            <h6 class="text-sm font-bold text-slate-800">Leave Request Filed</h6>
                                            <span x-show="step === 1" class="text-[10px] font-mono text-amber-600 bg-amber-50 px-2 py-0.5 rounded-md animate-pulse font-semibold">Pending</span>
                                            <span x-show="step >= 2" class="text-[10px] font-mono text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md font-semibold">Submitted ✓</span>
                                            <span x-show="step < 1" class="text-[10px] font-mono text-slate-300">Waiting...</span>
                                        </div>
                                        <div class="flex items-center gap-3 text-[11px] transition-colors duration-300"
                                             :class="step >= 1 ? 'text-slate-500' : 'text-slate-300'">
                                            <span>Type: <span class="font-bold" :class="step >= 1 ? 'text-slate-700' : 'text-slate-300'">WFH</span></span>
                                            <span>Date: <span class="font-bold" :class="step >= 1 ? 'text-slate-700' : 'text-slate-300'">Fri, June 6</span></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 2: Manager Review -->
                                <div class="flex items-start gap-5 relative">
                                    <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 relative z-10 transition-all duration-500 border-2"
                                         :class="step >= 2 ? (step === 2 ? 'bg-amber-50 border-amber-400 shadow-[0_0_16px_rgba(245,158,11,0.2)]' : 'bg-indigo-500 border-indigo-500 shadow-md shadow-indigo-200') : 'bg-white border-slate-200'">
                                        <svg x-show="step < 3" class="w-4 h-4 transition-colors duration-500" :class="step >= 2 ? 'text-amber-500' : 'text-slate-300'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <svg x-show="step >= 3" class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <div class="flex-grow min-w-0 pt-1">
                                        <div class="flex items-center justify-between mb-2">
                                            <h6 class="text-sm font-bold text-slate-800">Manager Review</h6>
                                            <span x-show="step === 2" class="text-[10px] font-mono text-amber-600 bg-amber-50 px-2 py-0.5 rounded-md animate-pulse font-semibold">Reviewing...</span>
                                            <span x-show="step >= 3" class="text-[10px] font-mono text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md font-semibold">Availability OK ✓</span>
                                            <span x-show="step < 2" class="text-[10px] font-mono text-slate-300">Waiting...</span>
                                        </div>
                                        <div class="flex items-center gap-3 text-[11px] transition-colors duration-300"
                                             :class="step >= 2 ? 'text-slate-500' : 'text-slate-300'">
                                            <span>Checking: <span class="font-bold" :class="step >= 2 ? 'text-slate-700' : 'text-slate-300'">Availability & Policy</span></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 3: Approved -->
                                <div class="flex items-start gap-5 relative">
                                    <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 relative z-10 transition-all duration-500 border-2"
                                         :class="step >= 3 ? (step === 3 ? 'bg-emerald-50 border-emerald-400 shadow-[0_0_16px_rgba(16,185,129,0.2)]' : 'bg-emerald-500 border-emerald-500 shadow-md shadow-emerald-200') : 'bg-white border-slate-200'">
                                        <svg x-show="step < 4" class="w-4 h-4 transition-colors duration-500" :class="step >= 3 ? 'text-emerald-500' : 'text-slate-300'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        <svg x-show="step >= 4" class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <div class="flex-grow min-w-0 pt-1">
                                        <div class="flex items-center justify-between mb-2">
                                            <h6 class="text-sm font-bold text-slate-800">Request Approved</h6>
                                            <span x-show="step === 3" class="text-[10px] font-mono text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md animate-pulse font-semibold">Syncing...</span>
                                            <span x-show="step >= 4" class="text-[10px] font-mono text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md font-semibold">Done ✓</span>
                                            <span x-show="step < 3" class="text-[10px] font-mono text-slate-300">Waiting...</span>
                                        </div>
                                        <div class="flex items-center gap-3 text-[11px] transition-colors duration-300"
                                             :class="step >= 3 ? 'text-slate-500' : 'text-slate-300'">
                                            <span>Status: <span class="font-bold" :class="step >= 3 ? 'text-emerald-600' : 'text-slate-300'" x-text="step >= 3 ? 'Active' : '---'"></span></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 4: Engine Synced -->
                                <div class="flex items-start gap-5 relative">
                                    <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 relative z-10 transition-all duration-500 border-2"
                                         :class="step >= 4 ? 'bg-indigo-500 border-indigo-500 shadow-lg shadow-indigo-200' : 'bg-white border-slate-200'">
                                        <svg x-show="step < 4" class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                        <svg x-show="step >= 4" class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    </div>
                                    <div class="flex-grow min-w-0 pt-1 transition-all duration-500"
                                         :class="step >= 4 ? 'opacity-100' : 'opacity-40'">
                                        <h6 class="text-sm font-bold transition-colors duration-500" :class="step >= 4 ? 'text-indigo-800' : 'text-slate-800'">Attendance Engine Synced</h6>
                                        <div class="mt-2 flex items-center gap-4 text-[11px]">
                                            <span class="px-2.5 py-1 rounded-lg font-bold border transition-all duration-400"
                                                  :class="step >= 4 ? 'bg-indigo-50 text-indigo-700 border-indigo-100' : 'bg-slate-50 text-slate-300 border-slate-100'"
                                                  x-text="step >= 4 ? 'Geo-Fence: Bypassed' : '---'"></span>
                                            <span class="transition-colors duration-400" :class="step >= 4 ? 'text-emerald-600 font-semibold' : 'text-slate-300'" x-text="step >= 4 ? 'Synced ✓' : '--'"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ═══════════════════════════════════════ --}}
                {{-- Widgets B & C: Leave Types + Team      --}}
                {{-- ═══════════════════════════════════════ --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                    <!-- Widget B: Leave Types -->
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-lg shadow-slate-200/50 p-6">
                        <h5 class="font-display font-semibold text-slate-900 text-sm mb-5 flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-indigo-50 flex items-center justify-center">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            Leave Types
                        </h5>
                        <div class="grid grid-cols-2 gap-2.5">
                            <div class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-slate-50 border border-slate-100">
                                <div class="w-1 h-6 rounded-full bg-emerald-400"></div>
                                <div>
                                    <p class="text-xs font-bold text-slate-700">Casual</p>
                                    <p class="text-[10px] text-slate-400 font-mono">12 days</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-slate-50 border border-slate-100">
                                <div class="w-1 h-6 rounded-full bg-amber-400"></div>
                                <div>
                                    <p class="text-xs font-bold text-slate-700">Sick</p>
                                    <p class="text-[10px] text-slate-400 font-mono">8 days</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-slate-50 border border-slate-100">
                                <div class="w-1 h-6 rounded-full bg-indigo-400"></div>
                                <div>
                                    <p class="text-xs font-bold text-slate-700">Paid</p>
                                    <p class="text-[10px] text-slate-400 font-mono">15 days</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-slate-50 border border-slate-100">
                                <div class="w-1 h-6 rounded-full bg-slate-400"></div>
                                <div>
                                    <p class="text-xs font-bold text-slate-700">Unpaid</p>
                                    <p class="text-[10px] text-slate-400 font-mono">∞</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-slate-50 border border-slate-100">
                                <div class="w-1 h-6 rounded-full bg-cyan-400"></div>
                                <div>
                                    <p class="text-xs font-bold text-slate-700">Half Day</p>
                                    <p class="text-[10px] text-slate-400 font-mono">Flexible</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-slate-50 border border-slate-100">
                                <div class="w-1 h-6 rounded-full bg-rose-400"></div>
                                <div>
                                    <p class="text-xs font-bold text-slate-700">Emergency</p>
                                    <p class="text-[10px] text-slate-400 font-mono">3 days</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Widget C: Team Availability -->
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-lg shadow-slate-200/50 p-6">
                        <h5 class="font-display font-semibold text-slate-900 text-sm mb-5 flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            </div>
                            Team Availability
                        </h5>
                        <div class="space-y-3.5">
                            <div class="flex items-center justify-between px-3 py-2.5 rounded-xl bg-indigo-50/50 border border-indigo-100/50">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name=Sarah+Chen&background=4f46e5&color=fff&size=48&font-size=0.4&bold=true&format=svg" alt="Sarah" class="w-7 h-7 rounded-full ring-2 ring-white">
                                    <span class="text-xs font-bold text-slate-700">Sarah Chen</span>
                                </div>
                                <span class="text-[10px] font-semibold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-md">WFH Today</span>
                            </div>
                            <div class="flex items-center justify-between px-3 py-2.5 rounded-xl bg-amber-50/50 border border-amber-100/50">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name=Mike+Ross&background=d97706&color=fff&size=48&font-size=0.4&bold=true&format=svg" alt="Mike" class="w-7 h-7 rounded-full ring-2 ring-white">
                                    <span class="text-xs font-bold text-slate-700">Mike Ross</span>
                                </div>
                                <span class="text-[10px] font-semibold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-md">On Leave</span>
                            </div>
                            <div class="flex items-center justify-between px-3 py-2.5 rounded-xl bg-emerald-50/50 border border-emerald-100/50">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name=Alex+Morgan&background=059669&color=fff&size=48&font-size=0.4&bold=true&format=svg" alt="Alex" class="w-7 h-7 rounded-full ring-2 ring-white">
                                    <span class="text-xs font-bold text-slate-700">Alex Morgan</span>
                                </div>
                                <span class="text-[10px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">Available</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
