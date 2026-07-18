<div class="bg-neutral-900/80 backdrop-blur-md rounded-2xl shadow-xl shadow-accent-900/20 p-5 w-64 border border-neutral-700/50 flex flex-col gap-4">
    <div class="text-sm font-semibold text-white mb-1">Fraudulent Check-ins</div>
    
    {{-- Row 1: Off --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-8 h-4 bg-neutral-700 rounded-full relative flex items-center shrink-0">
                <div class="w-3 h-3 bg-neutral-400 rounded-full shadow-sm absolute left-0.5"></div>
            </div>
            <div class="text-xs font-medium text-neutral-400">Without TimeNest</div>
        </div>
        <div class="text-sm font-bold text-neutral-300">14%</div>
    </div>

    {{-- Divider --}}
    <div class="h-px w-full bg-neutral-700/50"></div>

    {{-- Row 2: On --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-8 h-4 bg-accent-500 rounded-full relative flex items-center shrink-0">
                <div class="w-3 h-3 bg-white rounded-full shadow-sm absolute right-0.5"></div>
            </div>
            <div class="text-xs font-medium text-neutral-300">With TimeNest</div>
        </div>
        <div class="text-sm font-bold text-emerald-400">0%</div>
    </div>
</div>

