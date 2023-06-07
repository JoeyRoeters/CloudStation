<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Auth;

class AuthController
{
    public function __invoke()
    {
        return Auth::user()->only('name', 'email');
    }
}