@extends('layouts.marketing')

@section('content')
    <x-marketing.header />
    
    <main class="marketing-responsive-sections">
        {{-- 1. Hero Section --}}
        <section class="relative pt-32 pb-20 px-30 md:pt-40 md:pb-28 overflow-hidden bg-slate-950">
            <x-marketing.hero-background />
            
            <div class="relative z-10 max-w-7xl mx-auto px-6 text-center animate-fade-up">
                <div class="flex justify-center mb-6">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-white/80 text-xs font-semibold tracking-wide uppercase mb-6 border border-white/20">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        Security
                    </div>
                </div>
                
                <h1 class="text-5xl md:text-7xl font-extrabold text-white tracking-tight leading-[1.1] mb-6">
                    Built to Protect <br class="hidden sm:block" />
                    Every Team, Every Record
                </h1>
                
                <p class="text-lg md:text-xl text-slate-400 max-w-3xl mx-auto leading-relaxed mb-12">
                    TimeNest keeps every organization's data isolated, every login verified, and every action logged — so security isn't something you have to take on faith.
                </p>
                
                <div class="flex flex-wrap items-center justify-center gap-6 md:gap-10 text-slate-300 font-bold text-sm md:text-base border-t border-slate-700/50 pt-8 mt-4 max-w-4xl mx-auto">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Encrypted Sessions
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        Tenant Isolation
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Role-Based Access
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Full Audit Trail
                    </div>
                </div>
            </div>
        </section>

        {{-- 2. Authentication & Account Protection --}}
        <section class="py-16 lg:py-20 bg-slate-50 border-t border-slate-100">
            <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-accent-50 text-accent-600 text-xs font-semibold tracking-wide uppercase mb-6 border border-accent-100">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        JWT & TOTP
                    </div>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6 tracking-tight">Every login is verified — every time</h2>
                    <p class="text-lg text-slate-600 mb-6 leading-relaxed">
                        When someone signs in to TimeNest, we don't just check a password. Every session is issued a secure, time-limited token, and organizations can require a second verification step — a rotating code from an authenticator app — before access is granted. Lost or stolen passwords alone are never enough to get in.
                    </p>
                    
                    <ul class="space-y-8">
                        <li class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-full bg-accent-100 text-accent-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span class="text-slate-700 font-semibold mt-1">Session tokens expire automatically</span>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <span class="text-slate-700 font-semibold mt-1">Optional two-factor authentication per account</span>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m14-6h2m-2 6h2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>
                            </div>
                            <span class="text-slate-700 font-semibold mt-1">Every device that logs in is tracked and can be revoked</span>
                        </li>
                    </ul>
                </div>
                
                {{-- Mockup of 2FA Input --}}
                <div class="relative w-full max-w-md mx-auto">
                    <div class="absolute inset-0 bg-accent-600/5 rounded-full filter blur-3xl transform translate-y-10 scale-90"></div>
                    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 p-8 relative z-10">
                        <div class="w-12 h-12 bg-accent-50 border border-accent-100 rounded-xl flex items-center justify-center mb-6 shadow-sm">
                            <svg class="w-6 h-6 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path></svg>
                        </div>
                        <h3 class="text-xl font-extrabold text-slate-900 mb-2">Two-Factor Authentication</h3>
                        <p class="text-slate-500 text-sm mb-6">Enter the 6-digit code from your authenticator app.</p>
                        
                        <div class="flex gap-2 justify-between mb-8">
                            <div class="w-10 md:w-12 h-14 rounded-xl border border-slate-200 bg-slate-50 flex items-center justify-center text-2xl font-bold text-slate-700 shadow-inner">4</div>
                            <div class="w-10 md:w-12 h-14 rounded-xl border border-slate-200 bg-slate-50 flex items-center justify-center text-2xl font-bold text-slate-700 shadow-inner">8</div>
                            <div class="w-10 md:w-12 h-14 rounded-xl border border-slate-200 bg-slate-50 flex items-center justify-center text-2xl font-bold text-slate-700 shadow-inner">1</div>
                            <div class="w-10 md:w-12 h-14 rounded-xl border-accent-500 border-2 bg-white flex items-center justify-center text-2xl font-bold text-slate-900 shadow-sm shadow-indigo-100 relative">
                                <span class="animate-pulse block w-px h-6 bg-accent-500"></span>
                            </div>
                            <div class="w-10 md:w-12 h-14 rounded-xl border border-slate-200 bg-slate-50 flex items-center justify-center shadow-inner"></div>
                            <div class="w-10 md:w-12 h-14 rounded-xl border border-slate-200 bg-slate-50 flex items-center justify-center shadow-inner"></div>
                        </div>
                        
                        <button class="w-full bg-slate-900 text-white rounded-xl py-3.5 font-bold hover:bg-black transition-colors shadow-lg">Verify & Sign In</button>
                    </div>
                </div>
            </div>
        </section>

        {{-- 3. Multi-Tenant Data Isolation --}}
        <section class="py-16 lg:py-20 bg-white overflow-hidden">
            <div class="max-w-7xl mx-auto px-6 text-center">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-accent-50 text-accent-600 text-xs font-semibold tracking-wide uppercase mb-6 border border-accent-100">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    Enforced Layer
                </div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6 tracking-tight">Your organization's data never mixes with anyone else's</h2>
                <p class="text-lg text-slate-600 max-w-3xl mx-auto mb-16 leading-relaxed">
                    TimeNest runs many organizations on one platform, but every one of them operates inside its own walled-off space. Attendance records, leave requests, chat messages, employee data — none of it is ever visible or reachable from another organization, even by accident. This isn't a setting you turn on. It's checked on every single request.
                </p>
                
                {{-- Isolation Diagram --}}
                <div class="flex flex-col md:flex-row items-stretch justify-center gap-6 max-w-5xl mx-auto relative">
                    
                    {{-- Org 1 --}}
                    <div class="bg-white border-2 border-slate-100 rounded-3xl p-8 shadow-sm flex-1 w-full relative transform transition-transform hover:-translate-y-1">
                        <div class="w-full flex justify-center mb-6">
                            <div class="w-12 h-12 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                        </div>
                        <h4 class="font-bold text-slate-800 mb-6 border-b border-slate-100 pb-4">Acme Corp Data</h4>
                        <div class="flex justify-center gap-4 text-slate-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"></path></svg>
                        </div>
                    </div>
                    
                    {{-- Visual Spacer (Not Connected) --}}
                    <div class="hidden md:flex flex-col items-center justify-center px-2">
                        <div class="w-1 h-32 border-r-[3px] border-dashed border-slate-200"></div>
                    </div>
                    
                    {{-- Org 2 (Your Org) --}}
                    <div class="bg-accent-50 border-2 border-accent-200 rounded-3xl p-8 shadow-lg flex-1 w-full relative transform scale-105 z-10">
                        <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-accent-600 text-white text-[11px] font-bold px-3 py-1 rounded-full shadow-sm whitespace-nowrap">Your Organization</div>
                        <div class="w-full flex justify-center mb-6 mt-2">
                            <div class="w-12 h-12 rounded-xl bg-accent-100 border border-accent-200 flex items-center justify-center text-accent-600 shadow-inner">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            </div>
                        </div>
                        <h4 class="font-bold text-indigo-950 mb-6 border-b border-accent-100 pb-4">TimeNest Vault</h4>
                        <div class="flex justify-center gap-4 text-accent-400">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"></path></svg>
                        </div>
                    </div>
                    
                    {{-- Visual Spacer --}}
                    <div class="hidden md:flex flex-col items-center justify-center px-2">
                        <div class="w-1 h-32 border-r-[3px] border-dashed border-slate-200"></div>
                    </div>
                    
                    {{-- Org 3 --}}
                    <div class="bg-white border-2 border-slate-100 rounded-3xl p-8 shadow-sm flex-1 w-full relative transform transition-transform hover:-translate-y-1">
                        <div class="w-full flex justify-center mb-6">
                            <div class="w-12 h-12 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                            </div>
                        </div>
                        <h4 class="font-bold text-slate-800 mb-6 border-b border-slate-100 pb-4">Global Tech Data</h4>
                        <div class="flex justify-center gap-4 text-slate-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"></path></svg>
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>

        {{-- 4. Roles & Permissions --}}
        <section class="py-16 lg:py-20 bg-slate-50 border-y border-slate-100">
            <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                {{-- Right side goes first on mobile --}}
                <div class="order-2 lg:order-1">
                    {{-- Mock Permissions Table (Revamped) --}}
                    <div class="bg-white rounded-[2rem] shadow-2xl shadow-slate-200/40 border border-slate-100 overflow-hidden relative">
                        {{-- Header --}}
                        <div class="p-8 border-b border-slate-100 bg-slate-50/80 flex items-center justify-between">
                            <div>
                                <h3 class="font-bold text-slate-900 text-lg">Default Roles</h3>
                                <p class="text-sm text-slate-500 mt-1">Can be customized per workspace</p>
                            </div>
                            <div class="h-8 w-8 rounded-full bg-accent-100 text-accent-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                            </div>
                        </div>

                        <div class="p-2">
                            <table class="w-full text-left text-sm border-separate border-spacing-y-3">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-6 font-bold text-slate-400 tracking-wider uppercase text-[11px]">Role Level</th>
                                        <th class="py-2 px-4 font-bold text-slate-400 tracking-wider uppercase text-[11px] text-center w-32">
                                            <div class="flex items-center justify-center gap-1.5">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                View
                                            </div>
                                        </th>
                                        <th class="py-2 px-4 font-bold text-slate-400 tracking-wider uppercase text-[11px] text-center w-32">
                                            <div class="flex items-center justify-center gap-1.5">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                Approve
                                            </div>
                                        </th>
                                        <th class="py-2 px-4 font-bold text-slate-400 tracking-wider uppercase text-[11px] text-center w-32">
                                            <div class="flex items-center justify-center gap-1.5">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                Manage
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Admin --}}
                                    <tr class="group bg-slate-50/50 hover:bg-slate-50 transition-colors shadow-sm border border-slate-100">
                                        <td class="py-4 px-6 rounded-l-2xl border-y border-l border-slate-200/60 bg-white">
                                            <div class="flex items-center gap-4">
                                                <div class="w-12 h-12 rounded-xl bg-accent-50 border border-accent-100 text-accent-600 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </div>
                                                <div>
                                                    <div class="font-extrabold text-slate-900 text-base mb-0.5">Admin</div>
                                                    <div class="text-xs text-slate-500 font-medium">Full system access</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-2 text-center border-y border-slate-200/60 bg-white">
                                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-xs font-bold border border-emerald-100 w-[84px] justify-center shadow-sm">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                All
                                            </div>
                                        </td>
                                        <td class="py-4 px-2 text-center border-y border-slate-200/60 bg-white">
                                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-xs font-bold border border-emerald-100 w-[84px] justify-center shadow-sm">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                All
                                            </div>
                                        </td>
                                        <td class="py-4 px-2 text-center rounded-r-2xl border-y border-r border-slate-200/60 bg-white">
                                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-xs font-bold border border-emerald-100 w-[84px] justify-center shadow-sm">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                All
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Manager --}}
                                    <tr class="group bg-slate-50/50 hover:bg-slate-50 transition-colors shadow-sm relative border border-slate-100">
                                        <td class="py-4 px-6 rounded-l-2xl border-y border-l border-slate-200/60 bg-white">
                                            <div class="flex items-center gap-4">
                                                <div class="w-12 h-12 rounded-xl bg-accent-50 border border-accent-100 text-accent-600 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                                </div>
                                                <div>
                                                    <div class="font-extrabold text-slate-900 text-base mb-0.5">Manager</div>
                                                    <div class="text-xs text-slate-500 font-medium">Department level</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-2 text-center border-y border-slate-200/60 bg-white">
                                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-accent-50 text-accent-600 text-xs font-bold border border-accent-100 w-[84px] justify-center shadow-sm">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                Team
                                            </div>
                                        </td>
                                        <td class="py-4 px-2 text-center border-y border-slate-200/60 bg-white">
                                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-accent-50 text-accent-600 text-xs font-bold border border-accent-100 w-[84px] justify-center shadow-sm">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                Team
                                            </div>
                                        </td>
                                        <td class="py-4 px-2 text-center rounded-r-2xl border-y border-r border-slate-200/60 bg-white">
                                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-50 text-slate-400 text-xs font-bold border border-slate-200 w-[84px] justify-center">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                                None
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Employee --}}
                                    <tr class="group bg-slate-50/50 hover:bg-slate-50 transition-colors shadow-sm border border-slate-100">
                                        <td class="py-4 px-6 rounded-l-2xl border-y border-l border-slate-200/60 bg-white">
                                            <div class="flex items-center gap-4">
                                                <div class="w-12 h-12 rounded-xl bg-slate-100 border border-slate-200 text-slate-600 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                </div>
                                                <div>
                                                    <div class="font-extrabold text-slate-900 text-base mb-0.5">Employee</div>
                                                    <div class="text-xs text-slate-500 font-medium">Personal data only</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-2 text-center border-y border-slate-200/60 bg-white">
                                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-accent-50 text-accent-600 text-xs font-bold border border-accent-100 w-[84px] justify-center shadow-sm">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                Self
                                            </div>
                                        </td>
                                        <td class="py-4 px-2 text-center border-y border-slate-200/60 bg-white">
                                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-50 text-slate-400 text-xs font-bold border border-slate-200 w-[84px] justify-center">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                                None
                                            </div>
                                        </td>
                                        <td class="py-4 px-2 text-center rounded-r-2xl border-y border-r border-slate-200/60 bg-white">
                                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-50 text-slate-400 text-xs font-bold border border-slate-200 w-[84px] justify-center">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                                None
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="order-1 lg:order-2">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-accent-50 text-accent-600 text-xs font-semibold tracking-wide uppercase mb-6 border border-accent-100">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Access Control
                    </div>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6 tracking-tight">Control exactly who sees what</h2>
                    <p class="text-lg text-slate-600 mb-6 leading-relaxed">
                        Not everyone in your organization needs to see everything. TimeNest lets admins decide precisely what each role can view, edit, or approve — attendance, leave, worklogs, member management — down to the individual permission. No hardcoded assumptions about who "should" have access.
                    </p>
                </div>
            </div>
        </section>

        {{-- Mid-page Interruption CTA --}}
        <section class="py-12 md:py-16 bg-white relative">
            <div class="max-w-7xl mx-auto px-6 relative z-10">
                <div class="bg-black rounded-[2rem] overflow-hidden relative flex flex-col md:flex-row items-center justify-between p-6 md:p-8 border-[1.5px] border-[#2ad4a3]/80 shadow-[0_0_30px_rgba(42,212,163,0.15)]">
                    
                    {{-- Left Content --}}
                    <div class="relative z-10 max-w-xl">
                        <h3 class="text-4xl md:text-5xl font-bold text-white mb-6 leading-tight tracking-tight">
                            Ready to secure 
                            <span class="relative inline-block text-white mt-1">
                                <span class="relative z-10 px-2 py-0.5">your workforce</span>
                                <span class="absolute bottom-1 left-0 w-full h-[60%] bg-[#215fe5] -z-0 rounded-sm"></span>
                            </span>
                        </h3>
                        <p class="text-slate-300 text-lg mb-8 leading-relaxed font-medium">
                            Granular permissions, complete audit trails, and strict data isolation. 
                            Enterprise-grade security tools for modern teams.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row items-center gap-6">
                            <x-ui.button href="#" class="w-full sm:w-auto">Start free trial</x-ui.button>
                            <x-ui.button variant="secondary" href="/contact" class="w-full sm:w-auto">Talk to sales</x-ui.button>
                        </div>
                    </div>

                    {{-- Right Illustration (User Provided Image) --}}
                    <div class="relative z-10 mt-8 md:mt-0 flex-shrink-0 w-56 h-56 md:w-64 md:h-64 flex items-center justify-center">
                        {{-- Outer ring --}}
                        <div class="absolute w-[120%] h-[120%] rounded-full border-[1.5px] border-[#2ad4a3]/20 right-0"></div>
                        
                        {{-- Core illustration --}}
                        <div class="relative w-[110%] h-[110%] flex items-center justify-center translate-x-4">
                            <img src="/images/gradient-ssl-illustration-transparent-removebg-preview.png.png" alt="Security Illustration" class="w-full h-full object-contain filter drop-shadow-[0_0_20px_rgba(42,212,163,0.3)] animate-[pulse_4s_ease-in-out_infinite]" />
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- 5. Monitoring & Audit Trail --}}
        <section class="py-16 lg:py-20 bg-slate-50 border-t border-slate-100">
            <div class="max-w-7xl mx-auto px-6 text-center">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-accent-50 text-accent-600 text-xs font-semibold tracking-wide uppercase mb-6 border border-accent-100">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Audit Trail
                </div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6 tracking-tight">Know exactly who did what, and when</h2>
                <p class="text-lg text-slate-600 max-w-3xl mx-auto mb-16 leading-relaxed">
                    Every meaningful action in TimeNest — logins, permission changes, attendance edits, approvals — is recorded automatically. If something needs to be reviewed later, the record is already there. Nothing relies on memory or manual tracking.
                </p>
                
                <div class="max-w-3xl mx-auto bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden text-left">
                    <div class="border-b border-slate-100 p-4 bg-slate-50 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-bold text-slate-700 text-sm">System Audit Log</span>
                        </div>
                        <span class="text-xs font-bold bg-white border border-slate-200 text-emerald-600 px-3 py-1 rounded-full shadow-sm flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Live
                        </span>
                    </div>
                    <div class="divide-y divide-slate-50">
                        {{-- Log Entry 1 --}}
                        <div class="p-5 hover:bg-slate-50/80 flex items-start gap-4 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm text-slate-800 leading-relaxed"><span class="font-extrabold">Priya</span> changed <span class="font-extrabold">Rohan</span>'s role to <span class="font-bold text-accent-600 bg-accent-50 px-1.5 py-0.5 rounded">Manager</span></p>
                                <p class="text-xs text-slate-400 mt-1.5 font-medium">2 mins ago &middot; IP 192.168.1.1</p>
                            </div>
                        </div>
                        {{-- Log Entry 2 --}}
                        <div class="p-5 hover:bg-slate-50/80 flex items-start gap-4 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm text-slate-800 leading-relaxed">New device signed in from <span class="font-extrabold">Mumbai, IN</span></p>
                                <p class="text-xs text-slate-400 mt-1.5 font-medium">1 hour ago &middot; Chrome on Windows</p>
                            </div>
                        </div>
                        {{-- Log Entry 3 --}}
                        <div class="p-5 hover:bg-slate-50/80 flex items-start gap-4 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-accent-50 text-accent-600 border border-accent-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm text-slate-800 leading-relaxed"><span class="font-extrabold">Alex</span> approved <span class="font-extrabold">Sarah</span>'s Annual Leave request</p>
                                <p class="text-xs text-slate-400 mt-1.5 font-medium">3 hours ago &middot; Approved via Dashboard</p>
                            </div>
                        </div>
                        {{-- Log Entry 4 --}}
                        <div class="p-5 hover:bg-slate-50/80 flex items-start gap-4 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm text-slate-800 leading-relaxed"><span class="font-extrabold">David</span> exported Monthly Attendance Report</p>
                                <p class="text-xs text-slate-400 mt-1.5 font-medium">Yesterday at 4:30 PM &middot; CSV Format</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- 6. FAQ --}}
        <section class="py-16 lg:py-20 bg-white relative">
            <div class="max-w-4xl mx-auto px-6 relative z-10">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mb-4">
                        Security Questions, Answered
                    </h2>
                </div>
                
                <div x-data="{ active: null }" class="space-y-4">
                    
                    {{-- Q1 --}}
                    <div class="border border-slate-200 rounded-2xl bg-slate-50/50 overflow-hidden transition-colors" :class="active === 1 ? 'border-accent-200 bg-white shadow-md' : ''">
                        <button @click="active = active === 1 ? null : 1" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                            <span class="text-base font-bold text-slate-900">Is my organization's data encrypted?</span>
                            <svg class="w-5 h-5 text-slate-400 transform transition-transform" :class="active === 1 ? 'rotate-180 text-accent-500' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="active === 1" x-collapse x-cloak>
                            <div class="px-6 pb-6 text-slate-500 leading-relaxed text-sm">
                                Yes. Data is encrypted in transit, and sensitive fields such as passwords and authentication tokens are encrypted at rest. We don't store passwords in a readable form anywhere.
                            </div>
                        </div>
                    </div>

                    {{-- Q2 --}}
                    <div class="border border-slate-200 rounded-2xl bg-slate-50/50 overflow-hidden transition-colors" :class="active === 2 ? 'border-accent-200 bg-white shadow-md' : ''">
                        <button @click="active = active === 2 ? null : 2" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                            <span class="text-base font-bold text-slate-900">Can another organization on TimeNest see our data?</span>
                            <svg class="w-5 h-5 text-slate-400 transform transition-transform" :class="active === 2 ? 'rotate-180 text-accent-500' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="active === 2" x-collapse x-cloak>
                            <div class="px-6 pb-6 text-slate-500 leading-relaxed text-sm">
                                No. Every request is checked against your organization's identity before any data is returned. There's no shared view across organizations — isolation is enforced at the system level, not just the interface.
                            </div>
                        </div>
                    </div>

                    {{-- Q3 --}}
                    <div class="border border-slate-200 rounded-2xl bg-slate-50/50 overflow-hidden transition-colors" :class="active === 3 ? 'border-accent-200 bg-white shadow-md' : ''">
                        <button @click="active = active === 3 ? null : 3" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                            <span class="text-base font-bold text-slate-900">Who inside our organization can see employee data?</span>
                            <svg class="w-5 h-5 text-slate-400 transform transition-transform" :class="active === 3 ? 'rotate-180 text-accent-500' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="active === 3" x-collapse x-cloak>
                            <div class="px-6 pb-6 text-slate-500 leading-relaxed text-sm">
                                That's entirely up to your admins. TimeNest's role and permission system lets you decide exactly who can view attendance, approve leave, manage members, or access reports — nothing is visible by default beyond what a role is explicitly given.
                            </div>
                        </div>
                    </div>

                    {{-- Q4 --}}
                    <div class="border border-slate-200 rounded-2xl bg-slate-50/50 overflow-hidden transition-colors" :class="active === 4 ? 'border-accent-200 bg-white shadow-md' : ''">
                        <button @click="active = active === 4 ? null : 4" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                            <span class="text-base font-bold text-slate-900">Is team chat encrypted?</span>
                            <svg class="w-5 h-5 text-slate-400 transform transition-transform" :class="active === 4 ? 'rotate-180 text-accent-500' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="active === 4" x-collapse x-cloak>
                            <div class="px-6 pb-6 text-slate-500 leading-relaxed text-sm">
                                Yes — messages are encrypted in transit between your team and our servers, and access to any conversation is restricted to members who share the same organization.
                            </div>
                        </div>
                    </div>

                    {{-- Q5 --}}
                    <div class="border border-slate-200 rounded-2xl bg-slate-50/50 overflow-hidden transition-colors" :class="active === 5 ? 'border-accent-200 bg-white shadow-md' : ''">
                        <button @click="active = active === 5 ? null : 5" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                            <span class="text-base font-bold text-slate-900">What happens to our data if we stop using TimeNest?</span>
                            <svg class="w-5 h-5 text-slate-400 transform transition-transform" :class="active === 5 ? 'rotate-180 text-accent-500' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="active === 5" x-collapse x-cloak>
                            <div class="px-6 pb-6 text-slate-500 leading-relaxed text-sm">
                                Your organization's data remains yours. You can export your records, and on request we'll remove your data from our systems in line with your agreement with us.
                            </div>
                        </div>
                    </div>

                    {{-- Q6 --}}
                    <div class="border border-slate-200 rounded-2xl bg-slate-50/50 overflow-hidden transition-colors" :class="active === 6 ? 'border-accent-200 bg-white shadow-md' : ''">
                        <button @click="active = active === 6 ? null : 6" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                            <span class="text-base font-bold text-slate-900">How do you track suspicious activity?</span>
                            <svg class="w-5 h-5 text-slate-400 transform transition-transform" :class="active === 6 ? 'rotate-180 text-accent-500' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="active === 6" x-collapse x-cloak>
                            <div class="px-6 pb-6 text-slate-500 leading-relaxed text-sm">
                                Logins, permission changes, and key workforce actions are automatically logged with who, what, and when. Unusual activity — like a login from a new device — is recorded and visible to your admins.
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>

        {{-- Footer CTA (matching homepage final CTA style, but unique content) --}}
        <section class="py-16 bg-white relative px-6">
            <div class="max-w-7xl mx-auto">
                <div class="relative rounded-[2.5rem] overflow-hidden bg-slate-900 border border-slate-800 shadow-2xl">
                    
                    {{-- Background Effects --}}
                    <div class="absolute inset-0 z-0">
                        <div class="absolute inset-0" style="background-image: linear-gradient(to right, #334155 1px, transparent 1px), linear-gradient(to bottom, #334155 1px, transparent 1px); background-size: 32px 32px; opacity: 0.2; mask-image: radial-gradient(circle at center, black 40%, transparent 100%); -webkit-mask-image: radial-gradient(circle at center, black 40%, transparent 100%);"></div>
                        <div class="absolute -right-64 -top-64 w-[800px] h-[800px] bg-accent-600/30 rounded-full filter blur-[150px] pointer-events-none"></div>
                        <div class="absolute -left-64 -bottom-64 w-[800px] h-[800px] bg-accent-600/20 rounded-full filter blur-[150px] pointer-events-none"></div>
                    </div>

                    <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-8 items-center p-12 md:p-16">
                        
                        {{-- Text --}}
                        <div>
                            <h2 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight leading-tight mb-4">
                                Ready to run your team on a secure platform?
                            </h2>
                            <p class="text-lg text-white mb-8 max-w-lg">
                                Set up your organization in minutes. Rest easy knowing your attendance and payroll data is locked down.
                            </p>
                            
                            <div class="flex flex-col sm:flex-row gap-4 max-w-md">
                                <x-ui.button href="#" class="w-full sm:w-auto">Get Started</x-ui.button>
                                <x-ui.button variant="secondary" href="/contact" class="w-full sm:w-auto">Talk to Sales</x-ui.button>
                            </div>
                            <p class="text-xs text-slate-400 mt-4">No credit card required. 14-day free trial.</p>
                        </div>

                        {{-- Images/Avatars Collage (Same as Homepage) --}}
                        <div class="relative hidden md:flex items-center justify-center lg:justify-end">
                            <div class="relative w-full max-w-md h-[300px]">
                                {{-- Decorative Elements --}}
                                <div class="absolute right-0 top-0 w-32 h-40 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-4 shadow-2xl rotate-6 transform hover:rotate-12 transition duration-500">
                                    <div class="w-full h-24 rounded-lg bg-accent-500/20 mb-2 border border-accent-400/20 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    </div>
                                    <div class="w-2/3 h-2 rounded bg-white/20"></div>
                                </div>
                                
                                <div class="absolute left-10 bottom-0 w-48 h-32 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-4 shadow-2xl -rotate-6 transform hover:-rotate-12 transition duration-500 z-20">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="w-8 h-8 rounded-full bg-emerald-400/20 flex items-center justify-center text-emerald-400">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                        </div>
                                        <div>
                                            <div class="h-2 w-16 bg-white/30 rounded mb-1.5"></div>
                                            <div class="h-1.5 w-10 bg-white/10 rounded"></div>
                                        </div>
                                    </div>
                                    <div class="w-full h-1.5 bg-white/10 rounded mb-1.5"></div>
                                    <div class="w-4/5 h-1.5 bg-white/10 rounded"></div>
                                </div>
                                
                                {{-- Center Main Element --}}
                                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-56 bg-slate-800 border border-slate-700 rounded-3xl p-5 shadow-2xl z-10">
                                    <div class="flex justify-center mb-4">
                                        <div class="w-16 h-16 rounded-full border-4 border-slate-900 shadow-md bg-accent-500 flex items-center justify-center text-white">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path></svg>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-white font-bold text-sm">Authentication</div>
                                        <div class="text-accent-300 text-xs mt-1">Identity Verified</div>
                                    </div>
                                    <div class="mt-6 bg-emerald-500/20 text-emerald-400 text-center text-sm font-bold py-3 px-6 rounded-xl border border-emerald-500/30 w-full uppercase tracking-wider">
                                        Access Granted
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

    </main>

    {{-- Footer --}}
    <x-marketing.footer />
@endsection
