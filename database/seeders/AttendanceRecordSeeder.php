<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AttendanceRecord;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendanceRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            //過去6ヶ月分の(仮に土日を除いた)週5日のループ
            $startDate = now()->subMonths(6);
            $endDate = now();

            $currentDate = $startDate->copy();
            while ($currentDate <= $endDate) {
                if (!$currentDate->isWeekend()) {
                    AttendanceRecord::factory()->create([
                        'user_id' => $user->id,
                        'date' => $currentDate->format('Y-m-d'),
                        'total_break_time' => '1:00',
                        'total_time' => '8:00',
                        'attendance_status' => '3',
                    ]);
                }
                $currentDate->addDay();
            }
        }
    }
}
