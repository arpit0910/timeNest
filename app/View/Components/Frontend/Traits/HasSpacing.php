<?php

namespace App\View\Components\Frontend\Traits;

trait HasSpacing
{
    public function resolveSpacingClasses(string $spacing): string
    {
        return match($spacing) {
            'none'   => 'p-0',
            'xs'     => 'p-2',
            'sm'     => 'p-4',
            'md'     => 'p-6',
            'lg'     => 'p-8',
            'xl'     => 'p-12',
            '2xl'    => 'p-16',
            default  => 'p-6',
        };
    }
}
