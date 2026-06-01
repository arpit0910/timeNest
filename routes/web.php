<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\FeaturesController;
use App\Http\Controllers\Frontend\AiController;
use App\Http\Controllers\Frontend\PricingController;
use App\Http\Controllers\Frontend\RoadmapController;
use App\Http\Controllers\Frontend\SecurityController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\SolutionsController;
use App\Http\Controllers\Frontend\IndustriesController;
use App\Http\Controllers\Frontend\CompareController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\FaqController;
use App\Http\Controllers\Frontend\DocsController;
use App\Http\Controllers\Frontend\ReleaseNotesController;
use App\Http\Controllers\Frontend\ChangelogController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\CareersController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\DemoController;
use App\Http\Controllers\Frontend\LegalController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\ProductFeatureController;

Route::prefix('')->name('frontend.')->group(function () {
    // Core
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/features', [FeaturesController::class, 'index'])->name('features');
    Route::get('/ai', [AiController::class, 'index'])->name('ai');
    Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');
    Route::get('/roadmap', [RoadmapController::class, 'index'])->name('roadmap');
    Route::get('/security', [SecurityController::class, 'index'])->name('security');

    // Product
    Route::get('/product/organizations', [ProductController::class, 'organizations'])->name('product.organizations');
    Route::get('/product/freelancers', [ProductController::class, 'freelancers'])->name('product.freelancers');
    Route::get('/product/freelance-workspace', [ProductController::class, 'workspace'])->name('product.workspace');

    // Dynamic Features (Workforce, Operations, AI)
    Route::get('/feature/{category}/{slug}', [ProductFeatureController::class, 'show'])->name('feature.show');

    // Solutions
    Route::get('/solutions/{slug}', [SolutionsController::class, 'show'])->name('solutions.show');

    // Industries
    Route::get('/industries/{slug}', [IndustriesController::class, 'show'])->name('industries.show');

    // Comparison
    Route::get('/compare/{slug}', [CompareController::class, 'show'])->name('compare.show');

    // Resources
    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
    Route::get('/faqs', [FaqController::class, 'index'])->name('faqs.index');
    Route::get('/docs', [DocsController::class, 'index'])->name('docs.index');
    Route::get('/docs/{slug}', [DocsController::class, 'show'])->name('docs.show');
    Route::get('/release-notes', [ReleaseNotesController::class, 'index'])->name('release-notes');
    Route::get('/changelog', [ChangelogController::class, 'index'])->name('changelog');

    // Company
    Route::get('/about', [AboutController::class, 'index'])->name('about');
    Route::get('/careers', [CareersController::class, 'index'])->name('careers');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::get('/book-demo', [DemoController::class, 'index'])->name('book-demo');

    // Legal
    Route::get('/privacy-policy', [LegalController::class, 'privacy'])->name('legal.privacy');
    Route::get('/terms-of-service', [LegalController::class, 'terms'])->name('legal.terms');
    Route::get('/compliance', [LegalController::class, 'compliance'])->name('legal.compliance');

    // Search
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    Route::get('/search/suggest', [SearchController::class, 'search'])->name('search.suggest');
});
