<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return Project::with(['task', 'employee', 'creator'])->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'assigned_to' => 'required|exists:employees,id',
            'created_by' => 'required|exists:users,id',
        ]);

        $project = Project::create($validated);

        return response()->json($project->load(['task', 'employee', 'creator']), 201);
    }

    public function show(string $id)
    {
        return Project::with(['task', 'employee', 'creator'])->findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $project = Project::findOrFail($id);

        $validated = $request->validate([
            'task_id' => 'sometimes|required|exists:tasks,id',
            'assigned_to' => 'sometimes|required|exists:employees,id',
            'created_by' => 'sometimes|required|exists:users,id',
        ]);

        $project->update($validated);

        return response()->json($project->load(['task', 'employee', 'creator']));
    }

    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return response()->json(['message' => 'Project deleted successfully']);
    }
}
