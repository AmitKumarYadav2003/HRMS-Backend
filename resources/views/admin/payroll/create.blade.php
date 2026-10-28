@extends('layouts.admin')

@section('title', $payslip->exists ? 'Edit Payslip' : 'Add Payslip')

@section('content')
@php
    $isEdit = $payslip->exists;
    $action = $isEdit ? route('admin.payroll.update', $payslip) : route('admin.payroll.store');
    $amounts = ['basic' => 'Basic', 'hra' => 'HRA', 'allowance' => 'Allowance', 'pf' => 'PF', 'tax' => 'Tax'];
@endphp

<h4 class="mb-3">{{ $isEdit ? 'Edit Payslip' : 'Add Payslip' }}</h4>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ $action }}" autocomplete="off">
            @csrf
            @if($isEdit) @method('PUT') @endif

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Employee</label>
                    <select name="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                        <option value="">-- Select --</option>
                        @foreach($employees as $e)
                            <option value="{{ $e->id }}" @selected(old('user_id', $payslip->user_id) == $e->id)>{{ $e->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Month</label>
                    <select name="month" class="form-select @error('month') is-invalid @enderror" required>
                        @foreach($months as $m)
                            <option value="{{ $m }}" @selected(old('month', $payslip->month ?? 'August') === $m)>{{ $m }}</option>
                        @endforeach
                    </select>
                    @error('month')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Year</label>
                    <input type="number" name="year" value="{{ old('year', $payslip->year ?? now()->year) }}"
                           class="form-control @error('year') is-invalid @enderror" required>
                    @error('year')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                @foreach($amounts as $field => $label)
                    <div class="col-md-4">
                        <label class="form-label">{{ $label }}</label>
                        <input type="number" step="0.01" min="0" name="{{ $field }}"
                               value="{{ old($field, $payslip->$field) }}"
                               class="form-control @error($field) is-invalid @enderror" required>
                        @error($field)<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                @endforeach

                <div class="col-md-4">
                    <label class="form-label">Credited On</label>
                    <input type="date" name="credited_on" value="{{ old('credited_on', $payslip->credited_on) }}"
                           class="form-control @error('credited_on') is-invalid @enderror">
                    @error('credited_on')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button class="btn btn-primary">Save Draft</button>
                <a href="{{ route('admin.payroll.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection