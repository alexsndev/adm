<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectLinkController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $this->authorize('update', $project);
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|image|max:2048',
        ]);
        $data['project_id'] = $project->id;
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('project_links', 'public');
        }
        $link = ProjectLink::create($data);
        return response()->json(['success' => true, 'link' => $link]);
    }

    public function update(Request $request, Project $project, ProjectLink $link)
    {
        $this->authorize('update', $project);
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('image')) {
            if ($link->image) Storage::disk('public')->delete($link->image);
            $data['image'] = $request->file('image')->store('project_links', 'public');
        }
        $link->update($data);
        return response()->json(['success' => true, 'link' => $link]);
    }

    public function destroy(Project $project, ProjectLink $link)
    {
        $this->authorize('update', $project);
        if ($link->image) Storage::disk('public')->delete($link->image);
        $link->delete();
        return response()->json(['success' => true]);
    }
}
