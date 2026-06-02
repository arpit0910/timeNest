<?php

namespace App\View\Components\Frontend\Sections;

use Illuminate\View\Component;
use App\View\Components\Frontend\Traits\HasVariant;

class Cta extends Component
{
    use HasVariant;

    public string $variant;

    public function __construct($variant = 'middle')
    {
        $this->variant = $variant;
    }

    public function render()
    {
        return view('frontend.components.sections.cta');
    }
}
