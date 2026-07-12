<div class="flex flex-wrap items-center justify-center gap-2 md:gap-3 py-6 border-b border-white/5">
    @foreach($categories as $category)
        <button @click="activeFilter = '{{ $category }}'"
                class="px-4 py-2 text-xs md:text-sm font-medium tracking-tight rounded-xl border transition-all duration-300 cursor-pointer select-none focus:outline-none"
                :class="activeFilter === '{{ $category }}' 
                    ? 'bg-indigo-600 border-indigo-500 text-white shadow-[0_4px_16px_rgba(99,102,241,0.3)] scale-[1.02]' 
                    : 'bg-zinc-900/40 border-white/5 text-zinc-400 hover:text-white hover:bg-zinc-900 hover:border-white/10'">
            {{ $category }}
        </button>
    @endforeach
</div>
