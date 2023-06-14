<?php

namespace App\Http\Controllers\Api\V1;

use App\Facades\Contract;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class RegistrationController
{
    public function __invoke(Request $request)
    {
        /** @var \App\Models\Contract $contract */
        $contract = Contract::getFacadeRoot();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', "regex:/{$contract->mail_domain}/i", Rule::unique('users')],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'company_id' => $contract->company_id
        ]);

        return Response::make('', ResponseCode::HTTP_CREATED);
    }
}
