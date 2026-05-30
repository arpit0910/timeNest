<div class="{{ $class ?? 'bg-white rounded-2xl border border-slate-200/60 p-4 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between h-[160px]' }}"
     x-data="{ paid: false, amount: 24500 }"
     x-init="setInterval(() => { paid = !paid; }, 3500)"
>
     <div class="flex items-center justify-between">
         <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Freelancer Invoice</span>
         <span :class="'text-[8px] font-bold px-1.5 py-0.5 rounded border transition-all duration-300 ' + (paid ? 'bg-emerald-50 border-emerald-200 text-emerald-700' : 'bg-amber-50 border-amber-200 text-amber-700')" x-text="paid ? 'Paid' : 'Pending'"></span>
     </div>
     <div class="mt-3 flex items-center justify-between text-xs flex-1">
         <div>
             <p class="font-bold text-slate-700 text-[10px]">Client: Acme Corp</p>
             <p class="text-[9px] text-slate-500 font-semibold mt-0.5" x-text="'₹' + amount.toLocaleString()"></p>
         </div>
         <div :class="'flex items-center justify-center w-6 h-6 rounded-full border transition-all duration-500 ' + (paid ? 'bg-emerald-500 border-emerald-500 text-white scale-110 shadow-sm shadow-emerald-500/30' : 'bg-slate-50 border-slate-200 text-slate-400')">
             <svg class="w-3.5 h-3.5 transition-transform duration-300" :class="paid ? 'scale-100 rotate-0' : 'scale-50 -rotate-12'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
         </div>
     </div>
</div>
