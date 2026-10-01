<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * Jeton CLI. Le secret n'existe en clair qu'une fois, au moment où on le
 * montre à l'utilisateur ; la base ne garde que son SHA-256.
 *
 * Pas d'expiration : le jeton vit jusqu'à révocation. Ce qui l'invalide en
 * pratique, c'est l'abonnement — vérifié à chaque appel du registre, pas
 * seulement à la création.
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $token_hash
 * @property string $prefix
 * @property Carbon|null $last_used_at
 * @property string|null $last_used_ip
 * @property Carbon|null $revoked_at
 */
class ApiToken extends Model
{
    protected $guarded = ['id'];

    protected $hidden = ['token_hash'];

    /** Secret en clair, uniquement en mémoire, juste après issue(). */
    public ?string $plainText = null;

    protected function casts(): array
    {
        return [
            'last_used_at' => 'datetime',
            'revoked_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Fabrique un jeton et renvoie le modèle porteur du secret en clair.
     * L'appelant doit afficher `$token->plainText` immédiatement : il est
     * irrécupérable ensuite.
     */
    public static function issue(User $user, string $name): self
    {
        // 32 octets d'entropie : un hash SHA-256 non salé reste sûr, il n'y a
        // rien à deviner par force brute.
        $secret = 'fx_'.Str::random(48);

        $token = new self([
            'user_id' => $user->id,
            'name' => $name,
            'token_hash' => self::hash($secret),
            'prefix' => Str::substr($secret, 0, 11),
        ]);

        $token->save();
        $token->plainText = $secret;

        return $token;
    }

    public static function hash(string $secret): string
    {
        return hash('sha256', $secret);
    }

    /** Retrouve un jeton actif à partir du secret présenté par la CLI. */
    public static function findActive(string $secret): ?self
    {
        if (! str_starts_with($secret, 'fx_')) {
            return null;
        }

        return self::query()
            ->whereNull('revoked_at')
            ->where('token_hash', self::hash($secret))
            ->first();
    }

    public function isRevoked(): bool
    {
        return $this->revoked_at !== null;
    }

    public function revoke(): void
    {
        if (! $this->isRevoked()) {
            $this->forceFill(['revoked_at' => now()])->save();
        }
    }

    public function markUsed(?string $ip = null): void
    {
        // Appelé à chaque requête du registre : on n'écrit que si l'info
        // change vraiment (nouvelle IP, ou plus d'une minute écoulée).
        if ($this->last_used_ip === $ip && $this->last_used_at?->gt(now()->subMinute())) {
            return;
        }

        // Sans toucher updated_at : ce n'est pas une modification du jeton.
        static::withoutTimestamps(fn () => $this->forceFill([
            'last_used_at' => now(),
            'last_used_ip' => $ip,
        ])->saveQuietly());
    }

    /** @param  Builder<self>  $query */
    public function scopeActive(Builder $query): void
    {
        $query->whereNull('revoked_at');
    }

    public function maskedLabel(): string
    {
        return $this->prefix.str_repeat('•', 8);
    }
}
