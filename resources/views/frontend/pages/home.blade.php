<x-frontend-layout.app>
    {{-- Section 1: Hero & Value Proposition --}}
    <x-frontend-sections.hero />

    {{-- Section 2: Smart Attendance Engine --}}
    <x-frontend-widgets.attendance.engine />

    {{-- Section 3: Timelog & Productivity --}}
    <x-frontend-widgets.timelog.productivity />

    {{-- Section 4: Leave Management Workflow --}}
    <x-frontend-widgets.leave.workflow />

    {{-- Section 5: Middle CTA --}}
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
