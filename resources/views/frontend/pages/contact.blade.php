@extends('layouts.marketing')

@section('title', 'Contact Us | TimeNest')
@section('description', 'Questions about pricing, features, or want to see TimeNest in action? Send us a message.')

@section('content')
<x-marketing.header />

<main class="min-h-screen pt-24 relative overflow-hidden">
    {{-- Hero Section --}}
    <section class="relative pt-20 lg:pt-32 pb-16 px-6 z-10">
        <x-marketing.hero-background />
        <div class="relative max-w-4xl mx-auto text-center z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-indigo-50/80 backdrop-blur-sm border border-indigo-100/50 text-indigo-700 text-sm font-semibold tracking-wide uppercase mb-8 shadow-sm">
                Contact Us
            </div>
            <h1 class="text-5xl md:text-7xl font-extrabold text-slate-900 tracking-tight mb-8 leading-[1.1]">
                Let's Talk About<br class="hidden md:block"/>
                <span class="text-slate-900">Your Team</span>
            </h1>
            <p class="text-xl md:text-2xl text-slate-600 max-w-3xl mx-auto leading-relaxed">
                Questions about pricing, a specific feature, or just want to see TimeNest in action? Send us a message — a real person reads every one.
            </p>
        </div>
    </section>

    {{-- Section 2: Common Reasons to Reach Out --}}
    <section class="relative py-16 lg:py-20 bg-white z-10 overflow-hidden">
        <div class="absolute -top-1/2 -right-1/4 w-[600px] h-[600px] bg-indigo-50/60 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-1/3 -left-1/4 w-[500px] h-[500px] bg-blue-50/40 rounded-full blur-3xl pointer-events-none"></div>
        <div class="container mx-auto px-6 lg:px-8 xl:px-12 2xl:max-w-[1440px] relative z-10">
            <div class="max-w-7xl mx-auto">
                <div class="mb-16 flex flex-col items-center text-center">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-indigo-100 text-indigo-700 text-sm font-bold rounded-lg w-fit tracking-wide mb-6 mx-auto">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        Get In Touch
                    </div>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mb-4">What Can We Help With?</h2>
                    <p class="text-lg text-slate-500 max-w-2xl mx-auto">A quick starting point, so your message lands with the right context.</p>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    {{-- Reason 1 --}}
                    <div class="p-6 bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow cursor-pointer group">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <h3 class="font-bold text-slate-900 mb-2">Pricing & Plans</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">Figuring out what fits your team size and needs.</p>
                    </div>
                    {{-- Reason 2 --}}
                    <div class="p-6 bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow cursor-pointer group">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <h3 class="font-bold text-slate-900 mb-2">Product Demo</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">Want to see TimeNest in action before signing up.</p>
                    </div>
                    {{-- Reason 3 --}}
                    <div class="p-6 bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow cursor-pointer group">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" /></svg>
                        </div>
                        <h3 class="font-bold text-slate-900 mb-2">Technical Support</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">Already using TimeNest and running into an issue.</p>
                    </div>
                    {{-- Reason 4 --}}
                    <div class="p-6 bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow cursor-pointer group">
                        <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        </div>
                        <h3 class="font-bold text-slate-900 mb-2">Partnerships</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">Interested in working with TimeNest in some other way.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Main Content: Form & Direct Lines --}}
    <section class="relative py-16 lg:py-24 bg-slate-50 z-10 overflow-hidden">
        <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-indigo-100/30 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-[350px] h-[350px] bg-blue-100/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="container mx-auto px-6 lg:px-8 xl:px-12 2xl:max-w-[1440px] relative z-10">
            <div class="grid lg:grid-cols-12 gap-16 xl:gap-24 items-center max-w-7xl mx-auto">
                
                {{-- Left Column: Contact Form (Section 3) --}}
                <div class="lg:col-span-7 bg-white rounded-3xl p-8 md:p-12 shadow-xl shadow-slate-200/50 border border-slate-100 relative overflow-hidden" x-data="{
                    name: '',
                    email: '',
                    organization: '',
                    subject: 'General Inquiry',
                    message: '',
                    success: false,
                    error: '',
                    submitting: false,
                    
                    async submitForm() {
                        if (!this.name || !this.email || !this.message) {
                            this.error = 'Please fill out all required fields.';
                            return;
                        }
                        this.error = '';
                        this.submitting = true;
                        try {
                            const response = await fetch('/contact', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    name: this.name,
                                    email: this.email,
                                    subject: this.subject,
                                    message: this.message
                                })
                            });
                            
                            const data = await response.json();
                            if (response.ok && data.success) {
                                this.success = true;
                            } else {
                                this.error = data.message || 'An error occurred while sending the message.';
                            }
                        } catch (e) {
                            this.error = 'Failed to connect to the server. Please try again.';
                        } finally {
                            this.submitting = false;
                        }
                    }
                }">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-indigo-50 to-blue-50 rounded-full blur-3xl -mr-32 -mt-32"></div>
                    
                    <div class="relative z-10">
                        <div x-show="!success">
                            <h2 class="text-3xl font-bold text-slate-900 mb-2">Send Us a Message</h2>
                            <p class="text-slate-500 mb-8">Fill this out and we'll get back to you.</p>

                            <form @submit.prevent="submitForm()" class="space-y-6">
                                <div class="grid md:grid-cols-2 gap-6">
                                    {{-- Full Name --}}
                                    <div>
                                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Full Name</label>
                                        <input type="text" id="name" x-model="name" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block p-3 transition-colors hover:border-slate-300" placeholder="Jane Doe" required>
                                    </div>
                                    {{-- Email Address --}}
                                    <div>
                                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email Address</label>
                                        <input type="email" id="email" x-model="email" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block p-3 transition-colors hover:border-slate-300" placeholder="jane@example.com" required>
                                    </div>
                                </div>

                                <div class="grid md:grid-cols-2 gap-6">
                                    {{-- Organization Name --}}
                                    <div>
                                        <label for="organization" class="block text-sm font-semibold text-slate-700 mb-2">Organization Name <span class="text-slate-400 font-normal">(optional)</span></label>
                                        <input type="text" id="organization" x-model="organization" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block p-3 transition-colors hover:border-slate-300" placeholder="Acme Corp">
                                    </div>
                                    {{-- Subject --}}
                                    <div>
                                        <label for="subject" class="block text-sm font-semibold text-slate-700 mb-2">Topic</label>
                                        <select id="subject" x-model="subject" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block p-3 transition-colors hover:border-slate-300 appearance-none">
                                            <option value="General Inquiry">General Inquiry</option>
                                            <option value="Sales">Sales</option>
                                            <option value="Support">Support</option>
                                            <option value="Partnership">Partnership</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Message --}}
                                <div>
                                    <label for="message" class="block text-sm font-semibold text-slate-700 mb-2">Message</label>
                                    <textarea id="message" x-model="message" rows="5" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block p-3 transition-colors hover:border-slate-300 resize-y" placeholder="How can we help you?" required></textarea>
                                </div>

                                <div x-show="error" x-text="error" class="text-xs text-rose-600 font-semibold mb-4 leading-relaxed"></div>

                                {{-- Submit Button --}}
                                <div>
                                    <x-ui.button type="submit" :disabled="submitting" class="w-full md:w-auto">
                                        <span x-text="submitting ? 'Sending...' : 'Send Message'"></span>
                                    </x-ui.button>
                                </div>
                            </form>
                        </div>
                        
                        {{-- Success Feedback Screen --}}
                        <div x-show="success" x-transition class="text-center py-12 px-6 animate-fade-up">
                            <div class="w-16 h-16 rounded-full bg-emerald-100 border border-emerald-250 flex items-center justify-center mb-6 shadow-inner text-emerald-600 mx-auto">
                                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-extrabold text-slate-900 mb-3">Message Sent!</h3>
                            <p class="text-slate-500 text-sm leading-relaxed max-w-sm mx-auto mb-6">
                                Thank you for reaching out. A team member will get back to you shortly at <span class="font-bold text-slate-900" x-text="email"></span>.
                            </p>
                            <div class="text-[11px] font-semibold text-slate-400 bg-slate-50 border border-slate-100 rounded-lg p-2.5 max-w-sm mx-auto">
                                Reference code generated successfully. We usually reply in less than 24 hours.
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Information --}}
                <div class="lg:col-span-5 space-y-4">
                    
                    {{-- Section 4: Direct Lines --}}
                    <div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-6">Prefer a Direct Line?</h3>
                        <div class="space-y-4">
                            {{-- Sales --}}
                            <div class="p-5 bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-indigo-200 transition-all flex items-start gap-4 group">
                                <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center shrink-0 group-hover:bg-emerald-600 transition-colors">
                                    <svg class="w-5 h-5 text-emerald-600 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900">Sales</h4>
                                    <p class="text-sm text-slate-600 mt-1 mb-3 leading-relaxed">Questions about plans or getting your organization set up.</p>
                                    <div class="flex flex-col sm:flex-row flex-wrap gap-2">
                                        <a href="mailto:sales@timenest.io" class="inline-flex items-center gap-2 px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 transition-all text-xs font-semibold">
                                            <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                            sales@timenest.io
                                        </a>
                                        <a href="tel:+919876543210" class="inline-flex items-center gap-2 px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 transition-all text-xs font-semibold">
                                            <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                                            +91 98765 43210
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Support --}}
                            <div class="p-5 bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-blue-200 transition-all flex items-start gap-4 group">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center shrink-0 group-hover:bg-blue-600 transition-colors">
                                    <svg class="w-5 h-5 text-blue-600 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900">Support</h4>
                                    <p class="text-sm text-slate-600 mt-1 mb-3 leading-relaxed">Already using TimeNest and need help?</p>
                                    <div class="flex flex-col sm:flex-row flex-wrap gap-2">
                                        <a href="mailto:support@timenest.io" class="inline-flex items-center gap-2 px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 transition-all text-xs font-semibold">
                                            <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                            support@timenest.io
                                        </a>
                                        <a href="tel:+919876543211" class="inline-flex items-center gap-2 px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 transition-all text-xs font-semibold">
                                            <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                                            +91 98765 43211
                                        </a>
                                    </div>
                                </div>
                            </div>

                            {{-- General --}}
                            <div class="p-5 bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-slate-300 transition-all flex items-start gap-4 group">
                                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center shrink-0 group-hover:bg-slate-600 transition-colors">
                                    <svg class="w-5 h-5 text-slate-600 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900">General</h4>
                                    <p class="text-sm text-slate-600 mt-1 mb-3 leading-relaxed">Anything else — partnerships, press, or just saying hi.</p>
                                    <div class="flex flex-col sm:flex-row flex-wrap gap-2">
                                        <a href="mailto:hello@timenest.io" class="inline-flex items-center gap-2 px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 transition-all text-xs font-semibold">
                                            <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                            hello@timenest.io
                                        </a>
                                        <a href="tel:+919876543212" class="inline-flex items-center gap-2 px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 transition-all text-xs font-semibold">
                                            <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                                            +91 98765 43212
                                        </a>
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

    {{-- Section 5: Quick Answers Before You Wait --}}
    <section class="relative py-16 lg:py-24 bg-white z-10 overflow-hidden">
        <div class="absolute top-1/4 -right-1/4 w-[500px] h-[500px] bg-emerald-50/40 rounded-full blur-3xl pointer-events-none"></div>
        <div class="container mx-auto px-6 lg:px-8 xl:px-12 2xl:max-w-[1440px] relative z-10">
            <div class="max-w-4xl mx-auto text-center mb-12">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-100 text-emerald-700 text-sm font-bold rounded-lg w-fit tracking-wide mb-6 mx-auto">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Self Serve
                </div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mb-4">Might Already Be Answered</h2>
                <p class="text-lg text-slate-600 leading-relaxed">
                    If your question is about how TimeNest handles security, which plan fits your team, or what's actually included, these pages usually have the answer faster than waiting on a reply.
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-6 max-w-5xl mx-auto">
                <a href="{{ route('frontend.security') }}" class="group p-6 bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-indigo-200 transition-all text-center">
                    <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                    </div>
                    <h3 class="font-bold text-slate-900 mb-1 group-hover:text-indigo-600 transition-colors">Security</h3>
                    <p class="text-sm text-slate-500 font-medium flex items-center justify-center gap-1">Read more <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></p>
                </a>
                <a href="{{ route('frontend.solutions') }}" class="group p-6 bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-blue-200 transition-all text-center">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                    </div>
                    <h3 class="font-bold text-slate-900 mb-1 group-hover:text-blue-600 transition-colors">Solutions</h3>
                    <p class="text-sm text-slate-500 font-medium flex items-center justify-center gap-1">Read more <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></p>
                </a>
                <a href="{{ route('frontend.features') }}" class="group p-6 bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all text-center">
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" /></svg>
                    </div>
                    <h3 class="font-bold text-slate-900 mb-1 group-hover:text-emerald-600 transition-colors">Features</h3>
                    <p class="text-sm text-slate-500 font-medium flex items-center justify-center gap-1">Read more <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></p>
                </a>
            </div>
        </div>
    </section>

    {{-- Section 6: What Happens Next --}}
    <section class="relative py-16 lg:py-24 bg-slate-50 z-10 overflow-hidden">
        <div class="absolute -top-1/3 -left-1/4 w-[600px] h-[600px] bg-purple-50/40 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-indigo-50/30 rounded-full blur-3xl pointer-events-none"></div>
        <div class="container mx-auto px-6 lg:px-8 xl:px-12 2xl:max-w-[1440px] relative z-10">
            <div class="max-w-4xl mx-auto text-center mb-16">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-purple-100 text-purple-700 text-sm font-bold rounded-lg w-fit tracking-wide mb-6 mx-auto">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                    The Process
                </div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mb-4">What Happens Next</h2>
                <p class="text-lg text-slate-600 leading-relaxed max-w-2xl mx-auto">
                    We read every message personally — there's no ticket queue you'll get lost in, and no chatbot standing between you and an actual answer. We're a small, focused team, so when you hear back, it's from someone who actually read what you wrote.
                </p>
            </div>

            {{-- Process Steps --}}
            <div class="grid md:grid-cols-4 gap-6 max-w-6xl mx-auto">
                {{-- Step 1: Enquiry --}}
                <div class="group relative bg-white rounded-2xl border border-slate-200 p-8 shadow-sm hover:shadow-xl hover:border-indigo-200 transition-all duration-300 text-center">
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-indigo-600 text-white text-xs font-bold shadow-lg shadow-indigo-200">1</span>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mx-auto mb-5 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    </div>
                    <h4 class="font-bold text-slate-900 mb-2 text-lg">Enquiry</h4>
                    <p class="text-sm text-slate-500 leading-relaxed">Your message lands directly in our team inbox — no bots, no filters.</p>
                </div>

                {{-- Step 2: Discussion --}}
                <div class="group relative bg-white rounded-2xl border border-slate-200 p-8 shadow-sm hover:shadow-xl hover:border-blue-200 transition-all duration-300 text-center">
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 text-white text-xs font-bold shadow-lg shadow-blue-200">2</span>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-5 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    </div>
                    <h4 class="font-bold text-slate-900 mb-2 text-lg">Discussion</h4>
                    <p class="text-sm text-slate-500 leading-relaxed">A founder reads your message and responds to understand your exact needs.</p>
                </div>

                {{-- Step 3: Demo --}}
                <div class="group relative bg-white rounded-2xl border border-slate-200 p-8 shadow-sm hover:shadow-xl hover:border-emerald-200 transition-all duration-300 text-center">
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-emerald-600 text-white text-xs font-bold shadow-lg shadow-emerald-200">3</span>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-5 group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                    </div>
                    <h4 class="font-bold text-slate-900 mb-2 text-lg">Live Demo</h4>
                    <p class="text-sm text-slate-500 leading-relaxed">We walk you through TimeNest live, answering every question in real time.</p>
                </div>

                {{-- Step 4: Onboarding --}}
                <div class="group relative bg-white rounded-2xl border border-slate-200 p-8 shadow-sm hover:shadow-xl hover:border-purple-200 transition-all duration-300 text-center">
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-purple-600 text-white text-xs font-bold shadow-lg shadow-purple-200">4</span>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center mx-auto mb-5 group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" /></svg>
                    </div>
                    <h4 class="font-bold text-slate-900 mb-2 text-lg">Onboarding</h4>
                    <p class="text-sm text-slate-500 leading-relaxed">We help you get your organization fully set up and running smoothly.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Custom Footer CTA for Contact Page --}}
    <section class="py-20 lg:py-28 relative overflow-hidden bg-slate-900 mt-12">
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 brightness-100 contrast-150"></div>
        <div class="absolute -top-1/2 -right-1/4 w-[1000px] h-[1000px] bg-indigo-500/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-1/2 -left-1/4 w-[800px] h-[800px] bg-blue-500/20 rounded-full blur-3xl"></div>
        
        <div class="container mx-auto px-6 lg:px-8 xl:px-12 2xl:max-w-[1440px] relative z-10 text-center">
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white tracking-tight mb-6">
                Not ready to talk yet?
            </h2>
            <p class="text-xl text-slate-300 max-w-2xl mx-auto mb-10 leading-relaxed">
                Explore TimeNest on your own — no credit card required to get started.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <x-ui.button href="#" class="w-full sm:w-auto">Get Started</x-ui.button>
                <x-ui.button variant="secondary" href="{{ route('frontend.solutions') }}" class="w-full sm:w-auto">See Solutions</x-ui.button>
            </div>
        </div>
    </section>
</main>

<x-marketing.footer />
@endsection
