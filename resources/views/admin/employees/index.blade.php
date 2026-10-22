@extends('layouts.admin')

@section('title', 'Employees')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Employees</h4>
    <a href="{{ route('admin.employees.create') }}" class="btn btn-primary">Add Employee</a>
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-4">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control"
               placeholder="Search by Name, email or employee ID">
    </div>
    <div class="col-md-3">
        <select name="department" class="form-select">
            <option value="">All departments</option>
            @foreach($departments as $dept)
                <option value="{{ $dept }}" @selected(request('department') === $dept)>{{ $dept }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
    <select name="role" class="form-select">
        <option value="employee" @selected(request('role', 'employee') === 'employee')>Employees</option>
        <option value="admin" @selected(request('role') === 'admin')>Admins</option>
    </select>
</div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">Filter</button>
    </div>
</form>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Employee ID</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th>Phone</th>
                    <th>Joined</th>
                    <th>Status</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $employee)
                    <tr>
                        <td>
                            <strong>{{ $employee->name }}</strong><br>
                            <small class="text-muted">{{ $employee->email }}</small>
                        </td>
                        <td>{{ $employee->employee_id ?? '-' }}</td>
                        <td>{{ $employee->department ?? '-' }}</td>
                        <td>{{ $employee->designation ?? '-' }}</td>
                        <td>{{ $employee->phone ?? '-' }}</td>
                        <td>{{ $employee->date_of_joining?->format('d M Y') ?? '-' }}</td>
                        <td>
                            @if($employee->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.employees.edit', $employee) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('admin.employees.toggle', $employee) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $employee->is_active ? 'btn-outline-danger' : 'btn-outline-success' }}">
                                    {{ $employee->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">No employees found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $employees->links() }}
</div>
@endsection