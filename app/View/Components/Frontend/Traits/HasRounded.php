<?php

namespace App\View\Components\Frontend\Traits;

trait HasRounded
{
    public function resolveRoundedClasses(string $rounded): string
    {
        return match($rounded) {
            'none' => 'rounded-none',
            'sm'   => 'rounded-sm',
            'md'   => 'rounded-md',
            'lg'   => 'rounded-lg',
            'xl'   => 'rounded-xl',
            '2xl'  => 'rounded-2xl',
            'full' => 'rounded-full',
            default => 'rounded-lg',
        };
    }
}
