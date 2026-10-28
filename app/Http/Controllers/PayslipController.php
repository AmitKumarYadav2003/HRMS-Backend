<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payslip;

class PayslipController extends Controller
{
    public function history(Request $request)
{
    $payslips = Payslip::where('user_id', $request->user()->id)
        ->where('status', 'approved') // draft employee ko nahi dikhega
        ->orderBy('year', 'desc')
        ->orderBy('id', 'desc')
        ->get(['id', 'month', 'year', 'net_pay', 'credited_on']);

    return response()->json(['data' => $payslips]);
}

public function show(Request $request, Payslip $payslip)
{
    // Doosre ki payslip ya draft ko 404 do
    abort_unless(
        $payslip->user_id === $request->user()->id && $payslip->status === 'approved',
        404
    );

    $payslip->append(['gross', 'total_deductions'])
        ->makeHidden(['user_id', 'approved_by']);

    return response()->json(['data' => $payslip]);
}
}