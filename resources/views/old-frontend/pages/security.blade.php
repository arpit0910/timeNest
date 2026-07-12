<x-frontend-layout.app metaTitle="Security & Trust â€” TimeNest" metaDescription="Learn about TimeNest's security practices, data encryption, authentication, and compliance measures.">
    <section class="relative pt-32 pb-20 bg-surface">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            <x-frontend-sections.section-header title="Security & Trust Center" subtitle="Your data security is our top priority. Here's how we protect it." badge="Security" />

            <div class="space-y-8">
                @foreach([
                    ['ðŸ”', 'JWT Authentication', 'Industry-standard JSON Web Token authentication secures every API request. Tokens are short-lived with automatic refresh, ensuring session security without compromising user experience.'],
                    ['ðŸ”’', 'Data Encryption', 'All data is encrypted in transit using TLS 1.3 and at rest using AES-256. Database connections are encrypted end-to-end.'],
                    ['ðŸ“‹', 'Comprehensive Audit Logs', 'Every action in the system is logged with timestamps, user identity, and IP addresses. Complete audit trails for compliance and forensic analysis.'],
                    ['ðŸ‘¥', 'Role-Based Access Control', 'Granular RBAC system with customizable roles and permissions. Ensure every user only accesses what they need.'],
                    ['ðŸ›¡ï¸', 'AI Fraud Detection', 'Built-in AI systems detect attendance fraud, suspicious activity, and anomalous behavior patterns in real-time.'],
                    ['ðŸŒ', 'GDPR Readiness', 'Architecture designed with data privacy principles. Data minimization, right to erasure, and consent management built into the platform. Full GDPR compliance coming soon.'],
                ] as [$icon, $title, $desc])
                    <div class="rounded-xl border border-surface-border bg-surface-card p-6 flex gap-4">
                        <span class="text-3xl shrink-0">{{ $icon }}</span>
                        <div>
                            <h3 class="font-display text-lg font-semibold text-content-strong mb-2">{{ $title }}</h3>
                            <p class="text-content-muted text-sm leading-relaxed">{{ $desc }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <x-frontend-sections.cta-block headline="Security questions?" subheadline="Our team is ready to discuss your security requirements." primaryCtaText="Contact Us" primaryCtaUrl="{{ route('frontend.contact') }}" />
</x-frontend-layout.app>
