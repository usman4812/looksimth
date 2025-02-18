<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ServicesController;
use App\Http\Controllers\Api\LoginRegisterController;
use App\Http\Controllers\Api\ForgotPasswordController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->group( function () {
    Route::post('/logout', [LoginRegisterController::class, 'logout']);
    Route::get('/profile',[ProfileController::class,'show']);
    Route::post('/profile-update',[ProfileController::class,'update']);
    Route::post('/user-services',[ServicesController::class,'addFavouritService']);
    Route::get('/get-user-services',[ServicesController::class,'getUserFavouritServices']);
    Route::resource('/booking',BookingController::class);
    Route::post('/cancel-booking/{id}',[BookingController::class,'cancelBooking']);
    // update status of booking job
    Route::post('booking-status-update/{id}',[BookingController::class,'bookingStatusUpdate']);
    Route::post('/online-status-update', [BookingController::class,'onlineWorkerStatusUpdate']);
    Route::post('/get-worker-jobs',[BookingController::class,'getWorkerJob']);






});
Route::post('/register',[LoginRegisterController::class,'register']);
Route::post('/login',[LoginRegisterController::class,'login']);
Route::post('forget-password', [ForgotPasswordController::class, 'forgetPassword']);
Route::post('reset-password', [ForgotPasswordController::class, 'resetPassword']);
Route::resource('/categories', CategoryController::class);
Route::resource('/services', ServicesController::class);
