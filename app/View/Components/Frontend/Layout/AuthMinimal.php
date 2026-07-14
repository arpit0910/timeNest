<?php

namespace App\View\Components\Frontend\Layout;

use Illuminate\View\Component;

class AuthMinimal extends Component
{
    public function __construct(
        public string $metaTitle = 'TimeNest',
        public string $metaDescription = '',
    ) {}

    public function render()
    {
        return view('frontend.layouts.auth-minimal');
    }
}
