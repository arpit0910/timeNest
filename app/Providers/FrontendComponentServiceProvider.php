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
            'frontend-sections-carousel' => \App\View\Components\Frontend\Sections\Carousel::class,
            'frontend-sections-fingerprint-animation' => \App\View\Components\Frontend\Sections\FingerprintAnimation::class,
            'frontend-sections-gear-animation' => \App\View\Components\Frontend\Sections\GearAnimation::class,
            'frontend-sections-hero-section' => \App\View\Components\Frontend\Sections\HeroSection::class,
            'frontend-sections-logo-strip' => \App\View\Components\Frontend\Sections\LogoStrip::class,
            'frontend-sections-section-header' => \App\View\Components\Frontend\Sections\SectionHeader::class,
            'frontend-sections-stats-strip' => \App\View\Components\Frontend\Sections\StatsStrip::class,
            'frontend-sections-ticker' => \App\View\Components\Frontend\Sections\Ticker::class,
            
            // New Customer Stories Components
            'frontend-sections-testimonial-section' => \App\View\Components\Frontend\Sections\TestimonialSection::class,
            'frontend-sections-company-logo-strip' => \App\View\Components\Frontend\Sections\CompanyLogoStrip::class,
            'frontend-sections-featured-story' => \App\View\Components\Frontend\Sections\FeaturedStory::class,
            'frontend-sections-video-testimonials' => \App\View\Components\Frontend\Sections\VideoTestimonials::class,
            'frontend-sections-video-card' => \App\View\Components\Frontend\Sections\VideoCard::class,
            'frontend-sections-customer-filters' => \App\View\Components\Frontend\Sections\CustomerFilters::class,
            'frontend-sections-stats-section' => \App\View\Components\Frontend\Sections\StatsSection::class,
            'frontend-sections-case-study-carousel' => \App\View\Components\Frontend\Sections\CaseStudyCarousel::class,
            'frontend-sections-testimonial-wall' => \App\View\Components\Frontend\Sections\TestimonialWall::class,
            
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
            'frontend-sections.carousel' => \App\View\Components\Frontend\Sections\Carousel::class,
            'frontend-sections.fingerprint-animation' => \App\View\Components\Frontend\Sections\FingerprintAnimation::class,
            'frontend-sections.gear-animation' => \App\View\Components\Frontend\Sections\GearAnimation::class,
            'frontend-sections.hero-section' => \App\View\Components\Frontend\Sections\HeroSection::class,
            'frontend-sections.logo-strip' => \App\View\Components\Frontend\Sections\LogoStrip::class,
            'frontend-sections.section-header' => \App\View\Components\Frontend\Sections\SectionHeader::class,
            'frontend-sections.stats-strip' => \App\View\Components\Frontend\Sections\StatsStrip::class,
            'frontend-sections.ticker' => \App\View\Components\Frontend\Sections\Ticker::class,
            
            // New Customer Stories dot notations
            'frontend-sections.testimonial-section' => \App\View\Components\Frontend\Sections\TestimonialSection::class,
            'frontend-sections.company-logo-strip' => \App\View\Components\Frontend\Sections\CompanyLogoStrip::class,
            'frontend-sections.featured-story' => \App\View\Components\Frontend\Sections\FeaturedStory::class,
            'frontend-sections.video-testimonials' => \App\View\Components\Frontend\Sections\VideoTestimonials::class,
            'frontend-sections.video-card' => \App\View\Components\Frontend\Sections\VideoCard::class,
            'frontend-sections.customer-filters' => \App\View\Components\Frontend\Sections\CustomerFilters::class,
            'frontend-sections.stats-section' => \App\View\Components\Frontend\Sections\StatsSection::class,
            'frontend-sections.case-study-carousel' => \App\View\Components\Frontend\Sections\CaseStudyCarousel::class,
            'frontend-sections.testimonial-wall' => \App\View\Components\Frontend\Sections\TestimonialWall::class,

            // New Homepage Refactor Components
            'frontend-sections.hero' => \App\View\Components\Frontend\Sections\Hero::class,
            'frontend-sections.cta' => \App\View\Components\Frontend\Sections\Cta::class,
            'frontend-sections.testimonials.index' => \App\View\Components\Frontend\Sections\Testimonials\Index::class,
            'frontend-sections.faq.index' => \App\View\Components\Frontend\Sections\Faq\Index::class,
            
            'frontend-widgets.attendance.engine' => \App\View\Components\Frontend\Widgets\Attendance\Engine::class,
            'frontend-widgets.timelog.productivity' => \App\View\Components\Frontend\Widgets\Timelog\Productivity::class,
            'frontend-widgets.leave.workflow' => \App\View\Components\Frontend\Widgets\Leave\Workflow::class,
            
            'frontend-modals.book-demo' => \App\View\Components\Frontend\Modals\BookDemo::class,
        ];

        foreach ($components as $alias => $class) {
            Blade::component($alias, $class);
        }

        // Register anonymous components path for the newly added components
        Blade::anonymousComponentPath(resource_path('views/frontend/components/sections'), 'frontend-sections');
    }
}
