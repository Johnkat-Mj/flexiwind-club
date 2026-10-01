<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;

/**
 * Siège occupé sur un abonnement. Un siège = un compte.
 */
class SubscriptionMember extends Model
{
    use AsPivot;

    public const ROLE_OWNER = 'owner';

    public const ROLE_MEMBER = 'member';

    protected $table = 'subscription_members';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return ['joined_at' => 'datetime'];
    }
}
