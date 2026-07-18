<section class="py-32 bg-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-24 items-center">
            
            {{-- Text Content --}}
            <div class="max-w-xl marketing-section-copy">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-accent-50 text-accent-600 text-xs font-semibold tracking-wide uppercase mb-6 border border-accent-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" /></svg>
                    Workflow Policies
                </div>
                
                <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight mb-6">
                    Strict when you need it, <br class="hidden md:block"/>
                    <span class="text-accent-600">flexible when you don't.</span>
                </h2>
                
                <p class="text-lg text-slate-500 mb-8 leading-relaxed">
                    TimeNest gives you the power to define exact workflows for every team. Enforce strict check-in rules for hourly workers, or enable flexible, outcome-based tracking for salaried teams. It adapts to your business logic, not the other way around.
                </p>
                
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-accent-50 flex items-center justify-center text-accent-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900 mb-1">Strict Compliance</h3>
                            <p class="text-sm text-slate-500">Lock down check-ins by IP address, device, or precise location coordinates.</p>
                        </div>
                    </div>
                    
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-accent-50 flex items-center justify-center text-accent-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900 mb-1">Flexible Tracking</h3>
                            <p class="text-sm text-slate-500">Allow self-reported hours and trust-based tracking for remote knowledge workers.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Visual Content --}}
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-tr from-accent-100 to-white rounded-3xl transform rotate-3 scale-105 opacity-50"></div>
                <div class="bg-white border border-slate-100 shadow-xl rounded-3xl p-8 relative z-10 flex flex-col gap-6">
                    
                    {{-- UI Mockup: Policy Selector --}}
                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-sm font-bold text-slate-800">Support Team Policy</div>
                            <span class="px-2 py-1 bg-white text-slate-500 text-xs font-semibold rounded-md border border-slate-200">Active</span>
                        </div>
                        
                        <div class="space-y-3">
                            <label class="flex items-start gap-3 p-3 bg-white rounded-xl border-2 border-accent-500 cursor-pointer shadow-sm">
                                <input type="radio" name="policy" checked class="mt-1 w-4 h-4 text-accent-600 border-slate-300 focus:ring-accent-500">
                                <div>
                                    <div class="text-sm font-bold text-slate-900">Strict Enforcement</div>
                                    <div class="text-xs text-slate-500 mt-0.5">Requires Geofence & Device Validation</div>
                                </div>
                            </label>
                            
                            <label class="flex items-start gap-3 p-3 bg-white rounded-xl border border-slate-200 cursor-pointer opacity-70 hover:opacity-100 transition-opacity">
                                <input type="radio" name="policy" class="mt-1 w-4 h-4 text-accent-600 border-slate-300 focus:ring-accent-500">
                                <div>
                                    <div class="text-sm font-bold text-slate-900">Flexible Trust</div>
                                    <div class="text-xs text-slate-500 mt-0.5">Manual entry with manager approval</div>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                </div>
            </div>

        </div>
    </div>
</section>
