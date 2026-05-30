<x-frontend-layout.app :metaTitle="ucwords(str_replace('-', ' ', $slug)) . ' â€” TimeNest Docs'">
    <section class="relative pt-32 pb-20 bg-surface">
        <div class="max-w-3xl mx-auto px-6 lg:px-8">
            <x-frontend-base.badge color="teal" class="mb-4">Documentation</x-frontend-base.badge>
            <h1 class="font-display text-3xl font-bold text-content-strong mb-8">{{ ucwords(str_replace('-', ' ', $slug)) }}</h1>
            <!-- PLACEHOLDER â€” replace with real content -->
            <p class="text-content-muted">This documentation article will be loaded from the database.</p>
        </div>
    </section>
</x-frontend-layout.app>
