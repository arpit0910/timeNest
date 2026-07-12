<section class="py-32 bg-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-24 items-center">
            
            {{-- Text Content --}}
            <div class="max-w-xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 text-indigo-600 text-xs font-semibold tracking-wide uppercase mb-6 border border-indigo-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Shift Management
                </div>
                
                <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight mb-6">
                    Schedule complex shifts <br class="hidden md:block"/>
                    <span class="text-indigo-600">without the chaos.</span>
                </h2>
                
                <p class="text-lg text-slate-500 mb-8 leading-relaxed">
                    Build, rotate, and manage shifts for thousands of employees in minutes. Handle overlaps, night shifts, and split shifts with intelligent conflict resolution that stops scheduling errors before they happen.
                </p>
                
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-700 border border-slate-200">
                            <span class="font-bold">1</span>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900 mb-1">Dynamic Rosters</h3>
                            <p class="text-sm text-slate-500">Assign recurring shifts or one-off schedules instantly. Employees get notified via the app.</p>
                        </div>
                    </div>
                    
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-700 border border-slate-200">
                            <span class="font-bold">2</span>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900 mb-1">Conflict Engine</h3>
                            <p class="text-sm text-slate-500">Automatically warns you about double-bookings, rest period violations, and overtime thresholds.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Visual Content --}}
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-tr from-indigo-100 to-white rounded-3xl transform rotate-3 scale-105 opacity-50"></div>
                <div class="bg-white border border-slate-100 shadow-xl rounded-3xl p-6 relative z-10 flex flex-col gap-4">
                    
                    {{-- Calendar Header --}}
                    <div class="flex items-center justify-between mb-2">
                        <div class="text-sm font-bold text-slate-800">This Week's Roster</div>
                        <div class="flex gap-1 text-slate-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            <svg class="w-5 h-5 text-slate-800" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </div>

                    {{-- Shift Grid Mockup --}}
                    <div class="grid grid-cols-4 gap-2 text-center text-xs font-semibold text-slate-500 mb-2">
                        <div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div>
                    </div>

                    <div class="space-y-3">
                        {{-- Employee 1 --}}
                        <div class="grid grid-cols-4 gap-2">
                            <div class="col-span-4 flex items-center gap-2 mb-1">
                                <img src="https://randomuser.me/api/portraits/women/44.jpg" class="w-5 h-5 rounded-full" alt="avatar">
                                <span class="text-xs font-bold text-slate-700">Alice Freeman</span>
                            </div>
                            <div class="bg-blue-50 text-blue-600 border border-blue-100 rounded text-[10px] px-2 py-1.5 font-bold whitespace-nowrap">09:00 - 17:00</div>
                            <div class="bg-blue-50 text-blue-600 border border-blue-100 rounded text-[10px] px-2 py-1.5 font-bold whitespace-nowrap">09:00 - 17:00</div>
                            <div class="bg-slate-50 text-slate-400 border border-slate-100 rounded text-[10px] px-2 py-1.5 font-bold whitespace-nowrap">OFF</div>
                            <div class="bg-blue-50 text-blue-600 border border-blue-100 rounded text-[10px] px-2 py-1.5 font-bold whitespace-nowrap">09:00 - 17:00</div>
                        </div>

                        {{-- Employee 2 --}}
                        <div class="grid grid-cols-4 gap-2 pt-2 border-t border-slate-50">
                            <div class="col-span-4 flex items-center gap-2 mb-1">
                                <img src="https://randomuser.me/api/portraits/men/32.jpg" class="w-5 h-5 rounded-full" alt="avatar">
                                <span class="text-xs font-bold text-slate-700">David Kim</span>
                            </div>
                            <div class="bg-indigo-50 text-indigo-600 border border-indigo-100 rounded text-[10px] px-2 py-1.5 font-bold whitespace-nowrap">18:00 - 02:00</div>
                            <div class="bg-indigo-50 text-indigo-600 border border-indigo-100 rounded text-[10px] px-2 py-1.5 font-bold whitespace-nowrap">18:00 - 02:00</div>
                            <div class="bg-indigo-50 text-indigo-600 border border-indigo-100 rounded text-[10px] px-2 py-1.5 font-bold whitespace-nowrap">18:00 - 02:00</div>
                            <div class="bg-rose-50 text-rose-600 border border-rose-100 rounded text-[10px] px-2 py-1.5 font-bold whitespace-nowrap flex items-center justify-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                                Conflict
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>

        </div>
    </div>
</section>
