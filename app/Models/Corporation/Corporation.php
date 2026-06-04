<?php

declare(strict_types=1);

namespace App\Models\Corporation;

use App\Enums\CorporationPlan;
use App\Models\Auth\User;
use App\Models\Geo\Country;
use App\Models\Geo\State;
use App\Models\Invitation\Invitation;
use App\Models\Membership\CorpMembership;
use App\Models\Membership\EmployeeProfile;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

//TODO: Corporation creation flow: A user will register and will login, then he will purchase a organization plan and then a subscription record will be created in subscriptions table against a plan and creted by that user. Then only a user can create a corporation unless no one except app owners can perform this creation action.

/**
 * Corporation model — tenant registry.
 *
 * @property int $id
 * @property string $uuid
 * @property string $legal_name
 * @property string $slug
 * @property CorporationPlan $plan
 * @property bool $is_active
 * @property bool $is_verified
 */
class Corporation extends Model
{
    use HasUuid, SoftDeletes;

    protected $table = 'corporations';

    protected $fillable = [
        'legal_name', 'trading_name', 'slug',
        'legal_entity_type', 'industry', 'company_size',
        'registration_number', 'tax_id', 'legal_identifiers',
        'email', 'phone', 'website',
        'address_line_1', 'address_line_2', 'city', 'postal_code',
        'state_id', 'country_id',
        'operational_address_line_1', 'operational_city', 'operational_postal_code',
        'operational_state_id', 'operational_country_id',
        'timezone', 'locale', 'currency_code', 'date_format', 'week_start',
        'plan', 'plan_expires_at', 'max_users',
        'logo_url', 'brand_color_primary', 'brand_color_secondary',
        'settings', 'feature_flags',
        'is_active', 'is_verified', 'verified_at', 'verified_by',
    ];

    protected function casts(): array
    {
        return [
            'plan' => CorporationPlan::class,
            'legal_identifiers' => 'array',
            'settings' => 'array',
            'feature_flags' => 'array',
            'is_active' => 'boolean',
            'is_verified' => 'boolean',
            'plan_expires_at' => 'datetime',
            'verified_at' => 'datetime',
            'max_users' => 'integer',
        ];
    }

    // ─── Relationships ───────────────────────────────────────────

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }

    public function memberships(): HasMany
    {
        return $this->hasMany(CorpMembership::class);
    }

    public function employeeProfiles(): HasMany
    {
        return $this->hasMany(EmployeeProfile::class);
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'corp_memberships')
            ->withPivot('role_id', 'status', 'joined_at')->withTimestamps();
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function operationalCountry(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'operational_country_id');
    }

    public function operationalState(): BelongsTo
    {
        return $this->belongsTo(State::class, 'operational_state_id');
    }

    public function verifiedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // ─── Scopes ──────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeByPlan($query, CorporationPlan $plan)
    {
        return $query->where('plan', $plan);
    }
}
