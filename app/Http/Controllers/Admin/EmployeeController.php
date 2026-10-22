<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->get('role', 'employee'); // Default to 'employee' if not provided
        $query = User::where('role', $role);



        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('employee_id', 'like', "%{$search}%");
            });
        }

        if ($department = $request->get('department')) {
            $query->where('department', $department);
        }

        $employees = $query->latest()->paginate(10)->withQueryString();

        $departments = User::where('role', 'employee')
            ->whereNotNull('department')
            ->distinct()
            ->pluck('department');

        return view('admin.employees.index', compact('employees', 'departments'));
    }

    public function toggle(User $user)
    {
        if ($user->id === auth()->id()) {
             return back()->with('error', 'You cannot toggle your own account status.');
        }
        $user->update(['is_active' => ! $user->is_active]);
        
        if (!$user->is_active) {
            // If the user is deactivated, revoke all their tokens
            $user->tokens()->delete();
        }

        return back()->with('success', 'Employee status updated.');
    }

    public function create()
    {
        return view('admin.employees.create');
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:100',
        'email' => 'required|email|unique:users,email',
        'phone' => 'nullable|string|max:20',
        'department' => 'required|string|max:100',
        'designation' => 'required|string|max:100',
        'role' => 'required|in:employee,admin',
        'date_of_joining' => 'required|date',
        'password' => 'required|string|min:6',
    ]);

    $user = User::create([
        ...$validated,
        'password' => $validated['password'], // model me 'hashed' cast hai
        'is_active' => true,
    ]);

    $user->update([
        'employee_id' => 'EMP' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
    ]);

    return redirect()->route('admin.employees.index')
        ->with('success', 'Employee added successfully.');
}

    public function edit(User $user)
    {
        return view('admin.employees.create', ['employee' => $user]);
    }

public function update(Request $request, User $user)
{
    $validated = $request->validate([
        'name' => 'required|string|max:100',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'phone' => 'nullable|string|max:20',
        'department' => 'required|string|max:100',
        'designation' => 'required|string|max:100',
        'role' => 'required|in:employee,admin',
        'date_of_joining' => 'required|date',
        'password' => 'nullable|string|min:6',
    ]);
    if ($user->id === auth()->id() && $validated['role'] !== 'admin') {
        return back()->withErrors(['role' => 'You cannot change your own role.'])->withInput();
    }

    if (empty($validated['password'])) {
        unset($validated['password']);
    }

    $user->update($validated);

    return redirect()->route('admin.employees.index')
        ->with('success', 'Employee updated successfully.');
}
}