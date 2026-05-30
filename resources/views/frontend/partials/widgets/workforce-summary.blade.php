<div class="{{ $class ?? 'bg-white rounded-2xl border border-slate-200/60 p-4 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[160px] overflow-hidden' }}"
     x-data="{ 
         active: 84, 
         total: 90 
     }"
>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
            </span>
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Workforce Summary</span>
        </div>
        <span class="text-[9px] text-slate-400 font-semibold">93.3% Online</span>
    </div>
    
    <div class="flex items-center justify-around my-2">
        <!-- SVG Radial Progress Ring -->
        <div class="relative w-14 h-14 flex items-center justify-center">
            <svg class="w-full h-full transform -rotate-90">
                <circle cx="28" cy="28" r="22" stroke-width="3" stroke="#f1f5f9" fill="transparent" />
                <circle cx="28" cy="28" r="22" stroke-width="3" stroke="#10b981" fill="transparent"
                        stroke-dasharray="138" stroke-dashoffset="9.2" class="transition-all duration-1000 ease-out" />
            </svg>
            <div class="absolute text-[10px] font-bold text-slate-700">
                <span x-text="active"></span>/<span x-text="total"></span>
            </div>
        </div>
        
        <div class="space-y-1 text-left">
            <div class="flex items-center gap-1.5 text-[9px] font-semibold text-slate-600">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                <span>Active: 84</span>
            </div>
            <div class="flex items-center gap-1.5 text-[9px] font-semibold text-slate-600">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                <span>On Leave: 4</span>
            </div>
            <div class="flex items-center gap-1.5 text-[9px] font-semibold text-slate-600">
                <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                <span>Offline: 2</span>
            </div>
        </div>
    </div>

    <div class="border-t border-slate-100 pt-2 flex items-center justify-between text-[9px] font-semibold text-slate-400">
        <span>Target Productivity: 85%</span>
        <span class="text-emerald-600">Optimal</span>
    </div>
</div>
