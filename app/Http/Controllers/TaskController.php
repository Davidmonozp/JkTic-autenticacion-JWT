<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function addTask(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:5|max:100',
            'description' => 'required|string|min:10|max:180',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        Task::create([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
        ]);
        return response()->json(['message' => 'Tarea agregada exitosamente'], 201);
    }

    public function getTasks()
    {
        $tasks = Task::all();
        if ($tasks->isEmpty()) {
            return response()->json(['message' => 'No hay tareas'], 404);
        }
        return response()->json([$tasks], 200);
    }

    public function getTaskById($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Tarea no encontrada'], 404);
        }
        return response()->json([$task], 200);
    }

    public function updateTaskById(Request $request, $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Tarea no encontrada'], 404);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|min:5|max:100',
            'description' => 'sometimes|string|min:10|max:180',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        if ($request->has('name')) {
            $task->name = $request->name;
        }
        if ($request->has('description')) {
            $task->description = $request->description;
        }
        $task->update();
        return response()->json(['message' => 'Tarea actualizada exitosamente'], 200);
    }

    public function deleteTaskById($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Tarea no encontrada'], 404);
        }
        $task->delete();
        return response()->json(['message' => 'Tarea eliminada exitosamente'], 200);
    }
}
