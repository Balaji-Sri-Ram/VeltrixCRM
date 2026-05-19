<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;
use App\Models\Task;
use App\Models\ActivityLog;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalCustomers = Customer::count();
        $totalStaff = User::where('role', 'staff')->count();
        $totalTasks = Task::count();
        $completedTasks = Task::where('status', 'completed')->count();
        $recentActivities = ActivityLog::with('user')->latest()->take(5)->get();
        $recentCustomers = Customer::latest()->take(5)->get();

        $staffPerformance = User::where('role', 'staff')
            ->withCount(['customers', 'tasks'])
            ->get(['id', 'name']);

        return view('admin.dashboard', compact(
            'totalCustomers', 'totalStaff', 'totalTasks', 'completedTasks', 'recentActivities', 'recentCustomers', 'staffPerformance'
        ));
    }

    public function getStats()
    {
        $staffPerformance = User::where('role', 'staff')
            ->withCount(['customers', 'tasks'])
            ->get(['id', 'name']);

        return response()->json([
            'totalCustomers' => Customer::count(),
            'totalStaff' => User::where('role', 'staff')->count(),
            'totalTasks' => Task::count(),
            'completedTasks' => Task::where('status', 'completed')->count(),
            'recentCustomers' => Customer::latest()->take(5)->get(),
            'recentActivities' => ActivityLog::latest()->take(5)->get(),
            'staffPerformance' => $staffPerformance,
        ]);
    }

    public function staffIndex(Request $request)
    {
        $query = User::where('role', 'staff');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $staff = $query->latest()->get();
        return view('admin.staff.index', compact('staff'));
    }

    public function staffStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,staff',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $user = User::create($validated);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Staff Created',
            'description' => "Created staff member: {$user->name}",
        ]);

        return response()->json(['success' => true, 'user' => $user]);
    }

    public function staffUpdate(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,staff',
            'password' => 'nullable|string|min:8',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Staff Updated',
            'description' => "Updated staff member: {$user->name}",
        ]);

        return response()->json(['success' => true, 'user' => $user]);
    }

    public function staffDestroy(User $user)
    {
        $name = $user->name;
        $user->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Staff Deleted',
            'description' => "Deleted staff member: {$name}",
        ]);

        return response()->json(['success' => true]);
    }

    public function customerIndex(Request $request)
    {
        $query = Customer::with('assignedTo');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('staff_id')) {
            $query->where('assigned_to', $request->staff_id);
        }

        $customers = $query->latest()->get();
        $staff = User::where('role', 'staff')->get();
        return view('admin.customers.index', compact('customers', 'staff'));
    }

    public function taskIndex(Request $request)
    {
        $query = Task::with(['assignedTo', 'customer']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('staff_id')) {
            $query->where('assigned_to', $request->staff_id);
        }

        $tasks = $query->latest()->get();
        $staff = User::where('role', 'staff')->get();
        $customers = Customer::all();
        return view('admin.tasks.index', compact('tasks', 'staff', 'customers'));
    }
}
