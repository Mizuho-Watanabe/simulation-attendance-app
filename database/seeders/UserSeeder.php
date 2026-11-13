<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //一般ユーザーを2人登録
        User::firstOrCreate([ 'email' => 'user1@example.com'],
            ['name' => 'user1',
            'password' => Hash::make('password'),
            'admin_status' => '0',
        ]);

        User::firstOrCreate([ 'email' => 'user2@example.com'],
            ['name' => 'user2',
            'password' => Hash::make('password'),
            'admin_status' => '0',
        ]);
    
        //管理者ユーザーを1人登録
        User::firstOrCreate([ 'email' => 'user3@example.com'],
            ['name' => 'user3',
            'password' => Hash::make('password'),
            'admin_status' => '1',
        ]);
    }
}
