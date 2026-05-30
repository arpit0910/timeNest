<div class="{{ $class ?? 'bg-white rounded-2xl border border-slate-200/60 p-4 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between h-[160px]' }}"
     x-data="{ 
         roles: [
             { name: 'Admin', read: true, write: true },
             { name: 'Member', read: true, write: false }
         ]
     }"
     x-init="
         setInterval(() => {
             roles[1].write = !roles[1].write;
         }, 3000);
     "
>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-violet-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-violet-500"></span>
            </span>
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Role Permission Matrix</span>
        </div>
        <span class="text-[8px] font-bold text-slate-400 uppercase tracking-wider font-mono">RBAC</span>
    </div>
    
    <div class="mt-2 space-y-1.5 flex-1 flex flex-col justify-center">
        <template x-for="r in roles" :key="r.name">
            <div class="flex items-center justify-between p-1.5 bg-slate-50 border border-slate-100 rounded-lg">
                <span class="text-[10px] font-bold text-slate-700 w-1/3" x-text="r.name"></span>
                
                <div class="flex items-center gap-3 w-2/3 justify-end text-[8px] font-bold">
                    <div class="flex items-center gap-1">
                        <span class="text-slate-450">Read</span>
                        <div class="w-6 h-3.5 bg-indigo-500 rounded-full p-0.5 transition-all">
                            <div class="w-2.5 h-2.5 bg-white rounded-full translate-x-2.5"></div>
                        </div>
                    </div>
                    <div class="flex items-center gap-1">
                        <span class="text-slate-450">Write</span>
                        <div :class="'w-6 h-3.5 rounded-full p-0.5 transition-all cursor-pointer ' + (r.write ? 'bg-indigo-500' : 'bg-slate-300')">
                            <div :class="'w-2.5 h-2.5 bg-white rounded-full transition-all ' + (r.write ? 'translate-x-2.5' : 'translate-x-0')"></div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>
