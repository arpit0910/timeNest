<?php

namespace App\View\Components\Frontend\Base;

use Illuminate\View\Component;

class Pill extends Component
{
    public function __construct(
        public string $variant = 'default',
        public string $class = '',
    ) {}

    public function pillClasses(): string
    {
        $base = 'inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-body font-medium border';
        $variant = match($this->variant) {
            'brand'  => 'bg-brand-500/10 text-brand-400 border-brand-500/20',
            'accent' => 'bg-accent-500/10 text-accent-400 border-accent-500/20',
            'live'   => 'bg-green-500/10 text-green-400 border-green-500/20',
            default  => 'bg-surface-card text-slate-400 border-surface-border',
        };
        return trim("$base $variant {$this->class}");
    }

    public function render()
    {
        return view('frontend.components.base.pill');
    }
}
