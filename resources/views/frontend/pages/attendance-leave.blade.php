@extends('layouts.marketing')
@section('title', 'Attendance & Leave | TimeNest')
@section('content')

<x-marketing.header />

<main class="marketing-responsive-sections">

{{-- Hero Section --}}
<section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden bg-slate-950">
    <x-marketing.hero-background />
    <div class="relative max-w-7xl mx-auto px-6 text-center z-10">
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white/80 text-sm font-semibold tracking-wide uppercase mb-8 shadow-sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Attendance & Leave
        </div>
        
        <h1 class="text-5xl md:text-7xl font-extrabold text-white tracking-tight mb-8 leading-[1.1]">
            Run Attendance & Leave <br class="hidden md:block"/>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-accent-400 to-accent-300">Exactly How Your Policy Says</span>
        </h1>
        
        <p class="text-xl md:text-2xl text-slate-400 mb-12 max-w-3xl mx-auto leading-relaxed">
            Set the rules once — geo-fenced check-ins, approval chains, leave types — and TimeNest applies them consistently, every time, without manual follow-up.
        </p>
    </div>
</section>

{{-- 1. Attendance Policies --}}
<section class="py-20 lg:py-32 bg-slate-50 border-y border-slate-100 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="order-2 lg:order-1">
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6 tracking-tight">Set the boundaries, per location</h2>
                <p class="text-lg text-slate-600 mb-8 leading-relaxed">
                    Every branch or office can have its own attendance policy. Define the geo-fence radius around a location, and TimeNest only accepts a check-in if the employee is actually within range — no location, no check-in. Multiple branches, multiple policies, no manual cross-checking.
                </p>
                
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <div class="mt-1 w-6 h-6 rounded-full bg-accent-100 flex items-center justify-center text-accent-600 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span class="text-slate-700 font-medium">Configurable geo-fence radius, set per branch</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="mt-1 w-6 h-6 rounded-full bg-accent-100 flex items-center justify-center text-accent-600 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span class="text-slate-700 font-medium">Check-ins verified against real-time location, not self-reported</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="mt-1 w-6 h-6 rounded-full bg-accent-100 flex items-center justify-center text-accent-600 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span class="text-slate-700 font-medium">Multiple branches can run different attendance rules at once</span>
                    </li>
                </ul>
            </div>
            <div class="order-1 lg:order-2">
                <img src="/images/attendance-geofence.png" alt="Geo-fence configuration" class="w-full h-auto drop-shadow-2xl rounded-3xl" />
            </div>
        </div>
    </div>
</section>

{{-- 2. Leave Policies & Types --}}
<section class="py-20 lg:py-32 bg-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div>
                <img src="/images/attendance-leave-balance.png" alt="Leave balance card" class="w-full h-auto drop-shadow-2xl rounded-3xl" />
            </div>
            <div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6 tracking-tight">Leave rules that match how your company actually works</h2>
                <p class="text-lg text-slate-600 mb-8 leading-relaxed">
                    Define the leave types your organization actually offers — casual, sick, earned, or anything custom — along with balances and eligibility. When a policy changes, past leave records stay exactly as they were approved under; only new requests follow the updated rule.
                </p>
                
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <div class="mt-1 w-6 h-6 rounded-full bg-accent-100 flex items-center justify-center text-accent-600 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span class="text-slate-700 font-medium">Custom leave types and balances, configurable per organization</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="mt-1 w-6 h-6 rounded-full bg-accent-100 flex items-center justify-center text-accent-600 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span class="text-slate-700 font-medium">Policy changes never rewrite already-approved history</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="mt-1 w-6 h-6 rounded-full bg-accent-100 flex items-center justify-center text-accent-600 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span class="text-slate-700 font-medium">Employees see their real-time balance before requesting</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- 3. Approval Workflows --}}
<section class="py-20 lg:py-32 bg-slate-50 border-y border-slate-100 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="order-2 lg:order-1">
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6 tracking-tight">Choose how strict approval needs to be</h2>
                <p class="text-lg text-slate-600 mb-8 leading-relaxed">
                    Not every request needs the same level of scrutiny. TimeNest supports three approval modes per policy — automatic approval for routine cases, a single sign-off for standard requests, or a multi-level chain for anything that needs more oversight. You decide which applies where.
                </p>
                
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <div class="mt-1 w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span class="text-slate-700 font-medium">Auto-approval for policies that don't need manual review</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="mt-1 w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span class="text-slate-700 font-medium">Single-approval for straightforward requests</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="mt-1 w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span class="text-slate-700 font-medium">Multi-level approval for requests that need a chain of sign-offs</span>
                    </li>
                </ul>
            </div>
            <div class="order-1 lg:order-2">
                <img src="/images/attendance-approvals.png" alt="Approval workflow options" class="w-full h-auto drop-shadow-2xl rounded-3xl" />
            </div>
        </div>
    </div>
