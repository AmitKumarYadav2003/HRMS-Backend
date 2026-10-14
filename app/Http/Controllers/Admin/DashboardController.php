<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        $today = today()->toDateString();

        // Total active employees (role = employee)
        $totalEmployees = User::where('role', 'employee')->count();

        // Employees who have checked in today
        $presentToday = DB::table('attendances')
            ->whereDate('date', $today)
            ->whereNotNull('check_in')
            ->distinct()
            ->count('user_id');

        // Employees on approved leave today
        $onLeaveToday = DB::table('leaves')
            ->where('status', 'approved')
            ->whereDate('from_date', '<=', $today)
            ->whereDate('to_date', '>=', $today)
            ->distinct()
            ->count('user_id');

        // Employees expected to be present, excluding approved leave
        $expectedEmployees = max(
            0,
            $totalEmployees - $onLeaveToday
        );

        // No attendance + not on approved leave = absent
        $absentToday = max(
            0,
            $expectedEmployees - $presentToday
        );

        // Attendance percentage
        $attendancePercentage = $expectedEmployees > 0
            ? round(($presentToday / $expectedEmployees) * 100, 1)
            : 0;

        // Pending leave requests
        $pendingLeaves = DB::table('leaves')
            ->where('status', 'pending')
            ->count();

        // Latest 5 pending leave requests
        $leaveRequests = DB::table('leaves')
            ->join('users', 'leaves.user_id', '=', 'users.id')
            ->where('leaves.status', 'pending')
            ->select('leaves.*', 'users.name')
            ->latest('leaves.created_at')
            ->limit(5)
            ->get();

        // compact() variables ko Blade view tak pass karta hai.    
        return view('admin.dashboard', compact(
            'totalEmployees',
            'presentToday',
            'absentToday',
            'attendancePercentage',
            'pendingLeaves',
            'leaveRequests'
        ));
    }
}
