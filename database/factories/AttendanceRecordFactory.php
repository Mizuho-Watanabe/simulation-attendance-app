<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AttendanceRecord>
 */
class AttendanceRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'date' => $this->faker->dateTimeBetween($startDate = '-6 months', $endDate = 'now'),
            'clock_in' => '9:00',
            'clock_out' => '18:00',
            'total_break_time' => '1:00',
            'total_time' => '8:00',
            'attendance_status' => '3',
        ];
    }
}
