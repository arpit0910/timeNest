@extends('layouts.marketing')
@section('title', 'Blog | TimeNest')
@section('content')
    <x-marketing.header />

    <main x-data="{ searchQuery: '', activeCategory: 'All' }" class="flex-grow pb-20 bg-black relative overflow-hidden">
        {{-- Section 1: Hero --}}
        <section class="min-h-[85vh] flex flex-col justify-center relative z-10 px-6 pt-32 pb-20 mb-0 bg-black overflow-hidden">
            <x-marketing.hero-background />
            <div class="text-center max-w-3xl mx-auto mb-10 animate-fade-up relative z-10">
                <x-ui.pill-badge class="mb-6 !bg-white/10 !border-white/20 !text-white/80 backdrop-blur-sm">Blog</x-ui.pill-badge>
                <h1 class="text-5xl md:text-7xl font-extrabold text-white tracking-tight leading-[1.1] mb-6">
                    Ideas on Running<br/>Teams Better
                </h1>
                <p class="text-lg md:text-xl text-neutral-400 max-w-2xl mx-auto leading-relaxed mb-8">
                    Thoughts on workforce management, security, and building teams that don't run on spreadsheets and group chats.
                </p>
                
                
            </div>
        </section>

        {{-- Section 3: Latest Posts (Grid) --}}
        {{-- ONLY THIS SECTION IS FILTERED --}}
        <section class="py-24 bg-black border-y border-neutral-800"><div class="px-6 max-w-7xl mx-auto">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-accent-50 text-accent-600 text-xs font-semibold tracking-wide uppercase mb-6 border border-accent-100">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Recent
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Latest Posts</h2>
                <p class="text-lg text-neutral-400">Catch up on our newest thoughts and strategies for modern workforce management.</p>
                <div class="mt-10">
                    {{-- Search Input --}}
                <div class="relative max-w-lg mx-auto mb-6">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" x-model="searchQuery" class="block w-full pl-12 pr-4 py-3 border border-white/10 rounded-full leading-5 bg-white/5 placeholder-neutral-500 text-white focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 sm:text-sm shadow-sm transition-shadow hover:shadow-md" placeholder="Search articles by keyword...">
                </div>

                {{-- Category Filters --}}
                <div class="flex flex-wrap justify-center gap-2">
                    <button @click="activeCategory = 'All'" :class="activeCategory === 'All' ? 'bg-accent-600 text-white shadow-md' : 'bg-white/5 text-neutral-300 border border-white/10 hover:border-white/20 hover:text-white transition-colors shadow-sm'" class="px-4 py-1.5 rounded-full text-sm font-semibold">All</button>
                    <button @click="activeCategory = 'Workforce Management'" :class="activeCategory === 'Workforce Management' ? 'bg-accent-600 text-white shadow-md' : 'bg-white/5 text-neutral-300 border border-white/10 hover:border-white/20 hover:text-white transition-colors shadow-sm'" class="px-4 py-1.5 rounded-full text-sm font-semibold">Workforce Management</button>
                    <button @click="activeCategory = 'Security & Compliance'" :class="activeCategory === 'Security & Compliance' ? 'bg-accent-600 text-white shadow-md' : 'bg-white/5 text-neutral-300 border border-white/10 hover:border-white/20 hover:text-white transition-colors shadow-sm'" class="px-4 py-1.5 rounded-full text-sm font-semibold">Security & Compliance</button>
                    <button @click="activeCategory = 'Growing Teams'" :class="activeCategory === 'Growing Teams' ? 'bg-accent-600 text-white shadow-md' : 'bg-white/5 text-neutral-300 border border-white/10 hover:border-white/20 hover:text-white transition-colors shadow-sm'" class="px-4 py-1.5 rounded-full text-sm font-semibold">Growing Teams</button>
                    <button @click="activeCategory = 'Remote & Hybrid Work'" :class="activeCategory === 'Remote & Hybrid Work' ? 'bg-accent-600 text-white shadow-md' : 'bg-white/5 text-neutral-300 border border-white/10 hover:border-white/20 hover:text-white transition-colors shadow-sm'" class="px-4 py-1.5 rounded-full text-sm font-semibold">Remote & Hybrid Work</button>
                    
                </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Grid Post 1 --}}
                <a href="#" x-show="(activeCategory === 'All' || activeCategory === 'Workforce Management') && (searchQuery === '' || $el.innerText.toLowerCase().includes(searchQuery.toLowerCase()))" class="post-card group bg-neutral-900 rounded-3xl overflow-hidden shadow-none border border-white/10 hover:border-white/20 transition-all duration-300 flex flex-col h-full">
                    <div class="h-52 overflow-hidden bg-neutral-100">
                        <img src="{{ asset('images/blog/39f5e4bd70.jpg') }}" alt="Workflow" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-6 md:p-8 flex flex-col flex-grow items-start">
                        <x-ui.pill-badge class="mb-4 text-accent-600">Workforce Management</x-ui.pill-badge>
                        <h3 class="text-xl font-bold text-white mb-3 group-hover:text-accent-600 transition-colors leading-tight">The Real Cost of Manually Approving Leave Requests</h3>
                        <p class="text-neutral-400 text-sm mb-6 flex-grow">What actually gets lost when approvals live in someone's inbox.</p>
                        <div class="text-sm font-medium text-neutral-400 mt-auto pt-4 border-t border-white/10 w-full">TimeNest Team</div>
                    </div>
                </a>
                
                {{-- Grid Post 2 --}}
                <a href="#" x-show="(activeCategory === 'All' || activeCategory === 'Security & Compliance') && (searchQuery === '' || $el.innerText.toLowerCase().includes(searchQuery.toLowerCase()))" class="post-card group bg-neutral-900 rounded-3xl overflow-hidden shadow-none border border-white/10 hover:border-white/20 transition-all duration-300 flex flex-col h-full">
                    <div class="h-52 overflow-hidden bg-neutral-100">
                        <img src="{{ asset('images/blog/7a3d6ae345.jpg') }}" alt="Code security" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-6 md:p-8 flex flex-col flex-grow items-start">
                        <x-ui.pill-badge class="mb-4 text-accent-600">Security & Compliance</x-ui.pill-badge>
                        <h3 class="text-xl font-bold text-white mb-3 group-hover:text-accent-600 transition-colors leading-tight">Geo-Fenced Attendance: What It Is and Why It Matters</h3>
                        <p class="text-neutral-400 text-sm mb-6 flex-grow">A plain-language look at location-verified check-ins.</p>
                        <div class="text-sm font-medium text-neutral-400 mt-auto pt-4 border-t border-white/10 w-full">TimeNest Team</div>
                    </div>
                </a>

                {{-- Grid Post 3 --}}
                <a href="#" x-show="(activeCategory === 'All' || activeCategory === 'Growing Teams') && (searchQuery === '' || $el.innerText.toLowerCase().includes(searchQuery.toLowerCase()))" class="post-card group bg-neutral-900 rounded-3xl overflow-hidden shadow-none border border-white/10 hover:border-white/20 transition-all duration-300 flex flex-col h-full">
                    <div class="h-52 overflow-hidden bg-neutral-100">
                        <img src="{{ asset('images/blog/77fe2d6652.jpg') }}" alt="Team growth" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-6 md:p-8 flex flex-col flex-grow items-start">
                        <x-ui.pill-badge class="mb-4 text-emerald-600">Growing Teams</x-ui.pill-badge>
                        <h3 class="text-xl font-bold text-white mb-3 group-hover:text-accent-600 transition-colors leading-tight">From Freelancer to Founder: When to Actually Create an Organization</h3>
                        <p class="text-neutral-400 text-sm mb-6 flex-grow">The signs it's time to move past a solo setup.</p>
                        <div class="text-sm font-medium text-neutral-400 mt-auto pt-4 border-t border-white/10 w-full">TimeNest Team</div>
                    </div>
                </a>

                {{-- Grid Post 4 --}}
                <a href="#" x-show="(activeCategory === 'All' || activeCategory === 'Security & Compliance') && (searchQuery === '' || $el.innerText.toLowerCase().includes(searchQuery.toLowerCase()))" class="post-card group bg-neutral-900 rounded-3xl overflow-hidden shadow-none border border-white/10 hover:border-white/20 transition-all duration-300 flex flex-col h-full">
                    <div class="h-52 overflow-hidden bg-neutral-100">
                        <img src="{{ asset('images/blog/97369a06fe.jpg') }}" alt="Authentication" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-6 md:p-8 flex flex-col flex-grow items-start">
                        <x-ui.pill-badge class="mb-4 text-accent-600">Security & Compliance</x-ui.pill-badge>
                        <h3 class="text-xl font-bold text-white mb-3 group-hover:text-accent-600 transition-colors leading-tight">Two-Factor Authentication, Explained for Non-Technical Teams</h3>
                        <p class="text-neutral-400 text-sm mb-6 flex-grow">What 2FA actually protects against, without the jargon.</p>
                        <div class="text-sm font-medium text-neutral-400 mt-auto pt-4 border-t border-white/10 w-full">TimeNest Team</div>
                    </div>
                </a>

                {{-- Grid Post 5 --}}
                <a href="#" x-show="(activeCategory === 'All' || activeCategory === 'Remote & Hybrid Work') && (searchQuery === '' || $el.innerText.toLowerCase().includes(searchQuery.toLowerCase()))" class="post-card group bg-neutral-900 rounded-3xl overflow-hidden shadow-none border border-white/10 hover:border-white/20 transition-all duration-300 flex flex-col h-full">
                    <div class="h-52 overflow-hidden bg-neutral-100">
                        <img src="{{ asset('images/blog/whatsapp_chat.png') }}" alt="Remote working" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-6 md:p-8 flex flex-col flex-grow items-start">
                        <x-ui.pill-badge class="mb-4 text-amber-600">Remote & Hybrid Work</x-ui.pill-badge>
                        <h3 class="text-xl font-bold text-white mb-3 group-hover:text-accent-600 transition-colors leading-tight">WhatsApp Groups Aren't a Team Chat Strategy</h3>
                        <p class="text-neutral-400 text-sm mb-6 flex-grow">Why the "just use WhatsApp" phase has a shelf life.</p>
                        <div class="text-sm font-medium text-neutral-400 mt-auto pt-4 border-t border-white/10 w-full">TimeNest Team</div>
                    </div>
                </a>

                {{-- Grid Post 6 --}}
                <a href="#" x-show="(activeCategory === 'All' || activeCategory === 'Workforce Management') && (searchQuery === '' || $el.innerText.toLowerCase().includes(searchQuery.toLowerCase()))" class="post-card group bg-neutral-900 rounded-3xl overflow-hidden shadow-none border border-white/10 hover:border-white/20 transition-all duration-300 flex flex-col h-full">
                    <div class="h-52 overflow-hidden bg-neutral-100">
                        <img src="{{ asset('images/blog/0e514f19e2.jpg') }}" alt="Business discussion" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-6 md:p-8 flex flex-col flex-grow items-start">
                        <x-ui.pill-badge class="mb-4 text-accent-600">Workforce Management</x-ui.pill-badge>
                        <h3 class="text-xl font-bold text-white mb-3 group-hover:text-accent-600 transition-colors leading-tight">Designing Roles and Permissions That Don't Get in the Way</h3>
                        <p class="text-neutral-400 text-sm mb-6 flex-grow">Access control that protects data without slowing people down.</p>
                        <div class="text-sm font-medium text-neutral-400 mt-auto pt-4 border-t border-white/10 w-full">TimeNest Team</div>
                    </div>
                </a>
            </div>
            
            {{-- Fallback empty state for filtered grid --}}
            <div x-data="{ hasResults: true }" 
                 x-effect="
                     let s = searchQuery; 
                     let c = activeCategory; 
                     setTimeout(() => { 
                         hasResults = Array.from(document.querySelectorAll('.post-card')).some(el => el.style.display !== 'none');
                     }, 50);
                 " 
                 x-show="!hasResults" 
                 class="py-12 text-center" 
                 style="display: none;" x-cloak>
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-neutral-100 mb-6 text-neutral-400">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">No results found</h3>
                <p class="text-neutral-500 mb-6">We couldn't find any articles matching your search.</p>
                <button @click="searchQuery = ''; activeCategory = 'All'" class="px-6 py-2 bg-accent-50 text-accent-600 font-semibold rounded-full hover:bg-accent-100 transition-colors">Clear filters</button>
            </div>
        </div></section>

        {{-- Section 2: Featured Post (Spotlight) (Now below Latest Posts) --}}
        <section class="py-24 bg-white border-y border-neutral-100"><div class="px-6 max-w-7xl mx-auto">
            <div class="max-w-7xl mx-auto">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-50 text-amber-600 text-xs font-semibold tracking-wide uppercase mb-6 border border-amber-100">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" /></svg>
                    Spotlight
                </div>
                    <h2 class="text-3xl md:text-4xl font-bold text-neutral-900 mb-4">Featured Article</h2>
                    <p class="text-lg text-neutral-600">The most important piece of writing from our team this month.</p>
                </div>
                <a href="#" class="block group relative bg-white rounded-[2.5rem] overflow-hidden shadow-xl border border-neutral-100 hover:shadow-2xl transition-all duration-300">
                    <div class="grid grid-cols-1 lg:grid-cols-2">
                        <div class="h-72 lg:h-full overflow-hidden">
                            <img src="{{ asset('images/blog/2c97030ede.jpg') }}" alt="Team meeting" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
                        </div>
                        <div class="p-8 md:p-12 lg:p-16 flex flex-col justify-center items-start">
                            <x-ui.pill-badge class="mb-6 text-accent-600 border-accent-100 bg-accent-50">Workforce Management</x-ui.pill-badge>
                            <h2 class="text-3xl md:text-4xl font-extrabold text-neutral-900 mb-4 leading-tight group-hover:text-accent-600 transition-colors">
                                Why Attendance Sheets Stop Working Past 10 Employees
                            </h2>
                            <p class="text-lg text-neutral-600 mb-8 leading-relaxed">
                                The point where spreadsheets quietly start costing you more than they save.
                            </p>
                            <div class="flex items-center justify-between w-full mt-auto">
                                <span class="text-sm font-medium text-neutral-500">TimeNest Team</span>
                                <span class="text-sm font-bold text-accent-600 flex items-center group-hover:translate-x-1 transition-transform">
                                    Read Article 
                                    <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div></section>

        {{-- Section 4: Most Popular (Grid instead of Carousel) --}}
        <section class="py-24 bg-black border-y border-neutral-800">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-xs font-semibold tracking-wide uppercase mb-6 border border-emerald-100">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                    Trending
                </div>
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Most Popular</h2>
                    <p class="text-lg text-neutral-400">The articles that have resonated most with leaders and managers.</p>
                </div>
                
                {{-- Flex Wrap Grid Layout --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    {{-- Popular Post 1 --}}
                    <a href="#" class="flex flex-col bg-neutral-900 rounded-3xl shadow-none border border-white/10 p-8 hover:border-white/20 transition-all group hover:-translate-y-2 duration-300">
                        <x-ui.pill-badge class="mb-4 text-emerald-600 w-max">Growing Teams</x-ui.pill-badge>
                        <h3 class="text-lg font-bold text-white mb-3 group-hover:text-accent-600 transition-colors leading-tight">What Changes When Your Team Crosses 50 People</h3>
                        <p class="text-neutral-400 text-sm mb-6 flex-grow">The structural shift most growing teams don't see coming.</p>
                        <div class="text-sm font-medium text-neutral-400 mt-auto pt-4 border-t border-neutral-100">TimeNest Team</div>
                    </a>

                    {{-- Popular Post 2 --}}
                    <a href="#" class="flex flex-col bg-neutral-900 rounded-3xl shadow-none border border-white/10 p-8 hover:border-white/20 transition-all group hover:-translate-y-2 duration-300">
                        <x-ui.pill-badge class="mb-4 text-accent-600 w-max">Workforce Management</x-ui.pill-badge>
                        <h3 class="text-lg font-bold text-white mb-3 group-hover:text-accent-600 transition-colors leading-tight">How Multi-Level Approvals Actually Save Time</h3>
                        <p class="text-neutral-400 text-sm mb-6 flex-grow">Why routing requests through a real hierarchy beats a single bottleneck.</p>
                        <div class="text-sm font-medium text-neutral-400 mt-auto pt-4 border-t border-neutral-100">TimeNest Team</div>
                    </a>

                    {{-- Popular Post 3 --}}
                    <a href="#" class="flex flex-col bg-neutral-900 rounded-3xl shadow-none border border-white/10 p-8 hover:border-white/20 transition-all group hover:-translate-y-2 duration-300">
                        <x-ui.pill-badge class="mb-4 text-emerald-600 w-max">Growing Teams</x-ui.pill-badge>
                        <h3 class="text-lg font-bold text-white mb-3 group-hover:text-accent-600 transition-colors leading-tight">From Freelancer to Founder: When to Actually Create an Organization</h3>
                        <p class="text-neutral-400 text-sm mb-6 flex-grow">The signs it's time to move past a solo setup.</p>
                        <div class="text-sm font-medium text-neutral-400 mt-auto pt-4 border-t border-neutral-100">TimeNest Team</div>
                    </a>

                    {{-- Popular Post 4 --}}
                    <a href="#" class="flex flex-col bg-neutral-900 rounded-3xl shadow-none border border-white/10 p-8 hover:border-white/20 transition-all group hover:-translate-y-2 duration-300">
                        <x-ui.pill-badge class="mb-4 text-accent-600 w-max">Workforce Management</x-ui.pill-badge>
                        <h3 class="text-lg font-bold text-white mb-3 group-hover:text-accent-600 transition-colors leading-tight">Designing Roles and Permissions That Don't Get in the Way</h3>
                        <p class="text-neutral-400 text-sm mb-6 flex-grow">Access control that protects data without slowing people down.</p>
                        <div class="text-sm font-medium text-neutral-400 mt-auto pt-4 border-t border-neutral-100">TimeNest Team</div>
                    </a>
                    
                    {{-- Popular Post 5 --}}
                    <a href="#" class="flex flex-col bg-neutral-900 rounded-3xl shadow-none border border-white/10 p-8 hover:border-white/20 transition-all group hover:-translate-y-2 duration-300">
                        <x-ui.pill-badge class="mb-4 text-accent-600 w-max">Workforce Management</x-ui.pill-badge>
                        <h3 class="text-lg font-bold text-white mb-3 group-hover:text-accent-600 transition-colors leading-tight">The Real Cost of Manually Approving Leave Requests</h3>
                        <p class="text-neutral-400 text-sm mb-6 flex-grow">What actually gets lost when approvals live in someone's inbox.</p>
                        <div class="text-sm font-medium text-neutral-400 mt-auto pt-4 border-t border-neutral-100">TimeNest Team</div>
                    </a>
                </div>
            </div>
        </section>

        {{-- CTA 1: Newsletter --}}
        <div class="mb-24 px-6 max-w-7xl mx-auto">
            <x-marketing.cta-newsletter 
                heading="Get New Posts in Your Inbox"
                subtext="No spam â€” just new posts, whenever we publish something worth reading."
                buttonText="Subscribe"
            />
        </div>

        {{-- Section 5: Deep Dives (Masonry) --}}
        <section class="py-24 bg-white border-y border-neutral-100"><div class="px-6 max-w-7xl mx-auto">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-accent-50 text-accent-600 text-xs font-semibold tracking-wide uppercase mb-6 border border-accent-100">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" /></svg>
                    In-Depth
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-neutral-900 mb-4">Deep Dives</h2>
                <p class="text-lg text-neutral-600">Comprehensive guides and technical perspectives for power users.</p>
            </div>
            
            <div class="columns-1 md:columns-2 gap-8 space-y-8">
                {{-- Masonry Post 1 (Tall) --}}
                <a href="#" class="break-inside-avoid block group bg-white rounded-[2rem] overflow-hidden shadow-sm border border-neutral-100 hover:shadow-xl transition-all duration-300">
                    <div class="h-80 overflow-hidden bg-neutral-100">
                        <img src="{{ asset('images/blog/1049dc8662.jpg') }}" alt="Cybersecurity" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
                    </div>
                    <div class="p-8 items-start flex flex-col">
                        <x-ui.pill-badge class="mb-4 text-accent-600">Security & Compliance</x-ui.pill-badge>
                        <h3 class="text-2xl font-bold text-neutral-900 mb-4 group-hover:text-accent-600 transition-colors leading-tight">Multi-Tenant Data Isolation: Why It's Harder Than It Sounds</h3>
                        <p class="text-neutral-600 text-base mb-6 leading-relaxed">The quiet engineering problem behind "your data stays yours." When you build SaaS, separating tenant databases physically vs logically is a major decision that impacts every tier of security.</p>
                        <div class="text-sm font-medium text-neutral-500 pt-4 border-t border-neutral-100 w-full">TimeNest Team</div>
                    </div>
                </a>

                {{-- Masonry Post 2 (Short text only) --}}
                <a href="#" class="break-inside-avoid block group bg-white rounded-[2rem] overflow-hidden shadow-sm border border-neutral-100 hover:shadow-xl transition-all duration-300">
                    <div class="p-8 items-start flex flex-col">
                        <x-ui.pill-badge class="mb-4 text-purple-600">Product Updates</x-ui.pill-badge>
                        <h3 class="text-xl font-bold text-white mb-3 group-hover:text-accent-600 transition-colors leading-tight">Building TimeNest: Why We Started With Attendance</h3>
                        <p class="text-neutral-600 text-sm mb-6 leading-relaxed">The reasoning behind the first module we shipped, and why time tracking is the foundation of modern HR operations.</p>
                        <div class="text-sm font-medium text-neutral-500 pt-4 border-t border-neutral-100 w-full">TimeNest Team</div>
                    </div>
                </a>

                {{-- Masonry Post 3 (Short image + text) --}}
                <a href="#" class="break-inside-avoid block group bg-white rounded-[2rem] overflow-hidden shadow-sm border border-neutral-100 hover:shadow-xl transition-all duration-300">
                    <div class="h-48 overflow-hidden bg-neutral-100">
                        <img src="{{ asset('images/blog/whatsapp_chat.png') }}" alt="Remote work setup" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-8 items-start flex flex-col">
                        <x-ui.pill-badge class="mb-4 text-amber-600">Remote & Hybrid Work</x-ui.pill-badge>
                        <h3 class="text-xl font-bold text-white mb-3 group-hover:text-accent-600 transition-colors leading-tight">WhatsApp Groups Aren't a Team Chat Strategy</h3>
                        <p class="text-neutral-600 text-sm mb-6 leading-relaxed">Why informal chat networks fracture company knowledge and how to migrate teams to dedicated communication hubs.</p>
                        <div class="text-sm font-medium text-neutral-500 pt-4 border-t border-neutral-100 w-full">TimeNest Team</div>
                    </div>
                </a>

                {{-- Masonry Post 4 (Tall text focus) --}}
                <a href="#" class="break-inside-avoid block group bg-accent-50 rounded-[2rem] overflow-hidden shadow-sm border border-accent-100 hover:shadow-xl transition-all duration-300">
                    <div class="p-10 items-start flex flex-col">
                        <x-ui.pill-badge class="mb-6 text-accent-600 bg-white border-white">Workforce Management</x-ui.pill-badge>
                        <h3 class="text-2xl font-bold text-indigo-950 mb-4 group-hover:text-accent-600 transition-colors leading-tight">Inside TimeNest's Approval Hierarchy Logic</h3>
                        <p class="text-indigo-900/80 text-base mb-8 leading-relaxed">A detailed breakdown of how leave requests and expense approvals are routed when managers are out of office or escalation is required. We open-source our flowchart so you can implement similar resilience.</p>
                        <div class="flex items-center text-accent-600 font-bold group-hover:translate-x-2 transition-transform w-full">
                            Read the teardown 
                            <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                        </div>
                    </div>
                </a>
            </div>
        </div></section>

        {{-- Section 6: Quick Reads (Compact List) --}}
        <section class="py-24 bg-black border-y border-neutral-800"><div class="max-w-4xl mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-purple-50 text-purple-600 text-xs font-semibold tracking-wide uppercase mb-6 border border-purple-100">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    Bite-sized
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Quick Reads</h2>
                <p class="text-lg text-neutral-400">Short takes and updates that only take a minute.</p>
            </div>
            <div class="bg-neutral-900 rounded-3xl shadow-none border border-white/10 overflow-hidden divide-y divide-white/10">
                
                {{-- List Post 1 --}}
                <a href="#" class="block p-6 hover:bg-white/5 transition-colors group">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-bold text-white group-hover:text-accent-400 transition-colors mb-1">Building TimeNest: Why We Started With Attendance</h3>
                            <p class="text-neutral-600 text-sm">The reasoning behind the first module we shipped.</p>
                        </div>
                        <x-ui.pill-badge class="shrink-0 text-purple-600 w-max">Product Updates</x-ui.pill-badge>
                    </div>
                </a>

                {{-- List Post 2 --}}
                <a href="#" class="block p-6 hover:bg-white/5 transition-colors group">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-bold text-white group-hover:text-accent-400 transition-colors mb-1">What Changes When Your Team Crosses 50 People</h3>
                            <p class="text-neutral-600 text-sm">The structural shift most growing teams don't see coming.</p>
                        </div>
                        <x-ui.pill-badge class="shrink-0 text-emerald-600 w-max">Growing Teams</x-ui.pill-badge>
                    </div>
                </a>

                {{-- List Post 3 --}}
                <a href="#" class="block p-6 hover:bg-white/5 transition-colors group">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-bold text-white group-hover:text-accent-400 transition-colors mb-1">Two-Factor Authentication, Explained for Non-Technical Teams</h3>
                            <p class="text-neutral-600 text-sm">What 2FA actually protects against, without the jargon.</p>
                        </div>
                        <x-ui.pill-badge class="shrink-0 text-accent-600 w-max">Security</x-ui.pill-badge>
                    </div>
                </a>
                
                {{-- List Post 4 --}}
                <a href="#" class="block p-6 hover:bg-white/5 transition-colors group">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-bold text-white group-hover:text-accent-400 transition-colors mb-1">Geo-Fenced Attendance: What It Is and Why It Matters</h3>
                            <p class="text-neutral-600 text-sm">A plain-language look at location-verified check-ins.</p>
                        </div>
                        <x-ui.pill-badge class="shrink-0 text-accent-600 w-max">Security</x-ui.pill-badge>
                    </div>
                </a>

            </div>
        </div></section>

    </main>

    {{-- CTA 2: Footer CTA --}}
    <x-marketing.cta-dynamic 
        heading="Ready to see TimeNest in action?"
        subtext="Set up your organization in minutes â€” no credit card required."
    >
        <x-slot:buttons>
            <x-ui.button href="/register" class="w-full sm:w-auto">Get Started</x-ui.button>
            <x-ui.button variant="secondary" href="{{ route('frontend.book-demo') }}" class="w-full sm:w-auto">Book a Demo</x-ui.button>
        </x-slot:buttons>
    </x-marketing.cta-dynamic>

    <x-marketing.footer />
@endsection




