{{-- Products --}}
<div x-show="activeMenu === 'products'" class="grid grid-cols-3 gap-6">
    <a href="{{ route('frontend.product.organizations') }}" class="group p-4 rounded-xl hover:bg-surface transition-colors">
        <div class="w-10 h-10 rounded-lg bg-brand-500/10 flex items-center justify-center mb-3">
            <svg class="w-5 h-5 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        </div>
        <h3 class="font-display font-semibold text-white mb-1 group-hover:text-brand-400 transition-colors">For Organizations</h3>
        <p class="text-slate-400 text-sm">Complete workforce management for companies of all sizes</p>
    </a>
    <a href="{{ route('frontend.product.freelancers') }}" class="group p-4 rounded-xl hover:bg-surface transition-colors">
        <div class="w-10 h-10 rounded-lg bg-accent-500/10 flex items-center justify-center mb-3">
            <svg class="w-5 h-5 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </div>
        <h3 class="font-display font-semibold text-white mb-1 group-hover:text-accent-400 transition-colors">For Freelancers</h3>
        <p class="text-slate-400 text-sm">Manage clients, invoices, tasks, and revenue â€” start free</p>
    </a>
    <a href="{{ route('frontend.product.workspace') }}" class="group p-4 rounded-xl hover:bg-surface transition-colors">
        <div class="w-10 h-10 rounded-lg bg-amber-500/10 flex items-center justify-center mb-3">
            <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <h3 class="font-display font-semibold text-white mb-1 group-hover:text-amber-400 transition-colors">Freelance Workspace</h3>
        <p class="text-slate-400 text-sm">Collaborative workspace for freelance teams and agencies</p>
        <x-frontend-base.badge variant="pro" class="mt-2">Requires Pro</x-frontend-base.badge>
    </a>
</div>

{{-- Solutions --}}
<div x-show="activeMenu === 'solutions'" class="grid grid-cols-3 lg:grid-cols-5 gap-4">
    @foreach([
        ['slug' => 'workforce-management', 'title' => 'Workforce Mgmt', 'desc' => 'Employees, attendance, leaves, shifts'],
        ['slug' => 'operations-management', 'title' => 'Operations', 'desc' => 'Departments, teams, workflows'],
        ['slug' => 'financial-operations', 'title' => 'Financial Ops', 'desc' => 'Invoices, payments, revenue'],
        ['slug' => 'freelancer-management', 'title' => 'Freelancer Mgmt', 'desc' => 'Clients, leads, projects'],
        ['slug' => 'ai-operations', 'title' => 'AI Operations', 'desc' => 'Intelligence for workflows'],
    ] as $sol)
        <a href="{{ route('frontend.solutions.show', $sol['slug']) }}" class="group p-4 rounded-xl hover:bg-surface transition-colors">
            <h3 class="font-display font-semibold text-white text-sm mb-1 group-hover:text-brand-400 transition-colors">{{ $sol['title'] }}</h3>
            <p class="text-slate-400 text-xs">{{ $sol['desc'] }}</p>
        </a>
    @endforeach
</div>

{{-- AI --}}
<div x-show="activeMenu === 'ai'" class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    @foreach([
        ['title' => 'AI Workforce Analyst', 'desc' => 'Attendance anomaly, productivity insights'],
        ['title' => 'AI Fraud Detection', 'desc' => 'Suspicious activity detection'],
        ['title' => 'AI Executive Dashboard', 'desc' => 'Natural language business queries'],
        ['title' => 'AI Freelancer Assistant', 'desc' => 'Invoice, revenue forecasting'],
    ] as $ai)
        <a href="{{ route('frontend.ai') }}" class="group p-4 rounded-xl hover:bg-surface transition-colors">
            <div class="w-8 h-8 rounded-lg bg-brand-500/10 flex items-center justify-center mb-2">
                <svg class="w-4 h-4 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <h3 class="font-display font-semibold text-white text-sm mb-1 group-hover:text-brand-400 transition-colors">{{ $ai['title'] }}</h3>
            <p class="text-slate-400 text-xs">{{ $ai['desc'] }}</p>
        </a>
    @endforeach
</div>

{{-- Resources --}}
<div x-show="activeMenu === 'resources'" class="grid grid-cols-3 gap-4">
    @foreach([
        ['Blog', 'Latest insights', 'frontend.blog.index'],
        ['FAQs', 'Common questions', 'frontend.faqs.index'],
        ['Release Notes', 'What\'s new', 'frontend.release-notes'],
        ['Changelog', 'Dev history', 'frontend.changelog'],
        ['Security', 'Trust center', 'frontend.security'],
        ['Roadmap', 'Future plans', 'frontend.roadmap'],
    ] as [$title, $desc, $routeName])
        <a href="{{ route($routeName) }}" class="group p-3 rounded-xl hover:bg-surface transition-colors">
            <h3 class="font-display font-semibold text-white text-sm mb-0.5 group-hover:text-brand-400 transition-colors">{{ $title }}</h3>
            <p class="text-slate-400 text-xs">{{ $desc }}</p>
        </a>
    @endforeach
</div>

{{-- Company --}}
<div x-show="activeMenu === 'company'" class="grid grid-cols-3 gap-6 max-w-2xl">
    @foreach([
        ['About', 'Our story and mission', 'frontend.about'],
        ['Careers', 'Join the team', 'frontend.careers'],
        ['Contact', 'Get in touch', 'frontend.contact'],
    ] as [$title, $desc, $routeName])
        <a href="{{ route($routeName) }}" class="group p-4 rounded-xl hover:bg-surface transition-colors">
            <h3 class="font-display font-semibold text-white text-sm mb-1 group-hover:text-brand-400 transition-colors">{{ $title }}</h3>
            <p class="text-slate-400 text-xs">{{ $desc }}</p>
        </a>
    @endforeach
</div>
