<div class="{{ $class ?? 'bg-white rounded-2xl border border-slate-200/60 p-4 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between h-[160px]' }}"
     x-data="{ 
         grid: [
             [3, 4, 2, 1, 0],
             [4, 5, 4, 2, 1],
             [1, 2, 3, 4, 3]
         ]
     }"
     x-init="
         setInterval(() => {
             // Randomly tweak heatmap values to simulate real activity shifts
             grid = grid.map(row => row.map(v => Math.max(0, Math.min(5, v + (Math.random() > 0.5 ? 1 : -1)))));
         }, 3000);
     "
>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-teal-500"></span>
            </span>
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Workforce Activity Heatmap</span>
        </div>
        <span class="text-[8px] font-bold text-slate-400 uppercase tracking-wider">Weekly Coverage</span>
    </div>
    
    <div class="my-2 flex flex-col gap-1 items-center justify-center">
        <template x-for="(row, rIdx) in grid" :key="rIdx">
            <div class="flex gap-1">
                <template x-for="(cell, cIdx) in row" :key="cIdx">
                    <div :class="'w-6 h-4 rounded transition-all duration-500 ' + 
                         (cell === 0 ? 'bg-slate-50 border border-slate-100' :
                          cell === 1 ? 'bg-teal-100/50' :
                          cell === 2 ? 'bg-teal-200/70' :
                          cell === 3 ? 'bg-teal-400/80' :
                          cell === 4 ? 'bg-teal-500' :
                          'bg-indigo-600 shadow-sm')"
                    ></div>
                </template>
            </div>
        </template>
    </div>

    <div class="flex items-center justify-between text-[8px] font-bold text-slate-400">
        <span>08:00</span>
        <span>17:00</span>
    </div>
</div>
