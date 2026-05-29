<?php

namespace App\View\Components\Frontend\Sections;

use Illuminate\View\Component;

class LogoStrip extends Component
{
    public function __construct(
        public string $title = 'Trusted by teams worldwide',
        public array $logos = [],
        public string $class = '',
    ) {}

    public function render()
    {
        return view('frontend.components.sections.logo-strip');
    }
}
