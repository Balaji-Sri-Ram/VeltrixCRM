<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\ActivityLog;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'required|exists:users,id',
            'customer_id' => 'nullable|exists:customers,id',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
        ]);

        $task = Task::create($validated);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Task Created',
            'description' => "Created task: {$task->title}",
        ]);

        // Notify All Other Users
        $others = User::where('id', '!=', Auth::id())->get();
        foreach ($others as $other) {
            Notification::create([
                'user_id' => $other->id,
                'title' => __('messages.notif_task_added_title'),
                'message' => __('messages.notif_task_added_message', [
                    'name' => $task->title,
                    'user' => Auth::user()->name,
                    'role' => Auth::user()->role
                ]),
                'is_read' => false,
            ]);
        }

        return response()->json(['success' => true, 'task' => $task]);
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'required|exists:users,id',
            'customer_id' => 'nullable|exists:customers,id',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
        ]);

        $task->update($validated);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Task Updated',
            'description' => "Updated task: {$task->title}",
        ]);

        return response()->json(['success' => true, 'task' => $task]);
    }

    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $task->update(['status' => $request->status]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Task Updated',
            'description' => "Updated task status: {$task->title} to {$request->status}",
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy(Task $task)
    {
        $title = $task->title;
        $task->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Task Deleted',
            'description' => "Deleted task: {$title}",
        ]);

        // Notify All Other Users
        $others = User::where('id', '!=', Auth::id())->get();
        foreach ($others as $other) {
            Notification::create([
                'user_id' => $other->id,
                'title' => __('messages.notif_task_deleted_title'),
                'message' => __('messages.notif_task_deleted_message', [
                    'name' => $title,
                    'user' => Auth::user()->name,
                    'role' => Auth::user()->role
                ]),
                'is_read' => false,
            ]);
        }

        return response()->json(['success' => true]);
    }
}
