<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaveController extends Controller
{
    public function index()
    {
        $leaves = DB::table('leaves')
            ->join('users', 'leaves.user_id', '=', 'users.id')
            ->select('leaves.*', 'users.name', 'users.employee_id', 'users.department')
            ->latest('leaves.created_at')
            ->paginate(10);

        return view('admin.leaves.index', compact('leaves'));
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_remarks' => 'nullable|string|max:2000',
        ]);

        $leave = DB::table('leaves')->where('id', $id)->first();

        if (!$leave) {
            abort(404);
        }

        if ($leave->status !== 'pending') {
            return redirect()
                ->route('admin.leaves.index')
                ->with('error', 'This leave request has already been processed.');
        }

        DB::table('leaves')
            ->where('id', $id)
            ->update([
                'status' => $validated['status'],
                'admin_remarks' => $validated['admin_remarks'] ?? null,
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('admin.leaves.index')
            ->with('success', 'Leave request ' . $validated['status'] . ' successfully.');
    }
}

