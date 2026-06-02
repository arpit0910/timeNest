<?php

namespace App\View\Components\Frontend\Sections\Faq;

use Illuminate\View\Component;

class Index extends Component
{
    public $faqs;

    public function __construct($faqs = [])
    {
        $this->faqs = $faqs ?? [];
    }

    public function render()
    {
        return view('frontend.components.sections.faq.index');
    }
}
