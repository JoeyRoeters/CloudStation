<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \App\Models\Contract
 */
class Contract extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'contract';
    }
}
