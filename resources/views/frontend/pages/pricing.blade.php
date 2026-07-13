@extends('layouts.marketing')
@section('title', 'Pricing | TimeNest')
@section('content')

    <x-marketing.header />

    <main class="marketing-responsive-sections" x-data="{ isAnnual: false }">
        {{-- Section 1: Hero --}}
        <section class="relative pt-32 pb-16 lg:pt-44 lg:pb-20 overflow-hidden bg-white">
            <x-marketing.hero-background />
            
            <div class="relative z-10 max-w-7xl mx-auto px-6 text-center animate-fade-up">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-indigo-50/80 backdrop-blur-sm border border-indigo-100/50 text-indigo-700 text-sm font-semibold tracking-wide uppercase mb-6 shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Pricing Models
                </div>
                
                <h1 class="text-5xl md:text-7xl font-extrabold text-slate-900 tracking-tight leading-[1.1] mb-6">
                    Simple, Fair Pricing <br />
                    That Scales With You
                </h1>
                
                <p class="text-lg md:text-xl text-slate-500 max-w-3xl mx-auto leading-relaxed mb-10">
                    Free to start as an individual. Pay per person once you're a team — with the rate going down, not up, as you grow.
                </p>

                {{-- Billing Toggle --}}
                <div class="flex items-center justify-center gap-4 mt-6">
                    <span :class="!isAnnual ? 'text-slate-900 font-bold' : 'text-slate-400 font-medium'" class="text-sm transition-colors duration-200">Monthly Billing</span>
                    <button type="button" @click="isAnnual = !isAnnual" class="relative inline-flex h-6.5 w-12 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-250 ease-in-out focus:outline-none bg-indigo-600">
                        <span :class="isAnnual ? 'translate-x-5.5' : 'translate-x-0'" class="pointer-events-none inline-block h-5.5 w-5.5 transform rounded-full bg-white shadow ring-0 transition duration-250 ease-in-out"></span>
                    </button>
                    <div class="flex items-center gap-2">
                        <span :class="isAnnual ? 'text-slate-900 font-bold' : 'text-slate-400 font-medium'" class="text-sm transition-colors duration-200">Annual Billing</span>
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-emerald-50 border border-emerald-100 text-emerald-700 text-[11px] font-bold rounded-full shadow-sm">
                            Save 20%
                        </span>
                    </div>
                </div>
            </div>
        </section>

        {{-- Section 2: Freelancers & Independents --}}
        <section class="relative py-16 lg:py-24 bg-slate-50 border-y border-slate-100 overflow-hidden">
            <div class="absolute -top-1/2 -right-1/4 w-[600px] h-[600px] bg-indigo-50/60 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="container mx-auto px-6 lg:px-8 xl:px-12 2xl:max-w-[1440px] relative z-10">
                <div class="max-w-4xl mx-auto text-center mb-16">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-indigo-100 text-indigo-700 text-sm font-bold rounded-lg w-fit tracking-wide mb-6 mx-auto">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Solos & Independents
                    </div>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mb-4">Free Forever, For Individual Work</h2>
                    <p class="text-lg text-slate-500 max-w-2xl mx-auto">Get started tracking your own projects and tasks at no cost.</p>
                </div>

                <div class="grid lg:grid-cols-12 gap-8 max-w-5xl mx-auto items-stretch">
                    {{-- Free Plan Card --}}
                    <div class="lg:col-span-7 bg-white rounded-3xl p-8 border border-slate-200 shadow-sm flex flex-col justify-between hover:border-indigo-200 transition-colors">
                        <div>
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h3 class="font-extrabold text-slate-900 text-xl mb-1">Freelancer Free</h3>
                                    <p class="text-sm text-slate-400">Everything you need to track personal hours</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-3xl font-extrabold text-slate-900">$0</div>
                                    <div class="text-xs font-bold text-slate-400 uppercase mt-0.5">Free Forever</div>
                                </div>
                            </div>
                            
                            <hr class="border-slate-100 my-6" />

                            <ul class="space-y-4 mb-8">
                                <li class="flex items-start gap-3">
                                    <div class="mt-0.5 w-5 h-5 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700">Personal time tracking</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <div class="mt-0.5 w-5 h-5 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700">Project & task tracking</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <div class="mt-0.5 w-5 h-5 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700">Progress overview & dashboard</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <div class="mt-0.5 w-5 h-5 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700">Daily worklogs</span>
                                </li>
                            </ul>
                        </div>

                        <x-ui.button href="#" class="w-full">Start Free</x-ui.button>
                    </div>

                    {{-- Pro Add-on Card --}}
                    <div class="lg:col-span-5 bg-gradient-to-b from-slate-900 to-slate-950 text-white rounded-3xl p-8 border border-slate-800 shadow-xl flex flex-col justify-between relative overflow-hidden">
                        <div class="absolute -right-16 -top-16 w-48 h-48 bg-indigo-600/10 rounded-full filter blur-[40px] pointer-events-none"></div>
                        
                        <div>
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-indigo-500/20 text-indigo-400 text-[10px] font-bold uppercase tracking-wider mb-2">
                                        Add-on Plan
                                    </div>
                                    <h3 class="font-extrabold text-white text-xl">Freelancer Pro</h3>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-extrabold text-white" x-text="isAnnual ? '$48/yr' : '$5/mo'">$5/mo</div>
                                    <div class="text-[9px] font-bold text-slate-400 uppercase tracking-wide mt-0.5" x-text="isAnnual ? 'Billed Annually' : 'Billed Monthly'">Billed Monthly</div>
                                </div>
                            </div>
                            <p class="text-xs text-slate-450 leading-relaxed mb-6">For freelancers who need to bill clients and stay in touch, not just track time.</p>
                            
                            <hr class="border-slate-800 my-4" />

                            <ul class="space-y-3.5 mb-6 text-slate-300">
                                <li class="flex items-start gap-2.5">
                                    <div class="mt-0.5 w-4.5 h-4.5 rounded-full bg-indigo-500/10 text-indigo-400 flex items-center justify-center shrink-0">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                    </div>
                                    <span class="text-xs font-semibold">Excel / data export</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <div class="mt-0.5 w-4.5 h-4.5 rounded-full bg-indigo-500/10 text-indigo-400 flex items-center justify-center shrink-0">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                    </div>
                                    <span class="text-xs font-semibold">Invoice creation</span>
                                </li>
                                <li class="flex items-start gap-2.5">
                                    <div class="mt-0.5 w-4.5 h-4.5 rounded-full bg-indigo-500/10 text-indigo-400 flex items-center justify-center shrink-0">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                    </div>
                                    <span class="text-xs font-semibold">Client chat</span>
                                </li>
                            </ul>
                            
                            <div class="p-2.5 bg-slate-800/40 rounded-xl border border-slate-800 text-[10px] text-slate-400 font-medium leading-relaxed mb-6">
                                Note: These three features are disabled on the free plan and unlock immediately with Freelancer Pro.
                            </div>
                        </div>

                        <x-ui.button variant="secondary" href="#" class="w-full !bg-white !text-slate-900 border-transparent hover:!bg-slate-100">
                            Upgrade to Pro
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </section>

        {{-- Section 3: Growing Teams & Startups --}}
        <section class="relative py-16 lg:py-24 bg-white overflow-hidden">
            <div class="absolute top-1/3 -left-1/4 w-[600px] h-[600px] bg-blue-50/40 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="container mx-auto px-6 lg:px-8 xl:px-12 2xl:max-w-[1440px] relative z-10">
                <div class="max-w-5xl mx-auto grid lg:grid-cols-12 gap-12 lg:gap-16 items-stretch">
                    
                    {{-- Left Column: Price Table & Drop Note --}}
                    <div class="lg:col-span-7 flex flex-col justify-between">
                        <div>
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-100 text-blue-700 text-sm font-bold rounded-lg w-fit tracking-wide mb-6">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Growing Teams
                            </div>
                            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mb-2">Team — Priced Per Person</h2>
                            <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-6">Minimum 2 members</p>
                            
                            {{-- Pricing Table --}}
                            <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-sm mb-6 bg-white">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-slate-50 border-b border-slate-200">
                                            <th class="py-4 px-6 text-sm font-bold text-slate-950">Team Size</th>
                                            <th class="py-4 px-6 text-sm font-bold text-slate-950 text-right">Price per user / month</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-150">
                                        <tr>
                                            <td class="py-3.5 px-6 text-sm font-semibold text-slate-700">2–20</td>
                                            <td class="py-3.5 px-6 text-sm font-extrabold text-slate-900 text-right" x-text="isAnnual ? '$3.20' : '$4.00'">$4.00</td>
                                        </tr>
                                        <tr>
                                            <td class="py-3.5 px-6 text-sm font-semibold text-slate-700">21–100</td>
                                            <td class="py-3.5 px-6 text-sm font-extrabold text-slate-900 text-right" x-text="isAnnual ? '$2.80' : '$3.50'">$3.50</td>
                                        </tr>
                                        <tr>
                                            <td class="py-3.5 px-6 text-sm font-semibold text-slate-700">101–1,000</td>
                                            <td class="py-3.5 px-6 text-sm font-extrabold text-slate-900 text-right" x-text="isAnnual ? '$2.40' : '$3.00'">$3.00</td>
                                        </tr>
                                        <tr>
                                            <td class="py-3.5 px-6 text-sm font-semibold text-slate-700">1,001–10,000</td>
                                            <td class="py-3.5 px-6 text-sm font-extrabold text-slate-900 text-right" x-text="isAnnual ? '$2.00' : '$2.50'">$2.50</td>
                                        </tr>
                                        <tr>
                                            <td class="py-3.5 px-6 text-sm font-semibold text-slate-700">10,001–200,000</td>
                                            <td class="py-3.5 px-6 text-sm font-extrabold text-slate-900 text-right" x-text="isAnnual ? '$1.60' : '$2.00'">$2.00</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <p class="text-sm font-semibold text-slate-400 bg-slate-50 border border-slate-100 rounded-xl p-3 w-fit mb-6">
                            💡 Your rate automatically drops as your team grows — no renegotiation needed.
                        </p>
                    </div>

                    {{-- Right Column: Features list & Action --}}
                    <div class="lg:col-span-5 bg-slate-50 border border-slate-200 rounded-3xl p-8 flex flex-col justify-between shadow-inner">
                        <div>
                            <h3 class="font-extrabold text-slate-900 text-lg mb-6">Included in Team:</h3>
                            <ul class="space-y-4 mb-8">
                                <li class="flex items-start gap-3">
                                    <div class="mt-0.5 w-5 h-5 rounded-full bg-indigo-50 text-indigo-650 flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700">Everything in Freelancer Pro</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <div class="mt-0.5 w-5 h-5 rounded-full bg-indigo-50 text-indigo-650 flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700">Team attendance with geo-fenced check-ins</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <div class="mt-0.5 w-5 h-5 rounded-full bg-indigo-50 text-indigo-650 flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700">Leave management with single-approval workflow</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <div class="mt-0.5 w-5 h-5 rounded-full bg-indigo-50 text-indigo-650 flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700">Daily worklogs</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <div class="mt-0.5 w-5 h-5 rounded-full bg-indigo-50 text-indigo-650 flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700">Basic roles — Admin, Manager, Employee</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <div class="mt-0.5 w-5 h-5 rounded-full bg-indigo-50 text-indigo-650 flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700">Team chat</span>
                                </li>
                            </ul>
                        </div>

                        <x-ui.button href="#" class="w-full">Get Started</x-ui.button>
                    </div>

                </div>
            </div>
        </section>

        {{-- Section 4: Established Organizations & Enterprises --}}
        <section class="relative py-16 lg:py-24 bg-slate-50 border-t border-slate-100 overflow-hidden">
            <div class="absolute top-1/3 -right-1/4 w-[600px] h-[600px] bg-emerald-50/40 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="container mx-auto px-6 lg:px-8 xl:px-12 2xl:max-w-[1440px] relative z-10">
                <div class="max-w-5xl mx-auto grid lg:grid-cols-12 gap-12 lg:gap-16 items-stretch">
                    
                    {{-- Left Column: Price Table & Title --}}
                    <div class="lg:col-span-7 flex flex-col justify-between">
                        <div>
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-100 text-emerald-700 text-sm font-bold rounded-lg w-fit tracking-wide mb-6">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Large Organizations
                            </div>
                            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mb-2">Organization — Built for Real Structure</h2>
                            <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-6">Minimum 2 members</p>
                            
                            {{-- Pricing Table --}}
                            <div class="border border-slate-200 rounded-2xl overflow-hidden shadow-sm mb-6 bg-white">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-slate-50 border-b border-slate-200">
                                            <th class="py-4 px-6 text-sm font-bold text-slate-950">Team Size</th>
                                            <th class="py-4 px-6 text-sm font-bold text-slate-950 text-right">Price per user / month</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-150">
                                        <tr>
                                            <td class="py-3.5 px-6 text-sm font-semibold text-slate-700">2–20</td>
                                            <td class="py-3.5 px-6 text-sm font-extrabold text-slate-900 text-right" x-text="isAnnual ? '$5.60' : '$7.00'">$7.00</td>
                                        </tr>
                                        <tr>
                                            <td class="py-3.5 px-6 text-sm font-semibold text-slate-700">21–100</td>
                                            <td class="py-3.5 px-6 text-sm font-extrabold text-slate-900 text-right" x-text="isAnnual ? '$4.80' : '$6.00'">$6.00</td>
                                        </tr>
                                        <tr>
                                            <td class="py-3.5 px-6 text-sm font-semibold text-slate-700">101–1,000</td>
                                            <td class="py-3.5 px-6 text-sm font-extrabold text-slate-900 text-right" x-text="isAnnual ? '$4.00' : '$5.00'">$5.00</td>
                                        </tr>
                                        <tr>
                                            <td class="py-3.5 px-6 text-sm font-semibold text-slate-700">1,001–10,000</td>
                                            <td class="py-3.5 px-6 text-sm font-extrabold text-slate-900 text-right" x-text="isAnnual ? '$3.20' : '$4.00'">$4.00</td>
                                        </tr>
                                        <tr>
                                            <td class="py-3.5 px-6 text-sm font-semibold text-slate-700">10,001–200,000</td>
                                            <td class="py-3.5 px-6 text-sm font-extrabold text-slate-900 text-right" x-text="isAnnual ? '$2.40' : '$3.00'">$3.00</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <p class="text-sm font-semibold text-slate-400 bg-white border border-slate-200 rounded-xl p-3 w-fit mb-6 shadow-sm">
                            💡 Your rate automatically drops as your team grows — no renegotiation needed.
                        </p>
                    </div>

                    {{-- Right Column: Features list & Action --}}
                    <div class="lg:col-span-5 bg-white border border-slate-200 rounded-3xl p-8 flex flex-col justify-between shadow-sm">
                        <div>
                            <h3 class="font-extrabold text-slate-900 text-lg mb-6">Included in Organization:</h3>
                            <ul class="space-y-4 mb-8">
                                <li class="flex items-start gap-3">
                                    <div class="mt-0.5 w-5 h-5 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700">Everything in Team</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <div class="mt-0.5 w-5 h-5 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700">Departments, designations & reporting hierarchy</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <div class="mt-0.5 w-5 h-5 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700">Multi-level approval workflows</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <div class="mt-0.5 w-5 h-5 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700">Custom roles & granular permissions</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <div class="mt-0.5 w-5 h-5 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700">Branch-level attendance policies</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <div class="mt-0.5 w-5 h-5 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700">Worklogs tied to projects and approvals</span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <div class="w-5 h-5 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-semibold text-slate-400 line-through">Shift Management</span>
                                        <span class="inline-flex items-center px-2 py-0.5 bg-amber-50 border border-amber-100 text-amber-700 text-[9px] font-bold uppercase rounded tracking-wider">
                                            Coming Soon
                                        </span>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <x-ui.button href="#" class="w-full">Get Started</x-ui.button>
                    </div>

                </div>
            </div>
        </section>

        {{-- Mid-Page CTA --}}
        <x-marketing.cta-interruption 
            heading="Not sure which plan"
            headingHighlight="fits your team size?"
            subtext="Book a quick demo and we'll help you figure out the right plan."
        >
            <x-slot name="buttons">
                <x-ui.button href="{{ route('frontend.book-demo') }}" class="w-full sm:w-auto">Book a Demo</x-ui.button>
            </x-slot>
        </x-marketing.cta-interruption>

        {{-- Section 5: Compare Plans --}}
        <section class="py-16 lg:py-24 bg-white">
            <div class="container mx-auto px-6 lg:px-8 xl:px-12 2xl:max-w-[1440px]">
                <div class="max-w-4xl mx-auto text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">Compare Plans</h2>
                </div>

                <div class="max-w-5xl mx-auto border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                    <table class="w-full border-collapse text-left bg-white">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="py-4 px-6 text-sm font-bold text-slate-900">Capability</th>
                                <th class="py-4 px-6 text-sm font-bold text-slate-900 text-center">Freelancer</th>
                                <th class="py-4 px-6 text-sm font-bold text-slate-900 text-center">Team</th>
                                <th class="py-4 px-6 text-sm font-bold text-slate-900 text-center">Organization</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 text-sm font-medium text-slate-700">
                            <tr>
                                <td class="py-4 px-6">Time & project tracking</td>
                                <td class="py-4 px-6 text-center text-emerald-600 font-bold">✓</td>
                                <td class="py-4 px-6 text-center text-emerald-600 font-bold">✓</td>
                                <td class="py-4 px-6 text-center text-emerald-600 font-bold">✓</td>
                            </tr>
                            <tr>
                                <td class="py-4 px-6">Daily worklogs</td>
                                <td class="py-4 px-6 text-center text-emerald-600 font-bold">✓</td>
                                <td class="py-4 px-6 text-center text-emerald-600 font-bold">✓</td>
                                <td class="py-4 px-6 text-center text-emerald-600 font-bold">✓</td>
                            </tr>
                            <tr>
                                <td class="py-4 px-6">Excel export & invoicing</td>
                                <td class="py-4 px-6 text-center text-indigo-600 font-bold">Add-on</td>
                                <td class="py-4 px-6 text-center text-emerald-600 font-bold">✓</td>
                                <td class="py-4 px-6 text-center text-emerald-600 font-bold">✓</td>
                            </tr>
                            <tr>
                                <td class="py-4 px-6">Client chat</td>
                                <td class="py-4 px-6 text-center text-indigo-600 font-bold">Add-on</td>
                                <td class="py-4 px-6 text-center text-slate-350">—</td>
                                <td class="py-4 px-6 text-center text-slate-350">—</td>
                            </tr>
                            <tr>
                                <td class="py-4 px-6">Team attendance & leave</td>
                                <td class="py-4 px-6 text-center text-slate-350">—</td>
                                <td class="py-4 px-6 text-center text-emerald-600 font-bold">✓</td>
                                <td class="py-4 px-6 text-center text-emerald-600 font-bold">✓</td>
                            </tr>
                            <tr>
                                <td class="py-4 px-6">Approval workflow</td>
                                <td class="py-4 px-6 text-center text-slate-350">—</td>
                                <td class="py-4 px-6 text-center text-slate-700">Single-step</td>
                                <td class="py-4 px-6 text-center text-slate-700">Multi-level</td>
                            </tr>
                            <tr>
                                <td class="py-4 px-6">Team chat</td>
                                <td class="py-4 px-6 text-center text-slate-350">—</td>
                                <td class="py-4 px-6 text-center text-emerald-600 font-bold">✓</td>
                                <td class="py-4 px-6 text-center text-emerald-600 font-bold">✓</td>
                            </tr>
                            <tr>
                                <td class="py-4 px-6">Departments & hierarchy</td>
                                <td class="py-4 px-6 text-center text-slate-350">—</td>
                                <td class="py-4 px-6 text-center text-slate-350">—</td>
                                <td class="py-4 px-6 text-center text-emerald-600 font-bold">✓</td>
                            </tr>
                            <tr>
                                <td class="py-4 px-6">Custom roles & permissions</td>
                                <td class="py-4 px-6 text-center text-slate-350">—</td>
                                <td class="py-4 px-6 text-center text-slate-700">Basic</td>
                                <td class="py-4 px-6 text-center text-slate-700">Granular</td>
                            </tr>
                            <tr>
                                <td class="py-4 px-6">Branch-level policies</td>
                                <td class="py-4 px-6 text-center text-slate-350">—</td>
                                <td class="py-4 px-6 text-center text-slate-350">—</td>
                                <td class="py-4 px-6 text-center text-emerald-600 font-bold">✓</td>
                            </tr>
                            <tr>
                                <td class="py-4 px-6">Minimum users</td>
                                <td class="py-4 px-6 text-center text-slate-900">1</td>
                                <td class="py-4 px-6 text-center text-slate-900">2</td>
                                <td class="py-4 px-6 text-center text-slate-900">2</td>
                            </tr>
                            <tr>
                                <td class="py-4 px-6">Maximum users</td>
                                <td class="py-4 px-6 text-center text-slate-900">1</td>
                                <td class="py-4 px-6 text-center text-slate-900">200,000</td>
                                <td class="py-4 px-6 text-center text-slate-900">200,000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        {{-- Section 6: FAQ --}}
        <section class="relative py-16 lg:py-24 bg-slate-50 border-t border-slate-100 overflow-hidden">
            <div class="absolute top-1/4 -right-1/4 w-[500px] h-[500px] bg-indigo-50/30 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="container mx-auto px-6 lg:px-8 xl:px-12 2xl:max-w-[1440px] relative z-10">
                <div class="max-w-4xl mx-auto text-center mb-16">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-indigo-100 text-indigo-700 text-sm font-bold rounded-lg w-fit tracking-wide mb-6 mx-auto">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        FAQ
                    </div>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mb-4">Pricing Questions</h2>
                </div>

                <div x-data="{ active: null }" class="max-w-3xl mx-auto space-y-4">
                    {{-- Q1 --}}
                    <div class="border border-slate-200 rounded-2xl bg-white overflow-hidden transition-colors" :class="active === 1 ? 'border-indigo-200 shadow-md' : ''">
                        <button @click="active = active === 1 ? null : 1" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                            <span class="text-base font-bold text-slate-900">What happens if our team grows past a pricing bracket?</span>
                            <svg class="w-5 h-5 text-slate-400 transform transition-transform" :class="active === 1 ? 'rotate-180 text-indigo-500' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="active === 1" x-collapse x-cloak>
                            <div class="px-6 pb-6 text-slate-500 leading-relaxed text-sm">
                                Your rate automatically adjusts to the new bracket at your next billing cycle — no manual upgrade, no renegotiation, no surprise jump.
                            </div>
                        </div>
                    </div>

                    {{-- Q2 --}}
                    <div class="border border-slate-200 rounded-2xl bg-white overflow-hidden transition-colors" :class="active === 2 ? 'border-indigo-200 shadow-md' : ''">
                        <button @click="active = active === 2 ? null : 2" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                            <span class="text-base font-bold text-slate-900">Can we switch from Team to Organization anytime?</span>
                            <svg class="w-5 h-5 text-slate-400 transform transition-transform" :class="active === 2 ? 'rotate-180 text-indigo-500' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="active === 2" x-collapse x-cloak>
                            <div class="px-6 pb-6 text-slate-500 leading-relaxed text-sm">
                                Yes. Upgrading unlocks the additional features immediately, and your existing data carries over without any migration.
                            </div>
                        </div>
                    </div>

                    {{-- Q3 --}}
                    <div class="border border-slate-200 rounded-2xl bg-white overflow-hidden transition-colors" :class="active === 3 ? 'border-indigo-200 shadow-md' : ''">
                        <button @click="active = active === 3 ? null : 3" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                            <span class="text-base font-bold text-slate-900">Is there a minimum team size?</span>
                            <svg class="w-5 h-5 text-slate-400 transform transition-transform" :class="active === 3 ? 'rotate-180 text-indigo-500' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="active === 3" x-collapse x-cloak>
                            <div class="px-6 pb-6 text-slate-500 leading-relaxed text-sm">
                                The Freelancer plan is single-user. Team and Organization plans require a minimum of 2 members.
                            </div>
                        </div>
                    </div>

                    {{-- Q4 --}}
                    <div class="border border-slate-200 rounded-2xl bg-white overflow-hidden transition-colors" :class="active === 4 ? 'border-indigo-200 shadow-md' : ''">
                        <button @click="active = active === 4 ? null : 4" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                            <span class="text-base font-bold text-slate-900">What exactly does Freelancer Pro unlock?</span>
                            <svg class="w-5 h-5 text-slate-400 transform transition-transform" :class="active === 4 ? 'rotate-180 text-indigo-500' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="active === 4" x-collapse x-cloak>
                            <div class="px-6 pb-6 text-slate-500 leading-relaxed text-sm">
                                Excel/data export, invoice creation, and client chat — all disabled on the free plan, all available immediately once you subscribe.
                            </div>
                        </div>
                    </div>

                    {{-- Q5 --}}
                    <div class="border border-slate-200 rounded-2xl bg-white overflow-hidden transition-colors" :class="active === 5 ? 'border-indigo-200 shadow-md' : ''">
                        <button @click="active = active === 5 ? null : 5" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                            <span class="text-base font-bold text-slate-900">Do you offer a discount for annual billing?</span>
                            <svg class="w-5 h-5 text-slate-400 transform transition-transform" :class="active === 5 ? 'rotate-180 text-indigo-500' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="active === 5" x-collapse x-cloak>
                            <div class="px-6 pb-6 text-slate-500 leading-relaxed text-sm">
                                Yes — paying annually saves 20% compared to monthly billing, on both Team and Organization plans.
                            </div>
                        </div>
                    </div>

                    {{-- Q6 --}}
                    <div class="border border-slate-200 rounded-2xl bg-white overflow-hidden transition-colors" :class="active === 6 ? 'border-indigo-200 shadow-md' : ''">
                        <button @click="active = active === 6 ? null : 6" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                            <span class="text-base font-bold text-slate-900">Is there a free trial for Team or Organization plans?</span>
                            <svg class="w-5 h-5 text-slate-400 transform transition-transform" :class="active === 6 ? 'rotate-180 text-indigo-500' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="active === 6" x-collapse x-cloak>
                            <div class="px-6 pb-6 text-slate-500 leading-relaxed text-sm">
                                Yes — 14 days, no credit card required, full access to the plan's features during the trial.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Footer CTA --}}
        <section class="py-16 bg-white relative px-6 z-10 border-t border-slate-100">
            <div class="max-w-7xl mx-auto">
                <div class="relative rounded-[2.5rem] overflow-hidden bg-slate-900 border border-slate-800 shadow-2xl">
                    
                    {{-- Background Effects --}}
                    <div class="absolute inset-0 z-0">
                        <div class="absolute inset-0" style="background-image: linear-gradient(to right, #334155 1px, transparent 1px), linear-gradient(to bottom, #334155 1px, transparent 1px); background-size: 32px 32px; opacity: 0.15; mask-image: radial-gradient(circle at center, black 40%, transparent 100%); -webkit-mask-image: radial-gradient(circle at center, black 40%, transparent 100%);"></div>
                        <div class="absolute -right-64 -top-64 w-[800px] h-[800px] bg-indigo-600/30 rounded-full filter blur-[150px] pointer-events-none"></div>
                        <div class="absolute -left-64 -bottom-64 w-[800px] h-[800px] bg-blue-600/20 rounded-full filter blur-[150px] pointer-events-none"></div>
                    </div>

                    <div class="relative z-10 p-12 md:p-16 text-center max-w-3xl mx-auto">
                        <h2 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-6">
                            Ready to get started?
                        </h2>
                        <p class="text-lg md:text-xl text-slate-300 mb-10 leading-relaxed">
                            Start free as an individual, or set up your team in minutes.
                        </p>
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                            <x-ui.button href="#" class="w-full sm:w-auto">Start Free</x-ui.button>
                            <x-ui.button variant="secondary" href="{{ route('frontend.book-demo') }}" class="w-full sm:w-auto">Book a Demo</x-ui.button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <x-marketing.footer />
@endsection
