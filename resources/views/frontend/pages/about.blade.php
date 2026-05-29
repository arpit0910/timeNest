<x-frontend-layout.app metaTitle="About TimeNest" metaDescription="Learn about TimeNest â€” the Work Operating System built to unify workforce management and freelancer tools.">
    <section class="relative pt-32 pb-20 bg-surface">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            <x-frontend-sections.section-header title="About TimeNest" subtitle="We're building the Work Operating System that organizations and freelancers actually need." badge="Our Story" />
            <div class="prose prose-invert max-w-none">
                <div class="space-y-6 text-slate-400 font-body">
                    <p class="text-lg">TimeNest was born from a simple frustration: why do teams need 10 different tools to manage work? HR uses one tool, attendance uses another, freelancers use a third, and none of them talk to each other.</p>
                    <p>We're building a unified Work Operating System that serves organizations of all sizes AND individual freelancers. Whether you're a startup founder managing 5 employees or a freelancer juggling 20 clients, TimeNest gives you one platform for everything.</p>
                    <p>Our AI-first approach means intelligence is built into every feature â€” from detecting attendance fraud to forecasting freelancer revenue. We don't bolt on AI as an afterthought; it's woven into the fabric of every module.</p>
                </div>
            </div>
            <div class="mt-16 grid sm:grid-cols-3 gap-6">
                @foreach([['ðŸŽ¯', 'Mission', 'To eliminate tool fragmentation and give every team a single platform for all their work operations.'], ['ðŸ‘ï¸', 'Vision', 'A world where managing work â€” whether in an organization or as a freelancer â€” is simple, intelligent, and unified.'], ['ðŸ‡®ðŸ‡³', 'Made in India', 'Built for the global market with a deep understanding of Indian businesses, pricing, and compliance needs.']] as [$icon, $title, $desc])
                    <div class="rounded-xl border border-surface-border bg-surface-card p-6"><span class="text-2xl mb-3 block">{{ $icon }}</span><h3 class="font-display text-lg font-semibold text-white mb-2">{{ $title }}</h3><p class="text-slate-400 text-sm">{{ $desc }}</p></div>
                @endforeach
            </div>
        </div>
    </section>
</x-frontend-layout.app>
