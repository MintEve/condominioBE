<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\NotificacionProcesada;

class NotificacionController extends Controller
{
    // Esta función servirá para probar cualquier tipo de notificación
    public function enviarAlerta(Request $request)
    {
        // Validamos qué tipo de notificación es
        $request->validate([
            'tipo' => 'required|string', // multa, asamblea, pago, mensaje
            'titulo' => 'required|string',
            'id_referencia' => 'required|integer'
        ]);

        // Disparamos el evento de WebSocket
        broadcast(new NotificacionProcesada(
            $request->tipo, 
            $request->titulo, 
            $request->id_referencia
        ));

        return response()->json(['status' => 'Notificación enviada con éxito']);
    }
}