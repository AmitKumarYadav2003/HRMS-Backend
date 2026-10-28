@extends('layouts.admin')

@section('title', 'Payslip')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">{{ $payslip->user->name }} · {{ $payslip->month }} {{ $payslip->year }}</h4>
    <span class="badge {{ $payslip->status === 'approved' ? 'bg-success' : 'bg-secondary' }}">
        {{ ucfirst($payslip->status) }}
    </span>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card"><div class="card-body">
            <h6>Earnings</h6>
            <table class="table table-sm mb-0">
                <tr><td>Basic</td><td class="text-end">₹{{ number_format($payslip->basic, 2) }}</td></tr>
                <tr><td>HRA</td><td class="text-end">₹{{ number_format($payslip->hra, 2) }}</td></tr>
                <tr><td>Allowance</td><td class="text-end">₹{{ number_format($payslip->allowance, 2) }}</td></tr>
                <tr class="fw-bold"><td>Gross</td><td class="text-end">₹{{ number_format($payslip->gross, 2) }}</td></tr>
            </table>
        </div></div>
    </div>

    <div class="col-md-6">
        <div class="card"><div class="card-body">
            <h6>Deductions</h6>
            <table class="table table-sm mb-0">
                <tr><td>PF</td><td class="text-end">₹{{ number_format($payslip->pf, 2) }}</td></tr>
                <tr><td>Tax</td><td class="text-end">₹{{ number_format($payslip->tax, 2) }}</td></tr>
                <tr class="fw-bold"><td>Total</td><td class="text-end">₹{{ number_format($payslip->total_deductions, 2) }}</td></tr>
            </table>
        </div></div>
    </div>
</div>

<div class="card mt-3">
    <div class="card-body d-flex justify-content-between align-items-center">
        <div>
            <small class="text-muted">Net Pay</small>
            <div class="h4 mb-0">₹{{ number_format($payslip->net_pay, 2) }}</div>
        </div>

        <div class="d-flex gap-2">
            @if($payslip->status === 'draft')
                <a href="{{ route('admin.payroll.edit', $payslip) }}" class="btn btn-outline-primary">Edit</a>
                <form method="POST" action="{{ route('admin.payroll.approve', $payslip) }}"
                      onsubmit="return confirm('Want to Approve? Once approved, editing will be disabled.')">
                    @csrf
                    @method('PATCH')
                    <button class="btn btn-success">Approve</button>
                </form>
            @else
                <span class="text-success">
                    Approved {{ $payslip->approved_at?->format('d M Y') }}
                </span>
            @endif
        </div>
    </div>
</div>

<a href="{{ route('admin.payroll.index') }}" class="btn btn-link mt-3 px-0">← Back to Payroll</a>
@endsection