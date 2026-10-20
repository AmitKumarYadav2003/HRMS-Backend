@extends('layouts.admin')

@section('title', 'Announcements')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Announcements</h4>
    <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">+ New Announcement</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Posted By</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($announcements as $announcement)
                    <tr>
                        <td>
                            <strong>{{ $announcement->title }}</strong><br>
                            <small class="text-muted">{{ Str::limit($announcement->body, 80) }}</small>
                        </td>
                        <td><span class="badge bg-secondary text-capitalize">{{ $announcement->type }}</span></td>
                        <td>{{ $announcement->creator->name ?? '-' }}</td>
                        <td>{{ $announcement->created_at->format('d M Y') }}</td>
                        <td>
                            @if($announcement->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Hidden</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <form action="{{ route('admin.announcements.toggle', $announcement) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                    {{ $announcement->is_active ? 'Hide' : 'Show' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this announcement?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Abhi koi announcement nahi hai.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $announcements->links() }}
</div>
@endsection