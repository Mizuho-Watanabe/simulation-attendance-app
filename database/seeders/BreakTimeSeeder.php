<?php

namespace Database\Seeders;

use App\Models\AttendanceRecord;
use App\Models\BreakTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BreakTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //各Attendance_recordにbreak_timeを一件ずつ
        AttendanceRecord::all()->each(function ($attendance_record) {
            BreakTime::factory()->create([
                'attendance_record_id' => $attendance_record->id,
                'break_in' => '12:00',
                'break_out' => '13:00',
            ]);
        });
    }
}
