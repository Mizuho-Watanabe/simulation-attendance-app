<?php

namespace Database\Seeders;

use App\Models\AttendanceRecord;
use App\Models\Application;
use database\seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $attendance_record = AttendanceRecord::all();

        //修正申請を作成
        Application::firstOrCreate([
            'id' => '1',
            'attendance_record_id' => '120',
            'date' => '2026-10-23',
            'new_clock_in' => '11:00',
            'new_clock_out' => '19:00',
            'approval_status' => '0',
            'comment' => 'test',
        ]);

    }
}
