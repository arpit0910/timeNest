<?php

namespace App\View\Components\Frontend\Sections;

use Illuminate\View\Component;
use App\View\Components\Frontend\Traits\HasVariant;

class Hero extends Component
{
    use HasVariant;

    public string $variant;

    public $title;
    public $subtitle;
    public $badgeText;

    public function __construct(
        $variant = 'default',
        $title = 'The Work Operating System',
        $subtitle = 'Manage employees, attendance, timelogs, and leaves in one powerful platform.',
        $badgeText = 'TimeNest 2.0 is now live'
    ) {
        $this->variant = $variant;
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->badgeText = $badgeText;
    }

    public function render()
    {
        return view('frontend.components.sections.hero');
    }
}
