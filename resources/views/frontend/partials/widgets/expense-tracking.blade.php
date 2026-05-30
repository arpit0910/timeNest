<div class="{{ $class ?? 'bg-white rounded-2xl border border-slate-200/60 p-4 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between h-[160px]' }}"
     x-data="{ 
         expenses: [
             { label: 'SaaS Suite', amount: 89.00, status: 'Reimbursed' },
             { label: 'Travel Fare', amount: 345.50, status: 'Submitted' }
         ]
     }"
     x-init="
         setInterval(() => {
             let sub = expenses.find(e => e.status === 'Submitted');
             if (sub) {
                 sub.status = 'Approved';
                 setTimeout(() => {
                     sub.status = 'Reimbursed';
                 }, 1200);
             } else {
                 expenses[1].status = 'Submitted';
             }
         }, 4000);
     "
>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
            </span>
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Expense Tracker</span>
        </div>
        <span class="text-[8px] font-bold text-slate-400 uppercase tracking-wider font-mono">Month: Q2</span>
    </div>
    
    <div class="mt-2 space-y-2 flex-1 flex flex-col justify-center">
        <template x-for="item in expenses" :key="item.label">
            <div class="bg-slate-50 border border-slate-100 p-2 rounded-xl flex items-center justify-between transition-all duration-500">
                <div class="flex flex-col text-left">
                    <span class="text-[10px] font-bold text-slate-700" x-text="item.label"></span>
                    <span class="text-[9px] text-slate-800 font-bold font-mono" x-text="'$' + item.amount.toFixed(2)"></span>
                </div>
                <span :class="'text-[8px] font-bold px-1.5 py-0.5 rounded border transition-all duration-500 ' + 
                      (item.status === 'Reimbursed' ? 'bg-emerald-50 border-emerald-200 text-emerald-700' : 
                       item.status === 'Approved' ? 'bg-indigo-50 border-indigo-200 text-indigo-700' : 
                       'bg-amber-50 border-amber-200 text-amber-700')"
                      x-text="item.status"></span>
            </div>
        </template>
    </div>
</div>
