<div class="{{ $class ?? 'bg-white rounded-2xl border border-slate-200/60 p-4 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between h-[160px]' }}"
     x-data="{ 
         stage: 'Leads', 
         deals: [
             { name: 'Acme Deal', val: '₹1.2L', bg: 'bg-indigo-500' },
             { name: 'Wayne Corp', val: '₹3.5L', bg: 'bg-teal-500' },
             { name: 'Stark Tech', val: '₹5.0L', bg: 'bg-purple-500' }
         ],
         idx: 0
     }"
     x-init="
         setInterval(() => {
             idx = (idx + 1) % 4;
             stage = idx === 0 ? 'Leads' : idx === 1 ? 'Proposal' : idx === 2 ? 'Negotiation' : 'Closed Won';
         }, 3500);
     "
>
     <div class="flex items-center justify-between">
         <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider font-body">Sales Pipeline</span>
         <span :class="'text-[8px] font-bold px-1.5 py-0.5 rounded border transition-all duration-500 ' + 
               (stage === 'Closed Won' ? 'bg-emerald-50 border-emerald-200 text-emerald-700' : 'bg-indigo-50 border-indigo-200 text-indigo-700')"
               x-text="stage"></span>
     </div>
     <div class="mt-2 space-y-1 flex-1 flex flex-col justify-end">
         <div class="flex justify-between items-center text-[9px]">
             <span class="text-slate-400 font-semibold">Pipeline Value</span>
             <span class="font-bold text-slate-800">₹9.7L</span>
         </div>
         <!-- Funnel Progress Steps -->
         <div class="flex gap-1 h-1.5 my-1.5">
             <div class="flex-1 rounded-sm transition-all duration-500" :class="idx >= 0 ? 'bg-indigo-500' : 'bg-slate-200'"></div>
             <div class="flex-1 rounded-sm transition-all duration-500" :class="idx >= 1 ? 'bg-indigo-400' : 'bg-slate-200'"></div>
             <div class="flex-1 rounded-sm transition-all duration-500" :class="idx >= 2 ? 'bg-indigo-300' : 'bg-slate-200'"></div>
             <div class="flex-1 rounded-sm transition-all duration-500" :class="idx >= 3 ? 'bg-emerald-500' : 'bg-slate-200'"></div>
         </div>
         <div class="bg-slate-50 border border-slate-100 rounded-lg p-1 flex flex-col gap-0.5 transition-all duration-300">
             <span class="text-[7px] text-slate-400 font-bold uppercase">Active Deal</span>
             <div class="flex justify-between items-center text-[9px]">
                 <span class="font-bold text-slate-700 truncate max-w-[80px]" x-text="deals[idx % 3].name"></span>
                 <span class="font-bold text-indigo-600" x-text="deals[idx % 3].val"></span>
             </div>
         </div>
     </div>
</div>
