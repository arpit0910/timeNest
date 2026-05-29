<?php

namespace App\View\Components\Frontend\Traits;

trait HasAlignment
{
    public function resolveAlignmentClasses(string $align): string
    {
        return match($align) {
            'left'   => 'text-left',
            'center' => 'text-center',
            'right'  => 'text-right',
            default  => 'text-left',
        };
    }
}
