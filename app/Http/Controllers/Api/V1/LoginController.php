<?php

namespace App\Http\Controllers\Api\V1;

use App\Facades\Contract;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController
{
    public function __invoke(LoginRequest $request)
    {
        /** @var \App\Models\Contract $contract */
        $contract = Contract::getFacadeRoot();

        $request->authenticate(
            fn (Request $form) => Auth::attempt([
                'email' => $form->get('email'),
                'password' => $form->get('password'),
                'company_id' => $contract->company_id
            ])
        );

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

        return $user->createToken(
            $contract->company->name
        )->plainTextToken;
    }
}
