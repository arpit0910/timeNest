{{-- Standardized Link Component for Macro Use in the menu --}}
@php
    $linkClass = "group flex items-center justify-between p-3 rounded-xl bg-transparent hover:bg-surface-50 hover:shadow-[0_2px_8px_-2px_rgba(0,0,0,0.05)] border border-transparent hover:border-surface-border transition-all duration-300";
    $arrowSvg = '<svg class="w-4 h-4 text-content-light group-hover:text-brand-500 group-hover:translate-x-1.5 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>';
    $upcomingLinkClass = "group flex items-center justify-between p-3 rounded-xl bg-transparent hover:bg-surface-50/50 border border-transparent cursor-default transition-all duration-300 opacity-80";
@endphp

{{-- 1. PRODUCTS MENU --}}
<div x-show="activeMenu === 'products'" class="flex">
    {{-- Left Feature Panel --}}
    <div class="w-1/3 border-r border-surface-border pr-10">
        <h4 class="text-xs font-semibold text-content-muted tracking-wider uppercase mb-6">Core Platforms</h4>
        <div class="space-y-4">
            {{-- Organizations --}}
            <a href="{{ route('frontend.product.organizations') }}" class="group block p-4 rounded-xl border border-transparent hover:border-brand-500/20 hover:bg-brand-50/50 hover:shadow-lg hover:shadow-brand-500/5 transition-all duration-300 relative overflow-hidden">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-brand-500/10 flex items-center justify-center shrink-0 transition-all duration-300 group-hover:bg-brand-500 group-hover:scale-110 group-hover:shadow-md">
                        <svg class="w-6 h-6 text-brand-600 transition-colors duration-300 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <div>
                        <h3 class="font-display font-bold text-content-strong mb-1 group-hover:text-brand-600 flex items-center gap-2 transition-colors">For Organizations {!! $arrowSvg !!}</h3>
                        <p class="text-content-muted text-xs leading-relaxed">Complete workforce management for companies of all sizes.</p>
                    </div>
                </div>
            </a>
            
            {{-- Freelancers --}}
            <a href="javascript:void(0)" aria-disabled="true" class="group block p-4 rounded-xl border border-transparent hover:border-accent-500/10 hover:bg-accent-50/30 transition-all duration-300 relative overflow-hidden cursor-default">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-accent-500/10 flex items-center justify-center shrink-0 transition-all duration-300 group-hover:bg-accent-500 group-hover:scale-110 group-hover:shadow-md">
                        <svg class="w-6 h-6 text-accent-600 transition-colors duration-300 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-display font-bold text-content-strong mb-1 flex items-center gap-2 transition-colors">For Freelancers<x-frontend-base.badge variant="upcoming">Upcoming</x-frontend-base.badge></h3>
                        <p class="text-content-muted text-xs leading-relaxed">Manage clients, invoices, tasks, and revenue.</p>
                    </div>
                </div>
            </a>
            
            {{-- Workspace --}}
            <a href="javascript:void(0)" aria-disabled="true" class="group block p-4 rounded-xl border border-transparent hover:border-amber-500/10 hover:bg-amber-50/30 transition-all duration-300 relative overflow-hidden cursor-default">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/10 flex items-center justify-center shrink-0 transition-all duration-300 group-hover:bg-amber-500 group-hover:scale-110 group-hover:shadow-md">
                        <svg class="w-6 h-6 text-amber-600 transition-colors duration-300 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-display font-bold text-content-strong mb-1 flex items-center gap-2 transition-colors">Freelance Workspace<x-frontend-base.badge variant="upcoming">Upcoming</x-frontend-base.badge></h3>
                        <p class="text-content-muted text-xs leading-relaxed">Collaborative workspace for modern freelance teams.</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
    
    {{-- Right Links Grid --}}
    <div class="w-2/3 pl-10 grid grid-cols-3 gap-x-8 gap-y-6">
        <div>
            <h4 class="text-xs font-semibold text-content-muted tracking-wider uppercase mb-4 px-3">Workforce</h4>
            <ul class="space-y-1">
                @foreach([
                    'attendance-management' => 'Attendance', 
                    'timelog-management' => 'Timelogs', 
                    'leave-management' => 'Leave Mgmt', 
                    'shift-management' => 'Shift Planning', 
                    'employee-directory' => 'Directory'
                ] as $slug => $item)
                    <li>
                        <a href="{{ route('frontend.feature.show', ['category' => 'workforce', 'slug' => $slug]) }}" class="{!! $linkClass !!}">
                            <span class="text-sm font-medium text-content group-hover:text-brand-600 transition-colors">{{ $item }}</span>
                            {!! $arrowSvg !!}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div>
            <h4 class="text-xs font-semibold text-content-muted tracking-wider uppercase mb-4 px-3">Operations</h4>
            <ul class="space-y-1">
                @foreach([
                    ['slug' => 'departments', 'title' => 'Departments', 'status' => 'available'], 
                    ['slug' => 'teams', 'title' => 'Teams', 'status' => 'available'], 
                    ['slug' => 'roles-permissions', 'title' => 'Roles & Perms', 'status' => 'available'], 
                    ['slug' => 'audit-logs', 'title' => 'Audit Logs', 'status' => 'available'], 
                    ['slug' => 'workforce-analytics', 'title' => 'Analytics', 'status' => 'upcoming']
                ] as $item)
                    <li>
                        @if($item['status'] === 'upcoming')
                            <a href="javascript:void(0)" aria-disabled="true" class="{!! $upcomingLinkClass !!}">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-medium text-content-light">{{ $item['title'] }}</span>
                                    <x-frontend-base.badge variant="upcoming">Upcoming</x-frontend-base.badge>
                                </div>
                            </a>
                        @else
                            <a href="{{ route('frontend.feature.show', ['category' => 'operations', 'slug' => $item['slug']]) }}" class="{!! $linkClass !!}">
                                <span class="text-sm font-medium text-content group-hover:text-brand-600 transition-colors">{{ $item['title'] }}</span>
                                {!! $arrowSvg !!}
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
        <div>
            <h4 class="text-xs font-semibold text-content-muted tracking-wider uppercase mb-4 px-3">Upcoming</h4>
            <ul class="space-y-1">
                @foreach(['Workflows', 'Approvals', 'Payroll Sync', 'ATS', 'Performance'] as $item)
                    <li>
                        <a href="javascript:void(0)" aria-disabled="true" class="{!! $upcomingLinkClass !!}">
                            <span class="text-sm font-medium text-content-light">{{ $item }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

{{-- 2. SOLUTIONS MENU --}}
<div x-show="activeMenu === 'solutions'" 
     x-data="{ 
        hoveredItem: null, 
        defaultTitle: 'Enterprise Solutions', 
        defaultDesc: 'End-to-end operational workflows designed to scale with your business and break down data silos.', 
        defaultImage: '/images/mockups/mega_menu_solutions.png', 
        defaultLink: '#' 
     }" 
     class="flex"
