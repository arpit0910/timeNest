<?php

declare(strict_types=1);

namespace App\Models\Auth;

use App\Models\Corporation\Corporation;
use App\Models\Geo\Country;
use App\Models\Geo\State;
use App\Models\Membership\CorpMembership;
use App\Models\Membership\EmployeeProfile;
use App\Models\Membership\PlatformMembership;
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
 * One record per human. Owns authentication. Never corporation-specific.
 * Employment data lives in EmployeeProfile (corporation-scoped).
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
 * @property bool $phone_verified
 * @property string|null $avatar_url
 * @property Carbon|null $date_of_birth
 * @property string|null $gender
 * @property int|null $country_id
 * @property int|null $state_id
 * @property string $timezone
 * @property string $locale
 * @property bool $two_factor_enabled
 * @property bool $is_active
 * @property int $token_version
 * @property Carbon|null $last_login_at
 * @property string|null $last_login_ip
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
        'first_name',
        'last_name',
        'phone',
        'phone_verified',
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
        'two_factor_secret',
        'two_factor_enabled',
        'two_factor_recovery_codes',
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
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'password_set' => 'boolean',
            'phone_verified' => 'boolean',
            'date_of_birth' => 'date',
            'two_factor_secret' => 'encrypted',
            'two_factor_enabled' => 'boolean',
            'two_factor_recovery_codes' => 'encrypted:array',
            'is_active' => 'boolean',
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
     * @return HasMany<SocialAccount>
     */
    public function socialAccounts(): HasMany
    {
        return $this->hasMany(SocialAccount::class);
    }

    /**
     * @return HasMany<RefreshToken>
     */
    public function refreshTokens(): HasMany
    {
        return $this->hasMany(RefreshToken::class);
    }

    /**
     * @return HasMany<CorpMembership>
     */
    public function corpMemberships(): HasMany
    {
        return $this->hasMany(CorpMembership::class);
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
     * @return BelongsToMany<Corporation>
     */
    public function corporations(): BelongsToMany
    {
        return $this->belongsToMany(Corporation::class, 'corp_memberships')
            ->withPivot('role_id', 'status', 'joined_at')
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
