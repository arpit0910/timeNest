<?php

namespace App\View\Components\Frontend\Traits;

trait HasSize
{
    public function resolveSizeClasses(string $size, string $type = 'button'): string
    {
        $map = [
            'button' => [
                'xs' => 'px-2.5 py-1 text-xs',
                'sm' => 'px-3 py-1.5 text-sm',
                'md' => 'px-5 py-2.5 text-sm',
                'lg' => 'px-6 py-3 text-base',
                'xl' => 'px-8 py-4 text-lg',
            ],
            'text' => [
                'xs' => 'text-xs',
                'sm' => 'text-sm',
                'md' => 'text-base',
                'lg' => 'text-lg',
                'xl' => 'text-xl',
            ],
            'icon' => [
                'xs' => 'w-3 h-3',
                'sm' => 'w-4 h-4',
                'md' => 'w-5 h-5',
                'lg' => 'w-6 h-6',
                'xl' => 'w-8 h-8',
            ],
        ];

        return $map[$type][$size] ?? $map[$type]['md'] ?? '';
    }
}
