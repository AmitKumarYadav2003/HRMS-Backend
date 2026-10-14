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

    public function balance(Request $request)
{
    $userId = $request->user()->id;

    $limits = [
        'Earned' => 12,
        'Sick' => 5,
        'Casual' => 10,
    ];

    $balance = [];

    foreach ($limits as $type => $total) {
        $used = Leave::where('user_id', $userId)
            ->where('leave_type', $type)
            ->where('status', 'approved')
            ->get()
->sum(function ($leave) {
    $start = \Carbon\Carbon::parse($leave->from_date);
    $end = \Carbon\Carbon::parse($leave->to_date);

    $days = 0;

    while ($start->lte($end)) {
        if ($start->dayOfWeek !== \Carbon\Carbon::SUNDAY) {
            $days++;
        }

        $start->addDay();
    }

    return $days;
});

        $balance[strtolower($type)] = [
            'total' => $total,
            'used' => $used,
            'remaining' => max(0, $total - $used),
        ];
    }

    return response()->json(['data' => $balance]);
}
}