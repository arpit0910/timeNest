<section class="py-20 lg:py-28 bg-slate-50 relative border-b border-slate-100">
    <div class="max-w-4xl mx-auto px-4 md:px-6 lg:px-8 relative z-10" x-data="{ activeFaq: null }">
        
        <div class="text-center mb-16">
            <h2 class="font-display text-3xl lg:text-4xl font-bold text-slate-900 text-sm md:text-base pr-2 tracking-tight mb-4">
                Frequently Asked Questions
            </h2>
        </div>

        <div class="space-y-4">
            @foreach(array_slice($faqs, 0, 5) as $index => $faq)
            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden transition-all duration-300"
                 :class="activeFaq === {{ $index }} ? 'shadow-md border-indigo-200 ring-1 ring-indigo-100' : 'hover:border-slate-300'">
                <button @click="activeFaq = activeFaq === {{ $index }} ? null : {{ $index }}" class="w-full px-4 md:px-6 lg:px-8 py-4 md:py-5 flex items-center justify-between text-left gap-4">
                    <span class="font-bold text-slate-900 text-sm md:text-base pr-2">{{ $faq['q'] }}</span>
                    <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center shrink-0 transition-transform duration-300"
                         :class="activeFaq === {{ $index }} ? 'rotate-180 bg-indigo-50 text-indigo-500' : 'text-slate-400'">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </button>
                <div x-show="activeFaq === {{ $index }}" 
                     x-collapse
                     class="px-4 md:px-6 lg:px-8 pb-4 md:pb-6 text-slate-600 font-body leading-relaxed text-sm">
                    {{ $faq['a'] }}
                </div>
            </div>
            @endforeach
        </div>
        
    </div>
</section>
