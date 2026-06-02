<?php

namespace App\View\Components\Frontend\Base;

use Illuminate\View\Component;
use App\View\Components\Frontend\Traits\HasColor;
use App\View\Components\Frontend\Traits\HasSize;
use App\View\Components\Frontend\Traits\HasState;

class Button extends Component
{
    use HasColor, HasSize, HasState;

    public function __construct(
        public string $variant = 'primary',
        public string $size = 'md',
        public string $color = 'brand',
        public string $href = '',
        public string $type = 'button',
        public bool   $disabled = false,
        public bool   $loading = false,
        public string $iconLeft = '',
        public string $iconRight = '',
        public string $class = '',
        public bool   $fullWidthMobile = false,
    ) {}

    public function buttonClasses(): string
    {
        $base = 'group relative overflow-hidden inline-flex items-center justify-center gap-2 font-body font-medium rounded-xl transition-all duration-300 ease-out cursor-pointer focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:ring-offset-1 hover:-translate-y-0.5 active:scale-[0.98] shadow-sm';

        if ($this->fullWidthMobile) {
            $base .= ' w-full md:w-auto';
        }
        $colorClasses = $this->resolveColorClasses($this->color, $this->variant);
        $sizeClasses = $this->resolveSizeClasses($this->size);
        $stateClasses = $this->resolveStateClasses($this->disabled, $this->loading);

        return trim("$base $colorClasses $sizeClasses $stateClasses {$this->class}");
    }

    public function render()
    {
        return view('frontend.components.base.button');
    }
}
