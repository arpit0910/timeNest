<section class="py-32 bg-black relative">
    <div class="max-w-4xl mx-auto px-6 relative z-10">
        
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight mb-4">
                Frequently Asked Questions
            </h2>
            <p class="text-lg text-neutral-400">
                Everything you need to know about implementing TimeNest.
            </p>
        </div>
        
        {{-- Alpine Accordion --}}
        <div class="space-y-4" x-data="{ active: null }">
            
            {{-- FAQ 1 --}}
            <div class="border border-white/10 rounded-2xl bg-white/5 overflow-hidden transition-colors" :class="active === 1 ? 'border-accent-500/50 bg-neutral-900 shadow-xl' : ''">
                <button @click="active = active === 1 ? null : 1" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                    <span class="text-base font-bold text-white">Can I mix flexible and strict check-in rules?</span>
                    <svg class="w-5 h-5 text-neutral-400 transform transition-transform" :class="active === 1 ? 'rotate-180 text-accent-400' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </button>
                <div x-show="active === 1" x-collapse x-cloak>
                    <div class="px-6 pb-6 text-neutral-400 leading-relaxed text-sm">
                        Yes, absolutely. TimeNest's policy engine allows you to assign rules on a per-team or even per-employee basis. You can require strict AI face-matching and geofencing for warehouse staff, while simultaneously allowing flexible, trust-based manual entries for your remote software engineering team.
                    </div>
                </div>
            </div>
            
            {{-- FAQ 2 --}}
            <div class="border border-white/10 rounded-2xl bg-white/5 overflow-hidden transition-colors" :class="active === 2 ? 'border-accent-500/50 bg-neutral-900 shadow-xl' : ''">
                <button @click="active = active === 2 ? null : 2" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                    <span class="text-base font-bold text-white">How does the AI Face Match prevent fraud?</span>
                    <svg class="w-5 h-5 text-neutral-400 transform transition-transform" :class="active === 2 ? 'rotate-180 text-accent-400' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </button>
                <div x-show="active === 2" x-collapse x-cloak>
                    <div class="px-6 pb-6 text-neutral-400 leading-relaxed text-sm">
                        When an employee clocks in using our mobile app, they must take a quick selfie. Our secure AI compares the live capture against their master profile photo, checking for both facial likeness and liveness (preventing people from holding up printed photos or screens). If there is a mismatch, the check-in is immediately flagged for manager review.
                    </div>
                </div>
            </div>

            {{-- FAQ 3 --}}
            <div class="border border-white/10 rounded-2xl bg-white/5 overflow-hidden transition-colors" :class="active === 3 ? 'border-accent-500/50 bg-neutral-900 shadow-xl' : ''">
                <button @click="active = active === 3 ? null : 3" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                    <span class="text-base font-bold text-white">Do you support multi-country holiday calendars?</span>
                    <svg class="w-5 h-5 text-neutral-400 transform transition-transform" :class="active === 3 ? 'rotate-180 text-accent-400' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </button>
                <div x-show="active === 3" x-collapse x-cloak>
                    <div class="px-6 pb-6 text-neutral-400 leading-relaxed text-sm">
                        Yes. For distributed teams, you can create customized Regional Holiday Calendars. When an employee requests leave, the system automatically subtracts only their specific working days, intelligently ignoring public holidays based on their assigned region.
                    </div>
                </div>
            </div>

            {{-- FAQ 4 --}}
            <div class="border border-white/10 rounded-2xl bg-white/5 overflow-hidden transition-colors" :class="active === 4 ? 'border-accent-500/50 bg-neutral-900 shadow-xl' : ''">
                <button @click="active = active === 4 ? null : 4" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                    <span class="text-base font-bold text-white">Is the employee chat secure?</span>
                    <svg class="w-5 h-5 text-neutral-400 transform transition-transform" :class="active === 4 ? 'rotate-180 text-accent-400' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </button>
                <div x-show="active === 4" x-collapse x-cloak>
                    <div class="px-6 pb-6 text-neutral-400 leading-relaxed text-sm">
                        Absolutely. The built-in Team & Client Chat runs on end-to-end encrypted infrastructure. It ensures that professional conversations remain securely within your organization's environment, protecting intellectual property and maintaining clear boundaries for employees.
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

