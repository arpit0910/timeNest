<div class="{{ $class ?? 'bg-white rounded-2xl border border-neutral-200/60 p-4 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[160px] overflow-hidden' }}"
     x-data="{ 
         client: 'Wayne Ent.',
         status: 'New Lead',
         states: ['New Lead', 'Proposal Sent', 'Contract Signed'],
         idx: 0
     }"
     x-init="
         setInterval(() => {
             idx = (idx + 1) % states.length;
             status = states[idx];
         }, 3500);
     "
>
    <div class="flex items-center justify-between">
        <span class="text-[11px] font-bold text-neutral-500 uppercase tracking-wider">Clients CRM</span>
        <span :class="'text-[8px] font-bold px-1.5 py-0.5 rounded border transition-all duration-300 ' + 
              (status === 'Contract Signed' ? 'bg-emerald-50 border-emerald-200 text-emerald-700' : 
               status === 'Proposal Sent' ? 'bg-indigo-50 border-indigo-200 text-indigo-700' : 
               'bg-neutral-100 border-neutral-200 text-neutral-600')"
              x-text="status"></span>
    </div>
    <div class="mt-2 space-y-1.5 flex-1 flex flex-col justify-center">
        <div class="flex items-center justify-between text-[11px]">
            <span class="font-bold text-neutral-700" x-text="client"></span>
            <span class="text-indigo-600 font-bold text-[9px]">Active</span>
        </div>
        <div class="flex gap-1 h-1.5 my-1">
            <div class="flex-1 rounded-sm transition-all duration-500" :class="idx >= 0 ? 'bg-indigo-500' : 'bg-neutral-200'"></div>
            <div class="flex-1 rounded-sm transition-all duration-500" :class="idx >= 1 ? 'bg-indigo-400' : 'bg-neutral-200'"></div>
            <div class="flex-1 rounded-sm transition-all duration-500" :class="idx >= 2 ? 'bg-emerald-500' : 'bg-neutral-200'"></div>
        </div>
    </div>
</div>

