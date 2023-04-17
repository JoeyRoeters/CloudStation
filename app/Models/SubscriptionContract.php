<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SubscriptionContract
 *
 * @property int $id
 * @property int $subscription_id
 * @property int $user_id
 * @property string $start_date
 * @property string $end_date
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionContract newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionContract newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionContract query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionContract whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionContract whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionContract whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionContract whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionContract whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionContract whereSubscriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionContract whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionContract whereUserId($value)
 * @mixin \Eloquent
 */
class SubscriptionContract extends Model
{
    protected $table = 'subscription_contracts';
}
