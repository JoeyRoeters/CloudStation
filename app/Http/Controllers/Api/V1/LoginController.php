<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController
{
    public function __invoke(LoginRequest $request)
    {
        $request->authenticate();

        $user = Auth::user();

        $user->tokens()->delete();
        $token = $user->createToken('company', [
            "countries" => [
                "NL"
            ],
            "selectable" => [
                "wind_speed"
            ]
        ]);

        return $token->plainTextToken;
    }
}