<?php

namespace App\Models\Mappings;

class SubscriptionTableMap
{
    public const TABLE = 'subscriptions';

    public const TABLE_ALL = 'subscriptions.*';

    public const RELATION_CONTRACT = 'contract';
    public const RELATION_USER = 'user';

}
