@php
$industries = [
    'startups' => ['title' => 'Startups', 'tagline' => 'Scale your team operations from day one', 'challenges' => ['Rapid hiring without proper HR systems', 'No structured attendance or leave policies', 'Manual processes eating into growth time'], 'benefits' => ['Set up HR infrastructure in minutes', 'Automated attendance and leave from day one', 'Scale from 5 to 500 employees seamlessly']],
    'it-companies' => ['title' => 'IT Companies', 'tagline' => 'Manage distributed tech teams efficiently', 'challenges' => ['Remote and hybrid workforce tracking', 'Complex shift schedules across time zones', 'Developer productivity measurement'], 'benefits' => ['GPS and remote attendance tracking', 'Flexible shift management', 'AI-powered productivity insights']],
    'agencies' => ['title' => 'Agencies', 'tagline' => 'Coordinate freelancers and creative teams', 'challenges' => ['Managing mix of employees and freelancers', 'Client billing and project tracking chaos', 'No unified view of team capacity'], 'benefits' => ['Freelance Workspace for collaborators', 'Integrated invoicing and billing', 'Team capacity and analytics dashboard']],
    'consulting-firms' => ['title' => 'Consulting Firms', 'tagline' => 'Track billable hours and client projects', 'challenges' => ['Tracking consultant utilization rates', 'Complex client billing structures', 'Multi-project resource allocation'], 'benefits' => ['Accurate time tracking per project', 'Automated client invoicing', 'Resource allocation analytics']],
    'manufacturing' => ['title' => 'Manufacturing', 'tagline' => 'Shift management and compliance tracking', 'challenges' => ['Multiple shift management across plants', 'Overtime tracking and compliance', 'Large workforce attendance management'], 'benefits' => ['Automated shift rotations', 'Real-time overtime alerts', 'Bulk attendance management']],
    'healthcare' => ['title' => 'Healthcare', 'tagline' => 'Staff scheduling and credential management', 'challenges' => ['24/7 staff scheduling complexity', 'Compliance with labor regulations', 'High turnover and onboarding'], 'benefits' => ['Round-the-clock shift management', 'Compliance audit trails', 'Fast onboarding workflows']],
    'retail' => ['title' => 'Retail', 'tagline' => 'Multi-location workforce coordination', 'challenges' => ['Managing staff across multiple locations', 'Seasonal hiring and scheduling', 'POS integration requirements'], 'benefits' => ['Multi-location management', 'Flexible seasonal scheduling', 'API-ready for integrations']],
    'education' => ['title' => 'Education', 'tagline' => 'Faculty management and scheduling', 'challenges' => ['Complex academic schedules', 'Faculty leave management during terms', 'Part-time and visiting faculty tracking'], 'benefits' => ['Academic calendar integration', 'Smart leave policy enforcement', 'Flexible faculty management']],
];
$data = $industries[$slug] ?? abort(404);
@endphp
<x-frontend-layout.app :metaTitle="$data['title'] . ' â€” TimeNest for ' . $data['title']" :metaDescription="$data['tagline']">
    <section class="relative pt-32 pb-20 bg-surface">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            <x-frontend-base.badge variant="brand" class="mb-4">Industries</x-frontend-base.badge>
            <h1 class="font-display text-4xl lg:text-5xl font-bold text-white mb-4">TimeNest for {{ $data['title'] }}</h1>
            <p class="text-slate-400 text-lg mb-12">{{ $data['tagline'] }}</p>

            <div class="grid md:grid-cols-2 gap-8 mb-16">
                <div>
                    <h2 class="font-display text-xl font-semibold text-red-400 mb-4">Industry Challenges</h2>
                    <ul class="space-y-3">@foreach($data['challenges'] as $c)<li class="flex items-start gap-3 text-slate-300 text-sm"><span class="text-red-400 mt-0.5">âœ•</span>{{ $c }}</li>@endforeach</ul>
                </div>
                <div>
                    <h2 class="font-display text-xl font-semibold text-brand-400 mb-4">TimeNest Solution</h2>
                    <ul class="space-y-3">@foreach($data['benefits'] as $b)<li class="flex items-start gap-3 text-slate-300 text-sm"><svg class="w-4 h-4 text-brand-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>{{ $b }}</li>@endforeach</ul>
                </div>
            </div>

            <!-- PLACEHOLDER â€” replace with real content -->
            <div class="rounded-xl border border-dashed border-surface-border bg-surface-card/50 p-8 text-center">
                <p class="text-slate-500 text-sm">ðŸ“– Case study coming soon</p>
                <x-frontend-base.button href="{{ route('frontend.contact') }}" variant="outline" color="white" size="sm" class="mt-4">Be Our First Success Story</x-frontend-base.button>
            </div>
        </div>
    </section>
    <x-frontend-sections.cta-block headline="See how TimeNest works for {{ $data['title'] }}" primaryCtaText="Book Demo" primaryCtaUrl="{{ route('frontend.book-demo') }}" />
</x-frontend-layout.app>
