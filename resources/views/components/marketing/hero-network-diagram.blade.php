<div class="relative w-full max-w-4xl mx-auto flex flex-col md:flex-row items-center justify-between gap-8 md:gap-4 mt-16 animate-float-alt">
    
    {{-- Connecting Lines SVG (Desktop only) --}}
    <svg class="hidden md:block absolute top-1/2 left-0 w-full h-full -translate-y-1/2 z-0 pointer-events-none" preserveAspectRatio="none">
        <path d="M 200 50 C 350 50, 350 50, 450 50" stroke="#cbd5e1" stroke-width="1.5" stroke-dasharray="4 4" fill="none" />
        <path d="M 550 50 C 650 50, 650 50, 800 50" stroke="#cbd5e1" stroke-width="1.5" stroke-dasharray="4 4" fill="none" />
    </svg>

    {{-- Left: Your Team --}}
    <div class="bg-white rounded-2xl shadow-xl shadow-indigo-100/40 p-4 border border-slate-100 z-10 w-full md:w-auto relative">
        <div class="absolute -top-3 left-4 bg-white px-2 py-0.5 rounded-full border border-slate-100 shadow-sm text-[10px] font-semibold text-slate-600 uppercase tracking-wider flex items-center gap-1.5">
            <svg class="w-3 h-3 text-indigo-500" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
            Your Team
        </div>
        <div class="grid grid-cols-3 gap-2 mt-2">
            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Team member" class="w-12 h-12 rounded-xl object-cover bg-slate-100">
            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Team member" class="w-12 h-12 rounded-xl object-cover bg-slate-100">
            <div class="w-12 h-12 rounded-xl bg-slate-50 border border-dashed border-slate-200"></div>
            <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Team member" class="w-12 h-12 rounded-xl object-cover bg-slate-100">
            <img src="https://randomuser.me/api/portraits/men/86.jpg" alt="Team member" class="w-12 h-12 rounded-xl object-cover bg-slate-100">
            <img src="https://randomuser.me/api/portraits/women/21.jpg" alt="Team member" class="w-12 h-12 rounded-xl object-cover bg-slate-100">
        </div>
    </div>

    {{-- Center: TimeNest Node --}}
    <div class="z-10 bg-gradient-to-r from-indigo-600 to-blue-600 rounded-full py-3 px-6 shadow-xl shadow-indigo-200 flex items-center gap-2">
        <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32' class="w-5 h-5">
            <path d='M28 16 A12 12 0 1 0 16 28' stroke='#ffffff' stroke-width='2' fill='none' stroke-linecap='round'/>
            <path d='M23 16 A7 7 0 1 0 16 23' stroke='#93c5fd' stroke-width='2' fill='none' stroke-linecap='round'/>
            <path d='M19 16 A3 3 0 1 0 16 19' stroke='#93c5fd' stroke-width='2' fill='none' stroke-linecap='round'/>
        </svg>
        <span class="font-bold text-white text-lg tracking-tight">TimeNest</span>
    </div>

    {{-- Right: HR & Admins --}}
    <div class="bg-white rounded-2xl shadow-xl shadow-indigo-100/40 p-4 border border-slate-100 z-10 w-full md:w-auto relative">
        <div class="absolute -top-3 right-4 bg-white px-2 py-0.5 rounded-full border border-slate-100 shadow-sm text-[10px] font-semibold text-slate-600 uppercase tracking-wider flex items-center gap-1.5">
            <svg class="w-3 h-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a1 1 0 00-1 1v1a1 1 0 002 0V3a1 1 0 00-1-1zM4 4h3a3 3 0 006 0h3a2 2 0 012 2v9a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2zm2.5 7a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm2.45 4a2.5 2.5 0 10-4.9 0h4.9zM12 9a1 1 0 100 2h3a1 1 0 100-2h-3zm-1 4a1 1 0 011-1h2a1 1 0 110 2h-2a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
            HR & Admins
        </div>
        <div class="grid grid-cols-3 gap-2 mt-2">
            <img src="https://randomuser.me/api/portraits/men/12.jpg" alt="Admin" class="w-12 h-12 rounded-xl object-cover bg-slate-100">
            
            <div class="flex flex-col items-center justify-center w-12 h-12 rounded-xl bg-orange-50 border border-orange-100 text-orange-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span class="text-[8px] font-medium mt-0.5">Leaves</span>
            </div>

            <img src="https://randomuser.me/api/portraits/women/56.jpg" alt="Admin" class="w-12 h-12 rounded-xl object-cover bg-slate-100">
            
            <div class="flex flex-col items-center justify-center w-12 h-12 rounded-xl bg-blue-50 border border-blue-100 text-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                <span class="text-[8px] font-medium mt-0.5">Chat</span>
            </div>
            
            <div class="flex flex-col items-center justify-center w-12 h-12 rounded-xl bg-indigo-50 border border-indigo-100 text-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                <span class="text-[8px] font-medium mt-0.5">Reports</span>
            </div>
            
            <div class="w-12 h-12 rounded-xl bg-slate-50 border border-dashed border-slate-200"></div>
        </div>
    </div>
</div>
