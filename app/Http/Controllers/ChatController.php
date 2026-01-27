<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mensaje;
use App\Events\NuevoMensajeEnviado;

class ChatController extends Controller
{
    public function enviarMensaje(Request $request)
    {
        // validamos que el mensaje no venga vacío
        $request->validate([
            'mensaje' => 'required|string',
            'id_depab' => 'required|integer'
        ]);

        // guardamos el mensaje en la base de datos 
        
       $nuevoMensaje = Mensaje::create([
            'remitente'    => $request->remitente,
            'destinatario' => $request->destinatario,
            'id_depaa'     => $request->id_depaa, 
            'id_depab'     => $request->id_depab,
            'mensaje'      => $request->mensaje,
            'fecha'        => now(),
        ]);

        // dispara el evento para que reverb lo anuncie
        broadcast(new NuevoMensajeEnviado($nuevoMensaje))->toOthers();

        return response()->json([
            'status' => 'Mensaje enviado y transmitido',
            'datos'  => $nuevoMensaje
        ]);
    }
}