<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Employee;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index()
    {
        if(session('role') == 'HR') {
            $tasks = Task::all();
        } else {
            $tasks = Task::where('assigned_to', session('employee_id'))->get();
        }

        return view('tasks.index', compact('tasks'));
    }

    public function create(){
        $employees = Employee::all();
        return view('tasks.create', compact('employees'));
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'required|exists:employees,id',
            'due_date' => 'required|date',
            'status' => 'required|string|in:done,pending,on progress',
        ]);

        //jika berhasil maka akan menyimpan data ke database
        Task::create($validatedData);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function show(Task $task){
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task){
        $employees = Employee::all();
        return view('tasks.edit', compact('task', 'employees'));
    }

    public function update(Request $request, Task $task){
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'required|exists:employees,id',
            'due_date' => 'required|date',
            'status' => 'required|string|in:done,pending,on progress',
        ]);

        //jika berhasil maka akan menyimpan data ke database
        $task->update($validatedData);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }
    public function done(int $id){
        $task = Task::find($id);
        $task->update(['status' => 'done']);

        return redirect()->route('tasks.index')->with('success', 'Task marked as done.');
    }

    public function pending(int $id){
        $task = Task::find($id);
        $task->update(['status' => 'pending']);

        return redirect()->route('tasks.index')->with('success', 'Task marked as pending.');
    }

    public function destroy(Task $task){
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

}
