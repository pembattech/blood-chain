<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\UserController;
use App\Http\Controllers\API\V1\DonorController;
use App\Http\Controllers\API\V1\BloodRequestController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    // Auth routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        // User profile
        Route::get('/user/profile-status', [UserController::class, 'profileStatus']);

        // Donors resource routes
        Route::apiResource('donors', DonorController::class);

        // Blood Requests resource routes
        Route::apiResource('blood-requests', BloodRequestController::class);
        

    });
});
