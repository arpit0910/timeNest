<div {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full bg-white px-3 py-1 text-xs font-semibold text-slate-700 shadow-sm border border-slate-100 uppercase tracking-wide']) }}>
    @if(isset($icon))
        <span class="mr-1.5 flex h-4 w-4 items-center justify-center text-indigo-500">
            {{ $icon }}
        </span>
    @endif
    {{ $slot }}
</div>
