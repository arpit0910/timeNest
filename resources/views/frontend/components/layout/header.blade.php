<header
    x-data="{ scrolled: false, activeMenu: null }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 })"
    :class="scrolled ? 'bg-surface/80 glass border-b border-surface-border shadow-lg shadow-black/10' : 'bg-transparent'"
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
    @mouseleave="activeMenu = null"
>
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">
            <a href="{{ route('frontend.home') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-brand-500 flex items-center justify-center">
                    <svg class="w-5 h-5 text-content-strong" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="font-display text-xl font-bold text-content-strong">Time<span class="text-brand-400">Nest</span></span>
            </a>

            <nav class="hidden lg:flex items-center gap-1">
                @foreach(['products', 'solutions', 'ai', 'resources'] as $menu)
                    <div @mouseenter="activeMenu = '{{ $menu }}'">
                        <button class="px-3 py-2 text-sm text-content hover:text-content-strong font-body flex items-center gap-1 transition-colors cursor-pointer">
                            {{ ucfirst($menu) }}
                            <svg class="w-3.5 h-3.5 transition-transform" :class="activeMenu === '{{ $menu }}' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                    </div>
                @endforeach
                <a href="{{ route('frontend.pricing') }}" class="px-3 py-2 text-sm text-content hover:text-content-strong font-body transition-colors" @mouseenter="activeMenu = null">Pricing</a>
                <a href="{{ route('frontend.roadmap') }}" class="px-3 py-2 text-sm text-content hover:text-content-strong font-body transition-colors" @mouseenter="activeMenu = null">Roadmap</a>
            </nav>

            <div class="hidden lg:flex items-center gap-3">
                <button @click="$store.search.toggle()" class="p-2 text-content-muted hover:text-content-strong transition-colors cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </button>
                <x-frontend-base.button href="{{ route('frontend.book-demo') }}" variant="outline" color="white" size="sm">Book Demo</x-frontend-base.button>
                <x-frontend-base.button href="/register" variant="primary" color="brand" size="sm">Get Started</x-frontend-base.button>
            </div>

            <button @click="$store.mobileNav.toggle()" class="lg:hidden p-2 text-content-muted hover:text-content-strong cursor-pointer">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </div>

    {{-- Mega Menu --}}
    <div x-show="activeMenu" x-transition x-cloak class="absolute top-full left-0 right-0 flex justify-center mt-2 px-6 lg:px-8">
        <div class="w-full max-w-7xl bg-surface-card/95 glass border border-surface-border rounded-2xl shadow-2xl p-8 overflow-hidden">
            @include('frontend.partials.mega-menu-panels')
        </div>
    </div>

    {{-- Mobile Nav --}}
    <div x-show="$store.mobileNav.open" x-transition x-cloak class="lg:hidden bg-surface-card border-b border-surface-border">
        <div class="px-6 py-4 space-y-3">
            @foreach([
                ['Organizations', 'frontend.product.organizations'],
                ['Freelancers', 'frontend.product.freelancers'],
                ['AI', 'frontend.ai'],
                ['Pricing', 'frontend.pricing'],
                ['Blog', 'frontend.blog.index'],
                ['About', 'frontend.about'],
                ['Contact', 'frontend.contact'],
            ] as [$label, $routeName])
                <a href="{{ route($routeName) }}" class="block text-content hover:text-content-strong text-sm py-2 font-body">{{ $label }}</a>
            @endforeach
            <div class="flex flex-col gap-3 pt-4 border-t border-surface-border">
                <x-frontend-base.button href="{{ route('frontend.book-demo') }}" variant="outline" color="white" size="sm" class="w-full">Book Demo</x-frontend-base.button>
                <x-frontend-base.button href="/register" variant="primary" color="brand" size="sm" class="w-full">Get Started</x-frontend-base.button>
            </div>
        </div>
    </div>
</header>
