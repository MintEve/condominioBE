<?php

namespace App\Http\Controllers;
use App\Models\Notice;
use App\Events\NoticeSent;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index() {
        return Notice::latest()->take(10)->get();
    }

    public function store(Request $request) {
        // Solo el admin puede mandar avisos
        if ($request->user()->role !== 'admin') {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $request->validate(['mensaje' => 'required|string']);
        $notice = Notice::create(['mensaje' => $request->mensaje]);

        broadcast(new NoticeSent($notice))->toOthers();

        return response()->json($notice);
    }
}
