<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\AttendanceRecord;
use App\Models\BreakTime;

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
    public function store(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today();
        $now = Carbon::now();

        $attendance = AttendanceRecord::where('user_id', $user->id)
                    ->whereDate('date', $today)
                    ->first();
        $action = $request->input('action');

        //レコードがなければAttendanceRecordレコードを新規作成
        if (!$attendance) {
            AttendanceRecord::create([
                'user_id' => $user->id,
                'date' => $today,
                'clock_in' => $now,
                'attendance_status' =>1,
            ]);
        } else {
            //break_inが押されたらBreakTimeレコードを新規作成かつAttendanceRecordの上書き
            if ($action === 'break_in') {
                BreakTime::create([
                    'attendance_record_id' => $attendance->id,
                    'break_in' => $now,
                ]);
                $attendance->update([
                    'attendance_status' => 2,
                ]);
            } elseif ($action === 'break_out') {
                //break_outが押されたらBreakTimeとAttendanceRecordを上書き
                $breaktime = BreakTime::where('attendance_record_id', $attendance->id)
                            ->whereNull('break_out')
                            ->update([
                                'break_out' => $now,
                            ]);
                $attendance->update([
                    'attendance_status' => 1,
                ]);
            } elseif ($action === 'clock_out') {
                //clock_outが押されたらAttendanceRecordを上書き
                $totalSeconds = 0;
                $break_time_records = BreakTime::where('attendance_record_id', $attendance->id)->get();

                foreach ($break_time_records as $break_time_record) {
                    $break_in_time = new Carbon($break_time_record->break_in);
                    $break_out_time = new Carbon($break_time_record->break_out);
                    $diffInSeconds = $break_in_time->diffInSeconds($break_out_time);

                    $totalSeconds += $diffInSeconds;
                }
                $total_break_time = gmdate('H:i:s', $totalSeconds);

                $clock_in_time = new Carbon($attendance->clock_in);
                $clock_out_time = $now;
                $total_time = gmdate('H:i:s', $clock_in_time->diffInSeconds($clock_out_time));

                $attendance->update([
                    'clock_out' => $now,
                    'total_break_time' => $total_break_time,
                    'total_time' => $total_time,
                    'attendance_status' => 3,
                ]);
            }
        }

        return redirect('/attendance');
    }

    public function index()
    {
        
    }
}
