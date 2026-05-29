<x-frontend-layout.app metaTitle="{{ ucwords(str_replace('-', ' ', $slug)) }} â€” TimeNest Blog">
    <section class="relative pt-32 pb-20 bg-surface">
        <div class="max-w-3xl mx-auto px-6 lg:px-8">
            <!-- PLACEHOLDER â€” replace with real content -->
            <x-frontend-base.badge variant="brand" class="mb-4">Blog</x-frontend-base.badge>
            <h1 class="font-display text-3xl lg:text-4xl font-bold text-content-strong mb-4">{{ ucwords(str_replace('-', ' ', $slug)) }}</h1>
            <p class="text-content-light text-sm mb-8">Published on January 15, 2025 Â· 5 min read</p>
            <div class="text-content-muted font-body leading-relaxed space-y-4">
                <p>This is a placeholder blog post. Real content will be loaded from the database via the BlogPost model.</p>
                <p>TimeNest's CMS architecture is ready to serve dynamic blog content without any code changes. Simply populate the blog_posts table and content will appear here automatically.</p>
            </div>
        </div>
    </section>
</x-frontend-layout.app>
