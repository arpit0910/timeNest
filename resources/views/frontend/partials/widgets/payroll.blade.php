<div class="{{ $class ?? 'bg-white rounded-2xl border border-slate-200/60 p-4 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[160px] overflow-hidden' }}"
     x-data="{ 
         step: 0, 
         amount: 1420000, 
         steps: [
             { name: 'Calculated', status: 'done' },
             { name: 'Tax Compliance', status: 'doing' },
             { name: 'Disbursement', status: 'todo' }
         ]
     }"
     x-init="
         setInterval(() => {
             step = (step + 1) % 4;
             if (step === 0) {
                 steps[0].status = 'doing'; steps[1].status = 'todo'; steps[2].status = 'todo';
             } else if (step === 1) {
                 steps[0].status = 'done'; steps[1].status = 'doing'; steps[2].status = 'todo';
             } else if (step === 2) {
                 steps[0].status = 'done'; steps[1].status = 'done'; steps[2].status = 'doing';
             } else {
                 steps[0].status = 'done'; steps[1].status = 'done'; steps[2].status = 'done';
             }
         }, 3000);
     "
>
     <div class="flex items-center justify-between">
         <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Payroll</span>
         <span :class="'text-[8px] font-bold px-1.5 py-0.5 rounded border transition-colors duration-500 ' + 
               (step === 3 ? 'bg-emerald-50 border-emerald-200 text-emerald-700' : 'bg-amber-50 border-amber-200 text-amber-700')"
               x-text="step === 0 ? 'Review' : step === 1 ? 'Taxing' : step === 2 ? 'Sending' : 'Paid'"></span>
     </div>
     <div class="my-1">
         <p class="text-[8px] text-slate-400 font-bold uppercase leading-none">Payout Total</p>
         <p class="text-[12px] font-bold text-slate-800 mt-0.5" x-text="'₹' + amount.toLocaleString()"></p>
     </div>
     <div class="space-y-1 mt-1 flex-1 flex flex-col justify-end">
         <template x-for="(s, index) in steps">
             <div class="flex items-center justify-between text-[10px] transition-all duration-300">
                 <span :class="'font-semibold ' + (s.status === 'done' ? 'text-slate-400 line-through' : s.status === 'doing' ? 'text-indigo-600 font-bold' : 'text-slate-400')" x-text="s.name"></span>
                 <div class="flex items-center">
                     <template x-if="s.status === 'done'">
                         <div class="w-3.5 h-3.5 rounded-full bg-emerald-500 flex items-center justify-center text-white">
                             <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                         </div>
                     </template>
                     <template x-if="s.status === 'doing'">
                         <span class="relative flex h-1.5 w-1.5">
                             <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                             <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-indigo-500"></span>
                         </span>
                     </template>
                     <template x-if="s.status === 'todo'">
                         <span class="w-1.5 h-1.5 rounded-full bg-slate-200"></span>
                     </template>
                 </div>
             </div>
         </template>
     </div>
</div>
