{{-- Products --}}
<div x-show="activeMenu === 'products'" class="flex gap-8">
    <div class="w-1/3 border-r border-surface-border pr-8">
        <h4 class="text-xs font-semibold text-content-muted tracking-wider uppercase mb-4">Core Platforms</h4>
        <div class="space-y-2">
            <a href="{{ route('frontend.product.organizations') }}" class="group block p-3 rounded-xl hover:bg-surface-50 transition-all border border-transparent hover:border-surface-border relative">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-lg bg-brand-500/10 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <div>
                        <h3 class="font-display font-semibold text-content-strong mb-0.5 group-hover:text-brand-500 flex items-center gap-1">For Organizations <svg class="w-4 h-4 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></h3>
                        <p class="text-content-muted text-xs leading-relaxed">Complete workforce management for companies of all sizes</p>
                    </div>
                </div>
            </a>
            <a href="{{ route('frontend.product.freelancers') }}" class="group block p-3 rounded-xl hover:bg-surface-50 transition-all border border-transparent hover:border-surface-border relative">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-lg bg-accent-500/10 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-display font-semibold text-content-strong mb-0.5 group-hover:text-accent-500 flex items-center gap-1">For Freelancers <svg class="w-4 h-4 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></h3>
                        <p class="text-content-muted text-xs leading-relaxed">Manage clients, invoices, tasks, and revenue</p>
                    </div>
                </div>
            </a>
            <a href="{{ route('frontend.product.workspace') }}" class="group block p-3 rounded-xl hover:bg-surface-50 transition-all border border-transparent hover:border-surface-border relative">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-lg bg-amber-500/10 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-display font-semibold text-content-strong mb-0.5 group-hover:text-amber-500 flex items-center gap-1">Freelance Workspace <svg class="w-4 h-4 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></h3>
                        <p class="text-content-muted text-xs leading-relaxed">Collaborative workspace for freelance teams</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="w-2/3 grid grid-cols-3 gap-x-6 gap-y-4">
        <div>
            <h4 class="text-xs font-semibold text-content-muted tracking-wider uppercase mb-3">Workforce</h4>
            <ul class="space-y-1.5">
                @foreach([
                    'attendance-management' => 'Attendance Management', 
                    'timelog-management' => 'Timelog Management', 
                    'leave-management' => 'Leave Management', 
                    'shift-management' => 'Shift Management', 
                    'employee-directory' => 'Employee Directory'
                ] as $slug => $item)
                    <li><a href="{{ route('frontend.feature.show', ['category' => 'workforce', 'slug' => $slug]) }}" class="group flex items-center justify-between text-sm text-content hover:text-brand-500 py-1 transition-colors">{{ $item }} <svg class="w-3 h-3 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></a></li>
                @endforeach
            </ul>
        </div>
        <div>
            <h4 class="text-xs font-semibold text-content-muted tracking-wider uppercase mb-3">Operations</h4>
            <ul class="space-y-1.5">
                @foreach([
                    'departments' => 'Departments', 
                    'teams' => 'Teams', 
                    'roles-permissions' => 'Roles & Permissions', 
                    'audit-logs' => 'Audit Logs', 
                    'workforce-analytics' => 'Workforce Analytics'
                ] as $slug => $item)
                    <li><a href="{{ route('frontend.feature.show', ['category' => 'operations', 'slug' => $slug]) }}" class="group flex items-center justify-between text-sm text-content hover:text-brand-500 py-1 transition-colors">{{ $item }} <svg class="w-3 h-3 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></a></li>
                @endforeach
            </ul>
        </div>
        <div>
            <h4 class="text-xs font-semibold text-content-muted tracking-wider uppercase mb-3">Upcoming</h4>
            <ul class="space-y-1.5">
                @foreach(['Workflows', 'Approvals', 'Future Payroll', 'Future ATS', 'Future Performance Reviews', 'Future Asset Management'] as $item)
                    <li><a href="#" class="group flex items-center justify-between text-sm text-content-light hover:text-content-strong py-1 transition-colors">{{ $item }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

{{-- Solutions --}}
<div x-show="activeMenu === 'solutions'" class="grid grid-cols-4 gap-6">
    @foreach([
        ['slug' => 'workforce-management', 'title' => 'Workforce Mgmt', 'desc' => 'Employees, attendance, leaves, shifts', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
        ['slug' => 'operations-management', 'title' => 'Operations Mgmt', 'desc' => 'Departments, teams, workflows', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
        ['slug' => 'financial-operations', 'title' => 'Financial Ops', 'desc' => 'Invoices, payments, revenue', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['slug' => 'freelancer-management', 'title' => 'Freelancer Mgmt', 'desc' => 'Clients, leads, projects, tasks', 'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
        ['slug' => 'ai-operations', 'title' => 'AI Operations', 'desc' => 'Intelligence for workflows', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
    ] as $sol)
        <a href="{{ route('frontend.solutions.show', $sol['slug']) }}" class="group flex items-start gap-3 p-3 rounded-xl hover:bg-surface-50 transition-all border border-transparent hover:border-surface-border">
            <div class="w-10 h-10 rounded-lg bg-surface flex items-center justify-center shrink-0 border border-surface-border group-hover:border-brand-500/50 group-hover:text-brand-500 transition-colors">
                <svg class="w-5 h-5 text-content-muted group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $sol['icon'] }}"/></svg>
            </div>
            <div>
                <h3 class="font-display font-semibold text-content-strong text-sm mb-0.5 group-hover:text-brand-500 flex items-center gap-1">{{ $sol['title'] }}</h3>
                <p class="text-content-muted text-xs leading-relaxed">{{ $sol['desc'] }}</p>
            </div>
        </a>
    @endforeach
</div>

{{-- AI --}}
<div x-show="activeMenu === 'ai'" class="flex gap-8">
    <div class="w-1/3 bg-brand-50 rounded-xl p-6 border border-brand-100">
        <h3 class="font-display text-lg font-bold text-brand-900 mb-2">TimeNest AI</h3>
        <p class="text-brand-700 text-sm mb-6 leading-relaxed">Intelligence built into every module. Automate routine tasks, detect anomalies, and query your business data using natural language.</p>
        <x-frontend-base.button href="{{ route('frontend.ai') }}" variant="primary" color="brand" class="w-full justify-center">Explore AI Platform</x-frontend-base.button>
    </div>
    <div class="w-2/3 grid grid-cols-2 gap-x-6 gap-y-2">
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
            <a href="{{ route('frontend.feature.show', ['category' => 'ai', 'slug' => $slug]) }}" class="group p-3 rounded-xl hover:bg-surface-50 transition-all border border-transparent hover:border-surface-border flex items-center justify-between">
                <div>
                    <h3 class="font-display font-medium text-content-strong text-sm group-hover:text-brand-500 transition-colors">{{ $title }}</h3>
                    <p class="text-content-muted text-[11px] mt-0.5">{{ $desc }}</p>
                </div>
                <svg class="w-4 h-4 text-content-light opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 group-hover:text-brand-500 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        @endforeach
    </div>
</div>

{{-- Resources --}}
<div x-show="activeMenu === 'resources'" class="grid grid-cols-4 gap-6">
    <div class="col-span-1 space-y-1">
        <h4 class="text-xs font-semibold text-content-muted tracking-wider uppercase mb-3 px-3">Learn</h4>
        @foreach([['Blog', 'Latest insights', 'frontend.blog.index'], ['Help Center', 'Guides & tutorials', '#'], ['API Documentation', 'Developer guides', '#'], ['Community', 'Join the discussion', '#'], ['Webinars', 'Live training', '#']] as [$title, $desc, $routeName])
            <a href="{{ $routeName === '#' ? '#' : route($routeName) }}" class="group block p-3 rounded-xl hover:bg-surface-50 transition-all border border-transparent hover:border-surface-border">
                <h3 class="font-display font-medium text-content-strong text-sm group-hover:text-brand-500 transition-colors flex items-center gap-2">{{ $title }} <svg class="w-3 h-3 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg></h3>
                <p class="text-content-muted text-[11px] mt-0.5">{{ $desc }}</p>
            </a>
        @endforeach
    </div>
    <div class="col-span-1 space-y-1">
        <h4 class="text-xs font-semibold text-content-muted tracking-wider uppercase mb-3 px-3">Updates</h4>
        @foreach([['Changelog', 'Dev history', 'frontend.changelog'], ['Release Notes', 'What\'s new', 'frontend.release-notes'], ['Roadmap', 'Future plans', 'frontend.roadmap'], ['Status', 'System uptime', '#']] as [$title, $desc, $routeName])
            <a href="{{ $routeName === '#' ? '#' : route($routeName) }}" class="group block p-3 rounded-xl hover:bg-surface-50 transition-all border border-transparent hover:border-surface-border">
                <h3 class="font-display font-medium text-content-strong text-sm group-hover:text-brand-500 transition-colors flex items-center gap-2">{{ $title }} <svg class="w-3 h-3 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg></h3>
                <p class="text-content-muted text-[11px] mt-0.5">{{ $desc }}</p>
            </a>
        @endforeach
    </div>
    <div class="col-span-1 space-y-1">
        <h4 class="text-xs font-semibold text-content-muted tracking-wider uppercase mb-3 px-3">Company</h4>
        @foreach([['About', 'Our story', 'frontend.about'], ['Careers', 'Join the team', 'frontend.careers'], ['Contact', 'Get in touch', 'frontend.contact'], ['Partners', 'Partner program', '#'], ['Security', 'Trust center', 'frontend.security']] as [$title, $desc, $routeName])
            <a href="{{ $routeName === '#' ? '#' : route($routeName) }}" class="group block p-3 rounded-xl hover:bg-surface-50 transition-all border border-transparent hover:border-surface-border">
                <h3 class="font-display font-medium text-content-strong text-sm group-hover:text-brand-500 transition-colors flex items-center gap-2">{{ $title }} <svg class="w-3 h-3 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg></h3>
                <p class="text-content-muted text-[11px] mt-0.5">{{ $desc }}</p>
            </a>
        @endforeach
    </div>
    <div class="col-span-1">
        <div class="bg-surface-50 rounded-xl p-5 border border-surface-border h-full flex flex-col">
            <div class="w-10 h-10 rounded-lg bg-indigo-500/10 flex items-center justify-center mb-4">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
            </div>
            <h3 class="font-display font-bold text-content-strong mb-2">Read our latest guide</h3>
            <p class="text-content-muted text-sm mb-4 flex-1">How to scale your freelance agency using collaborative workspaces.</p>
            <x-frontend-base.button href="#" variant="outline" size="sm" class="w-full justify-center text-xs">Read Article</x-frontend-base.button>
        </div>
    </div>
</div>
