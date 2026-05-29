<?php

namespace App\View\Components\Frontend\Sections;

use Illuminate\View\Component;

class SectionHeader extends Component
{
    public function __construct(
        public string $title = '',
        public string $subtitle = '',
        public string $badge = '',
        public string $align = 'center',
        public string $class = '',
    ) {}

    public function render()
    {
        return view('frontend.components.sections.section-header');
    }
}
