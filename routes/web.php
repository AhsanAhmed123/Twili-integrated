<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParkingAttendentController;
use App\Http\Controllers\IVRController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashbaordController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return redirect()->route('parking-attendent-day');
});

Route::group(['middleware' => ['admin.guest']], function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/authenticate', [AuthController::class, 'Authenticate'])->name('Auth.login');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register-submit', [AuthController::class, 'registerSubmit'])->name('register-submit');
    

});
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware('auth')->group(function () {
Route::get('/dashboard', [DashbaordController::class, 'index'])->name('dashboard.index');
Route::get('/night', [DashbaordController::class, 'night'])->name('dashboard.night');
});
Route::get('parking-attendent-day',[ParkingAttendentController::class, 'parkingAttendentDay'])->name('parking-attendent-day');
Route::post('parking-attendent-day-store',[ParkingAttendentController::class, 'dayparkingstore'])->name('parking.store');
Route::get('parking-attendent-night',[ParkingAttendentController::class, 'parkingAttendentNight'])->name('parking-attendent-night');
Route::get('guest-parking-details',[ParkingAttendentController::class, 'guestparkingdetails'])->name('guest.parking.details');
Route::get('pre-authorize',[ParkingAttendentController::class, 'preAuthorize'])->name('pre.authorize');
Route::post('parking-preauthorize-store',[ParkingAttendentController::class, 'preAuthorizeStore'])->name('pre.authorize.store');

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

