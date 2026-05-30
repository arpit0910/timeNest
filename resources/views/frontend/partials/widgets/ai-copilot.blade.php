<div class="{{ $class ?? 'bg-white rounded-2xl border border-slate-200/60 p-4 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between h-[160px]' }}"
     x-data="{ 
         insights: [
             { text: 'Design team overtime up 15%. Balance recommended.', type: 'warning', color: 'text-amber-700 bg-amber-50 border-amber-100' },
             { text: 'Forecast: Revenue projected to hit +12% this Q.', type: 'forecast', color: 'text-emerald-700 bg-emerald-50 border-emerald-100' },
             { text: 'Anomaly: Developer clocked in outside geofence.', type: 'alert', color: 'text-rose-700 bg-rose-50 border-rose-100' }
         ],
         active: 0
     }"
     x-init="setInterval(() => { active = (active + 1) % insights.length; }, 4000)"
>
     <div class="flex items-center justify-between">
         <div class="flex items-center gap-1">
             <svg class="w-3.5 h-3.5 text-indigo-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
             <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">AI Copilot</span>
         </div>
         <span class="text-[8px] bg-indigo-50 text-indigo-600 border border-indigo-100 rounded px-1.5 py-0.5 font-bold uppercase">Realtime</span>
     </div>
     <div class="mt-2 h-[55px] flex items-center relative flex-1">
         <template x-for="(ins, idx) in insights">
             <div x-show="active === idx" 
                  x-transition:enter="transition ease-out duration-300"
                  x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                  x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                  x-transition:leave="transition ease-in duration-200 absolute"
                  x-transition:leave-start="opacity-100 translate-y-0"
                  x-transition:leave-end="opacity-0 -translate-y-2"
                  class="text-[9px] p-2 rounded-lg border font-semibold leading-relaxed w-full"
                  :class="ins.color"
             >
                 <div class="flex justify-between items-center mb-0.5 text-[7px] uppercase tracking-wider font-bold opacity-75">
                     <span x-text="ins.type"></span>
                     <span>Just now</span>
                 </div>
                 <span x-text="ins.text"></span>
             </div>
         </template>
     </div>
</div>
