<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee; // Make sure to import the model

class EmployeeController extends Controller
{
    public function index()
    {
        return Employee::all(); // Optional: list all employees
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
        ]);

        $employee = Employee::create($validated);

        return response()->json($employee, 201);
    }

    public function show(string $id)
    {
        return Employee::findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $employee = Employee::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:employees,email,' . $id,
        ]);

        $employee->update($validated);

        return response()->json($employee);
    }

    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return response()->json(['message' => 'Employee deleted successfully']);
    }
}
