@extends('layouts.admin')

@section('title', 'Holidays')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Holidays</h4>
    <a href="{{ route('admin.holidays.create') }}" class="btn btn-primary">+ Add Holiday</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($holidays as $holiday)
                    <tr>
                        <td><strong>{{ $holiday->name }}</strong></td>
                        <td>{{ $holiday->date->format('d M Y (D)') }}</td>
                        <td><span class="badge bg-secondary text-capitalize">{{ $holiday->type }}</span></td>
                        <td class="text-end">
                            <form action="{{ route('admin.holidays.destroy', $holiday) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this holiday?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">No Holidays Found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $holidays->links() }}
</div>
@endsection