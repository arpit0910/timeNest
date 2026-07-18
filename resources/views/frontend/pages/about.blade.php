@extends('layouts.marketing')
@section('title', 'About | TimeNest')
@section('content')

<x-marketing.header />

<main class="marketing-responsive-sections">
    {{-- Hero Section --}}
    <section class="relative pt-32 pb-16 lg:pt-48 lg:pb-24 overflow-hidden bg-slate-950">
        <x-marketing.hero-background />
        <div class="relative max-w-7xl mx-auto px-6 text-center z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white/80 text-sm font-semibold tracking-wide uppercase mb-8 shadow-sm">
                About TimeNest
            </div>
            
            <h1 class="text-5xl md:text-7xl font-extrabold text-white tracking-tight mb-8 leading-[1.1]">
                Built for Teams That<br class="hidden md:block"/>
                <span class="text-slate-300">Outgrow Simple Tools</span>
            </h1>
            
            <p class="text-xl md:text-2xl text-slate-400 max-w-3xl mx-auto leading-relaxed">
                TimeNest exists because most workforce tools force you to pick between "too simple" and "too complicated" — nothing built for the actual in-between of a freelancer becoming a team, and a team becoming an organization.
            </p>
        </div>
    </section>

    {{-- Why We're Building TimeNest --}}
    <section class="py-16 lg:py-24 bg-slate-950 relative overflow-hidden border-y border-slate-800">
        <div class="container mx-auto px-6 lg:px-8 xl:px-12 2xl:max-w-[1440px]">
            <div class="max-w-3xl mx-auto flex flex-col items-center text-center">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-500/20 text-amber-400 text-sm font-bold rounded-lg w-fit tracking-wide mb-6 mx-auto">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Why We're Building TimeNest
                </div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight mb-6 text-center">We kept seeing the same gap</h2>
                <div class="prose prose-lg text-slate-400 mx-auto">
                    <p class="mb-6 leading-relaxed text-lg">
                        Freelancers track time in notebooks or spreadsheets. Small teams run attendance off a WhatsApp group and a shared Excel sheet. By the time a company is large enough to afford "proper" enterprise software, they've already spent years duct-taping tools together — and migrating years of scattered data is its own project.
                    </p>
                    <p class="leading-relaxed text-lg">
                        TimeNest is built to be usable on day one, whether that's a single freelancer or a growing organization, without forcing structure before it's actually needed.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- What We Believe --}}
    <section class="py-16 lg:py-24 bg-white relative">
        <div class="container mx-auto px-6 lg:px-8 xl:px-12 2xl:max-w-[1440px]">
            <div class="max-w-4xl mx-auto flex flex-col items-center mb-16 text-center">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-100 text-emerald-700 text-sm font-bold rounded-lg w-fit tracking-wide mb-6 mx-auto">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    What We Believe
                </div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">A few things we don't compromise on</h2>
            </div>
            
            <div class="grid md:grid-cols-2 gap-x-12 gap-y-12 max-w-5xl mx-auto">
                <div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">1. Identity and business are separate.</h3>
                    <p class="text-slate-600 leading-relaxed">
                        A person's account isn't tied to one company. You can work independently, own an organization, and be invited into someone else's workspace — all on the same account.
                    </p>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">2. Structure should be earned, not forced.</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Organization setup, roles, and departments show up when you actually need them — not on day one, just because a template says so.
                    </p>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">3. Access is never hardcoded.</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Every permission is explicit and configurable by your admins, not baked into the code as an assumption about who "should" have access.
                    </p>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">4. Every organization's data stays walled off.</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Multi-tenancy isn't an afterthought — it's checked on every request, not assumed by default.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Built for Every Stage --}}
    <section class="py-16 lg:py-24 bg-slate-950 relative overflow-hidden border-y border-slate-800">
        <div class="container mx-auto px-6 lg:px-8 xl:px-12 2xl:max-w-[1440px]">
            <div class="max-w-3xl mx-auto flex flex-col items-center text-center">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-accent-500/20 text-accent-400 text-sm font-bold rounded-lg w-fit tracking-wide mb-6 mx-auto">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Built for Every Stage
                </div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight mb-6">From one person to a full organization</h2>
                <p class="text-lg text-slate-400 mb-8 leading-relaxed">
                    TimeNest is designed to work the same way for a solo freelancer, a growing startup, and a multi-department organization — the difference is what unlocks as you grow, not a different product entirely.
                </p>
                <a href="{{ route('frontend.solutions') }}" class="inline-flex items-center text-accent-400 font-semibold hover:text-accent-300 transition-colors">
                    See how TimeNest fits your team
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>
    </section>

    {{-- How We Build --}}
    <section class="py-16 lg:py-24 bg-white relative">
        <div class="container mx-auto px-6 lg:px-8 xl:px-12 2xl:max-w-[1440px]">
            <div class="max-w-3xl mx-auto flex flex-col items-center text-center">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-purple-100 text-purple-700 text-sm font-bold rounded-lg w-fit tracking-wide mb-6 mx-auto">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                    </svg>
                    How We Build
                </div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mb-6">Engineered like it has to last</h2>
                <p class="text-lg text-slate-600 leading-relaxed text-center">
                    TimeNest is built as a real production platform, not a quick MVP held together with shortcuts. That means proper tenant isolation, permission-driven access instead of hardcoded roles, encrypted sessions, and architecture designed to support new modules without rewrites — because workforce data is not something to get wrong.
                </p>
            </div>
        </div>
    </section>

    {{-- Footer CTA --}}
    <section class="py-20 lg:py-28 relative overflow-hidden bg-slate-950">
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 brightness-100 contrast-150"></div>
        <div class="absolute -top-1/2 -right-1/4 w-[1000px] h-[1000px] bg-accent-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-1/2 -left-1/4 w-[800px] h-[800px] bg-accent-500/10 rounded-full blur-3xl"></div>
        
        <div class="container mx-auto px-6 lg:px-8 xl:px-12 2xl:max-w-[1440px] relative z-10 text-center">
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white tracking-tight mb-6">
                See TimeNest for yourself
            </h2>
            <p class="text-xl text-slate-400 max-w-2xl mx-auto mb-10 leading-relaxed">
                Set up your organization in minutes — no credit card required.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <x-ui.button href="#" class="w-full sm:w-auto">Get Started</x-ui.button>
                <x-ui.button variant="secondary" href="/contact" class="w-full sm:w-auto">Talk to Sales</x-ui.button>
            </div>
        </div>
    </section>
</main>

<x-marketing.footer />
@endsection
