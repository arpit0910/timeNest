<footer class="bg-surface border-t border-surface-border">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-16">
        <div class="grid grid-cols-2 md:grid-cols-6 gap-8">
            {{-- Brand --}}
            <div class="col-span-2 md:col-span-1">
                <a href="{{ route('frontend.home') }}" class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-brand-500 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="font-display text-lg font-bold text-white">Time<span class="text-brand-400">Nest</span></span>
                </a>
                <p class="text-slate-400 text-sm mb-4">The Work Operating System for modern teams.</p>
            </div>

            {{-- Product --}}
            <div>
                <h4 class="font-display font-semibold text-white text-sm mb-4">Product</h4>
                <ul class="space-y-2">
                    @foreach([
                        ['Organizations', 'frontend.product.organizations'],
                        ['Freelancers', 'frontend.product.freelancers'],
                        ['Workspace', 'frontend.product.workspace'],
                        ['Pricing', 'frontend.pricing'],
                        ['Roadmap', 'frontend.roadmap'],
                    ] as [$label, $routeName])
                        <li><a href="{{ route($routeName) }}" class="text-slate-400 text-sm hover:text-white transition-colors">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- Solutions --}}
            <div>
                <h4 class="font-display font-semibold text-white text-sm mb-4">Solutions</h4>
                <ul class="space-y-2">
                    @foreach([
                        ['Workforce Mgmt', 'workforce-management'],
                        ['Operations', 'operations-management'],
                        ['Financial Ops', 'financial-operations'],
                        ['Freelancer Mgmt', 'freelancer-management'],
                        ['AI Operations', 'ai-operations'],
                    ] as [$label, $slug])
                        <li><a href="{{ route('frontend.solutions.show', $slug) }}" class="text-slate-400 text-sm hover:text-white transition-colors">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- Company --}}
            <div>
                <h4 class="font-display font-semibold text-white text-sm mb-4">Company</h4>
                <ul class="space-y-2">
                    @foreach([
                        ['About', 'frontend.about'],
                        ['Careers', 'frontend.careers'],
                        ['Blog', 'frontend.blog.index'],
                        ['Contact', 'frontend.contact'],
                        ['Book Demo', 'frontend.book-demo'],
                    ] as [$label, $routeName])
                        <li><a href="{{ route($routeName) }}" class="text-slate-400 text-sm hover:text-white transition-colors">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- Resources --}}
            <div>
                <h4 class="font-display font-semibold text-white text-sm mb-4">Resources</h4>
                <ul class="space-y-2">
                    @foreach([
                        ['FAQs', 'frontend.faqs.index'],
                        ['Release Notes', 'frontend.release-notes'],
                        ['Changelog', 'frontend.changelog'],
                        ['Security', 'frontend.security'],
                    ] as [$label, $routeName])
                        <li><a href="{{ route($routeName) }}" class="text-slate-400 text-sm hover:text-white transition-colors">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- Legal --}}
            <div>
                <h4 class="font-display font-semibold text-white text-sm mb-4">Legal</h4>
                <ul class="space-y-2">
                    @foreach([
                        ['Privacy Policy', 'frontend.legal.privacy'],
                        ['Terms of Service', 'frontend.legal.terms'],
                        ['Compliance', 'frontend.legal.compliance'],
                    ] as [$label, $routeName])
                        <li><a href="{{ route($routeName) }}" class="text-slate-400 text-sm hover:text-white transition-colors">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    {{-- Bottom bar --}}
    <div class="border-t border-surface-border">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-slate-500 text-sm">&copy; {{ date('Y') }} TimeNest. All rights reserved.</p>
            <p class="text-slate-500 text-sm">Made in India ðŸ‡®ðŸ‡³</p>
        </div>
    </div>
</footer>
