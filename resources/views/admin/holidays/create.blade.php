@extends('layouts.admin')

@section('title', 'Add Holiday')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="mb-3">Add Holiday</h5>

        <form action="{{ route('admin.holidays.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Date</label>
                <input type="date" name="date" class="form-control @error('date') is-invalid @enderror"
                       value="{{ old('date') }}" required>
                @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Type</label>
                <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                    <option value="national" @selected(old('type') === 'national')>National</option>
                    <option value="festival" @selected(old('type') === 'festival')>Festival</option>
                    <option value="optional" @selected(old('type') === 'optional')>Optional</option>
                </select>
                @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="btn btn-primary">Save Holiday</button>
            <a href="{{ route('admin.holidays.index') }}" class="btn btn-link">Cancel</a>
        </form>
    </div>
</div>
@endsection