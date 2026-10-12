@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title text-muted">Total Employees</h5>
                <h2 class="card-text" style="color: #2E86DE; font-weight: 800;">{{ $totalEmployees }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title text-muted">Present Today</h5>
                <h2 class="card-text" style="color: #10B981; font-weight: 800;">{{ $presentToday }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title text-muted">Absent Today</h5>
                <h2 class="card-text" style="color: #EF4444; font-weight: 800;">{{ $absentToday }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title text-muted">Pending Leaves</h5>
                <h2 class="card-text" style="color: #F59E0B; font-weight: 800;">{{ $pendingLeaves }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Pending Leave Requests</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm table-hover">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Type</th>
                            <th>Days</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
    @forelse($leaveRequests as $leave)
        <tr>
            <td>{{ $leave->name }}</td>
            <td>{{ $leave->leave_type }}</td>
            <td>
                {{ \Carbon\Carbon::parse($leave->from_date)
                    ->diffInDays(\Carbon\Carbon::parse($leave->to_date)) + 1 }}
            </td>
            <td>
                <span class="badge bg-warning">Pending</span>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="text-center">No pending leave requests</td>
        </tr>
    @endforelse
</tbody>
                </table>
            </div>
            <div class="card-footer text-center">
                
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Today's Attendance</h5>
            </div>
            <div class="card-body">
                
@php
    $absentPercentage = ($presentToday + $absentToday) > 0
        ? round(($absentToday / ($presentToday + $absentToday)) * 100, 1)
        : 0;
@endphp

<div class="mb-3">
    <div class="d-flex justify-content-between mb-2">
        <span>Present</span>
        <strong style="color: #10B981;">
            {{ $presentToday }} ({{ $attendancePercentage }}%)
        </strong>
    </div>
    <div class="progress">
        <div class="progress-bar bg-success"
             style="width: {{ $attendancePercentage }}%">
        </div>
    </div>
</div>

<div class="mb-3">
    <div class="d-flex justify-content-between mb-2">
        <span>Absent</span>
        <strong style="color: #EF4444;">
            {{ $absentToday }} ({{ $absentPercentage }}%)
        </strong>
    </div>
    <div class="progress">
        <div class="progress-bar bg-danger"
             style="width: {{ $absentPercentage }}%">
        </div>
    </div>
</div>

                <div class="text-muted small mt-3">
                    <p>📅 Last updated: Today at 09:30 AM</p>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
               
            </div>
        </div>
    </div>
</div>
@endsection