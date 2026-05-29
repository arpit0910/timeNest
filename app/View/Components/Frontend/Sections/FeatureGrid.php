<?php

namespace App\View\Components\Frontend\Sections;

use Illuminate\View\Component;

class FeatureGrid extends Component
{
    public function __construct(
        public array $features = [],
        public string $columns = '3',
        public string $class = '',
    ) {}

    public function render()
    {
        return view('frontend.components.sections.feature-grid');
    }
}
