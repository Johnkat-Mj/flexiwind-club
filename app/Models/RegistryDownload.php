<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Une source Pro servie à la CLI. Écrit uniquement par le registre.
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $api_token_id
 * @property string $item
 * @property string $channel
 * @property string|null $ip
 * @property Carbon $created_at
 */
class RegistryDownload extends Model
{
    use MassPrunable;

    public const CHANNEL_CLI = 'cli';

    public const CHANNEL_MCP = 'mcp';

    public const UPDATED_AT = null;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return ['created_at' => 'datetime'];
    }

    /** @return Builder<self> */
    public function prunable(): Builder
    {
        return static::query()->where('created_at', '<', now()->subDays(90));
    }
}
