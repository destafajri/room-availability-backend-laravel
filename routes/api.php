<?php

use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Auth\UserVerifyOtpController;
use App\Http\Controllers\Kost\KostController;
use App\Http\Controllers\RoomAvailability\RoomAvailabilityController;
use Illuminate\Http\Request;
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

// public routes
Route::post('/register/owner', [UserAuthController::class, 'ownerRegister']);
Route::post('/register/tenant/prime', [UserAuthController::class, 'tenantPrimeRegister']);
Route::post('/register/tenant/regular', [UserAuthController::class, 'tenantRegularRegister']);
Route::post('/login', [UserAuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [UserAuthController::class, 'logout']);
Route::post('/otp/verify', UserVerifyOtpController::class);
Route::get('/kost', [KostController::class, 'listKost']);
Route::get('/kost/{id}', [KostController::class, 'detailKost']);


// protected owner route
Route::group(['middleware' => ['auth:sanctum', 'checkRole:OWNER']], function () {
    Route::post('/owner/kost', [KostController::class, 'createKostByOwner']);
    Route::get('/owner/kost', [KostController::class, 'listKostByOwner']);
    Route::put('/owner/kost/{id}', [KostController::class, 'updateKostByOwner']);
    Route::delete('/owner/kost/{id}', [KostController::class, 'deleteKostByOwner']);
});

// protected tenant route
Route::group(['middleware' => ['auth:sanctum', 'checkRole:TENANT']], function () {
    Route::post('/kost/{id}/ask-room', [RoomAvailabilityController::class, 'askRoom']);
});