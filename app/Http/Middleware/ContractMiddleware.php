<?php

namespace App\Http\Middleware;

use App\Models\Contract;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class ContractMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $contract = Contract::where('token', $request->header('x-contract'))->first();

        if ($contract instanceof Contract) {
            App::instance('contract', $contract);

            return $next($request);
        }

        return Response::make('No contract found', ResponseCode::HTTP_NOT_FOUND);
    }
}
