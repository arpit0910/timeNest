<?php

namespace App\View\Components\Frontend\Sections;

use Illuminate\View\Component;

class StatsSection extends Component
{
    public function __construct(
        public array $stats = []
    ) {}

    public function render()
    {
        return view('frontend.components.sections.stats-section');
    }
}
