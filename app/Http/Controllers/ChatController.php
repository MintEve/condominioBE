<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mensaje;
use App\Events\NuevoMensajeEnviado;

class ChatController extends Controller
{
    public function enviarMensaje(Request $request)
    {
        // 1. Guardar en Postgres
        $nuevoMensaje = Mensaje::create([
            'remitente'    => $request->remitente,
            'destinatario' => $request->destinatario,
            'id_depaa'     => $request->id_depaa,
            'id_depab'     => $request->id_depab,
            'mensaje'      => $request->mensaje,
            'fecha'        => now(),
        ]);

        // 2. Disparar a Reverb
        broadcast(new NuevoMensajeEnviado($nuevoMensaje))->toOthers();

        return response()->json($nuevoMensaje);
    }
}