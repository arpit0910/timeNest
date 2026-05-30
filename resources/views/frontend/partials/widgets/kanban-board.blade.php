<div class="{{ $class ?? 'bg-white rounded-2xl border border-slate-200/60 p-4 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[160px] overflow-hidden' }}"
     x-data="{ 
         currentCol: 'Progress',
         task: 'Secure SSL Auth'
     }"
     x-init="
         setInterval(() => {
             if (currentCol === 'Progress') {
                 currentCol = 'Review';
             } else if (currentCol === 'Review') {
                 currentCol = 'Done';
             } else {
                 currentCol = 'Progress';
             }
         }, 3000);
     "
>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
            </span>
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Kanban Board</span>
        </div>
        <span class="text-[8px] font-bold text-indigo-600 bg-indigo-50 border border-indigo-100 px-1.5 py-0.5 rounded uppercase">Sprint 1</span>
    </div>
    
    <div class="grid grid-cols-3 gap-1.5 my-2.5">
        <div class="bg-slate-50 border border-slate-100 p-1.5 rounded-lg text-center h-[52px] flex flex-col justify-between">
            <span class="text-[7px] text-slate-400 font-bold uppercase">To Do</span>
            <div class="h-4"></div>
        </div>
        
        <div class="bg-slate-50 border border-slate-100 p-1.5 rounded-lg text-center h-[52px] flex flex-col justify-between relative overflow-hidden">
            <span class="text-[7px] text-slate-400 font-bold uppercase">In Progress</span>
            <div x-show="currentCol === 'Progress'" x-transition class="bg-white border border-slate-200/80 rounded px-1 py-0.5 shadow-xs text-[7px] font-bold text-slate-700 truncate leading-none">
                Secure SSL
            </div>
        </div>
        
        <div class="bg-slate-50 border border-slate-100 p-1.5 rounded-lg text-center h-[52px] flex flex-col justify-between relative overflow-hidden">
            <span class="text-[7px] text-slate-400 font-bold uppercase">Completed</span>
            <div x-show="currentCol === 'Review'" x-transition class="bg-amber-500 text-white border border-amber-500 rounded px-1 py-0.5 shadow-xs text-[7px] font-bold truncate leading-none animate-pulse">
                Review
            </div>
            <div x-show="currentCol === 'Done'" x-transition class="bg-emerald-500 text-white border border-emerald-500 rounded px-1 py-0.5 shadow-xs text-[7px] font-bold truncate leading-none">
                ✓ Secure SSL
            </div>
        </div>
    </div>
</div>
