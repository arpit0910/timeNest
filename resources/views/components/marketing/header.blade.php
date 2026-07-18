<div x-data="{ open: false, scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 10)">
    
    {{-- Gap Blocker to blur the space behind and above the floating header when scrolling --}}
    <div 
        class="fixed top-0 left-0 w-full h-5 z-40 transition-all duration-300 pointer-events-none"
        :class="scrolled ? 'bg-white/80 backdrop-blur-md' : 'bg-transparent'"
    ></div>

    <header 
        :class="{ 'shadow-xl shadow-accent-100/50 bg-white/90 backdrop-blur-md': scrolled, 'bg-white/5 backdrop-blur-sm border-white/10': !scrolled }"
        class="fixed top-4 left-1/2 -translate-x-1/2 z-50 w-[95%] max-w-6xl rounded-full transition-all duration-300 border border-transparent"
    >
    <div class="px-6 py-3 mx-auto flex items-center justify-between">
        
        {{-- Left: Logo --}}
        <a href="/" class="flex items-center gap-2 group outline-none">
            <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32' class="w-8 h-8 transition-transform group-hover:scale-105">
                <path d='M28 16 A12 12 0 1 0 16 28' :stroke="scrolled ? '#6853a4' : '#9b7dd0'" stroke-width='1.8' fill='none' stroke-linecap='round'/>
                <path d='M23 16 A7 7 0 1 0 16 23' :stroke="scrolled ? '#0f172a' : '#e2e8f0'" stroke-width='1.8' fill='none' stroke-linecap='round'/>
                <path d='M19 16 A3 3 0 1 0 16 19' :stroke="scrolled ? '#0f172a' : '#e2e8f0'" stroke-width='1.8' fill='none' stroke-linecap='round'/>
            </svg>
            <span class="font-bold text-xl tracking-tight transition-colors duration-300" :class="scrolled ? 'text-slate-900' : 'text-white'">TimeNest</span>
        </a>

        {{-- Right Group: Nav Links & Actions (Desktop) --}}
        <div class="hidden lg:flex items-center gap-8">
            {{-- Nav Links --}}
            <nav class="flex items-center gap-8">
                <a href="/features" class="text-sm font-medium transition-colors" :class="scrolled ? 'text-slate-600 hover:text-slate-900' : 'text-slate-300 hover:text-white'">Features</a>
                <a href="/solutions" class="text-sm font-medium transition-colors" :class="scrolled ? 'text-slate-600 hover:text-slate-900' : 'text-slate-300 hover:text-white'">Solutions</a>
                <a href="/security" class="text-sm font-medium transition-colors" :class="scrolled ? 'text-slate-600 hover:text-slate-900' : 'text-slate-300 hover:text-white'">Security</a>
                <a href="/pricing" class="text-sm font-medium transition-colors" :class="scrolled ? 'text-slate-600 hover:text-slate-900' : 'text-slate-300 hover:text-white'">Pricing</a>
                <a href="/blog" class="text-sm font-medium transition-colors" :class="scrolled ? 'text-slate-600 hover:text-slate-900' : 'text-slate-300 hover:text-white'">Blogs</a>
                <a href="/about" class="text-sm font-medium transition-colors" :class="scrolled ? 'text-slate-600 hover:text-slate-900' : 'text-slate-300 hover:text-white'">About</a>
            </nav>

            {{-- Actions --}}
            <div class="flex items-center gap-4">
                <x-ui.button variant="secondary" href="/contact" class="!px-4.5 !py-2 !text-sm">Contact us</x-ui.button>
                <x-ui.button href="{{ route('frontend.book-demo') }}" class="!px-4.5 !py-2 !text-sm">Book a demo</x-ui.button>
            </div>
        </div>

        {{-- Mobile Hamburger --}}
        <div class="lg:hidden flex items-center gap-4">
            <x-ui.button href="{{ route('frontend.book-demo') }}" class="!px-3 !py-1.5 text-xs">Book a demo</x-ui.button>
            <button @click="open = !open" class="focus:outline-none p-1 transition-colors" :class="scrolled ? 'text-slate-650 hover:text-slate-900' : 'text-slate-300 hover:text-white'">
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
         class="absolute top-full left-0 w-full mt-2 bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden lg:hidden">
        
        <div class="p-4 flex flex-col gap-4">
            <a href="/features" class="text-base font-medium text-slate-700 hover:text-accent-600">Features</a>
            <a href="/solutions" class="text-base font-medium text-slate-700 hover:text-accent-600">Solutions</a>
            <a href="/security" class="text-base font-medium text-slate-700 hover:text-accent-600">Security</a>
            <a href="/pricing" class="text-base font-medium text-slate-700 hover:text-accent-600">Pricing</a>
            <a href="/blog" class="text-base font-medium text-slate-700 hover:text-accent-600">Blogs</a>
            <a href="/about" class="text-base font-medium text-slate-700 hover:text-accent-600">About</a>
            <hr class="border-slate-100">
            <a href="/contact" class="text-base font-medium text-slate-700 hover:text-accent-600">Contact us</a>
        </div>
    </div>
</header>
</div>
