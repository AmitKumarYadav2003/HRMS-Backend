<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function checkIn(Request $request)
    {
        $today = Carbon::today()->toDateString();
        $user = $request->user();

        $existing = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        if ($existing) {
            return response()->json(['message' => 'Already checked in today'], 400);
        }

        $attendance = Attendance::create([
            'user_id' => $user->id,
            'date' => $today,
            'check_in' => Carbon::now()->toTimeString(),
            'status' => 'present',
        ]);

        return response()->json(['message' => 'Checked in successfully', 'data' => $attendance]);
    }

    public function checkOut(Request $request)
    {
        $today = Carbon::today()->toDateString();
        $user = $request->user();

        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        if (!$attendance) {
            return response()->json(['message' => 'No check-in found for today'], 400);
        }

        $attendance->update([
            'check_out' => Carbon::now()->toTimeString(),
        ]);

        return response()->json(['message' => 'Checked out successfully', 'data' => $attendance]);
    }

    public function today(Request $request)
    {
        $today = Carbon::today()->toDateString();
        $attendance = Attendance::where('user_id', $request->user()->id)
            ->where('date', $today)
            ->first();

        return response()->json(['data' => $attendance]);
    }

    public function history(Request $request)
    {
        $query = Attendance::where('user_id', $request->user()->id);

        if ($request->has('month') && $request->has('year')) {
            $query->whereMonth('date', $request->month)
                  ->whereYear('date', $request->year);
        }

        $attendances = $query->orderBy('date', 'desc')->get();

        $totalDays = $attendances->count();
        $presentCount = $attendances->where('status', 'present')->count();
        $absentCount = $attendances->where('status', 'absent')->count();
        $lateCount = $attendances->where('status', 'late')->count();
        $percentage = $totalDays > 0 ? round(($presentCount / $totalDays) * 100, 1) : 0;

        return response()->json([
            'stats' => [
                'total_days' => $totalDays,
                'present' => $presentCount,
                'absent' => $absentCount,
                'late' => $lateCount,
                'percentage' => $percentage,
            ],
            'data' => $attendances
        ]);
    }
}