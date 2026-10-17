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
        'to_date' => 'required|date|after_or_equal:from_date',
        'leave_type' => 'required|string|in:Casual,Sick,Earned,Unpaid',
        'reason' => 'nullable|string',
        'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
    ]);

    $userId = $request->user()->id;
    $type = $request->leave_type;

    if ($type !== 'Unpaid') {
        $limits = [
            'Earned' => 12,
            'Sick' => 5,
            'Casual' => 10,
        ];

        $countDays = function ($from, $to) {
            $start = \Carbon\Carbon::parse($from);
            $end = \Carbon\Carbon::parse($to);
            $days = 0;

            while ($start->lte($end)) {
                if ($start->dayOfWeek !== \Carbon\Carbon::SUNDAY) {
                    $days++;
                }
                $start->addDay();
            }

            return $days;
        };

        $requestedDays = $countDays(
            $request->from_date,
            $request->to_date
        );

        $usedDays = 0;

        $approvedLeaves = Leave::where('user_id', $userId)
            ->where('leave_type', $type)
            ->where('status', 'approved')
            ->get();

        foreach ($approvedLeaves as $existingLeave) {
            $usedDays += $countDays(
                $existingLeave->from_date,
                $existingLeave->to_date
            );
        }

        $remaining = max(0, $limits[$type] - $usedDays);

        if ($requestedDays > $remaining) {
            return response()->json([
                'message' => 'Insufficient leave balance.',
                'available_balance' => $remaining,
                'requested_days' => $requestedDays,
            ], 422);
        }
    }

    $attachmentPath = null;

    if ($request->hasFile('attachment')) {
        $attachmentPath = $request->file('attachment')
            ->store('leave_attachments', 'public');
    }

    $leave = Leave::create([
        'user_id' => $userId,
        'from_date' => $request->from_date,
        'to_date' => $request->to_date,
        'leave_type' => $type,
        'reason' => $request->reason,
        'attachment' => $attachmentPath,
        'status' => 'pending',
    ]);

    return response()->json([
        'message' => 'Leave applied successfully',
        'data' => $leave,
    ], 201);
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