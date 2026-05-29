{{-- Global Search Overlay --}}
<div x-show="$store.search.open" x-transition x-cloak class="fixed inset-0 z-[60] bg-surface/95 glass">
    <div class="max-w-3xl mx-auto px-6 pt-24">
        <div class="flex items-center gap-4 mb-8">
            <div class="flex-1 relative">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-content-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input id="global-search-input" type="text" placeholder="Search pages, features, FAQs..." class="w-full pl-12 pr-4 py-4 bg-surface-card border border-surface-border rounded-xl text-content-strong placeholder-slate-500 font-body focus:outline-none focus:border-brand-500" x-model="$store.search.query" @input="$store.search.search($event.target.value)" @keydown.escape="$store.search.close()">
            </div>
            <button @click="$store.search.close()" class="p-2 text-content-muted hover:text-content-strong cursor-pointer">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div x-show="$store.search.loading" class="text-center py-8">
            <svg class="animate-spin w-6 h-6 text-brand-400 mx-auto" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
        </div>

        <div x-show="$store.search.results.length > 0 && !$store.search.loading" class="space-y-2">
            <template x-for="result in $store.search.results" :key="result.id">
                <a :href="result.url" class="block p-4 rounded-xl bg-surface-card border border-surface-border hover:border-brand-500/30 transition-colors">
                    <div class="flex items-start justify-between">
                        <div><h3 class="text-content-strong font-medium text-sm" x-text="result.title"></h3><p class="text-content-muted text-xs mt-1" x-text="result.description"></p></div>
                        <span class="text-xs px-2 py-0.5 rounded-full bg-brand-500/10 text-brand-400 shrink-0" x-text="result.type"></span>
                    </div>
                </a>
            </template>
        </div>

        <div x-show="$store.search.query.length >= 2 && $store.search.results.length === 0 && !$store.search.loading" class="text-center py-8">
            <p class="text-content-muted">No results found</p>
        </div>

        <div x-show="$store.search.query.length < 2 && !$store.search.loading" class="text-center py-12">
            <p class="text-content-light text-sm">Start typing to search...</p>
            <div class="flex items-center justify-center gap-2 mt-4 text-xs text-slate-600">
                <kbd class="px-2 py-1 rounded bg-surface-card border border-surface-border text-content-muted">ESC</kbd>
                <span>to close</span>
            </div>
        </div>
    </div>
</div>
