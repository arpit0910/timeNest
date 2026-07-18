<div class="{{ $class ?? 'bg-white rounded-2xl border border-neutral-200/60 p-4 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[160px] overflow-hidden' }}"
     x-data="{ 
         users: [
             { initials: 'AM', color: 'bg-indigo-500', name: 'Alex' },
             { initials: 'SK', color: 'bg-teal-500', name: 'Sarah' },
             { initials: 'DL', color: 'bg-purple-500', name: 'David' }
         ],
         activeCount: 2
     }"
     x-init="setInterval(() => { 
         activeCount = activeCount === 3 ? 2 : 3;
     }, 3000)"
>
     <div class="flex items-center justify-between mb-2">
         <span class="text-[11px] font-bold text-neutral-500 uppercase tracking-wider block">Workspace Hub</span>
         <span class="text-[8px] font-bold text-indigo-600 bg-indigo-50 border border-indigo-100 rounded px-1.5 py-0.5 animate-pulse" x-text="activeCount + ' Editing'"></span>
     </div>
     <div class="flex items-center gap-1.5 mt-2 flex-1">
         <!-- Avatars Stack -->
         <div class="flex -space-x-1.5 overflow-hidden shrink-0">
             <div class="inline-block h-6 w-6 rounded-full border-2 border-white bg-indigo-500 flex items-center justify-center font-bold text-white text-[8px]">AM</div>
             <div class="inline-block h-6 w-6 rounded-full border-2 border-white bg-teal-500 flex items-center justify-center font-bold text-white text-[8px]">SK</div>
             <div x-show="activeCount === 3" 
                  x-transition:enter="transition ease-out duration-300 scale-0"
                  x-transition:enter-start="scale-0"
                  x-transition:enter-end="scale-100"
                  x-transition:leave="transition ease-in duration-200"
                  x-transition:leave-end="scale-0"
                  class="inline-block h-6 w-6 rounded-full border-2 border-white bg-purple-500 flex items-center justify-center font-bold text-white text-[8px]"
             >DL</div>
         </div>
         <span class="text-[9px] text-neutral-500 font-semibold truncate" x-text="activeCount === 3 ? 'David joined' : 'Sarah editing...'"></span>
     </div>
</div>

