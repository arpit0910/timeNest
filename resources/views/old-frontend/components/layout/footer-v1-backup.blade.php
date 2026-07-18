<footer class="bg-black border-t border-neutral-900/60 py-16 relative overflow-hidden">
    {{-- Ambient footer glow --}}
    <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-gradient-to-tr from-neutral-900/20 via-transparent to-transparent rounded-full blur-[100px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-6 gap-8 pb-12">
            {{-- Column 1: Brand / Logo --}}
            <div class="col-span-2 md:col-span-1 text-left">
                <a href="{{ route('frontend.home') }}" class="flex items-center mb-4">
                    <x-frontend-base.logo size="md" variant="full" />
                </a>
                <p class="text-neutral-400 text-xs sm:text-sm leading-relaxed mb-4 font-body max-w-[200px]">The Work Operating System for modern teams.</p>
            </div>

            {{-- Column 2: Product --}}
            <div>
                <h4 class="font-display font-semibold text-white text-sm mb-4">Product</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('frontend.features') }}" class="text-neutral-400 text-xs sm:text-sm hover:text-white transition-colors font-body">Features</a></li>
                    <li><a href="{{ route('frontend.feature.show', ['category' => 'workforce', 'slug' => 'attendance-management']) }}" class="text-neutral-400 text-xs sm:text-sm hover:text-white transition-colors font-body">Attendance</a></li>
                    <li><a href="{{ route('frontend.feature.show', ['category' => 'workforce', 'slug' => 'leave-management']) }}" class="text-neutral-400 text-xs sm:text-sm hover:text-white transition-colors font-body">Leave Management</a></li>
                    <li><a href="#" class="text-neutral-400 text-xs sm:text-sm hover:text-white transition-colors font-body">Payroll</a></li>
                    <li><a href="{{ route('frontend.feature.show', ['category' => 'workforce', 'slug' => 'timelog-management']) }}" class="text-neutral-400 text-xs sm:text-sm hover:text-white transition-colors font-body">Time Tracking</a></li>
                    <li><a href="#" class="text-neutral-400 text-xs sm:text-sm hover:text-white transition-colors font-body">Integrations</a></li>
                </ul>
            </div>

            {{-- Column 3: Solutions --}}
            <div>
                <h4 class="font-display font-semibold text-white text-sm mb-4">Solutions</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('frontend.solutions.show', 'startups') }}" class="text-neutral-400 text-xs sm:text-sm hover:text-white transition-colors font-body">Startups</a></li>
                    <li><a href="{{ route('frontend.solutions.show', 'smbs') }}" class="text-neutral-400 text-xs sm:text-sm hover:text-white transition-colors font-body">SMBs</a></li>
                    <li><a href="{{ route('frontend.solutions.show', 'enterprise') }}" class="text-neutral-400 text-xs sm:text-sm hover:text-white transition-colors font-body">Enterprise</a></li>
                    <li><a href="{{ route('frontend.solutions.show', 'remote-teams') }}" class="text-neutral-400 text-xs sm:text-sm hover:text-white transition-colors font-body">Remote Teams</a></li>
                    <li><a href="{{ route('frontend.solutions.show', 'contract-workforce') }}" class="text-neutral-400 text-xs sm:text-sm hover:text-white transition-colors font-body">Contract Workforce</a></li>
                </ul>
            </div>

            {{-- Column 4: Resources --}}
            <div>
                <h4 class="font-display font-semibold text-white text-sm mb-4">Resources</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('frontend.docs.index') }}" class="text-neutral-400 text-xs sm:text-sm hover:text-white transition-colors font-body">Documentation</a></li>
                    <li><a href="#" class="text-neutral-400 text-xs sm:text-sm hover:text-white transition-colors font-body">API Docs</a></li>
                    <li><a href="{{ route('frontend.blog.index') }}" class="text-neutral-400 text-xs sm:text-sm hover:text-white transition-colors font-body">Blog</a></li>
                    <li><a href="{{ route('frontend.faqs.index') }}" class="text-neutral-400 text-xs sm:text-sm hover:text-white transition-colors font-body">Help Center</a></li>
                    <li><a href="{{ route('frontend.roadmap') }}" class="text-neutral-400 text-xs sm:text-sm hover:text-white transition-colors font-body">Roadmap</a></li>
                </ul>
            </div>

            {{-- Column 5: Company --}}
            <div>
                <h4 class="font-display font-semibold text-white text-sm mb-4">Company</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('frontend.about') }}" class="text-neutral-400 text-xs sm:text-sm hover:text-white transition-colors font-body">About Us</a></li>
                    <li><a href="{{ route('frontend.careers') }}" class="text-neutral-400 text-xs sm:text-sm hover:text-white transition-colors font-body">Careers</a></li>
                    <li><a href="{{ route('frontend.contact') }}" class="text-neutral-400 text-xs sm:text-sm hover:text-white transition-colors font-body">Contact</a></li>
                    <li><a href="{{ route('frontend.legal.privacy') }}" class="text-neutral-400 text-xs sm:text-sm hover:text-white transition-colors font-body">Privacy Policy</a></li>
                    <li><a href="{{ route('frontend.legal.terms') }}" class="text-neutral-400 text-xs sm:text-sm hover:text-white transition-colors font-body">Terms</a></li>
                </ul>
            </div>

            {{-- Column 6: Newsletter Block (Stay Updated) --}}
            <div class="col-span-2 md:col-span-1 flex flex-col text-left">
                <h4 class="font-display font-semibold text-white text-sm mb-4">Stay Updated</h4>
                <p class="text-neutral-400 text-xs sm:text-sm leading-relaxed mb-4 font-body">Get the latest updates and insights on workforce management.</p>
                <form action="#" method="POST" class="space-y-2" @submit.prevent>
                    <div class="relative w-full">
                        <input type="email" placeholder="Email Address" required
                               class="w-full text-xs bg-neutral-900 border border-neutral-800 focus:border-amber-500 text-white placeholder-neutral-500 rounded-lg px-3 py-2 focus:outline-none transition-all font-body">
                    </div>
                    <button type="submit" 
                            class="w-full bg-amber-500 hover:bg-amber-400 text-neutral-950 font-bold text-xs py-2 rounded-lg text-center transition-all cursor-pointer">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>

        {{-- Bottom bar --}}
        <div class="border-t border-neutral-900/60 pt-8 mt-4">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-neutral-500 font-body">
                <span>&copy; 2026 TimeNest. All rights reserved.</span>
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-x-6 gap-y-2">
                    <a href="{{ route('frontend.legal.privacy') }}" class="hover:text-white transition-colors">Privacy</a>
                    <a href="{{ route('frontend.legal.terms') }}" class="hover:text-white transition-colors">Terms</a>
                    <a href="{{ route('frontend.legal.compliance') }}" class="hover:text-white transition-colors">Security</a>
                    <a href="#" class="hover:text-white transition-colors">Status</a>
                </div>
            </div>
        </div>
    </div>
</footer>

