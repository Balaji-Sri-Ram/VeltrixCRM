<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\ActivityLog;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.show', compact('customer'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:lead,active,inactive',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $customer = Customer::create($validated);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Customer Created',
            'description' => "Created customer: {$customer->name}",
        ]);

        // Notify All Other Users
        $others = User::where('id', '!=', Auth::id())->get();
        foreach ($others as $other) {
            Notification::create([
                'user_id' => $other->id,
                'title' => __('messages.notif_customer_added_title'),
                'message' => __('messages.notif_customer_added_message', [
                    'name' => $customer->name,
                    'user' => Auth::user()->name,
                    'role' => Auth::user()->role
                ]),
                'is_read' => false,
            ]);
        }

        return response()->json(['success' => true, 'customer' => $customer]);
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:lead,active,inactive',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $customer->update($validated);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Customer Updated',
            'description' => "Updated customer details: {$customer->name}",
        ]);

        return response()->json(['success' => true, 'customer' => $customer]);
    }

    public function destroy(Customer $customer)
    {
        $name = $customer->name;
        $customer->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Customer Deleted',
            'description' => "Deleted customer: {$name}",
        ]);

        // Notify All Other Users
        $others = User::where('id', '!=', Auth::id())->get();
        foreach ($others as $other) {
            Notification::create([
                'user_id' => $other->id,
                'title' => __('messages.notif_customer_deleted_title'),
                'message' => __('messages.notif_customer_deleted_message', [
                    'name' => $name,
                    'user' => Auth::user()->name,
                    'role' => Auth::user()->role
                ]),
                'is_read' => false,
            ]);
        }

        return response()->json(['success' => true]);
    }
}
