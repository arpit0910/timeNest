<div class="{{ $class ?? 'bg-white rounded-2xl border border-slate-200/60 p-4 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[160px] overflow-hidden' }}"
     x-data="{ 
         status: 'Pending', 
         user: 'Sarah K.',
         type: 'Annual Leave'
     }"
     x-init="
         setInterval(() => {
             status = status === 'Pending' ? 'Approved' : 'Pending';
         }, 3000);
     "
>
    <div class="flex items-center justify-between">
        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Leave Requests</span>
        <span :class="'text-[8px] font-bold px-1.5 py-0.5 rounded border transition-all duration-500 ' + 
              (status === 'Approved' ? 'bg-emerald-50 border-emerald-200 text-emerald-700' : 'bg-amber-50 border-amber-200 text-amber-700')"
              x-text="status"></span>
    </div>
    <div class="mt-2 space-y-1.5 flex-1 flex flex-col justify-center">
        <div class="flex items-center justify-between text-[11px]">
            <span class="font-semibold text-slate-700" x-text="user"></span>
            <span class="text-slate-400 text-[9px]">3 Days</span>
        </div>
        <div class="bg-slate-50 border border-slate-100 p-1.5 rounded-lg flex items-center justify-between">
            <div>
                <p class="text-[7px] text-slate-400 font-bold uppercase">Leave Type</p>
                <p class="text-[9px] font-bold text-slate-700" x-text="type"></p>
            </div>
            <div :class="'w-5 h-5 rounded-full flex items-center justify-center border transition-all duration-500 ' + 
                 (status === 'Approved' ? 'bg-emerald-500 border-emerald-500 text-white' : 'bg-slate-50 border-slate-200 text-slate-400')">
                 <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </div>
        </div>
    </div>
</div>
