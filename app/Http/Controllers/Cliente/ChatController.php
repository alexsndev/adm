<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\ClientChat;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $client = Auth::user();
        $projectId = $request->get('project_id');
        $taskId = $request->get('task_id');
        $query = ClientChat::where('client_id', $client->client_id ?? $client->id);
        if ($projectId) {
            $query->where('project_id', $projectId);
        }
        if ($taskId) {
            $query->where('task_id', $taskId);
        }
        $messages = $query->orderBy('created_at', 'asc')->get();
        return view('cliente.chat.index', compact('client', 'messages', 'projectId', 'taskId'));
    }

    public function getMessages(Request $request)
    {
        $client = Auth::user();
        $projectId = $request->get('project_id');
        $lastId = $request->get('last_id', 0);
        
        $query = ClientChat::where('client_id', $client->client_id ?? $client->id);
        
        if ($projectId) {
            $query->where('project_id', $projectId);
        }
        
        if ($lastId > 0) {
            $query->where('id', '>', $lastId);
        }
        
        $messages = $query->with('user:id,name')
                         ->orderBy('created_at', 'asc')
                         ->get()
                         ->map(function($msg) {
                             return [
                                 'id' => $msg->id,
                                 'message' => $msg->message,
                                 'user_name' => $msg->user->name,
                                 'created_at' => $msg->created_at->format('d/m/Y H:i:s')
                             ];
                         });
        
        return response()->json([
            'success' => true,
            'messages' => $messages
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);
        
        $projectId = $request->get('project_id');
        $taskId = $request->get('task_id');
        $clientId = null;
        
        if ($projectId) {
            $project = \App\Models\Project::find($projectId);
            $clientId = $project ? $project->client_id : null;
        }
        
        if (!$clientId) {
            $clientId = $user->client_id ?? $user->id;
        }
        
        $chat = ClientChat::create([
            'client_id' => $clientId,
            'user_id' => $user->id,
            'message' => $request->message,
            'project_id' => $projectId,
            'task_id' => $taskId,
        ]);
        
        // Responder com JSON para requisições AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $chat->message,
                'id' => $chat->id,
                'created_at' => $chat->created_at->format('d/m/Y H:i:s'),
                'user_name' => $user->name
            ]);
        }
        
        return redirect()->route('cliente.chat', array_filter([
            'project_id' => $projectId,
            'task_id' => $taskId,
        ]));
    }

    public function destroy($id)
    {
        $client = Auth::user();
        $mensagem = \App\Models\ClientChat::where('id', $id)
            ->where('user_id', $client->id)
            ->firstOrFail();
        $mensagem->delete();
        return back()->with('success', 'Mensagem excluída!');
    }

    public function destroyAll()
    {
        $client = Auth::user();
        \App\Models\ClientChat::where('user_id', $client->id)->delete();
        return back()->with('success', 'Todas as mensagens foram excluídas!');
    }
} 