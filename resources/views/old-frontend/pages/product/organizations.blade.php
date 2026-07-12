<x-frontend-layout.app metaTitle="TimeNest for Organizations â€” Complete Workforce Management" metaDescription="Manage employees, attendance, leaves, shifts, departments, and more with TimeNest for Organizations.">
    <section class="relative pt-32 pb-20 bg-surface">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center mb-16">
                <x-frontend-base.badge color="teal" class="mb-4">For Organizations</x-frontend-base.badge>
                <h1 class="font-display text-4xl lg:text-5xl font-bold text-content-strong mb-4">Complete workforce management</h1>
                <p class="text-content-muted text-lg">From startups to enterprise â€” manage your entire workforce, operations, and compliance in one platform.</p>
                <div class="flex justify-center gap-4 mt-8">
                    <x-frontend-base.button href="{{ route('frontend.book-demo') }}" variant="primary" color="brand" size="lg">Book a Demo</x-frontend-base.button>
                    <x-frontend-base.button href="{{ route('frontend.pricing') }}" variant="outline" color="white" size="lg">View Pricing</x-frontend-base.button>
                </div>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach([
                    ['ðŸ‘¤', 'Employee Management', 'Complete employee lifecycle from onboarding to offboarding.'],
                    ['â°', 'Attendance', 'GPS-enabled clock-in/out with automated reports.'],
                    ['ðŸ–ï¸', 'Leave Management', 'Configurable policies, approvals, and balance tracking.'],
                    ['ðŸ”„', 'Shift Scheduling', 'Rotating shifts, swap requests, overtime tracking.'],
                    ['ðŸ¢', 'Departments', 'Hierarchical org structure with teams.'],
                    ['âœ…', 'Workflows', 'Custom approval chains for all operations.'],
                    ['ðŸ“Š', 'Analytics', 'Real-time dashboards and reports.'],
                    ['ðŸ”', 'Roles & Permissions', 'Granular RBAC for security.'],
                    ['ðŸ¤–', 'AI Features', 'Workforce analyst, fraud detection, executive dashboard.'],
                ] as [$emoji, $title, $desc])
                    <div class="rounded-xl border border-surface-border bg-surface-card p-6">
                        <span class="text-2xl mb-3 block">{{ $emoji }}</span>
                        <h3 class="font-display text-base font-semibold text-content-strong mb-1">{{ $title }}</h3>
                        <p class="text-content-muted text-sm">{{ $desc }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <x-frontend-sections.cta-block headline="Ready to transform your workforce operations?" primaryCtaText="Book Demo" primaryCtaUrl="{{ route('frontend.book-demo') }}" />
</x-frontend-layout.app>
