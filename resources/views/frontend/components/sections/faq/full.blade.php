    <section class="py-24 lg:py-32 bg-slate-50 relative border-t border-slate-200/60" id="faq"
             x-data="{ 
                 activeCategory: 'General', 
                 activeSubcategory: 'All',
                 searchQuery: '',
                 sortMethod: 'popular',
                 currentPage: 1,
                 itemsPerPage: 10,
                 expandedIds: [],
                 faqData: {{ Js::from($faqs) }},
                 
                 init() {
                     // Auto-expand first question of active category
                     let firstQ = this.faqData.questions.find(q => q.category === this.activeCategory);
                     if (firstQ) this.expandedIds = [firstQ.id];
                 },

                 get allSubcategories() {
                     let qs = this.faqData.questions.filter(q => q.category === this.activeCategory);
                     let subcats = [...new Set(qs.map(q => q.subcategory).filter(Boolean))];
                     return ['All', ...subcats];
                 },

                 get filteredQuestions() {
                     let qs = [...this.faqData.questions];
                     
                     // If no search, filter by category & subcategory
                     if (this.searchQuery.trim() === '') {
                         qs = qs.filter(q => q.category === this.activeCategory);
                         if (this.activeSubcategory !== 'All') {
                             qs = qs.filter(q => q.subcategory === this.activeSubcategory);
                         }
                     } else {
                         // Global search
                         let query = this.searchQuery.toLowerCase().trim();
                         qs = qs.filter(q => 
                             q.q.toLowerCase().includes(query) || 
                             q.a.toLowerCase().includes(query) || 
                             q.category.toLowerCase().includes(query) || 
                             (q.subcategory && q.subcategory.toLowerCase().includes(query)) ||
                             (q.tags && q.tags.some(t => t.toLowerCase().includes(query)))
                         );
                     }

                     // Apply sorting
                     if (this.sortMethod === 'popular') {
                         qs.sort((a, b) => (b.is_popular ? 1 : 0) - (a.is_popular ? 1 : 0));
                     } else if (this.sortMethod === 'alphabetical') {
                         qs.sort((a, b) => a.q.localeCompare(b.q));
                     } else if (this.sortMethod === 'updated') {
                         qs.sort((a, b) => b.updated_at.localeCompare(a.updated_at));
                     }
                     return qs;
                 },

                 get paginatedQuestions() {
                     let start = (this.currentPage - 1) * this.itemsPerPage;
                     return this.filteredQuestions.slice(start, start + this.itemsPerPage);
                 },

                 get totalPages() {
                     return Math.ceil(this.filteredQuestions.length / this.itemsPerPage) || 1;
                 },

                 get searchMatches() {
                     if (this.searchQuery.trim().length < 2) return [];
                     let query = this.searchQuery.toLowerCase().trim();
                     return this.faqData.questions.filter(q => 
                         q.q.toLowerCase().includes(query) || 
                         q.category.toLowerCase().includes(query) || 
                         (q.subcategory && q.subcategory.toLowerCase().includes(query))
                     ).slice(0, 5);
                 },

                 toggleQuestion(id) {
                     if (this.expandedIds.includes(id)) {
                         this.expandedIds = this.expandedIds.filter(x => x !== id);
                     } else {
                         this.expandedIds.push(id);
                     }
                 },

                 isExpanded(id) {
                     return this.expandedIds.includes(id);
                 },

                 selectSearchResult(result) {
                     this.activeCategory = result.category;
                     this.activeSubcategory = 'All';
                     this.searchQuery = '';
                     
                     this.$nextTick(() => {
                         let idx = this.filteredQuestions.findIndex(q => q.id === result.id);
                         if (idx !== -1) {
                             this.currentPage = Math.floor(idx / this.itemsPerPage) + 1;
                         }
                         if (!this.expandedIds.includes(result.id)) {
                             this.expandedIds.push(result.id);
                         }
                         
                         setTimeout(() => {
                             let el = document.getElementById('faq-' + result.id);
                             if (el) {
                                 el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                             }
                         }, 100);
                     });
                 },

                 navigateToQuestion(id) {
                     let qObj = this.faqData.questions.find(q => q.id === id);
                     if (qObj) {
                         this.selectSearchResult(qObj);
                     }
                 },

                 expandAll() {
                     let visibleIds = this.paginatedQuestions.map(q => q.id);
                     this.expandedIds = [...new Set([...this.expandedIds, ...visibleIds])];
                 },

                 collapseAll() {
                     let visibleIds = this.paginatedQuestions.map(q => q.id);
                     this.expandedIds = this.expandedIds.filter(id => !visibleIds.includes(id));
                 },

                 getCategoryCount(cat) {
                     return this.faqData.questions.filter(q => q.category === cat).length;
                 }
             }">
        
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto mb-12">
                <x-frontend-base.badge color="brand" size="md" class="mb-6">Knowledge Base</x-frontend-base.badge>
                <h2 class="font-display text-4xl lg:text-5xl font-bold text-slate-900 mb-6 tracking-tight">Everything you need to know.</h2>
                <p class="text-slate-600 text-lg lg:text-xl font-body">Clear answers to help you make an informed decision about migrating your workforce to TimeNest.</p>
            </div>

            <!-- Statistics Badge Row -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-y-6 md:gap-y-0 gap-x-4 max-w-4xl mx-auto mb-16 border-y border-slate-200 py-6 md:py-8">
                <div class="text-center">
                    <span class="text-2xl md:text-3xl font-display font-black text-slate-900 leading-none">250+</span>
                    <p class="text-[10px] text-slate-500 font-semibold uppercase tracking-wider mt-1.5 font-mono">Knowledge Articles</p>
                </div>
                <div class="text-center border-l border-slate-200">
                    <span class="text-2xl md:text-3xl font-display font-black text-slate-900 leading-none">35+</span>
                    <p class="text-[10px] text-slate-500 font-semibold uppercase tracking-wider mt-1.5 font-mono">Product Features</p>
                </div>
                <div class="text-center md:border-l border-slate-200">
                    <span class="text-2xl md:text-3xl font-display font-black text-slate-900 leading-none">24/7</span>
                    <p class="text-[10px] text-slate-500 font-semibold uppercase tracking-wider mt-1.5 font-mono">Support Coverage</p>
                </div>
                <div class="text-center border-l border-slate-200">
                    <span class="text-2xl md:text-3xl font-display font-black text-slate-900 leading-none">98%</span>
                    <p class="text-[10px] text-slate-500 font-semibold uppercase tracking-wider mt-1.5 font-mono">Questions Answered</p>
                </div>
            </div>

            <!-- Most Popular Questions Panel -->
            <div class="max-w-7xl mx-auto mb-16 p-6 rounded-3xl bg-white border border-slate-200 shadow-sm text-left">
                <h3 class="text-xs font-bold uppercase tracking-widest text-slate-400 font-mono mb-4">Most Popular Questions</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach(collect($faqs['questions'])->filter(fn($q) => $q['is_popular'])->take(4) as $pQuest)
                        <button @click="navigateToQuestion('{{ $pQuest['id'] }}')"
                                class="flex items-center justify-between p-4 rounded-xl border border-slate-100 bg-slate-50 hover:bg-slate-100 hover:border-slate-200 hover:shadow-sm text-left group transition-all duration-300 cursor-pointer">
                            <div>
                                <span class="text-xs font-semibold text-indigo-600 bg-indigo-50 border border-indigo-100 px-2 py-0.5 rounded font-mono uppercase tracking-wider">{{ $pQuest['category'] }}</span>
                                <p class="text-slate-900 font-display font-semibold text-sm sm:text-base mt-2 group-hover:text-indigo-600 transition-colors">{{ $pQuest['q'] }}</p>
                            </div>
                            <span class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-400 group-hover:text-indigo-600 group-hover:border-indigo-200 shrink-0 ml-4 transition-all">
                                &rarr;
                            </span>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Global Search Section -->
            <div class="max-w-3xl mx-auto mb-16 relative">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" /></svg>
                    </div>
                    <input x-model="searchQuery" type="text" placeholder="Search across all categories, subcategories, and answers..." 
                           class="w-full pl-12 pr-4 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 shadow-sm transition-all text-base font-body text-slate-900 placeholder-slate-400">
                </div>

                <!-- Instant Search Dropdown Overlay -->
                <div x-show="searchQuery.trim().length >= 2" 
                     x-cloak
                     class="absolute left-0 right-0 mt-2 bg-white rounded-2xl border border-slate-200/80 shadow-2xl z-50 p-2 space-y-1 text-left max-h-96 overflow-y-auto"
                     @click.away="searchQuery = ''">
                    
                    <div class="px-3 py-2 border-b border-slate-100">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest font-mono">Global Search Matches</p>
                    </div>

                    <!-- Match list -->
                    <template x-for="match in searchMatches" :key="match.id">
                        <button @click="selectSearchResult(match)"
                                class="w-full text-left p-3 hover:bg-slate-50 rounded-xl transition-colors cursor-pointer block border border-transparent hover:border-slate-100 group">
                            <div class="flex items-center justify-between">
                                <span class="font-display font-semibold text-slate-900 text-sm group-hover:text-indigo-600 transition-colors" x-text="match.q"></span>
                                <svg class="w-3.5 h-3.5 text-slate-300 group-hover:text-indigo-500 transform transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                            <div class="flex items-center gap-1.5 mt-1.5">
                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider font-mono" x-text="match.category"></span>
                                <span class="text-slate-300 text-[9px]">&bull;</span>
                                <span class="text-[9px] font-bold text-slate-500 font-mono" x-text="match.subcategory"></span>
                            </div>
                        </button>
                    </template>

                    <!-- Empty state match -->
                    <div x-show="searchMatches.length === 0" class="py-6 text-center text-slate-400 text-sm font-body">
                        No matches found. Try general keywords like "location", "pricing", or "SSO".
                    </div>
                </div>
            </div>

            <!-- Mobile Category Chips (Horizontal Swipe) -->
            <div class="lg:hidden flex overflow-x-auto gap-2 pb-6 scrollbar-hide -mx-6 px-6 select-none" x-show="searchQuery.trim() === ''">
                @foreach($faqs['categories'] as $catName => $catMeta)
                    <button @click="activeCategory = '{{ $catName }}'; activeSubcategory = 'All'; currentPage = 1; expandedIds = []"
                            class="px-4 py-2.5 rounded-xl border text-xs font-semibold tracking-tight whitespace-nowrap transition-all duration-300 cursor-pointer flex items-center gap-2"
                            :class="activeCategory === '{{ $catName }}'
                                ? 'bg-slate-900 text-white border-slate-900 shadow-md scale-[1.02]'
                                : 'bg-white text-slate-600 border-slate-200/80 hover:bg-slate-50'">
                        {!! $getSvg($catMeta['icon']) !!}
                        <span>{{ $catName }}</span>
                        <span class="px-1.5 py-0.5 rounded-full text-[9px] font-mono leading-none"
                              :class="activeCategory === '{{ $catName }}' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-500'">
                            {{ count(collect($faqs['questions'])->filter(fn($q) => $q['category'] === $catName)) }}
                        </span>
                    </button>
                @endforeach
            </div>

            <!-- Core Explorer Grid Layout -->
            <div class="flex flex-col lg:flex-row gap-12 lg:gap-16 items-start relative">
                
                <!-- Left Sidebar (Desktop Categories list) -->
                <div class="hidden lg:flex w-full lg:w-1/3 flex-col gap-3 sticky top-32 shrink-0 select-none" x-show="searchQuery.trim() === ''">
                    <div class="px-2 pb-2">
                        <h4 class="text-xs font-bold uppercase tracking-widest text-slate-400 font-mono">Browse Categories</h4>
                    </div>

                    @foreach($faqs['categories'] as $catName => $catMeta)
                        <button @click="activeCategory = '{{ $catName }}'; activeSubcategory = 'All'; currentPage = 1; expandedIds = []"
                                class="text-left p-4 rounded-2xl border transition-all duration-300 cursor-pointer group flex items-start gap-4"
                                :class="activeCategory === '{{ $catName }}'
                                    ? 'bg-slate-900 border-slate-900 text-white shadow-xl shadow-slate-900/10 scale-[1.01]'
                                    : 'bg-white border-slate-200/60 text-slate-700 hover:border-slate-300 hover:bg-slate-50/50 hover:shadow-sm'">
                            
                            <!-- Icon wrapper -->
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 border transition-colors duration-300"
                                 :class="activeCategory === '{{ $catName }}' 
                                     ? 'bg-white/10 border-white/10 text-indigo-400' 
                                     : 'bg-slate-50 border-slate-100 text-slate-400 group-hover:text-indigo-600 group-hover:border-indigo-100'">
                                {!! $getSvg($catMeta['icon']) !!}
                            </div>

                            <!-- Details -->
                            <div class="flex-grow">
                                <div class="flex items-center justify-between">
                                    <span class="font-display font-bold text-sm tracking-tight"
                                          :class="activeCategory === '{{ $catName }}' ? 'text-white' : 'text-slate-950 group-hover:text-indigo-600'">
                                        {{ $catName }}
                                    </span>
                                    <!-- count badge -->
                                    <span class="px-1.5 py-0.5 rounded-full text-[10px] font-mono leading-none"
                                          :class="activeCategory === '{{ $catName }}' ? 'bg-white/25 text-white' : 'bg-slate-100 text-slate-500'">
                                        {{ count(collect($faqs['questions'])->filter(fn($q) => $q['category'] === $catName)) }}
                                    </span>
                                </div>
                                <p class="text-[11px] leading-relaxed mt-1 font-body"
                                   :class="activeCategory === '{{ $catName }}' ? 'text-slate-400' : 'text-slate-500'">
                                    {{ $catMeta['description'] }}
                                </p>
                            </div>
                        </button>
                    @endforeach
                </div>

                <!-- Right Side: Question Explorer Area -->
                <div class="w-full lg:w-2/3 min-h-[600px] flex flex-col justify-between space-y-6">
                    
                    <!-- Search Mode Header -->
                    <div x-show="searchQuery.trim() !== ''" class="mb-4 text-left">
                        <h3 class="text-xl font-bold text-slate-950 font-display">
                            Search Results for "<span class="text-indigo-600" x-text="searchQuery"></span>"
                            <span class="text-xs font-semibold ml-2 px-2.5 py-1 rounded-full bg-slate-200 text-slate-600" x-text="filteredQuestions.length"></span>
                        </h3>
                    </div>

                    <!-- Category Mode Filters Bar -->
                    <div x-show="searchQuery.trim() === ''" class="space-y-4 text-left">
                        <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                            <h3 class="text-xl font-bold text-slate-950 font-display flex items-center gap-2">
                                <span x-text="activeCategory"></span>
                                <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-slate-200 text-slate-600" x-text="filteredQuestions.length"></span>
                            </h3>
                        </div>

                        <!-- Subcategory Horizontal Chips Scrollable -->
                        <div class="flex items-center gap-1.5 overflow-x-auto pb-2 scrollbar-hide select-none">
                            <template x-for="subcat in allSubcategories" :key="subcat">
                                <button @click="activeSubcategory = subcat; currentPage = 1"
                                        class="px-3.5 py-1.5 rounded-lg border text-xs font-semibold tracking-tight whitespace-nowrap transition-colors duration-200 cursor-pointer"
                                        :class="activeSubcategory === subcat
                                            ? 'bg-indigo-600 border-indigo-500 text-white shadow-sm'
                                            : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-slate-900'">
                                    <span x-text="subcat"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- Controls / Sort Bar -->
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-0 bg-slate-100/60 p-2.5 rounded-xl border border-slate-200/50">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 font-mono"
                              x-text="'Showing ' + (filteredQuestions.length ? ((currentPage-1)*itemsPerPage + 1) : 0) + '–' + Math.min(currentPage * itemsPerPage, filteredQuestions.length) + ' of ' + filteredQuestions.length + ' questions'">
                        </span>
                        
                        <div class="flex flex-wrap items-center justify-center gap-3">
                            <!-- Sort -->
                            <select x-model="sortMethod" 
                                    class="text-[11px] font-semibold bg-white border border-slate-200 rounded-lg px-2 py-1 text-slate-600 focus:outline-none focus:ring-1 focus:ring-indigo-500 font-body">
                                <option value="popular">Sort: Popularity</option>
                                <option value="alphabetical">Sort: Alphabetical</option>
                                <option value="updated">Sort: Recently Updated</option>
                            </select>

                            <!-- Accordion Toggles -->
                            <div class="flex items-center gap-1">
                                <button @click="expandAll()" class="text-[10px] font-bold text-slate-500 hover:text-slate-900 border border-slate-200 bg-white px-2 py-1 rounded-md transition-colors cursor-pointer">Expand All</button>
                                <button @click="collapseAll()" class="text-[10px] font-bold text-slate-500 hover:text-slate-900 border border-slate-200 bg-white px-2 py-1 rounded-md transition-colors cursor-pointer">Collapse All</button>
                            </div>
                        </div>
                    </div>

                    <!-- Questions Accordion Loop Grid -->
                    <div class="space-y-4 text-left">
                        <template x-for="faq in paginatedQuestions" :key="faq.id">
                            <div :id="'faq-' + faq.id"
                                 class="rounded-2xl border bg-white overflow-hidden transition-all duration-300 shadow-sm"
                                 :class="isExpanded(faq.id) ? 'border-indigo-500 ring-1 ring-indigo-500/10 shadow-md bg-slate-50/50' : 'border-slate-200/80 hover:border-slate-300 hover:shadow-sm'">
                                
                                <button @click="toggleQuestion(faq.id)"
                                        class="w-full flex items-start sm:items-center justify-between px-5 py-4 text-left cursor-pointer focus:outline-none group">
                                    <div class="pr-4 space-y-1.5">
                                        <!-- badges row -->
                                        <div class="flex items-center gap-2">
                                            <template x-if="faq.label">
                                                <span class="text-[9px] font-black uppercase tracking-wider px-2 py-0.5 rounded font-mono"
                                                      :class="faq.label === 'Popular' 
                                                          ? 'bg-amber-100 text-amber-800 border border-amber-200/50' 
                                                          : 'bg-emerald-100 text-emerald-800 border border-emerald-200/50'"
                                                      x-text="faq.label"></span>
                                            </template>
                                            <template x-if="searchQuery.trim() !== ''">
                                                <span class="text-[8px] font-black text-slate-400 bg-slate-100 px-1.5 py-0.5 rounded font-mono uppercase tracking-widest"
                                                      x-text="faq.category + ' > ' + faq.subcategory"></span>
                                            </template>
                                        </div>
                                        <span class="font-display font-bold text-slate-900 text-base sm:text-lg group-hover:text-indigo-600 transition-colors duration-200 leading-tight block"
                                              :class="isExpanded(faq.id) ? 'text-indigo-600' : ''" 
                                              x-text="faq.q"></span>
                                    </div>

                                    <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 border transition-all duration-300"
                                         :class="isExpanded(faq.id) 
                                             ? 'bg-indigo-100 border-indigo-200 text-indigo-600 rotate-180 shadow-inner' 
                                             : 'bg-slate-50 border-slate-100 text-slate-400 group-hover:bg-slate-100'">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </button>

                                <!-- Collapsible content -->
                                <div x-show="isExpanded(faq.id)" x-collapse>
                                    <div class="px-5 pb-5 pt-1 text-slate-600 leading-relaxed text-sm sm:text-base font-body border-t border-slate-200/40">
                                        <div class="space-y-4" x-html="faq.a"></div>
                                        
                                        <!-- Last Updated timestamp -->
                                        <div class="text-[10px] text-slate-400 font-mono mt-4 flex items-center gap-1.5 select-none">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span x-text="faq.updated_at"></span>
                                        </div>

                                        <!-- Related Questions panel -->
                                        <template x-if="faq.related_questions && faq.related_questions.length > 0">
                                            <div class="mt-6 pt-4 border-t border-slate-200 select-none">
                                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest font-mono block mb-2.5">Related Questions</span>
                                                <div class="flex flex-wrap gap-2">
                                                    <template x-for="reqId in faq.related_questions">
                                                        <button @click="navigateToQuestion(reqId)" 
                                                                class="flex items-center gap-1 text-xs font-semibold text-indigo-600 hover:text-indigo-700 bg-indigo-50 hover:bg-indigo-100/80 border border-indigo-200/50 px-3 py-1.5 rounded-lg transition-colors cursor-pointer select-none">
                                                            <span class="max-w-[200px] sm:max-w-xs truncate inline-block" x-text="faqData.questions.find(q => q.id === reqId)?.q"></span> <span>&rarr;</span>
                                                        </button>
                                                    </template>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                            </div>
                        </template>

                        <!-- Empty state questions -->
                        <div x-show="filteredQuestions.length === 0" 
                             class="text-center py-16 bg-white rounded-3xl border border-slate-200 border-dashed">
                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H13.01" /></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 mb-2 font-display">No matches found</h3>
                            <p class="text-slate-500 font-body max-w-md mx-auto">We couldn't find any questions matching your query. Try searching for other tags, or check other categories.</p>
                            <button @click="searchQuery = ''; activeSubcategory = 'All'; currentPage = 1" class="mt-6 text-sm font-bold text-indigo-600 hover:text-indigo-700 bg-indigo-50 px-4 py-2 rounded-full transition-colors cursor-pointer">Reset Explorer</button>
                        </div>
                    </div>

                    <!-- Pagination Navigation footer block -->
                    <div x-show="totalPages > 1" 
                         class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 border-t border-slate-200 select-none">
                        <!-- Left indicator -->
                        <span class="text-xs text-slate-500 font-body"
                              x-text="'Page ' + currentPage + ' of ' + totalPages"></span>
                        
                        <!-- Nav buttons -->
                        <div class="flex items-center gap-1">
                            <!-- Prev -->
                            <button @click="currentPage = Math.max(currentPage - 1, 1)"
                                    class="w-10 h-10 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 flex items-center justify-center cursor-pointer transition-colors disabled:opacity-30 disabled:pointer-events-none"
                                    :disabled="currentPage === 1">
                                &larr;
                            </button>
                            <!-- Pages Desktop -->
                            <div class="hidden sm:flex items-center gap-1">
                                <template x-for="pIdx in totalPages" :key="pIdx">
                                    <button @click="currentPage = pIdx"
                                            class="w-10 h-10 rounded-xl text-xs font-bold font-mono transition-all cursor-pointer border"
                                            :class="currentPage === pIdx
                                                ? 'bg-slate-900 text-white border-slate-900 shadow-md scale-105'
                                                : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50'"
                                            x-text="pIdx">
                                    </button>
                                </template>
                            </div>
                            
                            <!-- Page Mobile Status -->
                            <div class="flex sm:hidden items-center justify-center px-4 h-10 rounded-xl border border-slate-200 bg-white text-xs font-bold font-mono text-slate-600"
                                 x-text="currentPage + ' / ' + totalPages">
                            </div>

                            <!-- Next -->
                            <button @click="currentPage = Math.min(currentPage + 1, totalPages)"
                                    class="w-10 h-10 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 flex items-center justify-center cursor-pointer transition-colors disabled:opacity-30 disabled:pointer-events-none"
                                    :disabled="currentPage === totalPages">
                                &rarr;
                            </button>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </section>
