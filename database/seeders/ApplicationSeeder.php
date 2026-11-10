<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $attendance_record = Attendance_record::all();

        //修正申請を作成
        Application::firstOrCreate([
            'id' => '1',
            'new_total_break_time' => '1:00',
            'attendance_id' => '120',
            'apploval_status' => '承認待ち',
        ]);

    }
}
