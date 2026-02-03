<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificacionProcesada implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $datos;

    public function __construct($tipo, $titulo, $id_referencia)
    {
        // Guardamos qué pasó y a dónde debe ir el usuario al hacer clic
        $this->datos = [
            'tipo' => $tipo, // 'multa', 'pago', 'asamblea', 'mensaje'
            'titulo' => $titulo,
            'id_referencia' => $id_referencia,
            'fecha' => now()->format('H:i')
        ];
    }

    public function broadcastOn(): array
    {
        // Canal global para notificaciones del condominio
        return [new Channel('notificaciones-globales')];
    }

    public function broadcastAs()
    {
        return 'NuevaNotificacion';
    }
}