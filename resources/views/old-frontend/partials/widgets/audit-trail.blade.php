<div class="{{ $class ?? 'bg-white rounded-2xl border border-neutral-200/60 p-4 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[160px] overflow-hidden' }}"
     x-data="{ 
         logs: [
             { time: '14:22:15', event: 'SOC2 Scope Verified', status: 'OK' },
             { time: '14:20:02', event: 'IAM Role Modified', status: 'Warn' }
         ]
     }"
     x-init="
         let idx = 0;
         let events = [
             { time: '14:24:08', event: 'API Key Rotated', status: 'OK' },
             { time: '14:25:31', event: 'SSH Access Blocked', status: 'Secure' },
             { time: '14:27:10', event: 'SOC2 Decert Rescan', status: 'OK' }
         ];
         setInterval(() => {
             logs.unshift(events[idx]);
             if (logs.length > 2) logs.pop();
             idx = (idx + 1) % events.length;
         }, 4000);
     "
>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-neutral-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-neutral-500"></span>
            </span>
            <span class="text-[11px] font-bold text-neutral-500 uppercase tracking-wider">Audit Trail</span>
        </div>
        <span class="text-[8px] font-mono text-neutral-400 uppercase">SOC2 Compliance</span>
    </div>
    
    <div class="mt-2 space-y-2 flex-1 flex flex-col justify-center">
        <template x-for="log in logs" :key="log.time">
            <div class="flex items-center justify-between p-1.5 bg-neutral-50/50 border border-neutral-100 rounded-xl transition-all duration-500">
                <div class="text-left">
                    <p class="text-[9px] font-bold text-neutral-700 x-text" x-text="log.event"></p>
                    <p class="text-[7px] font-mono text-neutral-400" x-text="log.time"></p>
                </div>
                <span :class="'text-[7px] font-mono font-bold px-1.5 py-0.5 rounded border transition-all duration-500 ' + 
                      (log.status === 'OK' || log.status === 'Secure' ? 'bg-emerald-50 border-emerald-200 text-emerald-700' : 'bg-rose-50 border-rose-200 text-rose-700')"
                      x-text="log.status"></span>
            </div>
        </template>
    </div>
</div>

