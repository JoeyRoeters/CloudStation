<?php

namespace App\Http\Controllers\Api\V1;

use App\Facades\Contract;

class CompanyController
{
    public function __invoke()
    {
        /** @var \App\Models\Contract $contract */
        $contract = Contract::getFacadeRoot();

        return $contract->company->only('name');
    }
}
