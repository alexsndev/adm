<?php

namespace App\Http\Controllers;

use App\Models\TaskCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskCategoryController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = TaskCategory::where('user_id', Auth::id())
            ->active()
            ->ordered()
            ->withCount(['householdTasks'])
            ->get();

        // Adiciona os counts personalizados manualmente
        foreach ($categories as $category) {
            $category->active_tasks_count = $category->active_tasks_count ?? $category->activeTasksCount;
            $category->completed_tasks_count = $category->completed_tasks_count ?? $category->completedTasksCount;
        }

        return view('task-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('task-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:50',
            'icon' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $category = TaskCategory::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'color' => $request->color,
            'icon' => $request->icon,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active', true),
            'order' => TaskCategory::where('user_id', Auth::id())->max('order') + 1,
        ]);

        return redirect()->route('task-categories.index')
            ->with('success', 'Categoria criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskCategory $taskCategory)
    {
        $this->authorize('view', $taskCategory);

        $tasks = $taskCategory->householdTasks()
            ->with('user')
            ->orderBy('due_date')
            ->orderBy('priority')
            ->get();

        return view('task-categories.show', compact('taskCategory', 'tasks'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskCategory $taskCategory)
    {
        $this->authorize('update', $taskCategory);

        return view('task-categories.edit', compact('taskCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TaskCategory $taskCategory)
    {
        $this->authorize('update', $taskCategory);

        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:50',
            'icon' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $taskCategory->update([
            'name' => $request->name,
            'color' => $request->color,
            'icon' => $request->icon,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('task-categories.index')
            ->with('success', 'Categoria atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskCategory $taskCategory)
    {
        $this->authorize('delete', $taskCategory);

        // Verificar se há tarefas associadas
        if ($taskCategory->householdTasks()->count() > 0) {
            return back()->with('error', 'Não é possível excluir uma categoria que possui tarefas associadas.');
        }

        $taskCategory->delete();

        return redirect()->route('task-categories.index')
            ->with('success', 'Categoria excluída com sucesso!');
    }
}
