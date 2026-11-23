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
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ApplicationRequest;

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

    //勤怠詳細画面の表示
    public function show(AttendanceRecord $attendance_record)
    {
        $user = Auth::user();
        $application = Application::where('attendance_record_id', $attendance_record->id)
                ->latest()
                ->first();
        $breaks = BreakTime::where('attendance_record_id', $attendance_record->id)
                ->get()
                ->toArray();

        $attendanceRecord = [
            'id' => $attendance_record->id,
            'year' => Carbon::parse($attendance_record->date),
            'date' => Carbon::parse($attendance_record->date),
            'clock_in' => $attendance_record->clock_in,
            'clock_out' => $attendance_record->clock_out,
            'breaks' => $breaks,
            'comment' => $application ? $application->comment : '',
        ];

        return view('admin.admin-detail', compact('user', 'attendanceRecord'));
    }

    //勤怠詳細画面から直接修正する
    public function update(ApplicationRequest $request, AttendanceRecord $attendance_record)
    {

        $user = Auth::user();

        DB::transaction(function () use ($request, $attendance_record) {
        //applicationにレコードを作成する
        $application = Application::create([
                'attendance_record_id' => $attendance_record->id,
                'date' => $attendance_record->date,
                'new_clock_in' => $request->input('new_clock_in'),
                'new_clock_out' => $request->input('new_clock_out'),
                'approval_status' => 1,
                'comment' => $request->input('comment'),
            ]);
        
        //break_timesテーブルの該当レコードの削除・新規作成および休憩時間・勤務時間の計算
        $new_break_ins = $request->input('new_break_in', []);
        $new_break_outs = $request->input('new_break_out', []);
        $validBreaks = [];

        BreakTime::where('attendance_record_id', $attendance_record->id)
                ->delete();
        foreach ($new_break_ins as $index => $new_break_in) {
            $new_break_out = $new_break_outs[$index] ?? null;

            $inVal = is_string($new_break_in) ? trim($new_break_in) : $new_break_in;
            $outVal = is_string($new_break_out) ? trim($new_break_out) : $new_break_out;
            if (empty($new_break_in) && empty($new_break_out)) { continue; }
            $validBreaks[] = [
                'break_in' => $inVal ?: null,
                'break_out' => $outVal ?: null,
            ];
        }

        foreach ($validBreaks as $break) {
            if ($break['break_in']) {
                Breaktime::create([
                'attendance_record_id' => $attendance_record->id,
                'break_in'  => $break['break_in'],
                'break_out' => $break['break_out'],
                ]);
            }
        }

        $totalSeconds = 0;
        $attendance_record_id = $attendance_record->id;
        $break_time_records = BreakTime::where('attendance_record_id', $attendance_record_id)
                ->get();

        foreach ($break_time_records as $break_time_record) {
            $break_in_time = new Carbon($break_time_record->break_in);
            $break_out_time = new Carbon($break_time_record->break_out);
            $diffInSeconds = $break_in_time->diffInSeconds($break_out_time);

            $totalSeconds += $diffInSeconds;
        }
        $total_break_time = gmdate('H:i:s', $totalSeconds);

        $clock_in_time = new Carbon($application->new_clock_in);
        $clock_out_time = new Carbon($application->new_clock_out);
        $total_duty_time = $clock_in_time->diffInSeconds($clock_out_time);
        $total_time = gmdate('H:i:s', $total_duty_time-$totalSeconds);

        //attendance_recordテーブルの更新
        $attendance_record->update([
            'clock_in' => $application->new_clock_in,
            'clock_out' => $application->new_clock_out,
            'total_break_time' => $total_break_time,
            'total_time' => $total_time,
            ]);

        });

        return redirect('/admin/attendance/list');
    }

    //スタッフ一覧画面の表示
    public function staffindex () {
        $user = Auth::user();
        $users = User::get();

        return view('admin.staff-list', compact('user', 'users'));
    }
}
