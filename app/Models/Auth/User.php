<?php

declare(strict_types=1);

namespace App\Models\Auth;

use App\Enums\UserStatus;
use App\Models\Organization\Organization;
use App\Models\Geo\Country;
use App\Models\Geo\State;
use App\Models\Organization\OrganizationMembership;
use App\Models\Membership\EmployeeProfile;
use App\Models\Membership\PlatformMembership;
use App\Models\Auth\OAuthAccount;
use App\Traits\HasUuid;
use Carbon\Carbon;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;

/**
 * User model — global identity layer.
 *
 * One record per human. Owns authentication. Never organization-specific.
 * Employment data lives in EmployeeProfile (organization-scoped).
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string $email
 * @property string|null $password
 * @property bool $password_set
 * @property Carbon|null $email_verified_at
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $phone
 * @property Carbon|null $phone_verified_at
 * @property string|null $avatar_url
 * @property Carbon|null $date_of_birth
 * @property string|null $gender
 * @property int|null $country_id
 * @property int|null $state_id
 * @property string $timezone
 * @property string $locale
 * @property Carbon|null $profile_completed_at
 * @property Carbon|null $two_factor_enabled_at
 * @property UserStatus $status
 * @property bool $is_active
 * @property int $token_version
 * @property Carbon|null $last_login_at
 * @property string|null $last_login_ip
 *
 * @property-read bool $phone_verified      Computed: phone_verified_at !== null
 * @property-read bool $two_factor_enabled   Computed: two_factor_enabled_at !== null
 * @property \Illuminate\Database\Eloquent\Collection<int, OAuthAccount> $oauthAccounts
 */
class User extends Authenticatable implements JWTSubject
{
    use HasFactory, HasRoles, HasUuid, Notifiable, SoftDeletes;

    protected $table = 'users';

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'password_set',
        'email_verified_at',
        'email_verification_token',
        'email_verification_token_expires_at',
        'first_name',
        'last_name',
        'phone',
        'phone_verified_at',
        'avatar_url',
        'date_of_birth',
        'gender',
        'country_id',
        'state_id',
        'city',
        'address_line_1',
        'address_line_2',
        'postal_code',
        'timezone',
        'locale',
        'profile_completed_at',
        'two_factor_secret',
        'two_factor_enabled_at',
        'two_factor_recovery_codes',
        'status',
        'is_active',
        'token_version',
        'last_login_at',
        'last_login_ip',
    ];

    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'email_verification_token',
        'email_verification_token_expires_at',
    ];

    /**
     * Accessors appended to JSON — backward-compatible booleans
     * derived from timestamp columns.
     *
     * @var list<string>
     */
    protected $appends = [
        'phone_verified',
        'two_factor_enabled',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'email_verification_token_expires_at' => 'datetime',
            'password' => 'hashed',
            'password_set' => 'boolean',
            'phone_verified_at' => 'datetime',
            'date_of_birth' => 'date',
            'profile_completed_at' => 'datetime',
            'two_factor_secret' => 'encrypted',
            'two_factor_enabled_at' => 'datetime',
            'two_factor_recovery_codes' => 'encrypted:array',
            'is_active' => 'boolean',
            'status' => UserStatus::class,
            'token_version' => 'integer',
            'last_login_at' => 'datetime',
        ];
    }

    // ─── JWT Interface ───────────────────────────────────────────

    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    /**
     * @return array<string, mixed>
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }

    // ─── Relationships ───────────────────────────────────────────

    /**
     * @return HasMany<OAuthAccount, self>
     */
    public function oauthAccounts(): HasMany
    {
        return $this->hasMany(OAuthAccount::class);
    }

    /**
     * @return HasMany<RefreshToken>
     */
    public function refreshTokens(): HasMany
    {
        return $this->hasMany(RefreshToken::class);
    }

    /**
     * @return HasMany<OrganizationMembership>
     */
    public function organizationMemberships(): HasMany
    {
        return $this->hasMany(OrganizationMembership::class);
    }

    /**
     * @return HasOne<PlatformMembership>
     */
    public function platformMembership(): HasOne
    {
        return $this->hasOne(PlatformMembership::class);
    }

    /**
     * @return HasMany<EmployeeProfile>
     */
    public function employeeProfiles(): HasMany
    {
        return $this->hasMany(EmployeeProfile::class);
    }

    /**
     * @return BelongsToMany<Organization>
     */
    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class, 'organization_memberships')
            ->withPivot('status', 'joined_at')
            ->withTimestamps();
    }

    /**
     * @return BelongsTo<Country, self>
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * @return BelongsTo<State, self>
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    // ─── Scopes ──────────────────────────────────────────────────

    /**
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeVerified($query)
    {
        return $query->whereNotNull('email_verified_at');
    }

    // ─── Computed Accessors ────────────────────────────────────────

    /**
     * Backward-compatible boolean: true when phone has been OTP-verified.
     */
    public function getPhoneVerifiedAttribute(): bool
    {
        return $this->phone_verified_at !== null;
    }

    /**
     * Backward-compatible boolean: true when 2FA is active.
     */
    public function getTwoFactorEnabledAttribute(): bool
    {
        return $this->two_factor_enabled_at !== null;
    }

    // ─── Helpers ─────────────────────────────────────────────────

    /**
     * Increment token version to invalidate all existing JWTs.
     */
    public function incrementTokenVersion(): void
    {
        $this->increment('token_version');
    }

    /**
     * Check if user has a platform membership.
     */
    public function isPlatformUser(): bool
    {
        return $this->platformMembership()->exists();
    }
}
