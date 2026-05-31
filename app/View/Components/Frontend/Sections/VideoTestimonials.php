<?php

namespace App\View\Components\Frontend\Sections;

use Illuminate\View\Component;

class VideoTestimonials extends Component
{
    public function __construct(
        public array $videos = []
    ) {}

    public function render()
    {
        return view('frontend.components.sections.video-testimonials');
    }
}
