<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * Invitation à occuper un siège d'un abonnement d'équipe.
 *
 * Même principe que les jetons : le lien porte un secret aléatoire dont
 * seul le SHA-256 est stocké, et il n'est valable qu'une fois.
 *
 * @property int $id
 * @property int $subscription_id
 * @property int $invited_by
 * @property string $email
 * @property string $token_hash
 * @property Carbon $expires_at
 * @property Carbon|null $accepted_at
 * @property Carbon|null $revoked_at
 */
class Invitation extends Model
{
    /** Une invitation non utilisée reste valable une semaine. */
    public const TTL_DAYS = 7;

    protected $guarded = ['id'];

    protected $hidden = ['token_hash'];

    public ?string $plainToken = null;

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'accepted_at' => 'datetime',
            'revoked_at' => 'datetime',
        ];
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public function inviter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    public static function issue(Subscription $subscription, User $inviter, string $email): self
    {
        $secret = Str::random(64);

        $invitation = new self([
            'subscription_id' => $subscription->id,
            'invited_by' => $inviter->id,
            'email' => Str::lower($email),
            'token_hash' => hash('sha256', $secret),
            'expires_at' => now()->addDays(self::TTL_DAYS),
        ]);

        $invitation->save();
        $invitation->plainToken = $secret;

        return $invitation;
    }

    public static function findPending(string $secret): ?self
    {
        return self::query()
            ->where('token_hash', hash('sha256', $secret))
            ->whereNull('accepted_at')
            ->whereNull('revoked_at')
            ->where('expires_at', '>', now())
            ->first();
    }

    public function isPending(): bool
    {
        return $this->accepted_at === null
            && $this->revoked_at === null
            && $this->expires_at->isFuture();
    }

    public function revoke(): void
    {
        $this->forceFill(['revoked_at' => now()])->save();
    }
}
