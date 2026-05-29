<?php

namespace App\View\Components\Frontend\Base;

use Illuminate\View\Component;

class Link extends Component
{
    public function __construct(
        public string $href = '#',
        public string $variant = 'default',
        public string $class = '',
    ) {}

    public function linkClasses(): string
    {
        $base = 'inline-flex items-center gap-1 font-body transition-colors duration-200';
        $variant = match($this->variant) {
            'brand'   => 'text-brand-400 hover:text-brand-300',
            'muted'   => 'text-slate-400 hover:text-slate-300',
            'white'   => 'text-white hover:text-brand-400',
            default   => 'text-slate-300 hover:text-white',
        };
        return trim("$base $variant {$this->class}");
    }

    public function render()
    {
        return view('frontend.components.base.link');
    }
}
