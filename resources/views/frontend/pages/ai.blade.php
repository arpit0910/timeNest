<x-frontend-layout.app metaTitle="TimeNest AI â€” Intelligence Built Into Every Workflow" metaDescription="Explore TimeNest's AI capabilities: workforce analytics, fraud detection, executive dashboards, and freelancer assistance.">
    {{-- Hero --}}
    <section class="relative min-h-[60vh] flex items-center overflow-hidden">
        <div class="absolute inset-0 bg-surface hero-grid-bg"></div>
        <div class="absolute top-1/3 left-1/2 -translate-x-1/2 w-[500px] h-[500px] bg-brand-500/10 rounded-full blur-[128px] animate-glow"></div>
        <div class="relative z-10 max-w-4xl mx-auto px-6 lg:px-8 py-32 text-center">
            <x-frontend-base.badge variant="brand" class="mb-6">TimeNest AI</x-frontend-base.badge>
            <h1 class="font-display text-5xl lg:text-6xl font-bold text-white mb-6">Intelligence built into<br><span class="text-gradient">every workflow</span></h1>
            <p class="text-slate-400 text-lg max-w-2xl mx-auto">From detecting attendance fraud to forecasting freelancer revenue, TimeNest AI works silently in the background to surface insights that matter.</p>
        </div>
    </section>

    @foreach([
        ['AI Workforce Analyst', 'Detect patterns humans miss', ['Attendance anomaly detection â€” spot irregular clock-in patterns', 'Leave abuse detection â€” identify suspicious leave clusters', 'Overtime anomaly alerts â€” flag unusual overtime trends', 'Productivity insights â€” team and individual performance metrics'], 'ðŸ”'],
        ['AI Fraud Detection', 'Trust, but verify â€” automatically', ['Fake attendance detection â€” GPS and behavioral analysis', 'Suspicious activity monitoring â€” unusual system access patterns', 'Invoice anomaly detection â€” flag billing irregularities', 'Reimbursement fraud alerts â€” catch duplicate or inflated claims'], 'ðŸ›¡ï¸'],
        ['AI Executive Dashboard', 'Ask your data anything', ['Natural language queries â€” "Show me attendance trends for Q1"', 'Instant insights â€” no SQL or report building needed', 'Smart suggestions â€” proactive alerts based on data patterns', 'Example queries shown as interactive chips'], 'ðŸ“Š'],
        ['AI Freelancer Assistant', 'Your AI business partner', ['Smart invoice suggestions based on project scope', 'Revenue forecasting with ML-powered predictions', 'Client risk assessment â€” payment reliability scoring', 'Payment prediction â€” when will invoices get paid?'], 'ðŸ¤–'],
    ] as $i => [$title, $subtitle, $features, $emoji])
        <section class="py-20 {{ $i % 2 === 0 ? 'bg-surface' : 'bg-surface-card/30' }}">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="grid md:grid-cols-2 gap-12 items-center {{ $i % 2 !== 0 ? 'md:flex-row-reverse' : '' }}">
                    <div class="{{ $i % 2 !== 0 ? 'md:order-2' : '' }}">
                        <span class="text-4xl mb-4 block">{{ $emoji }}</span>
                        <h2 class="font-display text-3xl font-bold text-white mb-3">{{ $title }}</h2>
                        <p class="text-slate-400 text-lg mb-6">{{ $subtitle }}</p>
                        <ul class="space-y-3">
                            @foreach($features as $f)
                                <li class="flex items-start gap-3 text-sm text-slate-300">
                                    <svg class="w-5 h-5 text-brand-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    {{ $f }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="{{ $i % 2 !== 0 ? 'md:order-1' : '' }} rounded-xl border border-surface-border bg-surface-card p-8 h-64 flex items-center justify-center">
                        <span class="text-7xl">{{ $emoji }}</span>
                    </div>
                </div>
            </div>
        </section>
    @endforeach

    {{-- Future AI Vision --}}
    <section class="py-20 bg-surface">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <x-frontend-sections.section-header title="Future AI Vision" subtitle="What we're building next with artificial intelligence." badge="Coming Soon" />
            <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-4">
                @foreach(['AI Agents', 'Automation Workflows', 'AI Operations Manager', 'AI Finance Assistant', 'AI HR Assistant'] as $item)
                    <div class="rounded-xl border border-surface-border bg-surface-card p-5 relative">
                        <x-frontend-base.badge variant="warning" class="mb-3">Coming Soon</x-frontend-base.badge>
                        <h3 class="font-display text-sm font-semibold text-white">{{ $item }}</h3>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <x-frontend-sections.cta-block headline="Get Early Access to AI Features" subheadline="Be among the first to experience intelligent workforce management." primaryCtaText="Book Demo" primaryCtaUrl="{{ route('frontend.book-demo') }}" secondaryCtaText="Start Free" secondaryCtaUrl="/register" />
</x-frontend-layout.app>
