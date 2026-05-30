<div class="{{ $class ?? 'bg-white rounded-2xl border border-slate-200/60 p-4 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[160px] overflow-hidden' }}"
     x-data="{ 
         revenue: 842000,
         transactions: [
             { id: 1, name: 'Acme Corp', amount: '+₹12,500', time: 'Just now', type: 'incoming' },
             { id: 2, name: 'Alex M. (Salary)', amount: '-₹45,000', time: '2m ago', type: 'outgoing' }
         ],
         counter: 0
     }"
     x-init="
         setInterval(() => {
             counter = (counter + 1) % 3;
             if (counter === 0) {
                 transactions.unshift({ id: Date.now(), name: 'Globex Inc', amount: '+₹18,200', time: 'Just now', type: 'incoming' });
                 revenue += 18200;
             } else if (counter === 1) {
                 transactions.unshift({ id: Date.now(), name: 'Server Billing', amount: '-₹4,200', time: 'Just now', type: 'outgoing' });
                 revenue -= 4200;
             } else {
                 transactions.unshift({ id: Date.now(), name: 'Stark Ind.', amount: '+₹25,000', time: 'Just now', type: 'incoming' });
                 revenue += 25000;
             }
             if (transactions.length > 2) {
                 transactions.pop();
             }
             transactions.forEach((tx, idx) => {
                 if (idx > 0) tx.time = idx + 'm ago';
             });
         }, 4000);
     "
>
    <div class="flex items-center justify-between">
         <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider font-body">Cashflow</span>
         <span class="text-[8px] font-bold text-emerald-600 flex items-center gap-0.5 animate-pulse bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200">
             <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
             Live
         </span>
    </div>
    <div class="my-1">
         <h4 class="text-slate-900 font-bold text-base leading-none transition-all duration-300" x-text="'₹' + revenue.toLocaleString()"></h4>
         <span class="text-[9px] text-slate-400 font-semibold">Total Balance</span>
    </div>
    <div class="space-y-1 mt-1 flex-1 flex flex-col justify-end">
         <template x-for="tx in transactions" :key="tx.id">
             <div class="flex items-center justify-between p-1 rounded border text-[9px] transition-all duration-500"
                  :class="tx.type === 'incoming' ? 'bg-emerald-50/50 border-emerald-100 text-emerald-800' : 'bg-rose-50/50 border-rose-100 text-rose-800'"
                  x-transition:enter="transition ease-out duration-300"
                  x-transition:enter-start="opacity-0 -translate-y-2"
                  x-transition:enter-end="opacity-100 translate-y-0"
             >
                 <div class="truncate max-w-[90px]">
                     <p class="font-bold truncate" x-text="tx.name"></p>
                     <span class="text-[7px] opacity-60" x-text="tx.time"></span>
                 </div>
                 <span class="font-mono font-bold" x-text="tx.amount"></span>
             </div>
         </template>
    </div>
</div>
