<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ClienteUserController extends Controller
{
    public function create()
    {
        $clientes = Client::all();
        return view('admin.users.create_cliente_user', compact('clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $client = Client::findOrFail($request->client_id);

        $user = User::create([
            'name' => $client->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_client' => true,
            'client_id' => $client->id, // Garante o vínculo correto
        ]);

        // (Opcional) Enviar e-mail para o cliente com os dados de acesso

        return redirect()->route('admin.users.index')->with('success', 'Usuário do cliente criado com sucesso!');
    }
} 