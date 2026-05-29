<?php

namespace App\View\Components\Frontend\Sections;

use Illuminate\View\Component;

class StatsStrip extends Component
{
    public function __construct(
        public array $stats = [],
        public string $class = '',
    ) {}

    public function render()
    {
        return view('frontend.components.sections.stats-strip');
    }
}
