<div class="space-y-12">
    <!-- Header inside video grid section -->
    <div class="text-left max-w-2xl">
        <h3 class="text-zinc-500 font-mono text-xs uppercase tracking-widest font-bold mb-2">Watch Customer Stories</h3>
        <h4 class="text-2xl md:text-3xl font-display font-bold text-white tracking-tight">Real-world impact, caught on screen.</h4>
        <p class="text-zinc-400 text-sm font-body mt-2">Hear directly from the founders, HR specialists, and operations managers who run their businesses on TimeNest.</p>
    </div>

    <!-- 3-Column Video Grid Layout -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($videos as $video)
            <x-frontend-sections.video-card :video="$video" />
        @endforeach
    </div>
</div>
