<div class="{{ $class ?? 'bg-white rounded-2xl border border-slate-200/60 p-4 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between h-[160px]' }}"
     x-data="{ 
         employees: [
             { name: 'Sarah Jenkins', role: 'UX Designer', verified: true, active: true },
             { name: 'Dinesh C.', role: 'QA Engineer', verified: false, active: true }
         ]
     }"
     x-init="
         setInterval(() => {
             let unverified = employees.find(e => !e.verified);
             if (unverified) {
                 unverified.verified = true;
                 setTimeout(() => {
                     employees.forEach((e, idx) => e.verified = (idx === 0 ? true : false));
                 }, 2000);
             }
         }, 5000);
     "
>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-teal-500"></span>
            </span>
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Employee Directory</span>
        </div>
        <span class="text-[8px] font-mono text-slate-400">Total: 42</span>
    </div>
    
    <div class="mt-2 space-y-2 flex-1 flex flex-col justify-center">
        <template x-for="emp in employees" :key="emp.name">
            <div class="flex items-center justify-between p-1.5 border-b border-slate-100 last:border-0">
                <div class="flex items-center gap-2">
                    <span :class="'w-1.5 h-1.5 rounded-full ' + (emp.active ? 'bg-emerald-500' : 'bg-slate-300')"></span>
                    <div class="flex flex-col text-left">
                        <span class="text-[10px] font-bold text-slate-700" x-text="emp.name"></span>
                        <span class="text-[8px] text-slate-400" x-text="emp.role"></span>
                    </div>
                </div>
                <div class="flex items-center gap-1.5">
                    <span :class="'text-[8px] font-bold px-1.5 py-0.5 rounded ' + 
                          (emp.verified ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-amber-50 text-amber-600 border border-amber-100')">
                          <span x-text="emp.verified ? 'Verified' : 'Pending'"></span>
                    </span>
                </div>
            </div>
        </template>
    </div>
</div>
