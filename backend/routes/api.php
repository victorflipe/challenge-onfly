<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TravelRequestController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Definindo rotas para a API de pedidos de viagem
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/travel-requests', [TravelRequestController::class, 'index']);
    Route::post('/travel-requests', [TravelRequestController::class, 'store']);
    Route::get('/travel-requests/{id}', [TravelRequestController::class, 'show']);
    Route::patch('/travel-requests/{id}/status', [TravelRequestController::class, 'updateStatus']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'getUser']);
});
