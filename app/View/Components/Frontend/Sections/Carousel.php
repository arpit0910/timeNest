<?php

namespace App\View\Components\Frontend\Sections;

use Illuminate\View\Component;

class Carousel extends Component
{
    public function __construct(
        public array $slides = [],
        public string $class = '',
    ) {}

    public function render()
    {
        return view('frontend.components.sections.carousel');
    }
}
