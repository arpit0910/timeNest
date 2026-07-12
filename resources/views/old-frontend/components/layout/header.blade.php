<style>
.tn-header-scrolled { background-color: #ffffff !important; border-bottom: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
.dark .tn-header-scrolled { background-color: #0a0a0f !important; border-bottom-color: #27272a; }
</style>
<header
    x-data="{ scrolled: false, mobileOpen: false }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 })"
    :class="(scrolled || mobileOpen) ? 'tn-header-scrolled' : 'bg-transparent'"
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
>
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">
            <a href="{{ route('frontend.home') }}" class="flex items-center">
                <x-frontend-base.logo size="md" variant="full" />
            </a>

            <nav class="hidden lg:flex items-center gap-6">
                <a href="{{ route('frontend.product.organizations') }}" class="px-1 py-2 text-sm font-medium text-content hover:text-content-strong transition-colors">Products</a>
                <a href="{{ route('frontend.solutions.show', 'workforce-management') }}" class="px-1 py-2 text-sm font-medium text-content hover:text-content-strong transition-colors">Solutions</a>
                <a href="{{ route('frontend.blog.index') }}" class="px-1 py-2 text-sm font-medium text-content hover:text-content-strong transition-colors">Resources</a>
                <a href="{{ route('frontend.pricing') }}" class="px-1 py-2 text-sm font-medium text-content hover:text-content-strong transition-colors">Pricing</a>
                <a href="{{ route('frontend.roadmap') }}" class="px-1 py-2 text-sm font-medium text-content hover:text-content-strong transition-colors">Roadmap</a>
            </nav>

            <div class="hidden lg:flex items-center gap-3">
                <button @click="$store.search.toggle()" class="p-2 text-content-muted hover:text-content-strong transition-colors cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </button>
                <x-frontend-base.button href="{{ route('frontend.book-demo') }}" variant="outline" size="sm" class="border-surface-border text-content hover:border-brand-500 hover:text-content-strong">Book Demo</x-frontend-base.button>
                <x-frontend-base.button href="/register" variant="primary" size="sm" class="bg-brand-500 hover:bg-brand-600 text-white border-0">Get Started</x-frontend-base.button>
            </div>

            {{-- Mobile Actions --}}
            <div class="flex items-center gap-1 lg:hidden">
                <button @click="$store.search.toggle()" class="p-2 text-content-muted hover:text-content-strong transition-colors cursor-pointer" aria-label="Toggle Search">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </button>
                <button @click="mobileOpen = !mobileOpen" class="p-2 text-content-muted hover:text-content-strong cursor-pointer z-50 focus:outline-none" aria-label="Toggle Menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="mobileOpen ? 'hidden' : 'block'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="mobileOpen ? 'block' : 'hidden'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Nav --}}
    <div x-show="mobileOpen"
         x-transition
         x-cloak
         class="lg:hidden bg-surface/95 glass border-t border-surface-border max-h-[calc(100vh-4rem)] overflow-y-auto"
    >
        <div class="px-6 py-6 space-y-2">
            <div class="py-2 border-b border-surface-border">
                <a href="{{ route('frontend.product.organizations') }}" class="block text-base font-bold text-content-strong">Products</a>
            </div>
            <div class="py-2 border-b border-surface-border">
                <a href="{{ route('frontend.solutions.show', 'workforce-management') }}" class="block text-base font-bold text-content-strong">Solutions</a>
            </div>
            <div class="py-2 border-b border-surface-border">
                <a href="{{ route('frontend.blog.index') }}" class="block text-base font-bold text-content-strong">Resources</a>
            </div>
            <div class="py-2 border-b border-surface-border">
                <a href="{{ route('frontend.pricing') }}" class="block text-base font-bold text-content-strong">Pricing</a>
            </div>
            <div class="py-2">
                <a href="{{ route('frontend.roadmap') }}" class="block text-base font-bold text-content-strong">Roadmap</a>
            </div>

            {{-- CTA BUTTONS --}}
            <div class="flex flex-col gap-3 pt-6 border-t border-surface-border">
                <x-frontend-base.button href="{{ route('frontend.book-demo') }}" variant="outline" size="sm" class="w-full justify-center border-surface-border text-content hover:border-brand-500 hover:text-content-strong">Book Demo</x-frontend-base.button>
                <x-frontend-base.button href="/register" variant="primary" size="sm" class="w-full justify-center bg-brand-500 hover:bg-brand-600 text-white border-0">Get Started</x-frontend-base.button>
            </div>
        </div>
    </div>
</header>
