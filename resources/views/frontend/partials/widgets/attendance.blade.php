<div class="{{ $class ?? 'bg-white rounded-2xl border border-slate-200/60 p-4 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between min-h-[160px] overflow-hidden' }}"
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
