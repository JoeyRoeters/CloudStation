<?php

use App\Http\Controllers\Analyse\AnalyseController;
use App\Http\Controllers\Dashboard\Dashboard;
use App\Http\Controllers\ImportMongoDataController;
use App\Http\Controllers\Notification\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Station\StationController;
use App\Http\Controllers\Station\StationIndexController;
use App\Http\Controllers\Station\StationShowController;
use App\Http\Controllers\Test;
use Illuminate\Support\Facades\Route;

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
    Route::get('/dashboard', fn() => view('dashboard.dashboard'))->name('dashboard');

    Route::get('/', [Dashboard::class, 'dashboard']);

    Route::get('/station', [StationIndexController::class, 'index'])->name('station.index');
    Route::get('/station/table', [StationIndexController::class, 'table']);
    Route::get('/station/{station}', [StationShowController::class, 'show'])->name('station.show');
    Route::post('/station/{station}', [StationShowController::class, 'store'])->name('station.store');

    Route::get('/notification', [NotificationController::class, 'index'])->name('notification.index');
    Route::get('/notification/table', [NotificationController::class, 'table']);
    Route::get('/notification/{name}', [NotificationController::class, 'read']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('analyse')->group(function() {
        Route::get('/', [AnalyseController::class, 'index'])->name('analyse');
        Route::post('/', [AnalyseController::class, 'store']);
    });
});

require __DIR__.'/auth.php';

Route::get('/import-mongo-data', [ImportMongoDataController::class, 'index']);
