<?php

namespace App\View\Components\Frontend\Traits;

trait HasAnimation
{
    public function resolveAnimationClasses(string $animation): string
    {
        return match($animation) {
            'fade'    => 'animate-fade-in',
            'slide'   => 'animate-slide-up',
            'scale'   => 'animate-scale-in',
            'glow'    => 'animate-glow',
            'none'    => '',
            default   => '',
        };
    }
}
