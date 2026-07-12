@extends('layouts.marketing')

@section('content')
    <x-marketing.header />
    
    <main>
        {{-- 1. Hero Section --}}
        <section class="relative pt-32 pb-20 px-6 md:pt-40 md:pb-28 overflow-hidden bg-white">
            <x-marketing.hero-background />
            
            <div class="relative z-10 max-w-4xl mx-auto text-center animate-fade-up">
                <div class="flex justify-center mb-6">
                    <x-ui.pill-badge>
                        Solutions
                    </x-ui.pill-badge>
                </div>
                
                <h1 class="text-5xl md:text-7xl font-extrabold text-slate-900 tracking-tight leading-[1.1] mb-6">
                    One Platform. <br class="hidden sm:block" />
                    Every Stage of Your Team.
                </h1>
                
                <p class="text-lg md:text-xl text-slate-500 max-w-3xl mx-auto leading-relaxed mb-12">
                    Whether you're working solo, growing a team, or running a multi-department organization, TimeNest scales with you — without forcing you into structure you don't need yet.
                </p>
                
                <div class="flex flex-wrap items-center justify-center gap-4 md:gap-6 mt-4 max-w-4xl mx-auto">
                    <a href="#freelancers" class="inline-flex items-center rounded-full bg-slate-50 hover:bg-slate-100 px-5 py-2 text-sm font-semibold text-slate-700 shadow-sm border border-slate-200 transition-colors">
                        Freelancers
                    </a>
                    <a href="#teams" class="inline-flex items-center rounded-full bg-slate-50 hover:bg-slate-100 px-5 py-2 text-sm font-semibold text-slate-700 shadow-sm border border-slate-200 transition-colors">
                        Teams
                    </a>
                    <a href="#organizations" class="inline-flex items-center rounded-full bg-slate-50 hover:bg-slate-100 px-5 py-2 text-sm font-semibold text-slate-700 shadow-sm border border-slate-200 transition-colors">
                        Organizations
                    </a>
                </div>
            </div>
        </section>

        {{-- 2. For Freelancers & Independents --}}
        <section id="freelancers" class="py-16 lg:py-20 bg-white border-t border-slate-100 scroll-mt-20">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <div class="order-2 lg:order-1">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-xs font-semibold tracking-wide uppercase mb-6 border border-emerald-100">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Freelancers & Independents
                        </div>
                        <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6 tracking-tight">Track your own work, your own way</h2>
                        <p class="text-lg text-slate-600 mb-8 leading-relaxed">
                            You don't need a company set up to use TimeNest. Log in, start tracking your time and projects immediately — no organization, no team setup, no forced structure. When you're ready to bring people on, creating an organization takes minutes.
                        </p>
                        
                        <ul class="space-y-4">
                            <li class="flex items-start gap-3">
                                <div class="mt-1 w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span class="text-slate-700 font-medium">Personal time & project tracking from day one</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="mt-1 w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span class="text-slate-700 font-medium">No forced organization setup</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="mt-1 w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span class="text-slate-700 font-medium">Upgrade to a team whenever you're ready — same account, same data</span>
                            </li>
                        </ul>
                    </div>
                    <div class="order-1 lg:order-2">
                        <div class="bg-slate-50 rounded-3xl p-6 border border-slate-200 shadow-inner">
                            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                                <div class="flex items-center justify-between mb-6">
                                    <div>
                                        <div class="text-sm font-bold text-slate-900">Today's Worklog</div>
                                        <div class="text-xs text-slate-500">Personal Space</div>
                                    </div>
                                    <div class="text-xl font-mono font-bold text-indigo-600">04:23:15</div>
                                </div>
                                <div class="space-y-3">
                                    <div class="p-3 border border-slate-100 rounded-xl flex justify-between items-center bg-slate-50">
                                        <div class="text-sm font-medium text-slate-700">Client A - Design Review</div>
                                        <div class="text-sm font-mono text-slate-500">02:15:00</div>
                                    </div>
                                    <div class="p-3 border border-slate-100 rounded-xl flex justify-between items-center bg-white shadow-sm border-l-4 border-l-indigo-500">
                                        <div class="text-sm font-medium text-slate-700">Client B - Development</div>
                                        <div class="text-sm font-mono text-indigo-600 font-semibold flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                            02:08:15
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- 3. For Growing Teams & Startups --}}
        <section id="teams" class="py-16 lg:py-20 bg-slate-50 scroll-mt-20">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <div class="order-1">
                        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xl shadow-slate-200/50 relative">
                            <div class="absolute -top-4 -right-4 bg-amber-100 text-amber-800 text-xs font-bold px-3 py-1.5 rounded-lg shadow-md rotate-3 z-10 border border-amber-200">
                                ⏳ Pending Approval
                            </div>
                            <div class="p-4 border border-slate-100 rounded-xl bg-slate-50 mb-4">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs">MK</div>
                                        <div>
                                            <div class="text-sm font-bold text-slate-900">Maya Krishnan</div>
                                            <div class="text-xs text-slate-500">Employee</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-xs text-slate-600 bg-white p-2 rounded border border-slate-100 mt-2">
                                    <span class="font-bold">Sick Leave</span> requested for tomorrow (8 hours).
                                </div>
                                <div class="flex gap-2 mt-3">
                                    <button class="flex-1 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold py-1.5 rounded-lg transition">Deny</button>
                                    <button class="flex-1 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold py-1.5 rounded-lg transition shadow-sm">Approve</button>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between p-3 border border-slate-100 rounded-lg">
                                    <div class="flex items-center gap-3">
                                        <div class="w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold text-[10px]">JD</div>
                                        <div class="text-sm font-medium text-slate-700">James Doe</div>
                                    </div>
                                    <div class="text-xs text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded">Present</div>
                                </div>
                                <div class="flex items-center justify-between p-3 border border-slate-100 rounded-lg">
                                    <div class="flex items-center gap-3">
                                        <div class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 font-bold text-[10px]">SJ</div>
                                        <div class="text-sm font-medium text-slate-700">Sarah Jones</div>
                                    </div>
                                    <div class="text-xs text-slate-500 font-bold bg-slate-100 px-2 py-0.5 rounded">Offline</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order-2">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 text-indigo-600 text-xs font-semibold tracking-wide uppercase mb-6 border border-indigo-100">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Growing Teams & Startups
                        </div>
                        <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6 tracking-tight">Replace the group chat and the spreadsheet</h2>
                        <p class="text-lg text-slate-600 mb-8 leading-relaxed">
                            Once you're coordinating a team, WhatsApp groups and manual attendance sheets stop working. TimeNest gives you a simple structure — invite your team, assign basic roles, and let attendance and leave approvals happen without anyone chasing anyone down.
                        </p>
                        
                        <ul class="space-y-4">
                            <li class="flex items-start gap-3">
                                <div class="mt-1 w-6 h-6 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span class="text-slate-700 font-medium">Invite your team with a link — no manual account creation</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="mt-1 w-6 h-6 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span class="text-slate-700 font-medium">Simple roles: Admin, Manager, Employee</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="mt-1 w-6 h-6 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span class="text-slate-700 font-medium">Attendance and leave requests, approved in one place</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        {{-- 4. For Established Organizations & Enterprises --}}
        <section id="organizations" class="py-16 lg:py-20 bg-white border-b border-slate-100 scroll-mt-20">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <div class="order-2 lg:order-1">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-xs font-semibold tracking-wide uppercase mb-6 border border-blue-100">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            Established Organizations
                        </div>
                        <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6 tracking-tight">Structure that matches how you actually operate</h2>
                        <p class="text-lg text-slate-600 mb-8 leading-relaxed">
                            Multiple departments, multiple branches, formal reporting lines — TimeNest models your real hierarchy instead of forcing a flat team structure. Approvals follow your actual chain of command, access is controlled down to the permission, and every change is recorded.
                        </p>
                        
                        <ul class="space-y-4">
                            <li class="flex items-start gap-3">
                                <div class="mt-1 w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span class="text-slate-700 font-medium">Departments, designations, and reporting hierarchy</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="mt-1 w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span class="text-slate-700 font-medium">Multi-level approvals that follow your org chart</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="mt-1 w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span class="text-slate-700 font-medium">Custom roles and permissions, configurable per organization</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="mt-1 w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span class="text-slate-700 font-medium">Branch-level attendance with location verification</span>
                            </li>
                        </ul>
                        
                        <div class="mt-8">
                            <a href="{{ route('frontend.features.attendance-leave') }}" class="inline-flex items-center gap-2 text-blue-600 font-bold hover:text-blue-700 transition-colors group">
                                Explore attendance & leave in detail 
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                    </div>
                    <div class="order-1 lg:order-2">
                        <div class="bg-slate-50 rounded-3xl p-6 border border-slate-200 shadow-inner">
                            <div class="space-y-3 relative">
                                {{-- Tree lines --}}
                                <div class="absolute left-6 top-10 bottom-10 w-0.5 bg-slate-200 z-0"></div>
                                <div class="absolute left-6 top-10 w-6 h-0.5 bg-slate-200 z-0"></div>
                                <div class="absolute left-6 bottom-10 w-6 h-0.5 bg-slate-200 z-0"></div>
                                
                                <div class="relative z-10 p-3 border border-slate-200 rounded-xl bg-white shadow-sm flex items-center gap-3 ml-0">
                                    <div class="w-10 h-10 rounded-lg bg-blue-100 border border-blue-200 flex items-center justify-center text-blue-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-slate-900">Engineering Director</div>
                                        <div class="text-xs text-slate-500">Final Approver</div>
                                    </div>
                                </div>
                                
                                <div class="relative z-10 p-3 border border-slate-200 rounded-xl bg-white shadow-sm flex items-center gap-3 ml-12">
                                    <div class="absolute -left-6 top-1/2 w-6 h-0.5 bg-slate-200"></div>
                                    <div class="w-10 h-10 rounded-lg bg-indigo-100 border border-indigo-200 flex items-center justify-center text-indigo-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-slate-900">Frontend Lead</div>
                                        <div class="text-xs text-slate-500">Level 1 Approver</div>
                                    </div>
                                </div>
                                
                                <div class="relative z-10 p-3 border border-slate-200 rounded-xl bg-white shadow-sm flex items-center gap-3 ml-24">
                                    <div class="absolute -left-6 top-1/2 w-6 h-0.5 bg-slate-200"></div>
                                    <div class="absolute -left-12 top-[-30px] bottom-1/2 w-0.5 bg-slate-200"></div>
                                    <div class="w-10 h-10 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-slate-900">Senior Engineer</div>
                                        <div class="text-xs text-slate-500">Employee</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Mid-page CTA --}}
        <x-marketing.cta-interruption 
            heading="Not sure which stage"
            headingHighlight="fits your team?"
            subtext="Whether you're a solo freelancer testing the waters or a 500-person company replacing legacy tools, our team can walk you through the best setup — no commitment, no sales pitch."
        >
            <x-slot name="buttons">
                <a href="#" class="w-full sm:w-auto bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white font-bold px-8 py-3 rounded-full transition-all duration-200 shadow-xl shadow-indigo-500/20 flex items-center justify-center gap-2.5 border border-transparent">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Book a demo
                </a>
                <a href="/contact" class="w-full sm:w-auto bg-white hover:bg-gray-100 text-black font-bold px-8 py-3 rounded-full transition-all duration-200 flex items-center justify-center gap-2.5 shadow-sm border border-transparent">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    Talk to sales
                </a>
            </x-slot>
        </x-marketing.cta-interruption>

        {{-- 5. Chat Section --}}
        <section class="py-16 lg:py-20 bg-slate-50 border-y border-slate-100">
            <div class="max-w-4xl mx-auto px-6 text-center">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 text-indigo-600 text-xs font-semibold tracking-wide uppercase mb-6 border border-indigo-100">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    Included at every stage
                </div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6 tracking-tight">Stop switching apps just to talk to your team</h2>
                <p class="text-lg text-slate-600 mb-12 leading-relaxed">
                    Freelancer or enterprise, you still need to talk to your team and your clients. TimeNest includes secure, organization-scoped team chat by default — no separate app, no separate login, no data leaving the platform your workforce records already live in.
                </p>
                
                <div class="flex flex-wrap items-center justify-center gap-6 md:gap-10 text-slate-700 font-bold text-sm md:text-base border-t border-slate-200 pt-8 mt-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Built in at every plan — not an add-on
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Conversations stay scoped to your organization
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        One login for work, attendance, and conversation
                    </div>
                </div>
            </div>
        </section>

        {{-- 6. Comparison Table --}}
        <section class="py-16 lg:py-20 bg-white relative">
            <div class="max-w-5xl mx-auto px-6 relative z-10">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mb-4">
                        Compare at a glance
                    </h2>
                </div>
                
                <div class="overflow-x-auto bg-white rounded-3xl border border-slate-200 shadow-xl shadow-slate-200/30">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b-2 border-slate-200">
                                <th class="py-6 px-8 text-sm font-bold text-slate-900 uppercase tracking-wide">Capability</th>
                                <th class="py-6 px-8 text-sm font-bold text-slate-900 uppercase tracking-wide text-center">Freelancer</th>
                                <th class="py-6 px-8 text-sm font-bold text-slate-900 uppercase tracking-wide text-center">Team</th>
                                <th class="py-6 px-8 text-sm font-bold text-slate-900 uppercase tracking-wide text-center">Organization</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm md:text-base text-slate-700 font-medium">
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-6 px-8">Personal time & project tracking</td>
                                <td class="py-6 px-8 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span></td>
                                <td class="py-6 px-8 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span></td>
                                <td class="py-6 px-8 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span></td>
                            </tr>
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-6 px-8">Team attendance & leave</td>
                                <td class="py-6 px-8 text-center text-slate-300">—</td>
                                <td class="py-6 px-8 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span></td>
                                <td class="py-6 px-8 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span></td>
                            </tr>
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-6 px-8">Approval workflow</td>
                                <td class="py-6 px-8 text-center text-slate-300">—</td>
                                <td class="py-6 px-8 text-center"><span class="text-sm font-bold text-slate-600 bg-slate-100 px-3 py-1 rounded-full">Single-step</span></td>
                                <td class="py-6 px-8 text-center"><span class="text-sm font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full">Multi-level</span></td>
                            </tr>
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-6 px-8">Team chat</td>
                                <td class="py-6 px-8 text-center text-slate-300">—</td>
                                <td class="py-6 px-8 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span></td>
                                <td class="py-6 px-8 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span></td>
                            </tr>
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-6 px-8">Departments & hierarchy</td>
                                <td class="py-6 px-8 text-center text-slate-300">—</td>
                                <td class="py-6 px-8 text-center text-slate-300">—</td>
                                <td class="py-6 px-8 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span></td>
                            </tr>
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-6 px-8">Custom roles & permissions</td>
                                <td class="py-6 px-8 text-center text-slate-300">—</td>
                                <td class="py-6 px-8 text-center"><span class="text-sm font-bold text-slate-600 bg-slate-100 px-3 py-1 rounded-full">Basic</span></td>
                                <td class="py-6 px-8 text-center"><span class="text-sm font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full">Granular</span></td>
                            </tr>
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-6 px-8">Branch/location tracking</td>
                                <td class="py-6 px-8 text-center text-slate-300">—</td>
                                <td class="py-6 px-8 text-center text-slate-300">—</td>
                                <td class="py-6 px-8 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-6">
                    <p class="text-sm text-slate-500">Every plan can grow into the next — no migration required.</p>
                </div>
            </div>
        </section>

        {{-- 7. FAQ --}}
        <section class="py-16 lg:py-20 bg-slate-50 border-t border-slate-100">
            <div class="max-w-4xl mx-auto px-6 relative z-10">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mb-4">
                        Common Questions
                    </h2>
                </div>
                
                <div x-data="{ active: null }" class="space-y-4">
                    
                    {{-- Q1 --}}
                    <div class="border border-slate-200 rounded-2xl bg-white overflow-hidden shadow-sm transition-colors" :class="active === 1 ? 'border-indigo-200 shadow-md' : ''">
                        <button @click="active = active === 1 ? null : 1" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                            <span class="text-base font-bold text-slate-900">Do I need to create an organization to use TimeNest?</span>
                            <svg class="w-5 h-5 text-slate-400 transform transition-transform" :class="active === 1 ? 'rotate-180 text-indigo-500' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="active === 1" x-collapse x-cloak>
                            <div class="px-6 pb-6 text-slate-500 leading-relaxed text-sm">
                                No. You can use TimeNest as an individual — tracking your own time and projects — without ever creating an organization.
                            </div>
                        </div>
                    </div>

                    {{-- Q2 --}}
                    <div class="border border-slate-200 rounded-2xl bg-white overflow-hidden shadow-sm transition-colors" :class="active === 2 ? 'border-indigo-200 shadow-md' : ''">
                        <button @click="active = active === 2 ? null : 2" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                            <span class="text-base font-bold text-slate-900">Can I start solo and upgrade to a team later?</span>
                            <svg class="w-5 h-5 text-slate-400 transform transition-transform" :class="active === 2 ? 'rotate-180 text-indigo-500' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="active === 2" x-collapse x-cloak>
                            <div class="px-6 pb-6 text-slate-500 leading-relaxed text-sm">
                                Yes. Your account stays the same; you simply create or join an organization whenever you're ready to bring people on. Nothing about your existing data is lost or migrated.
                            </div>
                        </div>
                    </div>

                    {{-- Q3 --}}
                    <div class="border border-slate-200 rounded-2xl bg-white overflow-hidden shadow-sm transition-colors" :class="active === 3 ? 'border-indigo-200 shadow-md' : ''">
                        <button @click="active = active === 3 ? null : 3" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                            <span class="text-base font-bold text-slate-900">Can one person belong to more than one organization?</span>
                            <svg class="w-5 h-5 text-slate-400 transform transition-transform" :class="active === 3 ? 'rotate-180 text-indigo-500' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="active === 3" x-collapse x-cloak>
                            <div class="px-6 pb-6 text-slate-500 leading-relaxed text-sm">
                                Yes. The same TimeNest account can be part of multiple organizations — for example, running your own freelance work while also being part of a client's team — and you can switch between them.
                            </div>
                        </div>
                    </div>

                    {{-- Q4 --}}
                    <div class="border border-slate-200 rounded-2xl bg-white overflow-hidden shadow-sm transition-colors" :class="active === 4 ? 'border-indigo-200 shadow-md' : ''">
                        <button @click="active = active === 4 ? null : 4" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                            <span class="text-base font-bold text-slate-900">What happens to our setup if our team grows?</span>
                            <svg class="w-5 h-5 text-slate-400 transform transition-transform" :class="active === 4 ? 'rotate-180 text-indigo-500' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="active === 4" x-collapse x-cloak>
                            <div class="px-6 pb-6 text-slate-500 leading-relaxed text-sm">
                                Nothing breaks. Departments, hierarchy, multi-level approvals, and custom roles are available whenever you need them — you're not forced to redo your setup as you grow from a handful of people to a full company.
                            </div>
                        </div>
                    </div>

                    {{-- Q5 --}}
                    <div class="border border-slate-200 rounded-2xl bg-white overflow-hidden shadow-sm transition-colors" :class="active === 5 ? 'border-indigo-200 shadow-md' : ''">
                        <button @click="active = active === 5 ? null : 5" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                            <span class="text-base font-bold text-slate-900">Is chat included, or is it a separate product?</span>
                            <svg class="w-5 h-5 text-slate-400 transform transition-transform" :class="active === 5 ? 'rotate-180 text-indigo-500' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="active === 5" x-collapse x-cloak>
                            <div class="px-6 pb-6 text-slate-500 leading-relaxed text-sm">
                                Chat is included as part of TimeNest at every stage — it's not a separate purchase or a separate login.
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>

        {{-- Footer CTA --}}
        <x-marketing.cta-dynamic 
            heading="Ready to find your fit?"
            subtext="Whether you're tracking hours as a solo freelancer or managing attendance across a 500-person organization, TimeNest scales with you. Start free today — upgrade whenever your team needs it."
        >
            <x-slot name="buttons">
                <a href="#" class="bg-indigo-500 hover:bg-indigo-400 text-white font-bold px-8 py-3.5 rounded-xl transition shadow-lg shadow-indigo-500/25 text-center whitespace-nowrap">
                    Start free trial
                </a>
                <a href="/contact" class="bg-slate-800/50 hover:bg-slate-700 border border-slate-700 text-white font-bold px-8 py-3.5 rounded-xl transition text-center whitespace-nowrap">
                    Talk to Sales
                </a>
            </x-slot>
        </x-marketing.cta-dynamic>

    </main>

    {{-- Footer --}}
    <x-marketing.footer />
@endsection
