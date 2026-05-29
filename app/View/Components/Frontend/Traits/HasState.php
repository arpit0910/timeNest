<?php

namespace App\View\Components\Frontend\Traits;

trait HasState
{
    public function resolveStateClasses(bool $disabled, bool $loading): string
    {
        if ($disabled) return 'opacity-50 cursor-not-allowed pointer-events-none';
        if ($loading) return 'opacity-75 cursor-wait';
        return '';
    }
}
