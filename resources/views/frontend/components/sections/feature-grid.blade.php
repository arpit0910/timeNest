<section class="py-20 bg-surface {{ $class }}">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-{{ $columns }} gap-6">
            @foreach($features as $feature)
                <x-frontend-cards.feature-card
                    :icon="$feature['icon'] ?? ''"
                    :title="$feature['title'] ?? ''"
                    :description="$feature['description'] ?? ''"
                    :href="$feature['href'] ?? ''"
                />
            @endforeach
        </div>
    </div>
</section>
