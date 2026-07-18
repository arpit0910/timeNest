<div class="{{ $class ?? 'bg-white rounded-2xl border border-neutral-200/60 p-4 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[160px] overflow-hidden' }}"
     x-data="{ 
         forecast: 142800,
         growth: 12.4
     }"
>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-violet-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-violet-500"></span>
            </span>
            <span class="text-[11px] font-bold text-neutral-500 uppercase tracking-wider">AI Revenue Forecast</span>
        </div>
        <span class="text-[9px] font-bold text-emerald-600 bg-emerald-50 border border-emerald-100 px-1.5 py-0.5 rounded flex items-center gap-0.5 animate-pulse">
            +<span x-text="growth"></span>%
        </span>
    </div>
    
    <div class="relative h-[60px] my-2 bg-neutral-50/50 border border-neutral-100 rounded-lg overflow-hidden flex items-end">
        <!-- SVG Line Chart representing the forecast curve -->
        <svg class="w-full h-full" viewBox="0 0 100 40" preserveAspectRatio="none">
            <!-- Historical Solid Line -->
            <path d="M 0 35 L 20 32 L 40 28 L 60 22" fill="none" stroke="#64748b" stroke-width="1.5" />
            <!-- Forecast Animated Dashed Line -->
            <path d="M 60 22 L 80 14 L 100 8" fill="none" stroke="#8b5cf6" stroke-dasharray="2" stroke-width="1.5" />
            <!-- Target Node Pulse -->
            <circle cx="100" cy="8" r="2.5" fill="#8b5cf6" class="animate-ping origin-center" style="transform-box: fill-box; transform-origin: center;" />
            <circle cx="100" cy="8" r="1.5" fill="#8b5cf6" />
        </svg>
        <div class="absolute top-2 left-3 bg-white/90 backdrop-blur-xs border border-neutral-150 px-1.5 py-0.5 rounded shadow-xs text-[8px] font-mono text-violet-700">
            Q3 Proj: $184K
        </div>
    </div>

    <div class="flex items-center justify-between text-[11px]">
        <div>
            <p class="text-[8px] text-neutral-400 font-bold uppercase">Estimated ARR</p>
            <p class="font-bold text-neutral-800 font-mono">$<span x-text="forecast.toLocaleString()"></span></p>
        </div>
        <span class="text-[9px] font-semibold text-violet-600">Model Active</span>
    </div>
</div>

