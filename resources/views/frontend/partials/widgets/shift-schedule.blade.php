<div class="{{ $class ?? 'bg-white rounded-2xl border border-slate-200/60 p-4 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between h-[160px]' }}"
     x-data="{ 
         currentShift: 'Day Shift', 
         roster: [
             { name: 'Marcus A.', status: 'Active', shift: '09:00 - 17:00' },
             { name: 'Chloe V.', status: 'Upcoming', shift: '17:00 - 01:00' }
         ]
     }"
     x-init="
         setInterval(() => {
             roster.forEach(r => {
                 r.status = r.status === 'Active' ? 'Break' : r.status === 'Break' ? 'Upcoming' : 'Active';
             });
         }, 3500);
     "
>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
            </span>
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Shift Scheduling</span>
        </div>
        <span class="text-[9px] text-blue-600 bg-blue-50 border border-blue-100 px-1.5 py-0.5 rounded font-bold">Roster 1A</span>
    </div>
    
    <div class="mt-2 space-y-2 flex-1 flex flex-col justify-center">
        <template x-for="emp in roster" :key="emp.name">
            <div class="bg-slate-50 border border-slate-100 p-2 rounded-xl flex items-center justify-between transition-all duration-500">
                <div class="flex flex-col text-left">
                    <span class="text-[10px] font-bold text-slate-700" x-text="emp.name"></span>
                    <span class="text-[8px] text-slate-400 font-mono" x-text="emp.shift"></span>
                </div>
                <span :class="'text-[8px] font-bold px-1.5 py-0.5 rounded-full border transition-all duration-500 ' + 
                      (emp.status === 'Active' ? 'bg-emerald-50 border-emerald-200 text-emerald-700' : 
                       emp.status === 'Break' ? 'bg-amber-50 border-amber-200 text-amber-700' : 
                       'bg-slate-50 border-slate-200 text-slate-500')" 
                      x-text="emp.status"></span>
            </div>
        </template>
    </div>
</div>
