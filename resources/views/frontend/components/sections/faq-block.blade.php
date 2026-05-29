<section class="py-20 bg-surface {{ $class }}">
    <div class="max-w-3xl mx-auto px-6 lg:px-8">
        <div class="space-y-4" x-data="{ openIndex: null }">
            @foreach($faqs as $index => $faq)
                <div class="rounded-xl border border-surface-border bg-surface-card overflow-hidden">
                    <button
                        @click="openIndex = openIndex === {{ $index }} ? null : {{ $index }}"
                        class="w-full flex items-center justify-between px-6 py-4 text-left cursor-pointer"
                    >
                        <span class="font-body font-medium text-content-strong pr-4">{{ $faq['question'] }}</span>
                        <svg class="w-5 h-5 text-content-muted shrink-0 transition-transform duration-200" :class="openIndex === {{ $index }} ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openIndex === {{ $index }}" x-collapse x-cloak class="px-6 pb-4">
                        <p class="text-content-muted text-sm leading-relaxed">{{ $faq['answer'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
