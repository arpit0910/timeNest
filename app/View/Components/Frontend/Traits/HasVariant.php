<?php

namespace App\View\Components\Frontend\Traits;

trait HasVariant
{
    public function resolveVariantClasses(string $variant): string
    {
        return match($variant) {
            'primary'   => 'bg-brand-500 hover:bg-brand-600 text-white',
            'secondary' => 'bg-surface-card hover:bg-surface-elevated text-white border border-surface-border',
            'outline'   => 'border border-surface-border text-slate-300 hover:bg-surface-card',
            'ghost'     => 'text-slate-400 hover:text-white hover:bg-white/5',
            'danger'    => 'bg-red-500/10 text-red-400 hover:bg-red-500/20',
            default     => '',
        };
    }
}
