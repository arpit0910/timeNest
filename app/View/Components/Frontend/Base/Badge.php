<?php

namespace App\View\Components\Frontend\Base;

use Illuminate\View\Component;

class Badge extends Component
{
    public function __construct(
        public string $color = 'gray',
        public string $size = 'sm',
        public string $variant = 'default',
        public bool $dot = true,
        public bool $pulse = false,
        public string $class = '',
    ) {}

    public function badgeClasses(): string
    {
        $base = 'inline-flex items-center gap-2 font-body font-semibold rounded-full border tracking-wider shadow-sm';
        
        $size = match($this->size) {
            'xs' => 'px-[18px] py-[4px] text-[12px]',
            'sm' => 'px-[22px] py-[6px] text-[13.5px]',
            'md' => 'px-[26px] py-[8px] text-[15px]',
            'lg' => 'px-[32px] py-[10px] text-[17px]',
            default => 'px-[22px] py-[6px] text-[13.5px]',
        };

        $colorMap = [
            'teal'   => 'bg-teal-50 border-teal-200 text-teal-950',
            'indigo' => 'bg-indigo-50 border-indigo-200 text-indigo-950',
            'green'  => 'bg-emerald-50 border-emerald-200 text-emerald-950',
            'orange' => 'bg-amber-50 border-amber-200 text-amber-950',
            'purple' => 'bg-purple-50 border-purple-200 text-purple-950',
            'red'    => 'bg-red-50 border-red-200 text-red-950',
            'gray'   => 'bg-slate-100 border-slate-300 text-slate-900',
        ];

        $color = $colorMap[$this->color] ?? $colorMap['gray'];

        // Pro variant override
        if ($this->variant === 'pro') {
            $color = 'bg-gradient-to-r from-amber-50 to-orange-50 border-amber-300 text-amber-950';
        }
        
        // Upcoming variant override
        if ($this->variant === 'upcoming') {
            $color = 'bg-slate-100 border-slate-200 text-slate-500 shadow-none';
            $size = 'px-2 py-0.5 text-[10px] uppercase font-bold tracking-widest';
        }

        return trim("$base $size $color {$this->class}");
    }

    public function dotColorClass(): string
    {
        return match($this->color) {
            'teal'   => 'bg-teal-600',
            'indigo' => 'bg-indigo-600',
            'green'  => 'bg-emerald-600',
            'orange' => 'bg-amber-600',
            'purple' => 'bg-purple-600',
            'red'    => 'bg-red-600',
            default  => 'bg-slate-500',
        };
    }

    public function render()
    {
        return view('frontend.components.base.badge');
    }
}
