<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\MessageController; 

// ruta para iniciar sesión  
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas (solo con Token de Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/notices', [\App\Http\Controllers\NoticeController::class, 'index']);
    Route::post('/notices', [\App\Http\Controllers\NoticeController::class, 'store']);
    
    // ruta de chat residentes
    Route::get('/messages', [MessageController::class, 'index']); // leer historial
    Route::post('/messages', [MessageController::class, 'store']); // enviar mensaje
});
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);

Route::post('/reset-password', [AuthController::class, 'resetPassword']);