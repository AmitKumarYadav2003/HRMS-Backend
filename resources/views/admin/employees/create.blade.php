@extends('layouts.admin')

@section('title', isset($employee) ? 'Edit Employee' : 'Add Employee')

@section('content')
@php 
    $isEdit = isset($employee);
    $employee = $employee ?? new \App\Models\User();
@endphp

<div class="card">
    <div class="card-body">
        <h5 class="mb-3">{{ $isEdit ? 'Edit Employee' : 'Add Employee' }}</h5>

        <form action="{{ $isEdit ? route('admin.employees.update', $employee) : route('admin.employees.store') }}"
              method="POST" autocomplete="off">
            @csrf
            @if($isEdit) @method('PUT') @endif

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $employee->name ?? '') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', $employee->email ?? '') }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                           value="{{ old('phone', $employee->phone ?? '') }}">
                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Date of Joining</label>
                    <input type="date" name="date_of_joining" class="form-control @error('date_of_joining') is-invalid @enderror"
                           value="{{ old('date_of_joining', $employee->date_of_joining?->format('Y-m-d') ?? '') }}" required>
                    @error('date_of_joining')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Department</label>
                    <input type="text" name="department" class="form-control @error('department') is-invalid @enderror"
                           value="{{ old('department', $employee->department ?? '') }}" required>
                    @error('department')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Designation</label>
                    <input type="text" name="designation" class="form-control @error('designation') is-invalid @enderror"
                           value="{{ old('designation', $employee->designation ?? '') }}" required>
                    @error('designation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                        <option value="employee" @selected(old('role', $employee->role ?? '') === 'employee')>Employee</option>
                        <option value="admin" @selected(old('role', $employee->role ?? '') === 'admin')>Admin</option>
                    </select>
                    @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ $isEdit ? 'New Password (optional)' : 'Initial Password' }}</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                           minlength="6" autocomplete="new-password"
                           placeholder="{{ $isEdit ? 'Keep it blank to retain current password' : '' }}"
                           {{ $isEdit ? '' : 'required' }}>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Update Employee' : 'Save Employee' }}</button>
            <a href="{{ route('admin.employees.index') }}" class="btn btn-link">Cancel</a>
        </form>
    </div>
</div>
@endsection