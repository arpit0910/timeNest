<?php

namespace App\View\Components\Frontend\Sections;

use Illuminate\View\Component;

class GearAnimation extends Component
{
    public function __construct(
        public string $class = '',
    ) {}

    public function render()
    {
        return view('frontend.components.sections.gear-animation');
    }
}
