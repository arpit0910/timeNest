<div class="{{ $class ?? 'bg-white rounded-2xl border border-neutral-200/60 p-4 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[160px] overflow-hidden' }}"
     x-data="{ 
         items: [
             { id: 1, name: 'Setup environment', done: true },
             { id: 2, name: 'Build dashboard UI', done: false },
             { id: 3, name: 'API integration', done: false }
         ]
     }"
     x-init="
         setInterval(() => {
             items[1].done = !items[1].done;
             if (items[1].done) {
                 items[2].done = false;
             } else {
                 items[2].done = Math.random() > 0.5;
             }
         }, 3000);
     "
>
    <div class="flex items-center justify-between">
        <span class="text-[11px] font-bold text-neutral-500 uppercase tracking-wider">Tasks</span>
        <span class="text-[8px] font-bold px-1.5 py-0.5 rounded border bg-indigo-50 border-indigo-200 text-indigo-700"
              x-text="items.filter(i => i.done).length + '/' + items.length + ' Done'"></span>
    </div>
    <div class="mt-2 space-y-1.5 flex-1 flex flex-col justify-center">
        <template x-for="item in items" :key="item.id">
            <div class="flex items-center justify-between text-[10px] transition-all duration-300">
                <span :class="item.done ? 'text-neutral-400 line-through' : 'text-neutral-700 font-semibold'" x-text="item.name"></span>
                <div :class="'w-3.5 h-3.5 rounded border flex items-center justify-center transition-all duration-300 ' + 
                     (item.done ? 'bg-indigo-500 border-indigo-500 text-white' : 'border-neutral-300 bg-white')">
                     <svg x-show="item.done" class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </div>
            </div>
        </template>
    </div>
</div>

