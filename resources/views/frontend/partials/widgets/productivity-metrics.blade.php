<div class="{{ $class ?? 'bg-white rounded-2xl border border-slate-200/60 p-4 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[160px] overflow-hidden' }}"
     x-data="{ 
         focusTime: 72,
         meetings: 28
     }"
     x-init="
         setInterval(() => {
             if (focusTime === 72) {
                 focusTime = 80;
                 meetings = 20;
             } else {
                 focusTime = 72;
                 meetings = 28;
             }
         }, 4000);
     "
>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
            </span>
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Productivity Insights</span>
        </div>
        <span class="text-[8px] font-bold text-slate-400 font-mono">Live Logs</span>
    </div>
    
    <div class="flex items-center justify-around my-2">
        <div class="text-left space-y-1">
            <div>
                <p class="text-[7px] text-slate-400 font-bold uppercase">Focus Hours</p>
                <p class="text-[12px] font-bold text-slate-800" x-text="focusTime + '%'"></p>
            </div>
            <div>
                <p class="text-[7px] text-slate-400 font-bold uppercase">Meetings</p>
                <p class="text-[12px] font-bold text-indigo-500" x-text="meetings + '%'"></p>
            </div>
        </div>
        
        <!-- Bar Chart Comparison -->
        <div class="flex items-end gap-3 h-14 w-12 pb-1 border-b border-slate-100">
            <div class="w-4 bg-emerald-500 rounded-t transition-all duration-1000 ease-out"
                 :style="'height: ' + focusTime + '%'"></div>
            <div class="w-4 bg-indigo-400 rounded-t transition-all duration-1000 ease-out"
                 :style="'height: ' + meetings + '%'"></div>
        </div>
    </div>

    <div class="border-t border-slate-100 pt-2 flex items-center justify-between text-[8px] font-bold text-emerald-600">
        <span>Goal (Focus > 70%)</span>
        <span>Achieved</span>
    </div>
</div>
