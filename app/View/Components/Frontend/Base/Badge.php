<?php

namespace App\View\Components\Frontend\Base;

use Illuminate\View\Component;

class Badge extends Component
{
    public function __construct(
        public string $variant = 'default',
        public string $size = 'sm',
        public string $class = '',
    ) {}

    public function badgeClasses(): string
    {
        $base = 'inline-flex items-center font-body font-medium rounded-full';
        $size = match($this->size) {
            'xs' => 'px-1.5 py-0.5 text-[10px]',
            'sm' => 'px-2.5 py-0.5 text-xs',
            'md' => 'px-3 py-1 text-sm',
            default => 'px-2.5 py-0.5 text-xs',
        };
        $variant = match($this->variant) {
            'brand'   => 'bg-brand-500/15 text-brand-400',
            'accent'  => 'bg-accent-500/15 text-accent-400',
            'success' => 'bg-green-500/15 text-green-400',
            'warning' => 'bg-amber-500/15 text-amber-400',
            'danger'  => 'bg-red-500/15 text-red-400',
            'pro'     => 'bg-gradient-to-r from-amber-500/20 to-orange-500/20 text-amber-400 border border-amber-500/30',
            default   => 'bg-slate-500/15 text-slate-400',
        };
        return trim("$base $size $variant {$this->class}");
    }

    public function render()
    {
        return view('frontend.components.base.badge');
    }
}
