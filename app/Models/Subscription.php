<?php

namespace App\Models;

use App\Billing\Plan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $owner_id
 * @property string $plan_key
 * @property int $seats
 * @property string $status
 * @property Carbon|null $starts_at
 * @property Carbon|null $ends_at
 * @property int $amount_cents
 * @property string $currency
 * @property string $provider
 * @property string|null $provider_reference
 * @property Carbon|null $paid_at
 */
class Subscription extends Model
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_ACTIVE = 'active';

    public const STATUS_EXPIRED = 'expired';

    public const STATUS_CANCELLED = 'cancelled';

    /**
     * Aucun $fillable : tous les abonnements sont créés par
     * App\Billing\Checkout, avec des valeurs relues depuis config/plans.php.
     * Un mass-assign accidentel depuis une requête est donc impossible.
     */
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'seats' => 'integer',
            'amount_cents' => 'integer',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'paid_at' => 'datetime',
        ];
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'subscription_members')
            ->using(SubscriptionMember::class)
            ->withPivot(['role', 'joined_at'])
            ->withTimestamps();
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class);
    }

    /** Invitations encore utilisables (ni acceptées, ni révoquées, ni expirées). */
    public function pendingInvitations(): HasMany
    {
        return $this->invitations()
            ->whereNull('accepted_at')
            ->whereNull('revoked_at')
            ->where('expires_at', '>', now());
    }

    public function plan(): ?Plan
    {
        return Plan::find($this->plan_key);
    }

    public function planName(): string
    {
        return $this->plan()?->name ?? $this->plan_key;
    }

    /**
     * Source de vérité unique de l'accès pro. Tout le reste (Tier, API CLI,
     * gating des vues) passe par ici.
     */
    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE
            && $this->paid_at !== null
            && ($this->ends_at === null || $this->ends_at->isFuture());
    }

    public function isLifetime(): bool
    {
        return $this->ends_at === null;
    }

    /** @param  Builder<self>  $query */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', self::STATUS_ACTIVE)
            ->whereNotNull('paid_at')
            ->where(fn (Builder $q) => $q->whereNull('ends_at')->orWhere('ends_at', '>', now()));
    }

    public function seatsUsed(): int
    {
        return $this->members()->count() + $this->pendingInvitations()->count();
    }

    public function seatsLeft(): int
    {
        return max(0, $this->seats - $this->seatsUsed());
    }

    public function hasSeatAvailable(): bool
    {
        return $this->seatsLeft() > 0;
    }

    public function isOwnedBy(User $user): bool
    {
        return $this->owner_id === $user->id;
    }
}
