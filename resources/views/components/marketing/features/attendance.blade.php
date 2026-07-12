<section class="py-32 bg-slate-50 relative overflow-hidden border-y border-slate-200/50">
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-24 items-center">
            
            {{-- Visual Content (Left on desktop, bottom on mobile) --}}
            <div class="order-2 lg:order-1 relative">
                <div class="absolute inset-0 bg-gradient-to-tr from-blue-100 to-white rounded-3xl transform -rotate-3 scale-105 opacity-50"></div>
                <div class="bg-white border border-slate-100 shadow-xl rounded-3xl p-8 relative z-10">
                    
                    {{-- UI Mockup: Fraud Detection --}}
                    <div class="space-y-4">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="text-sm font-bold text-slate-800">Recent Check-ins</h4>
                            <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                        </div>
                        
                        {{-- Clean Check-in --}}
                        <div class="flex items-center gap-4 p-3 bg-slate-50 rounded-xl border border-slate-100">
                            <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            </div>
                            <div class="flex-1">
                                <div class="text-sm font-bold text-slate-900">Sarah Jenkins</div>
                                <div class="text-xs text-slate-500">09:02 AM • Headquarters</div>
                            </div>
                            <div class="text-right">
                                <div class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded text-center">Verified</div>
                            </div>
                        </div>

                        {{-- Flagged Check-in --}}
                        <div class="flex items-center gap-4 p-3 bg-rose-50/50 rounded-xl border border-rose-100 relative overflow-hidden">
                            <div class="absolute left-0 top-0 bottom-0 w-1 bg-rose-500"></div>
                            <div class="w-10 h-10 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                            </div>
                            <div class="flex-1">
                                <div class="text-sm font-bold text-slate-900">Mike Thompson</div>
                                <div class="text-xs text-rose-600 font-medium">Flagged: Geofence mismatch</div>
                            </div>
                            <div class="text-right">
                                <div class="text-[10px] font-bold text-rose-700 uppercase tracking-wider bg-white border border-rose-200 px-2 py-1 rounded shadow-sm">Review</div>
                            </div>
                        </div>
                        
                        {{-- AI Face Match --}}
                        <div class="mt-6 pt-4 border-t border-slate-100 flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center border border-blue-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>
                            </div>
                            <div class="text-xs font-medium text-slate-600 flex-1">AI Face Match enabled for Warehouse staff</div>
                            <x-ui.pill-badge class="!text-[9px] !py-0.5">Active</x-ui.pill-badge>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Text Content (Right on desktop, top on mobile) --}}
            <div class="order-1 lg:order-2 max-w-xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-xs font-semibold tracking-wide uppercase mb-6 border border-blue-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                    Bulletproof Attendance
                </div>
                
                <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight mb-6">
                    Eliminate buddy punching. <br class="hidden md:block"/>
                    <span class="text-blue-600">Zero exceptions.</span>
                </h2>
                
                <p class="text-lg text-slate-500 mb-8 leading-relaxed">
                    Built for the realities of modern business. We combine multi-factor identity verification with strict business logic to ensure the people checking in are exactly who they say they are, exactly where they're supposed to be.
                </p>
                
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <div class="mt-1 flex-shrink-0 w-5 h-5 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div>
                            <strong class="text-slate-900">Precision Geofencing:</strong> Restrict check-ins to specific coordinates with adjustable radius buffers.
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="mt-1 flex-shrink-0 w-5 h-5 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div>
                            <strong class="text-slate-900">AI Face Detection:</strong> Compare live camera captures against employee master photos in real-time.
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="mt-1 flex-shrink-0 w-5 h-5 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div>
                            <strong class="text-slate-900">Automated Fraud Flags:</strong> Instantly notify managers of device spoofing, location masking, or suspicious patterns.
                        </div>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</section>
