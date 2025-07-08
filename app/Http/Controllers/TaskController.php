<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tarefas = \App\Models\Task::where('user_id', auth()->id())->orderBy('due_date')->get();
        return view('tarefas.index', compact('tarefas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $projectId = $request->get('project_id');
        $projects = \App\Models\Project::where('user_id', auth()->id())->get();
        return view('tarefas.create', compact('projects', 'projectId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:todo,in_progress,paused,completed',
        ]);

        $validated['user_id'] = auth()->id();
        \Log::info('Criando tarefa', $validated);
        $task = \App\Models\Task::create($validated);
        \Log::info('Tarefa criada', $task->toArray());

        return redirect()
            ->route('projetos.show', $validated['project_id'])
            ->with('success', 'Tarefa criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $task = \App\Models\Task::findOrFail($id);
        return view('tarefas.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $task = \App\Models\Task::findOrFail($id);
        return view('tarefas.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $task = \App\Models\Task::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:todo,in_progress,paused,completed',
        ]);
        $task->update($validated);
        return redirect()->route('projetos.show', $task->project_id)->with('success', 'Tarefa atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateStatus(Request $request, $id)
    {
        $task = \App\Models\Task::findOrFail($id);
        $validated = $request->validate([
            'status' => 'required|in:todo,in_progress,paused,completed',
        ]);
        $task->status = $validated['status'];
        $task->save();
        return response()->json(['success' => true, 'status' => $task->status]);
    }
}
