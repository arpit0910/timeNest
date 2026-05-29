<?php

namespace App\View\Components\Frontend\Layout;

use Illuminate\View\Component;

class Footer extends Component
{
    public function __construct()
    {
        //
    }

    public function render()
    {
        return view('frontend.components.layout.footer');
    }
}
