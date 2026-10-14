
@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Leave Management</h2>
            <p class="text-muted mb-0">Review and manage employee leave requests.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
            Back to Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Department</th>
                            <th>Leave Type</th>
                            <th>Dates</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Admin Remarks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leaves as $leave)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $leave->name }}</div>
                                    <small class="text-muted">
                                        {{ $leave->employee_id ?: 'Employee #' . $leave->user_id }}
                                    </small>
                                </td>
                                <td>{{ $leave->department ?: '—' }}</td>
                                <td>{{ $leave->leave_type }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($leave->from_date)->format('d M Y') }}
                                    <br>
                                    <small class="text-muted">to</small>
                                    <br>
                                    {{ \Carbon\Carbon::parse($leave->to_date)->format('d M Y') }}
                                    <br>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($leave->from_date)->diffInDays(
                                            \Carbon\Carbon::parse($leave->to_date)
                                        ) + 1 }} day(s)
                                    </small>
                                </td>
                                <td>{{ $leave->reason ?: '—' }}</td>
                                <td>
                                    @if($leave->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($leave->status === 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @else
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>
                                <td>{{ $leave->admin_remarks ?: '—' }}</td>
                                <td style="min-width: 230px;">
                                    @if($leave->status === 'pending')
                                        <form method="POST"
                                              action="{{ route('admin.leaves.updateStatus', $leave->id) }}">
                                            @csrf

                                            <textarea name="admin_remarks"
                                                      class="form-control form-control-sm mb-2"
                                                      rows="2"
                                                      maxlength="2000"
                                                      placeholder="Optional remarks"></textarea>

                                            <div class="d-flex gap-2">
                                                <button type="submit"
                                                        name="status"
                                                        value="approved"
                                                        class="btn btn-success btn-sm">
                                                    Approve
                                                </button>

                                                <button type="submit"
                                                        name="status"
                                                        value="rejected"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Reject this leave request?')">
                                                    Reject
                                                </button>
                                            </div>
                                        </form>
                                    @else
                                        <span class="text-muted small">Already processed</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    No leave requests found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $leaves->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
