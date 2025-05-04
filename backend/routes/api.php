<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TravelRequestController;

//Authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Routes to TravelRequests
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/travel-requests', [TravelRequestController::class, 'index']);
    Route::post('/travel-requests', [TravelRequestController::class, 'create']);
    Route::get('/travel-requests/{id}', [TravelRequestController::class, 'show']);
    Route::put('/travel-requests/{id}', [TravelRequestController::class, 'update']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'getUser']);
    
    
    Route::patch('/travel-requests/{id}/status', [TravelRequestController::class, 'updateStatus']);
});
