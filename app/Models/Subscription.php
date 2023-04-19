<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Subscription
 *
 * @property-read \App\Models\SubscriptionContract|null $contract
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription query()
 * @mixin \Eloquent
 */
class Subscription extends Model
{
    protected $table = 'subscriptions';

    /**
     * @return belongsTo
     */
    public function contract(): BelongsTo
    {
        return $this->belongsTo(SubscriptionContract::class, 'subscription_id');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
