<?php

use App\Http\Controllers\Analyse\AnalyseController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\ImportMongoDataController;
use App\Http\Controllers\Notification\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Station\StationIndexController;
use App\Http\Controllers\Station\StationShowController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::middleware(['auth:web', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('station')->group(function() {
        Route::get('/', [StationIndexController::class, 'index'])->name('station.index');
        Route::get('table', [StationIndexController::class, 'table']);

        Route::prefix('{station}')->group(function() {
            Route::get('/', [StationShowController::class, 'show'])->name('station.show');
            Route::post('/', [StationShowController::class, 'store'])->name('station.store');
        });
    });

    Route::prefix('notification')->group(function() {
        Route::get('/', [NotificationController::class, 'index'])->name('notification.index');
        Route::get('table', [NotificationController::class, 'table']);
        Route::get('{name}', [NotificationController::class, 'read']);
    });

    Route::prefix('profile')->group(function() {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::prefix('analyse')->group(function() {
        Route::get('/', [AnalyseController::class, 'index'])->name('analyse');
        Route::post('/', [AnalyseController::class, 'store']);
    });
});

require __DIR__.'/auth.php';

Route::get('/import-mongo-data', [ImportMongoDataController::class, 'index']);

Route::fallback(fn () => Redirect::route('dashboard'));
