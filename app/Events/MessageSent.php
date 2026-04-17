<?php

namespace App\Events;

use App\Models\Mensajes;
use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

// "ShouldBroadcastNow" le dice a Laravel: Transmite esto por WebSockets 
class MessageSent implements ShouldBroadcastNow 
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message; 

    public function __construct(Mensajes $message)
    {
        $this->message = $message->load('user'); 
    }

    // ¿Por cuál canal de radio vamos a transmitir?
    public function broadcastOn(): array
    {
        
        return [
            new Channel('chat-condominio'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'nuevo-mensaje';
    }
}