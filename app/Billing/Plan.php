<?php

namespace App\Billing;

use Carbon\CarbonInterface;
use DateInterval;
use Illuminate\Support\Number;

/**
 * Un plan du catalogue, lu depuis config/plans.php.
 *
 * Volontairement pas un modèle Eloquent : le prix et le nombre de sièges ne
 * doivent jamais pouvoir être modifiés par une requête, et un plan n'a pas
 * de cycle de vie propre.
 */
final class Plan
{
    /**
     * @param  list<string>  $features
     */
    private function __construct(
        public readonly string $key,
        public readonly string $name,
        public readonly string $billingLabel,
        public readonly int $seats,
        public readonly ?string $duration,
        public readonly int $priceCents,
        public readonly string $currency,
        public readonly string $tagline,
        public readonly array $features,
        public readonly bool $featured,
    ) {}

    /** Le plan existe-t-il vraiment ? Seule porte d'entrée depuis une requête. */
    public static function find(?string $key): ?self
    {
        if ($key === null) {
            return null;
        }

        $config = config('plans.'.$key);

        return is_array($config) ? self::fromConfig($key, $config) : null;
    }

    /** @return array<string, self> */
    public static function all(): array
    {
        $plans = [];

        foreach ((array) config('plans', []) as $key => $config) {
            $plans[$key] = self::fromConfig((string) $key, (array) $config);
        }

        return $plans;
    }

    /** @return list<string> */
    public static function keys(): array
    {
        return array_keys((array) config('plans', []));
    }

    public function isLifetime(): bool
    {
        return $this->duration === null;
    }

    public function isTeam(): bool
    {
        return $this->seats > 1;
    }

    /** Date de fin calculée côté serveur, jamais reçue du client. */
    public function endsAtFrom(CarbonInterface $start): ?CarbonInterface
    {
        return $this->duration === null
            ? null
            : $start->avoidMutation()->add(new DateInterval($this->duration));
    }

    public function formattedPrice(): string
    {
        return self::money($this->priceCents, $this->currency);
    }

    /**
     * Un montant lisible : « €499 » quand il est rond, « €12.50 » sinon.
     */
    public static function money(int $cents, string $currency): string
    {
        return (string) Number::currency($cents / 100, $currency, precision: $cents % 100 === 0 ? 0 : 2);
    }

    /**
     * @param  array<string, mixed>  $config
     */
    private static function fromConfig(string $key, array $config): self
    {
        return new self(
            key: $key,
            name: (string) ($config['name'] ?? $key),
            billingLabel: (string) ($config['billing_label'] ?? ''),
            seats: (int) ($config['seats'] ?? 1),
            duration: isset($config['duration']) ? (string) $config['duration'] : null,
            priceCents: (int) ($config['price_cents'] ?? 0),
            currency: (string) ($config['currency'] ?? 'EUR'),
            tagline: (string) ($config['tagline'] ?? ''),
            features: array_values((array) ($config['features'] ?? [])),
            featured: (bool) ($config['featured'] ?? false),
        );
    }
}