</section>

{{-- 4. Approval Hierarchy --}}
<section class="py-20 lg:py-32 bg-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div>
                <img src="/images/attendance-hierarchy.png" alt="Approval hierarchy flow" class="w-full h-auto drop-shadow-2xl rounded-3xl" />
            </div>
            <div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6 tracking-tight">Approvals follow your real chain of command</h2>
                <p class="text-lg text-slate-600 mb-8 leading-relaxed">
                    Requests route to the person an employee actually reports to. If that manager is unavailable or the role is empty, TimeNest falls back to the department head automatically — nothing gets stuck waiting on one person. And no one, at any level, can approve their own request.
                </p>
                
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <div class="mt-1 w-6 h-6 rounded-full bg-accent-100 flex items-center justify-center text-accent-600 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span class="text-slate-700 font-medium">Routes to the direct reporting manager first</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="mt-1 w-6 h-6 rounded-full bg-accent-100 flex items-center justify-center text-accent-600 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span class="text-slate-700 font-medium">Falls back to department head automatically if needed</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="mt-1 w-6 h-6 rounded-full bg-accent-100 flex items-center justify-center text-accent-600 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span class="text-slate-700 font-medium">Self-approval is never permitted, at any level</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- 5. Worklogs --}}
<section class="py-20 lg:py-32 bg-slate-50 border-y border-slate-100 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="order-2 lg:order-1">
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6 tracking-tight">See what was actually worked on, not just when someone clocked in</h2>
                <p class="text-lg text-slate-600 mb-8 leading-relaxed">
                    Attendance tells you someone was present. Worklogs tell you what they worked on. TimeNest ties daily worklogs to attendance records, so hours logged connect to real project or task context — not just a timestamp.
                </p>
                
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <div class="mt-1 w-6 h-6 rounded-full bg-accent-100 flex items-center justify-center text-accent-600 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span class="text-slate-700 font-medium">Daily worklogs tied to attendance, not tracked separately</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="mt-1 w-6 h-6 rounded-full bg-accent-100 flex items-center justify-center text-accent-600 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span class="text-slate-700 font-medium">Gives managers real context, not just presence data</span>
                    </li>
                </ul>
            </div>
            <div class="order-1 lg:order-2">
                <img src="/images/attendance-worklogs.png" alt="Worklogs and attendance" class="w-full h-auto drop-shadow-2xl rounded-3xl" />
            </div>
        </div>
    </div>
</section>

{{-- Mid-page CTA --}}
<x-marketing.cta-interruption 
    heading="Want to see how this"
    headingHighlight="fits your policy?"
    subtext="Talk to our team — we'll walk through your specific approval and attendance rules."
>
    <x-slot name="buttons">
        <x-ui.button href="/contact" class="w-full sm:w-auto">Contact Us</x-ui.button>
    </x-slot>
</x-marketing.cta-interruption>

{{-- FAQ Section --}}
<section class="py-20 lg:py-32 bg-slate-50 border-y border-slate-100">
    <div class="max-w-4xl mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">Attendance & Leave — Common Questions</h2>
        </div>
        
        <div class="space-y-4" x-data="{ active: null }">
            <x-marketing.faq-accordion 
                id="1"
                question="Can different branches have different attendance policies?"
                answer="Yes. Each branch can have its own geo-fence radius and attendance rules — you're not locked into one policy across your entire organization."
            />
            <x-marketing.faq-accordion 
                id="2"
                question="If we change a leave or attendance policy, does it affect past records?"
                answer="No. Past requests and approvals stay exactly as they were under the policy that applied at the time. Only new requests follow the updated policy."
            />
            <x-marketing.faq-accordion 
                id="3"
                question="Who approves my leave if my manager is unavailable?"
                answer="TimeNest automatically falls back to your department head if your direct reporting manager isn't available, so requests don't sit unresolved."
            />
            <x-marketing.faq-accordion 
                id="4"
                question="Can I choose how strict approval is for different types of requests?"
                answer="Yes. You can set a policy to auto-approve, require a single approval, or require a multi-level chain of approvals — this is configurable per policy, not fixed platform-wide."
            />
            <x-marketing.faq-accordion 
                id="5"
                question="Can someone approve their own attendance or leave request?"
                answer="No. Self-approval is blocked at every level, with no exceptions."
            />
        </div>
    </div>
</section>

{{-- Footer CTA --}}
<x-marketing.cta-newsletter 
    heading="Ready to set your own policies?"
    subtext="Set up your organization in minutes — no credit card required."
/>

</main>

<x-marketing.footer />
@endsection
