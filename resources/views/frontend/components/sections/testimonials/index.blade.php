<section class="py-20 lg:py-28 bg-white relative border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
        
        <div class="text-center max-w-3xl mx-auto mb-16">
            <x-frontend-base.badge variant="primary" class="mb-4">Success Stories</x-frontend-base.badge>
            <h2 class="font-display text-4xl lg:text-5xl font-bold text-slate-900 tracking-tight mb-4">
                Loved by modern teams
            </h2>
            <p class="text-lg text-slate-600 font-body">
                See how forward-thinking companies use TimeNest to streamline their workforce operations.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach(array_slice($stories, 0, 3) as $story)
            <div class="bg-slate-50 border border-slate-200 rounded-3xl p-8 hover:shadow-lg hover:border-slate-300 transition-all duration-300">
                <!-- Quote icon -->
                <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-500 flex items-center justify-center mb-6">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                </div>
                
                <p class="text-slate-700 font-body leading-relaxed mb-8">
                    "{{ $story['content'] }}"
                </p>
                
                <div class="flex items-center gap-4">
                    <img src="{{ $story['avatar'] ?? 'https://ui-avatars.com/api/?name='.urlencode($story['name']).'&background=random' }}" alt="{{ $story['name'] }}" class="w-12 h-12 rounded-full border border-slate-200 object-cover">
                    <div>
                        <h4 class="font-bold text-slate-900 text-sm">{{ $story['name'] }}</h4>
                        <p class="text-xs text-slate-500">{{ $story['role'] }}, {{ $story['company'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
    </div>
</section>
