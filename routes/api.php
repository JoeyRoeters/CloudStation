<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ContractController;
use App\Http\Controllers\Api\V1\LoginController;
use App\Http\Controllers\Api\V1\WeatherMeasurementsController;
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

Route::prefix('v1')->group(function () {
    Route::middleware('guest')->group(function () {
       Route::post('login', LoginController::class)->name('api.login');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('contract', ContractController::class)->name('api.contract');
        Route::get('measurements', WeatherMeasurementsController::class)->name('api.measurements');

        Route::prefix('auth')->group(function () {
            Route::get('/', AuthController::class)->name('api.auth');
        });
    });
});
