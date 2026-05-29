<?php

namespace App\View\Components\Frontend\Cards;

use Illuminate\View\Component;

class FeatureCard extends Component
{
    public function __construct(
        public string $icon = '',
        public string $title = '',
        public string $description = '',
        public string $href = '',
        public string $class = '',
    ) {}

    public function render()
    {
        return view('frontend.components.cards.feature-card');
    }
}
