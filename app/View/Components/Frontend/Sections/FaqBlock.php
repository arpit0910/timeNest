<?php

namespace App\View\Components\Frontend\Sections;

use Illuminate\View\Component;

class FaqBlock extends Component
{
    public function __construct(
        public array $faqs = [],
        public string $class = '',
    ) {}

    public function render()
    {
        return view('frontend.components.sections.faq-block');
    }
}
