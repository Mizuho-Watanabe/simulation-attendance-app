<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class New_break_timeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $application = Application::aii();

        //修正休憩時間を登録
        New_brak_time::create([
            'application_id' => '1',
            'new_break_in' => '13:00',
            'new_break_out' => '14:00',
        ])
    }
}
