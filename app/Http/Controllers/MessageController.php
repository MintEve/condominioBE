<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Events\MessageSent;
use App\Models\Mensajes;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        return Mensajes::with('user')->latest()->take(50)->get()->reverse()->values();
    }

    public function store(Request $request)
    {
        $request->validate(['content' => 'required|string']);

        $message = $request->user()->messages()->create([
            'content' => $request->content
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'status' => '¡Mensaje en el aire!', 
            'message' => $message->load('user')
        ]);
    }
}