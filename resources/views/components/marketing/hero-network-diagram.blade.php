<div class="relative w-full max-w-4xl mx-auto flex flex-col md:flex-row items-center justify-between gap-8 md:gap-4 mt-16 animate-float-alt">
    
    {{-- Left: Your Team --}}
    <div class="bg-slate-900/80 backdrop-blur-md rounded-2xl shadow-xl shadow-accent-900/20 p-4 border border-slate-700/50 z-10 w-full md:w-auto relative">
        <div class="absolute -top-3 left-4 bg-slate-900 px-2 py-0.5 rounded-full border border-slate-700/50 shadow-sm text-[10px] font-semibold text-slate-300 uppercase tracking-wider flex items-center gap-1.5">
            <svg class="w-3 h-3 text-accent-400" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
            Your Team
        </div>
        <div class="grid grid-cols-3 gap-2 mt-2">
            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Team member" class="w-12 h-12 rounded-xl object-cover bg-slate-800">
            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Team member" class="w-12 h-12 rounded-xl object-cover bg-slate-800">
            <div class="w-12 h-12 rounded-xl bg-slate-800/50 border border-dashed border-slate-600"></div>
            <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Team member" class="w-12 h-12 rounded-xl object-cover bg-slate-800">
            <img src="https://randomuser.me/api/portraits/men/86.jpg" alt="Team member" class="w-12 h-12 rounded-xl object-cover bg-slate-800">
            <img src="https://randomuser.me/api/portraits/women/21.jpg" alt="Team member" class="w-12 h-12 rounded-xl object-cover bg-slate-800">
        </div>
    </div>

    {{-- Center: TimeNest Node --}}
    <div class="relative flex-1 flex items-center justify-center">
        {{-- Internal Connecting Line perfectly centered on the button --}}
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[1000px] h-px border-t-[1.5px] border-dashed border-slate-600 z-0 pointer-events-none"></div>

        <div class="relative z-10 bg-slate-900/80 backdrop-blur-md rounded-full py-2 px-4 shadow-lg shadow-slate-900/50 border border-slate-700/50 flex items-center gap-2.5">
            <span class="flex h-2 w-2 relative">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
              <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
            </span>
            <span class="font-bold text-slate-300 text-xs tracking-widest uppercase">Live Sync</span>
        </div>
    </div>

    {{-- Right: HR & Admins --}}
    <div class="bg-slate-900/80 backdrop-blur-md rounded-2xl shadow-xl shadow-accent-900/20 p-4 border border-slate-700/50 z-10 w-full md:w-auto relative">
        <div class="absolute -top-3 right-4 bg-slate-900 px-2 py-0.5 rounded-full border border-slate-700/50 shadow-sm text-[10px] font-semibold text-slate-300 uppercase tracking-wider flex items-center gap-1.5">
            <svg class="w-3 h-3 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a1 1 0 00-1 1v1a1 1 0 002 0V3a1 1 0 00-1-1zM4 4h3a3 3 0 006 0h3a2 2 0 012 2v9a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2zm2.5 7a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm2.45 4a2.5 2.5 0 10-4.9 0h4.9zM12 9a1 1 0 100 2h3a1 1 0 100-2h-3zm-1 4a1 1 0 011-1h2a1 1 0 110 2h-2a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
            HR & Admins
        </div>
        <div class="grid grid-cols-3 gap-2 mt-2">
            <img src="https://randomuser.me/api/portraits/men/12.jpg" alt="Admin" class="w-12 h-12 rounded-xl object-cover bg-slate-800">
            
            <div class="flex flex-col items-center justify-center w-12 h-12 rounded-xl bg-orange-500/10 border border-orange-500/20 text-orange-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span class="text-[8px] font-medium mt-0.5">Leaves</span>
            </div>

            <img src="https://randomuser.me/api/portraits/women/56.jpg" alt="Admin" class="w-12 h-12 rounded-xl object-cover bg-slate-800">
            
            <div class="flex flex-col items-center justify-center w-12 h-12 rounded-xl bg-accent-500/10 border border-accent-500/20 text-accent-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                <span class="text-[8px] font-medium mt-0.5">Chat</span>
            </div>
            
            <div class="flex flex-col items-center justify-center w-12 h-12 rounded-xl bg-accent-500/10 border border-accent-500/20 text-accent-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                <span class="text-[8px] font-medium mt-0.5">Reports</span>
            </div>
            
            <div class="w-12 h-12 rounded-xl bg-slate-800/50 border border-dashed border-slate-600"></div>
        </div>
    </div>
</div>
