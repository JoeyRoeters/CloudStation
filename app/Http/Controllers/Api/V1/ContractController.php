<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Auth;

class ContractController
{
    public function __invoke()
    {
        return Auth::user()->currentAccessToken()->abilities;
    }
}
