@php
$solutions = [
    'workforce-management' => ['title' => 'Workforce Management', 'desc' => 'Complete employee lifecycle management from hiring to retirement.', 'features' => ['Employee Profiles & Documents', 'Attendance & Time Tracking', 'Leave Management & Policies', 'Shift Scheduling & Overtime']],
    'operations-management' => ['title' => 'Operations Management', 'desc' => 'Streamline departments, teams, workflows, and approval processes.', 'features' => ['Department Hierarchy', 'Team Management', 'Custom Workflows', 'Multi-level Approvals']],
    'financial-operations' => ['title' => 'Financial Operations', 'desc' => 'Manage invoices, payments, revenue tracking, and financial analytics.', 'features' => ['Invoice Generation', 'Payment Tracking', 'Revenue Analytics', 'Financial Reports']],
    'freelancer-management' => ['title' => 'Freelancer Management', 'desc' => 'Everything a freelancer needs to run their business efficiently.', 'features' => ['Client & Lead CRM', 'Project Management', 'Task Tracking', 'Document Management']],
    'ai-operations' => ['title' => 'AI Operations', 'desc' => 'Intelligence layer that works across all modules automatically.', 'features' => ['Workforce Analytics', 'Fraud Detection', 'Executive Dashboard', 'Revenue Forecasting']],
];
$data = $solutions[$slug] ?? abort(404);
@endphp
<x-frontend-layout.app :metaTitle="$data['title'] . ' â€” TimeNest Solutions'" :metaDescription="$data['desc']">
    <section class="relative pt-32 pb-20 bg-surface">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            <x-frontend-base.badge variant="brand" class="mb-4">Solutions</x-frontend-base.badge>
            <h1 class="font-display text-4xl lg:text-5xl font-bold text-white mb-4">{{ $data['title'] }}</h1>
            <p class="text-slate-400 text-lg mb-12">{{ $data['desc'] }}</p>
            <div class="grid sm:grid-cols-2 gap-6">
                @foreach($data['features'] as $f)
                    <div class="rounded-xl border border-surface-border bg-surface-card p-6">
                        <svg class="w-5 h-5 text-brand-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <h3 class="font-display text-base font-semibold text-white">{{ $f }}</h3>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <x-frontend-sections.cta-block headline="See {{ $data['title'] }} in action" primaryCtaText="Book Demo" primaryCtaUrl="{{ route('frontend.book-demo') }}" secondaryCtaText="Start Free" secondaryCtaUrl="/register" />
</x-frontend-layout.app>
