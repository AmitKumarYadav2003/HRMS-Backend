<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Holiday;

class HolidayController extends Controller
{
    public function list()
    {
        $holidays = Holiday::orderBy('date', 'asc')->get();

        return response()->json(['data' => $holidays]);
    }
}