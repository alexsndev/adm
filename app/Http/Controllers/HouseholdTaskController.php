<?php

namespace App\Http\Controllers;

use App\Models\HouseholdTask;
use App\Models\TaskCategory;
use App\Models\HouseholdTaskCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\HouseholdTaskPhoto;
use Illuminate\Support\Facades\Storage;

class HouseholdTaskController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = HouseholdTask::where('user_id', Auth::id())
            ->with(['taskCategory', 'user']);

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        if ($request->filled('category_id')) {
            $query->where('task_category_id', $request->category_id);
        }

        if ($request->filled('due_date')) {
            $query->where('due_date', $request->due_date);
        }

        // Ordenação
        $sortBy = $request->get('sort_by', 'due_date');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $tasks = $query->paginate(20);
        $categories = HouseholdTaskCategory::where('user_id', Auth::id())->active()->ordered()->get();

        return view('household-tasks.index', compact('tasks', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = TaskCategory::all();
        return view('household-tasks.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'task_category_id' => 'required|exists:task_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'priority' => 'required|in:low,medium,high,urgent',
            'assigned_to' => 'required|in:alexandre,liza,both',
            'frequency' => 'required|in:once,daily,weekly,monthly',
            'due_date' => 'nullable|date',
            'due_time' => 'nullable|date_format:H:i',
            'estimated_minutes' => 'nullable|integer|min:1',
            'notes' => 'nullable|string',
            // 'is_recurring' => 'sometimes|boolean',
        ]);

        $task = HouseholdTask::create([
            'user_id' => Auth::id(),
            'task_category_id' => $request->task_category_id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'priority' => $request->priority,
            'assigned_to' => $request->assigned_to,
            'frequency' => $request->frequency,
            'due_date' => $request->due_date,
            'due_time' => $request->due_time,
            'estimated_minutes' => $request->estimated_minutes,
            'notes' => $request->notes,
            'is_recurring' => $request->boolean('is_recurring', false),
            'order' => HouseholdTask::where('user_id', Auth::id())->max('order') + 1,
        ]);

        return redirect()->route('household-tasks.index')
            ->with('success', 'Tarefa criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(HouseholdTask $householdTask)
    {
        $this->authorize('view', $householdTask);

        return view('household-tasks.show', compact('householdTask'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HouseholdTask $householdTask)
    {
        $this->authorize('update', $householdTask);

        $categories = TaskCategory::all();
        return view('household-tasks.edit', compact('householdTask', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HouseholdTask $householdTask)
    {
        $this->authorize('update', $householdTask);

        $request->validate([
            'task_category_id' => 'required|exists:task_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'priority' => 'required|in:low,medium,high,urgent',
            'assigned_to' => 'required|in:alexandre,liza,both',
            'frequency' => 'required|in:once,daily,weekly,monthly',
            'due_date' => 'nullable|date',
            'due_time' => 'nullable|date_format:H:i',
            'estimated_minutes' => 'nullable|integer|min:1',
            'actual_minutes' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
            // 'is_recurring' => 'sometimes|boolean',
        ]);

        $data = [
            'task_category_id' => $request->task_category_id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'priority' => $request->priority,
            'assigned_to' => $request->assigned_to,
            'frequency' => $request->frequency,
            'due_date' => $request->due_date,
            'due_time' => $request->due_time,
            'estimated_minutes' => $request->estimated_minutes,
            'actual_minutes' => $request->actual_minutes,
            'notes' => $request->notes,
            'is_recurring' => $request->boolean('is_recurring', false),
        ];

        // Se a tarefa foi marcada como concluída, definir a data de conclusão
        if ($request->status === 'completed' && $householdTask->status !== 'completed') {
            $data['completed_date'] = Carbon::today();
        }

        $householdTask->update($data);

        return redirect()->route('household-tasks.index')
            ->with('success', 'Tarefa atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HouseholdTask $householdTask)
    {
        $this->authorize('delete', $householdTask);

        $householdTask->delete();

        return redirect()->route('household-tasks.index')
            ->with('success', 'Tarefa excluída com sucesso!');
    }

    /**
     * Marcar tarefa como concluída
     */
    public function complete(HouseholdTask $householdTask)
    {
        $this->authorize('update', $householdTask);

        // Se a tarefa está em progresso, calcular e salvar o tempo final
        if ($householdTask->status === 'in_progress' && $householdTask->started_at) {
            $now = Carbon::now();
            $started = Carbon::parse($householdTask->started_at);
            $elapsedMinutes = max(0, $now->diffInMinutes($started)); // nunca negativo
            // Adicionar o tempo decorrido ao tempo já registrado
            $householdTask->actual_minutes += $elapsedMinutes;
            // Limpar os campos de tempo ativo
            $householdTask->started_at = null;
            $householdTask->paused_at = null;
        }

        $householdTask->update([
            'status' => 'completed',
            'completed_date' => Carbon::today(),
        ]);

        return back()->with('success', 'Tarefa marcada como concluída! Tempo total: ' . $householdTask->actual_minutes . ' minutos');
    }

    /**
     * Retomar tarefa concluída
     */
    public function reopen(HouseholdTask $householdTask)
    {
        $this->authorize('update', $householdTask);

        $householdTask->reopen_count = ($householdTask->reopen_count ?? 0) + 1;
        $householdTask->update([
            'status' => 'in_progress',
            'completed_date' => null,
            'started_at' => Carbon::now(),
            'paused_at' => null,
            'reopen_count' => $householdTask->reopen_count
        ]);

        return back()->with('success', 'Tarefa retomada! O cronômetro foi iniciado automaticamente.');
    }

    /**
     * Marcar tarefa como em progresso
     */
    public function start(HouseholdTask $householdTask)
    {
        $this->authorize('update', $householdTask);

        $householdTask->update([
            'status' => 'in_progress',
            'started_at' => Carbon::now(),
            'paused_at' => null
        ]);

        return back()->with('success', 'Tarefa iniciada!');
    }

    /**
     * Dashboard de tarefas domésticas
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Tarefas de hoje
        $todayTasks = HouseholdTask::where('user_id', $user->id)
            ->today()
            ->with('taskCategory')
            ->orderBy('priority')
            ->orderBy('due_time')
            ->get();

        // Tarefas atrasadas
        $overdueTasks = HouseholdTask::where('user_id', $user->id)
            ->overdue()
            ->with('taskCategory')
            ->orderBy('due_date')
            ->orderBy('priority')
            ->get();

        // Tarefas desta semana
        $weekTasks = HouseholdTask::where('user_id', $user->id)
            ->thisWeek()
            ->with('taskCategory')
            ->orderBy('due_date')
            ->orderBy('priority')
            ->get();

        // Estatísticas
        $stats = [
            'total' => HouseholdTask::where('user_id', $user->id)->count(),
            'completed' => HouseholdTask::where('user_id', $user->id)->completed()->count(),
            'pending' => HouseholdTask::where('user_id', $user->id)->where('status', 'pending')->count(),
            'in_progress' => HouseholdTask::where('user_id', $user->id)->where('status', 'in_progress')->count(),
        ];

        // Estatísticas de tempo e atividade
        $timeStats = [
            'total_minutes' => HouseholdTask::where('user_id', $user->id)->sum('actual_minutes'),
            'total_hours' => round(HouseholdTask::where('user_id', $user->id)->sum('actual_minutes') / 60, 1),
            'tasks_with_time' => HouseholdTask::where('user_id', $user->id)->where('actual_minutes', '>', 0)->count(),
            'average_time_per_task' => HouseholdTask::where('user_id', $user->id)->where('actual_minutes', '>', 0)->avg('actual_minutes'),
            'tasks_paused' => HouseholdTask::where('user_id', $user->id)->whereNotNull('paused_at')->count(),
            'tasks_reopened' => HouseholdTask::where('user_id', $user->id)->sum('reopen_count'),
        ];

        return view('household-tasks.dashboard', compact(
            'todayTasks',
            'overdueTasks', 
            'weekTasks',
            'stats',
            'timeStats'
        ));
    }

    /**
     * Pausar tarefa doméstica
     */
    public function pause(HouseholdTask $householdTask)
    {
        $this->authorize('update', $householdTask);
        if ($householdTask->status === 'in_progress' && !$householdTask->paused_at) {
            // Calcula tempo parcial
            $now = Carbon::now();
            $started = $householdTask->started_at ? Carbon::parse($householdTask->started_at) : $now;
            $minutos = $now->diffInMinutes($started);
            $householdTask->actual_minutes += $minutos;
            $householdTask->paused_at = $now;
            $householdTask->status = 'in_progress'; // Mantém status, mas indica que está pausada
            $householdTask->save();
        }
        return redirect()->back();
    }

    /**
     * Retomar tarefa doméstica (despausar)
     */
    public function resume(HouseholdTask $householdTask)
    {
        $this->authorize('update', $householdTask);
        if ($householdTask->status === 'in_progress' && $householdTask->paused_at) {
            $householdTask->started_at = Carbon::now();
            $householdTask->paused_at = null;
            $householdTask->save();
        }
        return redirect()->back();
    }

    /**
     * Voltar tarefa para pendente
     */
    public function toPending(HouseholdTask $householdTask)
    {
        $this->authorize('update', $householdTask);
        $householdTask->status = 'pending';
        $householdTask->started_at = null;
        $householdTask->paused_at = null;
        $householdTask->actual_minutes = 0;
        $householdTask->save();
        return redirect()->back();
    }

    /**
     * Reiniciar tempo da tarefa
     */
    public function resetTimer(HouseholdTask $householdTask)
    {
        $this->authorize('update', $householdTask);
        
        try {
            $householdTask->update([
                'actual_minutes' => 0,
                'started_at' => null,
                'paused_at' => null,
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Tempo reiniciado com sucesso!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao reiniciar o tempo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Atualizar tempo em tempo real
     */
    public function updateTime(Request $request, HouseholdTask $householdTask)
    {
        $this->authorize('update', $householdTask);
        
        try {
            $request->validate([
                'actual_minutes' => 'required|integer|min:0'
            ]);
            
            $householdTask->update([
                'actual_minutes' => $request->actual_minutes
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Tempo atualizado com sucesso!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar o tempo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload de fotos para a tarefa doméstica (múltiplos arquivos)
     */
    public function uploadPhoto(Request $request, HouseholdTask $householdTask)
    {
        $this->authorize('update', $householdTask);

        $request->validate([
            'photos' => 'required|array',
            'photos.*' => 'image|max:5120', // 5MB por foto
        ], [
            'photos.required' => 'Selecione pelo menos uma foto.',
            'photos.*.image' => 'Cada arquivo deve ser uma imagem.',
            'photos.*.max' => 'Cada foto deve ter no máximo 5MB.',
        ]);

        $existingCount = $householdTask->photos()->count();
        $newCount = count($request->file('photos', []));
        if ($existingCount + $newCount > 5) {
            return back()->withErrors(['photos' => 'Limite de 5 fotos por tarefa. Você já enviou ' . $existingCount . '.']);
        }

        foreach ($request->file('photos', []) as $photo) {
            $path = $photo->store('household_tasks/' . $householdTask->id, 'public');
            $householdTask->photos()->create([
                'photo' => $path,
            ]);
        }

        return back()->with('success', 'Foto(s) enviada(s) com sucesso!');
    }

    /**
     * Remover foto da tarefa doméstica
     */
    public function deletePhoto(HouseholdTask $householdTask, HouseholdTaskPhoto $photo)
    {
        $this->authorize('update', $householdTask);
        if ($photo->household_task_id !== $householdTask->id) {
            abort(403);
        }
        Storage::disk('public')->delete($photo->photo);
        $photo->delete();
        return back()->with('success', 'Foto removida com sucesso!');
    }
}
