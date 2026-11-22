<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\AttendanceRecord;
use App\Models\BreakTime;
use App\Models\Application;
use App\Models\NewBreakTime;
use Carbon\Carbon;

class AdminController extends Controller
{
    //勤怠一覧画面
    public function index (Request $request, AttendanceRecord $attendance_record)
    {
        $user = Auth::user();

        $date = $request->filled('date')
            ? Carbon::parse($request->query('date'))
            : Carbon::today();
        $previousDay = $date->copy()->subDay(1);
        $nextDay = $date->copy()->addDay(1);

        $users = User::whereHas('attendance_records', function ($query) use ($date) {
            $query->where('date', $date);
        })
        ->get();

        $attendanceRecords = Attendancerecord::where('date', $date)
                ->get();

        return view('admin.admin-attendance-list', compact('user', 'users', 'date', 'previousDay', 'nextDay', 'attendanceRecords'));
    }
}