>
    {{-- Left Feature Panel --}}
    <div class="w-1/3 border-r border-surface-border pr-10 flex flex-col">
        <div class="relative overflow-hidden rounded-2xl border border-surface-border flex-1 flex flex-col min-h-[400px] group shadow-sm hover:shadow-lg transition-all duration-500 bg-white">
            <!-- Top Content Card (thick content box placed at the top with solid white background) -->
            <div class="relative z-20 p-5 bg-white flex flex-col transition-all duration-300">
                <h3 class="font-display text-base font-bold text-content-strong mb-1" x-text="hoveredItem ? hoveredItem.title : defaultTitle">Enterprise Solutions</h3>
                <p class="text-content-muted text-[11px] leading-relaxed mb-4 min-h-[48px] line-clamp-3" x-text="hoveredItem ? hoveredItem.desc : defaultDesc">End-to-end operational workflows designed to scale with your business and break down data silos.</p>
                <a :href="hoveredItem ? hoveredItem.link : defaultLink" 
                   class="group relative overflow-hidden inline-flex items-center justify-center gap-2 font-body font-medium rounded-lg transition-all duration-300 ease-out cursor-pointer focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:ring-offset-1 hover:-translate-y-0.5 hover:scale-[1.015] active:translate-y-0 active:scale-100 shadow-sm w-full py-2.5 text-xs text-white bg-brand-500 hover:bg-white hover:text-brand-500 hover:border-brand-500 border border-transparent"
                >
                    <span class="btn-shine"></span>
                    <span class="relative z-10 inline-flex items-center justify-center gap-1.5">
                        <span x-text="hoveredItem ? 'Explore ' + hoveredItem.title : 'Explore All Solutions'">Explore All Solutions</span>
                        <svg class="w-3.5 h-3.5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </span>
                </a>
            </div>

            <!-- Bottom Image/Animation Container -->
            <div class="relative flex-1 overflow-hidden bg-white z-10">
                <img :src="hoveredItem ? hoveredItem.image : defaultImage" 
                     class="w-full h-full object-cover transition-all duration-500 transform scale-100 group-hover:scale-105" 
                     alt="Feature Preview" />
                <div class="absolute inset-x-0 top-0 h-16 bg-gradient-to-b from-white via-white/80 to-transparent pointer-events-none z-10"></div>
                <div class="anim-mega-bg-glow"></div>
            </div>
        </div>
    </div>
    
    {{-- Right Links Grid --}}
    <div class="w-2/3 pl-10 grid grid-cols-2 gap-x-6 gap-y-2 content-start">
        @foreach([
            ['slug' => 'workforce-management', 'title' => 'Workforce Mgmt', 'desc' => 'Employees, attendance, leaves, shifts', 'hoverDesc' => 'Optimize employee scheduling, track attendance, and manage leaves in a single, unified database.', 'hoverImg' => '/images/mega-menu/workforce.png', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'status' => 'available'],
            ['slug' => 'operations-management', 'title' => 'Operations Mgmt', 'desc' => 'Departments, teams, workflows', 'hoverDesc' => 'Structure your organization into departments and teams, and orchestrate smooth operational workflows.', 'hoverImg' => '/images/mega-menu/operations.png', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'status' => 'upcoming'],
            ['slug' => 'financial-operations', 'title' => 'Financial Ops', 'desc' => 'Invoices, payments, revenue', 'hoverDesc' => 'Streamline client billing, automate invoice follow-ups, and track your cashflow in real-time.', 'hoverImg' => '/images/mega-menu/finance.png', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'status' => 'upcoming'],
            ['slug' => 'freelancer-management', 'title' => 'Freelancer Mgmt', 'desc' => 'Clients, leads, projects, tasks', 'hoverDesc' => 'Help your freelance contractors track projects, manage client leads, and invoice work seamlessly.', 'hoverImg' => '/images/mega-menu/freelancer.png', 'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'status' => 'upcoming'],
            ['slug' => 'ai-operations', 'title' => 'AI Operations', 'desc' => 'Intelligence for workflows', 'hoverDesc' => 'Embed intelligence directly into your daily processes to identify anomalies, predict bottlenecks, and automate routines.', 'hoverImg' => '/images/mega-menu/ai-ops.png', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'status' => 'upcoming'],
            ['slug' => '#', 'title' => 'Global Compliance', 'desc' => 'GDPR, SOC2, policies', 'hoverDesc' => 'Enforce company-wide policies, ensure audit readiness, and satisfy regional labor compliance regulations.', 'hoverImg' => '/images/mega-menu/compliance.png', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'status' => 'upcoming'],
            ['slug' => '#', 'title' => 'Enterprise Security', 'desc' => 'Audit logs, role permissions', 'hoverDesc' => 'Secure business access with granular role permissions, strict audit logging, and IP access restrictions.', 'hoverImg' => '/images/mega-menu/security.png', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'status' => 'upcoming'],
            ['slug' => '#', 'title' => 'Remote Teams', 'desc' => 'Async communication, global sync', 'hoverDesc' => 'Bridge timezone gaps with asynchronous project management, global clock sync, and smart collaboration channels.', 'hoverImg' => '/images/mega-menu/remote.png', 'icon' => 'M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9', 'status' => 'upcoming'],
            ['slug' => '#', 'title' => 'Integrations', 'desc' => 'Connect your tools', 'hoverDesc' => 'Connect TimeNest with your existing stack of communication tools, repositories, and authentication providers.', 'hoverImg' => '/images/mega-menu/integrations.png', 'icon' => 'M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z', 'status' => 'upcoming'],
            ['slug' => '#', 'title' => 'API Access', 'desc' => 'Build on top of TimeNest', 'hoverDesc' => 'Develop custom integrations and build automation scripts on top of the robust TimeNest developer platform.', 'hoverImg' => '/images/mega-menu/api.png', 'icon' => 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4', 'status' => 'upcoming'],
        ] as $sol)
            <a href="{{ $sol['status'] === 'upcoming' ? 'javascript:void(0)' : ($sol['slug'] === '#' ? '#' : route('frontend.solutions.show', $sol['slug'])) }}" 
               aria-disabled="{{ $sol['status'] === 'upcoming' ? 'true' : 'false' }}"
               class="{!! $sol['status'] === 'upcoming' ? $upcomingLinkClass : $linkClass !!}"
               @if($sol['status'] !== 'upcoming')
               @mouseenter="hoveredItem = { 
                   title: '{{ $sol['title'] }}', 
                   desc: '{{ $sol['hoverDesc'] }}', 
                   image: '{{ $sol['hoverImg'] }}', 
                   link: '{{ $sol['slug'] === '#' ? '#' : route('frontend.solutions.show', $sol['slug']) }}' 
               }"
               @mouseleave="hoveredItem = null"
               @endif
            >
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-surface flex items-center justify-center shrink-0 border border-surface-border group-hover:border-brand-500/50 group-hover:text-brand-500 group-hover:shadow-sm transition-all duration-300 overflow-hidden">
                        @switch($sol['title'])
                            @case('Workforce Mgmt')
                                <svg class="w-5 h-5 text-content-muted group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                                    <circle cx="8.5" cy="7" r="4" />
                                    <circle cx="18" cy="8" r="2" class="anim-workforce-dot" fill="#f59e0b" stroke="none" />
                                    <path class="anim-workforce-check text-emerald-500" stroke-width="2" d="M14 14l2 2 4-4" />
                                </svg>
                                @break
                            @case('Operations Mgmt')
                                <svg class="w-5 h-5 text-content-muted group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <circle cx="6" cy="12" r="2.5" class="anim-ops-node-a fill-slate-300" />
                                    <path d="M8.5 12h7" class="anim-ops-line stroke-slate-300" stroke-linecap="round" />
                                    <circle cx="18" cy="12" r="2.5" class="anim-ops-node-b fill-slate-300" />
                                    <path d="M12 12v4h3" stroke-dasharray="2" stroke-linecap="round" />
                                </svg>
                                @break
                            @case('Financial Ops')
                                <svg class="w-5 h-5 text-content-muted group-hover:text-emerald-600 transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                                    <path d="M14 2v6h6" />
                                    <g class="anim-finance-stamp text-emerald-500" stroke-width="2">
                                        <rect x="7" y="11" width="10" height="6" rx="1" fill="none" />
                                        <path d="M9 14l2 2 4-4" stroke-linecap="round" stroke-linejoin="round" />
                                    </g>
                                </svg>
                                @break
                            @case('Freelancer Mgmt')
                                <svg class="w-5 h-5 text-content-muted group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <line x1="12" y1="4" x2="12" y2="20" stroke-dasharray="2" />
                                    <rect x="3" y="6" width="6" height="4" rx="1" fill="#e2e8f0" stroke="none" />
                                    <rect x="3" y="12" width="6" height="4" rx="1" class="anim-kanban-card" stroke="none" />
                                    <path d="M15 8l2 2 4-4" class="anim-kanban-check text-emerald-500" stroke-width="2" stroke-linecap="round" />
                                </svg>
                                @break
                            @case('AI Operations')
                                <svg class="w-5 h-5 text-content-muted group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path class="anim-ai-sparkle text-indigo-500" d="M12 3l1 2.5L15.5 6 13 7l-1 2.5L11 7 8.5 6 11 5z" />
                                    <line x1="4" y1="12" x2="18" y2="12" class="anim-ai-l1" />
                                    <line x1="4" y1="15" x2="14" y2="15" class="anim-ai-l2" />
                                    <line x1="4" y1="18" x2="10" y2="18" class="anim-ai-l3" />
                                </svg>
                                @break
                            @case('Global Compliance')
                                <svg class="w-5 h-5 text-content-muted group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" />
                                    <path d="M9 5a2 2 0 00-2 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    <circle cx="9" cy="13" r="1.5" />
                                    <path d="M8.5 13l1 1 2-2" class="anim-compliance-check text-emerald-500" stroke-width="2" stroke-linecap="round" />
                                    <line x1="13" y1="13" x2="17" y2="13" />
                                    <line x1="7" y1="17" x2="17" y2="17" />
                                </svg>
                                @break
                            @case('Enterprise Security')
                                <svg class="w-5 h-5 text-content-muted group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                    <line x1="6" y1="7" x2="18" y2="7" class="anim-security-sweep text-emerald-500" stroke-width="2" stroke-linecap="round" />
                                </svg>
                                @break
                            @case('Remote Teams')
                                <svg class="w-5 h-5 text-content-muted group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path class="anim-chat-left text-brand-500" d="M12 8c0-3.3-2.7-6-6-6S0 4.7 0 8c0 1.8.8 3.5 2.2 4.6L1 16l4-2c.3 0 .7.1 1 .1 3.3 0 6-2.7 6-6z" />
                                    <path class="anim-chat-right text-indigo-500" d="M24 10c0-2.8-2.2-5-5-5s-5 2.2-5 5c0 1.5.7 2.9 1.8 3.8l-.8 3.2 3.3-1.7c.3 0 .5.1.7.1 2.8 0 5-2.2 5-5z" />
                                </svg>
                                @break
                            @case('Integrations')
                                <svg class="w-5 h-5 text-content-muted group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <rect x="10" y="8" width="4" height="8" rx="1" />
                                    <path class="anim-integration-plug" d="M3 12h5m-2-2v4" />
                                    <circle cx="12" cy="12" r="3" class="anim-integration-spark text-emerald-500 opacity-20" stroke-width="2" />
                                </svg>
                                @break
                            @case('API Access')
                                <svg class="w-5 h-5 text-content-muted group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path class="anim-terminal-cmd" d="M3 7l3 3-3 3" />
                                    <line x1="7" y1="10" x2="11" y2="10" class="anim-terminal-cmd" />
                                    <g class="anim-terminal-resp text-emerald-500" stroke-linecap="round">
                                        <path d="M14 6h3l-3 4h3m2-4v4h3v-4zm4 0v4h3v-4z" stroke-width="1.2" />
                                    </g>
                                </svg>
                                @break
                            @default
                                <svg class="w-5 h-5 text-content-muted group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $sol['icon'] }}"/></svg>
                        @endswitch
                    </div>
                    <div>
                        <h3 class="font-display font-bold text-content-strong text-sm mb-0.5 group-hover:text-brand-600 transition-colors flex items-center gap-2">{{ $sol['title'] }} @if($sol['status'] === 'upcoming') <x-frontend-base.badge variant="upcoming">Upcoming</x-frontend-base.badge> @endif</h3>
                        <p class="text-content-muted text-xs leading-relaxed line-clamp-1">{{ $sol['desc'] }}</p>
                    </div>
                </div>
                @if($sol['status'] !== 'upcoming') {!! $arrowSvg !!} @endif
            </a>
        @endforeach
    </div>
</div>

{{-- 3. AI MENU --}}
<div x-show="activeMenu === 'ai'" 
     x-data="{ 
        hoveredItem: null, 
        defaultTitle: 'TimeNest AI', 
        defaultDesc: 'Intelligence built into every module. Automate routine tasks, detect anomalies, and query your business data using natural language.', 
        defaultImage: '/images/mockups/mega_menu_ai.png', 
        defaultLink: '{{ route('frontend.ai') }}' 
     }" 
     class="flex"
