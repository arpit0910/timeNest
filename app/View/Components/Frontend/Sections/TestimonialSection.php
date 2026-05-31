<?php

namespace App\View\Components\Frontend\Sections;

use Illuminate\View\Component;

class TestimonialSection extends Component
{
    public function __construct(
        public array $stories = []
    ) {}

    public function render()
    {
        return view('frontend.components.sections.testimonial-section');
    }
}
