<x-frontend-layout.app 
    metaTitle="{{ $title }} — TimeNest" 
    metaDescription="{{ $description }}"
>
    {{-- Hero Section --}}
    <section class="pt-32 pb-20 lg:pt-48 lg:pb-32 bg-white relative overflow-hidden border-b border-surface-border">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Ik0zNiA0MmwxMC0xMGw0IDQgMTItMTJWMTJIMTB2MTZMMjIgMTZsMTAgMTB6IiBmaWxsPSIjMDAwMDAwIiBmaWxsLW9wYWNpdHk9IjAuMDIiLz48L2c+PC9zdmc+')] opacity-50"></div>
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10 text-center">
            <x-frontend-base.badge variant="brand" class="mb-6">{{ $categoryLabel }}</x-frontend-base.badge>
            <h1 class="font-display text-5xl lg:text-6xl font-bold text-content-strong tracking-tight mb-8">{{ $title }}</h1>
            <p class="text-xl text-content-muted max-w-3xl mx-auto mb-10">{{ $description }}</p>
            <div class="flex justify-center gap-4">
                <x-frontend-base.button href="/register" variant="primary" size="lg">Start Free Trial</x-frontend-base.button>
                <x-frontend-base.button href="{{ route('frontend.book-demo') }}" variant="outline" size="lg">Book Demo</x-frontend-base.button>
            </div>
        </div>
    </section>

    {{-- Main Content Array Render --}}
    <section class="py-24 bg-surface-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-24">
            @foreach($sections as $index => $section)
                <div class="grid lg:grid-cols-2 gap-16 items-center {{ $index % 2 !== 0 ? 'lg:flex-row-reverse' : '' }}">
                    <div class="{{ $index % 2 !== 0 ? 'lg:order-2' : '' }}">
                        <h2 class="font-display text-3xl font-bold text-content-strong mb-6">{{ $section['title'] }}</h2>
                        <p class="text-lg text-content-muted mb-8 leading-relaxed">{{ $section['content'] }}</p>
                        <ul class="space-y-4">
                            @foreach($section['points'] as $point)
                                <li class="flex items-start gap-3 text-content-strong font-medium">
                                    <svg class="w-6 h-6 text-brand-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    {{ $point }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="relative {{ $index % 2 !== 0 ? 'lg:order-1' : '' }}">
                        <div class="absolute inset-0 bg-brand-500/5 transform {{ $index % 2 !== 0 ? '-rotate-3' : 'rotate-3' }} rounded-2xl"></div>
                        <div class="relative bg-white p-8 rounded-2xl shadow-xl border border-surface-border flex items-center justify-center min-h-[300px]">
                            @if(isset($section['component']))
                                @include('frontend.components.sections.'.$section['component'])
                            @else
                                <svg class="w-24 h-24 text-surface-border" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Call to Action --}}
    <section class="py-24 bg-brand-900 text-center text-white">
        <h2 class="font-display text-4xl font-bold mb-6">Ready to transform your {{ strtolower($title) }}?</h2>
        <p class="text-brand-100 text-lg mb-10 max-w-2xl mx-auto">Join thousands of teams already using TimeNest to streamline their operations.</p>
        <x-frontend-base.button href="/register" variant="primary" color="white" class="text-brand-900">Get Started Today</x-frontend-base.button>
    </section>
</x-frontend-layout.app>
