<section class="py-16 lg:py-24 bg-white relative border-y border-slate-100 overflow-hidden" id="attendance">
    <!-- Decorative background elements -->
    <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-gradient-to-br from-indigo-50 to-transparent rounded-full blur-3xl opacity-60 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20 items-start">
            
            <!-- Left Side: Explanation & Feature Points -->
            <div class="lg:col-span-5 lg:sticky lg:top-28 lg:self-start">
                <x-frontend-base.badge variant="accent" class="mb-5">Smart Attendance Engine</x-frontend-base.badge>
                <h2 class="font-display text-4xl lg:text-5xl font-bold text-slate-900 tracking-tight mb-5">
                    Flawless attendance, <span class="text-indigo-600">zero friction.</span>
                </h2>
                <p class="text-lg text-slate-600 font-body mb-10 leading-relaxed">
                    Configurable attendance modes to match your company's operational reality. Ensure compliance with geo-fencing while providing flexibility.
                </p>

                <ul class="space-y-5">
                    <li class="flex items-start gap-3.5 text-slate-700 font-medium">
                        <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        Strict & Flexible attendance modes
                    </li>
                    <li class="flex items-start gap-3.5 text-slate-700 font-medium">
                        <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        Branch-based geo-fencing verification
                    </li>
                    <li class="flex items-start gap-3.5 text-slate-700 font-medium">
                        <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        Multiple work sessions per day
                    </li>
                    <li class="flex items-start gap-3.5 text-slate-700 font-medium">
                        <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        WFH & extra working day support
                    </li>
                    <li class="flex items-start gap-3.5 text-slate-700 font-medium">
                        <div class="w-7 h-7 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        Policy-based automatic calculations
                    </li>
                </ul>

                <!-- CTA -->
                <div class="mt-10 flex flex-wrap items-center gap-4">
                    <button @click="$dispatch('open-book-demo')" class="inline-flex items-center gap-2 px-6 py-3 bg-slate-900 text-white text-sm font-bold rounded-xl hover:bg-slate-800 transition-all shadow-md shadow-slate-900/10 group">
                        See it in action
                        <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </button>
                    <a href="/solutions/attendance" class="text-sm font-semibold text-slate-500 hover:text-indigo-600 transition-colors">Learn more →</a>
                </div>

                <!-- Trust strip -->
                <div class="mt-10 pt-8 border-t border-slate-100">
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <p class="text-2xl font-bold font-display text-slate-900">99.8%</p>
                            <p class="text-[11px] text-slate-400 font-medium mt-1">Uptime SLA</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold font-display text-slate-900">50<span class="text-base text-slate-400">ms</span></p>
                            <p class="text-[11px] text-slate-400 font-medium mt-1">Avg. clock-in</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold font-display text-slate-900">SOC 2</p>
                            <p class="text-[11px] text-slate-400 font-medium mt-1">Compliant</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Workflow Simulation Widgets -->
            <div class="lg:col-span-7 flex flex-col gap-6">

                {{-- ═══════════════════════════════════════════════ --}}
                {{-- Widget A: Attendance Engine — 4-Step Pipeline  --}}
                {{-- ═══════════════════════════════════════════════ --}}
                <div class="bg-white rounded-3xl border border-slate-200 shadow-lg shadow-slate-200/50 overflow-hidden"
                     x-data="{
                         step: 0,
                         init() {
                             this.runCycle();
                         },
                         runCycle() {
                             this.step = 0;
                             setTimeout(() => this.step = 1, 600);
                             setTimeout(() => this.step = 2, 3000);
                             setTimeout(() => this.step = 3, 5400);
                             setTimeout(() => this.step = 4, 7800);
                             setTimeout(() => this.runCycle(), 11000);
                         }
                     }">
                    <!-- Header -->
                    <div class="flex items-center justify-between px-6 py-4 bg-gradient-to-r from-slate-50 to-white border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <span class="font-display font-bold text-[15px] text-slate-800">Attendance Engine</span>
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
                    <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <img src="https://ui-avatars.com/api/?name=Alex+Morgan&background=4f46e5&color=fff&size=64&font-size=0.38&bold=true&format=svg" alt="Alex Morgan" class="w-9 h-9 rounded-full object-cover shadow-md shadow-indigo-500/20 ring-2 ring-white">
                            <div>
                                <p class="text-sm font-bold text-slate-800 leading-snug">Alex Morgan</p>
                                <p class="text-[11px] text-slate-400 font-mono mt-0.5">Engineering · Branch A</p>
                            </div>
                        </div>
                        <span class="text-xs font-semibold px-3 py-1.5 rounded-lg transition-all duration-500"
                              :class="step >= 4 ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-slate-100 text-slate-500 border border-slate-200'"
                              x-text="step >= 4 ? 'Clocked In ✓' : 'Clocking In...'"></span>
                    </div>

                    <div class="px-6 py-8" style="min-height: 420px;">
                        <!-- 4-Step Vertical Flow -->
                        <div class="relative">
                            <!-- Connector Line -->
                            <div class="absolute left-[17px] top-6 bottom-6 w-0.5 bg-slate-100 rounded-full">
                                <div class="absolute top-0 left-0 w-full rounded-full bg-gradient-to-b from-indigo-400 to-emerald-400 transition-all duration-1000 ease-out"
                                     :style="`height: ${step >= 4 ? 100 : step >= 3 ? 72 : step >= 2 ? 44 : step >= 1 ? 16 : 0}%`"></div>
                            </div>

                            <div class="space-y-8">
                                <!-- Step 1: Device Location -->
                                <div class="flex items-start gap-5 relative">
                                    <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 relative z-10 transition-all duration-500 border-2"
                                         :class="step >= 1 ? (step === 1 ? 'bg-indigo-50 border-indigo-400 shadow-[0_0_16px_rgba(99,102,241,0.2)]' : 'bg-indigo-500 border-indigo-500 shadow-md shadow-indigo-200') : 'bg-white border-slate-200'">
                                        <svg x-show="step < 2" class="w-4 h-4 transition-colors duration-500" :class="step >= 1 ? 'text-indigo-500' : 'text-slate-300'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <svg x-show="step >= 2" class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <div class="flex-grow min-w-0 pt-1">
                                        <div class="flex items-center justify-between mb-2">
                                            <h6 class="text-sm font-bold text-slate-800">Device Location</h6>
                                            <span x-show="step === 1"
                                                  x-transition:enter="transition ease-out duration-300"
                                                  x-transition:enter-start="opacity-0 translate-x-2"
                                                  x-transition:enter-end="opacity-100 translate-x-0"
                                                  class="text-[10px] font-mono text-indigo-500 bg-indigo-50 px-2 py-0.5 rounded-md animate-pulse">Searching GPS...</span>
                                            <span x-show="step >= 2"
                                                  x-transition:enter="transition ease-out duration-300"
                                                  x-transition:enter-start="opacity-0 scale-90"
                                                  x-transition:enter-end="opacity-100 scale-100"
                                                  class="text-[10px] font-mono text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md font-semibold">Located ✓</span>
                                            <span x-show="step < 1" class="text-[10px] font-mono text-slate-300">Waiting...</span>
                                        </div>
                                        <!-- GPS scanning bar / placeholder -->
                                        <div class="h-1.5 rounded-full overflow-hidden transition-all duration-300"
                                             :class="step >= 1 ? 'bg-slate-100' : 'bg-slate-100/60'">
                                            <div class="h-full rounded-full transition-all duration-[2000ms] ease-out"
                                                 :class="step >= 2 ? 'bg-emerald-400 w-full' : (step >= 1 ? 'bg-indigo-400 att-gps-scan' : 'bg-slate-200 w-[30%]')"
                                                 :style="step === 1 ? 'width: 65%' : ''"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 2: Branch Verification -->
                                <div class="flex items-start gap-5 relative">
                                    <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 relative z-10 transition-all duration-500 border-2"
                                         :class="step >= 2 ? (step === 2 ? 'bg-indigo-50 border-indigo-400 shadow-[0_0_16px_rgba(99,102,241,0.2)]' : 'bg-indigo-500 border-indigo-500 shadow-md shadow-indigo-200') : 'bg-white border-slate-200'">
                                        <svg x-show="step < 3" class="w-4 h-4 transition-colors duration-500" :class="step >= 2 ? 'text-indigo-500' : 'text-slate-300'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                                        <svg x-show="step >= 3" class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <div class="flex-grow min-w-0 pt-1">
                                        <div class="flex items-center justify-between mb-2">
                                            <h6 class="text-sm font-bold text-slate-800">Branch Verification</h6>
                                            <span x-show="step === 2"
                                                  x-transition:enter="transition ease-out duration-300"
                                                  x-transition:enter-start="opacity-0 translate-x-2"
                                                  x-transition:enter-end="opacity-100 translate-x-0"
                                                  class="text-[10px] font-mono text-indigo-500 bg-indigo-50 px-2 py-0.5 rounded-md animate-pulse">Checking...</span>
                                            <span x-show="step >= 3"
                                                  x-transition:enter="transition ease-out duration-300"
                                                  x-transition:enter-start="opacity-0 scale-90"
                                                  x-transition:enter-end="opacity-100 scale-100"
                                                  class="text-[10px] font-mono text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md font-semibold">Inside workplace ✓</span>
                                            <span x-show="step < 2" class="text-[10px] font-mono text-slate-300">Waiting...</span>
                                        </div>
                                        <!-- Geo-fence radius indicator / skeleton -->
                                        <div class="flex items-center gap-4">
                                            <template x-if="step >= 2">
                                                <div class="relative w-12 h-12 shrink-0">
                                                    <div class="absolute inset-0 rounded-full border-2 transition-all duration-700"
                                                         :class="step >= 3 ? 'border-emerald-200' : 'border-indigo-200'"></div>
                                                    <div class="absolute inset-2 rounded-full border transition-all duration-700"
                                                         :class="step >= 3 ? 'border-emerald-300/60' : 'border-indigo-300/60'"></div>
                                                    <div class="absolute inset-[14px] rounded-full transition-all duration-700"
                                                         :class="step >= 3 ? 'bg-emerald-400 shadow-[0_0_8px_rgba(16,185,129,0.4)]' : 'bg-indigo-400 animate-pulse'"></div>
                                                    <div x-show="step === 2" class="absolute inset-0 rounded-full border-2 border-indigo-400/30 att-radius-pulse"></div>
                                                </div>
                                            </template>
                                            <template x-if="step < 2">
                                                <div class="relative w-12 h-12 shrink-0">
                                                    <div class="absolute inset-0 rounded-full border-2 border-slate-200/60"></div>
                                                    <div class="absolute inset-2 rounded-full border border-slate-200/40"></div>
                                                    <div class="absolute inset-[14px] rounded-full bg-slate-200"></div>
                                                </div>
                                            </template>
                                            <div class="flex gap-4 text-[11px]">
                                                <span class="transition-colors duration-300" :class="step >= 2 ? 'text-slate-500' : 'text-slate-300'">Radius: <span class="font-bold" :class="step >= 2 ? 'text-slate-700' : 'text-slate-300'">200m</span></span>
                                                <span class="transition-colors duration-300" :class="step >= 2 ? 'text-slate-500' : 'text-slate-300'">Distance: <span class="font-bold transition-colors duration-500" :class="step >= 3 ? 'text-emerald-600' : (step >= 2 ? 'text-indigo-600' : 'text-slate-300')" x-text="step >= 3 ? '48m' : (step >= 2 ? '...' : '---')"></span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 3: Policy Engine -->
                                <div class="flex items-start gap-5 relative">
                                    <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 relative z-10 transition-all duration-500 border-2"
                                         :class="step >= 3 ? (step === 3 ? 'bg-indigo-50 border-indigo-400 shadow-[0_0_16px_rgba(99,102,241,0.2)]' : 'bg-indigo-500 border-indigo-500 shadow-md shadow-indigo-200') : 'bg-white border-slate-200'">
                                        <svg x-show="step < 4" class="w-4 h-4 transition-colors duration-500" :class="step >= 3 ? 'text-indigo-500' : 'text-slate-300'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <svg x-show="step >= 4" class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <div class="flex-grow min-w-0 pt-1">
                                        <div class="flex items-center justify-between mb-2">
                                            <h6 class="text-sm font-bold text-slate-800">Policy Engine</h6>
                                            <span x-show="step === 3"
                                                  x-transition:enter="transition ease-out duration-300"
                                                  x-transition:enter-start="opacity-0 translate-x-2"
                                                  x-transition:enter-end="opacity-100 translate-x-0"
                                                  class="text-[10px] font-mono text-indigo-500 bg-indigo-50 px-2 py-0.5 rounded-md animate-pulse">Evaluating...</span>
                                            <span x-show="step >= 4"
                                                  x-transition:enter="transition ease-out duration-300"
                                                  x-transition:enter-start="opacity-0 scale-90"
                                                  x-transition:enter-end="opacity-100 scale-100"
                                                  class="text-[10px] font-mono text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md font-semibold">Rules Passed ✓</span>
                                            <span x-show="step < 3" class="text-[10px] font-mono text-slate-300">Waiting...</span>
                                        </div>
                                        <!-- Policy cards / skeleton -->
                                        <div class="flex flex-wrap gap-2.5">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[11px] transition-all duration-400"
                                                  :class="step >= 3 ? 'bg-slate-50 border border-slate-200' : 'bg-slate-50/60 border border-slate-100'">
                                                <span :class="step >= 3 ? 'text-slate-400' : 'text-slate-300'">Mode:</span>
                                                <span class="font-bold" :class="step >= 3 ? 'text-slate-700' : 'text-slate-300'">Strict</span>
                                            </span>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[11px] transition-all duration-400"
                                                  :class="step >= 3 ? 'bg-slate-50 border border-slate-200' : 'bg-slate-50/60 border border-slate-100'">
                                                <span :class="step >= 3 ? 'text-slate-400' : 'text-slate-300'">Required:</span>
                                                <span class="font-bold" :class="step >= 3 ? 'text-slate-700' : 'text-slate-300'">8 Hours</span>
                                            </span>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[11px] transition-all duration-400"
                                                  :class="step >= 3 ? 'bg-slate-50 border border-slate-200' : 'bg-slate-50/60 border border-slate-100'">
                                                <span :class="step >= 3 ? 'text-slate-400' : 'text-slate-300'">Late Rules:</span>
                                                <span class="font-bold" :class="step >= 3 ? 'text-slate-700' : 'text-slate-300'">Active</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 4: Attendance Created -->
                                <div class="flex items-start gap-5 relative">
                                    <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 relative z-10 transition-all duration-500 border-2"
                                         :class="step >= 4 ? 'bg-emerald-500 border-emerald-500 shadow-lg shadow-emerald-200' : 'bg-white border-slate-200'">
                                        <svg x-show="step < 4" class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        <svg x-show="step >= 4" class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <div class="flex-grow min-w-0 pt-1 transition-all duration-500"
                                         :class="step >= 4 ? 'opacity-100' : 'opacity-40'">
                                        <h6 class="text-sm font-bold transition-colors duration-500" :class="step >= 4 ? 'text-emerald-800' : 'text-slate-800'">Attendance Created</h6>
                                        <div class="mt-2 flex items-center gap-4 text-[11px]">
                                            <span class="px-2.5 py-1 rounded-lg font-bold border transition-all duration-400"
                                                  :class="step >= 4 ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'bg-slate-50 text-slate-300 border-slate-100'"
                                                  x-text="step >= 4 ? 'Present' : '---'"></span>
                                            <span class="transition-colors duration-400" :class="step >= 4 ? 'text-slate-500' : 'text-slate-300'">Session: <span class="font-bold" :class="step >= 4 ? 'text-slate-700' : 'text-slate-300'" x-text="step >= 4 ? '09:02 AM Started' : '--:-- --'"></span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ═══════════════════════════════════════════════════ --}}
                {{-- Widget B & C: Session Timeline + Mode Toggle Grid --}}
                {{-- ═══════════════════════════════════════════════════ --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                    <!-- Widget B: Multiple Session Timeline -->
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-lg shadow-slate-200/50 p-6 relative overflow-hidden"
                         x-data="{ activeEntry: 0 }" x-init="setInterval(() => { activeEntry = activeEntry >= 3 ? 0 : activeEntry + 1 }, 2000)">
                        <h5 class="font-display font-semibold text-slate-900 text-sm mb-5 flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-indigo-50 flex items-center justify-center">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            Today's Timeline
                        </h5>

                        <div class="relative">
                            <!-- Timeline connector -->
                            <div class="absolute left-[9px] top-2 bottom-2 w-0.5 bg-slate-100 rounded-full">
                                <div class="absolute top-0 left-0 w-full rounded-full bg-indigo-400 transition-all duration-700 ease-out"
                                     :style="`height: ${(activeEntry / 3) * 100}%`"></div>
                            </div>

                            <div class="space-y-5">
                                <!-- 09:00 Clock In -->
                                <div class="flex items-center gap-4 relative">
                                    <div class="w-[18px] h-[18px] rounded-full border-2 shrink-0 relative z-10 transition-all duration-500"
                                         :class="activeEntry >= 0 ? 'bg-indigo-500 border-indigo-500 shadow-sm' : 'bg-white border-slate-300'">
                                        <div x-show="activeEntry === 0" class="absolute -inset-1 rounded-full bg-indigo-400/30 att-timeline-dot-pulse"></div>
                                    </div>
                                    <span class="text-xs font-mono font-bold text-slate-800 w-12">09:00</span>
                                    <span class="text-xs text-slate-600 font-medium">Clock In</span>
                                </div>
                                <!-- 12:30 Break -->
                                <div class="flex items-center gap-4 relative">
                                    <div class="w-[18px] h-[18px] rounded-full border-2 shrink-0 relative z-10 transition-all duration-500"
                                         :class="activeEntry >= 1 ? 'bg-amber-400 border-amber-400 shadow-sm' : 'bg-white border-slate-300'">
                                        <div x-show="activeEntry === 1" class="absolute -inset-1 rounded-full bg-amber-300/30 att-timeline-dot-pulse"></div>
                                    </div>
                                    <span class="text-xs font-mono font-bold text-slate-800 w-12">12:30</span>
                                    <span class="text-xs text-slate-600 font-medium">Break</span>
                                </div>
                                <!-- 01:15 Resume -->
                                <div class="flex items-center gap-4 relative">
                                    <div class="w-[18px] h-[18px] rounded-full border-2 shrink-0 relative z-10 transition-all duration-500"
                                         :class="activeEntry >= 2 ? 'bg-indigo-500 border-indigo-500 shadow-sm' : 'bg-white border-slate-300'">
                                        <div x-show="activeEntry === 2" class="absolute -inset-1 rounded-full bg-indigo-400/30 att-timeline-dot-pulse"></div>
                                    </div>
                                    <span class="text-xs font-mono font-bold text-slate-800 w-12">01:15</span>
                                    <span class="text-xs text-slate-600 font-medium">Resume</span>
                                </div>
                                <!-- 06:05 Clock Out -->
                                <div class="flex items-center gap-4 relative">
                                    <div class="w-[18px] h-[18px] rounded-full border-2 shrink-0 relative z-10 transition-all duration-500"
                                         :class="activeEntry >= 3 ? 'bg-emerald-500 border-emerald-500 shadow-sm' : 'bg-white border-slate-300'">
                                        <div x-show="activeEntry === 3" class="absolute -inset-1 rounded-full bg-emerald-400/30 att-timeline-dot-pulse"></div>
                                    </div>
                                    <span class="text-xs font-mono font-bold text-slate-800 w-12">06:05</span>
                                    <span class="text-xs text-slate-600 font-medium">Clock Out</span>
                                </div>
                            </div>
                        </div>

                        <!-- Total -->
                        <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-[11px] text-slate-400 uppercase tracking-wider font-semibold">Total Hours</span>
                            <span class="text-sm font-bold font-mono transition-all duration-500"
                                  :class="activeEntry >= 3 ? 'text-emerald-600' : 'text-slate-700'"
                                  x-text="activeEntry >= 3 ? '8h 20m' : (activeEntry >= 2 ? '6h 45m' : (activeEntry >= 1 ? '3h 30m' : '0h 00m'))"></span>
                        </div>
                    </div>

                    <!-- Widget C: Strict vs Flexible Mode Toggle -->
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-lg shadow-slate-200/50 p-6 relative overflow-hidden"
                         x-data="{
                             isStrict: true,
                             autoTimer: null,
                             init() {
                                 this.startAuto();
                             },
                             startAuto() {
                                 clearInterval(this.autoTimer);
                                 this.autoTimer = setInterval(() => { this.isStrict = !this.isStrict }, 8000);
                             },
                             toggle(mode) {
                                 this.isStrict = mode;
                                 clearInterval(this.autoTimer);
                                 this.startAuto();
                             }
                         }">
                        <h5 class="font-display font-semibold text-slate-900 text-sm mb-5 flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                            </div>
                            Attendance Mode
                        </h5>

                        <!-- Mode Switcher — Clickable -->
                        <div class="flex items-center gap-1 p-1 bg-slate-100 rounded-xl mb-5">
                            <button @click="toggle(true)" class="flex-1 text-center text-xs font-bold py-2 rounded-lg transition-all duration-500 cursor-pointer"
                                    :class="isStrict ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-400 hover:text-slate-500'">Strict</button>
                            <button @click="toggle(false)" class="flex-1 text-center text-xs font-bold py-2 rounded-lg transition-all duration-500 cursor-pointer"
                                    :class="!isStrict ? 'bg-white text-cyan-600 shadow-sm' : 'text-slate-400 hover:text-slate-500'">Flexible</button>
                        </div>

                        <!-- Fixed-height content area to prevent layout shift -->
                        <div class="relative" style="min-height: 148px;">
                            <!-- Strict Mode Checks -->
                            <div class="absolute inset-0 transition-all duration-300"
                                 :class="isStrict ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-3 pointer-events-none'">
                                <div class="space-y-3.5">
                                    <div class="flex items-center gap-3 text-xs text-slate-700">
                                        <div class="w-6 h-6 rounded-lg bg-indigo-50 flex items-center justify-center shrink-0">
                                            <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                        <span class="font-medium">Shift timing enforced</span>
                                    </div>
                                    <div class="flex items-center gap-3 text-xs text-slate-700">
                                        <div class="w-6 h-6 rounded-lg bg-indigo-50 flex items-center justify-center shrink-0">
                                            <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                        <span class="font-medium">Late arrival tracking</span>
                                    </div>
                                    <div class="flex items-center gap-3 text-xs text-slate-700">
                                        <div class="w-6 h-6 rounded-lg bg-indigo-50 flex items-center justify-center shrink-0">
                                            <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                        <span class="font-medium">Required hours validation</span>
                                    </div>
                                    <div class="flex items-center gap-3 text-xs text-slate-700">
                                        <div class="w-6 h-6 rounded-lg bg-indigo-50 flex items-center justify-center shrink-0">
                                            <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                        <span class="font-medium">Compliance rules active</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Flexible Mode Checks -->
                            <div class="absolute inset-0 transition-all duration-300"
                                 :class="!isStrict ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-3 pointer-events-none'">
                                <div class="space-y-3.5">
                                    <div class="flex items-center gap-3 text-xs text-slate-700">
                                        <div class="w-6 h-6 rounded-lg bg-cyan-50 flex items-center justify-center shrink-0">
                                            <svg class="w-3.5 h-3.5 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                        <span class="font-medium">Work duration tracking</span>
                                    </div>
                                    <div class="flex items-center gap-3 text-xs text-slate-700">
                                        <div class="w-6 h-6 rounded-lg bg-cyan-50 flex items-center justify-center shrink-0">
                                            <svg class="w-3.5 h-3.5 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                        <span class="font-medium">Multiple sessions allowed</span>
                                    </div>
                                    <div class="flex items-center gap-3 text-xs text-slate-700">
                                        <div class="w-6 h-6 rounded-lg bg-cyan-50 flex items-center justify-center shrink-0">
                                            <svg class="w-3.5 h-3.5 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                        <span class="font-medium">Flexible schedule</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ═════════════════════════════════════ --}}
                {{-- Widget D: WFH / EWD Handling Cards   --}}
                {{-- ═════════════════════════════════════ --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- WFH Card -->
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-lg shadow-slate-200/50 p-6 relative overflow-hidden">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Request Type</span>
                            <span class="text-[10px] font-bold px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-600 border border-emerald-100">Approved ✓</span>
                        </div>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-500 flex items-center justify-center shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            </div>
                            <span class="text-[15px] font-bold text-slate-800">WFH</span>
                        </div>
                        <div class="rounded-xl bg-slate-50 border border-slate-200 px-4 py-3">
                            <p class="text-[10px] text-slate-400 uppercase tracking-wider mb-1 font-semibold">Effect</p>
                            <p class="text-sm font-bold text-slate-700">Geo-Fence: <span class="text-indigo-600">Bypassed</span></p>
                        </div>
                    </div>

                    <!-- EWD Card -->
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-lg shadow-slate-200/50 p-6 relative overflow-hidden">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Request Type</span>
                            <span class="text-[10px] font-bold px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-600 border border-emerald-100">Approved ✓</span>
                        </div>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <span class="text-[15px] font-bold text-slate-800">EWD</span>
                        </div>
                        <div class="rounded-xl bg-slate-50 border border-slate-200 px-4 py-3">
                            <p class="text-[10px] text-slate-400 uppercase tracking-wider mb-1 font-semibold">Effect</p>
                            <p class="text-sm font-bold text-slate-700">Weekend/Holiday: <span class="text-amber-600">Work Enabled</span></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
