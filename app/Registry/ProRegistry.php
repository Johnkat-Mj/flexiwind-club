<?php

namespace App\Registry;

use App\Models\ApiToken;
use App\Models\RegistryDownload;
use App\Models\User;
use Flexiwind\Docs\BlockRegistry;
use Flexiwind\Docs\Tier;
use Illuminate\Support\Facades\Cache;

/**
 * Le catalogue Pro tel que la CLI le voit.
 *
 * Seule la liste blanche de config/registry.php est servie : un nom qui n'y
 * figure pas n'atteint jamais le système de fichiers, quel que soit son
 * format. C'est la vraie barrière contre la traversée de répertoire ; la
 * regex du routeur n'est qu'une première couche.
 */
final class ProRegistry
{
    /** Un nom de block ou de composant : minuscules, chiffres, tirets. */
    public const NAME_PATTERN = '[a-z0-9]+(?:-[a-z0-9]+)*';

    public function __construct(private readonly BlockRegistry $blocks) {}

    public function has(string $name): bool
    {
        return preg_match('/^'.self::NAME_PATTERN.'$/', $name) === 1
            && array_key_exists($name, $this->catalog());
    }

    /** @return array<string, mixed>|null */
    public function find(string $name): ?array
    {
        return $this->has($name) ? $this->blocks->find($name, Tier::Pro) : null;
    }

    /**
     * Ce que contient le registre, sans les sources : de quoi lister ou
     * chercher côté CLI.
     *
     * @return list<array{name: string, type: string, title: string, description: string, version: string|null}>
     */
    public function index(): array
    {
        $names = array_keys($this->catalog());

        return Cache::remember('pro-registry:index:'.md5(implode(',', $names)), now()->addHour(), function () use ($names): array {
            $items = [];

            foreach ($names as $name) {
                $payload = $this->blocks->find($name, Tier::Pro);

                if ($payload === null) {
                    continue;
                }

                $items[] = [
                    'name' => $name,
                    'type' => (string) ($payload['type'] ?? 'registry:component'),
                    'title' => (string) ($payload['title'] ?? $name),
                    'description' => (string) ($payload['description'] ?? ''),
                    'version' => isset($payload['version']) ? (string) $payload['version'] : null,
                ];
            }

            return $items;
        });
    }

    public function recordDownload(User $user, ?ApiToken $token, string $name, ?string $ip, string $channel = RegistryDownload::CHANNEL_CLI): void
    {
        RegistryDownload::create([
            'user_id' => $user->id,
            'api_token_id' => $token?->id,
            'item' => $name,
            'channel' => $channel,
            'ip' => $ip,
        ]);
    }

    /** @return array<string, string> */
    private function catalog(): array
    {
        return (array) config('registry', []);
    }
}
