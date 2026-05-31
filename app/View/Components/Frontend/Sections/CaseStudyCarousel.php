<?php

namespace App\View\Components\Frontend\Sections;

use Illuminate\View\Component;

class CaseStudyCarousel extends Component
{
    public function __construct(
        public array $caseStudies = []
    ) {}

    public function render()
    {
        return view('frontend.components.sections.case-study-carousel');
    }
}
