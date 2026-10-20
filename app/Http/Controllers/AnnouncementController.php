<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index(Request $request)
{
    $perPage = min((int) $request->get('per_page', $request->get('limit', 10)), 50);

    $paginator = Announcement::with('creator')
        ->where('is_active', true)
        ->latest()
        ->paginate($perPage);

    return response()->json([
        'success' => true,
        'data' => $paginator->getCollection()->map(fn ($a) => [
            'id' => $a->id,
            'title' => $a->title,
            'body' => $a->body,
            'type' => $a->type,
            'posted_by' => $a->creator->name ?? null,
            'created_at' => $a->created_at->format('Y-m-d H:i'),
        ])->values(),
        'pagination' => [
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'total' => $paginator->total(),
            'has_more' => $paginator->hasMorePages(),
        ],
    ]);
}
}