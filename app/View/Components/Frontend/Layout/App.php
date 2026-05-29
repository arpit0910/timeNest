<?php

namespace App\View\Components\Frontend\Layout;

use Illuminate\View\Component;

class App extends Component
{
    public function __construct(
        public string $metaTitle = 'TimeNest',
        public string $metaDescription = '',
        public string $ogImage = '',
    ) {}

    public function render()
    {
        return view('frontend.layouts.app');
    }
}
