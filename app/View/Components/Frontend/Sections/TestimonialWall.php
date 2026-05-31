<?php

namespace App\View\Components\Frontend\Sections;

use Illuminate\View\Component;

class TestimonialWall extends Component
{
    public function __construct(
        public array $wall = []
    ) {}

    public function render()
    {
        return view('frontend.components.sections.testimonial-wall');
    }
}
