<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'attendance_record_id' => AttendanceRecord::factory(),
            'date' => $this->faker->dateTimeBetween($startDate = '-6 months', $endDate = 'now'),
            'new_clock_in' => '9:30',
            'new_clock_out' => '18:30',
            'approval_status' => '0',
            'comment' => $this->faker->text(100),
        ];
    }
}
