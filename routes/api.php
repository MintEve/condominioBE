<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\AuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/enviar-mensaje', [ChatController::class, 'enviarMensaje']);

Route::post('/notificar', [NotificacionController::class, 'enviarAlerta']);

// Agrupamos las rutas que requieren que el usuario haya iniciado sesión
Route::middleware('auth:sanctum')->group(function () {
    
    // Ruta para cambiar la contraseña
    Route::post('/cambiar-password', [AuthController::class, 'cambiarPassword']);
    
});