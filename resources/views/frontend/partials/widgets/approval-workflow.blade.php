<div class="{{ $class ?? 'bg-white rounded-2xl border border-slate-200/60 p-4 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between h-[160px]' }}"
     x-data="{ 
         stages: [
             { name: 'Manager', status: 'Approved' },
             { name: 'HR Roster', status: 'Pending' },
             { name: 'Finance', status: 'Locked' }
         ]
     }"
     x-init="
         setInterval(() => {
             let hr = stages[1];
             let fin = stages[2];
             if (hr.status === 'Pending') {
                 hr.status = 'Approved';
                 fin.status = 'Pending';
             } else if (fin.status === 'Pending') {
                 fin.status = 'Approved';
             } else {
                 stages[1].status = 'Pending';
                 stages[2].status = 'Locked';
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
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Approval Workflow</span>
        </div>
        <span class="text-[8px] font-bold text-slate-400 uppercase tracking-wider">Leave Request #18</span>
    </div>
    
    <div class="flex items-center justify-between my-2.5 relative">
        <!-- Connecting Line -->
        <div class="absolute top-[18px] left-[15%] right-[15%] h-0.5 bg-slate-100 z-0">
            <div class="h-full bg-indigo-500 transition-all duration-1000"
                 :style="'width: ' + (stages[2].status === 'Approved' ? '100%' : stages[1].status === 'Approved' ? '50%' : '0%')"></div>
        </div>

        <template x-for="(stage, idx) in stages" :key="stage.name">
            <div class="flex flex-col items-center z-10 w-1/3">
                <div :class="'w-9 h-9 rounded-full flex items-center justify-center border font-bold text-[10px] transition-all duration-500 ' + 
                     (stage.status === 'Approved' ? 'bg-indigo-500 border-indigo-500 text-white shadow-lg shadow-indigo-500/20' : 
                      stage.status === 'Pending' ? 'bg-amber-400 border-amber-400 text-white animate-pulse' : 
                      'bg-white border-slate-200 text-slate-400')"
                >
                    <span x-show="stage.status === 'Approved'">✓</span>
                    <span x-show="stage.status === 'Pending'">?</span>
                    <span x-show="stage.status === 'Locked'">🔐</span>
                </div>
                <span class="text-[9px] font-bold text-slate-600 mt-1" x-text="stage.name"></span>
                <span class="text-[7px] font-semibold text-slate-400 uppercase mt-0.5" x-text="stage.status"></span>
            </div>
        </template>
    </div>
</div>
