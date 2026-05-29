<?php

namespace App\View\Components\Frontend\Traits;

trait HasShadow
{
    public function resolveShadowClasses(string $shadow): string
    {
        return match($shadow) {
            'none' => 'shadow-none',
            'sm'   => 'shadow-sm',
            'md'   => 'shadow-md',
            'lg'   => 'shadow-lg',
            'xl'   => 'shadow-xl',
            '2xl'  => 'shadow-2xl',
            'glow' => 'shadow-lg shadow-brand-500/20',
            default => 'shadow-none',
        };
    }
}
