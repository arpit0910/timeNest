<?php

namespace App\View\Components\Frontend\Sections;

use Illuminate\View\Component;

class CompanyLogoStrip extends Component
{
    public function __construct(
        public array $logos = []
    ) {}

    public function render()
    {
        return view('frontend.components.sections.company-logo-strip');
    }
}
