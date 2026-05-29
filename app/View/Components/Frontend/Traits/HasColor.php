<?php

namespace App\View\Components\Frontend\Traits;

trait HasColor
{
    public function resolveColorClasses(string $color, string $variant = 'primary'): string
    {
        $map = [
            'primary' => [
                'brand'  => 'bg-brand-500 hover:bg-brand-600 text-white',
                'accent' => 'bg-accent-500 hover:bg-accent-600 text-white',
                'white'  => 'bg-white hover:bg-gray-100 text-content-strong',
            ],
            'secondary' => [
                'brand'  => 'bg-brand-500/10 hover:bg-brand-500/20 text-brand-600',
                'accent' => 'bg-accent-500/10 hover:bg-accent-500/20 text-accent-600',
            ],
            'outline' => [
                'brand'  => 'border border-brand-500 text-brand-600 hover:bg-brand-500/10',
                'accent' => 'border border-accent-500 text-accent-600 hover:bg-accent-500/10',
                'white'  => 'border border-white/20 text-white hover:bg-white/10',
            ],
            'ghost' => [
                'brand'  => 'text-brand-600 hover:bg-brand-500/10',
                'accent' => 'text-accent-600 hover:bg-accent-500/10',
                'white'  => 'text-white hover:bg-white/10',
            ],
            'danger' => [
                'brand'  => 'bg-red-500 hover:bg-red-600 text-white',
            ],
        ];

        return $map[$variant][$color] ?? $map['primary']['brand'] ?? '';
    }
}
