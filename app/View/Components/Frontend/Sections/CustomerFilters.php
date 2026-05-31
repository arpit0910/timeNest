<?php

namespace App\View\Components\Frontend\Sections;

use Illuminate\View\Component;

class CustomerFilters extends Component
{
    public function __construct(
        public array $categories = []
    ) {}

    public function render()
    {
        return view('frontend.components.sections.customer-filters');
    }
}