>
    {{-- Left Feature Panel --}}
    <div class="w-1/3 border-r border-surface-border pr-10 flex flex-col">
        <div class="relative overflow-hidden rounded-2xl border border-surface-border flex-1 flex flex-col min-h-[400px] group shadow-sm hover:shadow-lg transition-all duration-500 bg-white">
            <!-- Top Content Card (thick content box placed at the top with solid white background) -->
            <div class="relative z-20 p-5 bg-white flex flex-col transition-all duration-300">
                <div class="flex items-center gap-3 mb-1"><h3 class="font-display text-base font-bold text-content-strong" x-text="hoveredItem ? hoveredItem.title : defaultTitle">TimeNest AI</h3><x-frontend-base.badge variant="upcoming">Coming Soon</x-frontend-base.badge></div>
                <p class="text-content-muted text-[11px] leading-relaxed mb-4 min-h-[48px] line-clamp-3" x-text="hoveredItem ? hoveredItem.desc : defaultDesc">Intelligence built into every module. Automate routine tasks, detect anomalies, and query your business data using natural language.</p>
                <a :href="hoveredItem ? hoveredItem.link : defaultLink" 
                   class="group relative overflow-hidden inline-flex items-center justify-center gap-2 font-body font-medium rounded-lg transition-all duration-300 ease-out cursor-pointer focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:ring-offset-1 hover:-translate-y-0.5 hover:scale-[1.015] active:translate-y-0 active:scale-100 shadow-sm w-full py-2.5 text-xs text-white bg-brand-500 hover:bg-white hover:text-brand-500 hover:border-brand-500 border border-transparent"
                >
                    <span class="btn-shine"></span>
                    <span class="relative z-10 inline-flex items-center justify-center gap-1.5">
                        <span x-text="hoveredItem ? 'Explore ' + hoveredItem.title : 'Explore AI Platform'">Explore AI Platform</span>
                        <svg class="w-3.5 h-3.5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </span>
                </a>
            </div>

            <!-- Bottom Image/Animation Container -->
            <div class="relative flex-1 overflow-hidden bg-white z-10">
                <img :src="hoveredItem ? hoveredItem.image : defaultImage" 
                     class="w-full h-full object-cover transition-all duration-500 transform scale-100 group-hover:scale-105" 
                     alt="Feature Preview" />
                <div class="absolute inset-x-0 top-0 h-16 bg-gradient-to-b from-white via-white/80 to-transparent pointer-events-none z-10"></div>
                <div class="anim-mega-bg-glow"></div>
            </div>
        </div>
    </div>

    {{-- Right Links Grid --}}
    <div class="w-2/3 pl-10 grid grid-cols-2 gap-x-6 gap-y-2 content-start">
        @foreach([
            ['workforce-analyst', 'Workforce Analyst', 'Attendance anomaly & productivity insights', 'Utilize machine learning models to detect attendance anomalies and analyze long-term team productivity trends.', '/images/mega-menu/ai-analyst.png'],
            ['attendance-insights', 'AI Attendance Insights', 'Smart shift & punctuality tracking', 'Extract intelligent punctuality statistics and predict shift coverage gaps before they affect operations.', '/images/mega-menu/ai-attendance.png'],
            ['fraud-detection', 'AI Fraud Detection', 'Location & time spoofing detection', 'Monitor time-clock submissions for location spoofing, VPN connections, and device tampering attempts.', '/images/mega-menu/ai-fraud.png'],
            ['executive-dashboard', 'AI Executive Dashboard', 'Natural language business queries', 'Query your business metrics using natural language prompts to instantly generate visual charts and reports.', '/images/mega-menu/ai-dashboard.png'],
            ['revenue-forecasting', 'AI Revenue Forecasting', 'Predictive income models', 'Forecast future cashflows and project agency revenues based on historical contract values and billing cycles.', '/images/mega-menu/ai-revenue.png'],
            ['freelancer-assistant', 'AI Freelancer Assistant', 'Automated invoicing & tasks', 'Delegate administrative tasks like drafting client proposals, tracking task details, and generating invoices to AI.', '/images/mega-menu/ai-freelancer.png'],
            ['productivity-insights', 'AI Productivity Insights', 'Team efficiency metrics', 'Benchmark project delivery velocity and track time efficiency scores to identify process optimizations.', '/images/mega-menu/ai-productivity.png'],
            ['compliance-monitoring', 'AI Compliance Monitoring', 'Automated policy enforcement', 'Run background audit checks to automatically flag shift schedule violations and non-compliant timelogs.', '/images/mega-menu/ai-compliance.png'],
            ['hr-assistant', 'AI HR Assistant', 'Automated onboarding & queries', 'Provide employees with instant answers to benefits questions, policy details, and onboard requests via text chat.', '/images/mega-menu/ai-hr.png'],
            ['operations-assistant', 'AI Operations Assistant', 'Smart workflow routing', 'Automate task distribution and route operation tickets dynamically to the best-suited team members.', '/images/mega-menu/ai-operations.png'],
            ['finance-assistant', 'AI Finance Assistant', 'Automated expense categorization', 'Scan receipts using optical character recognition to categorize expenses and match them against active budgets.', '/images/mega-menu/ai-finance.png'],
            ['future-agents', 'Future AI Agents', 'Autonomous workflow completion', 'Deploy autonomous AI agents trained to execute multi-step business operations and system workflows.', '/images/mega-menu/ai-agents.png'],
        ] as [$slug, $title, $desc, $hoverDesc, $hoverImg])
            <a href="javascript:void(0)" aria-disabled="true" 
               class="{!! $upcomingLinkClass !!}"
               @mouseenter="hoveredItem = { 
                   title: '{{ $title }}', 
                   desc: '{{ $hoverDesc }}', 
                   image: '{{ $hoverImg }}', 
                   link: 'javascript:void(0)' 
               }"
               @mouseleave="hoveredItem = null"
            >
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-surface flex items-center justify-center shrink-0 border border-surface-border group-hover:border-brand-500/50 group-hover:text-brand-500 group-hover:shadow-sm transition-all duration-300 overflow-hidden">
                        @switch($title)
                            @case('Workforce Analyst')
                                <svg class="w-5 h-5 text-content-muted group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path d="M12 2a4 4 0 014 4c0 2.2-3 6-4 6s-4-3.8-4-6a4 4 0 014-4z" />
                                    <path d="M12 12v7m0-7L6 6m6 6l6-4" stroke-dasharray="2 2" class="opacity-60" />
                                    <circle cx="12" cy="12" r="1.5" class="anim-ai-analyst-ping-1 text-teal-400 fill-teal-400" stroke="none" />
                                    <circle cx="12" cy="12" r="1.5" class="anim-ai-analyst-ping-2 text-brand-400 fill-brand-400" stroke="none" />
                                    <circle cx="12" cy="12" r="1.5" class="anim-ai-analyst-ping-3 text-indigo-400 fill-indigo-400" stroke="none" />
                                </svg>
                                @break
                            @case('AI Attendance Insights')
                                <svg class="w-5 h-5 text-content-muted group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="9" />
                                    <line x1="12" y1="12" x2="12" y2="7" class="anim-ai-clock-hour" stroke-linecap="round" />
                                    <line x1="12" y1="12" x2="15" y2="12" class="anim-ai-clock-min" stroke-linecap="round" />
                                    <circle cx="17" cy="7" r="1.8" class="anim-ai-clock-dot" stroke="none" />
                                </svg>
                                @break
                            @case('AI Fraud Detection')
                                <svg class="w-5 h-5 text-content-muted group-hover:text-rose-500 transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path d="M12 21s-7-5.5-7-12a7 7 0 0114 0c0 6.5-7 12-7 12z" />
                                    <circle cx="12" cy="9" r="3" class="anim-ai-fraud-ripple-1 opacity-25" fill="none" stroke-width="1" />
                                    <circle cx="12" cy="9" r="3" class="anim-ai-fraud-ripple-2 opacity-25" fill="none" stroke-width="1" />
                                    <g class="anim-ai-fraud-alert text-rose-500" stroke-width="2">
                                        <line x1="12" y1="6" x2="12" y2="9" stroke-linecap="round" />
                                        <circle cx="12" cy="12.5" r="0.75" fill="currentColor" stroke="none" />
                                    </g>
                                </svg>
                                @break
                            @case('AI Executive Dashboard')
                                <svg class="w-5 h-5 text-content-muted group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <rect x="3" y="3" width="18" height="18" rx="2" />
                                    <line x1="3" y1="9" x2="21" y2="9" />
                                    <line x1="9" y1="21" x2="9" y2="9" />
                                    <rect x="5.5" y="11" width="2" height="7" class="anim-ai-dash-bar-1 text-indigo-500 fill-indigo-500" stroke="none" />
                                    <rect x="12" y="13" width="2" height="5" class="anim-ai-dash-bar-2 text-teal-500 fill-teal-500" stroke="none" />
                                    <rect x="15.5" y="10" width="2" height="8" class="anim-ai-dash-bar-3 text-brand-500 fill-brand-500" stroke="none" />
                                </svg>
                                @break
                            @case('AI Revenue Forecasting')
                                <svg class="w-5 h-5 text-content-muted group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path d="M3 3v18h18" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M3 17l6-5 5 2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M14 14l6-7" class="anim-ai-forecast-line text-emerald-500" stroke-width="2" stroke-linecap="round" />
                                    <circle cx="20" cy="7" r="1.8" class="anim-ai-forecast-sparkle text-emerald-400 fill-emerald-400" stroke="none" />
                                </svg>
                                @break
                            @case('AI Freelancer Assistant')
                                <svg class="w-5 h-5 text-content-muted group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <rect x="4" y="9" width="16" height="11" rx="2" />
                                    <line x1="12" y1="9" x2="12" y2="5" />
                                    <circle cx="12" cy="4" r="1.2" class="anim-ai-assistant-antenna text-indigo-500 fill-indigo-500" stroke="none" />
                                    <circle cx="12" cy="4" r="3" class="anim-ai-assistant-signal text-indigo-300" fill="none" stroke-width="0.75" />
                                    <circle cx="8.5" cy="14" r="1.5" class="anim-ai-assistant-eye text-teal-400 fill-teal-400" stroke="none" />
                                    <circle cx="15.5" cy="14" r="1.5" class="anim-ai-assistant-eye text-teal-400 fill-teal-400" stroke="none" />
                                    <path d="M9.5 17c1 1 4 1 5 0" stroke-linecap="round" />
                                </svg>
                                @break
                            @case('AI Productivity Insights')
                                <svg class="w-5 h-5 text-content-muted group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path d="M3 16a9 9 0 0118 0" stroke-linecap="round" />
                                    <circle cx="12" cy="16" r="2" fill="currentColor" stroke="none" />
                                    <line x1="12" y1="16" x2="12" y2="8" stroke-width="2.2" class="anim-ai-productivity-needle text-brand-500" stroke-linecap="round" />
                                    <path d="M17 7l2-2M5 7L3 5" class="anim-ai-productivity-spark text-teal-400" stroke-linecap="round" />
                                </svg>
                                @break
                            @case('AI Compliance Monitoring')
                                <svg class="w-5 h-5 text-content-muted group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                    <circle cx="12" cy="11" r="3.5" class="anim-ai-compliance-gear" stroke-dasharray="2 1" />
                                    <line x1="6" y1="8" x2="18" y2="8" class="anim-ai-compliance-laser text-emerald-500" stroke-width="1.8" stroke-linecap="round" />
                                </svg>
                                @break
                            @case('AI HR Assistant')
                                <svg class="w-5 h-5 text-content-muted group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path d="M21 11.5a8.5 8.5 0 01-8.5 8.5H7l-4 4V11.5A8.5 8.5 0 0111.5 3h1A8.5 8.5 0 0121 11.5z" />
                                    <circle cx="8" cy="11.5" r="1" class="anim-ai-hr-dot-1 text-brand-500 fill-brand-500" stroke="none" />
                                    <circle cx="12" cy="11.5" r="1" class="anim-ai-hr-dot-2 text-brand-500 fill-brand-500" stroke="none" />
                                    <circle cx="16" cy="11.5" r="1" class="anim-ai-hr-dot-3 text-brand-500 fill-brand-500" stroke="none" />
                                </svg>
                                @break
                            @case('AI Operations Assistant')
                                <svg class="w-5 h-5 text-content-muted group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <rect x="3" y="3" width="18" height="18" rx="2" />
                                    <rect x="6" y="6" width="12" height="12" rx="1.5" class="anim-ai-ops-packet-path text-indigo-500" />
                                    <path d="M12 10a2 2 0 100 4 2 2 0 000-4z" class="anim-ai-ops-gear" />
                                </svg>
                                @break
                            @case('AI Finance Assistant')
                                <svg class="w-5 h-5 text-content-muted group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <rect x="4" y="4" width="16" height="16" rx="2" />
                                    <line x1="8" y1="8" x2="16" y2="8" />
                                    <line x1="8" y1="12" x2="13" y2="12" />
                                    <line x1="6" y1="7" x2="18" y2="7" class="anim-ai-finance-sweep text-emerald-500" stroke-width="1.8" stroke-linecap="round" />
                                </svg>
                                @break
                            @case('Future AI Agents')
                                <svg class="w-5 h-5 text-content-muted group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="3.2" class="anim-ai-agents-core text-indigo-500 fill-indigo-500" stroke="none" />
                                    <ellipse cx="12" cy="12" rx="9" ry="3" class="opacity-40" />
                                    <ellipse cx="12" cy="12" rx="9" ry="3" class="opacity-40" transform="rotate(60 12 12)" />
                                    <ellipse cx="12" cy="12" rx="9" ry="3" class="opacity-40" transform="rotate(120 12 12)" />
                                    <circle cx="21" cy="12" r="1.2" class="anim-ai-agents-electron-1 text-teal-400 fill-teal-400" stroke="none" />
                                    <circle cx="21" cy="12" r="1.2" class="anim-ai-agents-electron-2 text-brand-400 fill-brand-400" stroke="none" />
                                    <circle cx="21" cy="12" r="1.2" class="anim-ai-agents-electron-3 text-amber-400 fill-amber-400" stroke="none" />
                                </svg>
                                @break
                            @default
                                <svg class="w-5 h-5 text-content-muted group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        @endswitch
                    </div>
                    <div class="flex-1 w-full overflow-hidden">
                        <div class="flex items-center gap-2 mb-0.5">
                            <h3 class="font-display font-bold text-content-strong text-sm group-hover:text-brand-600 transition-colors">{{ $title }}</h3>
                            <x-frontend-base.badge variant="upcoming">Upcoming</x-frontend-base.badge>
                        </div>
                        <p class="text-content-muted text-xs leading-relaxed line-clamp-1">{{ $desc }}</p>
                    </div>
                </div>
                @if($sol['status'] !== 'upcoming') {!! $arrowSvg !!} @endif
            </a>
        @endforeach
    </div>
