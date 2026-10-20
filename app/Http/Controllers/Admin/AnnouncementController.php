<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('creator')
            ->latest()
            ->paginate(10);

        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'body' => 'required|string|max:1000',
            'type' => 'required|in:general,event,policy',
        ]);

        $validated['created_by'] = auth()->id();

        Announcement::create($validated);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement posted successfully.');
    }

    public function toggle(Announcement $announcement)
    {
        $announcement->update(['is_active' => ! $announcement->is_active]);

        return back()->with('success', 'Announcement status updated.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return back()->with('success', 'Announcement deleted.');
    }
}