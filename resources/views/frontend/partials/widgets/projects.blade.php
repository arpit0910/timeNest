<div class="{{ $class ?? 'bg-white rounded-2xl border border-slate-200/60 p-4 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[160px] overflow-hidden' }}"
     x-data="{ 
         progress: 65, 
         tasks: [
             { name: 'Auth Module', status: 'done' },
             { name: 'API Gateway', status: 'doing' },
             { name: 'UI Polish', status: 'todo' }
         ]
     }"
     x-init="
         setInterval(() => {
             if (progress === 65) {
                 progress = 90;
                 tasks[1].status = 'done';
                 tasks[2].status = 'doing';
             } else if (progress === 90) {
                 progress = 100;
                 tasks[2].status = 'done';
             } else {
                 progress = 40;
                 tasks[0].status = 'done';
                 tasks[1].status = 'doing';
                 tasks[2].status = 'todo';
             }
         }, 4000);
     "
>
     <div class="flex items-center justify-between">
         <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Project Progress</span>
         <span :class="'text-[8px] font-semibold px-2 py-0.5 rounded-full border transition-all duration-300 ' + 
               (progress === 100 ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-indigo-50 text-indigo-600 border-indigo-100')" 
               x-text="progress === 100 ? 'Completed' : 'Active'"></span>
     </div>
     <div class="space-y-1.5 flex-1 flex flex-col justify-end mt-1">
         <div class="bg-slate-50 border border-slate-100 p-1.5 rounded-lg">
             <div class="flex justify-between items-center text-[10px] mb-0.5">
                 <span class="text-slate-800 font-bold">TimeNest Launch</span>
                 <span class="text-slate-500 font-bold" x-text="progress + '%'"></span>
             </div>
             <div class="w-full bg-slate-200 h-1 rounded-full overflow-hidden">
                 <div class="bg-indigo-600 h-full rounded-full transition-all duration-1000 ease-out" :style="'width: ' + progress + '%'"></div>
             </div>
         </div>
         <div class="space-y-0.5">
             <template x-for="task in tasks">
                 <div class="flex items-center justify-between text-[9px]">
                     <span class="font-semibold text-slate-600" x-text="task.name"></span>
                     <span :class="'text-[8px] font-bold ' + 
                           (task.status === 'done' ? 'text-emerald-600' : task.status === 'doing' ? 'text-indigo-600 animate-pulse' : 'text-slate-400')"
                           x-text="task.status === 'done' ? '✓ Done' : task.status === 'doing' ? 'Doing' : 'Todo'"></span>
                 </div>
             </template>
         </div>
     </div>
</div>
