<section class="py-16 lg:py-24 bg-white relative border-y border-slate-100 overflow-hidden" id="leave-management">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
        
        <div class="text-center max-w-3xl mx-auto mb-16">
            <x-frontend-base.badge variant="accent" class="mb-4">Leave & Integrations</x-frontend-base.badge>
            <h2 class="font-display text-4xl lg:text-5xl font-bold text-slate-900 tracking-tight mb-4">
                Requests that <span class="text-rose-500">update your engine</span> automatically.
            </h2>
            <p class="text-lg text-slate-600 font-body">
                When a Work From Home or Extra Working Day request is approved, TimeNest automatically adjusts the employee's attendance rules for that specific day.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            
            <!-- Left Side: Interactive Workflow Diagram -->
            <div class="bg-slate-50 border border-slate-200 rounded-3xl p-8 relative overflow-hidden shadow-inner order-2 lg:order-1">
                <div class="absolute top-0 right-0 w-64 h-64 bg-rose-500/5 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative space-y-6" x-data="{ step: 1 }" x-init="setInterval(() => { step = step >= 4 ? 1 : step + 1 }, 2500)">
                    
                    <!-- Connector Line -->
                    <div class="absolute left-[19px] top-10 bottom-10 w-0.5 bg-slate-200 overflow-hidden">
                        <div class="absolute top-0 left-0 w-full bg-rose-500 transition-all duration-1000"
                             :style="`height: ${(step - 1) * 33.33}%`"></div>
                    </div>

                    <!-- Step 1 -->
                    <div class="flex items-start gap-4 relative">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm shrink-0 relative z-10 mt-1 transition-all duration-500 ring-4 ring-slate-50"
                             :class="step >= 1 ? 'bg-rose-500 text-white shadow-md' : 'bg-slate-200 text-slate-500'">1</div>
                        <div class="bg-white border p-4 rounded-xl shadow-sm w-full transition-all duration-500"
                             :class="step === 1 ? 'border-rose-400 ring-1 ring-rose-400 scale-[1.02]' : 'border-slate-200 opacity-70 scale-100'">
                            <h6 class="font-bold text-slate-900 text-sm flex items-center justify-between">
                                Employee Request
                                <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded-full" 
                                      :class="step === 1 ? 'bg-amber-100 text-amber-700 animate-pulse' : (step > 1 ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500')"
                                      x-text="step === 1 ? 'Pending' : (step > 1 ? 'Sent' : '')"></span>
                            </h6>
                            <p class="text-xs text-slate-500 mt-1">Files a WFH request for Friday.</p>
                        </div>
                    </div>
                    
                    <!-- Step 2 -->
                    <div class="flex items-start gap-4 relative">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm shrink-0 relative z-10 mt-1 transition-all duration-500 ring-4 ring-slate-50"
                             :class="step >= 2 ? 'bg-amber-400 text-white shadow-md' : 'bg-slate-200 text-slate-500'">2</div>
                        <div class="bg-white border p-4 rounded-xl shadow-sm w-full relative overflow-hidden transition-all duration-500"
                             :class="step === 2 ? 'border-amber-400 ring-1 ring-amber-400 scale-[1.02]' : 'border-slate-200 opacity-70 scale-100'">
                            <h6 class="font-bold text-slate-900 text-sm flex items-center justify-between">
                                Manager Review
                                <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded-full" 
                                      :class="step === 2 ? 'bg-amber-100 text-amber-700 animate-pulse' : (step > 2 ? 'bg-emerald-100 text-emerald-700' : 'hidden')"
                                      x-text="step === 2 ? 'Reviewing...' : (step > 2 ? 'Done' : '')"></span>
                            </h6>
                            <p class="text-xs text-slate-500 mt-1">Notified instantly. Checks project timeline.</p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex items-start gap-4 relative">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm shrink-0 relative z-10 mt-1 transition-all duration-500 ring-4 ring-slate-50"
                             :class="step >= 3 ? 'bg-emerald-500 text-white shadow-[0_0_15px_rgba(16,185,129,0.3)]' : 'bg-slate-200 text-slate-500'">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div class="border p-4 rounded-xl shadow-sm w-full transition-all duration-500"
                             :class="step === 3 ? 'bg-emerald-50 border-emerald-300 ring-1 ring-emerald-300 scale-[1.02]' : (step > 3 ? 'bg-white border-emerald-200 opacity-90' : 'bg-white border-slate-200 opacity-70 scale-100')">
                            <h6 class="font-bold text-sm transition-colors duration-500" :class="step >= 3 ? 'text-emerald-900' : 'text-slate-900'">Approved</h6>
                            <p class="text-xs mt-1 transition-colors duration-500" :class="step >= 3 ? 'text-emerald-600' : 'text-slate-500'">Request transitions to active state.</p>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex items-start gap-4 relative">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm shrink-0 relative z-10 mt-1 transition-all duration-500 ring-4 ring-slate-50"
                             :class="step >= 4 ? 'bg-rose-500 text-white shadow-[0_0_15px_rgba(244,63,94,0.3)]' : 'bg-slate-200 text-slate-500'">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <div class="border p-4 rounded-xl shadow-sm w-full transition-all duration-500"
                             :class="step === 4 ? 'bg-rose-50 border-rose-300 ring-1 ring-rose-300 scale-[1.02]' : 'bg-white border-slate-200 opacity-70 scale-100'">
                            <h6 class="font-bold text-sm flex items-center justify-between transition-colors duration-500" :class="step === 4 ? 'text-rose-900' : 'text-slate-900'">
                                Attendance Engine Updated
                                <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 animate-pulse" x-show="step === 4">Synced</span>
                            </h6>
                            <p class="text-xs mt-1 transition-colors duration-500" :class="step === 4 ? 'text-rose-600' : 'text-slate-500'">Geo-fence limits are lifted for Friday automatically.</p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Right Side: Content -->
            <div class="order-1 lg:order-2">
                <div class="space-y-8">
                    <!-- Feature: WFH -->
                    <div class="flex items-start gap-5">
                        <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-500 border border-rose-100 flex items-center justify-center shrink-0 shadow-sm">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        <div>
                            <h4 class="font-display font-bold text-xl text-slate-900 mb-2">Work From Home (WFH)</h4>
                            <p class="text-slate-600 font-body text-sm leading-relaxed mb-3">
                                When a WFH request is approved, TimeNest automatically removes the office radius location restriction for that employee for the specific date.
                            </p>
                            <span class="inline-block px-3 py-1 rounded bg-slate-100 text-slate-700 text-xs font-semibold tracking-wide">Location Restriction Removed</span>
                        </div>
                    </div>

                    <!-- Feature: EWD -->
                    <div class="flex items-start gap-5">
                        <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-500 border border-amber-100 flex items-center justify-center shrink-0 shadow-sm">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-display font-bold text-xl text-slate-900 mb-2">Extra Working Day (EWD)</h4>
                            <p class="text-slate-600 font-body text-sm leading-relaxed mb-3">
                                Need someone to work on a weekend or holiday? An approved EWD request ensures their attendance is counted and flagged for extra payroll.
                            </p>
                            <span class="inline-block px-3 py-1 rounded bg-slate-100 text-slate-700 text-xs font-semibold tracking-wide">Holiday/Weekend Enabled</span>
                        </div>
                    </div>

                    <!-- Feature: Standard Leaves -->
                    <div class="flex items-start gap-5">
                        <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-500 border border-indigo-100 flex items-center justify-center shrink-0 shadow-sm">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-display font-bold text-xl text-slate-900 mb-2">Paid & Unpaid Leaves</h4>
                            <p class="text-slate-600 font-body text-sm leading-relaxed">
                                Standard leave requests are handled gracefully, preventing the employee from being marked absent or having their pay deducted automatically.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
