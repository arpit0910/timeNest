<section class="py-16 bg-white relative px-6">
    <div class="max-w-7xl mx-auto">
        <div class="relative rounded-[2.5rem] overflow-hidden bg-slate-900 border border-slate-800 shadow-2xl">
            
            {{-- Background Effects --}}
            <div class="absolute inset-0 z-0">
                <div class="absolute inset-0" style="background-image: linear-gradient(to right, #334155 1px, transparent 1px), linear-gradient(to bottom, #334155 1px, transparent 1px); background-size: 32px 32px; opacity: 0.2; mask-image: radial-gradient(circle at center, black 40%, transparent 100%); -webkit-mask-image: radial-gradient(circle at center, black 40%, transparent 100%);"></div>
                <div class="absolute -right-64 -top-64 w-[800px] h-[800px] bg-indigo-600/30 rounded-full filter blur-[150px] pointer-events-none"></div>
                <div class="absolute -left-64 -bottom-64 w-[800px] h-[800px] bg-blue-600/20 rounded-full filter blur-[150px] pointer-events-none"></div>
            </div>

            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-8 items-center p-8 md:p-12">
                
                {{-- Text --}}
                <div>
                    <h2 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight leading-tight mb-4">
                        Ready to automate your workforce?
                    </h2>
                    <p class="text-lg text-white mb-8 max-w-lg">
                        Join 10,000+ companies using TimeNest to manage shifts, process leave, and handle complex payroll effortlessly.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 max-w-md">
                        <x-ui.button href="#" class="w-full sm:w-auto">Book a demo</x-ui.button>
                        <x-ui.button variant="secondary" href="/contact" class="w-full sm:w-auto">Contact us</x-ui.button>
                    </div>
                    <p class="text-xs text-slate-400 mt-4">No credit card required. 14-day free trial.</p>
                </div>

                {{-- Images/Avatars Collage --}}
                <div class="relative hidden md:flex items-center justify-center lg:justify-end">
                    <div class="relative w-full max-w-md h-[300px]">
                        {{-- Decorative Elements --}}
                        <div class="absolute right-0 top-0 w-32 h-40 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-4 shadow-2xl rotate-6 transform hover:rotate-12 transition duration-500">
                            <div class="w-full h-24 rounded-lg bg-indigo-500/20 mb-2"></div>
                            <div class="w-2/3 h-2 rounded bg-white/20"></div>
                        </div>
                        
                        <div class="absolute left-10 bottom-0 w-48 h-32 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-4 shadow-2xl -rotate-6 transform hover:-rotate-12 transition duration-500 z-20">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-8 h-8 rounded-full bg-emerald-400/20 flex items-center justify-center text-emerald-400">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div>
                                    <div class="h-2 w-16 bg-white/30 rounded mb-1.5"></div>
                                    <div class="h-1.5 w-10 bg-white/10 rounded"></div>
                                </div>
                            </div>
                            <div class="w-full h-1.5 bg-white/10 rounded mb-1.5"></div>
                            <div class="w-4/5 h-1.5 bg-white/10 rounded"></div>
                        </div>
                        
                        {{-- Center Main Element --}}
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-56 bg-slate-800 border border-slate-700 rounded-3xl p-5 shadow-2xl z-10">
                            <div class="flex justify-center mb-4">
                                <img src="https://randomuser.me/api/portraits/men/32.jpg" class="w-16 h-16 rounded-full border-4 border-slate-900 shadow-md" alt="User">
                            </div>
                            <div class="text-center">
                                <div class="text-white font-bold text-sm">Welcome back, Alex</div>
                                <div class="text-indigo-300 text-xs mt-1">Clock in for your shift</div>
                            </div>
                            <div class="mt-4 bg-indigo-500 text-white text-center text-sm font-bold py-2 rounded-xl shadow-inner cursor-pointer hover:bg-indigo-400 transition">
                                Clock In Now
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
