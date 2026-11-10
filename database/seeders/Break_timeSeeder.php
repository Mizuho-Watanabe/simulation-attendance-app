<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Break_timeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //各Attendance_recordにbreak_timeを一件ずつ
        Attendance_record::all()->each(function ($attendance_record) {
            Break_time::factory()->create([
                'attendance_recprd' => $attendance_record->id,
                'break_in' => '12:00',
                'break_out' => '13:00',
            ]);
        });
    }
}
