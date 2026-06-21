<?php

namespace App\View\Components\Frontend\Base;

use Illuminate\View\Component;

class Logo extends Component
{
    public string $size;
    public string $variant;

    public function __construct(string $size = 'md', string $variant = 'full')
    {
        $this->size = $size;
        $this->variant = $variant;
    }

    public function render()
    {
        return view('frontend.components.base.logo');
    }
}
