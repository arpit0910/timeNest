<div class="{{ $class ?? 'bg-white rounded-2xl border border-slate-200/60 p-4 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between h-[160px]' }}"
     x-data="{ 
         members: [
             { name: 'Sarah K.', load: 78, status: 'Optimal' },
             { name: 'David L.', load: 95, status: 'Overload' }
         ]
     }"
     x-init="
         setInterval(() => {
             members.forEach(m => {
                 if (m.load > 90) {
                     m.load = 82;
                     m.status = 'Optimal';
                 } else {
                     m.load = 94;
                     m.status = 'Overload';
                 }
             });
         }, 4000);
     "
>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-violet-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-violet-500"></span>
            </span>
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Team Capacity</span>
        </div>
        <span class="text-[8px] font-bold text-slate-400 uppercase tracking-wider">Active Sprint</span>
    </div>
    
    <div class="mt-2 space-y-2 flex-1 flex flex-col justify-center">
        <template x-for="m in members" :key="m.name">
            <div class="space-y-1">
                <div class="flex items-center justify-between text-[9px]">
                    <span class="font-bold text-slate-700" x-text="m.name"></span>
                    <span :class="'font-bold ' + (m.status === 'Overload' ? 'text-rose-600' : 'text-emerald-600')" x-text="m.load + '% (' + m.status + ')'"></span>
                </div>
                <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                    <div :class="'h-full rounded-full transition-all duration-1000 ease-out ' + 
                         (m.status === 'Overload' ? 'bg-rose-500' : 'bg-violet-500')"
                         :style="'width: ' + m.load + '%'"></div>
                </div>
            </div>
        </template>
    </div>
</div>
