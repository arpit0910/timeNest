<?php

namespace App\View\Components\Frontend\Base;

use Illuminate\View\Component;

class Divider extends Component
{
    public function __construct(
        public string $variant = 'default',
        public string $class = '',
    ) {}

    public function render()
    {
        return view('frontend.components.base.divider');
    }
}
