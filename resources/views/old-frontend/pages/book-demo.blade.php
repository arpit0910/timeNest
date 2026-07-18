<x-frontend-layout.app metaTitle="Book a Demo — TimeNest" metaDescription="Schedule a personalized demo of TimeNest for your organization.">
    <section class="relative pt-32 pb-20 bg-surface">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            <x-frontend-sections.section-header title="Book a Demo" subtitle="See TimeNest in action. Our team will walk you through every feature tailored to your needs." badge="Schedule Demo" />
            <div class="max-w-xl mx-auto rounded-xl border border-surface-border bg-surface-card p-8">
                <form class="space-y-4">
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div><label class="text-sm text-content-muted block mb-1">First Name</label><input type="text" class="w-full px-4 py-2.5 bg-surface border border-surface-border rounded-lg text-content-strong placeholder-neutral-500 focus:border-brand-500 focus:outline-none font-body" placeholder="First name"></div>
                        <div><label class="text-sm text-content-muted block mb-1">Last Name</label><input type="text" class="w-full px-4 py-2.5 bg-surface border border-surface-border rounded-lg text-content-strong placeholder-neutral-500 focus:border-brand-500 focus:outline-none font-body" placeholder="Last name"></div>
                    </div>
                    <div><label class="text-sm text-content-muted block mb-1">Work Email</label><input type="email" class="w-full px-4 py-2.5 bg-surface border border-surface-border rounded-lg text-content-strong placeholder-neutral-500 focus:border-brand-500 focus:outline-none font-body" placeholder="you@company.com"></div>
                    <div><label class="text-sm text-content-muted block mb-1">Organization Name</label><input type="text" class="w-full px-4 py-2.5 bg-surface border border-surface-border rounded-lg text-content-strong placeholder-neutral-500 focus:border-brand-500 focus:outline-none font-body" placeholder="Your organization"></div>
                    <div><label class="text-sm text-content-muted block mb-1">Team Size</label><select class="w-full px-4 py-2.5 bg-surface border border-surface-border rounded-lg text-content-strong focus:border-brand-500 focus:outline-none font-body"><option>1-10</option><option>11-50</option><option>51-200</option><option>201-500</option><option>500+</option></select></div>
                    <div><label class="text-sm text-content-muted block mb-1">What are you most interested in?</label><textarea rows="3" class="w-full px-4 py-2.5 bg-surface border border-surface-border rounded-lg text-content-strong placeholder-neutral-500 focus:border-brand-500 focus:outline-none font-body resize-none" placeholder="Tell us about your needs"></textarea></div>
                    <x-frontend-base.button type="submit" variant="primary" color="brand" size="lg" class="w-full">Schedule Demo</x-frontend-base.button>
                </form>
            </div>
        </div>
    </section>
</x-frontend-layout.app>

