<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class FrontendComponentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Manually register components to avoid namespace/tag resolution issues
        $components = [
            'frontend-layout.app' => \App\View\Components\Frontend\Layout\App::class,
            'frontend-layout-app' => \App\View\Components\Frontend\Layout\App::class,
            'frontend-layout.header' => \App\View\Components\Frontend\Layout\Header::class,
            'frontend-layout-header' => \App\View\Components\Frontend\Layout\Header::class,
            'frontend-layout.footer' => \App\View\Components\Frontend\Layout\Footer::class,
            'frontend-layout-footer' => \App\View\Components\Frontend\Layout\Footer::class,

            'frontend-base-badge' => \App\View\Components\Frontend\Base\Badge::class,
            'frontend-base-button' => \App\View\Components\Frontend\Base\Button::class,
            'frontend-base-divider' => \App\View\Components\Frontend\Base\Divider::class,
            'frontend-base-link' => \App\View\Components\Frontend\Base\Link::class,
            'frontend-base-pill' => \App\View\Components\Frontend\Base\Pill::class,

            'frontend-cards-card' => \App\View\Components\Frontend\Cards\Card::class,
            'frontend-cards-feature-card' => \App\View\Components\Frontend\Cards\FeatureCard::class,
            'frontend-cards-pricing-card' => \App\View\Components\Frontend\Cards\PricingCard::class,
            'frontend-cards-testimonial-card' => \App\View\Components\Frontend\Cards\TestimonialCard::class,

            'frontend-sections-cta-block' => \App\View\Components\Frontend\Sections\CtaBlock::class,
            'frontend-sections-faq-block' => \App\View\Components\Frontend\Sections\FaqBlock::class,
            'frontend-sections-feature-grid' => \App\View\Components\Frontend\Sections\FeatureGrid::class,
            'frontend-sections-hero-section' => \App\View\Components\Frontend\Sections\HeroSection::class,
            'frontend-sections-logo-strip' => \App\View\Components\Frontend\Sections\LogoStrip::class,
            'frontend-sections-section-header' => \App\View\Components\Frontend\Sections\SectionHeader::class,
            'frontend-sections-stats-strip' => \App\View\Components\Frontend\Sections\StatsStrip::class,
            
            // Also register dot notation versions since I modified some files!
            'frontend-base.badge' => \App\View\Components\Frontend\Base\Badge::class,
            'frontend-base.button' => \App\View\Components\Frontend\Base\Button::class,
            'frontend-base.divider' => \App\View\Components\Frontend\Base\Divider::class,
            'frontend-base.link' => \App\View\Components\Frontend\Base\Link::class,
            'frontend-base.pill' => \App\View\Components\Frontend\Base\Pill::class,

            'frontend-cards.card' => \App\View\Components\Frontend\Cards\Card::class,
            'frontend-cards.feature-card' => \App\View\Components\Frontend\Cards\FeatureCard::class,
            'frontend-cards.pricing-card' => \App\View\Components\Frontend\Cards\PricingCard::class,
            'frontend-cards.testimonial-card' => \App\View\Components\Frontend\Cards\TestimonialCard::class,

            'frontend-sections.cta-block' => \App\View\Components\Frontend\Sections\CtaBlock::class,
            'frontend-sections.faq-block' => \App\View\Components\Frontend\Sections\FaqBlock::class,
            'frontend-sections.feature-grid' => \App\View\Components\Frontend\Sections\FeatureGrid::class,
            'frontend-sections.hero-section' => \App\View\Components\Frontend\Sections\HeroSection::class,
            'frontend-sections.logo-strip' => \App\View\Components\Frontend\Sections\LogoStrip::class,
            'frontend-sections.section-header' => \App\View\Components\Frontend\Sections\SectionHeader::class,
            'frontend-sections.stats-strip' => \App\View\Components\Frontend\Sections\StatsStrip::class,
        ];

        foreach ($components as $alias => $class) {
            Blade::component($alias, $class);
        }
    }
}
