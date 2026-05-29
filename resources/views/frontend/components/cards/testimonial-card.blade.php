<!-- PLACEHOLDER â€” replace with real content -->
<div class="rounded-2xl border border-surface-border bg-white p-8 shadow-lg shadow-surface-border/20 hover:shadow-xl transition-all duration-300 {{ $class }}">
    <div class="flex gap-1 mb-6">
        @for($i = 0; $i < $rating; $i++)
            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
        @endfor
    </div>
    <p class="text-content-strong text-lg leading-relaxed mb-8">"{{ $content }}"</p>
    <div class="flex items-center gap-4">
        <div class="w-12 h-12 rounded-full bg-brand-100 flex items-center justify-center text-brand-700 font-bold font-display text-lg">
            {{ strtoupper(substr($name, 0, 1)) }}
        </div>
        <div>
            <p class="text-content-strong font-bold">{{ $name }}</p>
            <p class="text-content-muted text-sm">{{ $role }} · {{ $company }}</p>
        </div>
    </div>
</div>
