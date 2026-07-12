<x-frontend-layout.app metaTitle="Changelog â€” TimeNest">
    <section class="relative pt-32 pb-20 bg-surface">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            <x-frontend-sections.section-header title="Changelog" subtitle="Full development history of TimeNest." badge="History" />
            <!-- PLACEHOLDER â€” replace with real content -->
            <div class="space-y-4">
                @foreach([
                    ['2025-01-15', 'Added AI Workforce Analyst beta'],
                    ['2025-01-10', 'Freelancer invoice management improvements'],
                    ['2025-01-05', 'Shift scheduling module launched'],
                    ['2024-12-20', 'Leave management system overhaul'],
                    ['2024-12-15', 'Initial employee management release'],
                ] as [$date, $entry])
                    <div class="flex gap-4 items-start"><span class="text-content-light text-xs font-mono shrink-0 mt-1 w-24">{{ $date }}</span><p class="text-content text-sm">{{ $entry }}</p></div>
                @endforeach
            </div>
        </div>
    </section>
</x-frontend-layout.app>
