<section class="py-32 bg-slate-50 relative overflow-hidden border-b border-slate-200/50">
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-24 items-center">
            
            {{-- Visual Content (Left on desktop, bottom on mobile) --}}
            <div class="order-2 lg:order-1 relative">
                <div class="absolute inset-0 bg-gradient-to-tr from-blue-100 to-white rounded-3xl transform -rotate-3 scale-105 opacity-50"></div>
                <div class="bg-white border border-slate-100 shadow-xl rounded-3xl p-8 relative z-10">
                    
                    {{-- UI Mockup: Leave Request --}}
                    <div class="space-y-4">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-sm font-bold text-slate-800">Leave Approval Workflow</h4>
                            <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-2 py-1 rounded">2 Pending</span>
                        </div>
                        
                        {{-- Pending Request --}}
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                            <div class="flex items-center gap-3 mb-3">
                                <img src="https://randomuser.me/api/portraits/men/54.jpg" class="w-8 h-8 rounded-full" alt="avatar">
                                <div class="flex-1">
                                    <div class="text-sm font-bold text-slate-900">James Anderson</div>
                                    <div class="text-xs text-slate-500">Requested <span class="font-semibold text-slate-700">3 Days</span> of Paid Time Off</div>
                                </div>
                            </div>
                            
                            {{-- Leave Balance Bar --}}
                            <div class="mb-4">
                                <div class="flex justify-between text-[10px] font-semibold text-slate-500 mb-1">
                                    <span>Remaining Quota (12 Days)</span>
                                    <span>Will be 9 Days</span>
                                </div>
                                <div class="w-full h-1.5 bg-slate-200 rounded-full overflow-hidden flex">
                                    <div class="h-full bg-emerald-500 w-[60%]"></div>
                                    <div class="h-full bg-blue-400 w-[15%]"></div>
                                </div>
                            </div>
                            
                            {{-- Multi-level Approval --}}
                            <div class="flex items-center gap-2 mb-4 text-xs font-medium">
                                <div class="w-6 h-6 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                                </div>
                                <div class="text-slate-400">—</div>
                                <div class="w-6 h-6 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center animate-pulse">
                                    <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>
                                </div>
                                <div class="text-slate-400">—</div>
                                <div class="w-6 h-6 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center">
                                    HR
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <button class="py-2 bg-white border border-slate-200 text-slate-700 text-xs font-bold rounded-lg hover:bg-slate-50 transition">Reject</button>
                                <button class="py-2 bg-blue-600 text-white text-xs font-bold rounded-lg shadow-sm hover:bg-blue-700 transition">Approve Level 2</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Text Content (Right on desktop, top on mobile) --}}
            <div class="order-1 lg:order-2 max-w-xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-xs font-semibold tracking-wide uppercase mb-6 border border-blue-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    Leave & Time Off
                </div>
                
                <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight mb-6">
                    Handle time off <br class="hidden md:block"/>
                    <span class="text-blue-600">without the spreadsheets.</span>
                </h2>
                
                <p class="text-lg text-slate-500 mb-8 leading-relaxed">
                    Set custom quotas, configure multi-level approval cycles, and track everything from paid vacation to remote WFH days. TimeNest automatically adjusts payroll compliance and synchronizes with your custom holiday calendars.
                </p>
                
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <div class="mt-1 flex-shrink-0 w-5 h-5 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div>
                            <strong class="text-slate-900">Custom Quotas & Accruals:</strong> Automatically grant leave based on tenure, role, or custom company policies.
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="mt-1 flex-shrink-0 w-5 h-5 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div>
                            <strong class="text-slate-900">Approval Workflows:</strong> Route requests to direct managers, then HR, seamlessly via the app.
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="mt-1 flex-shrink-0 w-5 h-5 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div>
                            <strong class="text-slate-900">Holiday Calendars:</strong> Support multiple regional holidays for distributed global teams.
                        </div>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</section>
