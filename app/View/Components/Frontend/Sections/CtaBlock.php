<?php

namespace App\View\Components\Frontend\Sections;

use Illuminate\View\Component;

class CtaBlock extends Component
{
    public function __construct(
        public string $headline = '',
        public string $subheadline = '',
        public string $primaryCtaText = '',
        public string $primaryCtaUrl = '#',
        public string $secondaryCtaText = '',
        public string $secondaryCtaUrl = '#',
        public string $class = '',
    ) {}

    public function render()
    {
        return view('frontend.components.sections.cta-block');
    }
}
