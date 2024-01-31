<?php

use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Auth\UserVerifyOtpController;
use App\Http\Controllers\Kost\KostController;
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
    Route::post('/kost/owner', [KostController::class, 'createKostByOwner']);
    Route::get('/kost/owner', [KostController::class, 'listKostByOwner']);
});

