<?php

namespace App\View\Components\Frontend\Traits;

trait HasColor
{
    public function resolveColorClasses(string $color, string $variant = 'primary'): string
    {
        $map = [
            'primary' => [
                'brand'  => 'bg-slate-900 border border-slate-800 text-white shadow-[inset_0_1px_0_rgba(255,255,255,0.1),0_1px_2px_rgba(0,0,0,0.1)] hover:bg-slate-800 hover:border-slate-700 transition-all duration-200',
                'accent' => 'bg-brand-900 border border-brand-800 text-white shadow-[inset_0_1px_0_rgba(255,255,255,0.15),0_1px_2px_rgba(0,0,0,0.1)] hover:bg-brand-800 hover:border-brand-700 transition-all duration-200',
                'white'  => 'bg-white border border-slate-200 text-slate-900 shadow-[0_1px_2px_rgba(0,0,0,0.05)] hover:bg-slate-50 hover:border-slate-300 transition-all duration-200',
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
