<x-frontend-layout.app metaTitle="Features â€” TimeNest" metaDescription="Explore all TimeNest features: employee management, attendance, leaves, shifts, analytics, AI, and more.">
    <section class="relative pt-32 pb-20 bg-surface">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <x-frontend-sections.section-header title="Every feature you need" subtitle="A complete suite of modules for workforce management, freelancer operations, and intelligent analytics." badge="Features" />
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach([
                    ['ðŸ‘¤', 'Employee Management', 'Add, organize, and manage your entire workforce with detailed profiles, documents, and history.'],
                    ['â°', 'Attendance Tracking', 'Real-time clock-in/out with GPS support, biometric integration ready, and automated reports.'],
                    ['ðŸ–ï¸', 'Leave Management', 'Configurable leave policies, automated approvals, balance tracking, and calendar integration.'],
                    ['ðŸ”„', 'Shift Scheduling', 'Create rotating shifts, assign employees, manage swap requests, and track overtime.'],
                    ['ðŸ¢', 'Departments & Teams', 'Hierarchical organization structure with department heads and team leads.'],
                    ['âœ…', 'Workflows & Approvals', 'Custom multi-level approval chains for leaves, expenses, and operational requests.'],
                    ['ðŸ“Š', 'Analytics & Reports', 'Real-time dashboards, exportable reports, and trend analysis across all modules.'],
                    ['ðŸ”', 'Roles & Permissions', 'Granular RBAC with customizable roles, scopes, and permission groups.'],
                    ['ðŸ“', 'Audit Logs', 'Complete activity trail with user, timestamp, IP, and action details.'],
                    ['ðŸ’¼', 'Client Management', 'CRM for freelancers â€” manage leads, clients, and relationships.'],
                    ['ðŸ§¾', 'Invoice Management', 'Create, send, track invoices with payment status and reminders.'],
                    ['ðŸ“‹', 'Task & Project Management', 'Organize work with tasks, projects, milestones, and deadlines.'],
                ] as [$emoji, $title, $desc])
                    <div class="rounded-xl border border-surface-border bg-surface-card p-6 hover:border-brand-500/30 transition-all">
                        <span class="text-2xl mb-3 block">{{ $emoji }}</span>
                        <h3 class="font-display text-lg font-semibold text-content-strong mb-2">{{ $title }}</h3>
                        <p class="text-content-muted text-sm">{{ $desc }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <x-frontend-sections.cta-block headline="See all features in action" primaryCtaText="Book Demo" primaryCtaUrl="{{ route('frontend.book-demo') }}" secondaryCtaText="Start Free" secondaryCtaUrl="/register" />
</x-frontend-layout.app>
