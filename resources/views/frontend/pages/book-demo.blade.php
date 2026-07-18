@extends('layouts.marketing')
@section('title', 'Book a Demo | TimeNest')
@section('content')

    <x-marketing.header />

    <main class="marketing-responsive-sections">
        {{-- Section 1: Hero with Interactive Scheduler --}}
        <section id="booking-calendar-hero" class="relative pt-32 pb-16 lg:pt-40 lg:pb-28 overflow-hidden bg-black">
            <x-marketing.hero-background />
            
            <div class="relative z-10 max-w-7xl mx-auto px-6">
                <div class="grid lg:grid-cols-12 gap-16 xl:gap-20 items-center">
                    
                    {{-- Left Column: Text Content --}}
                    <div class="lg:col-span-7 flex flex-col items-start text-left marketing-responsive-copy animate-fade-up">
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white/80 text-sm font-semibold tracking-wide uppercase mb-6 shadow-sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-.447.894L15 19l-6-3-6 3V6l6 3 6-3z" />
                            </svg>
                            Book a Demo
                        </div>
                        
                        <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight leading-[1.1] mb-6">
                            See TimeNest <br />
                            Running Your Way
                        </h1>
                        
                        <p class="text-lg md:text-xl text-neutral-400 max-w-2xl mb-10 leading-relaxed">
                            A real walkthrough, not a canned video — we'll show you attendance, leave, and chat set up the way your team would actually use them.
                        </p>

                        <div class="space-y-4 border-t border-neutral-700/50 pt-8 w-full max-w-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-5 h-5 rounded-full bg-accent-500/15 text-accent-400 flex items-center justify-center shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                                </div>
                                <span class="text-sm font-semibold text-neutral-300">Live walkthrough with a real person</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-5 h-5 rounded-full bg-accent-500/15 text-accent-400 flex items-center justify-center shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                                </div>
                                <span class="text-sm font-semibold text-neutral-300">Tailored configuration for your exact team size</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-5 h-5 rounded-full bg-emerald-500/15 text-emerald-400 flex items-center justify-center shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                                </div>
                                <span class="text-sm font-semibold text-neutral-300">No commitment, no credit card required</span>
                            </div>
                        </div>
                    </div>

                    {{-- Right Column: Interactive Calendar Scheduler --}}
                    <div class="lg:col-span-5 relative w-full max-w-lg mx-auto" x-data="{ 
                        step: 1, 
                        date: '', 
                        dateLabel: '',
                        time: '', 
                        name: '', 
                        email: '', 
                        size: '1-10', 
                        dates: [],
                        isCustomDate: false,
                        customDate: '',
                        error: '',
                        submitting: false,
                        
                        init() {
                            this.dates = [];
                            let current = new Date();
                            // Start checking from tomorrow
                            current.setDate(current.getDate() + 1);
                            
                            const isHoliday = (d) => {
                                const m = d.getMonth();
                                const dy = d.getDate();
                                if (m === 0 && dy === 26) return true; // Republic Day
                                if (m === 7 && dy === 15) return true; // Independence Day
                                if (m === 9 && dy === 2) return true;  // Gandhi Jayanti
                                if (m === 11 && dy === 25) return true; // Christmas
                                return false;
                            };
                            
                            while (this.dates.length < 4) {
                                const dayOfWeek = current.getDay();
                                // 3 = Wednesday, 5 = Friday, 6 = Saturday
                                if ((dayOfWeek === 3 || dayOfWeek === 5 || dayOfWeek === 6) && !isHoliday(current)) {
                                    const label = current.toLocaleDateString('en-US', { weekday: 'long', month: 'short', day: 'numeric' });
                                    const value = current.toISOString().split('T')[0];
                                    this.dates.push({
                                        label: label,
                                        value: value,
                                        shortLabel: current.toLocaleDateString('en-US', { weekday: 'short' }),
                                        dateNum: current.getDate()
                                    });
                                }
                                current.setDate(current.getDate() + 1);
                            }
                            
                            if (this.dates.length > 0) {
                                this.date = this.dates[0].value;
                                this.dateLabel = this.dates[0].label;
                            }
                        },
                        
                        selectDate(dVal, dLabel) {
                            this.isCustomDate = false;
                            this.date = dVal;
                            this.dateLabel = dLabel;
                            this.error = '';
                        },
                        
                        selectCustom() {
                            this.isCustomDate = true;
                            this.date = '';
                            this.dateLabel = '';
                            this.error = '';
                            if (this.customDate) {
                                this.validateCustomDate();
                            }
                        },
                        
                        validateCustomDate() {
                            if (!this.customDate) return;
                            
                            const d = new Date(this.customDate);
                            const today = new Date();
                            today.setHours(0,0,0,0);
                            
                            if (d <= today) {
                                this.error = 'Please select a future date.';
                                this.date = '';
                                this.dateLabel = '';
                                return;
                            }
                            
                            const dayOfWeek = d.getDay();
                            if (dayOfWeek !== 3 && dayOfWeek !== 5 && dayOfWeek !== 6) {
                                this.error = 'Demos can only be scheduled on Wednesdays, Fridays, or Saturdays.';
                                this.date = '';
                                this.dateLabel = '';
                                return;
                            }
                            
                            const m = d.getMonth();
                            const dy = d.getDate();
                            const isHoliday = (m === 0 && dy === 26) || (m === 7 && dy === 15) || (m === 9 && dy === 2) || (m === 11 && dy === 25);
                            if (isHoliday) {
                                const holidayNames = {
                                    '0-26': 'Republic Day',
                                    '7-15': 'Independence Day',
                                    '9-2': 'Gandhi Jayanti',
                                    '11-25': 'Christmas Day'
                                };
                                const name = holidayNames[`${m}-${dy}`] || 'Public Holiday';
                                this.error = `Selected date is a public holiday in India (${name}). Please choose another date.`;
                                this.date = '';
                                this.dateLabel = '';
                                return;
                            }
                            
                            this.error = '';
                            this.date = this.customDate;
                            this.dateLabel = d.toLocaleDateString('en-US', { weekday: 'long', month: 'short', day: 'numeric' });
                        },

                        goToStep2() {
                            this.error = '';
                            if (!this.date || !this.time) {
                                this.error = 'Please select a valid date and time slot first.';
                                return;
                            }
                            
                            const d = new Date(this.date);
                            const today = new Date();
                            today.setHours(0,0,0,0);
                            
                            if (d <= today) {
                                this.error = 'Please select a future date.';
                                return;
                            }
                            
                            const dayOfWeek = d.getDay();
                            if (dayOfWeek !== 3 && dayOfWeek !== 5 && dayOfWeek !== 6) {
                                this.error = 'Demos can only be scheduled on Wednesdays, Fridays, or Saturdays.';
                                return;
                            }
                            
                            const m = d.getMonth();
                            const dy = d.getDate();
                            const isHoliday = (m === 0 && dy === 26) || (m === 7 && dy === 15) || (m === 9 && dy === 2) || (m === 11 && dy === 25);
                            if (isHoliday) {
                                const holidayNames = {
                                    '0-26': 'Republic Day',
                                    '7-15': 'Independence Day',
                                    '9-2': 'Gandhi Jayanti',
                                    '11-25': 'Christmas Day'
                                };
                                const name = holidayNames[`${m}-${dy}`] || 'Public Holiday';
                                this.error = `Selected date is a public holiday in India (${name}). Please choose another date.`;
                                return;
                            }
                            
                            this.step = 2;
                        },
                        
                        async submitBooking() {
                            if (!this.name || !this.email) {
                                this.error = 'Please fill out all fields.';
                                return;
                            }
                            if (!this.date || !this.time) {
                                this.error = 'Please select a valid date and time first.';
                                return;
                            }
                            this.error = '';
                            this.submitting = true;
                            try {
                                const response = await fetch('/book-demo', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        name: this.name,
                                        email: this.email,
                                        company_size: this.size,
                                        booking_date: this.date,
                                        booking_time: this.time
                                    })
                                });
                                
                                const data = await response.json();
                                if (response.ok && data.success) {
                                    this.step = 3;
                                } else {
                                    this.error = data.message || 'An error occurred while booking the demo.';
                                }
                            } catch (e) {
                                this.error = 'Failed to connect to the server. Please try again.';
                            } finally {
                                this.submitting = false;
                            }
                        }
                    }">
                        <div class="absolute inset-0 bg-indigo-650/5 rounded-[2.5rem] filter blur-3xl transform translate-y-10 scale-95"></div>
                        
                        <div class="bg-white border border-neutral-200 rounded-[2.2rem] shadow-xl shadow-neutral-100/80 p-6 md:p-8 relative z-20 overflow-hidden min-h-[460px] flex flex-col justify-between">
                            
                            {{-- Step 1: Select Date & Time --}}
                            <div x-show="step === 1" class="flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center justify-between mb-6">
                                        <h3 class="font-extrabold text-neutral-900 text-lg">1. Choose Date & Time</h3>
                                        <span class="text-xs font-bold text-accent-600 bg-accent-50 px-2.5 py-1 rounded-full">Step 1 of 2</span>
                                    </div>

                                    {{-- Horizontal Date Selector --}}
                                    <label class="block text-xs font-bold text-neutral-400 uppercase tracking-wider mb-3">Available Dates</label>
                                    <div class="grid grid-cols-5 gap-2 mb-4">
                                        <template x-for="item in dates" :key="item.value">
                                            <button type="button" @click="selectDate(item.value, item.label)" :class="(!isCustomDate && date === item.value) ? 'bg-accent-600 border-indigo-600 text-white shadow-md shadow-indigo-100' : 'bg-neutral-50 border-neutral-200 text-neutral-650 hover:bg-neutral-100'" class="flex flex-col items-center justify-center p-2.5 rounded-xl border text-center transition-all">
                                                <span class="text-[10px] uppercase font-bold tracking-wider" x-text="item.shortLabel"></span>
                                                <span class="text-base font-extrabold mt-0.5" x-text="item.dateNum"></span>
                                            </button>
                                        </template>
                                        {{-- Custom Date Button --}}
                                        <button type="button" @click="selectCustom()" :class="isCustomDate ? 'bg-accent-600 border-indigo-600 text-white shadow-md shadow-indigo-100' : 'bg-neutral-50 border-neutral-200 text-neutral-650 hover:bg-neutral-100'" class="flex flex-col items-center justify-center p-2.5 rounded-xl border text-center transition-all">
                                            <span class="text-[10px] uppercase font-bold tracking-wider">Custom</span>
                                            <svg class="w-5 h-5 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </button>
                                    </div>

                                    {{-- Custom Date Picker field (only show when isCustomDate is true) --}}
                                    <div x-show="isCustomDate" x-transition class="mb-6 animate-fade-down">
                                        <label class="block text-xs font-bold text-neutral-700 mb-1.5">Pick Any Date (Wed/Fri/Sat, non-holiday)</label>
                                        <input type="date" x-model="customDate" @change="validateCustomDate" :min="new Date().toISOString().split('T')[0]" class="w-full bg-neutral-50 border border-neutral-200 text-neutral-900 text-sm rounded-xl focus:ring-2 focus:ring-accent-500 focus:border-accent-500 block p-3 transition-colors hover:border-neutral-350" />
                                    </div>

                                    {{-- Time Slots Grid --}}
                                    <label class="block text-xs font-bold text-neutral-400 uppercase tracking-wider mb-3">Available Time Slots (Your Timezone)</label>
                                    <div class="grid grid-cols-2 gap-2 mb-6">
                                        <button type="button" @click="time = '10:00 AM'; error = ''" :class="time === '10:00 AM' ? 'bg-accent-50 border-accent-500 text-accent-700 font-bold' : 'bg-white border-neutral-200 text-neutral-700 hover:bg-neutral-50'" class="py-2.5 px-4 rounded-xl border text-sm font-medium transition-all text-center">10:00 AM</button>
                                        <button type="button" @click="time = '11:30 AM'; error = ''" :class="time === '11:30 AM' ? 'bg-accent-50 border-accent-500 text-accent-700 font-bold' : 'bg-white border-neutral-200 text-neutral-700 hover:bg-neutral-50'" class="py-2.5 px-4 rounded-xl border text-sm font-medium transition-all text-center">11:30 AM</button>
                                        <button type="button" @click="time = '02:00 PM'; error = ''" :class="time === '02:00 PM' ? 'bg-accent-50 border-accent-500 text-accent-700 font-bold' : 'bg-white border-neutral-200 text-neutral-700 hover:bg-neutral-50'" class="py-2.5 px-4 rounded-xl border text-sm font-medium transition-all text-center">02:00 PM</button>
                                        <button type="button" @click="time = '03:30 PM'; error = ''" :class="time === '03:30 PM' ? 'bg-accent-50 border-accent-500 text-accent-700 font-bold' : 'bg-white border-neutral-200 text-neutral-700 hover:bg-neutral-50'" class="py-2.5 px-4 rounded-xl border text-sm font-medium transition-all text-center">03:30 PM</button>
                                    </div>

                                    <div x-show="error" x-text="error" class="text-xs text-rose-600 font-semibold mb-4 leading-relaxed"></div>
                                </div>

                                <button type="button" @click="goToStep2()" class="w-full inline-flex items-center justify-center font-bold tracking-wide transition-all duration-300 rounded-full group/btn px-6 py-3.5 text-sm md:text-base bg-gradient-to-r from-accent-600 to-accent-600 hover:from-indigo-700 hover:to-blue-700 text-white shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/30 border border-transparent">
                                    <span>Next Step</span>
                                    <svg class="w-4 h-4 ml-2 transition-transform duration-300 transform group-hover/btn:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </button>
                            </div>

                            {{-- Step 2: Enter Details --}}
                            <div x-show="step === 2" class="flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center justify-between mb-6">
                                        <h3 class="font-extrabold text-neutral-900 text-lg">2. Your Details</h3>
                                        <span class="text-xs font-bold text-accent-600 bg-accent-50 px-2.5 py-1 rounded-full">Step 2 of 2</span>
                                    </div>

                                    <div class="space-y-4 mb-6">
                                        <div>
                                            <label class="block text-xs font-bold text-neutral-700 mb-1.5">Full Name</label>
                                            <input type="text" x-model="name" placeholder="John Doe" class="w-full bg-neutral-50 border border-neutral-200 text-neutral-900 text-sm rounded-xl focus:ring-2 focus:ring-accent-500 focus:border-accent-500 block p-3 transition-colors hover:border-neutral-350" required />
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-neutral-700 mb-1.5">Work Email</label>
                                            <input type="email" x-model="email" placeholder="john@company.com" class="w-full bg-neutral-50 border border-neutral-200 text-neutral-900 text-sm rounded-xl focus:ring-2 focus:ring-accent-500 focus:border-accent-500 block p-3 transition-colors hover:border-neutral-350" required />
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-neutral-700 mb-1.5">Team Size</label>
                                            <select x-model="size" class="w-full bg-neutral-50 border border-neutral-200 text-neutral-900 text-sm rounded-xl focus:ring-2 focus:ring-accent-500 focus:border-accent-500 block p-3 transition-colors hover:border-neutral-350">
                                                <option value="1-10">1–10 members</option>
                                                <option value="11-50">11–50 members</option>
                                                <option value="51-200">51–200 members</option>
                                                <option value="200+">200+ members</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div x-show="error" x-text="error" class="text-xs text-rose-600 font-semibold mb-4 leading-relaxed"></div>
                                </div>

                                <div class="flex items-center justify-between gap-6">
                                    <button type="button" @click="step = 1; error = ''" class="text-neutral-500 hover:text-neutral-900 font-bold text-sm tracking-wide transition-colors">
                                        Back
                                    </button>
                                    <button type="button" @click="submitBooking()" :disabled="submitting" class="flex-1 inline-flex items-center justify-center font-bold tracking-wide transition-all duration-300 rounded-full group/btn px-6 py-3.5 text-sm md:text-base bg-gradient-to-r from-accent-600 to-accent-600 hover:from-indigo-700 hover:to-blue-700 text-white shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/30 border border-transparent disabled:opacity-50">
                                        <span x-text="submitting ? 'Scheduling...' : 'Confirm Booking'"></span>
                                        <svg x-show="!submitting" class="w-4 h-4 ml-2 transition-transform duration-300 transform group-hover/btn:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            {{-- Step 3: Success Confirmation --}}
                            <div x-show="step === 3" class="flex-1 flex flex-col items-center justify-center text-center p-4">
                                <div class="w-16 h-16 rounded-full bg-emerald-100 border border-emerald-250 flex items-center justify-center mb-6 shadow-inner text-emerald-600">
                                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-extrabold text-neutral-900 mb-3">Walkthrough Scheduled!</h3>
                                <p class="text-neutral-500 text-sm leading-relaxed mb-6">
                                    We've sent a calendar invite and video link to <br />
                                    <span class="font-bold text-neutral-900" x-text="email"></span> for <br />
                                    <span class="font-bold text-neutral-900" x-text="date"></span> at <span class="font-bold text-neutral-900" x-text="time"></span>.
                                </p>
                                <div class="text-[11px] font-semibold text-neutral-400 bg-neutral-50 border border-neutral-100 rounded-lg p-2.5 w-full">
                                    If you need to reschedule, you can do so directly using the link in the calendar invite.
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- Section 2: What You'll See --}}
        <section class="relative py-16 lg:py-24 bg-black border-y border-neutral-800 overflow-hidden">
            <div class="absolute -top-1/2 -right-1/4 w-[600px] h-[600px] bg-accent-50/60 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-1/3 -left-1/4 w-[500px] h-[500px] bg-accent-50/40 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="container mx-auto px-6 lg:px-8 xl:px-12 2xl:max-w-[1440px] relative z-10">
                <div class="max-w-4xl mx-auto text-center mb-16">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-accent-100 text-accent-700 text-sm font-bold rounded-lg w-fit tracking-wide mb-6 mx-auto">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Walkthrough Overview
                    </div>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight mb-4">What We'll Walk Through</h2>
                    <p class="text-lg text-neutral-400 max-w-2xl mx-auto">A focused session, not a generic feature tour.</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 max-w-7xl mx-auto">
                    {{-- Card 1 --}}
                    <div class="p-6 bg-white/5 rounded-2xl border border-white/10 shadow-none hover:border-white/20 transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-accent-50 text-accent-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-white mb-2">Attendance Setup</h3>
                        <p class="text-sm text-neutral-400 leading-relaxed">Geo-fenced check-ins, configured for a branch like yours.</p>
                    </div>

                    {{-- Card 2 --}}
                    <div class="p-6 bg-white/5 rounded-2xl border border-white/10 shadow-none hover:border-white/20 transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-accent-50 text-accent-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-white mb-2">Leave & Approvals</h3>
                        <p class="text-sm text-neutral-400 leading-relaxed">How requests route through your actual reporting structure.</p>
                    </div>

                    {{-- Card 3 --}}
                    <div class="p-6 bg-white/5 rounded-2xl border border-white/10 shadow-none hover:border-white/20 transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-white mb-2">Worklogs</h3>
                        <p class="text-sm text-neutral-400 leading-relaxed">Daily work tied to attendance, not just clock in and out.</p>
                    </div>

                    {{-- Card 4 --}}
                    <div class="p-6 bg-white/5 rounded-2xl border border-white/10 shadow-none hover:border-white/20 transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-white mb-2">Team Chat</h3>
                        <p class="text-sm text-neutral-400 leading-relaxed">Secure, organization-scoped conversations, live in the demo.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Section 3: Real Scenarios --}}
        <section class="relative py-16 lg:py-24 bg-black z-10 overflow-hidden">
            <div class="absolute -top-1/3 -left-1/4 w-[600px] h-[600px] bg-accent-50/40 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="container mx-auto px-6 lg:px-8 xl:px-12 2xl:max-w-[1440px] relative z-10">
                <div class="max-w-3xl mx-auto text-center">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-accent-100 text-accent-700 text-sm font-bold rounded-lg w-fit tracking-wide mb-6 mx-auto">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                        </svg>
                        Real Scenarios
                    </div>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-neutral-900 tracking-tight mb-6">Not Just a Feature List</h2>
                    <p class="text-lg text-neutral-600 leading-relaxed">
                        We'll run through actual situations — a leave request that needs multi-level approval, a check-in outside a branch's geo-fence getting blocked, a manager reassigning an approval when they're unavailable. Seeing the logic in action tells you more than a slide ever could.
                    </p>
                </div>
            </div>
        </section>

        {{-- Section 4: Who Should Book This --}}
        <section class="relative py-16 lg:py-24 bg-black border-t border-neutral-800 overflow-hidden">
            <div class="absolute top-1/4 -right-1/4 w-[500px] h-[500px] bg-accent-50/30 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="container mx-auto px-6 lg:px-8 xl:px-12 2xl:max-w-[1440px] relative z-10">
                <div class="max-w-4xl mx-auto text-center mb-16">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-purple-100 text-purple-700 text-sm font-bold rounded-lg w-fit tracking-wide mb-6 mx-auto">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Target Audience
                    </div>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight mb-4">Built for Someone Making a Real Decision</h2>
                </div>

                <div class="grid md:grid-cols-3 gap-6 max-w-5xl mx-auto">
                    {{-- Card 1 --}}
                    <div class="p-6 bg-white/5 rounded-2xl border border-white/10 shadow-none hover:border-white/20 transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-accent-50 text-accent-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-white mb-2">Founders & Team Leads</h3>
                        <p class="text-sm text-neutral-400 leading-relaxed">Evaluating whether TimeNest replaces your current setup.</p>
                    </div>

                    {{-- Card 2 --}}
                    <div class="p-6 bg-white/5 rounded-2xl border border-white/10 shadow-none hover:border-white/20 transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-accent-50 text-accent-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-white mb-2">HR & Operations</h3>
                        <p class="text-sm text-neutral-400 leading-relaxed">Want to see approval flows and policies before rolling out.</p>
                    </div>

                    {{-- Card 3 --}}
                    <div class="p-6 bg-white/5 rounded-2xl border border-white/10 shadow-none hover:border-white/20 transition-all group">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-white mb-2">IT & Admins</h3>
                        <p class="text-sm text-neutral-400 leading-relaxed">Curious about roles, permissions, and how access actually works.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Mid-Page CTA (Contained Panel) --}}
        <section class="py-16 bg-black relative px-6">
            <div class="max-w-5xl mx-auto">
                <div class="relative rounded-[2.5rem] overflow-hidden bg-neutral-900 border border-neutral-800 shadow-2xl">
                    
                    {{-- Background Effects --}}
                    <div class="absolute inset-0 z-0">
                        <div class="absolute inset-0" style="background-image: linear-gradient(to right, #334155 1px, transparent 1px), linear-gradient(to bottom, #334155 1px, transparent 1px); background-size: 32px 32px; opacity: 0.15; mask-image: radial-gradient(circle at center, black 40%, transparent 100%); -webkit-mask-image: radial-gradient(circle at center, black 40%, transparent 100%);"></div>
                        <div class="absolute -right-64 -top-64 w-[600px] h-[600px] bg-accent-600/20 rounded-full filter blur-[120px] pointer-events-none"></div>
                        <div class="absolute -left-64 -bottom-64 w-[600px] h-[600px] bg-accent-600/10 rounded-full filter blur-[120px] pointer-events-none"></div>
                    </div>

                    <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-8 items-center p-8 md:p-12">
                        {{-- Text Column --}}
                        <div>
                            <h2 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight leading-tight mb-4">
                                Prefer to just talk it through first?
                            </h2>
                            <p class="text-base md:text-lg text-neutral-300 mb-8 max-w-lg leading-relaxed">
                                No pressure, no sales script — just a conversation about whether TimeNest fits.
                            </p>
                            
                            <div class="flex">
                                <x-ui.button variant="secondary" href="/contact">Talk to Us</x-ui.button>
                            </div>
                        </div>

                        {{-- Image Column --}}
                        <div class="relative flex items-center justify-center lg:justify-end">
                            <div class="relative w-full max-w-md aspect-[4/3] rounded-2xl overflow-hidden shadow-2xl border-4 border-neutral-800 bg-black">
                                <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=80" class="w-full h-full object-cover object-center" alt="Video call screen share meeting">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Section 5: What to Expect --}}
        <section class="relative py-16 lg:py-24 bg-black border-t border-neutral-800 overflow-hidden">
            <div class="absolute top-1/3 -left-1/4 w-[600px] h-[600px] bg-accent-50/40 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="container mx-auto px-6 lg:px-8 xl:px-12 2xl:max-w-[1440px] relative z-10">
                <div class="max-w-4xl mx-auto text-center mb-16">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-100 text-emerald-700 text-sm font-bold rounded-lg w-fit tracking-wide mb-6 mx-auto">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2" />
                        </svg>
                        Simple, No Surprises
                    </div>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-neutral-900 tracking-tight mb-4">What to Expect</h2>
                </div>

                <div class="max-w-3xl mx-auto bg-white rounded-3xl p-8 md:p-12 border border-neutral-200 shadow-sm space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-full bg-neutral-100 text-neutral-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="text-base font-semibold text-neutral-750 mt-1">20–30 minutes, over a video call</span>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-full bg-neutral-100 text-neutral-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="text-base font-semibold text-neutral-750 mt-1">No cost, no credit card required</span>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-full bg-neutral-100 text-neutral-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-.447.894L15 19l-6-3-6 3V6l6 3 6-3z" />
                            </svg>
                        </div>
                        <span class="text-base font-semibold text-neutral-750 mt-1">Live walkthrough with a real person — not a recorded video</span>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-full bg-neutral-100 text-neutral-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <span class="text-base font-semibold text-neutral-750 mt-1">Bring your team — multiple people can join</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- Section 6: Why a Demo --}}
        <section class="relative py-16 lg:py-24 bg-black z-10 overflow-hidden">
            <div class="absolute -bottom-1/3 -right-1/4 w-[500px] h-[500px] bg-accent-50/40 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="container mx-auto px-6 lg:px-8 xl:px-12 2xl:max-w-[1440px] relative z-10">
                <div class="max-w-3xl mx-auto text-center">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-100 text-amber-700 text-sm font-bold rounded-lg w-fit tracking-wide mb-6 mx-auto">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Why Book a Demo?
                    </div>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight mb-6">Why Not Just Sign Up and Explore?</h2>
                    <p class="text-lg text-neutral-400 leading-relaxed mb-8">
                        You can absolutely do that. But if your team has a specific approval structure, multiple branches, or questions about how something maps to your setup, a demo means we configure it together and you leave with real answers — not just a trial account and guesswork.
                    </p>
                    <a href="#" class="inline-flex items-center gap-1 text-sm font-bold text-indigo-400 hover:text-accent-400 transition-colors">
                        Prefer to explore on your own? Get started free
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        {{-- Section 7: FAQ --}}
        <section class="relative py-16 lg:py-24 bg-black border-t border-neutral-800 overflow-hidden">
            <div class="absolute top-1/4 -right-1/4 w-[500px] h-[500px] bg-accent-50/30 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="container mx-auto px-6 lg:px-8 xl:px-12 2xl:max-w-[1440px] relative z-10">
                <div class="max-w-4xl mx-auto text-center mb-16">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-accent-100 text-accent-700 text-sm font-bold rounded-lg w-fit tracking-wide mb-6 mx-auto">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        FAQ
                    </div>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-neutral-900 tracking-tight mb-4">Before You Book</h2>
                </div>

                <div x-data="{ active: null }" class="max-w-3xl mx-auto space-y-4">
                    {{-- Q1 --}}
                    <div class="border border-neutral-200 rounded-2xl bg-white overflow-hidden transition-colors" :class="active === 1 ? 'border-accent-200 shadow-md' : ''">
                        <button @click="active = active === 1 ? null : 1" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                            <span class="text-base font-bold text-neutral-900">Is the demo actually free?</span>
                            <svg class="w-5 h-5 text-neutral-400 transform transition-transform" :class="active === 1 ? 'rotate-180 text-accent-500' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="active === 1" x-collapse x-cloak>
                            <div class="px-6 pb-6 text-neutral-500 leading-relaxed text-sm">
                                Yes — no cost, no credit card required, no obligation to buy anything afterward.
                            </div>
                        </div>
                    </div>

                    {{-- Q2 --}}
                    <div class="border border-neutral-200 rounded-2xl bg-white overflow-hidden transition-colors" :class="active === 2 ? 'border-accent-200 shadow-md' : ''">
                        <button @click="active = active === 2 ? null : 2" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                            <span class="text-base font-bold text-neutral-900">How long does it take?</span>
                            <svg class="w-5 h-5 text-neutral-400 transform transition-transform" :class="active === 2 ? 'rotate-180 text-accent-500' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="active === 2" x-collapse x-cloak>
                            <div class="px-6 pb-6 text-neutral-500 leading-relaxed text-sm">
                                Usually 20–30 minutes, depending on how many questions you bring.
                            </div>
                        </div>
                    </div>

                    {{-- Q3 --}}
                    <div class="border border-neutral-200 rounded-2xl bg-white overflow-hidden transition-colors" :class="active === 3 ? 'border-accent-200 shadow-md' : ''">
                        <button @click="active = active === 3 ? null : 3" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                            <span class="text-base font-bold text-neutral-900">Do I need to prepare anything beforehand?</span>
                            <svg class="w-5 h-5 text-neutral-400 transform transition-transform" :class="active === 3 ? 'rotate-180 text-accent-500' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="active === 3" x-collapse x-cloak>
                            <div class="px-6 pb-6 text-neutral-500 leading-relaxed text-sm">
                                Not required, but knowing your team size and current process (spreadsheets, WhatsApp, another tool) helps us tailor the walkthrough to you.
                            </div>
                        </div>
                    </div>

                    {{-- Q4 --}}
                    <div class="border border-neutral-200 rounded-2xl bg-white overflow-hidden transition-colors" :class="active === 4 ? 'border-accent-200 shadow-md' : ''">
                        <button @click="active = active === 4 ? null : 4" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                            <span class="text-base font-bold text-neutral-900">Can more than one person from my team join?</span>
                            <svg class="w-5 h-5 text-neutral-400 transform transition-transform" :class="active === 4 ? 'rotate-180 text-accent-500' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="active === 4" x-collapse x-cloak>
                            <div class="px-6 pb-6 text-neutral-500 leading-relaxed text-sm">
                                Yes — bring whoever's actually making the decision.
                            </div>
                        </div>
                    </div>

                    {{-- Q5 --}}
                    <div class="border border-neutral-200 rounded-2xl bg-white overflow-hidden transition-colors" :class="active === 5 ? 'border-accent-200 shadow-md' : ''">
                        <button @click="active = active === 5 ? null : 5" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                            <span class="text-base font-bold text-neutral-900">What if we're not ready to commit yet?</span>
                            <svg class="w-5 h-5 text-neutral-400 transform transition-transform" :class="active === 5 ? 'rotate-180 text-accent-500' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="active === 5" x-collapse x-cloak>
                            <div class="px-6 pb-6 text-neutral-500 leading-relaxed text-sm">
                                That's fine. Plenty of people book a demo just to understand what TimeNest actually does before deciding anything.
                            </div>
                        </div>
                    </div>

                    {{-- Q6 --}}
                    <div class="border border-neutral-200 rounded-2xl bg-white overflow-hidden transition-colors" :class="active === 6 ? 'border-accent-200 shadow-md' : ''">
                        <button @click="active = active === 6 ? null : 6" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                            <span class="text-base font-bold text-neutral-900">Is it a live call, or a recorded video?</span>
                            <svg class="w-5 h-5 text-neutral-400 transform transition-transform" :class="active === 6 ? 'rotate-180 text-accent-500' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="active === 6" x-collapse x-cloak>
                            <div class="px-6 pb-6 text-neutral-500 leading-relaxed text-sm">
                                Live, with a real person, over video with screen-share — not a pre-recorded walkthrough.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Footer CTA (Contained Panel styling matching homepage final CTA) --}}
        <section class="py-16 bg-black relative px-6 z-10 border-t border-neutral-800">
            <div class="max-w-7xl mx-auto">
                <div class="relative rounded-[2.5rem] overflow-hidden bg-neutral-900 border border-neutral-800 shadow-2xl">
                    
                    {{-- Background Effects --}}
                    <div class="absolute inset-0 z-0">
                        <div class="absolute inset-0" style="background-image: linear-gradient(to right, #334155 1px, transparent 1px), linear-gradient(to bottom, #334155 1px, transparent 1px); background-size: 32px 32px; opacity: 0.15; mask-image: radial-gradient(circle at center, black 40%, transparent 100%); -webkit-mask-image: radial-gradient(circle at center, black 40%, transparent 100%);"></div>
                        <div class="absolute -right-64 -top-64 w-[800px] h-[800px] bg-accent-600/30 rounded-full filter blur-[150px] pointer-events-none"></div>
                        <div class="absolute -left-64 -bottom-64 w-[800px] h-[800px] bg-accent-600/20 rounded-full filter blur-[150px] pointer-events-none"></div>
                    </div>

                    <div class="relative z-10 p-12 md:p-16 text-center max-w-3xl mx-auto">
                        <h2 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-6 animate-pulse">
                            Ready when you are
                        </h2>
                        <p class="text-lg md:text-xl text-neutral-300 mb-10 leading-relaxed">
                            Book a time that works for you — takes less than a minute to schedule.
                        </p>
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                            <x-ui.button href="#booking-calendar-hero" class="w-full sm:w-auto">Book Your Demo</x-ui.button>
                            <x-ui.button variant="secondary" href="/contact" class="w-full sm:w-auto">Talk to Sales</x-ui.button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <x-marketing.footer />
@endsection



