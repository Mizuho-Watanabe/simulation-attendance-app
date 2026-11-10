<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::all();

        //各ユーザーに週5日勤務＊6ヶ月分として120日分のダミーデータを作成する
        Attendance_record::factory()->count(120)->create([
            'user_id' => '1',
            'total_break_time' => '1:00',
            'total_time' => '8:00',
        ]);

        Attendance_record::factory()->count(120)->create([
            'user_id' => '2',
            'total_break_time' => '1:00',
            'total_time' => '8:00',
        ]);

        Attendance_record::factory()->count(120)->create([
            'user_id' => 3,
            'total_break_time' => '1:00',
            'total_time' => '8:00',
        ]);
    }
}
