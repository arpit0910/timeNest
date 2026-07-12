<div class="{{ $class ?? 'bg-white rounded-2xl border border-slate-200/60 p-4 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[160px] overflow-hidden' }}"
     x-data="{ 
         value: 94.2, 
         points: [
             'M0 35 L20 28 L40 32 L60 18 L80 22 L100 12',
             'M0 35 L20 30 L40 24 L60 28 L80 14 L100 8',
             'M0 35 L20 25 L40 32 L60 16 L80 10 L100 5'
         ],
         idx: 0
     }"
     x-init="
         setInterval(() => { 
             idx = (idx + 1) % points.length; 
             value = idx === 0 ? 94.2 : idx === 1 ? 96.5 : 98.1;
         }, 2500);
     "
>
     <div class="flex items-center justify-between">
         <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider font-body">Productivity</span>
         <span class="text-[9px] font-bold text-teal-600 bg-teal-50 px-1.5 py-0.5 rounded border border-teal-200 transition-all duration-300" x-text="value + '%'"></span>
     </div>
     <div class="relative h-[45px] mt-2 flex-1 flex items-end">
         <svg class="w-full h-full" viewBox="0 0 100 40" fill="none">
             <line x1="0" y1="20" x2="100" y2="20" stroke="#f1f5f9" stroke-width="1" stroke-dasharray="2 2" />
             <line x1="0" y1="10" x2="100" y2="10" stroke="#e2e8f0" stroke-width="1" stroke-dasharray="2 2" />
             <path :d="points[idx]" stroke="#14b8a6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" fill="none" class="transition-all duration-1000 ease-in-out"/>
             <circle :cx="100" :cy="idx === 0 ? 12 : idx === 1 ? 8 : 5" r="3" fill="#14b8a6" class="transition-all duration-1000 ease-in-out"/>
             <circle :cx="100" :cy="idx === 0 ? 12 : idx === 1 ? 8 : 5" r="6" fill="#14b8a6" class="transition-all duration-1000 ease-in-out animate-ping opacity-30"/>
         </svg>
     </div>
</div>
