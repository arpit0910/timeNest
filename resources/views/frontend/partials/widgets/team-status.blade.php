<div class="{{ $class ?? 'bg-white rounded-2xl border border-slate-200/60 p-4 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between h-[160px]' }}"
     x-data="{ 
         employees: [
             { name: 'Alex M.', status: 'active', initials: 'AM', bg: 'bg-indigo-100', text: 'text-indigo-600' },
             { name: 'Sarah K.', status: 'active', initials: 'SK', bg: 'bg-teal-100', text: 'text-teal-600' },
             { name: 'David L.', status: 'meeting', initials: 'DL', bg: 'bg-amber-100', text: 'text-amber-600' }
         ] 
     }"
     x-init="setInterval(() => { 
         employees[1].status = employees[1].status === 'active' ? 'offline' : 'active'; 
         employees[2].status = employees[2].status === 'meeting' ? 'active' : 'meeting'; 
     }, 3000)"
>
    <div class="flex items-center justify-between">
        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Team Status</span>
        <span :class="'text-[9px] font-semibold px-2 py-0.5 rounded-full border transition-all duration-500 ' + 
              (employees.filter(e => e.status === 'active').length >= 2 ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-slate-50 text-slate-600 border-slate-200')" 
              x-text="employees.filter(e => e.status === 'active').length + ' Active'"></span>
    </div>
    <div class="mt-2 space-y-1.5 flex-1 flex flex-col justify-center">
        <template x-for="emp in employees">
            <div class="flex items-center justify-between text-[11px] transition-all duration-300">
                <div class="flex items-center gap-1.5">
                    <div :class="'w-5 h-5 rounded-full flex items-center justify-center font-bold text-[8px] transition-colors duration-500 ' + emp.bg + ' ' + emp.text" x-text="emp.initials"></div>
                    <span class="font-semibold text-slate-700" x-text="emp.name"></span>
                </div>
                <span :class="'px-1.5 py-0.5 rounded text-[8px] font-bold border transition-all duration-500 flex items-center gap-1 ' + 
                    (emp.status === 'active' ? 'bg-emerald-50 border-emerald-200 text-emerald-700' : 
                     emp.status === 'meeting' ? 'bg-amber-50 border-amber-200 text-amber-700' : 
                     'bg-slate-100 border-slate-200 text-slate-500')"
                >
                    <span :class="'w-1 h-1 rounded-full ' + 
                        (emp.status === 'active' ? 'bg-emerald-500 animate-pulse' : 
                         emp.status === 'meeting' ? 'bg-amber-500' : 
                         'bg-slate-400')"></span>
                    <span x-text="emp.status === 'active' ? 'Active' : emp.status === 'meeting' ? 'Meeting' : 'Offline'"></span>
                </span>
            </div>
        </template>
    </div>
</div>
