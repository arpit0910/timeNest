<x-frontend-layout.app metaTitle="Freelance Workspace â€” Collaborative Team Management" metaDescription="Create a collaborative workspace for your freelance team. Shared projects, invoices, and analytics.">
    <section class="relative pt-32 pb-20 bg-surface">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center mb-16">
                <x-frontend-base.badge color="orange" variant="pro" class="mb-4">Requires Pro Subscription</x-frontend-base.badge>
                <h1 class="font-display text-4xl lg:text-5xl font-bold text-content-strong mb-4">Freelance Workspace</h1>
                <p class="text-content-muted text-lg">Not an organization. Not a solo freelancer. A collaborative workspace for freelance teams, agencies, and creative studios.</p>
                <div class="flex justify-center gap-4 mt-8">
                    <x-frontend-base.button href="{{ route('frontend.pricing') }}" variant="primary" color="brand" size="lg">Upgrade to Pro</x-frontend-base.button>
                </div>
            </div>

            {{-- Comparison Table --}}
            <div class="max-w-4xl mx-auto rounded-xl border border-surface-border overflow-hidden mb-16">
                <table class="w-full text-sm">
                    <thead><tr class="bg-surface-card"><th class="p-4 text-left text-content-muted">Aspect</th><th class="p-4 text-center text-content-muted">Freelancer</th><th class="p-4 text-center text-brand-400">Workspace</th><th class="p-4 text-center text-content-muted">Organization</th></tr></thead>
                    <tbody>
                        @foreach([
                            ['Manages', 'Self', 'Collaborators', 'Employees'],
                            ['Team Size', 'Solo', 'Small Teams', 'Any Size'],
                            ['Projects', 'Personal', 'Shared', 'Departmental'],
                            ['Invoicing', 'Individual', 'Shared', 'N/A'],
                            ['HR Features', 'No', 'No', 'Full Suite'],
                            ['Pricing', 'Free / Pro', 'Pro Required', 'Custom'],
                        ] as [$aspect, $freelancer, $workspace, $org])
                            <tr class="border-t border-surface-border"><td class="p-4 text-content-strong">{{ $aspect }}</td><td class="p-4 text-center text-content-muted">{{ $freelancer }}</td><td class="p-4 text-center text-brand-400">{{ $workspace }}</td><td class="p-4 text-center text-content-muted">{{ $org }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <x-frontend-sections.cta-block headline="Build your freelance team today" primaryCtaText="Upgrade to Pro" primaryCtaUrl="{{ route('frontend.pricing') }}" />
</x-frontend-layout.app>
