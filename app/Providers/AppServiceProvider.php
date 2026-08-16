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

        \App\Models\Leave\EmployeeLeave::observe(\App\Observers\EmployeeLeaveObserver::class);
        \App\Models\Attendance\AttendanceWorklog::observe(\App\Observers\AttendanceWorklogObserver::class);

        // In-app notification triggers — see App\Services\Notification\NotificationService.
        \App\Models\Attendance\AttendanceAdjustmentRequest::observe(\App\Observers\AttendanceAdjustmentRequestObserver::class);
        \App\Models\Attendance\AttendanceEscalation::observe(\App\Observers\AttendanceEscalationObserver::class);
        \App\Models\Organization\OrganizationMembership::observe(\App\Observers\OrganizationMembershipObserver::class);
        \App\Models\Membership\EmployeeProfile::observe(\App\Observers\EmployeeProfileObserver::class);

        \Illuminate\Support\Facades\Gate::policy(\App\Models\Leave\EmployeeLeave::class, \App\Policies\EmployeeLeavePolicy::class);
        \Illuminate\Support\Facades\Gate::policy(\App\Models\Attendance\AttendanceWorklog::class, \App\Policies\AttendanceWorklogPolicy::class);
        \Illuminate\Support\Facades\Gate::policy(\App\Models\Attendance\AttendanceAdjustmentRequest::class, \App\Policies\AttendanceAdjustmentPolicy::class);
        \Illuminate\Support\Facades\Gate::policy(\App\Models\Attendance\AttendanceEscalation::class, \App\Policies\AttendanceEscalationPolicy::class);
        \Illuminate\Support\Facades\Gate::policy(\App\Models\Attendance\AttendanceDay::class, \App\Policies\AttendanceDayPolicy::class);

        // Platform accounts resolve against a capability map rather than a
        // blanket wildcard, so app_support (read) and app_auditor (read+export)
        // are expressible and a new policy method is not auto-granted to every
        // platform tier before anyone reviews it.
        \Illuminate\Support\Facades\Gate::before(function ($user, string $ability) {
            if (! $user->isPlatformAccount()) {
                return null; // ordinary user — fall through to Spatie and policies
            }

            // Platform-plane abilities are answered from the real assignment,
            // team-independently; a tier never manufactures them.
            if (str_starts_with($ability, 'platform.')
                || $ability === \App\Enums\SystemPermission::ORGANIZATIONS_MANAGE->value) {
                return has_platform_permission($user, $ability) ? true : null;
            }

            // Returning null rather than false on a miss matters: false
            // short-circuits into a special-cased denial, null falls through to
            // the normal path and yields a consistent 403.
            return $user->platformTenantAccess()?->grants($ability) ? true : null;
        });

        // Event Listeners
        \Illuminate\Support\Facades\Event::listen(
            \App\Events\InvitationCreated::class,
            \App\Listeners\SendInvitationNotification::class
        );

        // In-app notifications for the invitation outcome, addressed to the inviter.
        \Illuminate\Support\Facades\Event::listen(
            \App\Events\InvitationAccepted::class,
            [\App\Listeners\SendInvitationInAppNotification::class, 'handleAccepted']
        );
        \Illuminate\Support\Facades\Event::listen(
            \App\Events\InvitationRevoked::class,
            [\App\Listeners\SendInvitationInAppNotification::class, 'handleRevoked']
        );
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

        // Organization routes: 60 requests per minute per user
        RateLimiter::for('organization', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // General API: 60 requests per minute per IP
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
