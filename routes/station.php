<?php

use App\Http\Controllers\Station\StationDataController;

//Route::middleware('api-key')->group(function () {
    Route::group(['prefix' => 'station'], function () {
        Route::get('/data', [StationDataController::class, 'index']);
        Route::post('/data', [StationDataController::class, 'store']);
    });
//});
