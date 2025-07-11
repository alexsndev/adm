<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class TarefaController extends Controller
{
    public function index()
    {
        $client = Auth::user();
        $tarefas = Task::whereHas('project', function($q) use ($client) {
            $q->where('client_id', $client->id);
        })->get();
        return view('cliente.tarefas.index', compact('client', 'tarefas'));
    }
} 