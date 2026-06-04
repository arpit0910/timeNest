<section class="py-16 lg:py-24 bg-slate-50 relative overflow-hidden border-y border-slate-200" id="product-showcase">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <!-- Section Header -->
        <div class="text-center mb-12">
            <x-frontend-base.badge variant="accent" class="mb-5">Product Showcase</x-frontend-base.badge>
            <h2 class="font-display text-4xl lg:text-5xl font-bold text-slate-900 tracking-tight mb-4">
                See TimeNest in <span class="text-indigo-600">action.</span>
            </h2>
            <p class="text-lg text-slate-600 font-body max-w-2xl mx-auto leading-relaxed">
                Real dashboard screens that your team will use every day.
            </p>
        </div>

        <!-- Carousel -->
        <div x-data="{
                active: 0,
                slides: 3,
                interval: null,
                start() { this.interval = setInterval(() => { this.next() }, 6000) },
                next() { this.active = (this.active + 1) % this.slides },
                prev() { this.active = (this.active - 1 + this.slides) % this.slides },
                goTo(i) { this.active = i; clearInterval(this.interval); this.start() }
             }" x-init="start()" class="relative">

            <!-- Browser Window Frame -->
            <div class="bg-white rounded-2xl border border-slate-200 browser-chrome-frame overflow-hidden">
                <!-- Browser Chrome -->
                <div class="px-4 py-3 border-b border-slate-100 browser-glass-top flex items-center gap-3">
                    <div class="flex gap-1.5">
                        <div class="w-3 h-3 rounded-full bg-slate-200"></div>
                        <div class="w-3 h-3 rounded-full bg-slate-200"></div>
                        <div class="w-3 h-3 rounded-full bg-slate-200"></div>
                    </div>
                    <div class="flex-grow flex items-center justify-center">
                        <div class="bg-slate-50 border border-slate-200 rounded-lg px-4 py-1.5 text-[11px] text-slate-400 font-mono flex items-center gap-2 max-w-xs w-full">
                            <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            app.timenest.com/dashboard
                        </div>
                    </div>
                    <div class="w-16"></div>
                </div>

                <!-- Slide Container -->
                <div class="relative overflow-hidden" style="min-height: 420px;">
                    <div class="flex transition-transform duration-700 ease-out" :style="`transform: translateX(-${active * 100}%)`">

                        {{-- Slide 1: Attendance Dashboard --}}
                        <div class="w-full shrink-0 p-6 lg:p-8">
                            <div class="grid grid-cols-12 gap-5">
                                <!-- Sidebar -->
                                <div class="col-span-3 space-y-3">
                                    <div class="flex items-center gap-2 px-3 py-2 rounded-lg bg-indigo-50 border border-indigo-100">
                                        <div class="w-5 h-5 rounded-md bg-indigo-500 flex items-center justify-center">
                                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </div>
                                        <span class="text-[11px] font-bold text-indigo-700">Attendance</span>
                                    </div>
                                    <div class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-50">
                                        <div class="w-5 h-5 rounded-md bg-slate-100 flex items-center justify-center">
                                            <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                        <span class="text-[11px] font-medium text-slate-500">Leaves</span>
                                    </div>
                                    <div class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-50">
                                        <div class="w-5 h-5 rounded-md bg-slate-100 flex items-center justify-center">
                                            <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                        </div>
                                        <span class="text-[11px] font-medium text-slate-500">Reports</span>
                                    </div>
                                    <div class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-50">
                                        <div class="w-5 h-5 rounded-md bg-slate-100 flex items-center justify-center">
                                            <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        </div>
                                        <span class="text-[11px] font-medium text-slate-500">Settings</span>
                                    </div>
                                </div>

                                <!-- Main Content -->
                                <div class="col-span-9 space-y-4">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-base font-bold text-slate-800 font-display">Today's Attendance</h3>
                                        <span class="text-[10px] font-mono text-slate-400">June 4, 2026</span>
                                    </div>
                                    <!-- Stat Cards -->
                                    <div class="grid grid-cols-4 gap-3">
                                        <div class="p-3 rounded-xl bg-emerald-50 border border-emerald-100">
                                            <p class="text-lg font-bold font-display text-emerald-700">142</p>
                                            <p class="text-[10px] text-emerald-600 font-medium">Present</p>
                                        </div>
                                        <div class="p-3 rounded-xl bg-amber-50 border border-amber-100">
                                            <p class="text-lg font-bold font-display text-amber-700">8</p>
                                            <p class="text-[10px] text-amber-600 font-medium">Late</p>
                                        </div>
                                        <div class="p-3 rounded-xl bg-indigo-50 border border-indigo-100">
                                            <p class="text-lg font-bold font-display text-indigo-700">12</p>
                                            <p class="text-[10px] text-indigo-600 font-medium">WFH</p>
                                        </div>
                                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
                                            <p class="text-lg font-bold font-display text-slate-700">5</p>
                                            <p class="text-[10px] text-slate-500 font-medium">On Leave</p>
                                        </div>
                                    </div>
                                    <!-- Employee list preview -->
                                    <div class="rounded-xl border border-slate-200 overflow-hidden">
                                        <div class="grid grid-cols-5 gap-1 px-3 py-2 bg-slate-50 border-b border-slate-100 text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                                            <span class="col-span-2">Employee</span>
                                            <span>Clock In</span>
                                            <span>Branch</span>
                                            <span>Status</span>
                                        </div>
                                        <div class="divide-y divide-slate-50">
                                            <div class="grid grid-cols-5 gap-1 px-3 py-2.5 text-[11px] items-center">
                                                <span class="col-span-2 font-semibold text-slate-700">Sarah Chen</span>
                                                <span class="text-slate-500 font-mono">09:02</span>
                                                <span class="text-slate-500">Remote</span>
                                                <span class="text-emerald-600 font-semibold">Present</span>
                                            </div>
                                            <div class="grid grid-cols-5 gap-1 px-3 py-2.5 text-[11px] items-center">
                                                <span class="col-span-2 font-semibold text-slate-700">Alex Morgan</span>
                                                <span class="text-slate-500 font-mono">09:05</span>
                                                <span class="text-slate-500">HQ</span>
                                                <span class="text-emerald-600 font-semibold">Present</span>
                                            </div>
                                            <div class="grid grid-cols-5 gap-1 px-3 py-2.5 text-[11px] items-center">
                                                <span class="col-span-2 font-semibold text-slate-700">Mike Ross</span>
                                                <span class="text-slate-500 font-mono">—</span>
                                                <span class="text-slate-500">—</span>
                                                <span class="text-amber-600 font-semibold">On Leave</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Slide 2: Leave Calendar --}}
                        <div class="w-full shrink-0 p-6 lg:p-8">
                            <div class="grid grid-cols-12 gap-5">
                                <div class="col-span-3 space-y-3">
                                    <div class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-50">
                                        <div class="w-5 h-5 rounded-md bg-slate-100 flex items-center justify-center">
                                            <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </div>
                                        <span class="text-[11px] font-medium text-slate-500">Attendance</span>
                                    </div>
                                    <div class="flex items-center gap-2 px-3 py-2 rounded-lg bg-indigo-50 border border-indigo-100">
                                        <div class="w-5 h-5 rounded-md bg-indigo-500 flex items-center justify-center">
                                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                        <span class="text-[11px] font-bold text-indigo-700">Leaves</span>
                                    </div>
                                    <div class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-50">
                                        <div class="w-5 h-5 rounded-md bg-slate-100 flex items-center justify-center">
                                            <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                        </div>
                                        <span class="text-[11px] font-medium text-slate-500">Reports</span>
                                    </div>
                                </div>

                                <div class="col-span-9 space-y-4">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-base font-bold text-slate-800 font-display">Team Leave Calendar</h3>
                                        <span class="text-[10px] font-mono text-slate-400">June 2026</span>
                                    </div>
                                    <!-- Mini Calendar Grid -->
                                    <div class="rounded-xl border border-slate-200 overflow-hidden">
                                        <div class="grid grid-cols-7 text-center text-[10px] font-bold text-slate-400 uppercase py-2 bg-slate-50 border-b border-slate-100">
                                            <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span>
                                        </div>
                                        <div class="grid grid-cols-7 text-center text-[11px]">
                                            @for($d = 1; $d <= 28; $d++)
                                                <div class="py-2 border-b border-r border-slate-50 relative {{ in_array($d, [7, 14, 21, 28, 6, 13, 20, 27]) ? 'bg-slate-50/50 text-slate-300' : '' }}">
                                                    <span class="{{ $d == 4 ? 'font-bold text-indigo-600' : 'text-slate-600' }}">{{ $d }}</span>
                                                    @if($d == 5)
                                                        <div class="absolute bottom-0.5 left-1/2 -translate-x-1/2 w-4 h-0.5 rounded-full bg-amber-400"></div>
                                                    @endif
                                                    @if($d == 6)
                                                        <div class="absolute bottom-0.5 left-1/2 -translate-x-1/2 w-4 h-0.5 rounded-full bg-indigo-400"></div>
                                                    @endif
                                                    @if($d >= 9 && $d <= 11)
                                                        <div class="absolute bottom-0.5 left-1/2 -translate-x-1/2 w-4 h-0.5 rounded-full bg-emerald-400"></div>
                                                    @endif
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                    <!-- Legend -->
                                    <div class="flex items-center gap-4 text-[10px]">
                                        <div class="flex items-center gap-1.5"><div class="w-3 h-1 rounded-full bg-amber-400"></div><span class="text-slate-500">Casual Leave</span></div>
                                        <div class="flex items-center gap-1.5"><div class="w-3 h-1 rounded-full bg-indigo-400"></div><span class="text-slate-500">WFH</span></div>
                                        <div class="flex items-center gap-1.5"><div class="w-3 h-1 rounded-full bg-emerald-400"></div><span class="text-slate-500">Paid Leave</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Slide 3: Productivity Report --}}
                        <div class="w-full shrink-0 p-6 lg:p-8">
                            <div class="grid grid-cols-12 gap-5">
                                <div class="col-span-3 space-y-3">
                                    <div class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-50">
                                        <div class="w-5 h-5 rounded-md bg-slate-100 flex items-center justify-center">
                                            <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </div>
                                        <span class="text-[11px] font-medium text-slate-500">Attendance</span>
                                    </div>
                                    <div class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-50">
                                        <div class="w-5 h-5 rounded-md bg-slate-100 flex items-center justify-center">
                                            <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                        <span class="text-[11px] font-medium text-slate-500">Leaves</span>
                                    </div>
                                    <div class="flex items-center gap-2 px-3 py-2 rounded-lg bg-indigo-50 border border-indigo-100">
                                        <div class="w-5 h-5 rounded-md bg-indigo-500 flex items-center justify-center">
                                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                        </div>
                                        <span class="text-[11px] font-bold text-indigo-700">Reports</span>
                                    </div>
                                </div>

                                <div class="col-span-9 space-y-4">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-base font-bold text-slate-800 font-display">Productivity Report</h3>
                                        <span class="text-[10px] font-mono text-slate-400">This Week</span>
                                    </div>
                                    <!-- Bar Chart -->
                                    <div class="rounded-xl border border-slate-200 p-4">
                                        <div class="flex items-end justify-between gap-3" style="height: 140px;">
                                            <div class="flex-1 flex flex-col items-center gap-2">
                                                <div class="w-full bg-indigo-400 rounded-t-md" style="height: 85%"></div>
                                                <span class="text-[10px] text-slate-400 font-mono">Mon</span>
                                            </div>
                                            <div class="flex-1 flex flex-col items-center gap-2">
                                                <div class="w-full bg-indigo-500 rounded-t-md" style="height: 92%"></div>
                                                <span class="text-[10px] text-slate-400 font-mono">Tue</span>
                                            </div>
                                            <div class="flex-1 flex flex-col items-center gap-2">
                                                <div class="w-full bg-indigo-400 rounded-t-md" style="height: 78%"></div>
                                                <span class="text-[10px] text-slate-400 font-mono">Wed</span>
                                            </div>
                                            <div class="flex-1 flex flex-col items-center gap-2">
                                                <div class="w-full bg-indigo-600 rounded-t-md" style="height: 100%"></div>
                                                <span class="text-[10px] text-slate-400 font-mono">Thu</span>
                                            </div>
                                            <div class="flex-1 flex flex-col items-center gap-2">
                                                <div class="w-full bg-indigo-300 rounded-t-md" style="height: 60%"></div>
                                                <span class="text-[10px] text-slate-400 font-mono">Fri</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Summary stats -->
                                    <div class="grid grid-cols-3 gap-3">
                                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 text-center">
                                            <p class="text-lg font-bold font-display text-slate-800">40.5h</p>
                                            <p class="text-[10px] text-slate-500 font-medium">Total Hours</p>
                                        </div>
                                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 text-center">
                                            <p class="text-lg font-bold font-display text-emerald-600">97%</p>
                                            <p class="text-[10px] text-slate-500 font-medium">Compliance</p>
                                        </div>
                                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 text-center">
                                            <p class="text-lg font-bold font-display text-indigo-600">12</p>
                                            <p class="text-[10px] text-slate-500 font-medium">Tasks Done</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Navigation Dots + Arrows -->
            <div class="flex items-center justify-center gap-6 mt-8">
                <button @click="prev(); clearInterval(interval); start()" class="w-9 h-9 rounded-full border border-slate-200 bg-white flex items-center justify-center hover:border-indigo-300 hover:bg-indigo-50 transition-all group">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <div class="flex items-center gap-2.5">
                    <template x-for="i in slides" :key="i">
                        <button @click="goTo(i - 1)" class="transition-all duration-300 rounded-full"
                                :class="active === i - 1 ? 'w-8 h-2.5 bg-indigo-500' : 'w-2.5 h-2.5 bg-slate-300 hover:bg-slate-400'"></button>
                    </template>
                </div>
                <button @click="next(); clearInterval(interval); start()" class="w-9 h-9 rounded-full border border-slate-200 bg-white flex items-center justify-center hover:border-indigo-300 hover:bg-indigo-50 transition-all group">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>

            <!-- Slide Labels -->
            <div class="flex items-center justify-center gap-8 mt-4">
                <button @click="goTo(0)" class="text-[11px] font-semibold transition-colors" :class="active === 0 ? 'text-indigo-600' : 'text-slate-400 hover:text-slate-600'">Attendance</button>
                <button @click="goTo(1)" class="text-[11px] font-semibold transition-colors" :class="active === 1 ? 'text-indigo-600' : 'text-slate-400 hover:text-slate-600'">Leave Calendar</button>
                <button @click="goTo(2)" class="text-[11px] font-semibold transition-colors" :class="active === 2 ? 'text-indigo-600' : 'text-slate-400 hover:text-slate-600'">Productivity</button>
            </div>

        </div>
    </div>
</section>
