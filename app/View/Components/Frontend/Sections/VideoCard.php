<?php

namespace App\View\Components\Frontend\Sections;

use Illuminate\View\Component;

class VideoCard extends Component
{
    public function __construct(
        public array $video = []
    ) {}

    public function render()
    {
        return view('frontend.components.sections.video-card');
    }
}
