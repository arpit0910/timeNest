<x-frontend-layout.app metaTitle="Contact Us â€” TimeNest" metaDescription="Get in touch with the TimeNest team. We'd love to hear from you.">
    <section class="relative pt-32 pb-20 bg-surface">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            <x-frontend-sections.section-header title="Contact Us" subtitle="Have questions? We'd love to hear from you." badge="Get in Touch" />
            <div class="grid md:grid-cols-2 gap-12">
                <div class="space-y-6">
                    @foreach([['ðŸ“§', 'Email', 'hello@timenest.in'], ['ðŸ¢', 'Office', 'India (Remote-first)'], ['ðŸ•', 'Hours', 'Mon-Fri, 9AM-6PM IST']] as [$icon, $label, $value])
                        <div class="flex items-start gap-4"><span class="text-2xl">{{ $icon }}</span><div><p class="text-content-strong font-medium">{{ $label }}</p><p class="text-content-muted text-sm">{{ $value }}</p></div></div>
                    @endforeach
                </div>
                <div class="rounded-xl border border-surface-border bg-surface-card p-6">
                    <form class="space-y-4">
                        <div><label class="text-sm text-content-muted block mb-1">Name</label><input type="text" class="w-full px-4 py-2.5 bg-surface border border-surface-border rounded-lg text-content-strong placeholder-slate-500 focus:border-brand-500 focus:outline-none font-body" placeholder="Your name"></div>
                        <div><label class="text-sm text-content-muted block mb-1">Email</label><input type="email" class="w-full px-4 py-2.5 bg-surface border border-surface-border rounded-lg text-content-strong placeholder-slate-500 focus:border-brand-500 focus:outline-none font-body" placeholder="you@company.com"></div>
                        <div><label class="text-sm text-content-muted block mb-1">Message</label><textarea rows="4" class="w-full px-4 py-2.5 bg-surface border border-surface-border rounded-lg text-content-strong placeholder-slate-500 focus:border-brand-500 focus:outline-none font-body resize-none" placeholder="How can we help?"></textarea></div>
                        <x-frontend-base.button type="submit" variant="primary" color="brand" class="w-full">Send Message</x-frontend-base.button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-frontend-layout.app>
