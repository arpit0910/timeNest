{{-- Standardized Link Component for Macro Use in the menu --}}
@php
    $linkClass = "group flex items-center justify-between p-3 rounded-xl bg-transparent hover:bg-surface-50 hover:shadow-[0_2px_8px_-2px_rgba(0,0,0,0.05)] border border-transparent hover:border-surface-border transition-all duration-300";
    $arrowSvg = '<svg class="w-4 h-4 text-content-light group-hover:text-brand-500 group-hover:translate-x-1.5 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>';
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
            <a href="{{ route('frontend.product.freelancers') }}" class="group block p-4 rounded-xl border border-transparent hover:border-accent-500/20 hover:bg-accent-50/50 hover:shadow-lg hover:shadow-accent-500/5 transition-all duration-300 relative overflow-hidden">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-accent-500/10 flex items-center justify-center shrink-0 transition-all duration-300 group-hover:bg-accent-500 group-hover:scale-110 group-hover:shadow-md">
                        <svg class="w-6 h-6 text-accent-600 transition-colors duration-300 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-display font-bold text-content-strong mb-1 group-hover:text-accent-600 flex items-center gap-2 transition-colors">For Freelancers {!! $arrowSvg !!}</h3>
                        <p class="text-content-muted text-xs leading-relaxed">Manage clients, invoices, tasks, and revenue.</p>
                    </div>
                </div>
            </a>
            
            {{-- Workspace --}}
            <a href="{{ route('frontend.product.workspace') }}" class="group block p-4 rounded-xl border border-transparent hover:border-amber-500/20 hover:bg-amber-50/50 hover:shadow-lg hover:shadow-amber-500/5 transition-all duration-300 relative overflow-hidden">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/10 flex items-center justify-center shrink-0 transition-all duration-300 group-hover:bg-amber-500 group-hover:scale-110 group-hover:shadow-md">
                        <svg class="w-6 h-6 text-amber-600 transition-colors duration-300 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-display font-bold text-content-strong mb-1 group-hover:text-amber-600 flex items-center gap-2 transition-colors">Freelance Workspace {!! $arrowSvg !!}</h3>
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
                    'departments' => 'Departments', 
                    'teams' => 'Teams', 
                    'roles-permissions' => 'Roles & Perms', 
                    'audit-logs' => 'Audit Logs', 
                    'workforce-analytics' => 'Analytics'
                ] as $slug => $item)
                    <li>
                        <a href="{{ route('frontend.feature.show', ['category' => 'operations', 'slug' => $slug]) }}" class="{!! $linkClass !!}">
                            <span class="text-sm font-medium text-content group-hover:text-brand-600 transition-colors">{{ $item }}</span>
                            {!! $arrowSvg !!}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div>
            <h4 class="text-xs font-semibold text-content-muted tracking-wider uppercase mb-4 px-3">Upcoming</h4>
            <ul class="space-y-1">
                @foreach(['Workflows', 'Approvals', 'Payroll Sync', 'ATS', 'Performance'] as $item)
                    <li>
                        <a href="#" class="{!! $linkClass !!}">
                            <span class="text-sm font-medium text-content-light group-hover:text-content transition-colors">{{ $item }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

{{-- 2. SOLUTIONS MENU --}}
<div x-show="activeMenu === 'solutions'" class="flex">
    {{-- Left Feature Panel --}}
    <div class="w-1/3 border-r border-surface-border pr-10 flex flex-col">
        <div class="bg-brand-50 rounded-2xl p-6 border border-brand-100 flex-1 flex flex-col group hover:shadow-lg hover:shadow-brand-500/10 transition-all duration-300">
            <h3 class="font-display text-xl font-bold text-brand-900 mb-2">Enterprise Solutions</h3>
            <p class="text-brand-700 text-sm mb-6 leading-relaxed">End-to-end operational workflows designed to scale with your business and break down data silos.</p>
            <x-frontend-base.button href="#" variant="primary" color="brand" class="w-full justify-center mb-6 shadow-md shadow-brand-500/20">Explore All Solutions</x-frontend-base.button>
            <div class="mt-auto relative rounded-xl overflow-hidden border border-brand-200/50 shadow-sm">
                <img src="/images/mockups/mega_menu_solutions.png" alt="Solutions Dashboard" class="w-full h-auto object-cover aspect-[4/3] group-hover:scale-105 transition-transform duration-700">
            </div>
        </div>
    </div>
    
    {{-- Right Links Grid --}}
    <div class="w-2/3 pl-10 grid grid-cols-2 gap-x-6 gap-y-2 content-start">
        @foreach([
            ['slug' => 'workforce-management', 'title' => 'Workforce Mgmt', 'desc' => 'Employees, attendance, leaves, shifts', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
            ['slug' => 'operations-management', 'title' => 'Operations Mgmt', 'desc' => 'Departments, teams, workflows', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
            ['slug' => 'financial-operations', 'title' => 'Financial Ops', 'desc' => 'Invoices, payments, revenue', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['slug' => 'freelancer-management', 'title' => 'Freelancer Mgmt', 'desc' => 'Clients, leads, projects, tasks', 'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
            ['slug' => 'ai-operations', 'title' => 'AI Operations', 'desc' => 'Intelligence for workflows', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
            ['slug' => '#', 'title' => 'Global Compliance', 'desc' => 'GDPR, SOC2, policies', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['slug' => '#', 'title' => 'Enterprise Security', 'desc' => 'Audit logs, role permissions', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
            ['slug' => '#', 'title' => 'Remote Teams', 'desc' => 'Async communication, global sync', 'icon' => 'M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9'],
            ['slug' => '#', 'title' => 'Integrations', 'desc' => 'Connect your tools', 'icon' => 'M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z'],
            ['slug' => '#', 'title' => 'API Access', 'desc' => 'Build on top of TimeNest', 'icon' => 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4'],
        ] as $sol)
            <a href="{{ $sol['slug'] === '#' ? '#' : route('frontend.solutions.show', $sol['slug']) }}" class="{!! $linkClass !!}">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-surface flex items-center justify-center shrink-0 border border-surface-border group-hover:border-brand-500/50 group-hover:text-brand-500 group-hover:shadow-sm transition-all duration-300">
                        <svg class="w-5 h-5 text-content-muted group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $sol['icon'] }}"/></svg>
                    </div>
                    <div>
                        <h3 class="font-display font-bold text-content-strong text-sm mb-0.5 group-hover:text-brand-600 transition-colors">{{ $sol['title'] }}</h3>
                        <p class="text-content-muted text-xs leading-relaxed line-clamp-1">{{ $sol['desc'] }}</p>
                    </div>
                </div>
                {!! $arrowSvg !!}
            </a>
        @endforeach
    </div>
</div>

{{-- 3. AI MENU --}}
<div x-show="activeMenu === 'ai'" class="flex">
    {{-- Left Feature Panel --}}
    <div class="w-1/3 border-r border-surface-border pr-10 flex flex-col">
        <div class="bg-brand-50 rounded-2xl p-6 border border-brand-100 flex-1 flex flex-col group hover:shadow-lg hover:shadow-brand-500/10 transition-all duration-300">
            <h3 class="font-display text-xl font-bold text-brand-900 mb-2">TimeNest AI</h3>
            <p class="text-brand-700 text-sm mb-6 leading-relaxed">Intelligence built into every module. Automate routine tasks, detect anomalies, and query your business data using natural language.</p>
            <x-frontend-base.button href="{{ route('frontend.ai') }}" variant="primary" color="brand" class="w-full justify-center mb-6 shadow-md shadow-brand-500/20">Explore AI Platform</x-frontend-base.button>
            <div class="mt-auto relative rounded-xl overflow-hidden border border-brand-200/50 shadow-sm">
                <img src="/images/mockups/mega_menu_ai.png" alt="AI Analytics Interface" class="w-full h-auto object-cover aspect-[4/3] group-hover:scale-105 transition-transform duration-700">
            </div>
        </div>
    </div>
    
    {{-- Right Links Grid --}}
    <div class="w-2/3 pl-10 grid grid-cols-2 gap-x-6 gap-y-2 content-start">
        @foreach([
            ['workforce-analyst', 'Workforce Analyst', 'Attendance anomaly & productivity insights'],
            ['attendance-insights', 'AI Attendance Insights', 'Smart shift & punctuality tracking'],
            ['fraud-detection', 'AI Fraud Detection', 'Location & time spoofing detection'],
            ['executive-dashboard', 'AI Executive Dashboard', 'Natural language business queries'],
            ['revenue-forecasting', 'AI Revenue Forecasting', 'Predictive income models'],
            ['freelancer-assistant', 'AI Freelancer Assistant', 'Automated invoicing & tasks'],
            ['productivity-insights', 'AI Productivity Insights', 'Team efficiency metrics'],
            ['compliance-monitoring', 'AI Compliance Monitoring', 'Automated policy enforcement'],
            ['hr-assistant', 'AI HR Assistant', 'Automated onboarding & queries'],
            ['operations-assistant', 'AI Operations Assistant', 'Smart workflow routing'],
            ['finance-assistant', 'AI Finance Assistant', 'Automated expense categorization'],
            ['future-agents', 'Future AI Agents', 'Autonomous workflow completion'],
        ] as [$slug, $title, $desc])
            <a href="{{ route('frontend.feature.show', ['category' => 'ai', 'slug' => $slug]) }}" class="{!! $linkClass !!}">
                <div>
                    <h3 class="font-display font-bold text-content-strong text-sm mb-0.5 group-hover:text-brand-600 transition-colors">{{ $title }}</h3>
                    <p class="text-content-muted text-xs line-clamp-1">{{ $desc }}</p>
                </div>
                {!! $arrowSvg !!}
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
                    <li>
                        <a href="{{ $routeName === '#' ? '#' : route($routeName) }}" class="{!! $linkClass !!}">
                            <div>
                                <h3 class="font-medium text-sm text-content group-hover:text-brand-600 transition-colors">{{ $title }}</h3>
                                <p class="text-content-muted text-[11px] mt-0.5">{{ $desc }}</p>
                            </div>
                            {!! $arrowSvg !!}
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
                    <li>
                        <a href="{{ $routeName === '#' ? '#' : route($routeName) }}" class="{!! $linkClass !!}">
                            <div>
                                <h3 class="font-medium text-sm text-content group-hover:text-brand-600 transition-colors">{{ $title }}</h3>
                                <p class="text-content-muted text-[11px] mt-0.5">{{ $desc }}</p>
                            </div>
                            {!! $arrowSvg !!}
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
                    <li>
                        <a href="{{ $routeName === '#' ? '#' : route($routeName) }}" class="{!! $linkClass !!}">
                            <div>
                                <h3 class="font-medium text-sm text-content group-hover:text-brand-600 transition-colors">{{ $title }}</h3>
                                <p class="text-content-muted text-[11px] mt-0.5">{{ $desc }}</p>
                            </div>
                            {!! $arrowSvg !!}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
