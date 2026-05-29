<?php

namespace App\View\Components\Frontend\Sections;

use Illuminate\View\Component;

class Ticker extends Component
{
    public function __construct(
        public array $items = [],
        public string $class = '',
    ) {}

    public function render()
    {
        return view('frontend.components.sections.ticker');
    }
}
