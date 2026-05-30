<div class="{{ $class ?? 'bg-white rounded-2xl border border-slate-200/60 p-4 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[160px] overflow-hidden' }}"
     x-data="{ 
         clients: [
             { name: 'Globex Ltd', revenue: 14200, growth: true },
             { name: 'Acme LLC', revenue: 8400, growth: false }
         ]
     }"
>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
            </span>
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Client Revenue</span>
        </div>
        <span class="text-[8px] font-bold text-slate-400 uppercase tracking-wider">Live</span>
    </div>
    
    <div class="mt-2 space-y-2 flex-1 flex flex-col justify-center">
        <template x-for="c in clients" :key="c.name">
            <div class="flex items-center justify-between p-2 bg-slate-50/50 border border-slate-100 rounded-xl">
                <div class="flex flex-col text-left">
                    <span class="text-[10px] font-bold text-slate-700" x-text="c.name"></span>
                    <span class="text-[7px] text-slate-400 font-bold uppercase">Monthly Billed</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-[11px] font-bold text-slate-800 font-mono" x-text="'$' + c.revenue.toLocaleString()"></span>
                    <span :class="'w-1.5 h-1.5 rounded-full ' + (c.growth ? 'bg-emerald-500 animate-pulse' : 'bg-indigo-500')"></span>
                </div>
            </div>
        </template>
    </div>
</div>
