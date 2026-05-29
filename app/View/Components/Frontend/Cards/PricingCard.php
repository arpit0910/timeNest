<?php

namespace App\View\Components\Frontend\Cards;

use Illuminate\View\Component;

class PricingCard extends Component
{
    public function __construct(
        public string $name = '',
        public string $price = '',
        public string $period = '/mo',
        public string $description = '',
        public array  $features = [],
        public string $ctaText = 'Get Started',
        public string $ctaUrl = '#',
        public bool   $highlighted = false,
        public string $badge = '',
        public string $class = '',
    ) {}

    public function render()
    {
        return view('frontend.components.cards.pricing-card');
    }
}
