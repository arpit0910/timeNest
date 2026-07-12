@php
$competitors = [
    'timenest-vs-zoho-people' => ['name' => 'Zoho People', 'verdict' => 'TimeNest offers a unified Work OS with built-in AI and freelancer tools that Zoho People lacks.'],
    'timenest-vs-keka' => ['name' => 'Keka', 'verdict' => 'TimeNest goes beyond HR with freelancer management, AI analytics, and collaborative workspaces.'],
    'timenest-vs-greythr' => ['name' => 'greytHR', 'verdict' => 'TimeNest provides modern AI-powered features and freelancer tools that greytHR doesn\'t offer.'],
    'timenest-vs-bamboohr' => ['name' => 'BambooHR', 'verdict' => 'TimeNest is built for the Indian market with local pricing, compliance, and freelancer support.'],
    'timenest-vs-excel' => ['name' => 'Excel / Spreadsheets', 'verdict' => 'Stop managing your workforce in spreadsheets. TimeNest automates everything Excel can\'t.'],
    'timenest-vs-notion' => ['name' => 'Notion', 'verdict' => 'Notion is great for docs, but TimeNest is purpose-built for workforce and freelancer management.'],
];
$data = $competitors[$slug] ?? abort(404);
@endphp
<x-frontend-layout.app :metaTitle="'TimeNest vs ' . $data['name'] . ' â€” Comparison'" :metaDescription="$data['verdict']">
    <section class="relative pt-32 pb-20 bg-surface">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            <h1 class="font-display text-4xl lg:text-5xl font-bold text-content-strong mb-4">TimeNest vs {{ $data['name'] }}</h1>
            <p class="text-content-muted text-lg mb-12">{{ $data['verdict'] }}</p>

            <div class="rounded-xl border border-surface-border overflow-hidden mb-12">
                <table class="w-full text-sm">
                    <thead><tr class="bg-surface-card"><th class="p-4 text-left text-content-muted">Feature</th><th class="p-4 text-center text-brand-400">TimeNest</th><th class="p-4 text-center text-content-muted">{{ $data['name'] }}</th></tr></thead>
                    <tbody>
                        @foreach([
                            ['Employee Management', true, true], ['Attendance & Leaves', true, true],
                            ['Freelancer Tools', true, false], ['AI Analytics', true, false],
                            ['Collaborative Workspace', true, false], ['Custom Workflows', true, true],
                            ['Built-in CRM', true, false], ['Indian Market Focus', true, false],
                        ] as [$feature, $tn, $comp])
                            <tr class="border-t border-surface-border">
                                <td class="p-4 text-content-strong">{{ $feature }}</td>
                                <td class="p-4 text-center">@if($tn)<svg class="w-5 h-5 text-brand-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>@else<span class="text-slate-600">â€”</span>@endif</td>
                                <td class="p-4 text-center">@if($comp)<svg class="w-5 h-5 text-content-light mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>@else<span class="text-slate-600">â€”</span>@endif</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <x-frontend-sections.cta-block headline="Make the switch to TimeNest" primaryCtaText="Book Demo" primaryCtaUrl="{{ route('frontend.book-demo') }}" secondaryCtaText="Start Free" secondaryCtaUrl="/register" />
</x-frontend-layout.app>
