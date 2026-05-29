<x-frontend-layout.app metaTitle="Product Roadmap â€” TimeNest" metaDescription="See what we've built, what we're working on, and where TimeNest is headed.">
    <section class="relative pt-32 pb-20 bg-surface">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <x-frontend-sections.section-header title="Product Roadmap" subtitle="Transparency in what we've shipped, what we're building, and what's coming next." badge="Roadmap" />

            <div class="grid md:grid-cols-4 gap-6">
                @foreach([
                    ['Live', 'bg-green-500', [
                        ['Employee Management', 'HR'], ['Attendance Tracking', 'HR'], ['Leave Management', 'HR'],
                        ['Shift Scheduling', 'HR'], ['Departments & Teams', 'Operations'], ['Roles & Permissions', 'Operations'],
                        ['Client Management', 'Finance'], ['Invoice Management', 'Finance'], ['Task Management', 'Operations'],
                    ]],
                    ['In Progress', 'bg-amber-500', [
                        ['AI Workforce Analyst', 'AI'], ['AI Fraud Detection', 'AI'], ['Advanced Analytics', 'Operations'],
                        ['Freelance Workspace', 'Operations'],
                    ]],
                    ['Planned', 'bg-accent-500', [
                        ['Payroll Module', 'Finance'], ['Recruitment ATS', 'HR'], ['Performance Reviews', 'HR'],
                        ['Asset Management', 'Operations'], ['CRM Module', 'Operations'],
                    ]],
                    ['Future Vision', 'bg-slate-500', [
                        ['AI Agents', 'AI'], ['Workflow Automation', 'AI'], ['AI Operations Manager', 'AI'],
                        ['Procurement', 'Operations'], ['Vendor Management', 'Operations'],
                    ]],
                ] as [$stage, $color, $items])
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <span class="w-2 h-2 rounded-full {{ $color }}"></span>
                            <h3 class="font-display text-lg font-semibold text-content-strong">{{ $stage }}</h3>
                            <span class="text-content-light text-xs">({{ count($items) }})</span>
                        </div>
                        <div class="space-y-3">
                            @foreach($items as [$title, $category])
                                <div class="rounded-lg border border-surface-border bg-surface-card p-4">
                                    <h4 class="font-body text-sm font-medium text-content-strong mb-1">{{ $title }}</h4>
                                    <x-frontend-base.badge variant="default" size="xs">{{ $category }}</x-frontend-base.badge>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-frontend-layout.app>
