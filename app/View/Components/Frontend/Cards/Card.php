<?php

namespace App\View\Components\Frontend\Cards;

use Illuminate\View\Component;

class Card extends Component
{
    public function __construct(
        public string $variant = 'default',
        public string $padding = 'md',
        public bool   $hoverable = false,
        public string $class = '',
    ) {}

    public function cardClasses(): string
    {
        $base = 'rounded-xl border border-surface-border bg-surface-card font-body';
        $padding = match($this->padding) {
            'sm' => 'p-4',
            'md' => 'p-6',
            'lg' => 'p-8',
            'none' => '',
            default => 'p-6',
        };
        $hover = $this->hoverable ? 'hover:border-brand-500/30 hover:shadow-lg hover:shadow-brand-500/5 transition-all duration-300' : '';
        return trim("$base $padding $hover {$this->class}");
    }

    public function render()
    {
        return view('frontend.components.cards.card');
    }
}
