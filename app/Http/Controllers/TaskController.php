<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Get all tasks
    public function index()
    {
        return response()->json(Task::all());
    }

    // Store a new task
    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'status' => 'required|string',
        'priority' => 'required|string',
        'assigned_to' => 'required|exists:users,id',
        'due_date' => 'required|date',
    ]);

    $task = Task::create([
        'title' => $request->title,
        'description' => $request->description,
        'status' => $request->status,
        'priority' => $request->priority,
        'assigned_to' => $request->assigned_to,
        'created_by' => auth()->id(), // assuming user is authenticated
        'due_date' => $request->due_date,
    ]);

    return response()->json($task, 201);
}

    // Get a single task by ID
    public function show($id)
    {
        $task = Task::findOrFail($id);
        return response()->json($task);
    }

    // Update an existing task
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task->update($request->all());
        return response()->json($task);
    }

    // Delete a task
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(['message' => 'Task deleted']);
    }
}
