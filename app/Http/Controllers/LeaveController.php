<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;

class LeaveController extends Controller
{
    public function apply(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'leave_type' => 'required|string',
            'reason' => 'nullable|string',
        ]);

        $leave = Leave::create([
            'user_id' => $request->user()->id,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'leave_type' => $request->leave_type,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'Leave applied successfully', 'data' => $leave]);
    }

    public function history(Request $request)
    {
        $leaves = Leave::where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['data' => $leaves]);
    }
}