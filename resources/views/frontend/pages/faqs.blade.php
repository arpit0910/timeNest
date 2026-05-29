<x-frontend-layout.app metaTitle="FAQs â€” TimeNest" metaDescription="Frequently asked questions about TimeNest.">
    <section class="relative pt-32 pb-20 bg-surface">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <x-frontend-sections.section-header title="Frequently Asked Questions" subtitle="Everything you need to know about TimeNest." badge="FAQs" />
        </div>
        <x-frontend-sections.faq-block :faqs="[
            ['question' => 'What is TimeNest?', 'answer' => 'TimeNest is a Work Operating System that combines workforce management for organizations with a complete freelancer management platform.'],
            ['question' => 'Is TimeNest free for freelancers?', 'answer' => 'Yes! Core modules are completely free. Advanced AI features and Freelance Workspace require a Pro subscription.'],
            ['question' => 'How is Freelance Workspace different from an Organization?', 'answer' => 'Organizations manage employees with HR features. Freelance Workspaces manage collaborators â€” freelancers working together on shared projects.'],
            ['question' => 'Do I need a credit card?', 'answer' => 'No. Freelancers can start using core modules immediately without any payment information.'],
            ['question' => 'What AI features are available?', 'answer' => 'AI Workforce Analyst, AI Fraud Detection, AI Executive Dashboard, and AI Freelancer Assistant.'],
            ['question' => 'Can TimeNest replace multiple tools?', 'answer' => 'Yes. TimeNest replaces separate tools for HR, attendance, invoicing, project management, and analytics.'],
            ['question' => 'Is my data secure?', 'answer' => 'Yes. JWT authentication, data encryption, audit logs, and RBAC protect all your data.'],
            ['question' => 'What integrations are available?', 'answer' => 'Google Workspace, Teams, Slack, Zoom, Razorpay, Stripe integrations are coming soon.'],
            ['question' => 'Can I migrate from another platform?', 'answer' => 'Yes. Our team assists with data migration from other HR and workforce management platforms.'],
            ['question' => 'Is there a mobile app?', 'answer' => 'Mobile apps for iOS and Android are on our roadmap. The web platform is fully responsive for mobile use.'],
        ]" />
    </section>
</x-frontend-layout.app>
