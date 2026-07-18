<div class="{{ $class ?? 'bg-white rounded-2xl border border-neutral-200/60 p-4 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[160px] overflow-hidden' }}"
     x-data="{ 
         standards: [
             { label: 'SOC2 Type II', val: 100 },
             { label: 'ISO 27001', val: 85 }
         ]
     }"
     x-init="
         setInterval(() => {
             standards[1].val = standards[1].val === 85 ? 100 : 85;
         }, 4000);
     "
>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
            </span>
            <span class="text-[11px] font-bold text-neutral-500 uppercase tracking-wider">Compliance Tracker</span>
        </div>
        <span class="text-[8px] font-bold text-neutral-400 uppercase tracking-wider font-mono">Audited</span>
    </div>
    
    <div class="mt-2 space-y-2 flex-1 flex flex-col justify-center">
        <template x-for="std in standards" :key="std.label">
            <div class="bg-neutral-50 border border-neutral-100 p-2 rounded-xl flex items-center justify-between transition-all duration-500">
                <div class="text-left">
                    <span class="text-[10px] font-bold text-neutral-700" x-text="std.label"></span>
                    <span class="block text-[7px] text-neutral-400 font-bold uppercase mt-0.5" x-text="std.val === 100 ? 'Audit Passed' : 'In Progress'"></span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-[10px] font-bold text-neutral-800 font-mono" x-text="std.val + '%'"></span>
                    <div :class="'w-5 h-5 rounded-full flex items-center justify-center border transition-all duration-500 ' + 
                         (std.val === 100 ? 'bg-emerald-500 border-emerald-500 text-white' : 'bg-amber-400 border-amber-400 text-white animate-pulse')"
                    >
                        <span x-show="std.val === 100" class="text-[9px] font-bold">✓</span>
                        <span x-show="std.val !== 100" class="text-[9px] font-bold">↻</span>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>

