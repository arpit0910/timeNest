<x-frontend-layout.app>
    {{-- Section 1: Hero & Value Proposition --}}
    <x-frontend-sections.hero />

    {{-- Section 2: Smart Attendance Management --}}
    <x-frontend-widgets.attendance.engine />

    {{-- Section 3: Leave & Workforce Availability --}}
    <x-frontend-widgets.leave.workflow />

    {{-- Section 4: Productivity Logs & Compliance --}}
    <x-frontend-widgets.timelog.productivity />

    {{-- Section 5: Projects, Tasks & Deadline Management --}}
    <x-frontend-widgets.project.tasks />

    {{-- Section 6: Product Showcase Carousel --}}
    <x-frontend-sections.product-carousel />

    {{-- Section 7: Middle CTA --}}
    <x-frontend-sections.cta variant="middle" />

    {{-- Section 6: Customer Testimonials (Compact) --}}
    <x-frontend-sections.testimonials.index :stories="$testimonials" />

    {{-- Section 7: FAQ (Compact) --}}
    <x-frontend-sections.faq.index :faqs="$faqs" />

    {{-- Section 8: Final Enterprise CTA --}}
    <x-frontend-sections.cta variant="final" />

    {{-- Modals --}}
    <x-frontend-modals.book-demo />
</x-frontend-layout.app>
