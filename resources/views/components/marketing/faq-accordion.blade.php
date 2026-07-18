@props(['question', 'answer', 'id', 'theme' => 'light'])

@php
    $isDark = $theme === 'dark';
@endphp

<div class="border {{ $isDark ? 'border-white/10 bg-white/5' : 'border-neutral-200 bg-white' }} rounded-2xl overflow-hidden transition-colors" :class="active === {{ $id }} ? '{{ $isDark ? 'border-accent-500/50 bg-neutral-900 shadow-xl' : 'border-accent-200 shadow-md' }}' : ''">
    <button @click="active = active === {{ $id }} ? null : {{ $id }}" class="w-full flex items-center justify-between p-6 text-left focus:outline-none hover:{{ $isDark ? 'bg-white/10' : 'bg-neutral-50/50' }} transition-colors">
        <span class="text-base font-bold {{ $isDark ? 'text-white' : 'text-neutral-900' }}">{{ $question }}</span>
        <svg class="w-5 h-5 {{ $isDark ? 'text-neutral-400' : 'text-neutral-400' }} transform transition-transform" :class="active === {{ $id }} ? 'rotate-180 {{ $isDark ? 'text-accent-400' : 'text-accent-500' }}' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
    </button>
    <div x-show="active === {{ $id }}" x-collapse x-cloak>
        <div class="px-6 pb-6 {{ $isDark ? 'text-neutral-400' : 'text-neutral-600' }} leading-relaxed text-sm">
            {{ $answer }}
        </div>
    </div>
</div>

