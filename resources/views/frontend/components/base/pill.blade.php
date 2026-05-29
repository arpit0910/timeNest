<span {{ $attributes->merge(['class' => $pillClasses()]) }}>
    <span class="relative flex h-2 w-2">
        <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75 {{ str_contains($pillClasses(), 'brand') ? 'bg-brand-400' : (str_contains($pillClasses(), 'accent') ? 'bg-accent-400' : (str_contains($pillClasses(), 'green') ? 'bg-green-400' : 'bg-slate-400')) }}"></span>
        <span class="relative inline-flex rounded-full h-2 w-2 {{ str_contains($pillClasses(), 'brand') ? 'bg-brand-500' : (str_contains($pillClasses(), 'accent') ? 'bg-accent-500' : (str_contains($pillClasses(), 'green') ? 'bg-green-500' : 'bg-slate-500')) }}"></span>
    </span>
    {{ $slot }}
</span>
