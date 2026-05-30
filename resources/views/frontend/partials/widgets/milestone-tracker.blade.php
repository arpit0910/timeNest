<div class="{{ $class ?? 'bg-white rounded-2xl border border-slate-200/60 p-4 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[160px] overflow-hidden' }}"
     x-data="{ 
         milestones: [
             { label: 'Design Approved', complete: true },
             { label: 'Beta Release', complete: false },
             { label: 'Security Audit', complete: false }
         ]
     }"
     x-init="
         setInterval(() => {
             let beta = milestones[1];
             let audit = milestones[2];
             if (!beta.complete) {
                 beta.complete = true;
             } else if (!audit.complete) {
                 audit.complete = true;
             } else {
                 milestones[1].complete = false;
                 milestones[2].complete = false;
             }
         }, 3500);
     "
>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
            </span>
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Milestones</span>
        </div>
        <span class="text-[8px] font-bold text-slate-400 uppercase tracking-wider">3 Stages</span>
    </div>
    
    <div class="mt-2 space-y-1.5 flex-1 flex flex-col justify-center">
        <template x-for="ms in milestones" :key="ms.label">
            <div class="flex items-center justify-between p-1 border border-slate-100 rounded-lg bg-slate-50/50">
                <span class="text-[10px] font-semibold text-slate-700" x-text="ms.label"></span>
                <div :class="'w-4.5 h-4.5 rounded-full flex items-center justify-center border transition-all duration-500 ' + 
                     (ms.complete ? 'bg-emerald-500 border-emerald-500 text-white' : 'bg-white border-slate-200 text-slate-350')"
                >
                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
        </template>
    </div>
</div>
