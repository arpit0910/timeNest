<x-frontend-layout.app
    metaTitle="TimeNest â€” The Work Operating System for Modern Teams"
    metaDescription="Complete workforce management for organizations, freelancer tools, and collaborative workspaces. One platform for every workflow."
>
    {{-- Section 1: Hero --}}
    <x-frontend-sections.hero-section
        headline="The Work Operating System<br><span class='text-gradient'>for Modern Teams</span>"
        subheadline="Manage employees, freelancers, and collaborative workspaces in one powerful platform. From attendance to AI analytics â€” everything your team needs."
        primaryCtaText="Book a Demo"
        primaryCtaUrl="{{ route('frontend.book-demo') }}"
        secondaryCtaText="Start for Free"
        secondaryCtaUrl="/register"
    >
        {{-- Logo Strip --}}
        <div class="mt-16">
            <x-frontend-sections.logo-strip title="Trusted by teams at" />
        </div>
    </x-frontend-sections.hero-section>

    {{-- Section 2: Role-Based Problem Statement --}}
    <section class="py-20 bg-surface" x-data="{ activeTab: 'founders' }">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <x-frontend-sections.section-header title="Built for everyone who runs work" subtitle="Whether you're a founder scaling a company or a freelancer managing clients, TimeNest adapts to your workflow." badge="For Every Role" />

            <div class="flex flex-wrap justify-center gap-2 mb-12">
                @foreach(['founders' => 'Founders', 'hr' => 'HR Teams', 'operations' => 'Operations', 'freelancers' => 'Freelancers', 'agencies' => 'Agencies'] as $key => $label)
                    <button @click="activeTab = '{{ $key }}'" :class="activeTab === '{{ $key }}' ? 'bg-brand-500 text-white' : 'bg-surface-card text-slate-400 hover:text-white'" class="px-4 py-2 rounded-lg text-sm font-body transition-all cursor-pointer">{{ $label }}</button>
                @endforeach
            </div>

            <div class="rounded-xl border border-surface-border bg-surface-card p-8">
                <div x-show="activeTab === 'founders'" x-transition>
                    <div class="grid md:grid-cols-3 gap-8">
                        <div><h3 class="font-display text-lg font-semibold text-red-400 mb-2">ðŸ˜¤ The Pain</h3><p class="text-slate-400 text-sm">Juggling 5+ tools for HR, attendance, leaves, and payroll. No unified view of workforce health.</p></div>
                        <div><h3 class="font-display text-lg font-semibold text-brand-400 mb-2">âœ… TimeNest Solution</h3><p class="text-slate-400 text-sm">One platform to manage your entire workforce. Real-time dashboards, AI-powered insights, and automated workflows.</p></div>
                        <div><h3 class="font-display text-lg font-semibold text-white mb-2">ðŸ“¦ Key Modules</h3><ul class="text-slate-400 text-sm space-y-1"><li>â€¢ Employee Management</li><li>â€¢ AI Executive Dashboard</li><li>â€¢ Analytics & Reports</li><li>â€¢ Approvals & Workflows</li></ul></div>
                    </div>
                </div>
                <div x-show="activeTab === 'hr'" x-transition>
                    <div class="grid md:grid-cols-3 gap-8">
                        <div><h3 class="font-display text-lg font-semibold text-red-400 mb-2">ðŸ˜¤ The Pain</h3><p class="text-slate-400 text-sm">Manual attendance tracking, leave conflicts, shift scheduling nightmares, and compliance gaps.</p></div>
                        <div><h3 class="font-display text-lg font-semibold text-brand-400 mb-2">âœ… TimeNest Solution</h3><p class="text-slate-400 text-sm">Automated attendance, smart leave management, shift builder, and AI fraud detection to keep everything honest.</p></div>
                        <div><h3 class="font-display text-lg font-semibold text-white mb-2">ðŸ“¦ Key Modules</h3><ul class="text-slate-400 text-sm space-y-1"><li>â€¢ Attendance & Shifts</li><li>â€¢ Leave Management</li><li>â€¢ AI Fraud Detection</li><li>â€¢ Audit Logs</li></ul></div>
                    </div>
                </div>
                <div x-show="activeTab === 'operations'" x-transition>
                    <div class="grid md:grid-cols-3 gap-8">
                        <div><h3 class="font-display text-lg font-semibold text-red-400 mb-2">ðŸ˜¤ The Pain</h3><p class="text-slate-400 text-sm">Department silos, broken approval chains, and no visibility into team performance or resource allocation.</p></div>
                        <div><h3 class="font-display text-lg font-semibold text-brand-400 mb-2">âœ… TimeNest Solution</h3><p class="text-slate-400 text-sm">Centralized department and team management. Custom workflows, role-based permissions, and operational analytics.</p></div>
                        <div><h3 class="font-display text-lg font-semibold text-white mb-2">ðŸ“¦ Key Modules</h3><ul class="text-slate-400 text-sm space-y-1"><li>â€¢ Departments & Teams</li><li>â€¢ Workflows & Approvals</li><li>â€¢ Roles & Permissions</li><li>â€¢ Analytics</li></ul></div>
                    </div>
                </div>
                <div x-show="activeTab === 'freelancers'" x-transition>
                    <div class="grid md:grid-cols-3 gap-8">
                        <div><h3 class="font-display text-lg font-semibold text-red-400 mb-2">ðŸ˜¤ The Pain</h3><p class="text-slate-400 text-sm">Scattered client data, manual invoicing, no revenue tracking, and zero business intelligence.</p></div>
                        <div><h3 class="font-display text-lg font-semibold text-brand-400 mb-2">âœ… TimeNest Solution</h3><p class="text-slate-400 text-sm">All-in-one freelancer platform. CRM, invoicing, task management, and AI revenue forecasting â€” core features free.</p></div>
                        <div><h3 class="font-display text-lg font-semibold text-white mb-2">ðŸ“¦ Key Modules</h3><ul class="text-slate-400 text-sm space-y-1"><li>â€¢ Clients & Leads</li><li>â€¢ Invoices & Payments</li><li>â€¢ Tasks & Projects</li><li>â€¢ Revenue Tracking</li></ul></div>
                    </div>
                </div>
                <div x-show="activeTab === 'agencies'" x-transition>
                    <div class="grid md:grid-cols-3 gap-8">
                        <div><h3 class="font-display text-lg font-semibold text-red-400 mb-2">ðŸ˜¤ The Pain</h3><p class="text-slate-400 text-sm">Managing a freelance team without proper tools. No shared projects, no unified invoicing, no team analytics.</p></div>
                        <div><h3 class="font-display text-lg font-semibold text-brand-400 mb-2">âœ… TimeNest Solution</h3><p class="text-slate-400 text-sm">Freelance Workspace â€” a collaborative environment for agencies. Shared projects, shared invoicing, team analytics.</p></div>
                        <div><h3 class="font-display text-lg font-semibold text-white mb-2">ðŸ“¦ Key Modules</h3><ul class="text-slate-400 text-sm space-y-1"><li>â€¢ Collaborator Management</li><li>â€¢ Shared Projects & Tasks</li><li>â€¢ Shared Invoices</li><li>â€¢ Workspace Analytics</li></ul></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Section 3: Product Lines --}}
    <section class="py-20 bg-surface-card/30">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <x-frontend-sections.section-header title="Three products, one platform" subtitle="Choose the product that fits your workflow. Scale as you grow." badge="Products" />
            <div class="grid md:grid-cols-3 gap-6">
                @foreach([
                    ['title' => 'For Organizations', 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>', 'desc' => 'Complete workforce and operations management for companies of all sizes.', 'features' => ['Employee Management', 'Attendance & Leaves', 'Shifts & Departments', 'Analytics & Workflows'], 'cta' => 'Book Demo', 'url' => route('frontend.book-demo'), 'color' => 'brand'],
                    ['title' => 'For Freelancers', 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>', 'desc' => 'Everything a solo freelancer needs to manage clients, revenue, and projects.', 'features' => ['Clients & Leads', 'Invoices & Payments', 'Tasks & Projects', 'Revenue Tracking'], 'cta' => 'Start Free', 'url' => '/register', 'color' => 'accent'],
                    ['title' => 'Freelance Workspace', 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>', 'desc' => 'Collaborative workspace for freelance teams, agencies, and creative studios.', 'features' => ['Collaborator Management', 'Shared Projects', 'Shared Invoices', 'Team Analytics'], 'cta' => 'Upgrade to Pro', 'url' => route('frontend.pricing'), 'color' => 'amber', 'pro' => true],
                ] as $product)
                    <div class="group rounded-xl border border-surface-border bg-surface-card p-8 hover:border-{{ $product['color'] }}-500/30 hover:shadow-lg transition-all duration-300 flex flex-col">
                        <div class="w-12 h-12 rounded-xl bg-{{ $product['color'] }}-500/10 flex items-center justify-center mb-4 text-{{ $product['color'] }}-400">{!! $product['icon'] !!}</div>
                        <h3 class="font-display text-xl font-bold text-white mb-2">{{ $product['title'] }}</h3>
                        @if(isset($product['pro']))<x-frontend-base.badge variant="pro" class="mb-3">Requires Pro</x-frontend-base.badge>@endif
                        <p class="text-slate-400 text-sm mb-4">{{ $product['desc'] }}</p>
                        <ul class="space-y-2 mb-6 flex-1">
                            @foreach($product['features'] as $f)
                                <li class="flex items-center gap-2 text-sm text-slate-300"><svg class="w-4 h-4 text-{{ $product['color'] }}-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>{{ $f }}</li>
                            @endforeach
                        </ul>
                        <x-frontend-base.button :href="$product['url']" variant="outline" color="white" class="w-full">{{ $product['cta'] }}</x-frontend-base.button>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Section 4: Core Features Grid --}}
    <section class="py-20 bg-surface">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <x-frontend-sections.section-header title="Everything you need to manage work" subtitle="Powerful modules designed for real-world workforce operations." badge="Core Features" />
            <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-4">
                @foreach([
                    ['Employee Management', 'Add, organize, and manage your entire workforce'],
                    ['Attendance Tracking', 'Real-time clock-in/out with GPS support'],
                    ['Leave Management', 'Automated leave policies and approval workflows'],
                    ['Shift Scheduling', 'Create rotating shifts and manage schedules'],
                    ['Departments', 'Organize your organization by departments and teams'],
                    ['Workflows', 'Custom approval chains and automated processes'],
                    ['Analytics', 'Real-time dashboards and detailed reports'],
                    ['Approvals', 'Multi-level approval system for all operations'],
                    ['Audit Logs', 'Complete activity trail for compliance'],
                    ['Roles & Permissions', 'Granular role-based access control'],
                ] as [$title, $desc])
                    <div class="rounded-lg border border-surface-border bg-surface-card p-4 hover:border-brand-500/20 transition-colors">
                        <h4 class="font-display text-sm font-semibold text-white mb-1">{{ $title }}</h4>
                        <p class="text-slate-500 text-xs">{{ $desc }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Section 5: AI Teaser --}}
    <section class="py-20 bg-surface relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-brand-500/5 via-transparent to-accent-500/5"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8">
            <x-frontend-sections.section-header title="AI that works while you work" subtitle="Intelligent features powered by machine learning, built into every module." badge="TimeNest AI" />
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach([
                    ['AI Workforce Analyst', 'Detect attendance anomalies, leave abuse patterns, and overtime irregularities automatically.', 'ðŸ”'],
                    ['AI Fraud Detection', 'Identify fake attendance, suspicious reimbursements, and invoice anomalies in real-time.', 'ðŸ›¡ï¸'],
                    ['AI Executive Dashboard', 'Ask questions in natural language and get instant business insights from your data.', 'ðŸ“Š'],
                    ['AI Freelancer Assistant', 'Smart invoice suggestions, revenue forecasting, and client risk assessment.', 'ðŸ¤–'],
                ] as [$title, $desc, $emoji])
                    <div class="rounded-xl border border-surface-border bg-surface-card p-6 hover:border-brand-500/30 hover:shadow-lg hover:shadow-brand-500/5 transition-all duration-300">
                        <span class="text-3xl mb-4 block">{{ $emoji }}</span>
                        <h3 class="font-display text-lg font-semibold text-white mb-2">{{ $title }}</h3>
                        <p class="text-slate-400 text-sm">{{ $desc }}</p>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-10">
                <x-frontend-base.button href="{{ route('frontend.ai') }}" variant="primary" color="brand" size="lg">Explore TimeNest AI</x-frontend-base.button>
            </div>
        </div>
    </section>

    {{-- Section 8: Stats Strip --}}
    <x-frontend-sections.stats-strip :stats="$stats" />

    {{-- Section 9: Solutions Teaser --}}
    <section class="py-20 bg-surface">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <x-frontend-sections.section-header title="Solutions for every operation" subtitle="Purpose-built solutions that map to your organizational needs." badge="Solutions" />
            <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-4">
                @foreach([
                    ['Workforce Management', 'Employees, attendance, leaves, shifts', 'workforce-management'],
                    ['Operations Management', 'Departments, teams, workflows, approvals', 'operations-management'],
                    ['Financial Operations', 'Invoices, payments, revenue tracking', 'financial-operations'],
                    ['Freelancer Management', 'Clients, leads, projects, tasks', 'freelancer-management'],
                    ['AI Operations', 'Intelligence for every workflow', 'ai-operations'],
                ] as [$title, $desc, $slug])
                    <a href="{{ route('frontend.solutions.show', $slug) }}" class="group rounded-xl border border-surface-border bg-surface-card p-5 hover:border-brand-500/30 transition-all">
                        <h3 class="font-display text-sm font-semibold text-white mb-1 group-hover:text-brand-400 transition-colors">{{ $title }}</h3>
                        <p class="text-slate-500 text-xs">{{ $desc }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Section 10: Industries --}}
    <section class="py-20 bg-surface-card/30">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <x-frontend-sections.section-header title="Built for every industry" subtitle="TimeNest adapts to the unique needs of your industry." badge="Industries" />
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach([
                    ['Startups', 'Scale your team operations from day one', 'startups'],
                    ['IT Companies', 'Manage distributed tech teams efficiently', 'it-companies'],
                    ['Agencies', 'Coordinate freelancers and creative teams', 'agencies'],
                    ['Consulting Firms', 'Track billable hours and client projects', 'consulting-firms'],
                    ['Manufacturing', 'Shift management and compliance tracking', 'manufacturing'],
                    ['Healthcare', 'Staff scheduling and credential management', 'healthcare'],
                    ['Retail', 'Multi-location workforce coordination', 'retail'],
                    ['Education', 'Faculty management and scheduling', 'education'],
                ] as [$title, $desc, $slug])
                    <a href="{{ route('frontend.industries.show', $slug) }}" class="group rounded-xl border border-surface-border bg-surface-card p-5 hover:border-brand-500/30 transition-all">
                        <h3 class="font-display text-sm font-semibold text-white mb-1 group-hover:text-brand-400 transition-colors">{{ $title }}</h3>
                        <p class="text-slate-500 text-xs">{{ $desc }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Section 12: ROI Calculator --}}
    <section class="py-20 bg-surface" x-data="{ employees: 50, hrSize: 3, avgSalary: 50000, get timeSaved() { return Math.round(this.employees * 0.5 + this.hrSize * 8) }, get moneySaved() { return Math.round((this.timeSaved * 12 * this.avgSalary) / (22 * 8 * 12)) }, get productivity() { return Math.min(Math.round(this.employees * 0.15 + this.hrSize * 2), 45) } }">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            <x-frontend-sections.section-header title="Calculate your ROI" subtitle="See how much time and money TimeNest can save your organization." badge="ROI Calculator" />
            <div class="rounded-xl border border-surface-border bg-surface-card p-8">
                <div class="grid md:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div>
                            <label class="text-sm text-slate-400 block mb-2">Number of Employees</label>
                            <input type="range" min="10" max="1000" x-model="employees" class="w-full accent-brand-500">
                            <p class="text-white font-display text-lg mt-1" x-text="employees + ' employees'"></p>
                        </div>
                        <div>
                            <label class="text-sm text-slate-400 block mb-2">HR Team Size</label>
                            <input type="range" min="1" max="20" x-model="hrSize" class="w-full accent-brand-500">
                            <p class="text-white font-display text-lg mt-1" x-text="hrSize + ' people'"></p>
                        </div>
                        <div>
                            <label class="text-sm text-slate-400 block mb-2">Average Monthly Salary (â‚¹)</label>
                            <input type="range" min="15000" max="200000" step="5000" x-model="avgSalary" class="w-full accent-brand-500">
                            <p class="text-white font-display text-lg mt-1" x-text="'â‚¹' + Number(avgSalary).toLocaleString()"></p>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div class="rounded-lg bg-surface p-6 border border-surface-border">
                            <p class="text-slate-400 text-sm mb-1">Time Saved per Month</p>
                            <p class="font-display text-3xl font-bold text-brand-400" x-text="timeSaved + ' hours'"></p>
                        </div>
                        <div class="rounded-lg bg-surface p-6 border border-surface-border">
                            <p class="text-slate-400 text-sm mb-1">Money Saved per Year</p>
                            <p class="font-display text-3xl font-bold text-green-400" x-text="'â‚¹' + Number(moneySaved).toLocaleString()"></p>
                        </div>
                        <div class="rounded-lg bg-surface p-6 border border-surface-border">
                            <p class="text-slate-400 text-sm mb-1">Productivity Improvement</p>
                            <p class="font-display text-3xl font-bold text-accent-400" x-text="productivity + '%'"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Section 13: Testimonials --}}
    <section class="py-20 bg-surface-card/30">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <x-frontend-sections.section-header title="What our users say" subtitle="Real feedback from teams using TimeNest every day." badge="Testimonials" />
            <div class="grid md:grid-cols-3 gap-6">
                @foreach($testimonials as $t)
                    <x-frontend-cards.testimonial-card :name="$t['name']" :role="$t['role']" :company="$t['company']" :content="$t['content']" :rating="$t['rating']" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- Section 14: Security Strip --}}
    <section class="py-12 bg-surface border-y border-surface-border">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                @foreach([['ðŸ”', 'JWT Authentication'], ['ðŸ”’', 'Data Encryption'], ['ðŸ“‹', 'Audit Logs'], ['ðŸŒ', 'GDPR Ready']] as [$icon, $label])
                    <div><span class="text-2xl block mb-2">{{ $icon }}</span><p class="text-slate-400 text-sm font-body">{{ $label }}</p></div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Section 16: FAQ --}}
    <section class="py-20 bg-surface">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <x-frontend-sections.section-header title="Frequently Asked Questions" subtitle="Everything you need to know about TimeNest." badge="FAQs" />
        </div>
        <x-frontend-sections.faq-block :faqs="$faqs" />
    </section>

    {{-- Section 17: Final CTA --}}
    <x-frontend-sections.cta-block
        headline="Stop stitching tools together."
        subheadline="One platform. Every workflow."
        primaryCtaText="Book Demo"
        primaryCtaUrl="{{ route('frontend.book-demo') }}"
        secondaryCtaText="Start Free"
        secondaryCtaUrl="/register"
    />
</x-frontend-layout.app>
