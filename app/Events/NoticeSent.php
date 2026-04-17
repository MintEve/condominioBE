<?php

namespace App\Events;
use App\Models\Notice;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NoticeSent implements ShouldBroadcastNow 
{
    use Dispatchable, SerializesModels;
    public $notice;

    public function __construct(Notice $notice) {
        $this->notice = $notice;
    }
    public function broadcastOn(): array {
        return [new Channel('avisos-condominio')]; // Canal exclusivo de avisos
    }
    public function broadcastAs(): string {
        return 'nuevo-aviso';
    }
}