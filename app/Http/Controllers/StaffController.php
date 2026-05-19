<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\Task;
use App\Models\ActivityLog;

class StaffController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $assignedCustomers = Customer::where('assigned_to', $user->id)->count();
        $pendingTasks = Task::where('assigned_to', $user->id)->where('status', '!=', 'completed')->count();
        $completedTasks = Task::where('assigned_to', $user->id)->where('status', 'completed')->count();
        $recentCustomers = Customer::where('assigned_to', $user->id)->latest()->take(5)->get();

        return view('staff.dashboard', compact(
            'assignedCustomers', 'pendingTasks', 'completedTasks', 'recentCustomers'
        ));
    }

    public function getStats()
    {
        $user = Auth::user();
        return response()->json([
            'assignedCustomers' => Customer::where('assigned_to', $user->id)->count(),
            'pendingTasks' => Task::where('assigned_to', $user->id)->where('status', '!=', 'completed')->count(),
            'completedTasks' => Task::where('assigned_to', $user->id)->where('status', 'completed')->count(),
            'recentCustomers' => Customer::where('assigned_to', $user->id)->latest()->take(5)->get(),
        ]);
    }

    public function customerIndex(Request $request)
    {
        $user = Auth::user();
        $query = Customer::where('assigned_to', $user->id);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $customers = $query->latest()->get();
        return view('staff.customers.index', compact('customers'));
    }

    public function taskIndex(Request $request)
    {
        $user = Auth::user();
        $query = Task::with('customer')->where('assigned_to', $user->id);

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

        $tasks = $query->latest()->get();
        $customers = Customer::where('assigned_to', $user->id)->get();
        return view('staff.tasks.index', compact('tasks', 'customers'));
    }

    public function analyticsIndex()
    {
        return view('staff.analytics.index');
    }

    public function analyticsData()
    {
        $user = Auth::user();
        $customerStats = [
            'lead' => Customer::where('assigned_to', $user->id)->where('status', 'lead')->count(),
            'active' => Customer::where('assigned_to', $user->id)->where('status', 'active')->count(),
            'inactive' => Customer::where('assigned_to', $user->id)->where('status', 'inactive')->count(),
        ];

        $taskStats = [
            'pending' => Task::where('assigned_to', $user->id)->where('status', 'pending')->count(),
            'in_progress' => Task::where('assigned_to', $user->id)->where('status', 'in_progress')->count(),
            'completed' => Task::where('assigned_to', $user->id)->where('status', 'completed')->count(),
        ];

        $recentLogs = ActivityLog::with('user')
            ->whereHas('user', function ($query) {
                $query->where('role', 'staff');
            })
            ->latest()
            ->take(10)
            ->get();

        return response()->json([
            'customerStats' => $customerStats,
            'taskStats' => $taskStats,
            'recentLogs' => $recentLogs
        ]);
    }

    public function clearLogs()
    {
        ActivityLog::where('user_id', Auth::id())->delete();
        return response()->json(['success' => true]);
    }

    public function exportCsv()
    {
        $user = Auth::user();
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=veltrix_staff_report_' . date('Y-m-d_H-i-s') . '.csv',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() use ($user) {
            $file = fopen('php://output', 'w');

            // 1. Title Banner
            fputcsv($file, ['=========================================================']);
            fputcsv($file, ['        VELTRIX CRM - STAFF PERFORMANCE EXPORT           ']);
            fputcsv($file, ['=========================================================']);
            fputcsv($file, ['Generated At', date('Y-m-d H:i:s')]);
            fputcsv($file, ['Generated By', $user->name . ' (Staff)']);
            fputcsv($file, []);

            // 2. Summary Stats
            $totalCustomers = Customer::where('assigned_to', $user->id)->count();
            $totalTasks = Task::where('assigned_to', $user->id)->count();
            $completedTasks = Task::where('assigned_to', $user->id)->where('status', 'completed')->count();
            $completionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 1) . '%' : '0%';

            fputcsv($file, ['[1. INDIVIDUAL PERFORMANCE SUMMARY]']);
            fputcsv($file, ['Metric', 'Value']);
            fputcsv($file, ['Assigned Customers', $totalCustomers]);
            fputcsv($file, ['Assigned Tasks', $totalTasks]);
            fputcsv($file, ['Task Completion Efficiency', $completionRate]);
            fputcsv($file, []);

            // 3. Customer Segments
            $leadsCount = Customer::where('assigned_to', $user->id)->where('status', 'lead')->count();
            $activeCustomersCount = Customer::where('assigned_to', $user->id)->where('status', 'active')->count();
            $inactiveCustomersCount = Customer::where('assigned_to', $user->id)->where('status', 'inactive')->count();

            fputcsv($file, ['[2. CUSTOMER ENTITY DISTRIBUTION]']);
            fputcsv($file, ['Segment / Status', 'Total Count']);
            fputcsv($file, ['Leads / Prospects', $leadsCount]);
            fputcsv($file, ['Active Customers', $activeCustomersCount]);
            fputcsv($file, ['Inactive Accounts', $inactiveCustomersCount]);
            fputcsv($file, []);

            // 4. Task Velocity
            $pendingTasksCount = Task::where('assigned_to', $user->id)->where('status', 'pending')->count();
            $inProgressTasksCount = Task::where('assigned_to', $user->id)->where('status', 'in_progress')->count();

            fputcsv($file, ['[3. OPERATIONAL VELOCITY]']);
            fputcsv($file, ['Task Status', 'Total Count']);
            fputcsv($file, ['Pending Status', $pendingTasksCount]);
            fputcsv($file, ['In Progress Status', $inProgressTasksCount]);
            fputcsv($file, ['Completed Status', $completedTasks]);
            fputcsv($file, []);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
