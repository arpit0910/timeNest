<x-frontend-layout.app metaTitle="Blog â€” TimeNest" metaDescription="Latest insights, tips, and updates from the TimeNest team.">
    <section class="relative pt-32 pb-20 bg-surface">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <x-frontend-sections.section-header title="Blog" subtitle="Insights on workforce management, freelancing, and AI." badge="Latest Posts" />
            <!-- PLACEHOLDER â€” replace with real content -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach([
                    ['Why Every Startup Needs an HR System from Day One', 'Most startups wait too long to implement HR processes. Here\'s why that\'s a costly mistake.', '2025-01-15', 'Workforce'],
                    ['The Rise of Freelance Workspaces', 'How collaborative freelance teams are changing the way agencies operate.', '2025-01-10', 'Freelancing'],
                    ['AI in HR: Beyond the Buzzword', 'How machine learning is actually being used in workforce analytics today.', '2025-01-05', 'AI'],
                ] as [$title, $excerpt, $date, $category])
                    <div class="rounded-xl border border-surface-border bg-surface-card overflow-hidden hover:border-brand-500/30 transition-all">
                        <div class="h-40 bg-gradient-to-br from-surface to-surface-elevated"></div>
                        <div class="p-6">
                            <x-frontend-base.badge variant="brand" class="mb-3">{{ $category }}</x-frontend-base.badge>
                            <h3 class="font-display text-base font-semibold text-content-strong mb-2">{{ $title }}</h3>
                            <p class="text-content-muted text-sm mb-3">{{ $excerpt }}</p>
                            <p class="text-content-light text-xs">{{ $date }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-frontend-layout.app>
