<div class="{{ $class ?? 'bg-white rounded-2xl border border-slate-200/60 p-4 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[160px] overflow-hidden' }}"
     x-data="{ 
         progress: 68,
         resolved: 24,
         total: 35
     }"
     x-init="
         setInterval(() => {
             if (progress < 90) {
                 progress += 8;
                 resolved += 2;
             } else {
                 progress = 60;
                 resolved = 21;
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
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Sprint Tracker</span>
        </div>
        <span class="text-[8px] font-bold text-slate-400 font-mono">Sprint 14</span>
    </div>
    
    <div class="my-2 space-y-2 flex-1 flex flex-col justify-center">
        <div class="bg-slate-50 border border-slate-100 p-2 rounded-xl flex items-center justify-between">
            <div class="text-left">
                <p class="text-[7px] text-slate-400 font-bold uppercase">Progress</p>
                <p class="text-[11px] font-bold text-slate-800"><span x-text="progress"></span>% Complete</p>
            </div>
            <div class="text-right">
                <p class="text-[7px] text-slate-400 font-bold uppercase">Tasks Resolved</p>
                <p class="text-[11px] font-bold text-indigo-600 font-mono"><span x-text="resolved"></span>/<span x-text="total"></span></p>
            </div>
        </div>
        
        <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
            <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full transition-all duration-1000 ease-out"
                 :style="'width: ' + progress + '%'"></div>
        </div>
    </div>
</div>
