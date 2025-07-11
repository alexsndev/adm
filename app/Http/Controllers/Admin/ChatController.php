<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\ClientChat;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        // Lista de clientes que já enviaram mensagens
        $clientes = Client::whereHas('chats')->with('chats')->get();
        return view('admin.chats.index', compact('clientes'));
    }

    public function show($clientId)
    {
        $client = Client::findOrFail($clientId);
        $messages = ClientChat::where('client_id', $client->id)
            ->orderBy('created_at', 'asc')
            ->get();
        return view('admin.chats.show', compact('client', 'messages'));
    }

    public function store(Request $request, $clientId)
    {
        $client = Client::findOrFail($clientId);
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);
        ClientChat::create([
            'client_id' => $client->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);
        return redirect()->route('admin.chats.show', $client->id);
    }
} 