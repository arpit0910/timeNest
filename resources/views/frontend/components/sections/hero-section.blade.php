<section class="relative min-h-screen flex items-center overflow-hidden {{ $class }}">
    {{-- Background --}}
    <div class="absolute inset-0 bg-surface hero-grid-bg"></div>
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-brand-500/10 rounded-full blur-[128px] animate-glow"></div>
    <div class="absolute bottom-1/4 right-1/4 w-[400px] h-[400px] bg-accent-500/10 rounded-full blur-[100px] animate-glow" style="animation-delay: 1.5s"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 py-32 w-full">
        <div class="max-w-4xl mx-auto text-center">
            {{-- Pill badge --}}
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-brand-500/10 border border-brand-500/20 text-brand-400 text-sm font-body mb-8 animate-fade-in">
                <span class="w-2 h-2 rounded-full bg-brand-500 animate-pulse"></span>
                The Work Operating System
            </div>

            {{-- Headline --}}
            <h1 class="font-display text-5xl sm:text-6xl lg:text-7xl font-bold text-white leading-tight mb-6 animate-slide-up">
                {!! $headline !!}
            </h1>

            {{-- Sub-headline --}}
            <p class="font-body text-lg sm:text-xl text-slate-400 max-w-2xl mx-auto mb-10 leading-relaxed animate-slide-up" style="animation-delay: 0.1s">
                {{ $subheadline }}
            </p>

            {{-- CTAs --}}
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 animate-slide-up" style="animation-delay: 0.2s">
                @if($primaryCtaText)
                    <x-frontend-base.button :href="$primaryCtaUrl" variant="primary" color="brand" size="lg">
                        {{ $primaryCtaText }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </x-frontend-base.button>
                @endif
                @if($secondaryCtaText)
                    <x-frontend-base.button :href="$secondaryCtaUrl" variant="outline" color="white" size="lg">
                        {{ $secondaryCtaText }}
                    </x-frontend-base.button>
                @endif
            </div>
        </div>

        {{-- Dashboard Mockup --}}
        <div class="mt-20 max-w-5xl mx-auto animate-slide-up" style="animation-delay: 0.3s">
            <div class="relative rounded-xl border border-surface-border bg-surface-card overflow-hidden shadow-2xl shadow-brand-500/5">
                <div class="flex items-center gap-2 px-4 py-3 bg-surface border-b border-surface-border">
                    <span class="w-3 h-3 rounded-full bg-red-500/60"></span>
                    <span class="w-3 h-3 rounded-full bg-amber-500/60"></span>
                    <span class="w-3 h-3 rounded-full bg-green-500/60"></span>
                    <span class="ml-4 text-xs text-slate-500 font-mono">app.timenest.in</span>
                </div>
                <div class="aspect-video bg-gradient-to-br from-surface to-surface-card p-8">
                    {{-- Simulated Dashboard UI --}}
                    <div class="grid grid-cols-4 gap-4 mb-6">
                        @foreach(['Total Employees' => '1,247', 'Present Today' => '1,189', 'On Leave' => '43', 'Active Shifts' => '12'] as $label => $value)
                            <div class="rounded-lg bg-surface border border-surface-border p-4">
                                <p class="text-xs text-slate-500 mb-1">{{ $label }}</p>
                                <p class="text-2xl font-display font-bold text-white">{{ $value }}</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="col-span-2 rounded-lg bg-surface border border-surface-border p-4 h-40">
                            <p class="text-xs text-slate-500 mb-3">Attendance Overview</p>
                            <div class="flex items-end gap-1.5 h-24">
                                @foreach([65, 80, 55, 90, 75, 85, 70, 95, 60, 88, 72, 92] as $h)
                                    <div class="flex-1 rounded-sm bg-brand-500/30" style="height: {{ $h }}%"></div>
                                @endforeach
                            </div>
                        </div>
                        <div class="rounded-lg bg-surface border border-surface-border p-4 h-40">
                            <p class="text-xs text-slate-500 mb-3">Department Split</p>
                            <div class="space-y-2 mt-4">
                                @foreach(['Engineering' => '35%', 'Design' => '20%', 'Sales' => '25%', 'Operations' => '20%'] as $dept => $pct)
                                    <div class="flex justify-between text-xs">
                                        <span class="text-slate-400">{{ $dept }}</span>
                                        <span class="text-white">{{ $pct }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{ $slot }}
    </div>
</section>
