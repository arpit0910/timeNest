<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Strict mode: prevent lazy loading, silently discarded attributes, and invalid access
        Model::shouldBeStrict(! $this->app->isProduction());

        // Rate limiters
        $this->configureRateLimiting();

        // Register Observers
        \App\Models\Attendance\EmployeeLeave::observe(\App\Observers\EmployeeLeaveObserver::class);

        // Centralized AppOwner root bypass
        \Illuminate\Support\Facades\Gate::before(function ($user, $ability) {
            $platformRole = resolve_platform_role($user);
            if ($platformRole && $platformRole->name === \App\Enums\SystemRole::AppOwner->value) {
                return true;
            }
            return null;
        });
    }

    /**
     * Configure rate limiting for different API route groups.
     */
    private function configureRateLimiting(): void
    {
        // Auth endpoints: 5 requests per minute per IP (brute-force protection)
        RateLimiter::for('auth', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        // Platform admin routes: 120 requests per minute per user
        RateLimiter::for('platform', function (Request $request) {
            return Limit::perMinute(120)->by($request->user()?->id ?: $request->ip());
        });

        // Corporation routes: 60 requests per minute per user
        RateLimiter::for('corp', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // General API: 60 requests per minute per IP
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
