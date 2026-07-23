@props([
    'heading' => 'Ready to run your team on a secure platform?',
    'subtext' => 'Set up your organization in minutes. Rest easy knowing your attendance and payroll data is locked down.',
])
<section class="py-16 bg-white relative px-6 marketing-cta">
    <div class="max-w-7xl mx-auto">
        <div class="relative rounded-[2.5rem] overflow-hidden bg-neutral-900 border border-neutral-800 shadow-2xl">
            
            {{-- Background Effects --}}
            <div class="absolute inset-0 z-0">
                <div class="absolute inset-0" style="background-image: linear-gradient(to right, #334155 1px, transparent 1px), linear-gradient(to bottom, #334155 1px, transparent 1px); background-size: 32px 32px; opacity: 0.2; mask-image: radial-gradient(circle at center, black 40%, transparent 100%); -webkit-mask-image: radial-gradient(circle at center, black 40%, transparent 100%);"></div>
                <div class="absolute -right-64 -top-64 w-[800px] h-[800px] bg-accent-600/30 rounded-full filter blur-[150px] pointer-events-none"></div>
                <div class="absolute -left-64 -bottom-64 w-[800px] h-[800px] bg-accent-600/20 rounded-full filter blur-[150px] pointer-events-none"></div>
            </div>

            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-8 items-center p-8 md:p-12">
                
                {{-- Text --}}
                <div>
                    <h2 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight leading-tight mb-4 marketing-heading">
                        {{ $heading }}
                    </h2>
                    <p class="text-lg text-white mb-8 max-w-lg">
                        {{ $subtext }}
                    </p>
                    
                    @if(isset($buttons))
                        <div class="flex flex-col sm:flex-row gap-4 max-w-md">
                            {{ $buttons }}
                        </div>
                    @endif
                    <p class="text-xs text-neutral-400 mt-4">No credit card required. 14-day free trial.</p>
                </div>

                {{-- Images/Avatars Collage (Same as Homepage) --}}
                <div class="relative hidden md:flex items-center justify-center lg:justify-end">
                    <div class="relative w-full max-w-md h-[300px]">
                        {{-- Decorative Elements --}}
                        <div class="absolute right-0 top-0 w-32 h-40 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-4 shadow-2xl rotate-6 transform hover:rotate-12 transition duration-500">
                            <div class="w-full h-24 rounded-lg bg-accent-500/20 mb-2 border border-accent-400/20 flex items-center justify-center">
                                <svg class="w-8 h-8 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <div class="w-2/3 h-2 rounded bg-white/20"></div>
                        </div>
                        
                        <div class="absolute left-10 bottom-0 w-48 h-32 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-4 shadow-2xl -rotate-6 transform hover:-rotate-12 transition duration-500 z-20">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-8 h-8 rounded-full bg-emerald-400/20 flex items-center justify-center text-emerald-400">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
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
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-56 bg-neutral-800 border border-neutral-700 rounded-3xl p-5 shadow-2xl z-10">
                            <div class="flex justify-center mb-4">
                                <div class="w-16 h-16 rounded-full border-4 border-neutral-900 shadow-md bg-accent-500 flex items-center justify-center text-white">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path></svg>
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="text-white font-bold text-sm">Authentication</div>
                                <div class="text-accent-300 text-xs mt-1">Identity Verified</div>
                            </div>
                            <div class="mt-6 bg-emerald-500/20 text-emerald-400 text-center text-sm font-bold py-3 px-6 rounded-xl border border-emerald-500/30 w-full uppercase tracking-wider">
                                Access Granted
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
