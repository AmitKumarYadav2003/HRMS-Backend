@extends('layouts.admin')

@section('title', 'Payroll')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Payroll</h4>
    <a href="{{ route('admin.payroll.create') }}" class="btn btn-primary">+ Add Payslip</a>
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-3">
        <select name="month" class="form-select">
            @foreach($months as $m)
                <option value="{{ $m }}" @selected($m === $month)>{{ $m }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <input type="number" name="year" value="{{ $year }}" class="form-control">
    </div>
    <div class="col-md-2">
        <button class="btn btn-outline-secondary w-100">Filter</button>
    </div>
</form>

<div class="card">
    <table class="table mb-0 align-middle">
        <thead>
            <tr>
                <th>Employee</th>
                <th>Net Pay</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($payslips as $p)
                <tr>
                    <td>
                        {{ $p->user->name }}<br>
                        <small class="text-muted">{{ $p->user->email }}</small>
                    </td>
                    <td>₹{{ number_format($p->net_pay, 2) }}</td>
                    <td>
                        @if($p->status === 'approved')
                            <span class="badge bg-success">Approved</span>
                        @else
                            <span class="badge bg-secondary">Draft</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.payroll.show', $p) }}" class="btn btn-sm btn-outline-primary">View</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">No payslips found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">{{ $payslips->links() }}</div>
@endsection