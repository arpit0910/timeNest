<div class="{{ $class ?? 'bg-white rounded-2xl border border-slate-200/60 p-4 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[160px] overflow-hidden' }}"
     x-data="{ 
         insight: 'Analyzing team capacity trends...',
         status: 'thinking'
     }"
     x-init="
         let insights = [
             { text: 'Burnout Risk: engineering load is at 94%', status: 'Alert' },
             { text: 'Forecast: Q3 revenue on track (+12.4%)', status: 'OK' },
             { text: 'Audit Trigger: 3 anomalous logins from IP range', status: 'Secure' }
         ];
         let idx = 0;
         setInterval(() => {
             status = 'thinking';
             insight = 'AI model computing...';
             setTimeout(() => {
                 insight = insights[idx].text;
                 status = insights[idx].status;
                 idx = (idx + 1) % insights.length;
             }, 1200);
         }, 5000);
     "
>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-violet-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-violet-500"></span>
            </span>
            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">AI Operations Insights</span>
        </div>
        <span class="text-[8px] font-bold text-violet-600 bg-violet-50 border border-violet-100 px-1.5 py-0.5 rounded uppercase">Realtime</span>
    </div>
    
    <div class="my-2 p-2 bg-slate-900 border border-slate-950 rounded-xl flex items-center justify-between min-h-[50px] shadow-inner select-none transition-all duration-500">
        <p class="text-[9px] font-mono text-violet-300 text-left leading-normal flex-1" x-text="insight"></p>
    </div>

    <div class="flex items-center justify-between text-[8px] font-bold">
        <span class="text-slate-400 uppercase">Status</span>
        <span :class="'transition-all duration-500 ' + 
              (status === 'thinking' ? 'text-violet-500' : 
               status === 'Alert' ? 'text-rose-500 animate-pulse' : 
               status === 'Secure' ? 'text-blue-500' : 
               'text-emerald-500')"
              x-text="status.toUpperCase()"></span>
    </div>
</div>
