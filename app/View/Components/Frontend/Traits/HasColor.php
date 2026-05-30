<?php

namespace App\View\Components\Frontend\Traits;

trait HasColor
{
    public function resolveColorClasses(string $color, string $variant = 'primary'): string
    {
        $map = [
            'primary' => [
                'brand'  => 'bg-brand-500 border border-brand-500 text-white shadow-md shadow-brand-500/10 hover:bg-white hover:text-brand-600 hover:border-brand-500 hover:shadow-xl hover:shadow-brand-500/20',
                'accent' => 'bg-accent-500 border border-accent-500 text-white shadow-md shadow-accent-500/10 hover:bg-white hover:text-accent-600 hover:border-accent-500 hover:shadow-xl hover:shadow-accent-500/20',
                'white'  => 'bg-white border border-slate-200 text-content-strong shadow-md hover:bg-brand-500 hover:text-white hover:border-brand-500 hover:shadow-xl',
            ],
            'secondary' => [
                'brand'  => 'bg-brand-500/10 border border-transparent text-brand-600 hover:bg-brand-500 hover:text-white hover:border-brand-500 hover:shadow-md hover:shadow-brand-500/5',
                'accent' => 'bg-accent-500/10 border border-transparent text-accent-600 hover:bg-accent-500 hover:text-white hover:border-accent-500 hover:shadow-md hover:shadow-accent-500/5',
            ],
            'outline' => [
                'brand'   => 'border border-brand-500 bg-transparent text-brand-600 hover:bg-brand-500 hover:text-white hover:border-brand-500 hover:shadow-md hover:shadow-brand-500/5',
                'accent'  => 'border border-accent-500 bg-transparent text-accent-600 hover:bg-accent-500 hover:text-white hover:border-accent-500 hover:shadow-md hover:shadow-accent-500/5',
                'white'   => 'border border-white bg-transparent text-white hover:bg-white hover:text-brand-500 hover:border-white hover:shadow-md',
                'surface' => 'border border-surface-border bg-transparent text-content-strong hover:bg-brand-500 hover:text-white hover:border-brand-500 hover:shadow-md',
            ],
            'ghost' => [
                'brand'  => 'text-brand-600 hover:bg-brand-500 hover:text-white hover:shadow-sm',
                'accent' => 'text-accent-600 hover:bg-accent-500 hover:text-white hover:shadow-sm',
                'white'  => 'text-white hover:bg-white hover:text-brand-500 hover:shadow-sm',
            ],
            'danger' => [
                'brand'  => 'bg-red-500 border border-red-500 text-white shadow-md shadow-red-500/10 hover:bg-white hover:text-red-600 hover:border-red-500 hover:shadow-xl hover:shadow-red-500/20',
            ],
        ];

        return $map[$variant][$color] ?? $map['primary']['brand'] ?? '';
    }
}
