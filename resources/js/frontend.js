import Alpine from 'alpinejs';

window.Alpine = Alpine;

// ── Global Search Store ──
Alpine.store('search', {
    open: false,
    query: '',
    results: [],
    loading: false,
    debounceTimer: null,

    toggle() {
        this.open = !this.open;
        if (this.open) {
            this.query = '';
            this.results = [];
            setTimeout(() => document.getElementById('global-search-input')?.focus(), 100);
        }
    },

    close() {
        this.open = false;
        this.query = '';
        this.results = [];
    },

    async search(query) {
        this.query = query;
        clearTimeout(this.debounceTimer);

        if (query.length < 2) {
            this.results = [];
            return;
        }

        this.debounceTimer = setTimeout(async () => {
            this.loading = true;
            try {
                const response = await fetch(`/api/search?q=${encodeURIComponent(query)}`);
                const data = await response.json();
                this.results = data.results || [];
            } catch (e) {
                this.results = [];
            }
            this.loading = false;
        }, 300);
    }
});

// ── Mobile Nav Store ──
Alpine.store('mobileNav', {
    open: false,
    toggle() { this.open = !this.open; },
    close() { this.open = false; }
});

Alpine.start();
