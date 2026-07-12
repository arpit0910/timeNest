@extends('layouts.marketing')
@section('title', 'Features | TimeNest')
@section('content')

<x-marketing.header />

<main>
    {{-- Section 1: Hero --}}
    <section class="relative pt-32 pb-16 lg:pt-48 lg:pb-24 overflow-hidden bg-white">
        <x-marketing.hero-background />
        <div class="relative max-w-7xl mx-auto px-6 text-center z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-indigo-50/80 backdrop-blur-sm border border-indigo-100/50 text-indigo-700 text-sm font-semibold tracking-wide uppercase mb-8 shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                Features & Capabilities
            </div>
            
            <h1 class="text-5xl md:text-7xl font-extrabold text-slate-900 tracking-tight mb-8 leading-[1.1]">
                Everything included, <br class="hidden md:block"/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-blue-600">by how you work.</span>
            </h1>
            
            <p class="text-xl md:text-2xl text-slate-600 mb-12 max-w-3xl mx-auto leading-relaxed">
                Whether you're tracking hours as a solo freelancer or managing attendance across a 500-person organization, TimeNest has the tools you need.
            </p>
            
            <div class="flex flex-wrap justify-center gap-4">
                <a href="#freelancers" class="px-6 py-3 bg-white border border-slate-200 text-slate-700 font-bold rounded-full hover:border-indigo-300 hover:text-indigo-600 transition-colors shadow-sm">
                    Freelancers & Independents
                </a>
                <a href="#teams" class="px-6 py-3 bg-white border border-slate-200 text-slate-700 font-bold rounded-full hover:border-indigo-300 hover:text-indigo-600 transition-colors shadow-sm">
                    Growing Teams
                </a>
                <a href="#organizations" class="px-6 py-3 bg-white border border-slate-200 text-slate-700 font-bold rounded-full hover:border-indigo-300 hover:text-indigo-600 transition-colors shadow-sm">
                    Established Organizations
                </a>
            </div>
        </div>
    </section>

    {{-- Section 2: Freelancers & Independents --}}
    <section id="freelancers" class="py-20 lg:py-32 bg-slate-50 border-y border-slate-100 relative overflow-hidden scroll-mt-20">
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="order-2 lg:order-1">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 text-indigo-600 text-xs font-semibold tracking-wide uppercase mb-6 border border-indigo-100">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        Freelancers
                    </div>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6 tracking-tight">Freelancers & Independents</h2>
                    <p class="text-lg text-slate-600 mb-8 leading-relaxed">
                        Track your time cleanly without the bloat of enterprise systems. Stay focused on your work.
                    </p>
                    
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <div class="mt-1 w-6 h-6 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <span class="text-slate-700 font-medium"><strong class="text-slate-900">Personal Time & Project Tracking:</strong> Log hours against projects, no team required.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="mt-1 w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                            </div>
                            <span class="text-slate-700 font-medium"><strong class="text-slate-900">Daily Worklogs:</strong> Task-level detail, not just clock in/out.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="mt-1 w-6 h-6 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                            <span class="text-slate-700 font-medium"><strong class="text-slate-900">Account Security:</strong> JWT-based sessions, optional 2FA (<a href="/security" class="text-indigo-600 hover:underline">explore security</a>).</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="mt-1 w-6 h-6 rounded-full bg-rose-100 flex items-center justify-center text-rose-600 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" /></svg>
                            </div>
                            <span class="text-slate-700 font-medium"><strong class="text-slate-900">No Forced Structure:</strong> No org, no roles, no approval chains until you want them.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="mt-1 w-6 h-6 rounded-full bg-cyan-100 flex items-center justify-center text-cyan-600 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                            </div>
                            <span class="text-slate-700 font-medium"><strong class="text-slate-900">Seamless Upgrade Path:</strong> Same login, same history, when you add people.</span>
                        </li>
                    </ul>
                </div>
                <div class="order-1 lg:order-2">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-tr from-indigo-100 to-white rounded-3xl transform -rotate-3 scale-105 opacity-50"></div>
                        <div class="bg-white border border-slate-100 shadow-xl rounded-3xl p-8 relative z-10 flex flex-col gap-6">
                            <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100 flex items-center justify-between">
                                <div>
                                    <div class="text-sm text-slate-500 font-medium mb-1">Current Project</div>
                                    <div class="text-lg font-bold text-slate-900">Website Redesign</div>
                                </div>
                                <div class="text-2xl font-mono font-bold text-indigo-600">02:14:45</div>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-slate-100 shadow-sm">
                                    <div>
                                        <div class="text-sm font-bold text-slate-800">Client Call</div>
                                        <div class="text-xs text-slate-500">10:00 AM - 11:30 AM</div>
                                    </div>
                                    <span class="px-2 py-1 bg-emerald-50 text-emerald-600 text-xs font-semibold rounded-md border border-emerald-100">Logged</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Section 3: Growing Teams & Startups --}}
    <section id="teams" class="py-20 lg:py-32 bg-white relative overflow-hidden scroll-mt-20">
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-tr from-blue-100 to-white rounded-3xl transform rotate-3 scale-105 opacity-50"></div>
                        <div class="bg-white border border-slate-100 shadow-xl rounded-3xl p-8 relative z-10 flex flex-col gap-6">
                            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 shadow-inner">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-slate-800">Downtown Branch</div>
                                    <div class="text-xs text-slate-500">Geo-fence: 50m radius</div>
                                </div>
                                <div class="ml-auto">
                                    <span class="px-2 py-1 bg-blue-50 text-blue-600 text-xs font-semibold rounded-md border border-blue-100">Active</span>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-center gap-3 p-3 bg-white rounded-xl border border-slate-100 shadow-sm">
                                    <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 text-xs font-bold shadow-sm">AS</div>
                                    <div>
                                        <div class="text-sm font-bold text-slate-800">Alice Smith</div>
                                        <div class="text-xs text-emerald-500 font-medium">Checked in at 08:55 AM</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-xs font-semibold tracking-wide uppercase mb-6 border border-blue-100">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        Teams
                    </div>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6 tracking-tight">Growing Teams & Startups</h2>
                    <p class="text-lg text-slate-600 mb-8 leading-relaxed">
                        Structure your growing workforce with geo-verified attendance, custom leave policies, and secure team communication.
                    </p>
                    
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <div class="mt-1 w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                            </div>
                            <span class="text-slate-700 font-medium"><strong class="text-slate-900">Organization & Member Management:</strong> Invite-link based, no manual account creation.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="mt-1 w-6 h-6 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" /></svg>
                            </div>
                            <span class="text-slate-700 font-medium"><strong class="text-slate-900">Roles:</strong> Admin / Manager / Employee, assignable per member.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="mt-1 w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </div>
                            <span class="text-slate-700 font-medium"><strong class="text-slate-900">Attendance:</strong> Check-in verified against a configurable geo-fence radius per branch.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="mt-1 w-6 h-6 rounded-full bg-rose-100 flex items-center justify-center text-rose-600 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                            <span class="text-slate-700 font-medium"><strong class="text-slate-900">Leave Management:</strong> Configurable leave types, balances, and policy versioning (past approvals never change).</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="mt-1 w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <span class="text-slate-700 font-medium"><strong class="text-slate-900">Approval Workflows:</strong> Choose Auto-approval or Single-approval per policy.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="mt-1 w-6 h-6 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                            </div>
                            <span class="text-slate-700 font-medium"><strong class="text-slate-900">Worklogs:</strong> Tied to attendance, not tracked separately.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="mt-1 w-6 h-6 rounded-full bg-cyan-100 flex items-center justify-center text-cyan-600 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                            </div>
                            <span class="text-slate-700 font-medium"><strong class="text-slate-900">Team Chat:</strong> Secure, scoped to your organization only.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="mt-1 w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <span class="text-slate-500 font-medium italic"><strong class="text-slate-500">Shift Management:</strong> Coming Soon.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- Section 4: Established Organizations & Enterprises --}}
    <section id="organizations" class="py-20 lg:py-32 bg-slate-50 border-y border-slate-100 relative overflow-hidden scroll-mt-20">
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="order-2 lg:order-1">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 text-indigo-600 text-xs font-semibold tracking-wide uppercase mb-6 border border-indigo-100">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                        Organizations
                    </div>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6 tracking-tight">Established Organizations & Enterprises</h2>
                    <p class="text-lg text-slate-600 mb-8 leading-relaxed">
                        Scale efficiently with multi-level hierarchies, atomic permission syncing, and deep audit logs tailored for large-scale operations.
                    </p>
                    
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <div class="mt-1 w-6 h-6 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                            </div>
                            <span class="text-slate-700 font-medium"><strong class="text-slate-900">Departments & Designations:</strong> Full hierarchy, sub-departments, department heads.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="mt-1 w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <span class="text-slate-700 font-medium"><strong class="text-slate-900">Multi-Level Approvals:</strong> Reports-to first, department-head fallback, self-approval blocked.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="mt-1 w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </div>
                            <span class="text-slate-700 font-medium"><strong class="text-slate-900">Branch-Level Attendance:</strong> Independent geo-fence radius and rules per branch/location.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="mt-1 w-6 h-6 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                            <span class="text-slate-700 font-medium"><strong class="text-slate-900">Custom Roles & Permissions:</strong> Admin-configurable, atomic permission sync, no hardcoded limits.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="mt-1 w-6 h-6 rounded-full bg-cyan-100 flex items-center justify-center text-cyan-600 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            </div>
                            <span class="text-slate-700 font-medium"><strong class="text-slate-900">Worklogs:</strong> Tied to projects and approvals for real work context.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="mt-1 w-6 h-6 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                            </div>
                            <span class="text-slate-700 font-medium"><strong class="text-slate-900">Org-Wide Secure Chat:</strong> Scoped strictly within your org, encrypted in transit.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="mt-1 w-6 h-6 rounded-full bg-rose-100 flex items-center justify-center text-rose-600 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                            </div>
                            <span class="text-slate-700 font-medium"><strong class="text-slate-900">Account Security & Audit:</strong> 2FA, session/device tracking, activity logging.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="mt-1 w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                            </div>
                            <span class="text-slate-500 font-medium italic"><strong class="text-slate-500">Shift Management & Advanced Reporting:</strong> Coming Soon.</span>
                        </li>
                    </ul>
                </div>
                <div class="order-1 lg:order-2">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-tr from-indigo-100 to-white rounded-3xl transform -rotate-2 scale-105 opacity-50"></div>
                        <div class="bg-white border border-slate-100 shadow-xl rounded-3xl p-8 relative z-10 flex flex-col gap-6">
                            <div class="flex items-center justify-between mb-2">
                                <div class="text-sm font-bold text-slate-800">Custom Role: Floor Manager</div>
                                <span class="px-2 py-1 bg-indigo-50 text-indigo-600 text-xs font-semibold rounded-md border border-indigo-100">12 Assigned</span>
                            </div>
                            <div class="space-y-3">
                                <label class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-100 shadow-sm cursor-pointer hover:bg-slate-100 transition-colors">
                                    <div>
                                        <div class="text-sm font-bold text-slate-900">Approve Leave Requests</div>
                                        <div class="text-xs text-slate-500">Can approve Level 1 leaves</div>
                                    </div>
                                    <div class="relative inline-flex h-5 w-9 items-center rounded-full bg-indigo-500 shadow-inner">
                                        <span class="inline-block h-3 w-3 translate-x-5 rounded-full bg-white shadow-sm"></span>
                                    </div>
                                </label>
                                <label class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-100 shadow-sm cursor-pointer hover:bg-slate-100 transition-colors">
                                    <div>
                                        <div class="text-sm font-bold text-slate-900">Modify Shift Schedules</div>
                                        <div class="text-xs text-slate-500">Can edit departmental shifts</div>
                                    </div>
                                    <div class="relative inline-flex h-5 w-9 items-center rounded-full bg-slate-300 shadow-inner">
                                        <span class="inline-block h-3 w-3 translate-x-1 rounded-full bg-white shadow-sm"></span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Mid-page CTA --}}
    <x-marketing.cta-interruption 
        heading="Ready to elevate your"
        headingHighlight="workforce?"
        subtext="See these features in action by talking to our team or signing up today."
    >
        <x-slot name="buttons">
            <a href="/contact" class="w-full sm:w-auto bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold px-8 py-3.5 rounded-full transition-all duration-200 shadow-xl shadow-blue-500/20 flex items-center justify-center gap-2.5 border border-transparent">
                Contact Us
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </x-slot>
    </x-marketing.cta-interruption>

    {{-- Section 5: Feature Comparison Table --}}
    <section class="py-16 lg:py-32 bg-white relative">
        <div class="max-w-6xl mx-auto px-6 relative z-10">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mb-4">
                    Full Feature Comparison
                </h2>
                <p class="text-lg text-slate-500 max-w-2xl mx-auto">
                    A detailed breakdown of everything included at each tier.
                </p>
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
                            <td class="py-6 px-8">Time tracking</td>
                            <td class="py-6 px-8 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span></td>
                            <td class="py-6 px-8 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span></td>
                            <td class="py-6 px-8 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span></td>
                        </tr>
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-6 px-8">Worklogs</td>
                            <td class="py-6 px-8 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span></td>
                            <td class="py-6 px-8 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span></td>
                            <td class="py-6 px-8 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span></td>
                        </tr>
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-6 px-8">Attendance (geo-fence)</td>
                            <td class="py-6 px-8 text-center text-slate-300 font-bold">—</td>
                            <td class="py-6 px-8 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span></td>
                            <td class="py-6 px-8 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span></td>
                        </tr>
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-6 px-8">Leave types & balances</td>
                            <td class="py-6 px-8 text-center text-slate-300 font-bold">—</td>
                            <td class="py-6 px-8 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span></td>
                            <td class="py-6 px-8 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span></td>
                        </tr>
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-6 px-8">Approval mode</td>
                            <td class="py-6 px-8 text-center text-slate-300 font-bold">—</td>
                            <td class="py-6 px-8 text-center"><span class="text-sm font-bold text-slate-600 bg-slate-100 px-3 py-1 rounded-full">Single/Auto</span></td>
                            <td class="py-6 px-8 text-center"><span class="text-sm font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full">Multi-level</span></td>
                        </tr>
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-6 px-8">Chat</td>
                            <td class="py-6 px-8 text-center text-slate-300 font-bold">—</td>
                            <td class="py-6 px-8 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span></td>
                            <td class="py-6 px-8 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span></td>
                        </tr>
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-6 px-8">Roles</td>
                            <td class="py-6 px-8 text-center text-slate-300 font-bold">—</td>
                            <td class="py-6 px-8 text-center"><span class="text-sm font-bold text-slate-600 bg-slate-100 px-3 py-1 rounded-full">Basic</span></td>
                            <td class="py-6 px-8 text-center"><span class="text-sm font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full">Custom+Granular</span></td>
                        </tr>
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-6 px-8">Departments & hierarchy</td>
                            <td class="py-6 px-8 text-center text-slate-300 font-bold">—</td>
                            <td class="py-6 px-8 text-center text-slate-300 font-bold">—</td>
                            <td class="py-6 px-8 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span></td>
                        </tr>
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-6 px-8">Branch-level policies</td>
                            <td class="py-6 px-8 text-center text-slate-300 font-bold">—</td>
                            <td class="py-6 px-8 text-center text-slate-300 font-bold">—</td>
                            <td class="py-6 px-8 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span></td>
                        </tr>
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-6 px-8">2FA & session security</td>
                            <td class="py-6 px-8 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span></td>
                            <td class="py-6 px-8 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span></td>
                            <td class="py-6 px-8 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></span></td>
                        </tr>
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-6 px-8 text-slate-400">Shift management</td>
                            <td class="py-6 px-8 text-center"><span class="text-xs font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded-md">Coming Soon</span></td>
                            <td class="py-6 px-8 text-center"><span class="text-xs font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded-md">Coming Soon</span></td>
                            <td class="py-6 px-8 text-center"><span class="text-xs font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded-md">Coming Soon</span></td>
                        </tr>
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-6 px-8 text-slate-400">Reporting</td>
                            <td class="py-6 px-8 text-center"><span class="text-xs font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded-md">Coming Soon</span></td>
                            <td class="py-6 px-8 text-center"><span class="text-xs font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded-md">Coming Soon</span></td>
                            <td class="py-6 px-8 text-center"><span class="text-xs font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded-md">Coming Soon</span></td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- Section 6: FAQ --}}
    <section class="py-20 lg:py-32 bg-slate-50 border-y border-slate-100">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">Features Deep Dive — FAQ</h2>
            </div>
            
            <div class="space-y-4" x-data="{ active: null }">
                <x-marketing.faq-accordion 
                    id="1"
                    question="Can permissions go beyond the default roles?"
                    answer="Yes. In the Organizations tier, roles and permissions are entirely unlinked from hardcoded defaults. Administrators can create custom roles with granular atomic permissions tailored exactly to their internal hierarchy."
                />
                <x-marketing.faq-accordion 
                    id="2"
                    question="Is chat encrypted?"
                    answer="Absolutely. All internal team and organizational chat is strictly scoped within your workspace and is fully encrypted in transit."
                />
                <x-marketing.faq-accordion 
                    id="3"
                    question="Can different branches run different attendance rules?"
                    answer="Yes, Enterprise and Organization tiers allow branch-level policies, meaning one location can enforce a strict 50-meter geo-fence while another can operate with entirely different parameters."
                />
                <x-marketing.faq-accordion 
                    id="4"
                    question="What's coming next (shift management, reporting)?"
                    answer="We are actively rolling out advanced shift scheduling and deep reporting analytics across all tiers. Stay tuned to our Changelog for exact launch dates."
                />
                <x-marketing.faq-accordion 
                    id="5"
                    question="Does upgrading from Team to Organization require migration?"
                    answer="No. Because TimeNest scales with your account seamlessly, upgrading from Team to Organization requires no data migration. Your existing history remains perfectly intact while new hierarchical features are immediately unlocked."
                />
            </div>
        </div>
    </section>

    {{-- Footer CTA --}}
    <x-marketing.cta-newsletter 
        heading="Ready to optimize your workflow?"
        subtext="Start today — no credit card required."
    />

</main>

<x-marketing.footer />
@endsection
