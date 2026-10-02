<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payslip;

class PayslipController extends Controller
{
    public function history(Request $request)
    {
        $payslips = Payslip::where('user_id', $request->user()->id)
            ->orderBy('year', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['data' => $payslips]);
    }
}