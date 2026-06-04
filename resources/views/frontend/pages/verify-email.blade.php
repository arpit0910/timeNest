<x-frontend-layout.app metaTitle="Email Verification — TimeNest" metaDescription="Verify your timeNest email address.">
    <section class="relative pt-32 pb-20 bg-surface">
        <div class="max-w-2xl mx-auto px-6 lg:px-8">
            <div class="rounded-xl border border-surface-border bg-surface-card/50 p-12 text-center">
                @if($success)
                    {{-- Success State --}}
                    <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-emerald-500/10 flex items-center justify-center">
                        <svg class="w-10 h-10 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <h1 class="font-display text-2xl font-semibold text-content-strong mb-3">{{ $heading }}</h1>
                    <p class="text-content-muted mb-8 leading-relaxed">{{ $message }}</p>
                    <a href="{{ config('app.url') }}"
                       class="inline-flex items-center justify-center px-6 py-3 rounded-lg bg-brand text-white font-semibold text-sm transition hover:bg-brand/90 focus:outline-none focus:ring-2 focus:ring-brand/50">
                        Go to TimeNest
                    </a>
                @else
                    {{-- Error State --}}
                    <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-red-500/10 flex items-center justify-center">
                        <svg class="w-10 h-10 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                        </svg>
                    </div>
                    <h1 class="font-display text-2xl font-semibold text-content-strong mb-3">{{ $heading }}</h1>
                    <p class="text-content-muted mb-8 leading-relaxed">{{ $message }}</p>
                    <a href="{{ config('app.url') }}"
                       class="inline-flex items-center justify-center px-6 py-3 rounded-lg border border-surface-border text-content-strong font-semibold text-sm transition hover:bg-surface-hover focus:outline-none focus:ring-2 focus:ring-brand/50">
                        Back to TimeNest
                    </a>
                @endif
            </div>
        </div>
    </section>
</x-frontend-layout.app>
