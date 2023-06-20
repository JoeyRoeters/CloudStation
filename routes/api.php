<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CompanyController;
use App\Http\Controllers\Api\V1\ContractController;
use App\Http\Controllers\Api\V1\LoginController;
use App\Http\Controllers\Api\V1\RegistrationController;
use App\Http\Controllers\Api\V1\StationMeasurementsController;
use App\Http\Controllers\Api\V1\StationQueryMeasurementsController;
use App\Http\Middleware\ContractMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->middleware(ContractMiddleware::class)->group(function () {
    Route::middleware('guest')->group(function () {
       Route::post('login', LoginController::class)->name('api.login');
       Route::post('registration', RegistrationController::class)->name('api.registration');
    });

    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        Route::get('company', CompanyController::class)->name('api.company');
        Route::get('contract', ContractController::class)->name('api.contract');

        Route::prefix('measurements')->group(function () {
            Route::get('/', StationMeasurementsController::class)->name('api.measurements');
            Route::get('query/{id}', StationQueryMeasurementsController::class)->name('api.measurements.query');
        });

        Route::prefix('auth')->group(function () {
            Route::get('/', AuthController::class)->name('api.auth');
        });
    });
});
