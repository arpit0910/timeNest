<div class="bg-slate-900/80 backdrop-blur-md rounded-2xl shadow-xl shadow-accent-900/20 p-5 w-64 border border-slate-700/50 flex flex-col gap-4">
    <div class="text-sm font-semibold text-white mb-1">Fraudulent Check-ins</div>
    
    {{-- Row 1: Off --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-8 h-4 bg-slate-700 rounded-full relative flex items-center shrink-0">
                <div class="w-3 h-3 bg-slate-400 rounded-full shadow-sm absolute left-0.5"></div>
            </div>
            <div class="text-xs font-medium text-slate-400">Without TimeNest</div>
        </div>
        <div class="text-sm font-bold text-slate-300">14%</div>
    </div>

    {{-- Divider --}}
    <div class="h-px w-full bg-slate-700/50"></div>

    {{-- Row 2: On --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-8 h-4 bg-accent-500 rounded-full relative flex items-center shrink-0">
                <div class="w-3 h-3 bg-white rounded-full shadow-sm absolute right-0.5"></div>
            </div>
            <div class="text-xs font-medium text-slate-300">With TimeNest</div>
        </div>
        <div class="text-sm font-bold text-emerald-400">0%</div>
    </div>
</div>
