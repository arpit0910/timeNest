<section class="py-32 bg-slate-950 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-24 items-center">
            
            {{-- Text Content --}}
            <div class="max-w-xl marketing-section-copy">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-white/80 text-xs font-semibold tracking-wide uppercase mb-6 border border-white/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" /></svg>
                    Workflow Policies
                </div>
                
                <h2 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight leading-tight mb-6">
                    Strict when you need it, <br class="hidden md:block"/>
                    <span class="text-accent-400">flexible when you don't.</span>
                </h2>
                
                <p class="text-lg text-slate-400 mb-8 leading-relaxed">
                    TimeNest gives you the power to define exact workflows for every team. Enforce strict check-in rules for hourly workers, or enable flexible, outcome-based tracking for salaried teams. It adapts to your business logic, not the other way around.
                </p>
                
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-accent-500/15 flex items-center justify-center text-accent-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-white mb-1">Strict Compliance</h3>
                            <p class="text-sm text-slate-400">Lock down check-ins by IP address, device, or precise location coordinates.</p>
                        </div>
                    </div>
                    
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-accent-500/15 flex items-center justify-center text-accent-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-white mb-1">Flexible Tracking</h3>
                            <p class="text-sm text-slate-400">Allow self-reported hours and trust-based tracking for remote knowledge workers.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Visual Content --}}
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-tr from-accent-500/20 to-slate-900 rounded-3xl transform rotate-3 scale-105 opacity-50"></div>
                <div class="bg-slate-900/50 backdrop-blur-md border border-white/10 shadow-xl rounded-3xl p-8 relative z-10 flex flex-col gap-6">
                    
                    {{-- UI Mockup: Policy Selector --}}
                    <div class="bg-white/5 rounded-2xl p-6 border border-white/10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-sm font-bold text-white">Support Team Policy</div>
                            <span class="px-2 py-1 bg-accent-500/20 text-accent-400 text-xs font-semibold rounded-md border border-accent-500/30">Active</span>
                        </div>
                        
                        <div class="space-y-3">
                            <label class="flex items-start gap-3 p-3 bg-white/10 rounded-xl border-2 border-accent-500 cursor-pointer shadow-sm">
                                <input type="radio" name="policy" checked class="mt-1 w-4 h-4 text-accent-500 border-white/20 bg-transparent focus:ring-accent-500 focus:ring-offset-slate-900">
                                <div>
                                    <div class="text-sm font-bold text-white">Strict Enforcement</div>
                                    <div class="text-xs text-slate-400 mt-0.5">Requires Geofence & Device Validation</div>
                                </div>
                            </label>
                            
                            <label class="flex items-start gap-3 p-3 bg-white/5 rounded-xl border border-white/10 cursor-pointer opacity-70 hover:opacity-100 transition-opacity">
                                <input type="radio" name="policy" class="mt-1 w-4 h-4 text-accent-500 border-white/20 bg-transparent focus:ring-accent-500 focus:ring-offset-slate-900">
                                <div>
                                    <div class="text-sm font-bold text-slate-300">Flexible Trust</div>
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
