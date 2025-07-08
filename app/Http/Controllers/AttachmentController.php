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
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB
        ]);
        $uploadedFile = $request->file('file');
        $path = $uploadedFile->store('attachments');
        $attachment = $project->attachments()->create([
            'name' => $uploadedFile->getClientOriginalName(),
            'file' => $path,
            'type' => $uploadedFile->getClientMimeType(),
        ]);
        return response()->json(['success' => true, 'attachment' => $attachment]);
    }

    public function destroy(Project $project, Attachment $attachment)
    {
        if ($attachment->project_id !== $project->id) {
            abort(403);
        }
        Storage::delete($attachment->file);
        $attachment->delete();
        return response()->json(['success' => true]);
    }

    public function download(Project $project, Attachment $attachment)
    {
        if ($attachment->project_id !== $project->id) {
            abort(403);
        }
        return Storage::download($attachment->file, $attachment->name);
    }
}
