<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\AttendanceRecord;

class AttendanceController extends Controller
{
    //出勤登録画面の表示
    public function clock_in()
    {
        $user = Auth::user();
        $formattedDate = Carbon::today()->format('Y-m-d');
        $formattedTime = Carbon::now();

        return view('user.attendance-register', compact('user', 'formattedDate', 'formattedTime'));
    }

    //出勤登録機能
}
