<div class="{{ $class ?? 'bg-white rounded-2xl border border-neutral-200/60 p-4 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[160px] overflow-hidden' }}"
     x-data="{ 
         departments: [
             { name: 'Engineering', capacity: 78, color: 'bg-indigo-500' },
             { name: 'Design', capacity: 90, color: 'bg-teal-500' },
             { name: 'Finance/Admin', capacity: 45, color: 'bg-amber-500' }
         ]
     }"
>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-neutral-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-neutral-500"></span>
            </span>
            <span class="text-[11px] font-bold text-neutral-500 uppercase tracking-wider">Department Allocation</span>
        </div>
        <span class="text-[8px] font-bold text-indigo-600 bg-indigo-50 border border-indigo-100 px-1.5 py-0.5 rounded uppercase">Full view</span>
    </div>
    
    <div class="mt-2 space-y-2 flex-1 flex flex-col justify-center">
        <template x-for="dept in departments" :key="dept.name">
            <div class="space-y-0.5">
                <div class="flex items-center justify-between text-[9px] font-bold text-neutral-600">
                    <span x-text="dept.name"></span>
                    <span x-text="dept.capacity + '% Capacity'"></span>
                </div>
                <div class="w-full h-2 bg-neutral-100 rounded-full overflow-hidden">
                    <div :class="'h-full rounded-full transition-all duration-1000 ease-out ' + dept.color"
                         :style="'width: ' + dept.capacity + '%'"></div>
                </div>
            </div>
        </template>
    </div>
</div>

