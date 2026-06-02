<?php

namespace App\View\Components\Frontend\Sections\Testimonials;

use Illuminate\View\Component;

class Index extends Component
{
    public $stories;

    public function __construct($stories = [])
    {
        $this->stories = $stories ?? [];
    }

    public function render()
    {
        return view('frontend.components.sections.testimonials.index');
    }
}
