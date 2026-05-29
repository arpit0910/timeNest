<?php

namespace App\View\Components\Frontend\Cards;

use Illuminate\View\Component;

class TestimonialCard extends Component
{
    public function __construct(
        public string $name = '',
        public string $role = '',
        public string $company = '',
        public string $content = '',
        public int    $rating = 5,
        public string $avatar = '',
        public string $class = '',
    ) {}

    public function render()
    {
        return view('frontend.components.cards.testimonial-card');
    }
}
