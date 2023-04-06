<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $table = 'subscriptions';

    public function contract()
    {
        return $this->hasOne(SubscriptionContract::class, 'subscription_id', 'id');
    }

    public function user()
    {
        return $this->hasOne(UserProfile::class, 'user_id', 'user_id');
    }
}
