<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['name', 'email'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /** Cache de requête pour activeSubscription(). */
    private ?Subscription $activeSubscription = null;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /** Abonnements dont ce compte occupe un siège (le sien ou celui d'une équipe). */
    public function subscriptions(): BelongsToMany
    {
        return $this->belongsToMany(Subscription::class, 'subscription_members')
            ->using(SubscriptionMember::class)
            ->withPivot(['role', 'joined_at'])
            ->withTimestamps();
    }

    /** Abonnements achetés par ce compte. */
    public function ownedSubscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class, 'owner_id');
    }

    public function apiTokens(): HasMany
    {
        return $this->hasMany(ApiToken::class);
    }

    /**
     * Abonnement actif qui couvre ce compte, s'il y en a un.
     *
     * Résolu une seule fois par requête : le gating l'interroge à chaque
     * exemple de la page.
     */
    public function activeSubscription(): ?Subscription
    {
        return $this->activeSubscription ??= $this->subscriptions()
            ->active()
            // Un abonnement personnel passe devant un siège d'équipe.
            ->orderByRaw('CASE WHEN subscriptions.owner_id = ? THEN 0 ELSE 1 END', [$this->id])
            ->first();
    }

    public function hasProAccess(): bool
    {
        return $this->activeSubscription() !== null;
    }

    /** Équipes dont ce compte est propriétaire et qui ont plus d'un siège. */
    public function ownedTeamSubscription(): ?Subscription
    {
        return $this->ownedSubscriptions()->active()->where('seats', '>', 1)->first();
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        $initials = Str::initials($this->name, true);

        return Str::length($initials) > 1
            ? Str::substr($initials, 0, 1).Str::substr($initials, -1)
            : $initials;
    }
}
