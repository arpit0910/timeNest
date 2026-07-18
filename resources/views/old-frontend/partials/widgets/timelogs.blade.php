<div class="{{ $class ?? 'bg-white rounded-2xl border border-neutral-200/60 p-4 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[160px] overflow-hidden' }}"
     x-data="{ 
         logs: [
             { dev: 'Alex M.', task: 'Database Refactor', seconds: 120 },
             { dev: 'Sarah K.', task: 'UI Redesign', seconds: 4320 }
         ]
     }"
     x-init="
         setInterval(() => {
             logs.forEach(l => l.seconds += 1);
         }, 1000);
     "
>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
            </span>
            <span class="text-[11px] font-bold text-neutral-500 uppercase tracking-wider">Active Timelogs</span>
        </div>
        <span class="text-[8px] font-bold text-emerald-600 bg-emerald-50 border border-emerald-100 px-1.5 py-0.5 rounded uppercase animate-pulse">Live</span>
    </div>
    
    <div class="mt-2 space-y-2 flex-1 flex flex-col justify-center">
        <template x-for="log in logs" :key="log.dev">
            <div class="flex items-center justify-between p-2 bg-neutral-50/50 border border-neutral-100 rounded-xl">
                <div class="text-left">
                    <p class="text-[10px] font-bold text-neutral-700 x-text" x-text="log.dev"></p>
                    <p class="text-[8px] text-neutral-400 truncate max-w-[110px]" x-text="log.task"></p>
                </div>
                <div class="flex items-center gap-1.5 font-mono text-[10px] font-bold text-neutral-800">
                    <svg class="w-3 h-3 text-emerald-500 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span x-text="Math.floor(log.seconds / 3600) + 'h ' + Math.floor((log.seconds % 3600) / 60) + 'm' + (log.seconds % 60 ? ' ' + (log.seconds % 60) + 's' : '')"></span>
                </div>
            </div>
        </template>
    </div>
</div>

