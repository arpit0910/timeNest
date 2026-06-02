<section class="py-16 lg:py-24 bg-white relative border-y border-slate-100 overflow-hidden" id="attendance">
    <!-- Decorative background elements -->
    <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-gradient-to-br from-indigo-50 to-transparent rounded-full blur-3xl opacity-60 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <x-frontend-base.badge variant="accent" class="mb-4">Smart Attendance Engine</x-frontend-base.badge>
            <h2 class="font-display text-4xl lg:text-5xl font-bold text-slate-900 tracking-tight mb-4">
                Flawless attendance, <span class="text-indigo-600">zero friction.</span>
            </h2>
            <p class="text-lg text-slate-600 font-body">
                Configurable attendance modes to match your company's operational reality. Ensure compliance with geo-fencing while providing flexibility.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            
            <!-- Left Side: Modes & Details (Interactive) -->
            <div class="lg:col-span-5 flex flex-col gap-4" x-data="{ activeMode: 'hybrid' }">
                <!-- Mode 1: Strict -->
                <button @click="activeMode = 'strict'" 
                        class="p-6 rounded-2xl border text-left transition-all duration-300 relative overflow-hidden group"
                        :class="activeMode === 'strict' ? 'bg-white border-indigo-500 shadow-md ring-1 ring-indigo-500' : 'bg-slate-50 border-slate-200 hover:border-slate-300 hover:bg-white'">
                    <div class="flex items-center gap-4 mb-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-colors"
                             :class="activeMode === 'strict' ? 'bg-indigo-100 text-indigo-600' : 'bg-slate-200 text-slate-500'">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <h4 class="font-display font-bold text-lg text-slate-900">Strict Mode</h4>
                    </div>
                    <p class="text-sm text-slate-600 font-body">Fixed shift timings. Auto-deduction for late marks, half-days, and missing log-outs.</p>
                </button>

                <!-- Mode 2: Flexible -->
                <button @click="activeMode = 'flexible'" 
                        class="p-6 rounded-2xl border text-left transition-all duration-300 relative overflow-hidden group"
                        :class="activeMode === 'flexible' ? 'bg-white border-indigo-500 shadow-md ring-1 ring-indigo-500' : 'bg-slate-50 border-slate-200 hover:border-slate-300 hover:bg-white'">
                    <div class="flex items-center gap-4 mb-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-colors"
                             :class="activeMode === 'flexible' ? 'bg-teal-100 text-teal-600' : 'bg-slate-200 text-slate-500'">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h4 class="font-display font-bold text-lg text-slate-900">Flexible Mode</h4>
                    </div>
                    <p class="text-sm text-slate-600 font-body">Focus on total hours completed rather than start/end times. Support for multi-session clock-ins.</p>
                </button>

                <!-- Mode 3: Hybrid -->
                <button @click="activeMode = 'hybrid'" 
                        class="p-6 rounded-2xl border text-left transition-all duration-300 relative overflow-hidden group"
                        :class="activeMode === 'hybrid' ? 'bg-white border-indigo-500 shadow-md ring-1 ring-indigo-500' : 'bg-slate-50 border-slate-200 hover:border-slate-300 hover:bg-white'">
                    <div class="flex items-center gap-4 mb-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-colors"
                             :class="activeMode === 'hybrid' ? 'bg-amber-100 text-amber-600' : 'bg-slate-200 text-slate-500'">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        <h4 class="font-display font-bold text-lg text-slate-900">Hybrid & WFH</h4>
                    </div>
                    <p class="text-sm text-slate-600 font-body">Dynamic geo-fencing rules based on approved Work From Home (WFH) or Extra Working Day (EWD) requests.</p>
                </button>
            </div>

            <!-- Right Side: Visualization Grid -->
            <div class="lg:col-span-7 bg-slate-50 rounded-3xl p-6 sm:p-8 border border-slate-200 flex flex-col gap-6 relative shadow-inner">
                
                <!-- Geo-fence Flow Widget -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm relative overflow-hidden"
                     x-data="{ stage: 1 }" x-init="setInterval(() => { stage = stage >= 3 ? 1 : stage + 1 }, 2500)">
                    <div class="absolute right-0 top-0 w-32 h-32 bg-indigo-50/50 rounded-bl-full pointer-events-none transition-all duration-700"
                         :class="stage === 3 ? 'bg-emerald-50/50' : 'bg-indigo-50/50'"></div>
                    <h5 class="font-display font-semibold text-slate-900 mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-500 transition-colors duration-500" :class="stage === 3 ? 'text-emerald-500' : 'text-indigo-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Geo-Fence Verification
                    </h5>
                    
                    <div class="flex items-center justify-between text-xs font-mono font-medium relative z-10 mt-6">
                        <!-- Step 1: Device -->
                        <div class="flex flex-col items-center gap-2 w-1/4 transition-all duration-500" :class="stage >= 1 ? 'opacity-100' : 'opacity-40'">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center relative z-10 transition-all duration-500"
                                 :class="stage >= 1 ? 'bg-indigo-50 border-indigo-200 text-indigo-600' : 'bg-slate-100 border-slate-200 text-slate-400'">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            </div>
                            <span class="text-center transition-colors duration-500" :class="stage >= 1 ? 'text-indigo-600' : 'text-slate-400'">Employee<br>Device</span>
                        </div>
                        
                        <!-- Line 1 -->
                        <div class="flex-grow h-px bg-slate-200 relative overflow-hidden">
                            <div class="absolute inset-y-0 left-0 bg-indigo-500 transition-all duration-1000"
                                 :style="stage >= 2 ? 'width: 100%' : 'width: 0%'"></div>
                        </div>

                        <!-- Step 2: Signal Checking -->
                        <div class="flex flex-col items-center gap-2 w-1/4 transition-all duration-500" :class="stage >= 2 ? 'opacity-100' : 'opacity-40'">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center relative z-10 transition-all duration-500"
                                 :class="stage === 2 ? 'bg-indigo-50 border-indigo-200 text-indigo-500 ring-4 ring-indigo-50' : (stage > 2 ? 'bg-indigo-50 border-indigo-200 text-indigo-500' : 'bg-slate-100 border-slate-200 text-slate-400')">
                                <svg class="w-4 h-4" :class="stage === 2 ? 'animate-ping opacity-50 absolute' : 'hidden'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                                <svg class="w-4 h-4 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                            </div>
                            <span class="text-center transition-colors duration-500" :class="stage === 2 ? 'text-indigo-600 animate-pulse' : (stage > 2 ? 'text-indigo-600' : 'text-slate-400')" x-text="stage === 2 ? 'Checking...' : 'GPS Signal'"></span>
                        </div>

                        <!-- Line 2 -->
                        <div class="flex-grow h-px bg-slate-200 relative overflow-hidden">
                            <div class="absolute inset-y-0 left-0 bg-emerald-500 transition-all duration-1000"
                                 :style="stage >= 3 ? 'width: 100%' : 'width: 0%'"></div>
                        </div>

                        <!-- Step 3: Verified -->
                        <div class="flex flex-col items-center gap-2 w-1/4 transition-all duration-500" :class="stage >= 3 ? 'opacity-100' : 'opacity-40'">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center relative z-10 transition-all duration-500"
                                 :class="stage >= 3 ? 'bg-emerald-50 border-emerald-200 text-emerald-500 shadow-[0_0_15px_rgba(16,185,129,0.2)] scale-110' : 'bg-slate-100 border-slate-200 text-slate-400 scale-100'">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span class="text-center transition-colors duration-500" :class="stage >= 3 ? 'text-emerald-600 font-bold' : 'text-slate-400'">Inside<br>Radius</span>
                        </div>
                    </div>
                </div>

                <!-- Session Timeline Widget -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm relative overflow-hidden"
                     x-data="{ progress: 0 }" x-init="setInterval(() => { progress = progress >= 100 ? 0 : progress + 1 }, 100)">
                    <h5 class="font-display font-semibold text-slate-900 mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Live Session Timeline
                    </h5>
                    <div class="space-y-4">
                        <!-- Session 1 -->
                        <div class="flex items-center gap-4 text-sm font-body relative">
                            <div class="w-24 text-slate-500 font-mono text-xs text-right">09:00 - 12:30</div>
                            <div class="flex-grow h-2 bg-slate-100 rounded-full relative">
                                <div class="absolute inset-y-0 left-0 bg-emerald-400 rounded-full w-full"></div>
                            </div>
                            <div class="w-16 font-semibold text-slate-700">3h 30m</div>
                        </div>
                        
                        <!-- Break -->
                        <div class="flex items-center gap-4 text-sm font-body opacity-50 relative">
                            <div class="w-24 text-slate-400 font-mono text-xs text-right">12:30 - 13:30</div>
                            <div class="flex-grow h-2 bg-slate-100 border border-slate-200 border-dashed rounded-full overflow-hidden"></div>
                            <div class="w-16 font-semibold text-slate-500">1h Break</div>
                        </div>

                        <!-- Session 2 (Active) -->
                        <div class="flex items-center gap-4 text-sm font-body relative">
                            <div class="w-24 text-slate-800 font-mono text-xs text-right font-bold">13:30 - Now</div>
                            <div class="flex-grow h-2 bg-slate-100 rounded-full relative">
                                <div class="absolute inset-y-0 left-0 bg-emerald-400 rounded-full" :style="`width: ${progress}%`"></div>
                                <!-- Active Dot Indicator -->
                                <div class="absolute top-1/2 -translate-y-1/2 w-3 h-3 bg-white border-2 border-emerald-500 rounded-full shadow-sm z-10 transition-all duration-75"
                                     :style="`left: calc(${progress}% - 6px)`">
                                     <div class="absolute inset-0 bg-emerald-400 rounded-full animate-ping opacity-50"></div>
                                </div>
                            </div>
                            <div class="w-16 font-semibold text-emerald-600 animate-pulse">Active</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
