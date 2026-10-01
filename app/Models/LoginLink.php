<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * Lien de connexion à usage unique (magic link).
 *
 * Trois garde-fous : durée de vie courte, consommation unique, et
 * invalidation de tous les autres liens de la même adresse dès qu'un lien
 * est utilisé — un lien resté dans une boîte mail ne rouvre pas la session.
 *
 * @property int $id
 * @property string $email
 * @property string $token_hash
 * @property Carbon $expires_at
 * @property Carbon|null $consumed_at
 * @property string|null $requested_ip
 */
class LoginLink extends Model
{
    use MassPrunable;

    /** Assez pour aller chercher son mail, trop court pour traîner. */
    public const TTL_MINUTES = 15;

    protected $guarded = ['id'];

    protected $hidden = ['token_hash'];

    public ?string $plainToken = null;

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'consumed_at' => 'datetime',
        ];
    }

    /**
     * Un lien mort depuis une journée ne sert plus à rien, même aux logs.
     *
     * @return Builder<self>
     */
    public function prunable(): Builder
    {
        return static::query()->where('expires_at', '<', now()->subDay());
    }

    public static function issue(string $email, ?string $ip = null, ?string $userAgent = null): self
    {
        $secret = Str::random(64);

        $link = new self([
            'email' => Str::lower($email),
            'token_hash' => hash('sha256', $secret),
            'expires_at' => now()->addMinutes(self::TTL_MINUTES),
            'requested_ip' => $ip,
            'requested_user_agent' => Str::limit((string) $userAgent, 250, ''),
        ]);

        $link->save();
        $link->plainToken = $secret;

        return $link;
    }

    /** Lien encore utilisable pour cette adresse, ou null. */
    public static function findUsable(string $email, string $secret): ?self
    {
        return self::query()
            ->where('email', Str::lower($email))
            ->where('token_hash', hash('sha256', $secret))
            ->whereNull('consumed_at')
            ->where('expires_at', '>', now())
            ->first();
    }

    /**
     * Marque ce lien comme utilisé et périme tous les autres liens en
     * attente pour la même adresse.
     */
    public function consume(): void
    {
        $this->forceFill(['consumed_at' => now()])->save();

        self::query()
            ->where('email', $this->email)
            ->whereKeyNot($this->getKey())
            ->whereNull('consumed_at')
            ->update(['consumed_at' => now()]);
    }
}
