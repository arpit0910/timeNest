<header 
    x-data="{ open: false, scrolled: false }" 
    @scroll.window="scrolled = (window.pageYOffset > 10)"
    :class="{ 'shadow-xl shadow-indigo-100/50 bg-white/90 backdrop-blur-md': scrolled, 'bg-white shadow-sm': !scrolled }"
    class="fixed top-4 left-1/2 -translate-x-1/2 z-50 w-[95%] max-w-5xl rounded-full transition-all duration-300"
>
    <div class="px-6 py-3 mx-auto flex items-center justify-between">
        
        {{-- Left: Logo --}}
        <a href="/" class="flex items-center gap-2 group outline-none">
            <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32' class="w-8 h-8 transition-transform group-hover:scale-105">
                <path d='M28 16 A12 12 0 1 0 16 28' stroke='#4f46e5' stroke-width='1.8' fill='none' stroke-linecap='round'/>
                <path d='M23 16 A7 7 0 1 0 16 23' stroke='#0f172a' stroke-width='1.8' fill='none' stroke-linecap='round'/>
                <path d='M19 16 A3 3 0 1 0 16 19' stroke='#0f172a' stroke-width='1.8' fill='none' stroke-linecap='round'/>
            </svg>
            <span class="font-bold text-xl text-slate-900 tracking-tight">TimeNest</span>
        </a>

        {{-- Center: Nav Links (Desktop) --}}
        <nav class="hidden md:flex items-center gap-8">
            <a href="#" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">Features</a>
            <a href="#" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">Solutions</a>
            <a href="#" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">Security</a>
            <a href="#" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">Pricing</a>
            <a href="#" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">About</a>
        </nav>

        {{-- Right: Actions (Desktop) --}}
        <div class="hidden md:flex items-center gap-4">
            <a href="#" class="text-sm font-medium text-slate-700 hover:text-indigo-600 transition-colors">Contact us</a>
            <x-ui.button href="#">Book a demo</x-ui.button>
        </div>

        {{-- Mobile Hamburger --}}
        <div class="md:hidden flex items-center gap-4">
            <x-ui.button href="#" class="!px-3 !py-1.5 text-xs">Book a demo</x-ui.button>
            <button @click="open = !open" class="text-slate-600 hover:text-slate-900 focus:outline-none p-1">
                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="open" style="display: none;" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

    </div>

    {{-- Mobile Menu --}}
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         style="display: none;"
         class="absolute top-full left-0 w-full mt-2 bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden md:hidden">
        
        <div class="p-4 flex flex-col gap-4">
            <a href="#" class="text-base font-medium text-slate-700 hover:text-indigo-600">Features</a>
            <a href="#" class="text-base font-medium text-slate-700 hover:text-indigo-600">Solutions</a>
            <a href="#" class="text-base font-medium text-slate-700 hover:text-indigo-600">Security</a>
            <a href="#" class="text-base font-medium text-slate-700 hover:text-indigo-600">Pricing</a>
            <a href="#" class="text-base font-medium text-slate-700 hover:text-indigo-600">About</a>
            <hr class="border-slate-100">
            <a href="#" class="text-base font-medium text-slate-700 hover:text-indigo-600">Contact us</a>
        </div>
    </div>
</header>