</div>

{{-- 4. RESOURCES MENU --}}
<div x-show="activeMenu === 'resources'" class="flex">
    {{-- Left Feature Panel --}}
    <div class="w-1/3 border-r border-surface-border pr-10 flex flex-col">
        <div class="bg-surface-50 rounded-2xl p-6 border border-surface-border flex-1 flex flex-col group hover:shadow-lg hover:shadow-black/5 transition-all duration-300">
            <div class="relative rounded-xl overflow-hidden border border-surface-border mb-6 shadow-sm">
                <img src="/images/mockups/mega_menu_resources.png" alt="Team Collaboration" class="w-full h-auto object-cover aspect-[4/3] group-hover:scale-105 transition-transform duration-700">
            </div>
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-lg bg-indigo-500/10 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
                <h4 class="text-xs font-bold text-indigo-600 tracking-wider uppercase">Featured Guide</h4>
            </div>
            <h3 class="font-display font-bold text-content-strong text-lg mb-2">How to scale your freelance agency using collaborative workspaces</h3>
            <p class="text-content-muted text-sm mb-6 flex-1 leading-relaxed">Discover how modern teams are ditching traditional corporate structures for agile, highly-collaborative digital headquarters.</p>
            <x-frontend-base.button href="#" variant="outline" size="sm" class="w-full justify-center">Read Full Article</x-frontend-base.button>
        </div>
    </div>
    
    {{-- Right Links Grid --}}
    <div class="w-2/3 pl-10 grid grid-cols-3 gap-x-8 gap-y-6">
        <div>
            <h4 class="text-xs font-semibold text-content-muted tracking-wider uppercase mb-4 px-3">Learn</h4>
            <ul class="space-y-1">
                @foreach([
                    ['Blog', 'Latest insights', 'frontend.blog.index'], 
                    ['Help Center', 'Guides & tutorials', '#'], 
                    ['API Docs', 'Developer guides', '#'], 
                    ['Community', 'Join the discussion', '#'], 
                    ['Webinars', 'Live training', '#']
                ] as [$title, $desc, $routeName])
                    @php $status = $routeName === '#' ? 'upcoming' : 'available'; @endphp
                    <li>
                        <a href="{{ $status === 'upcoming' ? 'javascript:void(0)' : route($routeName) }}" aria-disabled="{{ $status === 'upcoming' ? 'true' : 'false' }}" class="{!! $status === 'upcoming' ? $upcomingLinkClass : $linkClass !!}">
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <h3 class="font-medium text-sm {{ $status === 'upcoming' ? 'text-content-light' : 'text-content group-hover:text-brand-600 transition-colors' }}">{{ $title }}</h3>
                                    @if($status === 'upcoming') <x-frontend-base.badge variant="upcoming">Upcoming</x-frontend-base.badge> @endif
                                </div>
                                <p class="text-content-muted text-[11px] mt-0.5">{{ $desc }}</p>
                            </div>
                            @if($status !== 'upcoming') {!! $arrowSvg !!} @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div>
            <h4 class="text-xs font-semibold text-content-muted tracking-wider uppercase mb-4 px-3">Updates</h4>
            <ul class="space-y-1">
                @foreach([
                    ['Changelog', 'Dev history', 'frontend.changelog'], 
                    ['Release Notes', 'What\'s new', 'frontend.release-notes'], 
                    ['Roadmap', 'Future plans', 'frontend.roadmap'], 
                    ['Status', 'System uptime', '#']
                ] as [$title, $desc, $routeName])
                    @php $status = $routeName === '#' ? 'upcoming' : 'available'; @endphp
                    <li>
                        <a href="{{ $status === 'upcoming' ? 'javascript:void(0)' : route($routeName) }}" aria-disabled="{{ $status === 'upcoming' ? 'true' : 'false' }}" class="{!! $status === 'upcoming' ? $upcomingLinkClass : $linkClass !!}">
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <h3 class="font-medium text-sm {{ $status === 'upcoming' ? 'text-content-light' : 'text-content group-hover:text-brand-600 transition-colors' }}">{{ $title }}</h3>
                                    @if($status === 'upcoming') <x-frontend-base.badge variant="upcoming">Upcoming</x-frontend-base.badge> @endif
                                </div>
                                <p class="text-content-muted text-[11px] mt-0.5">{{ $desc }}</p>
                            </div>
                            @if($status !== 'upcoming') {!! $arrowSvg !!} @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div>
            <h4 class="text-xs font-semibold text-content-muted tracking-wider uppercase mb-4 px-3">Company</h4>
            <ul class="space-y-1">
                @foreach([
                    ['About', 'Our story', 'frontend.about'], 
                    ['Careers', 'Join the team', 'frontend.careers'], 
                    ['Contact', 'Get in touch', 'frontend.contact'], 
                    ['Partners', 'Partner program', '#'], 
                    ['Security', 'Trust center', 'frontend.security']
                ] as [$title, $desc, $routeName])
                    @php $status = $routeName === '#' ? 'upcoming' : 'available'; @endphp
                    <li>
                        <a href="{{ $status === 'upcoming' ? 'javascript:void(0)' : route($routeName) }}" aria-disabled="{{ $status === 'upcoming' ? 'true' : 'false' }}" class="{!! $status === 'upcoming' ? $upcomingLinkClass : $linkClass !!}">
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <h3 class="font-medium text-sm {{ $status === 'upcoming' ? 'text-content-light' : 'text-content group-hover:text-brand-600 transition-colors' }}">{{ $title }}</h3>
                                    @if($status === 'upcoming') <x-frontend-base.badge variant="upcoming">Upcoming</x-frontend-base.badge> @endif
                                </div>
                                <p class="text-content-muted text-[11px] mt-0.5">{{ $desc }}</p>
                            </div>
                            @if($status !== 'upcoming') {!! $arrowSvg !!} @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
