<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\NewBreakTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewBreakTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $application = Application::all();

        //修正休憩時間を登録
        NewBreakTime::create([
            'application_id' => '1',
            'new_break_in' => '13:00',
            'new_break_out' => '14:00',
        ]);
    }
}
