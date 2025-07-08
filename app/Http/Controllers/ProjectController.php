<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = Project::with(['client', 'tasks', 'timeEntries'])
            ->where('user_id', $user->id);
        
        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('client', function($clientQuery) use ($search) {
                      $clientQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        
        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }
        
        $projects = $query->orderBy('created_at', 'desc')->paginate(12);
        
        // Dados para filtros
        $clients = Client::where('user_id', $user->id)->active()->orderBy('name')->get();
        
        return view('projetos.index', compact('projects', 'clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $clients = Client::where('user_id', $user->id)->active()->orderBy('name')->get();
        
        return view('projetos.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'client_id' => 'required|exists:clients,id',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:planning,in_progress,on_hold,completed,cancelled',
            'priority' => 'required|in:low,medium,high,urgent',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date|after_or_equal:start_date',
            'budget' => 'nullable|numeric|min:0',
            'hourly_rate' => 'nullable|numeric|min:0',
            'estimated_hours' => 'nullable|integer|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);
        
        // Verificar se o cliente pertence ao usuário
        $client = Client::where('id', $validated['client_id'])->where('user_id', $user->id)->first();
        if (!$client) {
            return back()->withErrors(['client_id' => 'Cliente inválido.']);
        }
        
        $validated['user_id'] = $user->id;
        $project = Project::create($validated);
        
        return redirect()->route('projetos.index')
            ->with('success', 'Projeto criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $this->authorize('view', $project);
        $project->load(['client', 'tasks', 'timeEntries']);
        return view('projetos.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $this->authorize('update', $project);
        $user = Auth::user();
        $clients = Client::where('user_id', $user->id)->active()->orderBy('name')->get();
        return view('projetos.edit', compact('project', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'client_id' => 'required|exists:clients,id',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:planning,in_progress,on_hold,completed,cancelled',
            'priority' => 'required|in:low,medium,high,urgent',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date|after_or_equal:start_date',
            'budget' => 'nullable|numeric|min:0',
            'hourly_rate' => 'nullable|numeric|min:0',
            'estimated_hours' => 'nullable|integer|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);
        
        // Verificar se o cliente pertence ao usuário
        $client = Client::where('id', $validated['client_id'])->where('user_id', $user->id)->first();
        if (!$client) {
            return back()->withErrors(['client_id' => 'Cliente inválido.']);
        }
        
        // Se o status for completed, definir completed_date
        if ($validated['status'] === 'completed' && $project->status !== 'completed') {
            $validated['completed_date'] = now();
        }
        
        $project->update($validated);
        
        return redirect()->route('projetos.index')
            ->with('success', 'Projeto atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        $user = Auth::user();
        
        $project->delete();
        
        return redirect()->route('projetos.index')
            ->with('success', 'Projeto excluído com sucesso!');
    }

    public function uploadAttachment(Request $request, Project $project)
    {
        $request->validate([
            'file' => 'required|file|max:10240',
        ]);
        $media = $project->addMediaFromRequest('file')->toMediaCollection('attachments');
        return response()->json([
            'success' => true,
            'media' => [
                'id' => $media->id,
                'name' => $media->name,
                'file_name' => $media->file_name,
                'mime_type' => $media->mime_type,
                'url' => $media->getUrl(),
                'preview' => $media->getUrl('thumb')
            ]
        ]);
    }

    public function deleteAttachment($mediaId)
    {
        $media = \Spatie\MediaLibrary\MediaCollections\Models\Media::findOrFail($mediaId);
        $project = Project::findOrFail($media->model_id);
        
        $this->authorize('update', $project);
        
        $media->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Anexo excluído com sucesso!'
        ]);
    }

    public function startTimer(Project $project)
    {
        $this->authorize('update', $project);
        $project->update([
            'status' => 'in_progress',
            'started_at' => Carbon::now(),
            'paused_at' => null
        ]);
        return back()->with('success', 'Projeto iniciado!');
    }

    public function pauseTimer(Project $project)
    {
        $this->authorize('update', $project);
        if ($project->status === 'in_progress' && !$project->paused_at) {
            $now = Carbon::now();
            $started = $project->started_at ? Carbon::parse($project->started_at) : $now;
            $minutos = $now->diffInMinutes($started);
            $project->actual_minutes += $minutos;
            $project->paused_at = $now;
            $project->save();
        }
        return response()->json(['success' => true]);
    }

    public function resumeTimer(Project $project)
    {
        $this->authorize('update', $project);
        if ($project->status === 'in_progress' && $project->paused_at) {
            $project->started_at = Carbon::now();
            $project->paused_at = null;
            $project->save();
        }
        return response()->json(['success' => true]);
    }

    public function resetTimer(Project $project)
    {
        $this->authorize('update', $project);
        $project->update([
            'actual_minutes' => 0,
            'started_at' => null,
            'paused_at' => null,
        ]);
        return response()->json(['success' => true]);
    }

    public function updateTime(Request $request, Project $project)
    {
        $this->authorize('update', $project);
        $request->validate([
            'actual_minutes' => 'required|integer|min:0'
        ]);
        $project->update([
            'actual_minutes' => $request->actual_minutes
        ]);
        return response()->json(['success' => true]);
    }

    public function updateNotes(Request $request, Project $project)
    {
        $this->authorize('update', $project);
        $request->validate([
            'notes' => 'nullable|string|max:2000',
        ]);
        $project->notes = $request->notes;
        $project->save();
        return response()->json(['success' => true]);
    }
}
