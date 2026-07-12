<div class="bg-white rounded-2xl shadow-xl shadow-indigo-100/50 p-5 w-64 border border-slate-100 flex flex-col gap-4">
    <div class="text-sm font-semibold text-slate-800 mb-1">Fraudulent Check-ins</div>
    
    {{-- Row 1: Off --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-8 h-4 bg-slate-200 rounded-full relative flex items-center shrink-0">
                <div class="w-3 h-3 bg-white rounded-full shadow-sm absolute left-0.5"></div>
            </div>
            <div class="text-xs font-medium text-slate-500">Without TimeNest</div>
        </div>
        <div class="text-sm font-bold text-slate-700">14%</div>
    </div>

    {{-- Divider --}}
    <div class="h-px w-full bg-slate-100"></div>

    {{-- Row 2: On --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-8 h-4 bg-indigo-500 rounded-full relative flex items-center shrink-0">
                <div class="w-3 h-3 bg-white rounded-full shadow-sm absolute right-0.5"></div>
            </div>
            <div class="text-xs font-medium text-slate-700">With TimeNest</div>
        </div>
        <div class="text-sm font-bold text-emerald-600">0%</div>
    </div>
</div>
