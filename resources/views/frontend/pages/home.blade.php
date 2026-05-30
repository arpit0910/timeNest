<x-frontend-layout.app
    metaTitle="TimeNest — The Work Operating System for Modern Teams"
    metaDescription="Complete workforce management for organizations, freelancer tools, and collaborative workspaces. One platform for every workflow."
>
    {{-- Section 1: Hero --}}
    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden" 
        x-data="{ mx: 0, my: 0 }" 
        @mousemove.window="mx = ($event.clientX / window.innerWidth - 0.5) * 4; my = ($event.clientY / window.innerHeight - 0.5) * 3"
    >
        {{-- Layer 1: Gradient Background --}}
        <div class="absolute inset-0 bg-gradient-to-b from-slate-50 via-white to-white pointer-events-none"></div>
        <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/4 w-[900px] h-[600px] bg-gradient-to-br from-teal-100/40 via-indigo-100/30 to-purple-100/20 rounded-full blur-3xl opacity-60 pointer-events-none"></div>

        {{-- Layer 2: Micro-Dashboard Visualization Widgets --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
                       {{-- Widget: Attendance — Fingerprint sweep --}}
            <div class="hero-widget animate-float-gentle bg-white/80 backdrop-blur-md rounded-2xl border border-slate-200/60 p-4 shadow-lg shadow-slate-200/20"
                 style="top: 10%; left: 4%; width: 190px; z-index: 10;"
                 x-data="{ 
                     status: 'idle', 
                     progress: 0, 
                     user: ''
                 }"
                 x-init="
                     let users = ['Alex M.', 'Sarah K.', 'David L.'];
                     let idx = 0;
                     setInterval(() => {
                         status = 'scanning';
                         progress = 0;
                         user = users[idx];
                         idx = (idx + 1) % users.length;
                         
                         let interval = setInterval(() => {
                             progress += 5;
                             if (progress >= 100) {
                                 clearInterval(interval);
                                 status = 'verified';
                                 setTimeout(() => {
                                     status = 'idle';
                                 }, 1800);
                             }
                         }, 80);
                     }, 4000);
                 "
            >
                <div class="flex items-center gap-2">
                    <span class="relative flex h-2 w-2">
                        <span x-show="status === 'scanning'" class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                        <span x-show="status === 'verified'" class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span :class="'relative inline-flex rounded-full h-2 w-2 transition-colors duration-300 ' + (status === 'scanning' ? 'bg-amber-500' : status === 'verified' ? 'bg-emerald-500' : 'bg-slate-400')"></span>
                    </span>
                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Attendance</span>
                </div>
                <div class="relative flex items-center justify-center my-2.5 h-[50px] overflow-hidden rounded-lg bg-slate-50/50 border border-slate-100">
                    <!-- Grey Background Fingerprint -->
                    <svg class="absolute w-10 h-10 text-slate-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" d="M12 2a10 10 0 0 0-10 10v1a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-1a5 5 0 0 1 10 0v3a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a10 10 0 0 0-10-10z"/>
                        <path stroke-linecap="round" d="M8 12v3a4 4 0 0 0 8 0v-3a4 4 0 0 0-8 0z"/>
                        <path stroke-linecap="round" d="M10 12v1a2 2 0 0 0 4 0v-1a2 2 0 0 0-4 0z"/>
                    </svg>
                    <!-- Color Foreground Fingerprint -->
                    <div class="absolute inset-x-0 bottom-0 flex items-center justify-center overflow-hidden transition-all duration-100 ease-linear"
                         :style="'height: ' + (status === 'idle' ? '0' : progress) + '%'">
                        <div class="relative h-[50px] w-full flex items-center justify-center">
                            <svg :class="'w-10 h-10 transition-colors duration-300 ' + (status === 'scanning' ? 'text-amber-500' : 'text-teal-500')" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" d="M12 2a10 10 0 0 0-10 10v1a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-1a5 5 0 0 1 10 0v3a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a10 10 0 0 0-10-10z"/>
                                <path stroke-linecap="round" d="M8 12v3a4 4 0 0 0 8 0v-3a4 4 0 0 0-8 0z"/>
                                <path stroke-linecap="round" d="M10 12v1a2 2 0 0 0 4 0v-1a2 2 0 0 0-4 0z"/>
                            </svg>
                        </div>
                    </div>
                    <!-- Scanner Laser Line -->
                    <div class="absolute left-0 right-0 h-0.5 shadow-sm transition-all duration-100 ease-linear"
                         :class="status === 'scanning' ? 'bg-amber-500 shadow-amber-500/50' : status === 'verified' ? 'bg-teal-500 shadow-teal-500/50' : 'hidden'"
                         :style="'bottom: ' + (status === 'idle' ? '0' : progress) + '%'"></div>
                </div>
                <div class="text-center h-4 flex items-center justify-center">
                    <p x-show="status === 'idle'" class="text-[10px] font-bold text-slate-400">Place Finger</p>
                    <p x-show="status === 'scanning'" class="text-[10px] font-bold text-amber-600" x-text="'Scanning... ' + progress + '%'"></p>
                    <p x-show="status === 'verified'" class="text-[10px] font-bold text-emerald-600 animate-pulse" x-text="user + ' Verified'"></p>
                </div>
            </div>

            {{-- Widget: Employee Management — Dynamic Team Status list --}}
            <div class="hero-widget animate-float-gentle-reverse bg-white/80 backdrop-blur-md rounded-2xl border border-slate-200/60 p-4 shadow-lg shadow-slate-200/20" 
                 style="top: 8%; right: 4%; width: 200px; z-index: 10;"
                 x-data="{ 
                     employees: [
                         { name: 'Alex M.', status: 'active', initials: 'AM', bg: 'bg-indigo-100', text: 'text-indigo-600' },
                         { name: 'Sarah K.', status: 'active', initials: 'SK', bg: 'bg-teal-100', text: 'text-teal-600' },
                         { name: 'David L.', status: 'meeting', initials: 'DL', bg: 'bg-amber-100', text: 'text-amber-600' }
                     ] 
                 }"
                 x-init="setInterval(() => { 
                     employees[1].status = employees[1].status === 'active' ? 'offline' : 'active'; 
                     employees[2].status = employees[2].status === 'meeting' ? 'active' : 'meeting'; 
                 }, 3000)"
            >
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Team Status</span>
                    <span :class="'text-[9px] font-semibold px-2 py-0.5 rounded-full border transition-all duration-500 ' + 
                          (employees.filter(e => e.status === 'active').length >= 2 ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-slate-50 text-slate-600 border-slate-200')" 
                          x-text="employees.filter(e => e.status === 'active').length + ' Active'"></span>
                </div>
                <div class="mt-3 space-y-2">
                    <template x-for="emp in employees">
                        <div class="flex items-center justify-between text-xs transition-all duration-300">
                            <div class="flex items-center gap-2">
                                <div :class="'w-6 h-6 rounded-full flex items-center justify-center font-bold text-[9px] transition-colors duration-500 ' + emp.bg + ' ' + emp.text" x-text="emp.initials"></div>
                                <span class="font-semibold text-slate-700" x-text="emp.name"></span>
                            </div>
                            <span :class="'px-1.5 py-0.5 rounded text-[8px] font-bold border transition-all duration-500 flex items-center gap-1 ' + 
                                (emp.status === 'active' ? 'bg-emerald-50 border-emerald-200 text-emerald-700' : 
                                 emp.status === 'meeting' ? 'bg-amber-50 border-amber-200 text-amber-700' : 
                                 'bg-slate-100 border-slate-200 text-slate-500')"
                            >
                                <span :class="'w-1 h-1 rounded-full ' + 
                                    (emp.status === 'active' ? 'bg-emerald-500 animate-pulse' : 
                                     emp.status === 'meeting' ? 'bg-amber-500' : 
                                     'bg-slate-400')"></span>
                                <span x-text="emp.status === 'active' ? 'Active' : emp.status === 'meeting' ? 'Meeting' : 'Offline'"></span>
                            </span>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Widget: Finance — Mini cashflow transaction list + revenue increment --}}
            <div class="hero-widget animate-float-gentle bg-white/80 backdrop-blur-md rounded-2xl border border-slate-200/60 p-4 shadow-lg shadow-slate-200/20" 
                 style="top: 36%; right: 2%; width: 220px; z-index: 10;"
                 x-data="{ 
                     revenue: 842000,
                     transactions: [
                         { id: 1, name: 'Acme Corp', amount: '+₹12,500', time: 'Just now', type: 'incoming' },
                         { id: 2, name: 'Alex M. (Salary)', amount: '-₹45,000', time: '2m ago', type: 'outgoing' },
                         { id: 3, name: 'David L. (Bonus)', amount: '-₹8,000', time: '1h ago', type: 'outgoing' }
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
                         if (transactions.length > 3) {
                             transactions.pop();
                         }
                         transactions.forEach((tx, idx) => {
                             if (idx > 0) tx.time = idx + 'm ago';
                         });
                     }, 4000);
                 "
            >
                <div class="flex items-center justify-between">
                     <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Cashflow</span>
                     <span class="text-[9px] font-bold text-emerald-600 flex items-center gap-0.5 animate-pulse bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200">
                         <span class="w-1 h-1 rounded-full bg-emerald-500"></span>
                         Live
                     </span>
                </div>
                <div class="my-1.5">
                     <h4 class="text-slate-900 font-bold text-base leading-none transition-all duration-300" x-text="'₹' + revenue.toLocaleString()"></h4>
                     <span class="text-[9px] text-slate-400 font-semibold">Total Balance</span>
                </div>
                <div class="mt-2 space-y-1.5">
                     <template x-for="tx in transactions" :key="tx.id">
                         <div class="flex items-center justify-between p-1.5 rounded-lg border text-[9px] transition-all duration-500"
                              :class="tx.type === 'incoming' ? 'bg-emerald-50/50 border-emerald-100 text-emerald-800' : 'bg-rose-50/50 border-rose-100 text-rose-800'"
                              x-transition:enter="transition ease-out duration-300"
                              x-transition:enter-start="opacity-0 -translate-y-2"
                              x-transition:enter-end="opacity-100 translate-y-0"
                         >
                             <div class="truncate max-w-[100px]">
                                 <p class="font-bold truncate" x-text="tx.name"></p>
                                 <span class="text-[8px] opacity-60" x-text="tx.time"></span>
                             </div>
                             <span class="font-mono font-bold" x-text="tx.amount"></span>
                         </div>
                     </template>
                </div>
            </div>

            {{-- Widget: Payroll — Payout stages --}}
            <div class="hero-widget animate-float-gentle-reverse bg-white/80 backdrop-blur-md rounded-2xl border border-slate-200/60 p-4 shadow-lg shadow-slate-200/20" 
                 style="bottom: 16%; right: 3%; width: 190px; z-index: 10;"
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
                 <div class="flex items-center justify-between mb-2">
                     <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Payroll</span>
                     <span :class="'text-[9px] font-bold px-1.5 py-0.5 rounded border transition-colors duration-500 ' + 
                           (step === 3 ? 'bg-emerald-50 border-emerald-200 text-emerald-700' : 'bg-amber-50 border-amber-200 text-amber-700')"
                           x-text="step === 0 ? 'Review' : step === 1 ? 'Taxing' : step === 2 ? 'Sending' : 'Paid'"></span>
                 </div>
                 <div class="mb-3">
                     <p class="text-[8px] text-slate-400 font-bold uppercase leading-none">Payout Total</p>
                     <p class="text-[13px] font-bold text-slate-800 mt-0.5" x-text="'₹' + amount.toLocaleString()"></p>
                 </div>
                 <div class="space-y-1.5">
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
                                     <span class="relative flex h-2 w-2">
                                         <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                                         <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                                     </span>
                                 </template>
                                 <template x-if="s.status === 'todo'">
                                     <span class="w-2 h-2 rounded-full bg-slate-200"></span>
                                 </template>
                             </div>
                         </div>
                     </template>
                 </div>
            </div>

            {{-- Widget: Sales — Funnel stage shifting --}}
            <div class="hero-widget animate-float-gentle bg-white/80 backdrop-blur-md rounded-2xl border border-slate-200/60 p-4 shadow-lg shadow-slate-200/20" 
                 style="top: 26%; left: 2%; width: 170px; z-index: 10;"
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
                 <div class="flex items-center justify-between mb-2">
                     <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider font-body">Sales Pipeline</span>
                     <span :class="'text-[8px] font-bold px-1.5 py-0.5 rounded border transition-all duration-500 ' + 
                           (stage === 'Closed Won' ? 'bg-emerald-50 border-emerald-200 text-emerald-700' : 'bg-indigo-50 border-indigo-200 text-indigo-700')"
                           x-text="stage"></span>
                 </div>
                 <div class="mt-2 space-y-1.5">
                     <div class="flex justify-between items-center text-[9px]">
                         <span class="text-slate-400 font-semibold">Pipeline Value</span>
                         <span class="font-bold text-slate-800">₹9.7L</span>
                     </div>
                     <!-- Funnel Progress Steps -->
                     <div class="flex gap-1 h-2 my-2">
                         <div class="flex-1 rounded-sm transition-all duration-500" :class="idx >= 0 ? 'bg-indigo-500' : 'bg-slate-200'"></div>
                         <div class="flex-1 rounded-sm transition-all duration-500" :class="idx >= 1 ? 'bg-indigo-400' : 'bg-slate-200'"></div>
                         <div class="flex-1 rounded-sm transition-all duration-500" :class="idx >= 2 ? 'bg-indigo-300' : 'bg-slate-200'"></div>
                         <div class="flex-1 rounded-sm transition-all duration-500" :class="idx >= 3 ? 'bg-emerald-500' : 'bg-slate-200'"></div>
                     </div>
                     <div class="bg-slate-50 border border-slate-100 rounded-lg p-1.5 flex flex-col gap-1 transition-all duration-300">
                         <span class="text-[7px] text-slate-400 font-bold uppercase">Active Deal</span>
                         <div class="flex justify-between items-center text-[9px]">
                             <span class="font-bold text-slate-700 truncate max-w-[80px]" x-text="deals[idx % 3].name"></span>
                             <span class="font-bold text-indigo-600" x-text="deals[idx % 3].val"></span>
                         </div>
                     </div>
                 </div>
            </div>

            {{-- Widget: Projects — Kanban task progress incrementing --}}
            <div class="hero-widget animate-float-gentle-reverse bg-white/80 backdrop-blur-md rounded-2xl border border-slate-200/60 p-4 shadow-lg shadow-slate-200/20" 
                 style="bottom: 18%; left: 2%; width: 210px; z-index: 10;"
                 x-data="{ 
                     progress: 65, 
                     tasks: [
                         { name: 'Auth Module', status: 'done' },
                         { name: 'API Gateway', status: 'doing' },
                         { name: 'UI Polish', status: 'todo' }
                     ]
                 }"
                 x-init="
                     setInterval(() => {
                         if (progress === 65) {
                             progress = 90;
                             tasks[1].status = 'done';
                             tasks[2].status = 'doing';
                         } else if (progress === 90) {
                             progress = 100;
                             tasks[2].status = 'done';
                         } else {
                             progress = 40;
                             tasks[0].status = 'done';
                             tasks[1].status = 'doing';
                             tasks[2].status = 'todo';
                         }
                     }, 4000);
                 "
            >
                 <div class="flex items-center justify-between mb-2.5">
                     <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Project Progress</span>
                     <span :class="'text-[9px] font-semibold px-2 py-0.5 rounded-full border transition-all duration-300 ' + 
                           (progress === 100 ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-indigo-50 text-indigo-600 border-indigo-100')" 
                           x-text="progress === 100 ? 'Completed' : 'Active'"></span>
                 </div>
                 <div class="space-y-2">
                     <div class="bg-slate-50 border border-slate-100 p-2 rounded-lg">
                         <div class="flex justify-between items-center text-[10px] mb-1">
                             <span class="text-slate-800 font-bold">TimeNest Launch</span>
                             <span class="text-slate-500 font-bold" x-text="progress + '%'"></span>
                         </div>
                         <div class="w-full bg-slate-200 h-1.5 rounded-full overflow-hidden">
                             <div class="bg-indigo-600 h-full rounded-full transition-all duration-1000 ease-out" :style="'width: ' + progress + '%'"></div>
                         </div>
                     </div>
                     <div class="space-y-1">
                         <template x-for="task in tasks">
                             <div class="flex items-center justify-between text-[9px]">
                                 <span class="font-semibold text-slate-600" x-text="task.name"></span>
                                 <span :class="'text-[8px] font-bold ' + 
                                       (task.status === 'done' ? 'text-emerald-600' : task.status === 'doing' ? 'text-indigo-600 animate-pulse' : 'text-slate-400')"
                                       x-text="task.status === 'done' ? '✓ Done' : task.status === 'doing' ? 'Doing' : 'Todo'"></span>
                             </div>
                         </template>
                     </div>
                 </div>
            </div>

            {{-- Widget: Analytics — Productivity dynamic counter --}}
            <div class="hero-widget animate-float-gentle bg-white/80 backdrop-blur-md rounded-2xl border border-slate-200/60 p-4 shadow-lg shadow-slate-200/20" 
                 style="bottom: 28%; right: 12%; width: 210px; z-index: 10;"
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
                 <div class="flex items-center justify-between mb-2">
                     <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider font-body">Productivity</span>
                     <span class="text-[9px] font-bold text-teal-600 bg-teal-50 px-1.5 py-0.5 rounded border border-teal-200 transition-all duration-300" x-text="value + '%'"></span>
                 </div>
                 <div class="relative h-[45px] mt-3">
                     <svg class="w-full h-full" viewBox="0 0 100 40" fill="none">
                         <line x1="0" y1="20" x2="100" y2="20" stroke="#f1f5f9" stroke-width="1" stroke-dasharray="2 2" />
                         <line x1="0" y1="10" x2="100" y2="10" stroke="#e2e8f0" stroke-width="1" stroke-dasharray="2 2" />
                         <path :d="points[idx]" stroke="#14b8a6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" fill="none" class="transition-all duration-1000 ease-in-out"/>
                         <circle :cx="100" :cy="idx === 0 ? 12 : idx === 1 ? 8 : 5" r="3" fill="#14b8a6" class="transition-all duration-1000 ease-in-out"/>
                         <circle :cx="100" :cy="idx === 0 ? 12 : idx === 1 ? 8 : 5" r="6" fill="#14b8a6" class="transition-all duration-1000 ease-in-out animate-ping opacity-30"/>
                     </svg>
                 </div>
            </div>

            {{-- Widget: AI — Rotating insight logs --}}
            <div class="hero-widget animate-float-gentle bg-white/80 backdrop-blur-md rounded-2xl border border-slate-200/60 p-4 shadow-lg shadow-slate-200/20" 
                 style="top: 50%; left: 3%; width: 210px; z-index: 10;"
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
                 <div class="flex items-center justify-between mb-2">
                     <div class="flex items-center gap-1.5">
                         <svg class="w-3.5 h-3.5 text-indigo-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                         <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">AI Copilot</span>
                     </div>
                     <span class="text-[8px] bg-indigo-50 text-indigo-600 border border-indigo-100 rounded px-1.5 py-0.5 font-bold uppercase">Realtime</span>
                 </div>
                 <div class="mt-2 h-[55px] flex items-center relative">
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
                             <div class="flex justify-between items-center mb-1 text-[7px] uppercase tracking-wider font-bold opacity-75">
                                 <span x-text="ins.type"></span>
                                 <span>Just now</span>
                             </div>
                             <span x-text="ins.text"></span>
                         </div>
                     </template>
                 </div>
            </div>

            {{-- Widget: Freelancers — Checkmark toggling with paid/sent --}}
            <div class="hero-widget animate-float-gentle-reverse bg-white/80 backdrop-blur-md rounded-2xl border border-slate-200/60 p-4 shadow-lg shadow-slate-200/20" 
                 style="top: 22%; right: 18%; width: 190px; z-index: 10;"
                 x-data="{ paid: false, amount: 24500 }"
                 x-init="setInterval(() => { paid = !paid; }, 3500)"
            >
                 <div class="flex items-center justify-between">
                     <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Freelancer Invoice</span>
                     <span :class="'text-[8px] font-bold px-1.5 py-0.5 rounded border transition-all duration-300 ' + (paid ? 'bg-emerald-50 border-emerald-200 text-emerald-700' : 'bg-amber-50 border-amber-200 text-amber-700')" x-text="paid ? 'Paid' : 'Pending'"></span>
                 </div>
                 <div class="mt-3 flex items-center justify-between text-xs">
                     <div>
                         <p class="font-bold text-slate-700 text-[10px]">Client: Acme Corp</p>
                         <p class="text-[9px] text-slate-500 font-semibold mt-0.5" x-text="'₹' + amount.toLocaleString()"></p>
                     </div>
                     <div :class="'flex items-center justify-center w-6 h-6 rounded-full border transition-all duration-500 ' + (paid ? 'bg-emerald-500 border-emerald-500 text-white scale-110 shadow-sm shadow-emerald-500/30' : 'bg-slate-50 border-slate-200 text-slate-400')">
                         <svg class="w-3.5 h-3.5 transition-transform duration-300" :class="paid ? 'scale-100 rotate-0' : 'scale-50 -rotate-12'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                     </div>
                 </div>
            </div>

            {{-- Widget: Workspace — Dynamic collaborator initials --}}
            <div class="hero-widget animate-float-gentle bg-white/80 backdrop-blur-md rounded-2xl border border-slate-200/60 p-4 shadow-lg shadow-slate-200/20" 
                 style="bottom: 6%; left: 16%; width: 190px; z-index: 10;"
                 x-data="{ 
                     users: [
                         { initials: 'AM', color: 'bg-indigo-500', name: 'Alex' },
                         { initials: 'SK', color: 'bg-teal-500', name: 'Sarah' },
                         { initials: 'DL', color: 'bg-purple-500', name: 'David' }
                     ],
                     activeCount: 2
                 }"
                 x-init="setInterval(() => { 
                     activeCount = activeCount === 3 ? 2 : 3;
                 }, 3000)"
            >
                 <div class="flex items-center justify-between mb-2">
                     <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block">Workspace Hub</span>
                     <span class="text-[8px] font-bold text-indigo-600 bg-indigo-50 border border-indigo-100 rounded px-1.5 py-0.5 animate-pulse" x-text="activeCount + ' Editing'"></span>
                 </div>
                 <div class="flex items-center gap-1.5 mt-3">
                     <!-- Avatars Stack -->
                     <div class="flex -space-x-1.5 overflow-hidden shrink-0">
                         <div class="inline-block h-6 w-6 rounded-full border-2 border-white bg-indigo-500 flex items-center justify-center font-bold text-white text-[8px]">AM</div>
                         <div class="inline-block h-6 w-6 rounded-full border-2 border-white bg-teal-500 flex items-center justify-center font-bold text-white text-[8px]">SK</div>
                         <div x-show="activeCount === 3" 
                              x-transition:enter="transition ease-out duration-300 scale-0"
                              x-transition:enter-start="scale-0"
                              x-transition:enter-end="scale-100"
                              x-transition:leave="transition ease-in duration-200"
                              x-transition:leave-end="scale-0"
                              class="inline-block h-6 w-6 rounded-full border-2 border-white bg-purple-500 flex items-center justify-center font-bold text-white text-[8px]"
                         >DL</div>
                     </div>
                     <span class="text-[9px] text-slate-500 font-semibold truncate" x-text="activeCount === 3 ? 'David joined' : 'Sarah editing...'"></span>
                 </div>
            </div>
        </div>

        {{-- Layer 3: Hero Content --}}
        <div class="relative z-30 max-w-7xl mx-auto px-6 lg:px-8 text-center">
            {{-- Announcement Pill --}}
            <div class="opacity-0 animate-hero-fade-up" style="animation-delay: 0ms;">
                <x-frontend-base.badge color="teal" size="md" :dot="true" :pulse="true" class="mb-8 inline-flex">
                    TimeNest 2.0 is now live
                </x-frontend-base.badge>
            </div>
            
            {{-- Main Heading with mouse parallax --}}
            <div :style="'transform: translate3d(' + mx + 'px, ' + my + 'px, 0)'" class="transition-transform duration-700 ease-out">
                <h1 class="font-display text-5xl lg:text-7xl font-bold text-content-strong tracking-tight mb-2 leading-tight">
                    <span class="block opacity-0 animate-hero-fade-up" style="animation-delay: 200ms;">The Work Operating System</span>
                    <span class="relative inline-block opacity-0 animate-hero-fade-up" style="animation-delay: 400ms;">
                        <span class="hero-text-glow"></span>
                        <span class="relative text-gradient-animated">for Modern Teams</span>
                    </span>
                </h1>
            </div>
            
            {{-- Subheading --}}
            <p class="text-lg lg:text-xl text-content-muted max-w-3xl mx-auto mb-10 leading-relaxed font-body opacity-0 animate-hero-fade-up" style="animation-delay: 600ms;">
                Manage employees, freelancers, and collaborative workspaces in one powerful platform. 
                From automated attendance tracking to AI-powered revenue forecasting — everything your team needs to scale.
            </p>
            
            {{-- CTA Buttons --}}
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 opacity-0 animate-hero-fade-up" style="animation-delay: 800ms;">
                <x-frontend-base.button href="/register" variant="primary" color="brand" size="lg" class="w-full sm:w-auto h-14 px-8 text-base" iconRight="<svg class='w-4 h-4' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2.5' d='M9 5l7 7-7 7'/></svg>">
                    Start for Free
                </x-frontend-base.button>
                <x-frontend-base.button href="{{ route('frontend.book-demo') }}" variant="outline" color="brand" size="lg" class="w-full sm:w-auto h-14 px-8 text-base">
                    Book a Demo
                </x-frontend-base.button>
            </div>

            {{-- Dashboard Preview --}}
            <div class="mt-16 relative mx-auto max-w-5xl opacity-0 animate-hero-fade-up" style="animation-delay: 1000ms;">
                {{-- Decorative Glow behind Dashboard Preview --}}
                <div class="absolute inset-0 -top-12 bg-gradient-to-tr from-brand-500/10 to-indigo-500/10 rounded-[2.5rem] transform rotate-1 scale-102 blur-2xl pointer-events-none"></div>
                <div class="relative bg-white/30 backdrop-blur-md rounded-2xl p-2.5 border border-slate-200/50 shadow-2xl">
                    <img src="/images/mockups/hero-dashboard.png" alt="TimeNest Work OS Dashboard" class="rounded-xl border border-slate-100/50 shadow-sm w-full">
                </div>
            </div>
            
            {{-- Ticker Component --}}
            <div class="mt-24 pt-10 border-t border-surface-border/50 opacity-0 animate-hero-fade-up" style="animation-delay: 1200ms;">
                <p class="text-center text-sm font-semibold text-content-muted uppercase tracking-wider mb-8">Trusted by forward-thinking teams globally</p>
                <x-frontend-sections.ticker :items="[
                    ['name' => 'Acme Corp', 'icon' => '<path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M13 10V3L4 14h7v7l9-11h-7z\'/>'],
                    ['name' => 'Stark Industries', 'icon' => '<path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4\'/>'],
                    ['name' => 'Wayne Ent', 'icon' => '<path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3\'/>'],
                    ['name' => 'Globex', 'icon' => '<path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9\'/>'],
                    ['name' => 'Soylent', 'icon' => '<path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10\'/>'],
                    ['name' => 'Initech', 'icon' => '<path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z\'/>'],
                ]" />
            </div>
        </div>
    </section>

    {{-- Section 2: Role-Based Problem Statement --}}
    <section class="py-24 bg-white" x-data="{ activeTab: 'founders' }">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="font-display text-3xl lg:text-4xl font-bold text-content-strong mb-4">Built for everyone who runs work</h2>
                <p class="text-content-muted text-lg">Whether you're a founder scaling a company or a freelancer managing clients, TimeNest adapts to your specific workflow.</p>
            </div>

            <div class="flex flex-wrap justify-center gap-2 mb-12">
                @foreach([
                    'founders' => ['Founders', 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6'], 
                    'hr' => ['HR Teams', 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'], 
                    'operations' => ['Operations', 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z'], 
                    'freelancers' => ['Freelancers', 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'], 
                    'agencies' => ['Agencies', 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4']
                ] as $key => [$label, $icon])
                    <button @click="activeTab = '{{ $key }}'" :class="activeTab === '{{ $key }}' ? 'bg-brand-500 text-white shadow-md shadow-brand-500/20' : 'bg-white border border-surface-border text-content-muted hover:text-content-strong hover:bg-surface-50'" class="px-5 py-3 rounded-xl text-sm font-body font-medium transition-all cursor-pointer flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/></svg>
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            <div class="rounded-2xl border border-surface-border bg-white shadow-xl shadow-surface-border/30 overflow-hidden">
                @php
                    $roleData = [
                        'founders' => [
                            'pain' => 'Juggling 5+ tools for HR, attendance, leaves, and payroll. No unified view of workforce health and ballooning software costs.',
                            'solution' => 'One platform to manage your entire workforce. Real-time executive dashboards, AI-powered insights, and automated workflows.',
                            'modules' => ['Employee Management', 'AI Executive Dashboard', 'Analytics & Reports', 'Approvals & Workflows']
                        ],
                        'hr' => [
                            'pain' => 'Manual attendance tracking via spreadsheets, leave conflicts, shift scheduling nightmares, and scary compliance gaps.',
                            'solution' => 'Automated attendance, smart leave management, visual shift builder, and AI fraud detection to keep everything honest.',
                            'modules' => ['Attendance & Shifts', 'Leave Management', 'AI Fraud Detection', 'Audit Logs']
                        ],
                        'operations' => [
                            'pain' => 'Department silos, broken manual approval chains via email, and zero visibility into team performance or resource allocation.',
                            'solution' => 'Centralized department and team management. Custom workflows, role-based granular permissions, and operational analytics.',
                            'modules' => ['Departments & Teams', 'Workflows & Approvals', 'Roles & Permissions', 'Analytics']
                        ],
                        'freelancers' => [
                            'pain' => 'Scattered client data, manual invoicing processes, no accurate revenue tracking, and zero business intelligence.',
                            'solution' => 'All-in-one freelancer platform. CRM, invoicing, task management, and AI revenue forecasting — core features forever free.',
                            'modules' => ['Clients & Leads', 'Invoices & Payments', 'Tasks & Projects', 'Revenue Tracking']
                        ],
                        'agencies' => [
                            'pain' => 'Managing a freelance team without proper tools. No shared projects, no unified invoicing, and no team utilization analytics.',
                            'solution' => 'Freelance Workspace — a collaborative environment for agencies. Shared projects, shared invoicing, and team analytics.',
                            'modules' => ['Collaborator Management', 'Shared Projects & Tasks', 'Shared Invoices', 'Workspace Analytics']
                        ],
                    ];
                @endphp

                @foreach($roleData as $key => $data)
                    <div x-show="activeTab === '{{ $key }}'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-cloak class="p-8 lg:p-12">
                        <div class="grid lg:grid-cols-3 gap-12 items-center">
                            <div class="space-y-4">
                                <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center justify-center border border-red-100">
                                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                </div>
                                <h3 class="font-display text-xl font-bold text-content-strong">The Pain</h3>
                                <p class="text-content-muted leading-relaxed">{{ $data['pain'] }}</p>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="w-12 h-12 rounded-xl bg-brand-50 flex items-center justify-center border border-brand-100">
                                    <svg class="w-6 h-6 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <h3 class="font-display text-xl font-bold text-content-strong">TimeNest Solution</h3>
                                <p class="text-content-muted leading-relaxed">{{ $data['solution'] }}</p>
                            </div>

                            <div>
                                @if($key === 'hr')
                                    <x-frontend-sections.fingerprint-animation />
                                @elseif($key === 'operations')
                                    <x-frontend-sections.gear-animation />
                                @else
                                    <div class="space-y-4 bg-surface-50 p-6 rounded-xl border border-surface-border h-full">
                                        <h3 class="font-display text-lg font-bold text-content-strong flex items-center gap-2">
                                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                            Key Modules
                                        </h3>
                                        <ul class="space-y-3 mt-4">
                                            @foreach($data['modules'] as $module)
                                                <li class="flex items-center gap-3 text-content-strong font-medium text-sm">
                                                    <div class="w-1.5 h-1.5 rounded-full bg-brand-500"></div>
                                                    {{ $module }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Section 3: Deep Dive Features --}}
    <section class="py-24 bg-surface-50 border-y border-surface-border overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    <x-frontend-base.badge variant="accent" class="mb-6">Intelligent Core</x-frontend-base.badge>
                    <h2 class="font-display text-3xl lg:text-5xl font-bold text-content-strong mb-6 leading-tight">Everything you need to manage work, <span class="text-indigo-600">beautifully designed.</span></h2>
                    <p class="text-lg text-content-muted mb-8 leading-relaxed">
                        TimeNest isn't just a collection of tools. It's a deeply integrated ecosystem where attendance data feeds into payroll, project tasks feed into invoices, and AI connects the dots.
                    </p>
                    
                    <div class="space-y-6">
                        @foreach([
                            ['Employee Mgmt', 'Maintain a single source of truth for your entire workforce with rich profiles and documentation.'],
                            ['Smart Attendance', 'Geofenced clock-ins, biometric support, and real-time shift tracking.'],
                            ['Approval Workflows', 'Build custom multi-step approval chains for leaves, expenses, and operational changes.']
                        ] as [$title, $desc])
                            <div class="flex items-start gap-4">
                                <div class="w-8 h-8 rounded-lg bg-white border border-surface-border shadow-sm flex items-center justify-center shrink-0 mt-1">
                                    <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div>
                                    <h4 class="font-display font-bold text-content-strong mb-1">{{ $title }}</h4>
                                    <p class="text-content-muted text-sm">{{ $desc }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-10">
                        <x-frontend-base.link href="{{ route('frontend.solutions.show', 'workforce-management') }}" class="text-brand-600 font-semibold hover:text-brand-700">Explore all features &rarr;</x-frontend-base.link>
                    </div>
                </div>
                
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-tr from-brand-500/20 to-indigo-500/20 rounded-[2.5rem] transform rotate-3 scale-105"></div>
                    <div class="relative bg-white rounded-2xl shadow-xl shadow-surface-border/50 border border-surface-border p-2">
                        <img src="/images/mockups/ai-analytics.png" alt="AI Analytics Dashboard" class="w-full rounded-xl border border-surface-border/50">
                        
                        {{-- Floating Element --}}
                        <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-xl shadow-lg border border-surface-border flex items-center gap-4 animate-slide-up" style="animation-delay: 500ms;">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            </div>
                            <div>
                                <p class="text-xs text-content-muted font-medium uppercase tracking-wider">Productivity</p>
                                <p class="font-display font-bold text-content-strong text-xl">+24.5%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-20">
            <x-frontend-sections.carousel :slides="[
                ['title' => 'Real-time AI Analytics', 'description' => 'Instantly detect anomalies in attendance data, forecast revenue, and monitor productivity trends without running a single manual report.', 'badge' => 'TimeNest AI', 'image' => '/images/mockups/ai-analytics.png', 'url' => route('frontend.ai')],
                ['title' => 'Smart Shift Builder', 'description' => 'Drag-and-drop shift scheduling with automated conflict resolution. TimeNest ensures complete compliance with labor laws automatically.', 'badge' => 'Workforce Core', 'image' => '/images/mockups/hero-dashboard.png', 'url' => '#'],
                ['title' => 'Collaborative Workspaces', 'description' => 'Share projects, manage freelance teams, and consolidate invoicing into one unified platform for your creative agency.', 'badge' => 'Agencies', 'image' => '/images/mockups/ai-analytics.png', 'url' => '#'],
            ]" />
        </div>
    </section>

    {{-- Section 4: Product Lines Cards --}}
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="font-display text-3xl lg:text-4xl font-bold text-content-strong mb-4">Three products, one platform</h2>
                <p class="text-content-muted text-lg">Choose the product that fits your workflow right now, and seamlessly scale as your business grows without ever migrating data.</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                @foreach([
                    ['title' => 'For Organizations', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'desc' => 'Complete workforce and operations management for companies. Unify HR, attendance, shifts, and departmental workflows.', 'features' => ['Employee Directory & Profiles', 'Real-time Attendance & GPS', 'Shift Builder & Leave Rules', 'Multi-level Approvals'], 'cta' => 'Book Demo', 'url' => route('frontend.book-demo'), 'color' => 'brand'],
                    ['title' => 'For Freelancers', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'desc' => 'Everything a solo freelancer needs to manage clients, revenue, and projects. Run your entire freelance business from one dashboard.', 'features' => ['Client CRM & Lead Tracking', 'Professional Invoicing', 'Task & Project Kanban', 'Revenue Forecasting'], 'cta' => 'Start Free', 'url' => '/register', 'color' => 'indigo'],
                    ['title' => 'Freelance Workspace', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'desc' => 'A collaborative workspace for freelance teams, agencies, and studios. Work together without full corporate overhead.', 'features' => ['Collaborator Management', 'Shared Projects & Files', 'Unified Client Billing', 'Team Utilization Analytics'], 'cta' => 'Upgrade to Pro', 'url' => route('frontend.pricing'), 'color' => 'amber', 'pro' => true],
                ] as $product)
                    <div class="group rounded-2xl border border-surface-border bg-white p-8 hover:border-{{ $product['color'] }}-300 hover:shadow-xl hover:shadow-{{ $product['color'] }}-500/10 transition-all duration-300 flex flex-col relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-8 opacity-5 group-hover:opacity-10 transition-opacity">
                            <svg class="w-32 h-32 text-{{ $product['color'] }}-600 -mr-10 -mt-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="{{ $product['icon'] }}"/></svg>
                        </div>
                        
                        <div class="w-14 h-14 rounded-xl bg-{{ $product['color'] }}-50 flex items-center justify-center mb-6 text-{{ $product['color'] }}-600 border border-{{ $product['color'] }}-100 relative z-10">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $product['icon'] }}"/></svg>
                        </div>
                        
                        <h3 class="font-display text-2xl font-bold text-content-strong mb-3 relative z-10">{{ $product['title'] }}</h3>
                        
                        @if(isset($product['pro']))
                            <x-frontend-base.badge variant="pro" class="mb-4 self-start relative z-10">Requires Pro</x-frontend-base.badge>
                        @endif
                        
                        <p class="text-content-muted text-base leading-relaxed mb-8 relative z-10">{{ $product['desc'] }}</p>
                        
                        <div class="mb-8 flex-1 relative z-10">
                            <h4 class="text-xs font-semibold text-content-strong uppercase tracking-wider mb-4">Core Features</h4>
                            <ul class="space-y-3">
                                @foreach($product['features'] as $f)
                                    <li class="flex items-start gap-3 text-sm text-content-muted">
                                        <svg class="w-5 h-5 text-{{ $product['color'] }}-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        {{ $f }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        
                        <x-frontend-base.button :href="$product['url']" variant="outline" class="w-full relative z-10 bg-white border-surface-border hover:bg-{{ $product['color'] }}-50 hover:text-{{ $product['color'] }}-700 hover:border-{{ $product['color'] }}-200">{{ $product['cta'] }}</x-frontend-base.button>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Section 5: AI Platform --}}
    <section class="py-24 bg-brand-900 relative overflow-hidden text-white">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Ik0zNiA0MmwxMC0xMGw0IDQgMTItMTJWMTJIMTB2MTZMMjIgMTZsMTAgMTB6IiBmaWxsPSIjZmZmZmZmIiBmaWxsLW9wYWNpdHk9IjAuMDIiLz48L2c+PC9zdmc+')] opacity-20"></div>
        <div class="absolute right-0 top-0 w-[800px] h-[800px] bg-brand-500/20 rounded-full blur-[120px] pointer-events-none translate-x-1/3 -translate-y-1/3"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    <x-frontend-base.badge variant="accent" class="mb-6 bg-white/10 text-brand-100 border-white/20">TimeNest AI</x-frontend-base.badge>
                    <h2 class="font-display text-3xl lg:text-5xl font-bold text-white mb-6 leading-tight">Intelligence embedded into every workflow.</h2>
                    <p class="text-lg text-brand-100/80 mb-10 leading-relaxed">
                        We didn't just bolt on a chatbot. TimeNest AI monitors your operations in the background, surfacing insights, detecting anomalies, and automating routine administrative tasks before you even ask.
                    </p>
                    
                    <div class="grid sm:grid-cols-2 gap-6">
                        @foreach([
                            ['AI Workforce Analyst', 'Detect attendance anomalies, leave abuse patterns, and overtime risks.', 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'],
                            ['AI Fraud Detection', 'Identify location spoofing, fake attendance, and suspicious reimbursements.', 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                            ['AI Executive Dashboards', 'Ask complex business queries in plain English and get visual answers.', 'M8 13v-1m4 1v-3m4 3V8M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z'],
                            ['AI Freelancer Assistant', 'Smart invoice categorization, payment risk assessment, and revenue prediction.', 'M13 10V3L4 14h7v7l9-11h-7z'],
                        ] as [$title, $desc, $icon])
                            <div class="bg-white/5 border border-white/10 p-5 rounded-xl hover:bg-white/10 transition-colors">
                                <svg class="w-6 h-6 text-brand-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $icon }}"/></svg>
                                <h3 class="font-display font-semibold text-white mb-2">{{ $title }}</h3>
                                <p class="text-brand-100/70 text-sm leading-relaxed">{{ $desc }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="relative hidden lg:block">
                    <div class="bg-surface/50 border border-white/10 rounded-2xl p-8 backdrop-blur-md shadow-2xl">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-12 h-12 rounded-full bg-brand-500/20 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6 text-brand-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <div>
                                <p class="text-white font-medium">TimeNest AI Agent</p>
                                <p class="text-brand-200/60 text-sm">Analyzing current month operations...</p>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="bg-white/10 rounded-xl p-4 border border-white/5 animate-pulse">
                                <div class="h-4 bg-white/20 rounded w-3/4 mb-3"></div>
                                <div class="h-3 bg-white/10 rounded w-full mb-2"></div>
                                <div class="h-3 bg-white/10 rounded w-5/6"></div>
                            </div>
                            <div class="bg-white/5 rounded-xl p-4 border border-white/5 border-l-4 border-l-amber-500">
                                <h4 class="text-white font-medium mb-1">Anomaly Detected</h4>
                                <p class="text-brand-100/70 text-sm">Design team has logged 15% more overtime this week compared to monthly average. Risk of burnout is high.</p>
                            </div>
                            <div class="bg-white/5 rounded-xl p-4 border border-white/5 border-l-4 border-l-brand-500">
                                <h4 class="text-white font-medium mb-1">Revenue Forecast</h4>
                                <p class="text-brand-100/70 text-sm">Based on current billable hours, Q3 revenue is projected to exceed targets by 8.5%.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Section 6: Stats Strip --}}
    <x-frontend-sections.stats-strip :stats="$stats" />

    {{-- Section 7: Interactive ROI Calculator --}}
    <section class="py-24 bg-surface-50 border-y border-surface-border" x-data="{ 
        employees: 50, 
        hrSize: 3, 
        avgSalary: 50000, 
        get timeSaved() { return Math.round(this.employees * 0.5 + this.hrSize * 8) }, 
        get moneySaved() { return Math.round((this.timeSaved * 12 * this.avgSalary) / (22 * 8 * 12)) }, 
        get productivity() { return Math.min(Math.round(this.employees * 0.15 + this.hrSize * 2), 45) } 
    }">
        <div class="max-w-6xl mx-auto px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="font-display text-3xl lg:text-4xl font-bold text-content-strong mb-4">Calculate your exact ROI</h2>
                <p class="text-content-muted text-lg">See how much time and money TimeNest can save your organization by eliminating manual tasks and tool sprawl.</p>
            </div>
            
            <div class="rounded-3xl border border-surface-border bg-white shadow-xl p-8 lg:p-12">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <div class="space-y-10">
                        <div>
                            <div class="flex justify-between mb-3">
                                <label class="text-sm font-bold text-content-strong uppercase tracking-wider">Number of Employees</label>
                                <span class="font-display font-bold text-brand-600" x-text="employees"></span>
                            </div>
                            <input type="range" min="10" max="1000" x-model="employees" class="w-full h-2 bg-surface-border rounded-lg appearance-none cursor-pointer accent-brand-500">
                        </div>
                        <div>
                            <div class="flex justify-between mb-3">
                                <label class="text-sm font-bold text-content-strong uppercase tracking-wider">HR/Ops Team Size</label>
                                <span class="font-display font-bold text-brand-600" x-text="hrSize"></span>
                            </div>
                            <input type="range" min="1" max="20" x-model="hrSize" class="w-full h-2 bg-surface-border rounded-lg appearance-none cursor-pointer accent-brand-500">
                        </div>
                        <div>
                            <div class="flex justify-between mb-3">
                                <label class="text-sm font-bold text-content-strong uppercase tracking-wider">Avg Monthly Salary (₹)</label>
                                <span class="font-display font-bold text-brand-600" x-text="'₹' + Number(avgSalary).toLocaleString()"></span>
                            </div>
                            <input type="range" min="15000" max="200000" step="5000" x-model="avgSalary" class="w-full h-2 bg-surface-border rounded-lg appearance-none cursor-pointer accent-brand-500">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="rounded-2xl bg-brand-50 p-6 border border-brand-100 flex flex-col justify-center shadow-sm">
                            <p class="text-brand-700 text-sm font-medium mb-2 uppercase tracking-wider">Time Saved Monthly</p>
                            <p class="font-display text-4xl font-bold text-brand-600 mb-1" x-text="timeSaved + ' hrs'"></p>
                            <p class="text-brand-600/70 text-xs">Automating approvals & attendance</p>
                        </div>
                        <div class="rounded-2xl bg-indigo-50 p-6 border border-indigo-100 flex flex-col justify-center shadow-sm">
                            <p class="text-indigo-700 text-sm font-medium mb-2 uppercase tracking-wider">Productivity Boost</p>
                            <p class="font-display text-4xl font-bold text-indigo-600 mb-1" x-text="'+' + productivity + '%'"></p>
                            <p class="text-indigo-600/70 text-xs">Due to centralized workflows</p>
                        </div>
                        <div class="sm:col-span-2 rounded-2xl bg-green-50 p-8 border border-green-100 flex flex-col justify-center shadow-sm relative overflow-hidden">
                            <svg class="absolute right-0 bottom-0 text-green-200/50 w-32 h-32 -mr-8 -mb-8 transform rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="text-green-700 text-sm font-medium mb-2 uppercase tracking-wider relative z-10">Estimated Annual Savings</p>
                            <p class="font-display text-5xl font-bold text-green-600 relative z-10" x-text="'₹' + Number(moneySaved).toLocaleString()"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Section 8: Testimonials --}}
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <x-frontend-sections.section-header title="Loved by forward-thinking teams" subtitle="Don't just take our word for it. Here's what our users have to say about TimeNest." badge="Testimonials" />
            
            <div class="grid md:grid-cols-3 gap-6 mt-12">
                @foreach($testimonials as $t)
                    <div class="bg-white rounded-2xl p-8 shadow-lg shadow-surface-border/20 border border-surface-border">
                        <div class="flex items-center gap-1 mb-6">
                            @for($i=0; $i<$t['rating']; $i++)
                                <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <p class="text-content-strong text-lg mb-8 leading-relaxed">"{{ $t['content'] }}"</p>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-brand-100 flex items-center justify-center text-brand-700 font-bold font-display">
                                {{ substr($t['name'], 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-content-strong">{{ $t['name'] }}</h4>
                                <p class="text-sm text-content-muted">{{ $t['role'] }}, {{ $t['company'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Section 9: Security & Compliance --}}
    <section class="py-16 bg-surface-50 border-y border-surface-border">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                @foreach([
                    ['M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'Enterprise Security'], 
                    ['M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'Data Encryption'], 
                    ['M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01', 'Complete Audit Logs'], 
                    ['M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'GDPR Ready']
                ] as [$icon, $label])
                    <div class="flex flex-col items-center justify-center">
                        <div class="w-12 h-12 rounded-xl bg-white border border-surface-border shadow-sm flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $icon }}"/></svg>
                        </div>
                        <p class="text-content-strong font-semibold text-sm uppercase tracking-wider">{{ $label }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Section 10: FAQ --}}
    <section class="py-24 bg-white">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="font-display text-3xl font-bold text-content-strong mb-4">Frequently Asked Questions</h2>
                <p class="text-content-muted text-lg">Everything you need to know about implementing TimeNest for your organization.</p>
            </div>
            <x-frontend-sections.faq-block :faqs="$faqs" />
        </div>
    </section>

    {{-- Section 11: Final CTA --}}
    <section class="py-24 bg-brand-900 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-brand-600 to-indigo-600 opacity-90"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Ik0zNiA0MmwxMC0xMGw0IDQgMTItMTJWMTJIMTB2MTZMMjIgMTZsMTAgMTB6IiBmaWxsPSIjZmZmZmZmIiBmaWxsLW9wYWNpdHk9IjAuMDUiLz48L2c+PC9zdmc+')]"></div>
        
        <div class="relative z-10 max-w-4xl mx-auto px-6 lg:px-8 text-center">
            <h2 class="font-display text-4xl lg:text-5xl font-bold text-white mb-6">Stop stitching tools together.</h2>
            <p class="text-xl text-white/80 mb-10 max-w-2xl mx-auto">Join thousands of teams running their entire workforce, operations, and freelancers on a single, intelligent platform.</p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <x-frontend-base.button href="/register" variant="primary" color="white" size="lg" class="w-full sm:w-auto h-14 px-8 text-brand-700 bg-white hover:bg-surface-50 shadow-xl">
                    Start for Free
                </x-frontend-base.button>
                <x-frontend-base.button href="{{ route('frontend.book-demo') }}" variant="outline" color="white" size="lg" class="w-full sm:w-auto h-14 px-8 text-white border-white/30 hover:bg-white/10">
                    Book a Demo
                </x-frontend-base.button>
            </div>
            <p class="text-white/60 text-sm mt-6">No credit card required. 14-day free trial on Pro plans.</p>
        </div>
    </section>
</x-frontend-layout.app>
