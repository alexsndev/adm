<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function store(Request $request, Project $project)
    {
        // Verificar se o usuário tem permissão para acessar este projeto
        if ($project->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Acesso negado'], 403);
        }
        
        $request->validate([
            'arquivo' => 'required|file|max:10240', // 10MB
            'descricao' => 'nullable|string|max:255',
        ]);
        
        $uploadedFile = $request->file('arquivo');
        $path = $uploadedFile->store('attachments', 'public');
        
        $attachment = $project->attachments()->create([
            'name' => $uploadedFile->getClientOriginalName(),
            'file' => $path,
            'type' => $uploadedFile->getClientMimeType(),
            'descricao' => $request->descricao,
        ]);
        
        return response()->json([
            'success' => true, 
            'attachment' => [
                'id' => $attachment->id,
                'name' => $attachment->name,
                'descricao' => $attachment->descricao,
                'file' => $attachment->file,
                'created_at' => $attachment->created_at->format('d/m/Y H:i'),
                'url' => Storage::url($attachment->file)
            ]
        ]);
    }

    public function destroy(Project $project, Attachment $attachment)
    {
        // Verificar se o usuário tem permissão para acessar este projeto
        if ($project->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Acesso negado'], 403);
        }
        
        if ($attachment->project_id !== $project->id) {
            return response()->json(['success' => false, 'message' => 'Anexo não encontrado'], 404);
        }
        
        Storage::disk('public')->delete($attachment->file);
        $attachment->delete();
        return response()->json(['success' => true]);
    }

    public function download(Project $project, Attachment $attachment)
    {
        if ($attachment->project_id !== $project->id) {
            abort(403);
        }
        return Storage::disk('public')->download($attachment->file, $attachment->name);
    }
}
