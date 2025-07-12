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

    public function enviarMensagem(\Illuminate\Http\Request $request, $id)
    {
        $user = auth()->user();
        $projeto = \App\Models\Project::findOrFail($id);

        // Se for requisição AJAX para buscar mensagens novas
        if ($request->isMethod('GET') && $request->has('ajax') && $request->ajax == '1') {
            $lastId = $request->get('last_id', 0);
            $newMessages = \App\Models\ClientChat::where('project_id', $id)
                ->where('id', '>', $lastId)
                ->with('user')
                ->orderBy('created_at', 'asc')
                ->get()
                ->map(function($msg) {
                    return [
                        'id' => $msg->id,
                        'message' => $msg->message,
                        'user_name' => $msg->user->name,
                        'created_at' => $msg->created_at->format('d/m H:i')
                    ];
                });

            return response()->json([
                'messages' => $newMessages
            ]);
        }

        // Só cria mensagem se for POST
        if ($request->isMethod('POST')) {
            $client_id = $user->is_admin ? $projeto->client_id : ($user->client_id ?? $user->id);

            $chat = \App\Models\ClientChat::create([
                'client_id' => $client_id,
                'user_id' => $user->id,
                'project_id' => $projeto->id,
                'message' => $request->input('message'),
            ]);

            return response()->json([
                'success' => true,
                'id' => $chat->id,
                'message' => $chat->message,
                'user' => $chat->user->name,
                'created_at' => $chat->created_at->format('d/m/Y H:i'),
            ]);
        }

        // Se não for GET ajax nem POST, retorna erro
        return response()->json(['error' => 'Método não permitido'], 405);
    }

    // Método para admin - mesma lógica do ChatController do cliente, mas retorna JSON
    public function enviarMensagemAdmin(\Illuminate\Http\Request $request, $id)
    {
        $user = Auth::user();

        // Se for requisição GET para buscar mensagens novas via AJAX
        if ($request->isMethod('GET') && $request->has('ajax') && $request->ajax == '1') {
            $lastId = $request->get('last_id', 0);
            $newMessages = \App\Models\ClientChat::where('project_id', $id)
                ->where('id', '>', $lastId)
                ->with('user')
                ->orderBy('created_at', 'asc')
                ->get()
                ->map(function($msg) {
                    return [
                        'id' => $msg->id,
                        'message' => $msg->message,
                        'user_name' => $msg->user->name,
                        'created_at' => $msg->created_at->format('d/m H:i')
                    ];
                });

            return response()->json([
                'messages' => $newMessages
            ]);
        }

        // Só cria mensagem se for POST
        if ($request->isMethod('POST')) {
            $request->validate([
                'message' => 'required|string|max:2000',
            ]);
            
            $projectId = $id; // ID do projeto da URL
            $taskId = $request->get('task_id');
            $clientId = null;
            
            if ($projectId) {
                $project = \App\Models\Project::find($projectId);
                $clientId = $project ? $project->client_id : null;
            }
            
            if (!$clientId) {
                $clientId = $user->client_id ?? $user->id;
            }
            
            $chat = \App\Models\ClientChat::create([
                'client_id' => $clientId,
                'user_id' => $user->id,
                'message' => $request->message,
                'project_id' => $projectId,
                'task_id' => $taskId,
            ]);

            // Retorna JSON em vez de redirect (como o chat do cliente funciona)
            return response()->json([
                'success' => true,
                'id' => $chat->id,
                'message' => $chat->message,
                'user' => $chat->user->name,
                'created_at' => $chat->created_at->format('d/m H:i'),
            ]);
        }

        // Se não for GET ajax nem POST, retorna erro
        return response()->json(['error' => 'Método não permitido'], 405);
    }
} 