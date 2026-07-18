<x-frontend-layout.app 
    metaTitle="Solution: {{ ucwords(str_replace('-', ' ', $slug)) }} — TimeNest" 
    metaDescription="Explore our comprehensive {{ str_replace('-', ' ', $slug) }} solution."
>
    {{-- Hero Section --}}
    <section class="pt-32 pb-20 lg:pt-48 lg:pb-32 bg-surface-50 relative overflow-hidden border-b border-surface-border">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Ik0zNiA0MmwxMC0xMGw0IDQgMTItMTJWMTJIMTB2MTZMMjIgMTZsMTAgMTB6IiBmaWxsPSIjMDAwMDAwIiBmaWxsLW9wYWNpdHk9IjAuMDIiLz48L2c+PC9zdmc+')] opacity-50"></div>
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10 text-center">
            <x-frontend-base.badge color="indigo" class="mb-6">Enterprise Solution</x-frontend-base.badge>
            <h1 class="font-display text-5xl lg:text-7xl font-bold text-content-strong tracking-tight mb-8">{{ ucwords(str_replace('-', ' ', $slug)) }}</h1>
            <p class="text-xl text-content-muted max-w-3xl mx-auto mb-10">Streamline your entire {{ str_replace('-', ' ', $slug) }} workflow with our integrated suite of tools designed specifically for modern, agile teams.</p>
            <div class="flex justify-center gap-4">
                <x-frontend-base.button href="/register" variant="primary" size="lg">Start Free Trial</x-frontend-base.button>
                <x-frontend-base.button href="{{ route('frontend.book-demo') }}" variant="outline" size="lg">Contact Sales</x-frontend-base.button>
            </div>
        </div>
    </section>

    {{-- Value Proposition --}}
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-12">
                @foreach([
                    ['Centralized Data', 'Eliminate data silos. Everything from employee records to financial invoices lives in one unified database, ensuring single-source-of-truth accuracy.'],
                    ['Automated Workflows', 'Stop manual data entry. Our platform automatically routes approvals, generates reports, and flags anomalies before they become problems.'],
                    ['Actionable Intelligence', 'Make better decisions with AI-powered dashboards that translate complex datasets into clear, readable insights for your executive team.']
                ] as [$title, $desc])
                    <div class="bg-surface-50 p-8 rounded-2xl border border-surface-border shadow-sm">
                        <div class="w-12 h-12 rounded-xl bg-brand-50 border border-brand-100 text-brand-600 flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <h3 class="font-display text-xl font-bold text-content-strong mb-3">{{ $title }}</h3>
                        <p class="text-content-muted leading-relaxed">{{ $desc }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Interactive Element --}}
    <section class="py-24 bg-brand-900 overflow-hidden relative">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center text-white relative z-10">
            <h2 class="font-display text-4xl font-bold mb-16">The engine powering your operations</h2>
            <div class="max-w-md mx-auto">
                <x-frontend-sections.gear-animation class="shadow-2xl shadow-brand-500/20" />
            </div>
        </div>
    </section>

    {{-- Deep Dive --}}
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="font-display text-3xl font-bold text-content-strong mb-6">Built for scale. Designed for humans.</h2>
                    <p class="text-lg text-content-muted mb-8 leading-relaxed">Most enterprise software requires months of training and deployment. We built TimeNest to be incredibly powerful yet instantly intuitive. Whether you have 50 employees or 5,000, adoption is seamless.</p>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3"><svg class="w-6 h-6 text-brand-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> <span class="text-content-strong font-medium">SOC2 Type II Certified Security</span></li>
                        <li class="flex items-start gap-3"><svg class="w-6 h-6 text-brand-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> <span class="text-content-strong font-medium">99.99% Guaranteed Uptime SLA</span></li>
                        <li class="flex items-start gap-3"><svg class="w-6 h-6 text-brand-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> <span class="text-content-strong font-medium">24/7 Dedicated Account Manager</span></li>
                    </ul>
                </div>
                <div class="bg-surface-50 rounded-2xl p-4 border border-surface-border shadow-xl">
                    <img src="/images/mockups/hero-dashboard.png" alt="Dashboard" class="rounded-xl w-full border border-surface-border/50">
                </div>
            </div>
        </div>
    </section>
</x-frontend-layout.app>


