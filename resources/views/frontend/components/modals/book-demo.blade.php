<div x-data="{ 
         open: false,
         interests: { attendance: false, productivity: false, leave: false, platform: false }
     }" 
     @open-book-demo.window="open = true; $nextTick(() => { $refs.fullName && $refs.fullName.focus() })" 
     @keydown.escape.window="open = false"
     class="relative z-[100]" 
     aria-labelledby="book-demo-modal-title" 
     role="dialog" 
     aria-modal="true"
     x-cloak>

    <!-- Background backdrop -->
    <div x-show="open" 
         x-transition:enter="ease-out duration-300" 
         x-transition:enter-start="opacity-0" 
         x-transition:enter-end="opacity-100" 
         x-transition:leave="ease-in duration-200" 
         x-transition:leave-start="opacity-100" 
         x-transition:leave-end="opacity-0" 
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"
         @click="open = false"></div>

    <div x-show="open" class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <!-- Modal panel -->
            <div x-show="open" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 w-full sm:max-w-4xl border border-slate-100"
                 @click.away="open = false">
                
                <!-- Close button -->
                <div class="absolute top-4 right-4 z-20">
                    <button type="button" @click="open = false" class="rounded-full bg-white/80 backdrop-blur-sm text-slate-400 hover:text-slate-600 hover:bg-white p-2 transition-all shadow-sm border border-slate-200/50">
                        <span class="sr-only">Close</span>
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12">
                    
                    <!-- ═══════════════════════════ -->
                    <!-- LEFT PANEL: Brand / Info    -->
                    <!-- ═══════════════════════════ -->
                    <div class="lg:col-span-5 bg-gradient-to-br from-slate-900 via-slate-800 to-indigo-900 p-8 lg:p-10 relative overflow-hidden flex flex-col justify-between min-h-[280px] lg:min-h-0">
                        <!-- Decorative glow -->
                        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/15 rounded-full blur-[80px] pointer-events-none"></div>
                        <div class="absolute bottom-0 left-0 w-48 h-48 bg-cyan-500/10 rounded-full blur-[60px] pointer-events-none"></div>

                        <div class="relative z-10">
                            <!-- Logo -->
                            <div class="flex items-center gap-2 mb-8">
                                <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <span class="font-display font-bold text-white text-sm tracking-wide">TimeNest</span>
                            </div>

                            <h3 class="font-display text-2xl lg:text-3xl font-bold text-white mb-3 leading-tight" id="book-demo-modal-title">
                                See TimeNest<br>in action
                            </h3>
                            <p class="text-sm text-slate-300 font-body leading-relaxed mb-8">
                                Discover how your organization can automate attendance, productivity tracking and workforce operations.
                            </p>

                            <!-- Benefit Points -->
                            <div class="space-y-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-5 h-5 rounded-full bg-emerald-500/20 flex items-center justify-center shrink-0">
                                        <svg class="w-3 h-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span class="text-sm text-slate-200">Smart attendance workflows</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-5 h-5 rounded-full bg-emerald-500/20 flex items-center justify-center shrink-0">
                                        <svg class="w-3 h-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span class="text-sm text-slate-200">Employee productivity visibility</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-5 h-5 rounded-full bg-emerald-500/20 flex items-center justify-center shrink-0">
                                        <svg class="w-3 h-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <span class="text-sm text-slate-200">Flexible workforce policies</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ═══════════════════════════ -->
                    <!-- RIGHT PANEL: Form           -->
                    <!-- ═══════════════════════════ -->
                    <div class="lg:col-span-7 p-6 sm:p-8 lg:p-10 max-h-[80vh] overflow-y-auto">
                        <h4 class="font-display font-bold text-xl text-slate-900 mb-1 lg:hidden">Book a Demo</h4>
                        <p class="text-sm text-slate-500 mb-6 lg:hidden">Fill in your details and we'll get back to you.</p>

                        <form @submit.prevent="$dispatch('demo-form-submitted')" class="space-y-5">
                            <!-- Full Name -->
                            <div>
                                <label for="demo-full-name" class="block text-sm font-semibold text-slate-700 mb-1.5">Full Name</label>
                                <input x-ref="fullName" type="text" id="demo-full-name" name="full_name" required
                                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-400 transition-all bg-slate-50/50"
                                       placeholder="John Smith">
                            </div>

                            <!-- Company Name -->
                            <div>
                                <label for="demo-company-name" class="block text-sm font-semibold text-slate-700 mb-1.5">Company Name</label>
                                <input type="text" id="demo-company-name" name="company_name" required
                                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-400 transition-all bg-slate-50/50"
                                       placeholder="Acme Corp">
                            </div>

                            <!-- Email & Phone (side by side) -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="demo-email" class="block text-sm font-semibold text-slate-700 mb-1.5">Business Email</label>
                                    <input type="email" id="demo-email" name="email" required
                                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-400 transition-all bg-slate-50/50"
                                           placeholder="john@acme.com">
                                </div>
                                <div>
                                    <label for="demo-phone" class="block text-sm font-semibold text-slate-700 mb-1.5">Phone Number</label>
                                    <input type="tel" id="demo-phone" name="phone"
                                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-400 transition-all bg-slate-50/50"
                                           placeholder="+91 98765 43210">
                                </div>
                            </div>

                            <!-- Company Size -->
                            <div>
                                <label for="demo-company-size" class="block text-sm font-semibold text-slate-700 mb-1.5">Company Size</label>
                                <select id="demo-company-size" name="company_size" required
                                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-400 transition-all bg-slate-50/50 appearance-none"
                                        style="background-image: url(&quot;data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e&quot;); background-position: right 0.75rem center; background-repeat: no-repeat; background-size: 1.25rem;">
                                    <option value="" disabled selected>Select company size</option>
                                    <option value="1-10">1–10 employees</option>
                                    <option value="11-50">11–50 employees</option>
                                    <option value="51-200">51–200 employees</option>
                                    <option value="201-500">201–500 employees</option>
                                    <option value="500+">500+ employees</option>
                                </select>
                            </div>

                            <!-- Interested In -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Interested In</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <label @click="interests.attendance = !interests.attendance"
                                           class="flex items-center gap-2 px-3 py-2.5 rounded-xl border cursor-pointer transition-all text-sm"
                                           :class="interests.attendance ? 'border-indigo-400 bg-indigo-50 text-indigo-700 ring-1 ring-indigo-400' : 'border-slate-200 text-slate-600 hover:border-slate-300 hover:bg-slate-50'">
                                        <div class="w-4 h-4 rounded border flex items-center justify-center shrink-0 transition-all"
                                             :class="interests.attendance ? 'bg-indigo-500 border-indigo-500' : 'border-slate-300 bg-white'">
                                            <svg x-show="interests.attendance" class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                        Attendance
                                    </label>
                                    <label @click="interests.productivity = !interests.productivity"
                                           class="flex items-center gap-2 px-3 py-2.5 rounded-xl border cursor-pointer transition-all text-sm"
                                           :class="interests.productivity ? 'border-indigo-400 bg-indigo-50 text-indigo-700 ring-1 ring-indigo-400' : 'border-slate-200 text-slate-600 hover:border-slate-300 hover:bg-slate-50'">
                                        <div class="w-4 h-4 rounded border flex items-center justify-center shrink-0 transition-all"
                                             :class="interests.productivity ? 'bg-indigo-500 border-indigo-500' : 'border-slate-300 bg-white'">
                                            <svg x-show="interests.productivity" class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                        Productivity
                                    </label>
                                    <label @click="interests.leave = !interests.leave"
                                           class="flex items-center gap-2 px-3 py-2.5 rounded-xl border cursor-pointer transition-all text-sm"
                                           :class="interests.leave ? 'border-indigo-400 bg-indigo-50 text-indigo-700 ring-1 ring-indigo-400' : 'border-slate-200 text-slate-600 hover:border-slate-300 hover:bg-slate-50'">
                                        <div class="w-4 h-4 rounded border flex items-center justify-center shrink-0 transition-all"
                                             :class="interests.leave ? 'bg-indigo-500 border-indigo-500' : 'border-slate-300 bg-white'">
                                            <svg x-show="interests.leave" class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                        Leave Mgmt
                                    </label>
                                    <label @click="interests.platform = !interests.platform"
                                           class="flex items-center gap-2 px-3 py-2.5 rounded-xl border cursor-pointer transition-all text-sm"
                                           :class="interests.platform ? 'border-indigo-400 bg-indigo-50 text-indigo-700 ring-1 ring-indigo-400' : 'border-slate-200 text-slate-600 hover:border-slate-300 hover:bg-slate-50'">
                                        <div class="w-4 h-4 rounded border flex items-center justify-center shrink-0 transition-all"
                                             :class="interests.platform ? 'bg-indigo-500 border-indigo-500' : 'border-slate-300 bg-white'">
                                            <svg x-show="interests.platform" class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                        Complete Platform
                                    </label>
                                </div>
                            </div>

                            <!-- Message -->
                            <div>
                                <label for="demo-message" class="block text-sm font-semibold text-slate-700 mb-1.5">Message <span class="text-slate-400 font-normal">(optional)</span></label>
                                <textarea id="demo-message" name="message" rows="3"
                                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-400 transition-all bg-slate-50/50 resize-none"
                                          placeholder="Tell us about your requirements..."></textarea>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit"
                                    class="w-full py-3.5 px-6 bg-slate-900 text-white rounded-xl font-bold text-sm hover:bg-slate-800 transition-all shadow-md shadow-slate-900/10 relative overflow-hidden group">
                                <span class="relative z-10 flex items-center justify-center gap-2">
                                    Schedule Demo
                                    <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </span>
                                <div class="btn-shine"></div>
                            </button>

                            <p class="text-center text-[11px] text-slate-400">
                                By submitting, you agree to our <a href="/legal/privacy" class="underline hover:text-slate-600">Privacy Policy</a>.
                            </p>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
