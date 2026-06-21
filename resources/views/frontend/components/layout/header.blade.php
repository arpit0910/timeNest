<header
    x-data="{ scrolled: false, activeMenu: null, mobileOpen: false, expandedSection: null }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 })"
    :class="(scrolled || mobileOpen) ? 'bg-surface/80 glass border-b border-surface-border shadow-lg shadow-black/10' : 'bg-transparent'"
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
    @mouseleave="activeMenu = null"
>
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">
            <a href="{{ route('frontend.home') }}" class="flex items-center">
                <x-frontend-base.logo size="md" variant="full" />
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
                <x-frontend-base.button href="{{ route('frontend.book-demo') }}" variant="outline" color="brand" size="sm">Book Demo</x-frontend-base.button>
                <x-frontend-base.button href="/register" variant="primary" color="brand" size="sm">Get Started</x-frontend-base.button>
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

    {{-- Mega Menu --}}
    <div x-show="activeMenu" x-transition x-cloak class="absolute top-full left-0 right-0 flex justify-center mt-2 px-6 lg:px-8">
        <div class="w-full max-w-7xl bg-surface-card/95 glass border border-surface-border rounded-2xl shadow-2xl p-10 overflow-hidden">
            @include('frontend.partials.mega-menu-panels')
        </div>
    </div>

    {{-- Mobile Nav --}}
    <div x-show="mobileOpen"
         x-transition
         x-cloak
         class="lg:hidden bg-surface/95 glass border-t border-surface-border max-h-[calc(100vh-4rem)] overflow-y-auto"
    >
        <div class="px-6 py-6 space-y-4">
            {{-- Search Bar Shortcut --}}
            <div class="mb-2">
                <button @click="$store.search.toggle(); mobileOpen = false" class="w-full flex items-center justify-between px-4 py-3 rounded-xl bg-surface-50 border border-surface-border text-content-muted text-sm hover:text-content transition-colors cursor-pointer">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-content-light" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Search TimeNest...
                    </span>
                    <span class="text-xs bg-surface-border text-content-muted px-2 py-0.5 rounded-md font-mono">/</span>
                </button>
            </div>

            {{-- 1. PRODUCTS ACCORDION --}}
            <div class="border-b border-surface-border/50 pb-3">
                <button @click="expandedSection = expandedSection === 'products' ? null : 'products'" class="w-full flex items-center justify-between py-2 text-base font-bold text-content-strong transition-colors">
                    <span>Products</span>
                    <svg class="w-4 h-4 text-content-muted transition-transform duration-300" :class="expandedSection === 'products' ? 'rotate-180 text-brand-500' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="expandedSection === 'products'" x-transition class="mt-3 pl-2 space-y-4">
                    <div>
                        <h4 class="text-xs font-semibold text-content-muted tracking-wider uppercase mb-2">Core Platforms</h4>
                        <div class="grid gap-2">
                            <a href="{{ route('frontend.product.organizations') }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-surface-50">
                                <div class="w-8 h-8 rounded-md bg-brand-500/10 flex items-center justify-center text-brand-600 shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-content-strong">For Organizations</div>
                                    <div class="text-xs text-content-muted">Workforce management.</div>
                                </div>
                            </a>
                            <a href="{{ route('frontend.product.freelancers') }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-surface-50">
                                <div class="w-8 h-8 rounded-md bg-accent-500/10 flex items-center justify-center text-accent-600 shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-content-strong">For Freelancers</div>
                                    <div class="text-xs text-content-muted">Clients, invoices & tasks.</div>
                                </div>
                            </a>
                            <a href="{{ route('frontend.product.workspace') }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-surface-50">
                                <div class="w-8 h-8 rounded-md bg-amber-500/10 flex items-center justify-center text-amber-600 shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-content-strong">Freelance Workspace</div>
                                    <div class="text-xs text-content-muted">Collaborative hub for teams.</div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-xs font-semibold text-content-muted tracking-wider uppercase mb-2">Workforce Features</h4>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach([
                                'attendance-management' => 'Attendance', 
                                'timelog-management' => 'Timelogs', 
                                'leave-management' => 'Leaves', 
                                'shift-management' => 'Shifts', 
                                'employee-directory' => 'Directory'
                            ] as $slug => $item)
                                <a href="{{ route('frontend.feature.show', ['category' => 'workforce', 'slug' => $slug]) }}" class="block p-2 rounded-lg text-sm text-content hover:bg-surface-50 font-medium">{{ $item }}</a>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <h4 class="text-xs font-semibold text-content-muted tracking-wider uppercase mb-2">Operations Features</h4>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach([
                                'departments' => 'Departments', 
                                'teams' => 'Teams', 
                                'roles-permissions' => 'Roles & Perms', 
                                'audit-logs' => 'Audit Logs', 
                                'workforce-analytics' => 'Analytics'
                            ] as $slug => $item)
                                <a href="{{ route('frontend.feature.show', ['category' => 'operations', 'slug' => $slug]) }}" class="block p-2 rounded-lg text-sm text-content hover:bg-surface-50 font-medium">{{ $item }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. SOLUTIONS ACCORDION --}}
            <div class="border-b border-surface-border/50 pb-3">
                <button @click="expandedSection = expandedSection === 'solutions' ? null : 'solutions'" class="w-full flex items-center justify-between py-2 text-base font-bold text-content-strong transition-colors">
                    <span>Solutions</span>
                    <svg class="w-4 h-4 text-content-muted transition-transform duration-300" :class="expandedSection === 'solutions' ? 'rotate-180 text-brand-500' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="expandedSection === 'solutions'" x-transition class="mt-3 pl-2 space-y-2">
                    @foreach([
                        ['workforce-management', 'Workforce Management', 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                        ['operations-management', 'Operations Management', 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                        ['financial-operations', 'Financial Operations', 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['freelancer-management', 'Freelancer Management', 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                        ['ai-operations', 'AI Operations', 'M13 10V3L4 14h7v7l9-11h-7z'],
                        ['#', 'Global Compliance', 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['#', 'Enterprise Security', 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                        ['#', 'Remote Teams', 'M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9'],
                        ['#', 'Integrations', 'M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z'],
                        ['#', 'API Access', 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4']
                    ] as [$slug, $title, $icon])
                        <a href="{{ $slug === '#' ? '#' : route('frontend.solutions.show', $slug) }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-surface-50 text-sm text-content font-medium">
                            <svg class="w-4 h-4 text-content-light shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}"/></svg>
                            <span>{{ $title }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- 3. AI ACCORDION --}}
            <div class="border-b border-surface-border/50 pb-3">
                <button @click="expandedSection = expandedSection === 'ai' ? null : 'ai'" class="w-full flex items-center justify-between py-2 text-base font-bold text-content-strong transition-colors">
                    <span>AI Platform</span>
                    <svg class="w-4 h-4 text-content-muted transition-transform duration-300" :class="expandedSection === 'ai' ? 'rotate-180 text-brand-500' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="expandedSection === 'ai'" x-transition class="mt-3 pl-2 space-y-1">
                    @foreach([
                        ['workforce-analyst', 'Workforce Analyst'],
                        ['attendance-insights', 'AI Attendance Insights'],
                        ['fraud-detection', 'AI Fraud Detection'],
                        ['executive-dashboard', 'AI Executive Dashboard'],
                        ['revenue-forecasting', 'AI Revenue Forecasting'],
                        ['freelancer-assistant', 'AI Freelancer Assistant'],
                        ['productivity-insights', 'AI Productivity Insights'],
                        ['compliance-monitoring', 'AI Compliance Monitoring'],
                        ['hr-assistant', 'AI HR Assistant'],
                        ['operations-assistant', 'AI Operations Assistant'],
                        ['finance-assistant', 'AI Finance Assistant'],
                        ['future-agents', 'Future AI Agents'],
                    ] as [$slug, $title])
                        <a href="{{ route('frontend.feature.show', ['category' => 'ai', 'slug' => $slug]) }}" class="block p-2 rounded-lg text-sm text-content hover:bg-surface-50 font-medium">{{ $title }}</a>
                    @endforeach
                </div>
            </div>

            {{-- 4. RESOURCES ACCORDION --}}
            <div class="border-b border-surface-border/50 pb-3">
                <button @click="expandedSection = expandedSection === 'resources' ? null : 'resources'" class="w-full flex items-center justify-between py-2 text-base font-bold text-content-strong transition-colors">
                    <span>Resources</span>
                    <svg class="w-4 h-4 text-content-muted transition-transform duration-300" :class="expandedSection === 'resources' ? 'rotate-180 text-brand-500' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="expandedSection === 'resources'" x-transition class="mt-3 pl-2 space-y-1">
                    <a href="{{ route('frontend.blog.index') }}" class="block p-2 rounded-lg text-sm text-content hover:bg-surface-50 font-medium">Blog</a>
                    <a href="{{ route('frontend.faqs.index') }}" class="block p-2 rounded-lg text-sm text-content hover:bg-surface-50 font-medium">FAQs</a>
                    <a href="{{ route('frontend.docs.index') }}" class="block p-2 rounded-lg text-sm text-content hover:bg-surface-50 font-medium">Help Center / Docs</a>
                    <a href="{{ route('frontend.release-notes') }}" class="block p-2 rounded-lg text-sm text-content hover:bg-surface-50 font-medium">Release Notes</a>
                    <a href="{{ route('frontend.changelog') }}" class="block p-2 rounded-lg text-sm text-content hover:bg-surface-50 font-medium">Changelog</a>
                    <a href="{{ route('frontend.about') }}" class="block p-2 rounded-lg text-sm text-content hover:bg-surface-50 font-medium">About Us</a>
                    <a href="{{ route('frontend.careers') }}" class="block p-2 rounded-lg text-sm text-content hover:bg-surface-50 font-medium">Careers</a>
                    <a href="{{ route('frontend.contact') }}" class="block p-2 rounded-lg text-sm text-content hover:bg-surface-50 font-medium">Contact</a>
                </div>
            </div>

            {{-- DIRECT LINKS --}}
            <div class="py-1">
                <a href="{{ route('frontend.pricing') }}" class="block text-base font-bold text-content-strong py-2">Pricing</a>
            </div>
            <div class="py-1">
                <a href="{{ route('frontend.roadmap') }}" class="block text-base font-bold text-content-strong py-2">Roadmap</a>
            </div>

            {{-- CTA BUTTONS --}}
            <div class="flex flex-col gap-3 pt-6 border-t border-surface-border">
                <x-frontend-base.button href="{{ route('frontend.book-demo') }}" variant="outline" color="brand" size="sm" class="w-full justify-center">Book Demo</x-frontend-base.button>
                <x-frontend-base.button href="/register" variant="primary" color="brand" size="sm" class="w-full justify-center">Get Started</x-frontend-base.button>
            </div>
        </div>
    </div>
</header>
