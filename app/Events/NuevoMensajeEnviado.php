<?php

namespace App\Events;

use App\Models\Mensaje;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast; // <-- aquiii (clave)
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

// "ShouldBroadcast" manda el evento por
// el puerto de websockets (Reverb)".
class NuevoMensajeEnviado implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    //  variable pública será lo que React reciba (el "paquete")
    public $mensaje;

    public function __construct(Mensaje $mensaje)
    {
        // recibimos el mensaje que se guardó en la BD
        $this->mensaje = $mensaje;
    }

   // usare un canal basado en el ID del departamento.
    public function broadcastOn(): array
    {
        return [
            new Channel('chat-depa-' . $this->mensaje->id_depaB),
        ];
    }

    // nombre al evento para que React lo identifique fácilmente
    public function broadcastAs()
    {
        return 'NuevoMensaje';
    }
}