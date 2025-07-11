<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;

class ProjetoController extends Controller
{
    public function index()
    {
        $client = Auth::user()->client;
        $projetos = Project::where('client_id', $client->id)->get();
        return view('cliente.projetos.index', compact('client', 'projetos'));
    }

    public function show($id)
    {
        $client = Auth::user()->client;
        $projeto = Project::where('id', $id)->where('client_id', $client->id)->firstOrFail();
        // Buscar mensagens do chat deste projeto
        $messages = \App\Models\ClientChat::where('client_id', $client->id)
            ->where('project_id', $projeto->id)
            ->orderBy('created_at', 'asc')
            ->with(['user', 'project', 'task'])
            ->get();
        $projectId = $projeto->id;
        return view('cliente.projetos.show', compact('client', 'projeto', 'messages', 'projectId'));
    }
} 