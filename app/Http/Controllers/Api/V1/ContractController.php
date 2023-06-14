<?php

namespace App\Http\Controllers\Api\V1;

use App\Facades\Contract;

class ContractController
{
    public function __invoke()
    {
        return Contract::only(['countries', 'selectables']);
    }
}
