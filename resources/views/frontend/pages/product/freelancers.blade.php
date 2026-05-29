<x-frontend-layout.app metaTitle="TimeNest for Freelancers â€” Manage Your Business Free" metaDescription="Free tools for freelancers: clients, invoices, tasks, projects, and revenue tracking. Start free, upgrade when you need AI.">
    <section class="relative pt-32 pb-20 bg-surface">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center mb-20">
                <div>
                    <x-frontend-base.badge variant="accent" class="mb-4">For Freelancers</x-frontend-base.badge>
                    <h1 class="font-display text-4xl lg:text-5xl font-bold text-white mb-4">Built for independent professionals</h1>
                    <p class="text-slate-400 text-lg mb-6">Manage clients, invoices, tasks, and revenue â€” all in one place. Core features are completely free.</p>
                    <x-frontend-base.button href="/register" variant="primary" color="brand" size="lg">Start Free â€” No Card Required</x-frontend-base.button>
                </div>
                <div class="rounded-xl border border-surface-border bg-surface-card p-6">
                    <div class="space-y-3">
                        @foreach([
                            ['Core (Free)', ['Client Management', 'Invoice Creation', 'Task & Projects', 'Revenue Tracking', 'Documents & Notes'], 'brand'],
                            ['Pro Features', ['AI Revenue Forecasting', 'AI Work Analysis', 'Advanced Insights', 'AI Assistant'], 'amber'],
                        ] as [$tier, $features, $color])
                            <div class="rounded-lg bg-surface p-4 border border-surface-border">
                                <h3 class="font-display text-sm font-semibold text-white mb-2 flex items-center gap-2">{{ $tier }} @if($color === 'amber')<x-frontend-base.badge variant="pro">PRO</x-frontend-base.badge>@endif</h3>
                                <ul class="space-y-1">@foreach($features as $f)<li class="text-slate-400 text-xs flex items-center gap-2"><svg class="w-3 h-3 text-{{ $color }}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>{{ $f }}</li>@endforeach</ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <x-frontend-sections.cta-block headline="Start free, upgrade when you need more power." primaryCtaText="Get Started Free" primaryCtaUrl="/register" />
</x-frontend-layout.app>
