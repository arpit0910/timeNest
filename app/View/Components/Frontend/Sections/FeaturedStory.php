<?php

namespace App\View\Components\Frontend\Sections;

use Illuminate\View\Component;

class FeaturedStory extends Component
{
    public function __construct(
        public array $story = []
    ) {}

    public function render()
    {
        return view('frontend.components.sections.featured-story');
    }
}
