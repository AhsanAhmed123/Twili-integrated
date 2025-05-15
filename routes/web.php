<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParkingAttendentController;
use App\Http\Controllers\IVRController;
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

Route::get('/', function () {
    return redirect()->route('parking-attendent-day');
});

Route::get('parking-attendent-day',[ParkingAttendentController::class, 'parkingAttendentDay'])->name('parking-attendent-day');
Route::post('parking-attendent-day-store',[ParkingAttendentController::class, 'dayparkingstore'])->name('parking.store');
Route::get('parking-attendent-night',[ParkingAttendentController::class, 'parkingAttendentNight'])->name('parking-attendent-night');

Route::match(['get', 'post'],'/ivr/start', [IVRController::class, 'start']);
Route::match(['get', 'post'],'/ivr/step-a1', [IVRController::class, 'stepA1']);
Route::match(['get', 'post'],'/ivr/step-a2', [IVRController::class, 'stepA2']);
Route::match(['get', 'post'],'/ivr/step-a3', [IVRController::class, 'stepA3']);
Route::match(['get', 'post'],'/ivr/step-a4', [IVRController::class, 'stepA4']);
Route::match(['get', 'post'],'/ivr/step-a5', [IVRController::class, 'stepA5']);
Route::match(['get', 'post'],'/ivr/step-a6', [IVRController::class, 'stepA6']);
Route::match(['get', 'post'],'/ivr/step-a7', [IVRController::class, 'stepA7']);
Route::match(['get', 'post'],'/ivr/step-a8', [IVRController::class, 'stepA8']);
Route::match(['get', 'post'],'/ivr/step-a9', [IVRController::class, 'stepA9']);
Route::match(['get', 'post'],'/ivr/step-a10', [IVRController::class, 'stepA10']);
Route::match(['get', 'post'],'/ivr/step-a11', [IVRController::class, 'stepA11']);
Route::match(['get', 'post'],'/ivr/step-final', [IVRController::class, 'stepFinal']);



Route::match(['get', 'post'],'/ivr/step-d1', [IVRController::class, 'stepD1']);
Route::match(['get', 'post'],'/ivr/step-d2', [IVRController::class, 'stepD2']);
Route::match(['get', 'post'],'/ivr/step-d3', [IVRController::class, 'stepD3']);

