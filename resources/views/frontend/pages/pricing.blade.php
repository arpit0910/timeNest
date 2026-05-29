<x-frontend-layout.app metaTitle="Pricing â€” TimeNest" metaDescription="Simple pricing for freelancers and organizations. Start free, upgrade when you need more power.">
    <section class="relative pt-32 pb-20 bg-surface">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <x-frontend-sections.section-header title="Simple, transparent pricing" subtitle="Start free as a freelancer. Scale to Pro or Organization when you're ready." badge="Pricing" />

            <div class="grid md:grid-cols-3 gap-6 max-w-5xl mx-auto">
                <x-frontend-cards.pricing-card name="Free" price="â‚¹0" period="" description="For individual freelancers getting started." :features="['Client Management', 'Invoice Creation', 'Task & Project Management', 'Revenue Tracking', 'Document Storage', 'Basic Reports']" ctaText="Get Started" ctaUrl="/register" />
                <x-frontend-cards.pricing-card name="Pro" price="â‚¹499" period="/mo" description="For freelancers who need AI and workspace features." :features="['Everything in Free', 'AI Revenue Forecasting', 'AI Work Analysis', 'Advanced Insights', 'AI Assistant', 'Freelance Workspace', 'Priority Support']" ctaText="Upgrade to Pro" ctaUrl="/register" :highlighted="true" badge="Most Popular" />
                <x-frontend-cards.pricing-card name="Organization" price="Custom" period="/seat" description="For teams and companies of all sizes." :features="['Employee Management', 'Attendance & Leaves', 'Shift Management', 'Departments & Teams', 'Workflows & Approvals', 'AI Analytics', 'Dedicated Support', 'Custom Integrations']" ctaText="Book Demo" ctaUrl="{{ route('frontend.book-demo') }}" />
            </div>

            {{-- Feature Comparison --}}
            <div class="mt-20 max-w-5xl mx-auto">
                <h3 class="font-display text-2xl font-bold text-white text-center mb-8">Feature Comparison</h3>
                <div class="rounded-xl border border-surface-border overflow-hidden">
                    <table class="w-full text-sm">
                        <thead><tr class="bg-surface-card"><th class="text-left p-4 text-slate-400 font-body">Feature</th><th class="p-4 text-slate-400 font-body">Free</th><th class="p-4 text-brand-400 font-body">Pro</th><th class="p-4 text-slate-400 font-body">Organization</th></tr></thead>
                        <tbody>
                            @foreach([
                                ['Client Management', true, true, true],
                                ['Invoices & Payments', true, true, true],
                                ['Tasks & Projects', true, true, true],
                                ['AI Features', false, true, true],
                                ['Freelance Workspace', false, true, false],
                                ['Employee Management', false, false, true],
                                ['Attendance & Leaves', false, false, true],
                                ['Shift Management', false, false, true],
                                ['Custom Workflows', false, false, true],
                                ['Dedicated Support', false, true, true],
                            ] as [$feature, $free, $pro, $org])
                                <tr class="border-t border-surface-border">
                                    <td class="p-4 text-white">{{ $feature }}</td>
                                    @foreach([$free, $pro, $org] as $has)
                                        <td class="p-4 text-center">
                                            @if($has)<svg class="w-5 h-5 text-brand-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>@else<span class="text-slate-600">â€”</span>@endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <x-frontend-sections.cta-block headline="Ready to get started?" subheadline="Join thousands of teams already using TimeNest." primaryCtaText="Book Demo" primaryCtaUrl="{{ route('frontend.book-demo') }}" secondaryCtaText="Start Free" secondaryCtaUrl="/register" />
</x-frontend-layout.app>
