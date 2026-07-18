@props(['question', 'answer', 'id'])

<div class="border border-slate-200 rounded-2xl bg-white overflow-hidden transition-colors" :class="active === {{ $id }} ? 'border-accent-200 shadow-md' : ''">
    <button @click="active = active === {{ $id }} ? null : {{ $id }}" class="w-full flex items-center justify-between p-6 text-left focus:outline-none hover:bg-slate-50/50 transition-colors">
        <span class="text-base font-bold text-slate-900">{{ $question }}</span>
        <svg class="w-5 h-5 text-slate-400 transform transition-transform" :class="active === {{ $id }} ? 'rotate-180 text-accent-500' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
    </button>
    <div x-show="active === {{ $id }}" x-collapse x-cloak>
        <div class="px-6 pb-6 text-slate-600 leading-relaxed text-sm">
            {{ $answer }}
        </div>
    </div>
</div>
