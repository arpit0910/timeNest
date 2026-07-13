@extends('layouts.marketing')
@section('title', 'Features | TimeNest')
@section('content')

<x-marketing.header />

<main class="marketing-responsive-sections">
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
                <span class="text-slate-900">by how you work.</span>
            </h1>
            
            <p class="text-xl md:text-2xl text-slate-600 mb-12 max-w-3xl mx-auto leading-relaxed">
                Whether you're tracking hours as a solo freelancer or managing attendance across a 500-person organization, TimeNest has the tools you need.
            </p>
            
            <div class="inline-flex flex-wrap p-1.5 bg-slate-100/80 backdrop-blur-md rounded-2xl border border-slate-200/50 gap-1.5 shadow-sm max-w-2xl mx-auto mt-4">
                <a href="#freelancers" class="group flex items-center gap-2 px-5 py-2.5 rounded-xl bg-transparent hover:bg-white hover:shadow-md hover:border-slate-150/50 transition-all duration-300 text-sm font-semibold text-slate-600 hover:text-slate-900">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-600 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Freelancers
                </a>
                <a href="#teams" class="group flex items-center gap-2 px-5 py-2.5 rounded-xl bg-transparent hover:bg-white hover:shadow-md hover:border-slate-150/50 transition-all duration-300 text-sm font-semibold text-slate-600 hover:text-slate-900">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-600 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Teams
                </a>
                <a href="#organizations" class="group flex items-center gap-2 px-5 py-2.5 rounded-xl bg-transparent hover:bg-white hover:shadow-md hover:border-slate-150/50 transition-all duration-300 text-sm font-semibold text-slate-600 hover:text-slate-900">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-600 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Organizations
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
                        <div class="absolute inset-0 bg-gradient-to-tr from-indigo-200 to-purple-100 rounded-3xl transform -rotate-2 scale-105 opacity-60"></div>
                        <div class="bg-white border border-slate-100 shadow-2xl rounded-3xl p-6 relative z-10 flex flex-col gap-6">
                            
                            {{-- Header Stats --}}
                            <div class="flex items-end justify-between border-b border-slate-100 pb-4">
                                <div>
                                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Weekly Summary</div>
                                    <div class="text-3xl font-extrabold text-slate-900 tracking-tight">38<span class="text-xl text-slate-400 font-medium">h</span> 15<span class="text-xl text-slate-400 font-medium">m</span></div>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-md">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                                        12% vs last week
                                    </span>
                                </div>
                            </div>
                            
                            {{-- Mini Bar Chart --}}
                            <div class="flex items-end justify-between h-24 gap-2 pt-2">
                                <div class="w-full bg-indigo-50 rounded-t-sm h-[40%] relative group"><div class="absolute inset-x-0 bottom-full mb-2 hidden group-hover:block text-center text-xs font-bold text-slate-700 bg-white shadow-sm border border-slate-100 py-1 rounded">4h</div></div>
                                <div class="w-full bg-indigo-50 rounded-t-sm h-[70%] relative group"><div class="absolute inset-x-0 bottom-full mb-2 hidden group-hover:block text-center text-xs font-bold text-slate-700 bg-white shadow-sm border border-slate-100 py-1 rounded">7h</div></div>
                                <div class="w-full bg-indigo-500 rounded-t-sm h-[85%] relative shadow-[0_0_15px_rgba(99,102,241,0.4)]"><div class="absolute inset-x-0 bottom-full mb-2 text-center text-xs font-bold text-indigo-700 bg-indigo-50 py-1 rounded">8.5h</div></div>
                                <div class="w-full bg-indigo-50 rounded-t-sm h-[60%] relative group"><div class="absolute inset-x-0 bottom-full mb-2 hidden group-hover:block text-center text-xs font-bold text-slate-700 bg-white shadow-sm border border-slate-100 py-1 rounded">6h</div></div>
                                <div class="w-full bg-indigo-50 rounded-t-sm h-[90%] relative group"><div class="absolute inset-x-0 bottom-full mb-2 hidden group-hover:block text-center text-xs font-bold text-slate-700 bg-white shadow-sm border border-slate-100 py-1 rounded">9h</div></div>
                                <div class="w-full bg-slate-50 rounded-t-sm h-[10%] relative group"><div class="absolute inset-x-0 bottom-full mb-2 hidden group-hover:block text-center text-xs font-bold text-slate-700 bg-white shadow-sm border border-slate-100 py-1 rounded">1h</div></div>
                                <div class="w-full bg-slate-50 rounded-t-sm h-[0%]"></div>
                            </div>
                            <div class="flex items-center justify-between text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1 px-1">
                                <span>M</span><span>T</span><span class="text-indigo-600">W</span><span>T</span><span>F</span><span>S</span><span>S</span>
                            </div>
                            
                            {{-- Detailed Log List --}}
                            <div class="space-y-3 mt-2">
                                <div class="flex items-center gap-4 p-3 bg-slate-50 rounded-xl border border-slate-100 hover:bg-white hover:shadow-md transition-all cursor-pointer">
                                    <div class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="text-sm font-bold text-slate-900">Frontend Architecture</span>
                                            <span class="text-sm font-mono font-bold text-slate-700">03:45:00</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="px-2 py-0.5 bg-indigo-100 text-indigo-700 text-[10px] font-bold uppercase tracking-wider rounded">TimeNest App</span>
                                            <span class="text-xs text-slate-500">Billable</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4 p-3 bg-slate-50 rounded-xl border border-slate-100 hover:bg-white hover:shadow-md transition-all cursor-pointer">
                                    <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="text-sm font-bold text-slate-900">Client Sync - Q3 Goals</span>
                                            <span class="text-sm font-mono font-bold text-slate-700">01:30:00</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="px-2 py-0.5 bg-rose-100 text-rose-700 text-[10px] font-bold uppercase tracking-wider rounded">Consulting</span>
                                            <span class="text-xs text-slate-500">Billable</span>
                                        </div>
                                    </div>
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
                        <div class="absolute inset-0 bg-gradient-to-tr from-blue-200 to-cyan-100 rounded-3xl transform rotate-2 scale-105 opacity-60"></div>
                        <div class="bg-white border border-slate-100 shadow-2xl rounded-3xl p-6 relative z-10 flex flex-col gap-6 overflow-hidden">
                            
                            {{-- Live Radar Header --}}
                            <div class="relative bg-slate-900 rounded-2xl p-5 overflow-hidden">
                                {{-- Radar Rings --}}
                                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 border border-slate-700/50 rounded-full"></div>
                                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-48 h-48 border border-slate-700/50 rounded-full"></div>
                                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-32 h-32 border border-slate-600/50 rounded-full bg-slate-800/30"></div>
                                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-16 h-16 border border-emerald-500/30 rounded-full bg-emerald-500/10 animate-pulse"></div>
                                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.8)]"></div>
                                
                                {{-- Fake Pins --}}
                                <div class="absolute top-1/4 left-1/3 w-2 h-2 rounded-full bg-blue-400 shadow-[0_0_8px_rgba(96,165,250,0.8)]"></div>
                                <div class="absolute bottom-1/3 right-1/4 w-2 h-2 rounded-full bg-rose-400 shadow-[0_0_8px_rgba(251,113,133,0.8)]"></div>
                                <div class="absolute top-1/3 right-1/3 w-2 h-2 rounded-full bg-blue-400 shadow-[0_0_8px_rgba(96,165,250,0.8)]"></div>
                                
                                <div class="relative z-10 flex items-center justify-between">
                                    <div>
                                        <div class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1 flex items-center gap-2">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Live Status
                                        </div>
                                        <div class="text-xl font-bold text-white">Downtown HQ</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-xs font-medium text-slate-400">Geo-fence</div>
                                        <div class="text-sm font-mono font-bold text-emerald-400">150m Radius</div>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Team Status Grid --}}
                            <div class="grid grid-cols-2 gap-3">
                                <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 hover:shadow-md transition-shadow relative overflow-hidden">
                                    <div class="absolute top-0 right-0 w-8 h-8 bg-emerald-50 transform rotate-45 translate-x-4 -translate-y-4"></div>
                                    <div class="flex items-start justify-between mb-3 relative z-10">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-xs shadow-inner">AS</div>
                                        <span class="flex h-2.5 w-2.5 rounded-full bg-emerald-500 shadow-[0_0_5px_rgba(16,185,129,0.5)]"></span>
                                    </div>
                                    <div class="text-sm font-bold text-slate-900 relative z-10">Alice Smith</div>
                                    <div class="text-[10px] font-medium text-emerald-600 uppercase tracking-wider mt-1 relative z-10">In Zone • 08:45 AM</div>
                                </div>
                                <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 hover:shadow-md transition-shadow relative overflow-hidden">
                                    <div class="absolute top-0 right-0 w-8 h-8 bg-rose-50 transform rotate-45 translate-x-4 -translate-y-4"></div>
                                    <div class="flex items-start justify-between mb-3 relative z-10">
                                        <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 font-bold text-xs shadow-inner">RJ</div>
                                        <span class="flex h-2.5 w-2.5 rounded-full bg-rose-500 shadow-[0_0_5px_rgba(244,63,94,0.5)]"></span>
                                    </div>
                                    <div class="text-sm font-bold text-slate-900 relative z-10">Robert Jones</div>
                                    <div class="text-[10px] font-medium text-rose-600 uppercase tracking-wider mt-1 relative z-10">Out of Zone</div>
                                </div>
                            </div>
                            
                            {{-- Manager Override --}}
                            <div class="flex items-center justify-between p-3 bg-white border border-slate-200 rounded-lg shadow-sm border-dashed">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    <span class="text-xs font-bold text-slate-600">Robert check-in failed</span>
                                </div>
                                <button class="px-3 py-1 bg-slate-900 text-white text-[10px] font-bold uppercase tracking-wide rounded hover:bg-slate-800 transition-colors shadow-sm">Override</button>
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
                        <div class="absolute inset-0 bg-gradient-to-tr from-slate-200 to-indigo-100 rounded-3xl transform -rotate-2 scale-105 opacity-60"></div>
                        <div class="bg-white border border-slate-100 shadow-2xl rounded-3xl p-6 relative z-10 flex flex-col gap-6 overflow-hidden">
                            
                            {{-- Global Sync Header --}}
                            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                                <div>
                                    <div class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1 flex items-center gap-2">
                                        <svg class="w-3 h-3 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                        Global Policy Sync
                                    </div>
                                    <div class="text-lg font-bold text-slate-900">Enterprise Propagation</div>
                                </div>
                                <div class="w-24 bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-indigo-500 h-1.5 rounded-full w-2/3 shadow-[0_0_8px_rgba(99,102,241,0.8)] animate-pulse"></div>
                                </div>
                            </div>
                            
                            {{-- Data Matrix --}}
                            <div class="bg-slate-50 border border-slate-200 rounded-xl overflow-hidden shadow-sm">
                                <div class="grid grid-cols-3 bg-slate-100/50 p-2 border-b border-slate-200">
                                    <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Branch</div>
                                    <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest text-center">Nodes</div>
                                    <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest text-right">Status</div>
                                </div>
                                <div class="grid grid-cols-3 p-3 items-center border-b border-slate-100 hover:bg-white transition-colors">
                                    <div class="text-xs font-bold text-slate-900">North America</div>
                                    <div class="text-xs font-mono text-slate-500 text-center">4,205</div>
                                    <div class="text-right"><span class="inline-flex px-1.5 py-0.5 bg-emerald-100 text-emerald-700 text-[10px] font-bold rounded">Synced</span></div>
                                </div>
                                <div class="grid grid-cols-3 p-3 items-center border-b border-slate-100 hover:bg-white transition-colors">
                                    <div class="text-xs font-bold text-slate-900">Europe (EMEA)</div>
                                    <div class="text-xs font-mono text-slate-500 text-center">2,810</div>
                                    <div class="text-right"><span class="inline-flex px-1.5 py-0.5 bg-emerald-100 text-emerald-700 text-[10px] font-bold rounded">Synced</span></div>
                                </div>
                                <div class="grid grid-cols-3 p-3 items-center hover:bg-white transition-colors bg-indigo-50/30">
                                    <div class="text-xs font-bold text-indigo-900">Asia Pacific</div>
                                    <div class="text-xs font-mono text-indigo-600 text-center flex items-center justify-center gap-1">
                                        <svg class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                        1,950
                                    </div>
                                    <div class="text-right"><span class="inline-flex px-1.5 py-0.5 bg-indigo-100 text-indigo-700 text-[10px] font-bold rounded animate-pulse">Syncing...</span></div>
                                </div>
                            </div>
                            
                            {{-- Live Audit Stream --}}
                            <div class="pt-2">
                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Live Audit Stream</div>
                                <div class="space-y-3 relative before:absolute before:inset-0 before:ml-2 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-200 before:to-transparent">
                                    <div class="relative flex items-center justify-between group">
                                        <div class="flex items-center gap-3 w-full">
                                            <div class="w-4 h-4 rounded-full bg-slate-800 border-2 border-white shadow-sm flex items-center justify-center z-10"><div class="w-1.5 h-1.5 bg-white rounded-full"></div></div>
                                            <div class="flex-1 bg-slate-50 border border-slate-100 rounded-lg p-2 flex items-center justify-between hover:bg-white transition-colors cursor-pointer">
                                                <div class="text-[11px] font-medium text-slate-600"><span class="font-bold text-slate-900">SysAdmin</span> updated role <span class="font-mono text-indigo-600 bg-indigo-50 px-1 rounded font-bold">Floor_Mgr</span></div>
                                                <div class="text-[9px] text-slate-400 font-bold uppercase">2m ago</div>
                                            </div>
                                        </div>
                                    </div>
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
        heading="Ready to elevate your"
        headingHighlight="workforce?"
        subtext="See these features in action by talking to our team or signing up today."
    >
        <x-slot name="buttons">
            <x-ui.button variant="secondary" href="/contact" class="w-full sm:w-auto">Contact Us</x-ui.button>
            <x-ui.button href="{{ route('frontend.book-demo') }}" class="w-full sm:w-auto">Book a demo</x-ui.button>
        </x-slot>
    </x-marketing.cta-interruption>

    {{-- Section 5: Core Platform Capabilities (Carousel) --}}
    <section class="py-16 lg:py-32 bg-slate-50 relative border-t border-slate-100 overflow-hidden">
        <div class="container mx-auto px-6 lg:px-8 xl:px-12 2xl:max-w-[1440px] relative z-10">
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-sm font-bold tracking-wide mb-4 border border-blue-100">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                    The Platform Engine
                </div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-indigo-100 text-indigo-700 text-sm font-bold rounded-lg w-fit tracking-wide mb-6 mx-auto">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Feature Overview
                </div>
                <h2 class="text-3xl md:text-5xl font-extrabold text-slate-900 tracking-tight mb-6">
                    Compare at a glance
                </h2>
                <p class="text-lg text-slate-500 max-w-2xl mx-auto mb-4">
                    Explore all the powerful tools and capabilities that make timeNest the ultimate platform for managing your work, teams, and projects.
                </p>
                <div class="flex items-center justify-center gap-2 text-sm text-slate-400 font-bold uppercase tracking-widest mt-8 animate-pulse">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/></svg>
                    Swipe to explore
                </div>
            </div>
                       {{-- Horizontal Scroll Carousel --}}
            
            <!-- Owl Carousel Dependencies -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
            
            <style>
                /* Make owl items flex so they stretch to equal height */
                .owl-stage {
                    display: flex;
                }
                .owl-item {
                    display: flex;
                    flex: 1 0 auto;
                }
                .owl-item > div {
                    width: 100%;
                }
                /* Custom dots styling */
                .owl-theme .owl-dots .owl-dot span {
                    width: 8px;
                    height: 8px;
                    margin: 5px 6px;
                    background: #cbd5e1 !important;
                    display: block;
                    border-radius: 50%;
                    transition: all 0.3s ease;
                }
                .owl-theme .owl-dots .owl-dot.active span {
                    width: 32px;
                    background: #4f46e5 !important;
                    border-radius: 4px;
                }
                
                /* Reorder nav and dots */
                .owl-carousel {
                    display: flex !important;
                    flex-direction: column !important;
                }
                .owl-carousel .owl-stage-outer {
                    order: 1;
                }
                .owl-theme .owl-dots {
                    order: 2;
                    margin-top: 32px !important;
                }
                .owl-theme .owl-nav {
                    order: 3;
                    margin-top: 32px !important;
                }
                /* Custom nav styling */
                .owl-theme .owl-dots {
                    margin-top: 32px !important;
                }
                .owl-theme .owl-nav {
                    margin-top: 32px;
                    display: flex;
                    justify-content: center;
                    gap: 12px;
                }
                .owl-theme .owl-nav [class*='owl-'] {
                    margin: 0;
                    padding: 0;
                    background: transparent;
                }
                .owl-theme .owl-nav [class*='owl-']:hover {
                    background: transparent;
                }
                .custom-nav-btn {
                    width: 40px;
                    height: 40px;
                    border-radius: 9999px;
                    border: 1px solid #e2e8f0;
                    background-color: #ffffff;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: #475569;
                    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
                    transition: all 0.2s ease;
                }
                .custom-nav-btn:hover {
                    color: #4f46e5;
                    border-color: #c7d2fe;
                    background-color: #eef2ff;
                }
            </style>

            <div class="owl-carousel owl-theme mt-8" id="features-carousel">

                {{-- Card 1: Time & Project Tracking --}}
                <div class="item h-full pb-8 pt-4">
                    <div class="relative h-full bg-gradient-to-br from-white via-white to-indigo-50 rounded-[32px] border border-slate-200 hover:-translate-y-2 transition-all duration-500 overflow-hidden flex flex-col group">
                        
                        <div class="relative flex-1 p-6 md:p-8 flex flex-col justify-between">
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold rounded-lg w-fit tracking-wide mb-6">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Everyday Use
                            </div>

                            <div class="flex-grow flex flex-col lg:flex-row items-center gap-6">
                                <div class="w-full lg:w-[45%] relative z-10 flex flex-col h-full justify-center">
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="w-12 h-12 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-center justify-center p-2">
                                            <svg class="w-6 h-6 text-slate-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-2xl font-bold text-slate-900">Time & Project Tracking</h3>
                                    </div>
                                    <p class="text-slate-500 text-sm leading-relaxed font-medium mb-6">
                                        Log hours against specific projects, whether you're working solo or as part of a full team. It's the same tracking foundation across every tier — nothing changes as you grow, only what's built on top of it does.
                                    </p>
                                    <div class="mt-auto pt-2">
                                        <x-ui.button href="{{ route('frontend.book-demo') }}">Book a demo</x-ui.button>
                                    </div>
                                </div>
                                
                                <div class="w-full lg:w-[55%] relative h-full min-h-[220px] flex items-center justify-center p-4 mt-6 lg:mt-0 perspective-1000">
                                    
                                    <!-- Tilted Image Wrapper -->
                                    <div class="relative z-10 w-full max-w-[240px] transform transition-all duration-700 -rotate-3 group-hover:rotate-0 group-hover:scale-105 group-hover:-translate-y-2">
                                        <div class="relative rounded-2xl overflow-hidden shadow-2xl border-[6px] border-white/80 bg-white">
                                            <img src="https://images.unsplash.com/photo-1497215728101-856f4ea42174?w=800&auto=format&fit=crop&q=80" class="w-full aspect-[4/3] object-cover object-center transform transition-transform duration-1000 group-hover:scale-110" alt="Time & Project Tracking">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Card 2: Daily Worklogs --}}
                <div class="item h-full pb-8 pt-4">
                    <div class="relative h-full bg-gradient-to-br from-white via-white to-rose-50 rounded-[32px] border border-slate-200 hover:-translate-y-2 transition-all duration-500 overflow-hidden flex flex-col group">
                        
                        <div class="relative flex-1 p-6 md:p-8 flex flex-col justify-between">
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-rose-100 text-rose-700 text-xs font-bold rounded-lg w-fit tracking-wide mb-6">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Task-Level Detail
                            </div>

                            <div class="flex-grow flex flex-col lg:flex-row items-center gap-6">
                                <div class="w-full lg:w-[45%] relative z-10 flex flex-col h-full justify-center">
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="w-12 h-12 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-center justify-center p-2">
                                            <svg class="w-6 h-6 text-slate-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                            </svg>
                                        </div>
                                        <h3 class="text-2xl font-bold text-slate-900">Daily Worklogs</h3>
                                    </div>
                                    <p class="text-slate-500 text-sm leading-relaxed font-medium mb-6">
                                        Tie logged hours to real task and project context instead of a bare timestamp. Managers see what was actually worked on each day, and employees get a running record they can refer back to.
                                    </p>
                                    <div class="mt-auto pt-2">
                                        <x-ui.button href="/contact">Let's Talk</x-ui.button>
                                    </div>
                                </div>
                                
                                <div class="w-full lg:w-[55%] relative h-full min-h-[220px] flex items-center justify-center p-4 mt-6 lg:mt-0 perspective-1000">
                                    
                                    <!-- Tilted Image Wrapper -->
                                    <div class="relative z-10 w-full max-w-[240px] transform transition-all duration-700 -rotate-3 group-hover:rotate-0 group-hover:scale-105 group-hover:-translate-y-2">
                                        <div class="relative rounded-2xl overflow-hidden shadow-2xl border-[6px] border-white/80 bg-white">
                                            <img src="https://images.unsplash.com/photo-1517048676732-d65bc937f952?w=800&auto=format&fit=crop&q=80" class="w-full aspect-[4/3] object-cover object-center transform transition-transform duration-1000 group-hover:scale-110" alt="Daily Worklogs">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Card 3: Geo-Fenced Attendance --}}
                <div class="item h-full pb-8 pt-4">
                    <div class="relative h-full bg-gradient-to-br from-white via-white to-emerald-50 rounded-[32px] border border-slate-200 hover:-translate-y-2 transition-all duration-500 overflow-hidden flex flex-col group">
                        
                        <div class="relative flex-1 p-6 md:p-8 flex flex-col justify-between">
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-lg w-fit tracking-wide mb-6">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Precision Location
                            </div>

                            <div class="flex-grow flex flex-col lg:flex-row items-center gap-6">
                                <div class="w-full lg:w-[45%] relative z-10 flex flex-col h-full justify-center">
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="w-12 h-12 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-center justify-center p-2">
                                            <svg class="w-6 h-6 text-slate-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-2xl font-bold text-slate-900">Geo-Fenced Attendance</h3>
                                    </div>
                                    <p class="text-slate-500 text-sm leading-relaxed font-medium mb-6">
                                        Set a configurable check-in radius per branch, and TimeNest only accepts an attendance mark when someone is actually within range. Multiple branches can each run their own independent radius and rules.
                                    </p>
                                    <div class="mt-auto pt-2">
                                        <x-ui.button href="/contact">Get in Touch</x-ui.button>
                                    </div>
                                </div>
                                
                                <div class="w-full lg:w-[55%] relative h-full min-h-[220px] flex items-center justify-center p-4 mt-6 lg:mt-0 perspective-1000">
                                    
                                    <!-- Tilted Image Wrapper -->
                                    <div class="relative z-10 w-full max-w-[240px] transform transition-all duration-700 -rotate-3 group-hover:rotate-0 group-hover:scale-105 group-hover:-translate-y-2">
                                        <div class="relative rounded-2xl overflow-hidden shadow-2xl border-[6px] border-white/80 bg-white">
                                            <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?w=800&auto=format&fit=crop&q=80" class="w-full aspect-[4/3] object-cover object-center transform transition-transform duration-1000 group-hover:scale-110" alt="Geo-Fenced Attendance">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Card 4: Leave Management --}}
                <div class="item h-full pb-8 pt-4">
                    <div class="relative h-full bg-gradient-to-br from-white via-white to-amber-50 rounded-[32px] border border-slate-200 hover:-translate-y-2 transition-all duration-500 overflow-hidden flex flex-col group">
                        
                        <div class="relative flex-1 p-6 md:p-8 flex flex-col justify-between">
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold rounded-lg w-fit tracking-wide mb-6">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Policy Safe
                            </div>

                            <div class="flex-grow flex flex-col lg:flex-row items-center gap-6">
                                <div class="w-full lg:w-[45%] relative z-10 flex flex-col h-full justify-center">
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="w-12 h-12 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-center justify-center p-2">
                                            <svg class="w-6 h-6 text-slate-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-2xl font-bold text-slate-900">Leave Management</h3>
                                    </div>
                                    <p class="text-slate-500 text-sm leading-relaxed font-medium mb-6">
                                        Define the leave types and balances your organization actually offers, with full policy versioning underneath. When a policy changes, past approvals stay exactly as they were — only new requests follow the update.
                                    </p>
                                    <div class="mt-auto pt-2">
                                        <x-ui.button href="/contact">Talk to Sales</x-ui.button>
                                    </div>
                                </div>
                                
                                <div class="w-full lg:w-[55%] relative h-full min-h-[220px] flex items-center justify-center p-4 mt-6 lg:mt-0 perspective-1000">
                                    
                                    <!-- Tilted Image Wrapper -->
                                    <div class="relative z-10 w-full max-w-[240px] transform transition-all duration-700 -rotate-3 group-hover:rotate-0 group-hover:scale-105 group-hover:-translate-y-2">
                                        <div class="relative rounded-2xl overflow-hidden shadow-2xl border-[6px] border-white/80 bg-white">
                                            <img src="https://images.unsplash.com/photo-1506784951206-396260171bd4?w=800&auto=format&fit=crop&q=80" class="w-full aspect-[4/3] object-cover object-center transform transition-transform duration-1000 group-hover:scale-110" alt="Leave Management">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Card 5: Approval Workflows --}}
                <div class="item h-full pb-8 pt-4">
                    <div class="relative h-full bg-gradient-to-br from-white via-white to-fuchsia-50 rounded-[32px] border border-slate-200 hover:-translate-y-2 transition-all duration-500 overflow-hidden flex flex-col group">
                        
                        <div class="relative flex-1 p-6 md:p-8 flex flex-col justify-between">
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-fuchsia-100 text-fuchsia-700 text-xs font-bold rounded-lg w-fit tracking-wide mb-6">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                </svg>
                                Fully Configurable
                            </div>

                            <div class="flex-grow flex flex-col lg:flex-row items-center gap-6">
                                <div class="w-full lg:w-[45%] relative z-10 flex flex-col h-full justify-center">
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="w-12 h-12 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-center justify-center p-2">
                                            <svg class="w-6 h-6 text-slate-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                                            </svg>
                                        </div>
                                        <h3 class="text-2xl font-bold text-slate-900">Approval Workflows</h3>
                                    </div>
                                    <p class="text-slate-500 text-sm leading-relaxed font-medium mb-6">
                                        Choose auto-approval, a single sign-off, or a full multi-level chain — per policy, not platform-wide. Requests route to the person someone actually reports to, with a department-head fallback if needed.
                                    </p>
                                    <div class="mt-auto pt-2">
                                        <x-ui.button href="/contact">Reach out</x-ui.button>
                                    </div>
                                </div>
                                
                                <div class="w-full lg:w-[55%] relative h-full min-h-[220px] flex items-center justify-center p-4 mt-6 lg:mt-0 perspective-1000">
                                    
                                    <!-- Tilted Image Wrapper -->
                                    <div class="relative z-10 w-full max-w-[240px] transform transition-all duration-700 -rotate-3 group-hover:rotate-0 group-hover:scale-105 group-hover:-translate-y-2">
                                        <div class="relative rounded-2xl overflow-hidden shadow-2xl border-[6px] border-white/80 bg-white">
                                            <img src="https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=800&auto=format&fit=crop&q=80" class="w-full aspect-[4/3] object-cover object-center transform transition-transform duration-1000 group-hover:scale-110" alt="Approval Workflows">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Card 6: Departments & Hierarchy --}}
                <div class="item h-full pb-8 pt-4">
                    <div class="relative h-full bg-gradient-to-br from-white via-white to-blue-50 rounded-[32px] border border-slate-200 hover:-translate-y-2 transition-all duration-500 overflow-hidden flex flex-col group">
                        
                        <div class="relative flex-1 p-6 md:p-8 flex flex-col justify-between">
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-lg w-fit tracking-wide mb-6">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Enterprise Structure
                            </div>

                            <div class="flex-grow flex flex-col lg:flex-row items-center gap-6">
                                <div class="w-full lg:w-[45%] relative z-10 flex flex-col h-full justify-center">
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="w-12 h-12 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-center justify-center p-2">
                                            <svg class="w-6 h-6 text-slate-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-2xl font-bold text-slate-900">Departments & Hierarchy</h3>
                                    </div>
                                    <p class="text-slate-500 text-sm leading-relaxed font-medium mb-6">
                                        Model departments, sub-departments, designations, and real reporting lines — the structure your organization actually has, not a flattened version of it. Every approval and permission check respects this hierarchy.
                                    </p>
                                    <div class="mt-auto pt-2">
                                        <x-ui.button href="{{ route('frontend.book-demo') }}">Book a demo</x-ui.button>
                                    </div>
                                </div>
                                
                                <div class="w-full lg:w-[55%] relative h-full min-h-[220px] flex items-center justify-center p-4 mt-6 lg:mt-0 perspective-1000">
                                    
                                    <!-- Tilted Image Wrapper -->
                                    <div class="relative z-10 w-full max-w-[240px] transform transition-all duration-700 -rotate-3 group-hover:rotate-0 group-hover:scale-105 group-hover:-translate-y-2">
                                        <div class="relative rounded-2xl overflow-hidden shadow-2xl border-[6px] border-white/80 bg-white">
                                            <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&auto=format&fit=crop&q=80" class="w-full aspect-[4/3] object-cover object-center transform transition-transform duration-1000 group-hover:scale-110" alt="Departments & Hierarchy">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Card 7: Two-Factor Authentication --}}
                <div class="item h-full pb-8 pt-4">
                    <div class="relative h-full bg-gradient-to-br from-white via-white to-teal-50 rounded-[32px] border border-slate-200 hover:-translate-y-2 transition-all duration-500 overflow-hidden flex flex-col group">
                        
                        <div class="relative flex-1 p-6 md:p-8 flex flex-col justify-between">
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-teal-100 text-teal-700 text-xs font-bold rounded-lg w-fit tracking-wide mb-6">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                Extra Layer
                            </div>

                            <div class="flex-grow flex flex-col lg:flex-row items-center gap-6">
                                <div class="w-full lg:w-[45%] relative z-10 flex flex-col h-full justify-center">
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="w-12 h-12 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-center justify-center p-2">
                                            <svg class="w-6 h-6 text-slate-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-2xl font-bold text-slate-900">Two-Factor Authentication</h3>
                                    </div>
                                    <p class="text-slate-500 text-sm leading-relaxed font-medium mb-6">
                                        Add a rotating verification code on top of a password for any account that wants it. A stolen or guessed password alone is never enough to get into someone's TimeNest account.
                                    </p>
                                    <div class="mt-auto pt-2">
                                        <x-ui.button href="/contact">Let's Talk</x-ui.button>
                                    </div>
                                </div>
                                
                                <div class="w-full lg:w-[55%] relative h-full min-h-[220px] flex items-center justify-center p-4 mt-6 lg:mt-0 perspective-1000">
                                    
                                    <!-- Tilted Image Wrapper -->
                                    <div class="relative z-10 w-full max-w-[240px] transform transition-all duration-700 -rotate-3 group-hover:rotate-0 group-hover:scale-105 group-hover:-translate-y-2">
                                        <div class="relative rounded-2xl overflow-hidden shadow-2xl border-[6px] border-white/80 bg-white">
                                            <img src="https://images.unsplash.com/photo-1563986768609-322da13575f3?w=800&auto=format&fit=crop&q=80" class="w-full aspect-[4/3] object-cover object-center transform transition-transform duration-1000 group-hover:scale-110" alt="Two-Factor Authentication">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Card 8: Custom Roles & Permissions --}}
                <div class="item h-full pb-8 pt-4">
                    <div class="relative h-full bg-gradient-to-br from-white via-white to-violet-50 rounded-[32px] border border-slate-200 hover:-translate-y-2 transition-all duration-500 overflow-hidden flex flex-col group">
                        
                        <div class="relative flex-1 p-6 md:p-8 flex flex-col justify-between">
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-violet-100 text-violet-700 text-xs font-bold rounded-lg w-fit tracking-wide mb-6">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                Granular Control
                            </div>

                            <div class="flex-grow flex flex-col lg:flex-row items-center gap-6">
                                <div class="w-full lg:w-[45%] relative z-10 flex flex-col h-full justify-center">
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="w-12 h-12 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-center justify-center p-2">
                                            <svg class="w-6 h-6 text-slate-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                                            </svg>
                                        </div>
                                        <h3 class="text-2xl font-bold text-slate-900">Custom Roles & Permissions</h3>
                                    </div>
                                    <p class="text-slate-500 text-sm leading-relaxed font-medium mb-6">
                                        Build roles with permission-by-permission precision, configurable independently by each organization. Nothing about who can see or approve what is hardcoded into the platform.
                                    </p>
                                    <div class="mt-auto pt-2">
                                        <x-ui.button href="/contact">Get in Touch</x-ui.button>
                                    </div>
                                </div>
                                
                                <div class="w-full lg:w-[55%] relative h-full min-h-[220px] flex items-center justify-center p-4 mt-6 lg:mt-0 perspective-1000">
                                    
                                    <!-- Tilted Image Wrapper -->
                                    <div class="relative z-10 w-full max-w-[240px] transform transition-all duration-700 -rotate-3 group-hover:rotate-0 group-hover:scale-105 group-hover:-translate-y-2">
                                        <div class="relative rounded-2xl overflow-hidden shadow-2xl border-[6px] border-white/80 bg-white">
                                            <img src="https://images.unsplash.com/photo-1550565118-3a14e8d0386f?w=800&auto=format&fit=crop&q=80" class="w-full aspect-[4/3] object-cover object-center transform transition-transform duration-1000 group-hover:scale-110" alt="Custom Roles & Permissions">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Card 9: Organization-Scoped Chat --}}
                <div class="item h-full pb-8 pt-4">
                    <div class="relative h-full bg-gradient-to-br from-white via-white to-orange-50 rounded-[32px] border border-slate-200 hover:-translate-y-2 transition-all duration-500 overflow-hidden flex flex-col group">
                        
                        <div class="relative flex-1 p-6 md:p-8 flex flex-col justify-between">
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-orange-100 text-orange-700 text-xs font-bold rounded-lg w-fit tracking-wide mb-6">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                Always Included
                            </div>

                            <div class="flex-grow flex flex-col lg:flex-row items-center gap-6">
                                <div class="w-full lg:w-[45%] relative z-10 flex flex-col h-full justify-center">
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="w-12 h-12 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-center justify-center p-2">
                                            <svg class="w-6 h-6 text-slate-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-2xl font-bold text-slate-900">Organization-Scoped Chat</h3>
                                    </div>
                                    <p class="text-slate-500 text-sm leading-relaxed font-medium mb-6">
                                        Every conversation is encrypted in transit and scoped strictly to members within your organization. It ships as part of TimeNest at every tier, not as a separate purchase or a bolt-on app.
                                    </p>
                                    <div class="mt-auto pt-2">
                                        <x-ui.button href="/contact">Talk to Sales</x-ui.button>
                                    </div>
                                </div>
                                
                                <div class="w-full lg:w-[55%] relative h-full min-h-[220px] flex items-center justify-center p-4 mt-6 lg:mt-0 perspective-1000">
                                    
                                    <!-- Tilted Image Wrapper -->
                                    <div class="relative z-10 w-full max-w-[240px] transform transition-all duration-700 -rotate-3 group-hover:rotate-0 group-hover:scale-105 group-hover:-translate-y-2">
                                        <div class="relative rounded-2xl overflow-hidden shadow-2xl border-[6px] border-white/80 bg-white">
                                            <img src="https://images.unsplash.com/photo-1611162617213-7d7a39e9b1d7?w=800&auto=format&fit=crop&q=80" class="w-full aspect-[4/3] object-cover object-center transform transition-transform duration-1000 group-hover:scale-110" alt="Organization-Scoped Chat">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Card 10: Shift Management --}}
                <div class="item h-full pb-8 pt-4">
                    <div class="relative h-full bg-gradient-to-br from-white via-white to-cyan-50 rounded-[32px] border border-slate-200 hover:-translate-y-2 transition-all duration-500 overflow-hidden flex flex-col group">
                        
                        <div class="relative flex-1 p-6 md:p-8 flex flex-col justify-between">
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-cyan-100 text-cyan-700 text-xs font-bold rounded-lg w-fit tracking-wide mb-6">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Coming Soon
                            </div>

                            <div class="flex-grow flex flex-col lg:flex-row items-center gap-6">
                                <div class="w-full lg:w-[45%] relative z-10 flex flex-col h-full justify-center">
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="w-12 h-12 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-center justify-center p-2">
                                            <svg class="w-6 h-6 text-slate-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2zM12 12v4l3 3" />
                                            </svg>
                                        </div>
                                        <h3 class="text-2xl font-bold text-slate-900">Shift Management</h3>
                                    </div>
                                    <p class="text-slate-500 text-sm leading-relaxed font-medium mb-6">
                                        Plan, assign, and manage shifts across your whole team from a single view, currently in active development. It'll sit directly on top of the attendance and approval system TimeNest already runs on.
                                    </p>
                                    <div class="mt-auto pt-2">
                                        <x-ui.button href="/contact">Reach out</x-ui.button>
                                    </div>
                                </div>
                                
                                <div class="w-full lg:w-[55%] relative h-full min-h-[220px] flex items-center justify-center p-4 mt-6 lg:mt-0 perspective-1000">
                                    
                                    <!-- Tilted Image Wrapper -->
                                    <div class="relative z-10 w-full max-w-[240px] transform transition-all duration-700 -rotate-3 group-hover:rotate-0 group-hover:scale-105 group-hover:-translate-y-2">
                                        <div class="relative rounded-2xl overflow-hidden shadow-2xl border-[6px] border-white/80 bg-white">
                                            <img src="https://images.unsplash.com/photo-1588600878108-578307a3cc9d?w=800&auto=format&fit=crop&q=80" class="w-full aspect-[4/3] object-cover object-center transform transition-transform duration-1000 group-hover:scale-110" alt="Shift Management">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Card 11: Advanced Reporting --}}
                <div class="item h-full pb-8 pt-4">
                    <div class="relative h-full bg-gradient-to-br from-white via-white to-pink-50 rounded-[32px] border border-slate-200 hover:-translate-y-2 transition-all duration-500 overflow-hidden flex flex-col group">
                        
                        <div class="relative flex-1 p-6 md:p-8 flex flex-col justify-between">
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-pink-100 text-pink-700 text-xs font-bold rounded-lg w-fit tracking-wide mb-6">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Coming Soon
                            </div>

                            <div class="flex-grow flex flex-col lg:flex-row items-center gap-6">
                                <div class="w-full lg:w-[45%] relative z-10 flex flex-col h-full justify-center">
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="w-12 h-12 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-center justify-center p-2">
                                            <svg class="w-6 h-6 text-slate-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-2xl font-bold text-slate-900">Advanced Reporting</h3>
                                    </div>
                                    <p class="text-slate-500 text-sm leading-relaxed font-medium mb-6">
                                        Deeper insights and exportable reports across attendance, leave, and worklogs, currently in active development. Built to turn the data TimeNest already collects into something you can actually act on.
                                    </p>
                                    <div class="mt-auto pt-2">
                                        <x-ui.button href="{{ route('frontend.book-demo') }}">Book a demo</x-ui.button>
                                    </div>
                                </div>
                                
                                <div class="w-full lg:w-[55%] relative h-full min-h-[220px] flex items-center justify-center p-4 mt-6 lg:mt-0 perspective-1000">
                                    
                                    <!-- Tilted Image Wrapper -->
                                    <div class="relative z-10 w-full max-w-[240px] transform transition-all duration-700 -rotate-3 group-hover:rotate-0 group-hover:scale-105 group-hover:-translate-y-2">
                                        <div class="relative rounded-2xl overflow-hidden shadow-2xl border-[6px] border-white/80 bg-white">
                                            <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&auto=format&fit=crop&q=80" class="w-full aspect-[4/3] object-cover object-center transform transition-transform duration-1000 group-hover:scale-110" alt="Advanced Reporting">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ensure jQuery is loaded before Owl -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
            <script>
                $(document).ready(function(){
                    $("#features-carousel").owlCarousel({
                        loop: false,
                        margin: 24,
                        nav: true,
                        dots: true,
                        navText: [
                            '<div class="custom-nav-btn"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg></div>',
                            '<div class="custom-nav-btn"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg></div>'
                        ],
                        responsive: {
                            0: { items: 1 },
                            768: { items: 1 },
                            1024: { items: 2 }
                        }
                    });
                });
            </script>

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
