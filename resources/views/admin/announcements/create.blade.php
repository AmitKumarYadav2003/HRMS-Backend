@extends('layouts.admin')

@section('title', 'New Announcement')

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="mb-3">New Announcement</h5>

        <form action="{{ route('admin.announcements.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                       value="{{ old('title') }}" maxlength="150" required>
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Type</label>
                <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                    <option value="general" @selected(old('type') === 'general')>General</option>
                    <option value="event" @selected(old('type') === 'event')>Event</option>
                    <option value="policy" @selected(old('type') === 'policy')>Policy</option>
                </select>
                @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Message</label>
                <textarea name="body" rows="4" class="form-control @error('body') is-invalid @enderror"
                          maxlength="1000" required>{{ old('body') }}</textarea>
                @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="btn btn-primary">Post Announcement</button>
            <a href="{{ route('admin.announcements.index') }}" class="btn btn-link">Cancel</a>
        </form>
    </div>
</div>
@endsection