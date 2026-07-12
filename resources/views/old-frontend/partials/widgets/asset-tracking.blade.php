<div class="{{ $class ?? 'bg-white rounded-2xl border border-slate-200/60 p-4 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[160px] overflow-hidden' }}"
     x-data="{ 
         assets: [
             { label: 'Workstation Mac', type: 'Hardware', status: 'Assigned' },
             { label: 'Cloud Sandbox', type: 'SaaS License', status: 'Provisioning' }
         ]
     }"
     x-init="
         setInterval(() => {
             let prov = assets.find(a => a.status === 'Provisioning');
             if (prov) {
                 prov.status = 'Assigned';
             } else {
                 assets[1].status = 'Provisioning';
             }
         }, 3500);
     "
>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-slate-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-slate-500"></span>
            </span>
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Asset Management</span>
        </div>
        <span class="text-[8px] font-bold text-slate-400 uppercase tracking-wider">Inventory</span>
    </div>
    
    <div class="mt-2 space-y-2 flex-1 flex flex-col justify-center">
        <template x-for="ast in assets" :key="ast.label">
            <div class="bg-slate-50 border border-slate-100 p-2 rounded-xl flex items-center justify-between transition-all duration-500">
                <div class="text-left">
                    <span class="text-[10px] font-bold text-slate-700 block" x-text="ast.label"></span>
                    <span class="text-[7px] text-slate-400 font-bold uppercase" x-text="ast.type"></span>
                </div>
                <span :class="'text-[8px] font-bold px-1.5 py-0.5 rounded border transition-all duration-500 ' + 
                      (ast.status === 'Assigned' ? 'bg-emerald-50 border-emerald-200 text-emerald-700' : 'bg-amber-50 border-amber-200 text-amber-700')"
                      x-text="ast.status"></span>
            </div>
        </template>
    </div>
</div>
